<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Logbook;

class MentorController extends Controller
{
    public function index()
    {
        $mentorId = Auth::id();

        // 1. Ambil daftar siswa yang di-plotting ke mentor ini
        $siswas = User::where('role', 'siswa')
                    ->where('mentor_id', $mentorId)
                    ->get();

        // 2. Ambil ID siswa-siswa tersebut untuk memfilter logbook/jurnal
        $studentIds = $siswas->pluck('id');

        // 3. Ambil data logbook/jurnal dari siswa bimbingan ini saja
        $logbooks = Logbook::whereIn('user_id', $studentIds)
                           ->with('user')
                           ->orderBy('created_at', 'desc')
                           ->get();

        // 4. Hitung statistik untuk dashboard mentor
        $totalSiswa = $siswas->count();
        $perluValidasi = $logbooks->where('status', 'Pending')->count();

        return view('dashboards.mentor-dudi', compact('siswas', 'logbooks', 'totalSiswa', 'perluValidasi'));
    }

    // Fungsi untuk memvalidasi (Setujui / Revisi) jurnal siswa
    public function updateLogbookStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Revisi',
            'catatan_mentor' => 'nullable|string',
        ]);

        $logbook = Logbook::findOrFail($id);
        $logbook->update([
            'status' => $request->status,
            'catatan_mentor' => $request->catatan_mentor,
        ]);

        return back()->with('success', 'Status jurnal berhasil diperbarui!');
    }

    // Fungsi Baru untuk Menyimpan Penilaian Akhir PKL dari Mentor (60%)
    public function storeNilai(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:users,id',
            'nilai_teknis'   => 'required|numeric|min:0|max:100',
            'nilai_disiplin' => 'required|numeric|min:0|max:100',
            'nilai_kerjasama'=> 'required|numeric|min:0|max:100',
            'nilai_inisiatif'=> 'required|numeric|min:0|max:100',
            'catatan'        => 'nullable|string',
        ]);

        // Hitung rata-rata dari 4 aspek penilaian sebagai Nilai DUDI
        $nilaiDudi = (
            $request->nilai_teknis +
            $request->nilai_disiplin +
            $request->nilai_kerjasama +
            $request->nilai_inisiatif
        ) / 4;

        // Simpan atau perbarui nilai ke database (tabel grades)
        DB::table('grades')->updateOrInsert(
            ['student_id' => $request->student_id],
            [
                'mentor_id'      => Auth::id(),
                'nilai_teknis'   => $request->nilai_teknis,
                'nilai_disiplin' => $request->nilai_disiplin,
                'nilai_kerjasama'=> $request->nilai_kerjasama,
                'nilai_inisiatif'=> $request->nilai_inisiatif,
                'nilai_dudi'     => round($nilaiDudi, 2),
                'catatan_mentor' => $request->catatan,
                'updated_at'     => now(),
                'created_at'     => now(),
            ]
        );

        return back()->with('success', 'Nilai akhir PKL dari Mentor berhasil disimpan!');
    }
}
