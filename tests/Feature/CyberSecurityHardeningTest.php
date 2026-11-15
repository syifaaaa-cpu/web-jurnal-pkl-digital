<?php

namespace Tests\Feature;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CyberSecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. Uji kehadiran HTTP Security Headers (Anti-MITM, Anti-Clickjacking, Anti-XSS)
     */
    public function test_security_headers_are_present_on_all_responses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        // Anti-Clickjacking
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');

        // Anti-MIME Sniffing
        $response->assertHeader('X-Content-Type-Options', 'nosniff');

        // Referrer Privacy
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Anti-MITM (HSTS)
        $response->assertHeader('Strict-Transport-Security');

        // Content Security Policy
        $response->assertHeader('Content-Security-Policy');
        $this->assertStringContainsString("frame-ancestors 'self'", (string) $response->headers->get('Content-Security-Policy'));

        // Permissions Policy
        $response->assertHeader('Permissions-Policy');
    }

    /**
     * 2. Uji perlindungan Anti-Bot Honeypot Trap pada Form Login
     */
    public function test_honeypot_field_traps_and_rejects_bots_on_login(): void
    {
        $user = User::factory()->create([
            'email' => 'korban.bot@test.com',
            'password' => Hash::make('SiswaKuat123#'),
            'status' => 'approved',
            'role' => 'siswa',
        ]);

        // Bot otomatis mengisi seluruh field termasuk honeypot
        $payload = [
            'email' => 'korban.bot@test.com',
            'password' => 'SiswaKuat123#',
            '_honey_guard' => 'http://spam-botnet.ru/attack',
        ];

        $response = $this->post('/login', $payload);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * 3. Uji perlindungan Anti-Bot Honeypot Trap pada Form Registrasi
     */
    public function test_honeypot_field_traps_and_rejects_bots_on_register(): void
    {
        $payload = [
            'role' => 'siswa',
            'name' => 'Spam Bot Automator',
            'email' => 'bot@spammer.test',
            'nis' => '99998888',
            'nisn' => '0099887766',
            'departemen' => 'PPLG',
            'password' => 'SiswaKuat123#',
            'password_confirmation' => 'SiswaKuat123#',
            '_honey_guard' => 'https://botnet-payload.com',
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('users', [
            'email' => 'bot@spammer.test',
        ]);
    }

    /**
     * 4. Uji mitigasi SQL Injection pada Route Parameter Constraints (whereNumber)
     */
    public function test_sql_injection_on_route_parameter_is_blocked_by_pattern_constraint(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // Mencoba menyisipkan SQLi payload pada parameter URL {id}
        $sqliPayload = "1' OR '1'='1";
        $response = $this->actingAs($admin)->put('/admin/users/'.urlencode($sqliPayload), [
            'name' => 'Hacker Name',
        ]);

        // Route pattern constraint [0-9]+ menolak rute ini di tingkat routing (404) sebelum query database dieksekusi
        $response->assertStatus(404);
    }

    /**
     * 5. Uji mitigasi SQL Injection pada Filter Pencarian Admin via PDO Binding
     */
    public function test_sql_injection_in_search_filter_is_safely_handled(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // Mencoba menyisipkan payload SQL union / sleep pada parameter pencarian
        $response = $this->actingAs($admin)->get('/dashboard/admin?search=%27+OR+1%3D1+--&role=siswa');

        $response->assertStatus(200);
    }

    /**
     * 6. Uji sanitasi Cross-Site Scripting (XSS) input oleh Middleware
     */
    public function test_xss_payload_in_input_is_sanitized_by_middleware(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'status' => 'approved',
        ]);

        $xssTitle = "<script>alert('XSS-ATTACK')</script>Pengerjaan Modul Database";
        $xssDesc = '<img src=x onerror=alert(1)>Refleksi harian belajar SQL injection.';

        $response = $this->actingAs($siswa)->post(route('siswa.logbook.store'), [
            'tanggal' => '2026-11-15',
            'jam_kerja' => '08:00 - 16:00',
            'judul_kegiatan' => $xssTitle,
            'deskripsi' => $xssDesc,
        ]);

        $response->assertRedirect('/dashboard/siswa');

        // Pastikan tag script dan tag img berbahaya telah dibersihkan oleh SanitizeInputMiddleware
        $this->assertDatabaseMissing('logbooks', [
            'judul_kegiatan' => $xssTitle,
        ]);

        $this->assertDatabaseHas('logbooks', [
            'user_id' => $siswa->id,
            'judul_kegiatan' => 'Pengerjaan Modul Database',
        ]);
    }

    /**
     * 7. Uji mitigasi CSV Formula Injection (DDE) pada Ekspor Rekap Nilai
     */
    public function test_csv_formula_injection_is_sanitized_with_leading_quote(): void
    {
        $pembimbing = User::factory()->create([
            'role' => 'pembimbing',
            'status' => 'approved',
        ]);

        // Siswa sengaja menggunakan nama bernuansa eksekusi formula Excel (=cmd|...)
        $maliciousStudent = User::factory()->create([
            'role' => 'siswa',
            'status' => 'approved',
            'name' => "=cmd|' /C calc'!A0",
            'tempat_dudi' => '+cmd|dir!B1',
        ]);

        $response = $this->actingAs($pembimbing)->get(route('pembimbing.export.excel'));

        $response->assertStatus(200);
        $content = $response->streamedContent();

        // Karakter berbahaya = dan + wajib dinetralisir dengan awalan tanda kutip tunggal '
        $this->assertStringContainsString("'=cmd|' /C calc'!A0", $content);
        $this->assertStringContainsString("'+cmd|dir!B1", $content);
    }

    /**
     * 8. Uji mitigasi Insecure Direct Object Reference (IDOR) pada Unduh Sertifikat
     */
    public function test_idor_protection_prevents_unauthorized_student_certificate_download(): void
    {
        $siswaA = User::factory()->create([
            'role' => 'siswa',
            'status' => 'approved',
        ]);

        $siswaB = User::factory()->create([
            'role' => 'siswa',
            'status' => 'approved',
        ]);

        // Siswa A mencoba mengunduh sertifikat Siswa B dengan mengganti query string ID
        $response = $this->actingAs($siswaA)->get(route('export.sertifikat', ['student_id' => $siswaB->id]));

        $response->assertStatus(403);
    }

    /**
     * 9. Uji mitigasi Insecure Direct Object Reference (IDOR) pada Validasi Logbook Mentor
     */
    public function test_idor_protection_prevents_unauthorized_mentor_logbook_approval(): void
    {
        $mentor1 = User::factory()->create(['role' => 'mentor', 'status' => 'approved']);
        $mentor2 = User::factory()->create(['role' => 'mentor', 'status' => 'approved']);

        // Siswa dibimbing oleh mentor 2
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'status' => 'approved',
            'mentor_id' => $mentor2->id,
        ]);

        $logbook = Logbook::create([
            'user_id' => $siswa->id,
            'tanggal' => '2026-11-15',
            'jam_kerja' => '08:00 - 16:00',
            'judul_kegiatan' => 'Kegiatan Normal',
            'deskripsi' => 'Deskripsi kegiatan magang siswa',
            'status' => 'Pending',
        ]);

        // Mentor 1 (bukan pembimbing siswa ini) mencoba memvalidasi logbook
        $response = $this->actingAs($mentor1)->post(route('mentor.logbook.update', ['id' => $logbook->id]), [
            'status' => 'Approved',
            'catatan_mentor' => 'Catatan tidak sah',
        ]);

        $response->assertStatus(403);
    }
}
