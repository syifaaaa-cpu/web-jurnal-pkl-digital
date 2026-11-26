<div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="font-bold text-primary text-lg">Monitoring Absensi &amp; Logbook Siswa per DUDI</h3>
            <p class="text-xs sm:text-sm text-slate-500">Filter instansi DUDI, kompetensi keahlian (jurusan), dan status kehadiran secara reaktif.</p>
        </div>
        <div class="text-xs sm:text-sm text-slate-500 sm:text-right">
            <span class="font-bold text-primary block">Total Siswa Ditampilkan: {{ $siswasMonitoring->count() }} Orang</span>
            <span>Status Sinkronisasi: <span class="text-emerald-700 font-semibold">Terhubung (Livewire)</span></span>
        </div>
    </div>

    <!-- Filter Reaktif (DUDI, Jurusan, Status Kehadiran/Logbook) -->
    <div class="bg-slate-50 p-4 rounded-xl grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="space-y-1.5">
            <label class="text-xs sm:text-sm font-semibold text-slate-600 block">Instansi / Mitra DUDI:</label>
            <select wire:model.live="selectedDudi"
                class="w-full min-h-[44px] px-3 py-2 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary font-medium">
                <option value="">-- Semua Instansi DUDI --</option>
                @foreach ($dudis as $dudi)
                    <option value="{{ $dudi->tempat_dudi }}">
                        {{ $dudi->tempat_dudi }} (Mentor: {{ $mentorsByDudi[$dudi->tempat_dudi] ?? 'Belum ditentukan' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1.5">
            <label class="text-xs sm:text-sm font-semibold text-slate-600 block">Jurusan / Kompetensi:</label>
            <select wire:model.live="selectedDepartemen"
                class="w-full min-h-[44px] px-3 py-2 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary font-medium">
                <option value="">Semua Jurusan</option>
                @foreach ($departemenOptions as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>

        <div class="space-y-1.5">
            <label class="text-xs sm:text-sm font-semibold text-slate-600 block">Filter Status Kehadiran / Logbook:</label>
            <select wire:model.live="selectedStatus"
                class="w-full min-h-[44px] px-3 py-2 border border-slate-200 rounded-lg text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary font-medium">
                <option value="">Semua Status</option>
                <option value="hadir">Sudah Pernah Hadir</option>
                <option value="luar_radius">Tercatat Diluar Radius DUDI</option>
                <option value="belum_absen">Belum Ada Presensi</option>
                <option value="logbook_pending">Logbook Terakhir Pending</option>
            </select>
        </div>
    </div>

    <!-- Daftar Murid Berdasarkan Filter -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <th class="py-3 px-4">Nama Siswa</th>
                    <th class="py-3 px-4">Rekap Absensi (Hadir / Izin / Sakit)</th>
                    <th class="py-3 px-4">Aktivitas Terakhir / Pekerjaan di DUDI</th>
                    <th class="py-3 px-4 text-center">Aksi &amp; Logbook</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswasMonitoring as $siswa)
                    @php
                        $hadir = (int) $siswa->hadir_count;
                        $izin = (int) $siswa->izin_count;
                        $sakit = (int) $siswa->sakit_count;
                        $diluarRadius = (int) $siswa->diluar_radius_count;
                        $lastLogbook = $siswa->logbooks->first();
                    @endphp
                    <tr wire:key="monitoring-siswa-{{ $siswa->id }}" class="hover:bg-slate-50 odd:bg-white even:bg-slate-50/40">
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-800 text-sm block">{{ $siswa->name }}</span>
                            <span class="text-xs text-slate-500">
                                ID: {{ $siswa->id }} &bull; {{ $siswa->departemen ?? '-' }} &bull; {{ $siswa->email }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="inline-flex items-center flex-wrap gap-3 text-xs sm:text-sm">
                                <span class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>{{ $hadir }} Hadir
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-amber-700 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>{{ $izin }} Izin
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-third font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-third"></span>{{ $sakit }} Sakit
                                </span>
                                @if ($diluarRadius > 0)
                                    <span class="inline-flex items-center gap-1.5 text-rose-700 font-medium text-xs"
                                        title="{{ $diluarRadius }} presensi tercatat di luar radius koordinat DUDI">
                                        ({{ $diluarRadius }} Luar Radius)
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            @if ($lastLogbook)
                                <span class="font-semibold text-slate-800 block">{{ $lastLogbook->judul_kegiatan ?? $lastLogbook->activity ?? ($lastLogbook->deskripsi ?? 'Aktivitas PKL') }}</span>
                                <span class="text-xs text-slate-500">
                                    Dibuat: {{ \Carbon\Carbon::parse($lastLogbook->created_at)->diffForHumans() }} &bull; Status: {{ $lastLogbook->status }}
                                </span>
                            @else
                                <span class="text-slate-400 italic">Belum ada catatan logbook</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <a href="{{ route('pembimbing.export.logbook', $siswa->id) }}"
                                class="min-h-[40px] px-3.5 py-2 bg-secondary text-white rounded-lg hover:bg-blue-700 transition font-semibold inline-flex items-center gap-1.5 shadow-sm whitespace-nowrap text-xs sm:text-sm">
                                <i class="fa-solid fa-file-pdf"></i><span>Unduh Logbook</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-slate-400">Tidak ada siswa yang sesuai dengan kriteria filter saat ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
