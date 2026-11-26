<?php

namespace Tests\Feature;

use App\Livewire\MentorLogbookApproval;
use App\Livewire\PembimbingMonitoring;
use App\Models\Attendance;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireComponentsTest extends TestCase
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

    public function test_mentor_logbook_approval_updates_status_note_and_dispatches_event(): void
    {
        $mentor = $this->createUser(['role' => 'mentor']);
        $student = $this->createUser([
            'name' => 'Siswa Binaan',
            'role' => 'siswa',
            'mentor_id' => $mentor->id,
        ]);

        $logbookOne = Logbook::create([
            'user_id' => $student->id,
            'tanggal' => now()->toDateString(),
            'judul_kegiatan' => 'Setup API Authentication',
            'deskripsi' => 'Implementasi token sanctum dan middleware.',
            'status' => 'Pending',
        ]);

        $logbookTwo = Logbook::create([
            'user_id' => $student->id,
            'tanggal' => now()->subDay()->toDateString(),
            'judul_kegiatan' => 'Migrasi Database',
            'deskripsi' => 'Menambahkan tabel logbooks dan attendances.',
            'status' => 'Pending',
        ]);

        Livewire::actingAs($mentor)
            ->test(MentorLogbookApproval::class)
            ->assertSee('Setup API Authentication')
            ->set("catatan.{$logbookOne->id}", 'Bagus dan rapi')
            ->call('updateStatus', $logbookOne->id, 'Approved')
            ->assertDispatched('mentor-logbook-updated', pendingCount: 1)
            ->set("catatan.{$logbookTwo->id}", 'Lengkapi screenshot hasil')
            ->call('updateStatus', $logbookTwo->id, 'Revisi')
            ->assertDispatched('mentor-logbook-updated', pendingCount: 0);

        $this->assertSame('Approved', $logbookOne->fresh()->status);
        $this->assertSame('Bagus dan rapi', $logbookOne->fresh()->catatan_mentor);
        $this->assertSame('Revisi', $logbookTwo->fresh()->status);
        $this->assertSame('Lengkapi screenshot hasil', $logbookTwo->fresh()->catatan_mentor);
    }

    public function test_mentor_logbook_approval_blocks_idor_from_other_mentor(): void
    {
        $mentorOwner = $this->createUser(['role' => 'mentor']);
        $mentorIntruder = $this->createUser(['role' => 'mentor']);

        $student = $this->createUser([
            'role' => 'siswa',
            'mentor_id' => $mentorOwner->id,
        ]);

        $logbook = Logbook::create([
            'user_id' => $student->id,
            'tanggal' => now()->toDateString(),
            'judul_kegiatan' => 'Task Rahasia',
            'deskripsi' => 'Detail pekerjaan internal.',
            'status' => 'Pending',
        ]);

        Livewire::actingAs($mentorIntruder)
            ->test(MentorLogbookApproval::class)
            ->call('updateStatus', $logbook->id, 'Approved')
            ->assertForbidden();

        $this->assertSame('Pending', $logbook->fresh()->status);
    }

    public function test_pembimbing_monitoring_filters_by_dudi_departemen_and_status(): void
    {
        $pembimbing = $this->createUser(['role' => 'pembimbing']);

        $siswaAlphaPplg = $this->createUser([
            'name' => 'Andi PPLG',
            'role' => 'siswa',
            'departemen' => 'PPLG',
            'tempat_dudi' => 'PT Alpha Tech',
        ]);

        $siswaAlphaAkl = $this->createUser([
            'name' => 'Budi AKL',
            'role' => 'siswa',
            'departemen' => 'AKL',
            'tempat_dudi' => 'PT Alpha Tech',
        ]);

        $siswaBeta = $this->createUser([
            'name' => 'Citra Beta',
            'role' => 'siswa',
            'departemen' => 'PPLG',
            'tempat_dudi' => 'PT Beta Jaya',
        ]);

        Attendance::create([
            'user_id' => $siswaAlphaPplg->id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => '08:00:00',
            'status' => 'Hadir',
            'lokasi' => 'PT Alpha Tech',
        ]);

        Attendance::create([
            'user_id' => $siswaAlphaAkl->id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => '08:15:00',
            'status' => 'Diluar Radius DUDI',
            'lokasi' => 'PT Alpha Tech',
        ]);

        Logbook::create([
            'user_id' => $siswaAlphaPplg->id,
            'tanggal' => now()->toDateString(),
            'judul_kegiatan' => 'Coding Frontend',
            'deskripsi' => 'Styling bento grid',
            'status' => 'Pending',
        ]);

        Livewire::actingAs($pembimbing)
            ->test(PembimbingMonitoring::class, ['initialDudi' => 'PT Alpha Tech'])
            ->assertSee('Andi PPLG')
            ->assertSee('Budi AKL')
            ->assertDontSee('Citra Beta')
            ->set('selectedDepartemen', 'PPLG')
            ->assertSee('Andi PPLG')
            ->assertDontSee('Budi AKL')
            ->set('selectedDepartemen', '')
            ->set('selectedStatus', 'luar_radius')
            ->assertSee('Budi AKL')
            ->assertDontSee('Andi PPLG')
            ->set('selectedStatus', 'logbook_pending')
            ->assertSee('Andi PPLG')
            ->assertDontSee('Budi AKL')
            ->set('selectedStatus', '')
            ->set('selectedDudi', 'PT Beta Jaya')
            ->assertSee('Citra Beta')
            ->assertDontSee('Andi PPLG')
            ->set('selectedStatus', 'belum_absen')
            ->assertSee('Citra Beta');
    }
}
