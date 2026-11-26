<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mentor - Jurnal PKL Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        secondary: '#2563eb',
                        third: '#3c5897',
                        schoolnavy: '#1e3a8a',
                        schoolblue: '#2563eb',
                        schoolred: '#dc2626',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>

<body class="bg-slate-100 font-sans text-slate-800 antialiased overflow-x-hidden"
    x-data="{
        activeTab: ['dashboard', 'mahasiswa', 'laporan', 'nilai'].includes(window.location.hash.replace('#', ''))
            ? window.location.hash.replace('#', '')
            : 'dashboard',
        sidebarOpen: false,
        pendingCount: {{ $perluValidasi ?? 0 }}
    }"
    @mentor-logbook-updated.window="pendingCount = $event.detail.pendingCount">

    <!-- MOBILE DRAWER OVERLAY -->
    <div id="sidebar-overlay" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-30 transition-opacity duration-300 md:hidden">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
            class="w-64 bg-primary text-white flex flex-col fixed inset-y-0 left-0 z-40 transform transition-transform duration-300 ease-in-out md:static shadow-xl">
            <!-- Pure Logo Brand Header -->
            <div class="h-20 flex items-center justify-between px-6 bg-primary">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-9 h-9 object-contain shrink-0">
                    <div>
                        <span class="text-sm font-bold tracking-wide text-white block">Jurnal PKL</span>
                        <span class="text-xs text-blue-200 font-medium">Digital System</span>
                    </div>
                </div>
                <button type="button" @click="sidebarOpen = false" aria-label="Tutup Sidebar"
                    class="md:hidden text-blue-200 hover:text-white min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto">
                <a href="#dashboard" @click.prevent="activeTab = 'dashboard'; sidebarOpen = false"
                    :class="activeTab === 'dashboard' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#mahasiswa" @click.prevent="activeTab = 'mahasiswa'; sidebarOpen = false"
                    :class="activeTab === 'mahasiswa' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Daftar Siswa Bimbingan</span>
                </a>
                <a href="#laporan" @click.prevent="activeTab = 'laporan'; sidebarOpen = false"
                    :class="activeTab === 'laporan' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-book-open w-5 text-center"></i>
                    <span>Validasi Jurnal</span>
                    <span x-text="pendingCount" class="ml-auto text-xs font-bold text-amber-300 tabular-nums">{{ $perluValidasi ?? 0 }}</span>
                </a>
                <a href="#nilai" @click.prevent="activeTab = 'nilai'; sidebarOpen = false"
                    :class="activeTab === 'nilai' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-file-invoice w-5 text-center"></i>
                    <span>Penilaian PKL</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-200 hover:bg-red-500/20 hover:text-white transition text-sm font-semibold">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOP NAVBAR -->
            <header class="min-h-[4.5rem] py-3 bg-white flex items-center justify-between px-4 sm:px-6 z-20 shadow-sm shrink-0 gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" @click="sidebarOpen = !sidebarOpen" aria-label="Buka Menu"
                        class="text-slate-600 hover:text-primary md:hidden min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg hover:bg-slate-100 transition-colors shrink-0">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div class="min-w-0">
                        <h2 id="page-title" class="text-base sm:text-xl font-bold text-primary truncate">Dashboard Pembimbing Industri</h2>
                        <p class="text-xs text-slate-500 truncate hidden sm:block">Selamat datang kembali, {{ Auth::user()->name ?? 'Mentor DUDI' }}</p>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Mentor DUDI' }}</span>
                        <span class="block text-xs text-slate-500">Mentor Industri</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-third text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'MD', 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6">

                <!-- TAB 1: DASHBOARD -->
                <div id="tab-dashboard" x-show="activeTab === 'dashboard'" class="tab-content space-y-6">
                    <div class="bg-gradient-to-r from-primary to-third rounded-xl p-6 sm:p-8 text-white shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <h3 class="text-xl sm:text-2xl font-bold">Monitoring Aktivitas PKL Siswa</h3>
                            <p class="text-blue-100 text-sm max-w-xl leading-relaxed">Kelola absensi, validasi jurnal kegiatan harian, serta berikan penilaian akhir untuk siswa bimbingan Anda dengan mudah.</p>
                        </div>
                        <div class="hidden md:flex w-16 h-16 bg-white/10 rounded-xl items-center justify-center shrink-0">
                            <i class="fa-solid fa-user-shield text-2xl text-blue-100"></i>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-secondary flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Siswa</p>
                                <h4 class="text-2xl font-bold text-slate-900 tabular-nums">{{ $totalSiswa ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Perlu Validasi</p>
                                <h4 class="text-2xl font-bold text-slate-900 tabular-nums"><span x-text="pendingCount">{{ $perluValidasi ?? 0 }}</span> Jurnal</h4>
                            </div>
                        </div>
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Hadir Hari Ini</p>
                                <h4 class="text-2xl font-bold text-slate-900 tabular-nums">{{ $hadirHariIni ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-third flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Status Nilai</p>
                                <h4 class="text-2xl font-bold text-slate-900">Aktif</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between gap-2">
                            <h4 class="font-bold text-primary text-base sm:text-lg">Aktivitas Jurnal Terbaru</h4>
                            <button type="button" @click="activeTab = 'laporan'"
                                class="min-h-[36px] text-xs sm:text-sm font-semibold text-secondary hover:underline cursor-pointer">Lihat Semua</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Kegiatan</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logbooks ?? [] as $logbook)
                                        <tr class="hover:bg-slate-50 odd:bg-white even:bg-slate-50/40">
                                            <td class="py-3.5 px-4 font-semibold text-slate-800 whitespace-nowrap">
                                                {{ $logbook->user->name ?? 'Siswa' }}</td>
                                            <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">{{ $logbook->tanggal }}</td>
                                            <td class="py-3.5 px-4 text-slate-600">{{ $logbook->judul_kegiatan }}</td>
                                            <td class="py-3.5 px-4 whitespace-nowrap">
                                                @php $st = $logbook->status ?? 'Pending'; @endphp
                                                @if ($st === 'Approved')
                                                    <span class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Approved
                                                    </span>
                                                @elseif ($st === 'Revisi')
                                                    <span class="inline-flex items-center gap-1.5 text-rose-700 font-semibold">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Revisi
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 text-amber-700 font-semibold">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>{{ $st }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                <button type="button" @click="activeTab = 'laporan'"
                                                    class="min-h-[36px] px-3.5 py-1.5 bg-secondary text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition cursor-pointer">Periksa</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-slate-400 text-sm">Belum ada aktivitas jurnal terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SISWA BIMBINGAN -->
                <div id="tab-mahasiswa" x-show="activeTab === 'mahasiswa'" x-cloak x-data="{ searchSiswa: '' }" class="tab-content space-y-6">
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h3 class="font-bold text-primary text-lg">Daftar Siswa Bimbingan PKL</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Daftar siswa yang ditempatkan di bawah bimbingan Anda (sesuai plotting admin).</p>
                            </div>
                            <div class="w-full sm:w-auto">
                                <input type="text" x-model="searchSiswa" placeholder="Cari nama siswa..."
                                    class="w-full sm:w-64 min-h-[44px] px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                            @forelse($siswas ?? [] as $siswa)
                                <div x-show="searchSiswa.trim() === '' || '{{ strtolower($siswa->name) }}'.includes(searchSiswa.toLowerCase())"
                                    class="rounded-xl p-5 bg-slate-50 hover:bg-slate-100/80 transition flex flex-col justify-between space-y-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-11 h-11 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center shrink-0">
                                                {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="font-bold text-slate-800 text-base truncate">{{ $siswa->name }}</h4>
                                                <p class="text-xs text-slate-500">{{ $siswa->school ?? 'SMK Negeri 1 Depok' }}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-1.5 text-xs sm:text-sm text-slate-600">
                                            <p><span class="font-semibold text-slate-700">Email:</span> {{ $siswa->email }}</p>
                                            <p><span class="font-semibold text-slate-700">Jurusan:</span> {{ $siswa->departemen ?? 'PPLG' }}</p>
                                            <p><span class="font-semibold text-slate-700">Periode:</span> Jul - Okt 2026</p>
                                        </div>
                                    </div>
                                    <button type="button" @click="activeTab = 'laporan'"
                                        class="w-full min-h-[44px] py-2 bg-white text-primary text-xs sm:text-sm font-semibold rounded-lg shadow-sm hover:bg-primary hover:text-white transition cursor-pointer">Periksa Jurnal Siswa</button>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm col-span-3 text-center py-8">Belum ada siswa bimbingan yang di-plotting oleh Admin.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- TAB 3: VALIDASI JURNAL & LAPORAN (LIVEWIRE) -->
                <div id="tab-laporan" x-show="activeTab === 'laporan'" x-cloak class="tab-content space-y-6">
                    <livewire:mentor-logbook-approval />
                </div>

                <!-- TAB 4: PENILAIAN -->
                <div id="tab-nilai" x-show="activeTab === 'nilai'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <div>
                            <h3 class="font-bold text-primary text-lg">Form &amp; Manajemen Penilaian Akhir PKL</h3>
                            <p class="text-xs sm:text-sm text-slate-500">Berikan penilaian objektif berdasarkan berbagai aspek kompetensi dan kedisiplinan.</p>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- BAGIAN KIRI: Form Input Nilai -->
                            <div class="lg:col-span-2 bg-slate-50 p-4 sm:p-5 rounded-xl">
                                <form action="{{ route('mentor.store.nilai') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <h4 class="font-bold text-primary text-sm uppercase tracking-wider">
                                        <i class="fa-solid fa-pen-to-square mr-1 text-secondary"></i> Input Nilai Siswa
                                    </h4>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Pilih Siswa (Individu)</label>
                                        <select name="student_id"
                                            class="w-full min-h-[44px] px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"
                                            required>
                                            <option value="">-- Pilih Nama Siswa --</option>
                                            @forelse($siswas ?? [] as $s)
                                                <option value="{{ $s->id }}">{{ $s->name }} (DUDI: {{ $s->tempat_dudi ?? 'Belum ada' }})</option>
                                            @empty
                                                <option value="">Tidak ada siswa bimbingan</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kompetensi Teknis (0-100)</label>
                                            <input type="number" name="nilai_teknis" placeholder="88"
                                                class="w-full min-h-[44px] px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kedisiplinan &amp; Absensi (0-100)</label>
                                            <input type="number" name="nilai_disiplin" placeholder="90"
                                                class="w-full min-h-[44px] px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Kerjasama Tim / Sikap (0-100)</label>
                                            <input type="number" name="nilai_kerjasama" placeholder="85"
                                                class="w-full min-h-[44px] px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Inisiatif &amp; Kreativitas (0-100)</label>
                                            <input type="number" name="nilai_inisiatif" placeholder="87"
                                                class="w-full min-h-[44px] px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"
                                                required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">Catatan &amp; Ulasan Perkembangan PKL</label>
                                        <textarea name="catatan" rows="3" placeholder="Siswa memiliki kemampuan teknis yang baik..."
                                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full sm:w-auto min-h-[44px] px-6 py-2.5 bg-secondary text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm cursor-pointer">
                                        Simpan &amp; Kunci Nilai
                                    </button>
                                </form>
                            </div>

                            <!-- BAGIAN KANAN: Status Nilai Siswa Bimbingan -->
                            <div class="space-y-4 bg-slate-50 p-4 sm:p-5 rounded-xl">
                                <h4 class="font-bold text-primary text-sm uppercase tracking-wider">
                                    <i class="fa-solid fa-clipboard-list mr-1 text-secondary"></i> Status Nilai Siswa
                                </h4>
                                <div class="space-y-3">
                                    @forelse($siswas ?? [] as $s)
                                        @php
                                            $existingGrade = DB::table('grades')
                                                ->where('student_id', $s->id)
                                                ->whereNotNull('nilai_dudi')
                                                ->first();
                                        @endphp
                                        <div class="bg-white p-3.5 rounded-xl flex items-center justify-between gap-2 shadow-sm">
                                            <div>
                                                <span class="font-semibold text-sm text-slate-800 block">{{ $s->name }}</span>
                                                @if ($existingGrade)
                                                    <span class="text-xs text-emerald-700 font-semibold inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-check-circle"></i> Sudah Dinilai (DUDI: {{ $existingGrade->nilai_dudi }})
                                                    </span>
                                                @else
                                                    <span class="text-xs text-amber-700 font-semibold inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-clock"></i> Belum Dinilai
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-secondary font-semibold">Aktif</span>
                                        </div>
                                    @empty
                                        <p class="text-xs sm:text-sm text-slate-400 text-center py-4">Belum ada siswa bimbingan.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
