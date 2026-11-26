<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Komponen Livewire untuk memfilter dan memantau kehadiran serta logbook siswa pada Dashboard Pembimbing Sekolah.
 */
class PembimbingMonitoring extends Component
{
    #[Url(as: 'monitoring_dudi')]
    public string $selectedDudi = '';

    public string $selectedDepartemen = '';

    public string $selectedStatus = '';

    /**
     * Inisialisasi instansi DUDI default jika belum ada query parameter dari URL.
     */
    public function mount(string $initialDudi = ''): void
    {
        if ($this->selectedDudi === '' && $initialDudi !== '') {
            $this->selectedDudi = $initialDudi;
        }
    }

    /**
     * Merender tabel monitoring siswa beserta rekapitulasi absensi dan logbook terakhir secara reaktif.
     */
    public function render(): View
    {
        $dudis = User::where('role', 'siswa')
            ->whereNotNull('tempat_dudi')
            ->select('tempat_dudi')
            ->distinct()
            ->get();

        $mentorsByDudi = User::where('role', 'siswa')
            ->whereNotNull('tempat_dudi')
            ->whereNotNull('mentor_id')
            ->with('mentor:id,name')
            ->get()
            ->groupBy('tempat_dudi')
            ->map(fn ($group) => $group->first()?->mentor?->name ?? 'Belum ditentukan');

        if ($this->selectedDudi === '' && $dudis->isNotEmpty()) {
            $this->selectedDudi = (string) $dudis->first()->tempat_dudi;
        }

        $siswasQuery = User::where('role', 'siswa')
            ->whereNotNull('tempat_dudi')
            ->when($this->selectedDudi !== '', function ($query): void {
                $query->where('tempat_dudi', $this->selectedDudi);
            })
            ->when($this->selectedDepartemen !== '', function ($query): void {
                $query->where('departemen', $this->selectedDepartemen);
            })
            ->withCount([
                'attendances as hadir_count' => function ($q): void {
                    $q->where(function ($sub): void {
                        $sub->where('status', 'like', '%Hadir%')
                            ->orWhere('status', 'like', '%Diluar%');
                    });
                },
                'attendances as izin_count' => function ($q): void {
                    $q->where('status', 'like', '%Izin%');
                },
                'attendances as sakit_count' => function ($q): void {
                    $q->where('status', 'like', '%Sakit%');
                },
                'attendances as diluar_radius_count' => function ($q): void {
                    $q->where('status', 'like', '%Diluar%');
                },
            ])
            ->with(['logbooks' => function ($q): void {
                $q->latest('created_at');
            }]);

        $siswas = $siswasQuery->get();

        if ($this->selectedStatus !== '') {
            $siswas = $siswas->filter(function (User $siswa): bool {
                $lastLogbook = $siswa->logbooks->first();

                return match ($this->selectedStatus) {
                    'hadir' => $siswa->hadir_count > 0,
                    'luar_radius' => $siswa->diluar_radius_count > 0,
                    'belum_absen' => ($siswa->hadir_count + $siswa->izin_count + $siswa->sakit_count) === 0,
                    'logbook_pending' => $lastLogbook !== null && $lastLogbook->status === 'Pending',
                    default => true,
                };
            })->values();
        }

        return view('livewire.pembimbing-monitoring', [
            'dudis' => $dudis,
            'mentorsByDudi' => $mentorsByDudi,
            'siswasMonitoring' => $siswas,
            'departemenOptions' => ['PPLG', 'AKL', 'TKR', 'TBSM', 'PH', 'DKV'],
        ]);
    }
}
