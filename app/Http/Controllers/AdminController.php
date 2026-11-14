<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Hitung total akun berdasarkan role untuk ringkasan kartu atas & manajemen akun
        $countAdmin   = User::where('role', 'admin')->count();
        $countGuru    = User::where('role', 'pembimbing')->count();
        $countSiswa   = User::where('role', 'siswa')->count();
        $countMentor  = User::where('role', 'mentor')->count();

        // 1. Total keseluruhan akun terdaftar
        $totalAkun = User::count();

        // 2. Kapasitas Kuota DUDI (Aman jika tabel settings dihapus)
        $totalSiswaTerplotting = User::where('role', 'siswa')->whereNotNull('tempat_dudi')->count();
        $totalSemuaSiswa       = $countSiswa;

        $kuotaSetting = \Illuminate\Support\Facades\Schema::hasTable('settings')
            ? DB::table('settings')->where('key', 'kuota_dudi')->value('value')
            : null;
        $kapasitasMaksimal     = $kuotaSetting ? (int)$kuotaSetting : 150;

        // 3. Siswa Perlu Perhatian (Mendeteksi siswa yang status absensinya "Luar Radius" atau belum di-plotting)
        $siswaBermasalahIds = DB::table('attendances')
            ->where('status', 'like', '%Luar Radius%')
            ->distinct()
            ->pluck('user_id');

        $siswaPerhatian = User::where('role', 'siswa')
            ->where(function ($q) use ($siswaBermasalahIds) {
                $q->whereNull('tempat_dudi')
                    ->orWhereIn('id', $siswaBermasalahIds);
            })->get();
        $countSiswaPerhatian = $siswaPerhatian->count();

        // 4. Kelulusan & Pengesahan (Aman jika tabel settings dihapus)
        $tanggalSelesaiPkl = \Illuminate\Support\Facades\Schema::hasTable('settings')
            ? (DB::table('settings')->where('key', 'tanggal_selesai')->value('value') ?? session('pk_tanggal_selesai', '2026-12-09'))
            : session('pk_tanggal_selesai', '2026-12-09');

        $isPeriodeSelesai = Carbon::now()->startOfDay()->gte(Carbon::parse($tanggalSelesaiPkl)->startOfDay());
        $siswaLulus = $isPeriodeSelesai ? $totalSiswaTerplotting : 0;

        // Query untuk tabel dengan fitur pencarian & filter role
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Ambil data dengan pagination
        $users = $query->paginate(5)->withQueryString();

        // Data pendukung lainnya untuk tab plotting
        $siswas  = User::where('role', 'siswa')->get();
        $mentors = User::where('role', 'mentor')->get();
        $groups  = User::where('role', 'siswa')
            ->whereNotNull('tempat_dudi')
            ->select('tempat_dudi', 'mentor_id')
            ->distinct()
            ->get();

        return view('dashboards.Admin', compact(
            'siswas',
            'mentors',
            'groups',
            'users',
            'countAdmin',
            'countGuru',
            'countSiswa',
            'countMentor',
            'totalAkun',
            'totalSiswaTerplotting',
            'kapasitasMaksimal',
            'siswaPerhatian',
            'countSiswaPerhatian',
            'siswaLulus',
            'totalSemuaSiswa'
        ));
    }
    public function storePlotting(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'tempat_dudi' => 'required|string',
            'mentor_id'   => 'required|exists:users,id',
        ]);

        User::whereIn('id', $request->student_ids)->update([
            'tempat_dudi' => $request->tempat_dudi,
            'mentor_id'   => $request->mentor_id,
        ]);

        return back()->with('success', 'Plotting kelompok siswa berhasil disimpan!');
    }

    // --- MANAJEMEN AKUN ---

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'role'        => 'required|in:admin,pembimbing,siswa,mentor',
            'password'    => 'required|min:6',
            'tempat_dudi' => 'nullable|string',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'password'    => bcrypt($request->password),
            'tempat_dudi' => $request->tempat_dudi,
        ]);

        return back()->with('success', 'Akun pengguna baru berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $id,
            'role'        => 'required|in:admin,pembimbing,siswa,mentor',
            'tempat_dudi' => 'nullable|string',
        ]);

        $user->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'tempat_dudi' => $request->tempat_dudi,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus!');
    }

    // --- EXPORT LAPORAN & SERTIFIKAT ---

    public function exportLaporan(Request $request)
    {
        $siswas = User::where('role', 'siswa')->get();

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Laporan Rekapitulasi & Penilaian PKL</title>
            <style>
                body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.4; }
                .header { text-align: center; border-bottom: 2px solid #0b1c3d; padding-bottom: 10px; margin-bottom: 20px; }
                .header h2, .header h3 { margin: 2px 0; color: #0b1c3d; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
                th { background-color: #f1f5f9; color: #0b1c3d; font-size: 11px; text-transform: uppercase; }
                .footer { margin-top: 40px; float: right; text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <h3>PEMERINTAH PROVINSI JAWA BARAT</h3>
                <h3>DINAS PENDIDIKAN - SMKN 1 DEPOK</h3>
                <h2>LAPORAN REKAPITULASI ABSENSI & PENILAIAN PKL</h2>
                <p>Tahun Ajaran: 2023/2024</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Tempat DUDI / Penempatan</th>
                        <th>Kehadiran (%)</th>
                        <th>Nilai Akhir DUDI</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';

        $no = 1;
        foreach ($siswas as $siswa) {
            $html .= '<tr>
                <td>' . $no++ . '</td>
                <td><b>' . $siswa->name . '</b></td>
                <td>' . $siswa->email . '</td>
                <td>' . ($siswa->tempat_dudi ?? 'Belum Diplotting') . '</td>
                <td>95%</td>
                <td>88 (Baik Sekali)</td>
                <td>Aktif</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>

            <div class="footer">
                <p>Depok, ' . date('d F Y') . '</p>
                <p><b>Ketua Pokja PKL / Admin Hubin</b></p>
                <br><br><br>
                <p><b>( _________________________ )</b></p>
            </div>
        </body>
        </html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="Rekapitulasi_Absensi_Dan_Nilai_PKL.xls"',
        ]);
    }

    public function exportSertifikat(Request $request)
    {
        $studentId = $request->query('student_id');

        if ($studentId && $studentId !== 'all') {
            $siswas = User::where('id', $studentId)->where('role', 'siswa')->get();
        } else {
            $siswas = User::where('role', 'siswa')->get();
        }

        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Sertifikat PKL Resmi</title>
            <style>
                @page { size: landscape; margin: 1cm; }
                body { font-family: "Times New Roman", Times, serif; color: #1e293b; background: #ffffff; margin: 0; padding: 0; }
                .certificate-container {
                    position: relative;
                    width: 100%;
                    max-width: 1050px;
                    margin: 0 auto;
                    padding: 50px 60px;
                    border: 12px solid #1e3a8a;
                    outline: 4px solid #d97706;
                    outline-offset: -18px;
                    background: #fdfbf7;
                    box-sizing: border-box;
                    text-align: center;
                }
                .header-instansi {
                    font-size: 14px;
                    font-weight: bold;
                    letter-spacing: 3px;
                    color: #475569;
                    text-transform: uppercase;
                    margin-bottom: 5px;
                }
                .school-name {
                    font-size: 20px;
                    font-weight: bold;
                    color: #1e3a8a;
                    margin-bottom: 25px;
                }
                .certificate-title {
                    font-size: 38px;
                    font-weight: bold;
                    color: #1e3a8a;
                    text-transform: uppercase;
                    letter-spacing: 4px;
                    margin: 10px 0;
                }
                .certificate-subtitle {
                    font-size: 14px;
                    font-style: italic;
                    color: #64748b;
                    margin-bottom: 25px;
                }
                .recipient-label {
                    font-size: 15px;
                    color: #334155;
                    margin-bottom: 10px;
                }
                .recipient-name {
                    font-size: 32px;
                    font-weight: bold;
                    color: #b45309;
                    font-family: "Georgia", serif;
                    margin: 10px 0 20px 0;
                    text-decoration: underline;
                    text-decoration-color: #d97706;
                }
                .certificate-body {
                    font-size: 15px;
                    line-height: 1.8;
                    color: #334155;
                    max-width: 800px;
                    margin: 0 auto 40px auto;
                }
                .footer-section {
                    width: 100%;
                    margin-top: 30px;
                }
                .signature-box {
                    width: 35%;
                    display: inline-block;
                    text-align: center;
                    vertical-align: top;
                    font-size: 14px;
                }
                .signature-space {
                    height: 70px;
                }
                .signer-name {
                    font-weight: bold;
                    color: #1e3a8a;
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>';

        foreach ($siswas as $siswa) {
            $html .= '
            <div class="certificate-container">
                <div class="header-instansi">Pemerintah Provinsi Jawa Barat &bull; Dinas Pendidikan</div>
                <div class="school-name">SMK NEGERI 1 DEPOK</div>

                <div class="certificate-title">Sertifikat Penghargaan</div>
                <div class="certificate-subtitle">Nomor: 421.5 / PKL-SMKN1DPK / ' . date('Y') . '</div>

                <div class="recipient-label">Sertifikat ini diberikan dengan bangga kepada:</div>
                <div class="recipient-name">' . $siswa->name . '</div>

                <div class="certificate-body">
                    Telah sukses menyelesaikan kegiatan <b>Praktik Kerja Lapangan (PKL)</b> di Industri Mitra
                    <b>' . ($siswa->tempat_dudi ?? 'DUDI Mitra SMKN 1 Depok') . '</b>
                    mulai dari periode yang telah ditentukan dengan predikat <b>SANGAT BAIK</b>,
                    serta menunjukkan dedikasi, kedisiplinan, dan kompetensi keahlian yang tinggi.
                </div>

                <table class="footer-section">
                    <tr>
                        <td class="signature-box" style="text-align: left;">
                            <p>Mengetahui,<br>Pembimbing / Pimpinan DUDI</p>
                            <div class="signature-space"></div>
                            <p class="signer-name">( _____________________ )</p>
                        </td>
                        <td style="width: 30%;"></td>
                        <td class="signature-box" style="text-align: right;">
                            <p>Depok, ' . date('d F Y') . '<br>Kepala SMK Negeri 1 Depok</p>
                            <div class="signature-space"></div>
                            <p class="signer-name">Drs. H. Administrator, M.Pd.</p>
                            <p style="font-size: 12px; color: #64748b; margin: 0;">NIP. 19700101 199503 1 001</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="page-break-after: always;"></div>';
        }

        $html .= '</body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="Sertifikat_Resmi_PKL.doc"',
        ]);
    }

    // --- --- PENGATURAN TIMELINE & SETTING --- ---

    public function updateTimeline(Request $request)
    {
        $request->validate([
            'tahun_ajaran'    => 'required|string',
            'gelombang'       => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status_lockdown' => 'required|in:buka,tutup',
            'kuota_dudi'      => 'required|integer',
        ]);

        // Simpan ke database settings agar permanen & real-time
        DB::table('settings')->updateOrInsert(['key' => 'tanggal_selesai'], ['value' => $request->tanggal_selesai]);
        DB::table('settings')->updateOrInsert(['key' => 'kuota_dudi'], ['value' => $request->kuota_dudi]);

        session([
            'pk_tahun_ajaran'    => $request->tahun_ajaran,
            'pk_gelombang'       => $request->gelombang,
            'pk_tanggal_mulai'   => $request->tanggal_mulai,
            'pk_tanggal_selesai' => $request->tanggal_selesai,
            'pk_status_lockdown' => $request->status_lockdown,
        ]);

        return back()->with('success', 'Jadwal pelaksanaan, kuota DUDI, dan kontrol akses berhasil diperbarui!');
    }

    // Update Pengaturan Umum (Database)
    public function updateSettingUmum(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'email_resmi'  => 'required|email',
            'telepon'      => 'required|string|max:20',
        ]);

        // Simpan ke tabel settings dengan format key-value
        DB::table('settings')->updateOrInsert(['key' => 'nama_sekolah'], ['value' => $request->nama_sekolah]);
        DB::table('settings')->updateOrInsert(['key' => 'alamat_sekolah'], ['value' => $request->alamat]);
        DB::table('settings')->updateOrInsert(['key' => 'email_resmi'], ['value' => $request->email_resmi]);
        DB::table('settings')->updateOrInsert(['key' => 'telepon_resmi'], ['value' => $request->telepon]);

        return back()->with('success', 'Pengaturan Identitas Sekolah berhasil diperbarui!');
    }

    // 2. Update Identitas Sekolah (Database)
    public function updateSettingSekolah(Request $request)
    {
        DB::table('settings')->updateOrInsert(['key' => 'school_name'], ['value' => $request->nama_sekolah]);
        DB::table('settings')->updateOrInsert(['key' => 'school_address'], ['value' => $request->alamat]);
        DB::table('settings')->updateOrInsert(['key' => 'school_email'], ['value' => $request->email]);
        DB::table('settings')->updateOrInsert(['key' => 'school_phone'], ['value' => $request->telepon]);

        return back()->with('success', 'Identitas Sekolah berhasil diperbarui dan disimpan ke database!');
    }

    

}
