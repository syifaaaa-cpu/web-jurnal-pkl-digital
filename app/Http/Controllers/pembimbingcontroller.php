<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PembimbingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data user yang sedang login (Nama pembimbing aktif)
        $user = Auth::user();

        // 2. Ambil seluruh data siswa yang sudah di-plotting ke tempat DUDI
        $allSiswa = User::where('role', 'siswa')->whereNotNull('tempat_dudi')->get();

        // 3. Hitung statistik kartu atas
        $totalSiswaBinaan = $allSiswa->count();

        // Ambil daftar DUDI unik yang dipegang
        $dudis = User::where('role', 'siswa')
                     ->whereNotNull('tempat_dudi')
                     ->select('tempat_dudi', 'mentor_id')
                     ->distinct()
                     ->get();

        $totalInstansi = $dudis->count();

        // Hitung jumlah *siswa* yang logbook-nya sudah dinilai / disetujui (Approved)
        $siswaDinilaiCount = DB::table('logbooks')
                             ->where('status', 'Approved')
                             ->distinct('user_id')
                             ->count('user_id');

        // 4. Data untuk Tab Penempatan & DUDI (Mengelompokkan siswa berdasarkan tempat_dudi)
        $dudiGroups = $allSiswa->groupBy('tempat_dudi');

        // 5. Data untuk Tab Rekap & Nilai Akhir
        $selectedDudi = $request->input('dudi', $dudis->first()->tempat_dudi ?? null);
        $siswasBimbingan = collect();
        if ($selectedDudi) {
            $siswasBimbingan = User::where('role', 'siswa')
                                   ->where('tempat_dudi', $selectedDudi)
                                   ->get();
        }

        // 6. Data untuk Tab 3: Monitoring Siswa (Filter berdasarkan DUDI yang dipilih di tab monitoring)
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

    public function updateNilaiLaporan(Request $request, $studentId)
    {
        $request->validate([
            'nilai_laporan' => 'required|numeric|min:0|max:100',
        ]);

        $grade = DB::table('grades')->where('student_id', $studentId)->first();
        $nilaiDudi = $grade ? $grade->nilai_dudi : 0;
        $nilaiLaporan = $request->nilai_laporan;

        $nilaiAkhir = ($nilaiDudi * 0.6) + ($nilaiLaporan * 0.4);

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

        DB::table('grades')->updateOrInsert(
            ['student_id' => $studentId],
            [
                'nilai_laporan' => $nilaiLaporan,
                'nilai_akhir'   => round($nilaiAkhir, 2),
                'predikat'      => $predikat,
                'updated_at'    => now(),
            ]
        );

        return back()->with('success', 'Nilai laporan sekolah dan rekapitulasi nilai akhir berhasil diperbarui!');
    }

    // Fungsi untuk mengunduh logbook siswa dalam format dokumen/PDF terstruktur
    public function exportLogbook($studentId)
    {
        $siswa = User::findOrFail($studentId);
        $logbooks = DB::table('logbooks')->where('user_id', $studentId)->orderBy('created_at', 'desc')->get();

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Logbook Harian PKL - ' . $siswa->name . '</title>
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
                <h3>DINAS PENDIDIKAN - SMKN 1 DEPOK</h3>
                <h2>LOGBOOK / JURNAL HARIAN PRAKTIK KERJA LAPANGAN</h2>
                <p>Nama Siswa: <b>' . $siswa->name . '</b> | Tempat DUDI: <b>' . ($siswa->tempat_dudi ?? '-') . '</b></p>
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
            $html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . date('d-m-Y', strtotime($lb->created_at)) . '</td>
                <td>' . ($lb->activity ?? $lb->deskripsi ?? 'Aktivitas harian PKL') . '</td>
                <td><b>' . ($lb->status ?? 'Pending') . '</b></td>
                <td>' . ($lb->catatan_mentor ?? '-') . '</td>
            </tr>';
        }

        if ($logbooks->isEmpty()) {
            $html .= '<tr><td colspan="5" style="text-align: center; color: #777;">Belum ada catatan logbook.</td></tr>';
        }

        $html .= '</tbody></table></body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="Logbook_' . str_replace(' ', '_', $siswa->name) . '.doc"',
        ]);
    }
    // Fungsi untuk mengunduh rekapitulasi nilai keseluruhan siswa
    public function exportExcel()
    {
        // Ambil semua data siswa beserta nilai dari tabel grades
        $siswas = User::where('role', 'siswa')->whereNotNull('tempat_dudi')->get();

        $filename = "Rekap_Nilai_Keseluruhan_PKL_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($siswas) {
            $file = fopen('php://output', 'w');

            // Header kolom CSV/Excel
            fputcsv($file, ['No', 'Nama Siswa', 'Tempat DUDI', 'Nilai DUDI (60%)', 'Nilai Laporan (40%)', 'Nilai Akhir', 'Predikat']);

            $no = 1;
            foreach ($siswas as $siswa) {
                $grade = DB::table('grades')->where('student_id', $siswa->id)->first();

                fputcsv($file, [
                    $no++,
                    $siswa->name,
                    $siswa->tempat_dudi ?? '-',
                    $grade->nilai_dudi ?? 'Belum Dinilai',
                    $grade->nilai_laporan ?? 'Belum Dinilai',
                    $grade->nilai_akhir ?? '-',
                    $grade->predikat ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    // Fungsi untuk memperbarui profil guru pembimbing
   public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'nip'   => 'nullable|string|max:50',
        'phone' => 'nullable|string|max:20',
    ]);

    $user->name  = $request->input('name');
    $user->nip   = $request->input('nip');
    $user->phone = $request->input('phone');
    $user->save();

    return back()->with('success', 'Profil Guru Pembimbing berhasil diperbarui!');
}
}
