<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Controller PembimbingController menangani fungsionalitas Guru Pembimbing Sekolah:
 * monitoring siswa bimbingan di industri mitra, evaluasi nilai naskah laporan PKL,
 * kalkulasi bobot kelulusan gabungan (60% DUDI + 40% Sekolah), dan ekspor rekapitulasi.
 */
class PembimbingController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk Guru Pembimbing Sekolah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // --- LANGKAH 1: Ambil Seluruh Siswa yang Sudah Memiliki Penempatan DUDIKA ---
        $allSiswa = User::where('role', 'siswa')->whereNotNull('tempat_dudi')->get();

        // --- LANGKAH 2: Hitung Statistik Ringkasan Kartu Atas ---
        $totalSiswaBinaan = $allSiswa->count();

        // Ambil daftar DUDIKA unik yang bermitra dengan sekolah
        $dudis = User::where('role', 'siswa')
            ->whereNotNull('tempat_dudi')
            ->select('tempat_dudi', 'mentor_id')
            ->distinct()
            ->get();

        $totalInstansi = $dudis->count();

        // Hitung jumlah siswa yang logbook-nya sudah diverifikasi oleh mentor
        $siswaDinilaiCount = Logbook::where('status', 'Approved')
            ->distinct('user_id')
            ->count('user_id');

        // Pengelompokan siswa berdasarkan industri mitra untuk tab penempatan
        $dudiGroups = $allSiswa->groupBy('tempat_dudi');

        // --- LANGKAH 3: Filter Siswa Berdasarkan DUDI Terpilih (Tab Penilaian) ---
        $selectedDudi = $request->input('dudi', $dudis->first()->tempat_dudi ?? null);
        $siswasBimbingan = collect();
        if ($selectedDudi) {
            $siswasBimbingan = User::where('role', 'siswa')
                ->where('tempat_dudi', $selectedDudi)
                ->get();
        }

        // --- LANGKAH 4: Filter Siswa untuk Tab Monitoring ---
        $selectedMonitoringDudi = $request->input('monitoring_dudi', $dudis->first()->tempat_dudi ?? null);
        $siswasMonitoring = collect();
        if ($selectedMonitoringDudi) {
            $siswasMonitoring = User::where('role', 'siswa')
                ->where('tempat_dudi', $selectedMonitoringDudi)
                ->get();
        }

        return view('dashboards.pembimbing', compact(
            'user',
            'totalSiswaBinaan',
            'totalInstansi',
            'siswaDinilaiCount',
            'dudis',
            'dudiGroups',
            'selectedDudi',
            'siswasBimbingan',
            'selectedMonitoringDudi',
            'siswasMonitoring'
        ));
    }

    /**
     * Memperbarui Nilai Laporan Sekolah dan Menghitung Rekapitulasi Nilai Akhir Siswa.
     *
     * Logika Pembobotan Dual-Assessment:
     * - Nilai DUDIKA berbobot 60% (aspek teknis, disiplin, kerjasama, inisiatif).
     * - Nilai Laporan Sekolah berbobot 40% (kualitas isi naskah laporan PKL).
     * - Rumus: (Nilai DUDI * 0.60) + (Nilai Laporan * 0.40).
     * - Skala Predikat:
     *   A >= 85.00 (Sangat Baik / Lulus Memuaskan)
     *   B >= 75.00 (Baik / Lulus Standar)
     *   C >= 60.00 (Cukup / Perlu Pembinaan)
     *   D <  60.00 (Kurang)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $studentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNilaiLaporan(Request $request, int|string $studentId): RedirectResponse
    {
        // --- LANGKAH 1: Otorisasi & Validasi Siswa Sasaran ---
        $student = User::where('id', (int) $studentId)->where('role', 'siswa')->firstOrFail();

        $request->validate([
            'nilai_laporan' => 'required|numeric|between:0,100',
        ]);

        // --- LANGKAH 2: Ambil Nilai DUDIKA yang Telah Diberikan Mentor Industri ---
        $grade = Grade::where('student_id', $student->id)->first();
        $nilaiDudi = $grade ? (float) $grade->nilai_dudi : 0.0;
        $nilaiLaporan = (float) $request->nilai_laporan;

        // --- LANGKAH 3: Kalkulasi Nilai Akhir Berbobot 60:40 ---
        $nilaiAkhir = ($nilaiDudi * 0.60) + ($nilaiLaporan * 0.40);

        // --- LANGKAH 4: Konversi Angka ke Predikat Huruf Mutu ---
        $predikat = 'C';
        if ($nilaiAkhir >= 85) {
            $predikat = 'A';
        } elseif ($nilaiAkhir >= 75) {
            $predikat = 'B';
        } elseif ($nilaiAkhir >= 60) {
            $predikat = 'C';
        } else {
            $predikat = 'D';
        }

        // --- LANGKAH 5: Simpan atau Perbarui Catatan Nilai di Database ---
        Grade::updateOrInsert(
            ['student_id' => $student->id],
            [
                'nilai_laporan' => $nilaiLaporan,
                'nilai_akhir' => round($nilaiAkhir, 2),
                'predikat' => $predikat,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Nilai laporan sekolah dan rekapitulasi nilai akhir berhasil diperbarui!');
    }

    /**
     * Mengunduh seluruh riwayat logbook siswa dalam format dokumen Word/HTML terstruktur.
     *
     * @param  int|string  $studentId
     * @return \Illuminate\Http\Response
     */
    public function exportLogbook(int|string $studentId): Response
    {
        $siswa = User::where('id', (int) $studentId)->where('role', 'siswa')->firstOrFail();
        $logbooks = Logbook::where('user_id', $siswa->id)->orderBy('created_at', 'desc')->get();

        // Sanitasi XSS sebelum merender ke dokumen output
        $safeName = htmlspecialchars($siswa->name, ENT_QUOTES, 'UTF-8');
        $safeDudi = htmlspecialchars($siswa->tempat_dudi ?? '-', ENT_QUOTES, 'UTF-8');

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Logbook Harian PKL - '.$safeName.'</title>
            <style>
                body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.4; padding: 20px; }
                .header { text-align: center; border-bottom: 2px solid #0b1c3d; padding-bottom: 10px; margin-bottom: 20px; }
                .header h2, .header h3 { margin: 2px 0; color: #0b1c3d; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
                th { background-color: #f1f5f9; color: #0b1c3d; font-size: 11px; text-transform: uppercase; }
            </style>
        </head>
        <body>
            <div class="header">
                <h3>PEMERINTAH PROVINSI JAWA BARAT</h3>
                <h3>DINAS PENDIDIKAN - CABANG DINAS WILAYAH II</h3>
                <h2>SMK NEGERI 1 DEPOK</h2>
                <p style="font-size: 10px; margin: 2px 0;">Jl. Raya Tapos, Gg. Bhakti Suci No. 100, Cimpaeun, Tapos, Kota Depok, Jawa Barat 16459</p>
                <p style="font-size: 10px; margin: 2px 0;">Telp: (021) 8790-7233 | Email: smkn1depok@gmail.com | Website: www.smkn1depok.sch.id</p>
                <hr style="border: 1px solid #0b1c3d; margin: 10px 0;">
                <h3 style="margin-top: 10px;">LOGBOOK / JURNAL HARIAN PRAKTIK KERJA LAPANGAN</h3>
                <p>Nama Siswa: <b>'.$safeName.'</b> | Tempat DUDI: <b>'.$safeDudi.'</b></p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Aktivitas / Pekerjaan</th>
                        <th>Status</th>
                        <th>Catatan Mentor</th>
                    </tr>
                </thead>
                <tbody>';

        $no = 1;
        foreach ($logbooks as $lb) {
            $safeDesc = htmlspecialchars($lb->judul_kegiatan ?? $lb->deskripsi ?? 'Aktivitas harian PKL', ENT_QUOTES, 'UTF-8');
            $safeStatus = htmlspecialchars($lb->status ?? 'Pending', ENT_QUOTES, 'UTF-8');
            $safeNote = htmlspecialchars($lb->catatan_mentor ?? '-', ENT_QUOTES, 'UTF-8');

            $html .= '<tr>
                <td>'.$no++.'</td>
                <td>'.date('d-m-Y', strtotime($lb->tanggal ?? $lb->created_at)).'</td>
                <td>'.$safeDesc.'</td>
                <td><b>'.$safeStatus.'</b></td>
                <td>'.$safeNote.'</td>
            </tr>';
        }

        if ($logbooks->isEmpty()) {
            $html .= '<tr><td colspan="5" style="text-align: center; color: #777;">Belum ada catatan logbook.</td></tr>';
        }

        $html .= '</tbody></table></body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="Logbook_'.str_replace(' ', '_', $siswa->name).'.doc"',
        ]);
    }

    /**
     * Mengunduh rekapitulasi nilai keseluruhan siswa binaan format CSV dengan proteksi CSV Injection.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportExcel(): StreamedResponse
    {
        $siswas = User::where('role', 'siswa')->whereNotNull('tempat_dudi')->get();
        $filename = 'Rekap_Nilai_Keseluruhan_PKL_'.date('Y-m-d').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($siswas): void {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama Siswa', 'Tempat DUDI', 'Nilai DUDI (60%)', 'Nilai Laporan (40%)', 'Nilai Akhir', 'Predikat']);

            $no = 1;
            foreach ($siswas as $siswa) {
                $grade = Grade::where('student_id', $siswa->id)->first();

                // Seluruh sel dilewatkan ke fungsi sanitizeCsvField untuk netralisasi formula injection
                fputcsv($file, [
                    $no++,
                    $this->sanitizeCsvField($siswa->name),
                    $this->sanitizeCsvField($siswa->tempat_dudi ?? '-'),
                    $this->sanitizeCsvField($grade->nilai_dudi ?? 'Belum Dinilai'),
                    $this->sanitizeCsvField($grade->nilai_laporan ?? 'Belum Dinilai'),
                    $this->sanitizeCsvField($grade->nilai_akhir ?? '-'),
                    $this->sanitizeCsvField($grade->predikat ?? '-'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Netralisir potensi serangan CSV Formula Injection (DDE).
     * Jika diawali '=', '+', '-', '@', '\t', '\r', sistem menambahkan kutip tunggal di depannya.
     *
     * @param  mixed  $value
     * @return string
     */
    private function sanitizeCsvField(mixed $value): string
    {
        $str = (string) ($value ?? '');
        if (in_array(substr($str, 0, 1), ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'".$str;
        }

        return $str;
    }

    /**
     * Memperbarui informasi profil pribadi Guru Pembimbing Sekolah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->name = $request->input('name');
        $user->nip = $request->input('nip');
        $user->phone = $request->input('phone');
        $user->save();

        return back()->with('success', 'Profil Guru Pembimbing berhasil diperbarui!');
    }
}
