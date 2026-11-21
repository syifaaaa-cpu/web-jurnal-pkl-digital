<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Logbook;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class QcBugFixesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper membuat user dengan password default dan status approved.
     */
    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Pengguna Uji',
            'email' => 'user_'.uniqid().'@smk.test',
            'password' => Hash::make('PasswordKuat123#'),
            'role' => 'siswa',
            'status' => 'approved',
            'phone' => '081234567890',
        ], $attributes));
    }

    /**
     * QC No. 5: Ringkasan logbook hari ini otomatis muncul di kartu "Aktivitas Terbaru Hari Ini".
     */
    public function test_qc_5_today_logbook_appears_in_aktivitas_terbaru_card(): void
    {
        $student = $this->createUser([
            'role' => 'siswa',
            'tempat_dudi' => 'PT Mitra Industri',
        ]);

        $today = Carbon::today()->toDateString();

        // 1. Awalnya belum ada logbook hari ini -> Menampilkan teks kosong
        $responseBefore = $this->actingAs($student)->get(route('dashboard.siswa'));
        $responseBefore->assertStatus(200);
        $responseBefore->assertSee('Belum ada aktivitas yang dicatat hari ini');
        $responseBefore->assertViewHas('latestLogbook', null);

        // 2. Siswa mengisi logbook hari ini
        $logbook = Logbook::create([
            'user_id' => $student->id,
            'tanggal' => $today,
            'jam_kerja' => '08:00 - 16:00 WIB',
            'judul_kegiatan' => 'Implementasi API Backend Laravel',
            'deskripsi' => 'Menyelesaikan modul autentikasi dan sinkronisasi geofence.',
            'status' => 'Pending',
        ]);

        // 3. Kembali ke dashboard siswa -> Ringkasan otomatis muncul di kartu
        $responseAfter = $this->actingAs($student)->get(route('dashboard.siswa'));
        $responseAfter->assertStatus(200);
        $responseAfter->assertViewHas('latestLogbook');
        $responseAfter->assertSee('Implementasi API Backend Laravel');
        $responseAfter->assertSee('Menyelesaikan modul autentikasi dan sinkronisasi geofence.');
        $responseAfter->assertDontSee('Belum ada aktivitas yang dicatat hari ini');
    }

    /**
     * QC No. 20: Kolom rekap absensi monitoring pembimbing menampilkan data akurat untuk Hadir (dalam radius).
     */
    public function test_qc_20_monitoring_table_displays_accurate_attendance_hadir(): void
    {
        $pembimbing = $this->createUser(['role' => 'pembimbing']);
        $student = $this->createUser([
            'role' => 'siswa',
            'name' => 'Ahmad Rizki',
            'tempat_dudi' => 'PT Teknologi Masa Depan',
        ]);

        // Catat presensi Hadir
        Attendance::create([
            'user_id' => $student->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => '07:45:00',
            'status' => 'Hadir',
            'lokasi' => 'PT Teknologi Masa Depan',
        ]);

        $response = $this->actingAs($pembimbing)
            ->get(route('dashboard.pembimbing', ['monitoring_dudi' => 'PT Teknologi Masa Depan']));

        $response->assertStatus(200);
        $response->assertSee('Ahmad Rizki');
        $response->assertSee('1 Hadir');
        $response->assertSee('0 Izin');
        $response->assertSee('0 Sakit');
    }

    /**
     * QC No. 20: Kolom rekap absensi tersinkronisasi dan menghitung Hadir meskipun status 'Diluar Radius DUDI'.
     */
    public function test_qc_20_monitoring_table_syncs_attendance_outside_radius(): void
    {
        $pembimbing = $this->createUser(['role' => 'pembimbing']);
        $student = $this->createUser([
            'role' => 'siswa',
            'name' => 'Bintang Pratama',
            'tempat_dudi' => 'PT Rekayasa Digital',
        ]);

        // Presensi tercatat 'Diluar Radius DUDI'
        Attendance::create([
            'user_id' => $student->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => '08:05:00',
            'status' => 'Diluar Radius DUDI',
            'alasan' => 'Peringatan: Jarak terlalu jauh',
            'lokasi' => 'PT Rekayasa Digital',
        ]);

        $response = $this->actingAs($pembimbing)
            ->get(route('dashboard.pembimbing', ['monitoring_dudi' => 'PT Rekayasa Digital']));

        $response->assertStatus(200);
        $response->assertSee('Bintang Pratama');
        // Harus terhitung sebagai 1 Hadir (bukan 0 Hadir!)
        $response->assertSee('1 Hadir');
        $response->assertSee('1 Luar Radius');
        $response->assertDontSee('0 Hadir');
    }

    /**
     * QC No. 20: Kolom rekap absensi menampilkan jumlah Izin dan Sakit secara akurat.
     */
    public function test_qc_20_monitoring_table_displays_accurate_izin_and_sakit(): void
    {
        $pembimbing = $this->createUser(['role' => 'pembimbing']);
        $student = $this->createUser([
            'role' => 'siswa',
            'name' => 'Citra Lestari',
            'tempat_dudi' => 'PT Solusi Komputasi',
        ]);

        // 1 Hadir, 1 Izin, 2 Sakit
        Attendance::create([
            'user_id' => $student->id,
            'tanggal' => Carbon::today()->subDays(3)->toDateString(),
            'jam_masuk' => '07:50:00',
            'status' => 'Hadir',
            'lokasi' => 'PT Solusi Komputasi',
        ]);

        Attendance::create([
            'user_id' => $student->id,
            'tanggal' => Carbon::today()->subDays(2)->toDateString(),
            'jam_masuk' => '08:00:00',
            'status' => 'Izin',
            'alasan' => 'Urusan keluarga',
            'lokasi' => 'PT Solusi Komputasi',
        ]);

        Attendance::create([
            'user_id' => $student->id,
            'tanggal' => Carbon::today()->subDays(1)->toDateString(),
            'jam_masuk' => '08:00:00',
            'status' => 'Sakit',
            'alasan' => 'Demam flu',
            'lokasi' => 'PT Solusi Komputasi',
        ]);

        Attendance::create([
            'user_id' => $student->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => '08:00:00',
            'status' => 'Sakit',
            'alasan' => 'Istirahat dokter',
            'lokasi' => 'PT Solusi Komputasi',
        ]);

        $response = $this->actingAs($pembimbing)
            ->get(route('dashboard.pembimbing', ['monitoring_dudi' => 'PT Solusi Komputasi']));

        $response->assertStatus(200);
        $response->assertSee('Citra Lestari');
        $response->assertSee('1 Hadir');
        $response->assertSee('1 Izin');
        $response->assertSee('2 Sakit');
    }
}
