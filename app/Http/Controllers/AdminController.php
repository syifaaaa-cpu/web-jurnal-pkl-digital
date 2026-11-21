<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Controller AdminController menangani seluruh fungsi Administrator Pusat (Pokja Hubin):
 * verifikasi persetujuan akun baru (approval gate), plotting kelompok magang ke industri mitra,
 * manajemen kuota DUDIKA, ekspor laporan rekapitulasi, cetak sertifikat dinas, dan pengaturan sistem.
 */
class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama Administrator Pokja Hubin.
     * Mengagregasi data ringkasan kartu, deteksi siswa berisiko (luar radius GPS),
     * tabel pencarian pengguna dengan pagination, dan daftar permohonan akun pending.
     */
    public function index(Request $request): View
    {
        // --- LANGKAH 1: Agregasi Statistik Peran Pengguna ---
        $countAdmin = User::where('role', 'admin')->count();
        $countGuru = User::where('role', 'pembimbing')->count();
        $countSiswa = User::where('role', 'siswa')->count();
        $countMentor = User::where('role', 'mentor')->count();
        $totalAkun = User::count();

        // --- LANGKAH 2: Evaluasi Kapasitas Kuota Penempatan DUDIKA ---
        $totalSiswaTerplotting = User::where('role', 'siswa')->whereNotNull('tempat_dudi')->count();
        $totalSemuaSiswa = $countSiswa;

        $kuotaSetting = Setting::get('kuota_dudi', 150);
        $kapasitasMaksimal = (int) $kuotaSetting;

        // --- LANGKAH 3: Deteksi Dini Siswa "Perlu Perhatian" ---
        // Mencari siswa yang pernah absen "Diluar Radius DUDI" atau belum memiliki tempat magang
        $siswaBermasalahIds = Attendance::where('status', 'like', '%Luar Radius%')
            ->distinct()
            ->pluck('user_id');

        $siswaPerhatian = User::where('role', 'siswa')
            ->where(function ($q) use ($siswaBermasalahIds): void {
                $q->whereNull('tempat_dudi')
                    ->orWhereIn('id', $siswaBermasalahIds);
            })->get();
        $countSiswaPerhatian = $siswaPerhatian->count();

        // --- LANGKAH 4: Status Kelulusan PKL Berdasarkan Timeline Sekolah ---
        $tanggalSelesaiPkl = Setting::get('tanggal_selesai', session('pk_tanggal_selesai', '2026-12-09'));
        $isPeriodeSelesai = Carbon::now()->startOfDay()->gte(Carbon::parse($tanggalSelesaiPkl)->startOfDay());
        $siswaLulus = $isPeriodeSelesai ? $totalSiswaTerplotting : 0;

        // --- LANGKAH 5: Query Tabel Pengguna dengan Pencarian & Filter Peran ---
        $query = User::query();

        if ($request->filled('search')) {
            $search = (string) $request->search;
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && in_array($request->role, ['admin', 'pembimbing', 'siswa', 'mentor'], true)) {
            $query->where('role', $request->role);
        }

        // Ambil data dengan paginasi 5 item per halaman
        $users = $query->paginate(5)->withQueryString();

        // --- LANGKAH 6: Data Akun Baru yang Menunggu Persetujuan Admin (Pending) ---
        $pendingUsers = User::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $pendingUsersCount = $pendingUsers->count();

        // Data pendukung tab plotting
        $siswas = User::where('role', 'siswa')->where('status', 'approved')->get();
        $mentors = User::where('role', 'mentor')->where('status', 'approved')->get();
        $groups = User::where('role', 'siswa')
            ->whereNotNull('tempat_dudi')
            ->select('tempat_dudi', 'mentor_id')
            ->distinct()
            ->get();

        return view('dashboards.admin', compact(
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
            'totalSemuaSiswa',
            'pendingUsers',
            'pendingUsersCount'
        ));
    }

    /**
     * Menyimpan plotting penempatan kelompok siswa ke industri mitra, mentor, dan koordinat GPS.
     */
    public function storePlotting(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Validasi Masukan Plotting & Koordinat GPS Kantor DUDI ---
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'tempat_dudi' => 'required|string|max:255',
            'mentor_id' => 'required|exists:users,id',
            'dudi_lat' => 'nullable|numeric|between:-90,90',
            'dudi_lng' => 'nullable|numeric|between:-180,180',
        ]);

        $updateData = [
            'tempat_dudi' => $request->tempat_dudi,
            'mentor_id' => (int) $request->mentor_id,
        ];

        if ($request->filled('dudi_lat') && $request->filled('dudi_lng')) {
            $updateData['dudi_lat'] = (float) $request->dudi_lat;
            $updateData['dudi_lng'] = (float) $request->dudi_lng;
        }

        // --- LANGKAH 2: Perbarui Seluruh Siswa Terpilih Secara Masal ---
        User::whereIn('id', $request->student_ids)->update($updateData);

        return back()->with('success', 'Plotting kelompok siswa dan titik lokasi DUDI berhasil disimpan!');
    }

    // =========================================================================
    // MODUL MANAJEMEN AKUN & GERBANG APPROVAL
    // =========================================================================

    /**
     * Membuat akun baru secara manual oleh Admin (langsung berstatus approved).
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,pembimbing,siswa,mentor',
            'password' => 'required|string|min:8',
            'nis' => 'nullable|string|max:50|unique:users,nis',
            'nisn' => 'nullable|string|size:10|unique:users,nisn',
            'departemen' => 'nullable|in:PPLG,AKL,TKR,TBSM,PH,DKV',
            'tempat_dudi' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:25',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 'approved',
            'password' => bcrypt($request->password),
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'departemen' => $request->departemen,
            'tempat_dudi' => $request->tempat_dudi,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Akun pengguna baru berhasil ditambahkan!');
    }

    /**
     * Menyetujui permohonan akun baru (Pending -> Approved) sehingga pengguna dapat login.
     */
    public function approveUser(int|string $id): RedirectResponse
    {
        $user = User::findOrFail((int) $id);
        $user->update(['status' => 'approved']);

        return back()->with('success', "Akun {$user->name} ({$user->role}) berhasil disetujui dan diaktifkan!");
    }

    /**
     * Menolak permohonan pendaftaran akun baru (Pending -> Rejected).
     */
    public function rejectUser(int|string $id): RedirectResponse
    {
        $user = User::findOrFail((int) $id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', "Pendaftaran akun {$user->name} berhasil ditolak.");
    }

    /**
     * Memperbarui informasi akun pengguna oleh Administrator.
     */
    public function updateUser(Request $request, int|string $id): RedirectResponse
    {
        $userId = (int) $id;
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'role' => 'required|in:admin,pembimbing,siswa,mentor',
            'nis' => 'nullable|string|max:50|unique:users,nis,'.$userId,
            'nisn' => 'nullable|string|size:10|unique:users,nisn,'.$userId,
            'departemen' => 'nullable|in:PPLG,AKL,TKR,TBSM,PH,DKV',
            'tempat_dudi' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:25',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nis' => $request->nis ?? $user->nis,
            'nisn' => $request->nisn ?? $user->nisn,
            'departemen' => $request->departemen ?? $user->departemen,
            'tempat_dudi' => $request->tempat_dudi,
            'phone' => $request->phone ?? $user->phone,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'Data akun berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna dari basis data.
     */
    public function destroyUser(int|string $id): RedirectResponse
    {
        $userId = (int) $id;
        if ($userId === (int) Auth::id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri saat sedang masuk.']);
        }

        $user = User::findOrFail($userId);
        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus!');
    }

    // =========================================================================
    // MODUL EKSPOR LAPORAN & SERTIFIKAT RESMI DINAS
    // =========================================================================

    /**
     * Mengunduh rekapitulasi data presensi dan nilai PKL seluruh siswa format Excel.
     */
    public function exportLaporan(Request $request): Response
    {
        $siswas = User::where('role', 'siswa')->get();

        $html = '<!DOCTYPE html>
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
                <h3>DINAS PENDIDIKAN - CABANG DINAS WILAYAH II</h3>
                <h2>SMK NEGERI 1 DEPOK</h2>
                <p style="font-size: 10px; margin: 2px 0;">Jl. Raya Tapos, Gg. Bhakti Suci No. 100, Cimpaeun, Tapos, Kota Depok, Jawa Barat 16459</p>
                <p style="font-size: 10px; margin: 2px 0;">Telp: (021) 8790-7233 | Email: smkn1depok@gmail.com | Website: www.smkn1depok.sch.id</p>
                <hr style="border: 1px solid #0b1c3d; margin: 10px 0;">
                <h3 style="margin-top: 10px;">LAPORAN REKAPITULASI ABSENSI & PENILAIAN PKL</h3>
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
            $safeName = htmlspecialchars($siswa->name, ENT_QUOTES, 'UTF-8');
            $safeEmail = htmlspecialchars($siswa->email, ENT_QUOTES, 'UTF-8');
            $safeDudi = htmlspecialchars($siswa->tempat_dudi ?? 'Belum Diplotting', ENT_QUOTES, 'UTF-8');

            // Kalkulasi kehadiran riil siswa dari database
            $totalHadir = Attendance::where('user_id', $siswa->id)
                ->where(function ($q): void {
                    $q->where('status', 'like', '%Hadir%')
                        ->orWhere('status', 'like', '%Diluar%');
                })
                ->count();
            $targetHari = 30;
            $persenKehadiran = $targetHari > 0 ? min(round(($totalHadir / $targetHari) * 100), 100) : 0;
            $strKehadiran = "{$persenKehadiran}% ({$totalHadir} Hari)";

            // Ambil data nilai riil siswa dari tabel grades
            $grade = Grade::where('student_id', $siswa->id)->first();
            if ($grade && $grade->nilai_akhir !== null) {
                $strNilai = "{$grade->nilai_akhir} ({$grade->predikat})";
            } elseif ($grade && $grade->nilai_dudi !== null) {
                $strNilai = "{$grade->nilai_dudi} (Nilai DUDI)";
            } else {
                $strNilai = 'Belum Dinilai';
            }

            $safeStatus = $siswa->status === 'approved' ? 'Aktif' : ucfirst($siswa->status ?? 'Aktif');

            $html .= '<tr>
                <td>'.$no++.'</td>
                <td><b>'.$safeName.'</b></td>
                <td>'.$safeEmail.'</td>
                <td>'.$safeDudi.'</td>
                <td>'.$strKehadiran.'</td>
                <td>'.$strNilai.'</td>
                <td>'.$safeStatus.'</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>

            <div class="footer">
                <p>Depok, '.date('d F Y').'</p>
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

    /**
     * Ekspor sertifikat penghargaan PKL resmi berstandar Dinas Pendidikan.
     * Dilengkapi Otorisasi Ketat: Siswa hanya boleh unduh miliknya; Mentor hanya bimbingannya; Admin semua.
     */
    public function exportSertifikat(Request $request): Response
    {
        $currentUser = Auth::user();

        // --- LANGKAH 1: Otorisasi Kepemilikan Unduh Sertifikat (Anti-IDOR) ---
        if ($currentUser->role === 'siswa') {
            // Siswa hanya boleh mengunduh sertifikat miliknya sendiri
            $requestedId = $request->query('student_id');
            if ($requestedId && (int) $requestedId !== (int) $currentUser->id) {
                abort(403, 'Anda tidak diizinkan mengunduh sertifikat siswa lain.');
            }
            $siswas = User::where('id', $currentUser->id)->where('role', 'siswa')->get();
        } elseif (in_array($currentUser->role, ['mentor', 'mentor_dudi'], true)) {
            // Mentor hanya dapat mengunduh sertifikat siswa binaannya
            $studentId = $request->query('student_id');
            $query = User::where('role', 'siswa')->where('mentor_id', $currentUser->id);
            if ($studentId && $studentId !== 'all') {
                $query->where('id', (int) $studentId);
            }
            $siswas = $query->get();
            if ($studentId && $studentId !== 'all' && $siswas->isEmpty()) {
                abort(403, 'Siswa tersebut bukan siswa bimbingan Anda.');
            }
        } else {
            // Admin Pokja Hubin & Guru Pembimbing berhak mengunduh seluruhnya
            $studentId = $request->query('student_id');
            if ($studentId && $studentId !== 'all') {
                $siswas = User::where('id', (int) $studentId)->where('role', 'siswa')->get();
            } else {
                $siswas = User::where('role', 'siswa')->get();
            }
        }

        // --- LANGKAH 2: Render Template Sertifikat Berstandar Dokumen Resmi ---
        $html = '<!DOCTYPE html>
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
            $safeName = htmlspecialchars($siswa->name, ENT_QUOTES, 'UTF-8');
            $safeDudi = htmlspecialchars($siswa->tempat_dudi ?? 'DUDI Mitra SMKN 1 Depok', ENT_QUOTES, 'UTF-8');

            $html .= '<div class="certificate-container">
                <div class="header-instansi">Pemerintah Provinsi Jawa Barat &bull; Dinas Pendidikan</div>
                <div class="school-name">SMK NEGERI 1 DEPOK</div>

                <div class="certificate-title">Sertifikat Penghargaan</div>
                <div class="certificate-subtitle">Nomor: 421.5 / PKL-SMKN1DPK / '.date('Y').'</div>

                <div class="recipient-label">Sertifikat ini diberikan dengan bangga kepada:</div>
                <div class="recipient-name">'.$safeName.'</div>

                <div class="certificate-body">
                    Telah sukses menyelesaikan kegiatan <b>Praktik Kerja Lapangan (PKL)</b> di Industri Mitra
                    <b>'.$safeDudi.'</b>
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
                            <p>Depok, '.date('d F Y').'<br>Kepala SMK Negeri 1 Depok</p>
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

    // =========================================================================
    // MODUL PENGATURAN SISTEM & TIMELINE
    // =========================================================================

    /**
     * Memperbarui jadwal timeline pelaksanaan PKL, kuota industri, dan kontrol akses sistem.
     */
    public function updateTimeline(Request $request): RedirectResponse
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'gelombang' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status_lockdown' => 'required|in:buka,tutup',
            'kuota_dudi' => 'required|integer',
        ]);

        Setting::set('tahun_ajaran', $request->tahun_ajaran);
        Setting::set('gelombang', $request->gelombang);
        Setting::set('tanggal_mulai', $request->tanggal_mulai);
        Setting::set('tanggal_selesai', $request->tanggal_selesai);
        Setting::set('status_lockdown', $request->status_lockdown);
        Setting::set('kuota_dudi', (string) $request->kuota_dudi);

        session([
            'pk_tahun_ajaran' => $request->tahun_ajaran,
            'pk_gelombang' => $request->gelombang,
            'pk_tanggal_mulai' => $request->tanggal_mulai,
            'pk_tanggal_selesai' => $request->tanggal_selesai,
            'pk_status_lockdown' => $request->status_lockdown,
        ]);

        return back()->with('success', 'Jadwal pelaksanaan, kuota DUDI, dan kontrol akses berhasil diperbarui!');
    }

    /**
     * Memperbarui pengaturan identitas umum sekolah.
     */
    public function updateSettingUmum(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email_resmi' => 'required|email',
            'telepon' => 'required|string|max:20',
        ]);

        Setting::set('nama_sekolah', $request->nama_sekolah);
        Setting::set('alamat_sekolah', $request->alamat);
        Setting::set('email_resmi', $request->email_resmi);
        Setting::set('telepon_resmi', $request->telepon);

        // Sinkronisasi alias untuk profil sekolah
        Setting::set('school_name', $request->nama_sekolah);
        Setting::set('school_address', $request->alamat);
        Setting::set('school_email', $request->email_resmi);
        Setting::set('school_phone', $request->telepon);

        return back()->with('success', 'Pengaturan Identitas Sekolah berhasil diperbarui!');
    }

    /**
     * Memperbarui pengaturan profil kontak dan media komunikasi sekolah.
     */
    public function updateSettingSekolah(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
        ]);

        Setting::set('school_name', $request->nama_sekolah);
        Setting::set('school_address', $request->alamat);
        Setting::set('school_email', $request->email);
        Setting::set('school_phone', $request->telepon);

        // Sinkronisasi alias untuk pengaturan umum
        Setting::set('nama_sekolah', $request->nama_sekolah);
        Setting::set('alamat_sekolah', $request->alamat);
        Setting::set('email_resmi', $request->email);
        Setting::set('telepon_resmi', $request->telepon);

        if ($request->filled('whatsapp')) {
            Setting::set('school_whatsapp', $request->whatsapp);
        }
        if ($request->filled('website')) {
            Setting::set('school_website', $request->website);
        }

        return back()->with('success', 'Identitas Sekolah berhasil diperbarui dan disimpan ke database!');
    }

    /**
     * Memperbarui parameter kebijakan keamanan sistem.
     */
    public function updateSettingKeamanan(Request $request): RedirectResponse
    {
        $allowed = [
            'two_factor_auth',
            'session_timeout',
            'ip_restriction',
            'auto_logout',
            'password_expiry',
            'geofence_strict',
        ];

        foreach ($request->only($allowed) as $key => $value) {
            Setting::set($key, (string) $value);
        }

        return back()->with('success', 'Pengaturan keamanan berhasil diperbarui!');
    }

    /**
     * Memperbarui kanal pengiriman notifikasi otomatis sistem.
     */
    public function updateSettingNotifikasi(Request $request): RedirectResponse
    {
        $allowed = [
            'notify_attendance',
            'notify_logbook',
            'notify_approval',
            'notify_grade',
            'channel_email',
            'channel_whatsapp',
        ];

        foreach ($request->only($allowed) as $key => $value) {
            Setting::set($key, (string) $value);
        }

        return back()->with('success', 'Pengaturan notifikasi berhasil diperbarui!');
    }
}
