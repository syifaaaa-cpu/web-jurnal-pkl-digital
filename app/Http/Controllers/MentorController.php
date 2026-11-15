<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller MentorController menangani seluruh fungsi untuk Mentor Industri (DUDIKA):
 * melihat daftar siswa binaan perusahaan, memverifikasi jurnal harian (Approval/Revisi),
 * dan memberikan evaluasi penilaian 4 pilar kompetensi industri (bobot 60%).
 */
class MentorController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk mentor industri (DUDIKA).
     */
    public function index(): View
    {
        $mentorId = Auth::id();

        // --- LANGKAH 1: Ambil Daftar Siswa yang Secara Resmi Dibimbing Mentor Ini ---
        $siswas = User::where('role', 'siswa')
            ->where('mentor_id', $mentorId)
            ->get();

        // Ambil kumpulan ID siswa untuk memfilter riwayat logbook
        $studentIds = $siswas->pluck('id');

        // --- LANGKAH 2: Ambil Data Jurnal Harian Hanya dari Siswa Binaan Sendiri ---
        $logbooks = Logbook::whereIn('user_id', $studentIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // --- LANGKAH 3: Hitung Metrik Statistik Ringkasan ---
        $totalSiswa = $siswas->count();
        $perluValidasi = $logbooks->where('status', 'Pending')->count();

        return view('dashboards.mentor-dudi', compact('siswas', 'logbooks', 'totalSiswa', 'perluValidasi'));
    }

    /**
     * Memvalidasi status jurnal harian siswa bimbingan (Setujui atau Minta Revisi).
     * Dilengkapi proteksi Anti-IDOR (Insecure Direct Object Reference).
     */
    public function updateLogbookStatus(Request $request, int|string $id): RedirectResponse
    {
        // --- LANGKAH 1: Validasi Masukan Status & Catatan Pembinaan ---
        $request->validate([
            'status' => 'required|in:Approved,Revisi',
            'catatan_mentor' => 'nullable|string',
        ]);

        $logbook = Logbook::with('user')->findOrFail((int) $id);

        // --- LANGKAH 2: Pertahanan Siber Anti-IDOR ---
        // Pastikan siswa pemilik logbook memang berada di bawah bimbingan mentor yang login
        if ($logbook->user?->mentor_id !== Auth::id()) {
            abort(403, 'Akses Ditolak: Anda hanya memiliki izin untuk memvalidasi logbook siswa bimbingan Anda.');
        }

        // --- LANGKAH 3: Simpan Hasil Review Validasi Mentor ---
        $logbook->update([
            'status' => $request->status,
            'catatan_mentor' => $request->catatan_mentor,
        ]);

        return back()->with('success', 'Status jurnal berhasil diperbarui!');
    }

    /**
     * Menyimpan Penilaian Akhir PKL dari Mentor Industri (Bobot 60%).
     *
     * Rumus Perhitungan 4 Pilar Kompetensi:
     * Nilai DUDI = (Teknis + Disiplin + Kerjasama + Inisiatif) / 4
     */
    public function storeNilai(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Validasi Rentang Nilai 0 - 100 untuk 4 Aspek Penilaian ---
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'nilai_teknis' => 'required|numeric|between:0,100',
            'nilai_disiplin' => 'required|numeric|between:0,100',
            'nilai_kerjasama' => 'required|numeric|between:0,100',
            'nilai_inisiatif' => 'required|numeric|between:0,100',
            'catatan' => 'nullable|string',
        ]);

        // --- LANGKAH 2: Verifikasi Kepemilikan Bimbingan (Anti-IDOR) ---
        $student = User::where('id', (int) $request->student_id)
            ->where('role', 'siswa')
            ->where('mentor_id', Auth::id())
            ->first();

        if (! $student) {
            abort(403, 'Akses Ditolak: Anda hanya dapat memberikan penilaian untuk siswa bimbingan Anda.');
        }

        // --- LANGKAH 3: Kalkulasi Nilai Rata-Rata 4 Pilar Kompetensi Industri ---
        $nilaiDudi = (
            (float) $request->nilai_teknis +
            (float) $request->nilai_disiplin +
            (float) $request->nilai_kerjasama +
            (float) $request->nilai_inisiatif
        ) / 4;

        // --- LANGKAH 4: Simpan atau Perbarui Nilai DUDI ke Tabel Grades ---
        Grade::updateOrInsert(
            ['student_id' => $student->id],
            [
                'mentor_id' => Auth::id(),
                'nilai_teknis' => (float) $request->nilai_teknis,
                'nilai_disiplin' => (float) $request->nilai_disiplin,
                'nilai_kerjasama' => (float) $request->nilai_kerjasama,
                'nilai_inisiatif' => (float) $request->nilai_inisiatif,
                'nilai_dudi' => round($nilaiDudi, 2),
                'catatan_mentor' => $request->catatan,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Nilai akhir PKL dari Mentor berhasil disimpan!');
    }
}
