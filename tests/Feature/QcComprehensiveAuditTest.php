<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Logbook;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class QcComprehensiveAuditTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Pengguna Audit',
            'email' => 'audit_'.uniqid().'@smk.test',
            'password' => Hash::make('PasswordAman123#'),
            'role' => 'siswa',
            'status' => 'approved',
            'phone' => '081234567890',
        ], $attributes));
    }

    /**
     * BUG-01: Mentor score submission automatically recalculates final grade and predicate
     * when school report score already exists.
     */
    public function test_mentor_score_submission_recalculates_final_grade_when_school_report_exists(): void
    {
        $mentor = $this->createUser(['role' => 'mentor']);
        $student = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentor->id,
            'tempat_dudi' => 'PT Google Indonesia',
        ]);

        // Simulasikan guru pembimbing telah mengisi nilai laporan sekolah (nilai = 80)
        Grade::create([
            'student_id' => $student->id,
            'nilai_laporan' => 80.0,
            'catatan_pembimbing' => 'Laporan bab 1 sampai 4 rapi.',
        ]);

        // Mentor mengirimkan 4 pilar nilai industri: rata-rata = 90
        $response = $this->actingAs($mentor)->post(route('mentor.store.nilai'), [
            'student_id' => $student->id,
            'nilai_teknis' => 90,
            'nilai_disiplin' => 90,
            'nilai_kerjasama' => 90,
            'nilai_inisiatif' => 90,
            'catatan' => 'Kinerja sangat profesional di kantor.',
        ]);

        $response->assertRedirect();

        // Verifikasi database: nilai DUDI = 90 (bobot 60%) + nilai laporan = 80 (bobot 40%)
        // Nilai Akhir = (90 * 0.6) + (80 * 0.4) = 54 + 32 = 86 -> Predikat A (>= 85)
        $grade = Grade::where('student_id', $student->id)->first();
        $this->assertNotNull($grade);
        $this->assertEquals(90.0, (float) $grade->nilai_dudi);
        $this->assertEquals(80.0, (float) $grade->nilai_laporan);
        $this->assertEquals(86.0, (float) $grade->nilai_akhir);
        $this->assertEquals('A', $grade->predikat);
    }

    /**
     * BUG-02: Admin export laporan contains real attendance and grades from database.
     */
    public function test_admin_export_laporan_contains_real_attendance_and_grades(): void
    {
        $admin = $this->createUser(['role' => 'admin']);
        $student = $this->createUser([
            'name' => 'Budi Santoso',
            'role' => 'siswa',
            'tempat_dudi' => 'PT Astra Honda Motor',
        ]);

        // 3 kali hadir
        for ($i = 0; $i < 3; $i++) {
            Attendance::create([
                'user_id' => $student->id,
                'tanggal' => Carbon::now()->subDays($i)->toDateString(),
                'status' => 'Hadir',
                'lokasi' => 'PT Astra Honda Motor',
            ]);
        }

        // Nilai akhir 88.5 Predikat A
        Grade::create([
            'student_id' => $student->id,
            'nilai_dudi' => 90,
            'nilai_laporan' => 86,
            'nilai_akhir' => 88.4,
            'predikat' => 'A',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.export.laporan'));
        $response->assertStatus(200);

        // Harus berisi kehadiran riil 3 Hari dan Nilai Akhir 88.4 (A), bukan fake 95% atau 88 (Baik Sekali)
        $content = $response->getContent();
        $this->assertStringContainsString('3 Hari', $content);
        $this->assertStringContainsString('88.4 (A)', $content);
        $this->assertStringNotContainsString('88 (Baik Sekali)', $content);
    }

    /**
     * BUG-03: Student dashboard displays grade results and certificate download link.
     */
    public function test_student_dashboard_displays_grade_and_certificate_download_link(): void
    {
        $student = $this->createUser([
            'name' => 'Dina Amalia',
            'role' => 'siswa',
            'tempat_dudi' => 'PT Telkom Indonesia',
        ]);

        Grade::create([
            'student_id' => $student->id,
            'nilai_dudi' => 92.0,
            'nilai_laporan' => 88.0,
            'nilai_akhir' => 90.4,
            'predikat' => 'A',
            'catatan_mentor' => 'Siswa teladan dan berbakat.',
        ]);

        $response = $this->actingAs($student)->get(route('dashboard.siswa'));
        $response->assertStatus(200);
        $response->assertSee('Rekap Penilaian Akhir');
        $response->assertSee('90.4');
        $response->assertSee('Sangat Baik');
        $response->assertSee(route('export.sertifikat'));
    }

    /**
     * BUG-04: Student can update their phone number via profile update.
     */
    public function test_student_can_update_phone_number_via_profile_update(): void
    {
        $student = $this->createUser([
            'role' => 'siswa',
            'phone' => '08111111111',
        ]);

        $response = $this->actingAs($student)->put(route('siswa.profile.update'), [
            'phone' => '08999888777',
        ]);

        $response->assertRedirect();
        $this->assertEquals('08999888777', $student->fresh()->phone);
    }

    /**
     * BUG-05 & BUG-06: Admin timeline and school settings persist to database Setting model.
     */
    public function test_admin_timeline_and_settings_persist_to_database(): void
    {
        $admin = $this->createUser(['role' => 'admin']);

        // Update timeline
        $this->actingAs($admin)->post(route('admin.timeline.update'), [
            'tahun_ajaran' => '2026/2027',
            'gelombang' => 'Gelombang 1',
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai' => '2026-10-31',
            'status_lockdown' => 'buka',
            'kuota_dudi' => 150,
        ]);

        $this->assertEquals('2026/2027', Setting::get('tahun_ajaran'));
        $this->assertEquals('Gelombang 1', Setting::get('gelombang'));
        $this->assertEquals('2026-07-01', Setting::get('tanggal_mulai'));
        $this->assertEquals('2026-10-31', Setting::get('tanggal_selesai'));
        $this->assertEquals('buka', Setting::get('status_lockdown'));

        // Update umum settings
        $this->actingAs($admin)->post(route('admin.settings.umum'), [
            'nama_sekolah' => 'SMK Negeri 1 Depok Maju',
            'alamat' => 'Jl. Bhakti Suci No. 100',
            'email_resmi' => 'info@smkn1depok.sch.id',
            'telepon' => '021-87900000',
        ]);

        $this->assertEquals('SMK Negeri 1 Depok Maju', Setting::get('nama_sekolah'));
        $this->assertEquals('SMK Negeri 1 Depok Maju', Setting::get('school_name'));
    }

    /**
     * BUG-08: Mentor dashboard displays real attendance metrics instead of total students.
     */
    public function test_mentor_dashboard_displays_real_attendance_metrics(): void
    {
        $mentor = $this->createUser(['role' => 'mentor']);
        $student1 = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentor->id,
        ]);
        $student2 = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentor->id,
        ]);

        // Student 1 hadir hari ini, student 2 belum hadir
        Attendance::create([
            'user_id' => $student1->id,
            'tanggal' => Carbon::today()->toDateString(),
            'jam_masuk' => '07:55:00',
            'status' => 'Hadir',
            'lokasi' => 'DUDI Mitra',
        ]);

        $response = $this->actingAs($mentor)->get(route('dashboard.mentor'));
        $response->assertStatus(200);
        $response->assertViewHas('hadirHariIni', 1);
        $response->assertViewHas('totalSiswa', 2);
    }

    /**
     * BUG-10: Pembimbing profile form does not prefill fake hardcoded defaults.
     */
    public function test_pembimbing_profile_does_not_contain_hardcoded_fake_defaults(): void
    {
        $pembimbing = $this->createUser([
            'role' => 'pembimbing',
            'nip' => null,
            'phone' => null,
        ]);

        $response = $this->actingAs($pembimbing)->get(route('dashboard.pembimbing'));
        $response->assertStatus(200);

        // Jangan ada fake NIP 196805121994032001 dalam value
        $response->assertDontSee('value="196805121994032001"', false);
        $response->assertDontSee('value="0812-9876-5432"', false);
    }

    /**
     * BUG-11: Admin cannot delete their own account.
     */
    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = $this->createUser(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));
        $response->assertSessionHasErrors('error');

        // Akun tetap ada di database
        $this->assertNotNull(User::find($admin->id));
    }

    /**
     * BUG-12: Student can revise and resubmit logbook that has 'Revisi' status.
     */
    public function test_student_can_revise_and_resubmit_logbook(): void
    {
        $student = $this->createUser(['role' => 'siswa']);

        $logbook = Logbook::create([
            'user_id' => $student->id,
            'tanggal' => '2026-08-10',
            'jam_kerja' => '08:00 - 16:00',
            'judul_kegiatan' => 'Membuat Dokumentasi',
            'deskripsi' => 'Belum lengkap.',
            'status' => 'Revisi',
            'catatan_mentor' => 'Tolong jelaskan diagram arsitekturnya.',
        ]);

        $response = $this->actingAs($student)->put(route('siswa.logbook.update', $logbook->id), [
            'tanggal' => '2026-08-10',
            'jam_kerja' => '08:00 - 17:00',
            'judul_kegiatan' => 'Membuat Dokumentasi & Diagram Arsitektur',
            'deskripsi' => 'Menambahkan diagram ERD dan Sequence Diagram sesuai arahan.',
        ]);

        $response->assertRedirect('/dashboard/siswa');

        $freshLogbook = $logbook->fresh();
        $this->assertEquals('Pending', $freshLogbook->status);
        $this->assertEquals('Membuat Dokumentasi & Diagram Arsitektur', $freshLogbook->judul_kegiatan);
        $this->assertEquals('Menambahkan diagram ERD dan Sequence Diagram sesuai arahan.', $freshLogbook->deskripsi);
    }
}
