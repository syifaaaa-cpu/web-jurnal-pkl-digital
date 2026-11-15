<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Pendaftaran Akun Baru');
        $response->assertSee('Nama Lengkap');
        $response->assertSee('Nomor Induk Siswa Nasional (NISN)');
        $response->assertSee('PPLG');
    }

    public function test_siswa_can_register_and_receives_pending_status(): void
    {
        $payload = [
            'role' => 'siswa',
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@smk.test',
            'nis' => '12345678',
            'nisn' => '0081234567',
            'departemen' => 'PPLG',
            'phone' => '081234567890',
            'password' => 'SiswaKuat123#',
            'password_confirmation' => 'SiswaKuat123#',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'budi.santoso@smk.test',
            'role' => 'siswa',
            'status' => 'pending',
            'nis' => '12345678',
            'nisn' => '0081234567',
            'departemen' => 'PPLG',
        ]);
    }

    public function test_registration_fails_if_password_does_not_meet_security_standard(): void
    {
        // Password lemah: tidak memuat simbol dan huruf besar
        $payload = [
            'role' => 'siswa',
            'name' => 'Budi Lemah',
            'email' => 'budi.lemah@smk.test',
            'nis' => '88888888',
            'nisn' => '0088888888',
            'departemen' => 'PPLG',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'budi.lemah@smk.test']);
    }

    public function test_registration_fails_if_departemen_not_in_official_list(): void
    {
        $payload = [
            'role' => 'siswa',
            'name' => 'Budi Luar Jurusan',
            'email' => 'budi.luar@smk.test',
            'nis' => '99999999',
            'nisn' => '0099999999',
            'departemen' => 'Teknik Mesin Kapal', // Bukan PPLG, AKL, TKR, TBSM, PH, DKV
            'password' => 'SiswaKuat123#',
            'password_confirmation' => 'SiswaKuat123#',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertSessionHasErrors(['departemen']);
        $this->assertDatabaseMissing('users', ['email' => 'budi.luar@smk.test']);
    }

    public function test_registration_fails_if_nisn_is_not_10_digits(): void
    {
        $payload = [
            'role' => 'siswa',
            'name' => 'Budi Salah NISN',
            'email' => 'budi.nisn@smk.test',
            'nis' => '77777777',
            'nisn' => '123', // Bukan 10 digit
            'departemen' => 'AKL',
            'password' => 'SiswaKuat123#',
            'password_confirmation' => 'SiswaKuat123#',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertSessionHasErrors(['nisn']);
        $this->assertDatabaseMissing('users', ['email' => 'budi.nisn@smk.test']);
    }

    public function test_pending_user_cannot_login_and_sees_approval_warning(): void
    {
        $user = User::create([
            'name' => 'Siti Pending',
            'email' => 'siti.pending@smk.test',
            'password' => Hash::make('SitiKuat123#'),
            'role' => 'siswa',
            'status' => 'pending',
            'departemen' => 'DKV',
        ]);

        $response = $this->post('/login', [
            'email' => 'siti.pending@smk.test',
            'password' => 'SitiKuat123#',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_approve_pending_user(): void
    {
        $admin = User::create([
            'name' => 'Admin Pusat',
            'email' => 'admin.hubin@smk.test',
            'password' => Hash::make('AdminKuat123#'),
            'role' => 'admin',
            'status' => 'approved',
        ]);

        $pendingStudent = User::create([
            'name' => 'Calon Siswa',
            'email' => 'calon.siswa@smk.test',
            'password' => Hash::make('CalonKuat123#'),
            'role' => 'siswa',
            'status' => 'pending',
            'departemen' => 'TBSM',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.approve', $pendingStudent->id));

        $response->assertSessionHas('success');
        $this->assertEquals('approved', $pendingStudent->fresh()->status);
    }

    public function test_unauthorized_user_cannot_access_admin_dashboard(): void
    {
        $siswa = User::create([
            'name' => 'Siswa PKL',
            'email' => 'siswa.pkl@smk.test',
            'password' => Hash::make('SiswaKuat123#'),
            'role' => 'siswa',
            'status' => 'approved',
            'departemen' => 'PH',
        ]);

        // Siswa mencoba membuka dashboard admin -> harus di-abort 403
        $response = $this->actingAs($siswa)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }
}
