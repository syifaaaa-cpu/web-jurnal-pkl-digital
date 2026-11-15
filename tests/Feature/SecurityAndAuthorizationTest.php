<?php

namespace Tests\Feature;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'User Test',
            'email' => 'user.'.uniqid().'@smk.test',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'status' => 'approved',
        ], $attributes));
    }

    public function test_mentor_cannot_update_logbook_of_unassigned_student(): void
    {
        $mentor1 = $this->createUser(['role' => 'mentor']);
        $mentor2 = $this->createUser(['role' => 'mentor']);

        $studentOfMentor2 = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentor2->id,
        ]);

        $logbook = Logbook::create([
            'user_id' => $studentOfMentor2->id,
            'tanggal' => now()->toDateString(),
            'judul_kegiatan' => 'Mengerjakan modul backend',
            'deskripsi' => 'Pengembangan API dan autentikasi',
            'status' => 'Pending',
        ]);

        // Mentor 1 mencoba menyetujui logbook murid mentor 2 (IDOR Attack)
        $response = $this->actingAs($mentor1)->post(route('mentor.logbook.update', $logbook->id), [
            'status' => 'Approved',
            'catatan_mentor' => 'Bagus',
        ]);

        $response->assertStatus(403);
        $this->assertEquals('Pending', $logbook->fresh()->status);
    }

    public function test_mentor_can_update_logbook_of_assigned_student(): void
    {
        $mentor = $this->createUser(['role' => 'mentor']);
        $student = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentor->id,
        ]);

        $logbook = Logbook::create([
            'user_id' => $student->id,
            'tanggal' => now()->toDateString(),
            'judul_kegiatan' => 'Membuat database schema',
            'deskripsi' => 'Membuat migrasi dan relasi tabel',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($mentor)->post(route('mentor.logbook.update', $logbook->id), [
            'status' => 'Approved',
            'catatan_mentor' => 'Pekerjaan rapi',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Approved', $logbook->fresh()->status);
        $this->assertEquals('Pekerjaan rapi', $logbook->fresh()->catatan_mentor);
    }

    public function test_mentor_cannot_grade_unassigned_student(): void
    {
        $mentor1 = $this->createUser(['role' => 'mentor']);
        $mentor2 = $this->createUser(['role' => 'mentor']);

        $studentOfMentor2 = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentor2->id,
        ]);

        // Mentor 1 mencoba memasukkan nilai untuk siswa milik mentor 2
        $response = $this->actingAs($mentor1)->post(route('mentor.store.nilai'), [
            'student_id' => $studentOfMentor2->id,
            'nilai_teknis' => 90,
            'nilai_disiplin' => 85,
            'nilai_kerjasama' => 95,
            'nilai_inisiatif' => 88,
        ]);

        $response->assertStatus(403);
    }

    public function test_attendance_hadir_strictly_requires_gps_coordinates(): void
    {
        $student = $this->createUser(['role' => 'siswa']);

        // Mencoba absen Hadir tanpa mengirim koordinat lat & lng (GPS Bypass attempt)
        $response = $this->actingAs($student)->post(route('attendance.store'), [
            'status' => 'Hadir',
            // lat & lng sengaja dikosongkan
        ]);

        $response->assertSessionHasErrors(['lat', 'lng']);
        $this->assertDatabaseMissing('attendances', [
            'user_id' => $student->id,
        ]);
    }

    public function test_attendance_hadir_with_valid_coordinates_succeeds(): void
    {
        $student = $this->createUser([
            'role' => 'siswa',
            'dudi_lat' => -6.402484,
            'dudi_lng' => 106.794241,
        ]);

        $response = $this->actingAs($student)->post(route('attendance.store'), [
            'status' => 'Hadir',
            'lat' => -6.402484,
            'lng' => 106.794241,
            'keterangan' => 'Tepat waktu',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'user_id' => $student->id,
            'status' => 'Hadir',
        ]);
    }

    public function test_student_cannot_manipulate_dudi_coordinates_via_profile_update(): void
    {
        $student = $this->createUser([
            'role' => 'siswa',
            'tempat_dudi' => 'PT Asli Industri',
            'dudi_lat' => -6.400000,
            'dudi_lng' => 106.800000,
            'phone' => '08123456789',
        ]);

        // Siswa mencoba mengubah dudi_lat dan dudi_lng agar geofence bisa dipalsukan (via PUT)
        $response = $this->actingAs($student)->put(route('siswa.profile.update'), [
            'phone' => '08999999999',
            'dudi_lat' => -10.000000,
            'dudi_lng' => 120.000000,
            'tempat_dudi' => 'PT Palsu',
        ]);

        $response->assertRedirect();
        $freshStudent = $student->fresh();

        // Phone berhasil diperbarui
        $this->assertEquals('08999999999', $freshStudent->phone);
        // Koordinat dan nama DUDI TIDAK boleh berubah
        $this->assertEquals(-6.400000, (float) $freshStudent->dudi_lat);
        $this->assertEquals(106.800000, (float) $freshStudent->dudi_lng);
        $this->assertEquals('PT Asli Industri', $freshStudent->tempat_dudi);
    }

    public function test_student_cannot_download_other_student_certificate(): void
    {
        $student1 = $this->createUser(['role' => 'siswa']);
        $student2 = $this->createUser(['role' => 'siswa']);

        // Siswa 1 mencoba mengunduh sertifikat milik siswa 2 (IDOR download)
        $response = $this->actingAs($student1)->get(route('export.sertifikat', ['student_id' => $student2->id]));

        $response->assertStatus(403);
    }

    public function test_student_can_download_own_certificate(): void
    {
        $student = $this->createUser([
            'role' => 'siswa',
            'name' => 'Siswa Mandiri',
            'tempat_dudi' => 'PT Teknologi Digital',
        ]);

        $response = $this->actingAs($student)->get(route('export.sertifikat', ['student_id' => $student->id]));

        $response->assertStatus(200);
        $this->assertTrue(str_contains(strtolower($response->headers->get('content-disposition', '')), 'attachment; filename="sertifikat'));
    }

    public function test_login_rate_limiting_triggers_too_many_requests(): void
    {
        // 5 requests allowed per minute on /login
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'wrong@smk.test',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt should be throttled
        $response = $this->post('/login', [
            'email' => 'wrong@smk.test',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429);
    }
}
