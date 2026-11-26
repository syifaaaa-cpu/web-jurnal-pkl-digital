<div x-data="{ subLaporan: 'validasi' }" class="bg-white p-4 sm:p-6 rounded-xl shadow-sm space-y-6">
    <!-- Header & Sub-Tab Switcher -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-2">
        <div>
            <h3 class="font-bold text-primary text-lg">Validasi Jurnal &amp; Rekap Laporan</h3>
            <p class="text-xs sm:text-sm text-slate-500">Periksa jurnal harian, setujui atau minta revisi secara langsung tanpa muat ulang halaman.</p>
        </div>
        <div class="flex w-full md:w-auto bg-slate-100 p-1 rounded-xl text-xs sm:text-sm font-semibold gap-1">
            <button type="button" @click="subLaporan = 'validasi'"
                :class="subLaporan === 'validasi' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-primary'"
                class="flex-1 md:flex-none min-h-[44px] px-4 py-2 rounded-lg transition cursor-pointer">
                Validasi Harian
            </button>
            <button type="button" @click="subLaporan = 'rekap'"
                :class="subLaporan === 'rekap' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-primary'"
                class="flex-1 md:flex-none min-h-[44px] px-4 py-2 rounded-lg transition cursor-pointer">
                Rekap Per Orang
            </button>
        </div>
    </div>

    @if ($feedbackMessage)
        <div class="bg-emerald-50 text-emerald-800 px-4 py-3 rounded-xl text-xs sm:text-sm font-semibold flex items-center justify-between gap-2">
            <span><i class="fa-solid fa-circle-check mr-1.5"></i>{{ $feedbackMessage }}</span>
            <button type="button" wire:click="$set('feedbackMessage', null)" class="text-emerald-700 hover:text-emerald-900 font-bold min-h-[36px] min-w-[36px] flex items-center justify-center">
                &times;
            </button>
        </div>
    @endif

    <!-- SUB-VIEW 1: VALIDASI HARIAN -->
    <div x-show="subLaporan === 'validasi'" class="space-y-4">
        <div class="flex flex-col sm:flex-row gap-3 bg-slate-50 p-4 rounded-xl items-start sm:items-center justify-between">
            <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 w-full sm:w-auto">
                <div class="flex items-center justify-between sm:justify-start gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-slate-600">Tanggal:</label>
                    <input type="date" wire:model.live="filterTanggal"
                        class="min-h-[40px] px-3 py-1.5 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary">
                </div>
                <div class="flex items-center justify-between sm:justify-start gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-slate-600">Siswa:</label>
                    <select wire:model.live="filterStudentId"
                        class="min-h-[40px] px-3 py-1.5 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary">
                        <option value="all">Semua Siswa</option>
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($filterTanggal !== '' || $filterStudentId !== 'all')
                    <button type="button" wire:click="$set('filterTanggal', ''); $set('filterStudentId', 'all')"
                        class="text-xs sm:text-sm font-semibold text-secondary hover:underline cursor-pointer text-left">
                        Reset Filter
                    </button>
                @endif
            </div>
            <div class="flex items-center gap-4 text-xs sm:text-sm">
                <span class="inline-flex items-center gap-1.5 text-amber-700 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    {{ $pendingCount }} Pending
                </span>
                <span class="text-slate-600 font-medium">
                    {{ $logbooks->count() }} Jurnal Ditampilkan
                </span>
            </div>
        </div>

        @forelse ($logbooks as $logbook)
            <div wire:key="logbook-card-{{ $logbook->id }}"
                class="rounded-xl p-4 sm:p-5 bg-slate-50 space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center shrink-0">
                            {{ strtoupper(substr($logbook->user->name ?? 'S', 0, 2)) }}
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 text-sm sm:text-base block">{{ $logbook->user->name ?? 'Siswa' }}</span>
                            <span class="text-xs text-slate-500">{{ $logbook->user->departemen ?? 'PPLG' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-xs sm:text-sm">
                        @if ($logbook->status === 'Approved')
                            <span class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Approved
                            </span>
                        @elseif ($logbook->status === 'Revisi')
                            <span class="inline-flex items-center gap-1.5 text-rose-700 font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Revisi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-amber-700 font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Pending
                            </span>
                        @endif
                        <span class="text-slate-500 font-medium">{{ $logbook->tanggal }}</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Kegiatan Utama</p>
                    <p class="text-sm sm:text-base font-semibold text-slate-800">{{ $logbook->judul_kegiatan }}</p>
                    <div class="text-xs sm:text-sm text-slate-600 bg-white p-3.5 rounded-lg">
                        <span class="font-semibold text-slate-800">Deskripsi/Kendala:</span>
                        {{ $logbook->deskripsi }}
                    </div>
                </div>

                <div class="space-y-3 pt-1">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-primary uppercase">
                            <i class="fa-solid fa-pen-nib mr-1 text-secondary"></i> Catatan / Umpan Balik Mentor
                        </label>
                        <textarea wire:model.defer="catatan.{{ $logbook->id }}" rows="2"
                            placeholder="Tulis catatan atau arahan untuk siswa di sini..."
                            class="w-full px-3.5 py-2.5 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary"></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 pt-1">
                        <button type="button" wire:click="updateStatus({{ $logbook->id }}, 'Revisi')"
                            wire:loading.attr="disabled" wire:target="updateStatus({{ $logbook->id }}, 'Revisi')"
                            class="min-h-[44px] px-4 py-2 bg-amber-500 text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-amber-600 transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-pen-to-square"></i><span>Minta Revisi</span>
                        </button>
                        <button type="button" wire:click="updateStatus({{ $logbook->id }}, 'Approved')"
                            wire:loading.attr="disabled" wire:target="updateStatus({{ $logbook->id }}, 'Approved')"
                            class="min-h-[44px] px-4 py-2 bg-emerald-600 text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-emerald-700 transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-check"></i><span>Setujui Jurnal</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-slate-500 text-sm text-center py-8">Belum ada jurnal atau laporan sesuai filter yang dipilih.</p>
        @endforelse
    </div>

    <!-- SUB-VIEW 2: REKAP LAPORAN PER ORANG -->
    <div x-show="subLaporan === 'rekap'" x-cloak class="space-y-4">
        <div class="bg-slate-50 p-4 rounded-xl flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                <label class="text-xs sm:text-sm font-semibold text-slate-600">Pilih Siswa:</label>
                <select wire:model.live="filterStudentId"
                    class="min-h-[44px] px-3 py-2 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary">
                    <option value="all">Semua Siswa</option>
                    @foreach ($siswas as $s)
                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->departemen ?? 'PPLG' }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="rounded-xl p-4 sm:p-5 bg-slate-50 space-y-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h4 class="font-bold text-slate-900 text-base">Rekapitulasi Jurnal Bimbingan</h4>
                    <p class="text-xs sm:text-sm text-slate-500">Data tersinkronisasi langsung dengan status verifikasi mentor.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-emerald-700 font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Status: Aktif
                </span>
            </div>
            <div class="overflow-x-auto bg-white rounded-xl">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase text-xs">
                            <th class="py-3 px-3.5">Tanggal</th>
                            <th class="py-3 px-3.5">Aktivitas Utama</th>
                            <th class="py-3 px-3.5">Catatan Mentor</th>
                            <th class="py-3 px-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapLogbooks as $logbook)
                            <tr wire:key="rekap-row-{{ $logbook->id }}" class="hover:bg-slate-50/70">
                                <td class="py-3 px-3.5 text-slate-600 whitespace-nowrap">{{ $logbook->tanggal }}</td>
                                <td class="py-3 px-3.5 text-slate-800 font-medium">
                                    <div>{{ $logbook->judul_kegiatan }}</div>
                                    <div class="text-xs text-slate-500">{{ $logbook->user->name ?? 'Siswa' }}</div>
                                </td>
                                <td class="py-3 px-3.5 text-slate-600">{{ $logbook->catatan_mentor ?? '-' }}</td>
                                <td class="py-3 px-3.5 text-center whitespace-nowrap">
                                    @if ($logbook->status === 'Approved')
                                        <span class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Approved
                                        </span>
                                    @elseif ($logbook->status === 'Revisi')
                                        <span class="inline-flex items-center gap-1.5 text-rose-700 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Revisi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-amber-700 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-slate-400">Belum ada data rekap.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
