<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Komponen Livewire untuk validasi logbook harian dan rekap laporan siswa bimbingan Mentor DUDI.
 */
class MentorLogbookApproval extends Component
{
    public string $filterStudentId = 'all';

    public string $filterTanggal = '';

    /** @var array<int, string|null> */
    public array $catatan = [];

    public ?string $feedbackMessage = null;

    /**
     * Inisialisasi catatan mentor yang sudah tersimpan pada tiap logbook.
     */
    public function mount(): void
    {
        $studentIds = User::where('role', 'siswa')
            ->where('mentor_id', Auth::id())
            ->pluck('id');

        $this->catatan = Logbook::whereIn('user_id', $studentIds)
            ->pluck('catatan_mentor', 'id')
            ->toArray();
    }

    /**
     * Memperbarui status verifikasi logbook (Approved / Revisi) secara reaktif dengan proteksi Anti-IDOR.
     */
    public function updateStatus(int $logbookId, string $status): void
    {
        if (! in_array($status, ['Approved', 'Revisi'], true)) {
            abort(422, 'Status validasi tidak valid.');
        }

        $logbook = Logbook::with('user')->findOrFail($logbookId);

        if ($logbook->user?->mentor_id !== Auth::id()) {
            abort(403, 'Akses Ditolak: Anda hanya memiliki izin untuk memvalidasi logbook siswa bimbingan Anda.');
        }

        $catatanText = trim((string) ($this->catatan[$logbookId] ?? $logbook->catatan_mentor ?? ''));

        $logbook->update([
            'status' => $status,
            'catatan_mentor' => $catatanText !== '' ? $catatanText : null,
        ]);

        $studentIds = User::where('role', 'siswa')
            ->where('mentor_id', Auth::id())
            ->pluck('id');

        $pendingCount = Logbook::whereIn('user_id', $studentIds)
            ->where('status', 'Pending')
            ->count();

        $this->feedbackMessage = "Jurnal {$logbook->user->name} berhasil ditandai {$status}.";
        $this->dispatch('mentor-logbook-updated', pendingCount: $pendingCount);
    }

    /**
     * Merender daftar logbook siswa bimbingan dengan filter reaktif.
     */
    public function render(): View
    {
        $siswas = User::where('role', 'siswa')
            ->where('mentor_id', Auth::id())
            ->orderBy('name')
            ->get();

        $studentIds = $siswas->pluck('id');

        $baseQuery = Logbook::whereIn('user_id', $studentIds)
            ->with('user')
            ->orderBy('created_at', 'desc');

        $allLogbooks = (clone $baseQuery)->get();

        $filteredLogbooks = $baseQuery
            ->when($this->filterStudentId !== 'all', function ($query): void {
                $query->where('user_id', (int) $this->filterStudentId);
            })
            ->when($this->filterTanggal !== '', function ($query): void {
                $query->whereDate('tanggal', $this->filterTanggal);
            })
            ->get();

        $pendingCount = $allLogbooks->where('status', 'Pending')->count();

        return view('livewire.mentor-logbook-approval', [
            'siswas' => $siswas,
            'logbooks' => $filteredLogbooks,
            'rekapLogbooks' => $allLogbooks->when(
                $this->filterStudentId !== 'all',
                fn ($collection) => $collection->where('user_id', (int) $this->filterStudentId)
            ),
            'pendingCount' => $pendingCount,
        ]);
    }
}
