<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <!-- Cloudflare CDN Leaflet CSS & JS (Stabil & Terisolasi) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Jurnal PKL Digital</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Leaflet & Tailwind CSS Compatibility Guard -->
    <style>
        [x-cloak] { display: none !important; }
        .leaflet-pane img,
        .leaflet-tile-container img,
        .leaflet-container img,
        .leaflet-tile {
            max-width: none !important;
            max-height: none !important;
        }
        #dudiMap {
            position: relative !important;
            overflow: hidden !important;
            width: 100% !important;
            height: 320px !important;
            min-height: 320px !important;
            border-radius: 0.75rem;
            z-index: 10;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1e3a8a',
                        secondary: '#2563eb',
                        third: '#3c5897',
                        schoolnavy: '#1e3a8a',
                        schoolblue: '#2563eb',
                        schoolred: '#dc2626',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-100 text-slate-800 font-sans antialiased overflow-x-hidden"
    x-data="{
        activeTab: ['dashboard', 'attendance', 'reports', 'settings'].includes(window.location.hash.replace('#', ''))
            ? window.location.hash.replace('#', '')
            : 'dashboard',
        activeSub: 'profile',
        sidebarOpen: false,
        modalOpen: false,
        allHistoryOpen: false,
        modalType: 'masuk',
        attendanceStatus: 'Hadir',
        titles: {
            dashboard: 'Dashboard Siswa',
            attendance: 'Presensi & Geotagging',
            reports: 'Reports & Logbook',
            settings: 'Pengaturan Akun'
        },
        selectTab(tab) {
            this.activeTab = tab;
            this.sidebarOpen = false;
            window.history.replaceState(null, '', '#' + tab);
            this.$nextTick(() => {
                if (window.lucide) lucide.createIcons();
                if (tab === 'settings' && this.activeSub === 'profile' && typeof ensureDudiMapReady === 'function') {
                    ensureDudiMapReady();
                }
            });
        },
        openAttendance(type) {
            this.modalType = type;
            this.attendanceStatus = 'Hadir';
            this.modalOpen = true;
            this.$nextTick(() => {
                if (window.lucide) lucide.createIcons();
                if (typeof initAttendanceModalGps === 'function') initAttendanceModalGps(type);
            });
        }
    }"
    x-init="$nextTick(() => {
        if (window.lucide) lucide.createIcons();
        if (activeTab === 'settings' && activeSub === 'profile' && typeof ensureDudiMapReady === 'function') {
            ensureDudiMapReady();
        }
    })">

    <!-- MOBILE DRAWER OVERLAY -->
    <div id="sidebar-overlay" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-30 transition-opacity duration-300 md:hidden">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR UTAMA -->
        <aside id="sidebar"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
            class="w-64 bg-primary text-blue-100 flex flex-col fixed inset-y-0 left-0 z-40 transform transition-transform duration-300 ease-in-out md:static shadow-xl">
            <!-- Pure Logo Brand Header -->
            <div class="h-20 flex items-center justify-between px-6 bg-primary">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-9 h-9 object-contain shrink-0">
                    <div>
                        <span class="text-sm font-bold tracking-wide text-white block">Jurnal PKL</span>
                        <span class="text-xs text-blue-200 font-medium">SMKN 1 Depok</span>
                    </div>
                </div>
                <button type="button" @click="sidebarOpen = false" aria-label="Tutup Sidebar"
                    class="md:hidden text-blue-200 hover:text-white min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigasi Menu -->
            <nav class="flex-1 px-4 py-4 space-y-1.5 text-sm font-medium overflow-y-auto">
                <a href="#dashboard" @click.prevent="selectTab('dashboard')" id="nav-dashboard"
                    :class="activeTab === 'dashboard' ? 'bg-secondary text-white font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="menu-item min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                <a href="#attendance" @click.prevent="selectTab('attendance')" id="nav-attendance"
                    :class="activeTab === 'attendance' ? 'bg-secondary text-white font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="menu-item min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors">
                    <i data-lucide="calendar-check" class="w-4 h-4"></i> Attendance
                </a>
                <a href="#reports" @click.prevent="selectTab('reports')" id="nav-reports"
                    :class="activeTab === 'reports' ? 'bg-secondary text-white font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="menu-item min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Reports &amp; Logbook
                </a>
                <a href="#settings" @click.prevent="selectTab('settings')" id="nav-settings"
                    :class="activeTab === 'settings' ? 'bg-secondary text-white font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="menu-item min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl transition-colors">
                    <i data-lucide="settings" class="w-4 h-4"></i> Settings
                </a>
            </nav>

            <!-- Tombol Logout -->
            <div class="p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-200 hover:bg-red-500/20 hover:text-white transition text-sm font-semibold">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Aplikasi
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOPBAR -->
            <header class="min-h-[4.5rem] py-3 bg-white flex justify-between items-center px-4 sm:px-6 sticky top-0 z-10 shadow-sm shrink-0 gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" @click="sidebarOpen = !sidebarOpen" aria-label="Buka Menu"
                        class="md:hidden min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-primary hover:bg-slate-100 transition shrink-0">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h2 class="text-base sm:text-xl font-bold text-primary tracking-tight truncate"
                        id="page-title" x-text="titles[activeTab] || 'Dashboard Siswa'">Dashboard Siswa</h2>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Siswa' }}</span>
                        <span class="block text-xs text-slate-500">Siswa Praktikan</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-third flex items-center justify-center font-bold text-white text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'BS', 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN DINAMIS -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6">

                <!-- TAB 1: DASHBOARD -->
                <div id="tab-dashboard" x-show="activeTab === 'dashboard'" class="tab-content space-y-6">

                    @php
                        $user = Auth::user();

                        $totalKehadiran = App\Models\Attendance::where('user_id', $user->id)
                            ->whereNotNull('jam_masuk')
                            ->count();

                        $targetHariKerja = 30;
                        $persenKehadiran =
                            $targetHariKerja > 0 ? min(round(($totalKehadiran / $targetHariKerja) * 100, 1), 100) : 0;

                        $totalLogbook = class_exists('App\Models\Logbook')
                            ? App\Models\Logbook::where('user_id', $user->id)->count()
                            : 18;

                        if (!isset($latestLogbook) || !$latestLogbook) {
                            $todayDate = \Carbon\Carbon::today()->toDateString();
                            $latestLogbook = isset($logbooks)
                                ? $logbooks->first(function ($item) use ($todayDate) {
                                    return \Carbon\Carbon::parse($item->tanggal)->toDateString() === $todayDate
                                        || \Carbon\Carbon::parse($item->created_at)->toDateString() === $todayDate;
                                })
                                : null;
                        }
                    @endphp

                    <!-- Banner Pengumuman Resmi Sekolah -->
                    <div class="bg-blue-50 p-4 rounded-xl flex items-start sm:items-center gap-3 text-slate-800">
                        <div class="bg-secondary text-white p-2 rounded-lg shrink-0">
                            <i data-lucide="info" class="w-4 h-4"></i>
                        </div>
                        <p class="text-xs sm:text-sm font-medium leading-relaxed">
                            <strong class="font-bold text-primary mr-1">Pengumuman:</strong>
                            Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB. Pastikan mentor industri sudah memberikan approval.
                        </p>
                    </div>

                    <!-- Header Selamat Pagi & Action Button -->
                    <div class="bg-gradient-to-br from-primary to-third p-6 sm:p-8 rounded-xl text-white shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="space-y-2">
                            <h1 class="text-xl sm:text-2xl font-bold tracking-tight">
                                Selamat Pagi, {{ $user->name ?? 'Siswa' }}!
                            </h1>
                            <p class="text-xs sm:text-sm text-blue-100 max-w-xl leading-relaxed">
                                Pantau terus kehadiran dan progres laporan Praktek Kerja Lapangan (PKL) Anda langsung dari dashboard digital SMKN 1 Depok.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row w-full md:w-auto items-stretch sm:items-center gap-3 shrink-0">
                            <button type="button" @click="selectTab('attendance')"
                                class="w-full sm:w-auto min-h-[44px] bg-white text-primary hover:bg-blue-50 text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="calendar-check" class="w-4 h-4 text-secondary"></i> Isi Absensi
                            </button>
                            <button type="button" @click="selectTab('reports')"
                                class="w-full sm:w-auto min-h-[44px] bg-secondary hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                                <i data-lucide="file-plus" class="w-4 h-4"></i> Tambah Logbook
                            </button>
                        </div>
                    </div>

                    <!-- 3 Kartu Statistik Dashboard -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Kehadiran Total</div>
                                <div class="text-2xl font-bold text-slate-900 tabular-nums">
                                    {{ $totalKehadiran }} <span class="text-sm font-semibold text-slate-500">Hari</span>
                                </div>
                                <div class="text-xs text-emerald-700 font-semibold flex items-center gap-1">
                                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> {{ $persenKehadiran }}% Kehadiran Valid
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-secondary flex items-center justify-center shrink-0">
                                <i data-lucide="calendar" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Logbook Dikirim</div>
                                <div class="text-2xl font-bold text-slate-900 tabular-nums">
                                    {{ $totalLogbook }} <span class="text-sm font-semibold text-slate-500">Entri</span>
                                </div>
                                <div class="text-xs text-secondary font-semibold flex items-center gap-1">
                                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Semua Tepat Waktu
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-third flex items-center justify-center shrink-0">
                                <i data-lucide="book-open" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Status Validasi</div>
                                <div class="text-xl font-bold text-emerald-700 pt-0.5">Terverifikasi</div>
                                <div class="text-xs text-slate-500 font-medium">Oleh Pembimbing DUDI</div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Aktivitas Terbaru -->
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-4">
                        <div class="flex justify-between items-center gap-2">
                            <h3 class="font-bold text-base sm:text-lg text-slate-900 flex items-center gap-2">
                                <i data-lucide="activity" class="w-4 h-4 text-secondary"></i> Aktivitas Terbaru Hari Ini
                            </h3>
                            <button type="button" @click="selectTab('reports')"
                                class="min-h-[36px] text-xs sm:text-sm font-semibold text-secondary hover:underline flex items-center gap-1 cursor-pointer">
                                Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>

                        @if (isset($latestLogbook) && $latestLogbook)
                            <div class="p-4 sm:p-5 rounded-xl bg-slate-50 space-y-4">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-secondary text-white flex items-center justify-center shrink-0">
                                            <i data-lucide="wrench" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm sm:text-base font-bold text-slate-900 capitalize">{{ $latestLogbook->judul_kegiatan }}</h4>
                                            <span class="text-xs text-slate-500">{{ $user->tempat_dudi ?? 'PT. Ciptadra Softindo' }} (DUDI)</span>
                                        </div>
                                    </div>

                                    <div>
                                        @if ($latestLogbook->status == 'Approved')
                                            <span class="inline-flex items-center gap-1.5 text-emerald-700 text-xs sm:text-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                            </span>
                                        @elseif($latestLogbook->status == 'Revisi')
                                            <span class="inline-flex items-center gap-1.5 text-rose-700 text-xs sm:text-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Revisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-amber-700 text-xs sm:text-sm font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-white p-4 rounded-xl">
                                    {{ $latestLogbook->deskripsi }}
                                </p>

                                @if ($latestLogbook->catatan_mentor)
                                    <div class="bg-blue-50 p-3.5 rounded-xl flex items-start gap-2.5 text-slate-800 text-xs sm:text-sm">
                                        <i data-lucide="message-square-quote" class="w-4 h-4 text-secondary shrink-0 mt-0.5"></i>
                                        <div>
                                            <strong class="font-bold text-primary">Catatan Mentor:</strong>
                                            {{ $latestLogbook->catatan_mentor }}
                                        </div>
                                    </div>
                                @endif

                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-slate-500 gap-1 font-medium">
                                    <span class="flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                        {{ \Carbon\Carbon::parse($latestLogbook->tanggal)->format('d F Y') }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        {{ $latestLogbook->jam_kerja }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="p-6 text-center text-slate-500 text-sm bg-slate-50 rounded-xl">
                                Belum ada aktivitas yang dicatat hari ini. Silakan buat entri logbook baru melalui menu Reports.
                            </div>
                        @endif
                    </div>

                    <!-- Kartu Status Nilai Akhir & Sertifikat PKL -->
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-5">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div>
                                <h3 class="font-bold text-base sm:text-lg text-slate-900 flex items-center gap-2">
                                    <i data-lucide="award" class="w-4 h-4 text-secondary"></i> Rekap Penilaian Akhir &amp; Sertifikat PKL
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500">Sistem penilaian ganda: Nilai Industri DUDI (60%) dan Nilai Laporan Sekolah (40%).</p>
                            </div>
                            @if(isset($grade) && $grade->nilai_akhir !== null)
                                <a href="{{ route('export.sertifikat') }}"
                                    class="w-full sm:w-auto min-h-[44px] px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                                    <i data-lucide="download" class="w-4 h-4"></i> Unduh Sertifikat Resmi (.doc)
                                </a>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-slate-50 p-4 rounded-xl">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide block">Nilai DUDI (60%)</span>
                                <span class="text-xl font-bold text-slate-900 mt-1 block tabular-nums">
                                    {{ isset($grade) && $grade->nilai_dudi !== null ? number_format($grade->nilai_dudi, 1) : 'Belum Ada' }}
                                </span>
                                <span class="text-xs text-slate-500">Dari Pembimbing Lapangan</span>
                            </div>

                            <div class="bg-slate-50 p-4 rounded-xl">
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide block">Nilai Laporan (40%)</span>
                                <span class="text-xl font-bold text-slate-900 mt-1 block tabular-nums">
                                    {{ isset($grade) && $grade->nilai_laporan !== null ? number_format($grade->nilai_laporan, 1) : 'Belum Ada' }}
                                </span>
                                <span class="text-xs text-slate-500">Dari Pembimbing Sekolah</span>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-xl">
                                <span class="text-xs font-semibold text-secondary uppercase tracking-wide block">Nilai Akhir</span>
                                <span class="text-xl font-bold text-primary mt-1 block tabular-nums">
                                    {{ isset($grade) && $grade->nilai_akhir !== null ? number_format($grade->nilai_akhir, 1) : 'Menunggu' }}
                                </span>
                                <span class="text-xs text-secondary font-medium">Skala 0 - 100</span>
                            </div>

                            <div class="bg-emerald-50 p-4 rounded-xl">
                                <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wide block">Predikat</span>
                                <span class="text-xl font-bold text-emerald-800 mt-1 block">
                                    {{ isset($grade) && $grade->predikat ? $grade->predikat : '-' }}
                                </span>
                                <span class="text-xs text-emerald-700 font-medium">
                                    @if(isset($grade) && $grade->predikat === 'A') Sangat Baik
                                    @elseif(isset($grade) && $grade->predikat === 'B') Baik
                                    @elseif(isset($grade) && $grade->predikat === 'C') Cukup
                                    @elseif(isset($grade) && $grade->predikat === 'D') Kurang
                                    @else Belum Lengkap
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if(isset($grade) && $grade->catatan_mentor)
                            <div class="bg-slate-50 p-4 rounded-xl text-xs sm:text-sm text-slate-600">
                                <strong class="text-slate-800">Umpan Balik Mentor DUDI:</strong> {{ $grade->catatan_mentor }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TAB 2: ATTENDANCE -->
                <div id="tab-attendance" x-show="activeTab === 'attendance'" x-cloak class="tab-content space-y-6">

                    @php
                        $user = Auth::user();
                        $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                        $todayAttendance = App\Models\Attendance::where('user_id', $user->id)
                            ->where('tanggal', $today)
                            ->first();

                        if (!$todayAttendance) {
                            $btnText = 'Lakukan Presensi Masuk';
                            $btnAction = "openAttendance('masuk')";
                            $btnBg = 'bg-primary hover:bg-third';
                        } elseif ($todayAttendance->status == 'Izin' || $todayAttendance->status == 'Sakit') {
                            $btnText = 'Presensi Hari Ini Selesai';
                            $btnAction = "alert('Status hari ini tercatat Izin/Sakit.')";
                            $btnBg = 'bg-slate-400 cursor-not-allowed';
                        } elseif (!$todayAttendance->jam_pulang) {
                            $btnText = 'Lakukan Presensi Pulang';
                            $btnAction = "openAttendance('pulang')";
                            $btnBg = 'bg-emerald-600 hover:bg-emerald-700';
                        } else {
                            $btnText = 'Presensi Hari Ini Selesai';
                            $btnAction = "alert('Anda sudah menyelesaikan presensi masuk dan pulang hari ini.')";
                            $btnBg = 'bg-slate-400 cursor-not-allowed';
                        }

                        $allUserAttendances = App\Models\Attendance::where('user_id', $user->id)->get();
                        $totalHadir = $allUserAttendances
                            ->filter(function ($item) {
                                return $item->status == 'Hadir' || str_contains($item->status, 'Diluar');
                            })
                            ->count();

                        $totalIzinSakit = $allUserAttendances
                            ->filter(function ($item) {
                                return $item->status == 'Izin' || $item->status == 'Sakit';
                            })
                            ->count();

                        $targetHariKerja = 30;
                        $tingkatKehadiran =
                            $targetHariKerja > 0 ? min(round(($totalHadir / $targetHariKerja) * 100, 1), 100) : 0;
                    @endphp

                    <!-- HEADER SECTION & TOMBOL -->
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-1">
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900">Presensi &amp; Geotagging PKL</h3>
                            <p class="text-xs sm:text-sm text-slate-500">Penempatan DUDI: <span class="font-semibold text-secondary">{{ $user->tempat_dudi ?? 'Belum diatur di Settings' }}</span></p>
                        </div>

                        <button type="button" @click="{{ $btnAction }}"
                            class="w-full md:w-auto min-h-[44px] {{ $btnBg }} text-white text-xs sm:text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                            <i data-lucide="map-pin" class="w-4 h-4"></i> {{ $btnText }}
                        </button>
                    </div>

                    <!-- STATS CARDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Tingkat Kehadiran</span>
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-emerald-700 tabular-nums">{{ $tingkatKehadiran }}%</div>
                                <div class="text-xs sm:text-sm text-slate-500 mt-1">Total {{ $totalHadir }} Hari Masuk Tercatat</div>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Lokasi DUDI / GPS</span>
                                <div class="w-9 h-9 rounded-lg bg-blue-50 text-secondary flex items-center justify-center">
                                    <i data-lucide="crosshair" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-base font-bold text-slate-900 truncate">{{ $user->tempat_dudi ?? 'Belum diatur' }}</div>
                                <div class="text-xs sm:text-sm text-slate-500 mt-1">Radius validasi aktif (&le; 150M)</div>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Izin / Sakit</span>
                                <div class="w-9 h-9 rounded-lg bg-slate-100 text-third flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-primary tabular-nums">{{ $totalIzinSakit }} Hari</div>
                                <div class="text-xs sm:text-sm text-slate-500 mt-1">
                                    {{ $totalIzinSakit > 0 ? 'Total akumulasi izin/sakit' : 'Tidak ada catatan ketidakhadiran' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIWAYAT PRESENSI -->
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-5">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-base sm:text-lg text-slate-900">Riwayat Presensi Geotagging</h4>
                                <p class="text-xs sm:text-sm text-slate-500">Catatan log kehadiran harian di lokasi perusahaan penempatan.</p>
                            </div>
                            <button type="button" @click="allHistoryOpen = true; $nextTick(() => { if (window.lucide) lucide.createIcons(); })"
                                class="min-h-[40px] text-xs sm:text-sm font-semibold text-secondary hover:text-primary bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="list" class="w-4 h-4"></i> Semua Riwayat
                            </button>
                        </div>

                        <div class="space-y-3">
                            @php
                                $attendances = App\Models\Attendance::where('user_id', $user->id)
                                    ->orderBy('id', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp

                            <div class="space-y-3">
                                @forelse($attendances as $att)
                                    <div class="p-4 sm:p-5 rounded-xl bg-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                        <div class="flex items-start gap-3.5">
                                            <div class="w-10 h-10 rounded-xl {{ $att->status == 'Sakit' || $att->status == 'Izin' ? 'bg-amber-100 text-amber-700' : (str_contains($att->status, 'Diluar') ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700') }} flex items-center justify-center shrink-0">
                                                <i data-lucide="{{ $att->status == 'Sakit' || $att->status == 'Izin' ? 'file-text' : (str_contains($att->status, 'Diluar') ? 'alert-triangle' : 'check-circle-2') }}"
                                                    class="w-5 h-5"></i>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-3 flex-wrap">
                                                    <span class="text-sm font-bold text-slate-900">{{ $att->tanggal }}</span>

                                                    @if ($att->status == 'Izin')
                                                        <span class="inline-flex items-center gap-1.5 text-secondary text-xs sm:text-sm font-semibold">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Izin (Tidak Hadir)
                                                        </span>
                                                    @elseif ($att->status == 'Sakit')
                                                        <span class="inline-flex items-center gap-1.5 text-amber-700 text-xs sm:text-sm font-semibold">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sakit (Tidak Hadir)
                                                        </span>
                                                    @elseif (str_contains($att->status, 'Diluar'))
                                                        <span class="inline-flex items-center gap-1.5 text-rose-700 text-xs sm:text-sm font-semibold">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Diluar Radius DUDI
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 text-emerald-700 text-xs sm:text-sm font-semibold">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Hadir
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="text-xs sm:text-sm text-slate-600 flex items-center gap-1.5">
                                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-secondary shrink-0"></i>
                                                    <span class="font-medium">{{ $att->lokasi }}</span>
                                                </div>

                                                @if ($att->alasan)
                                                    <div class="text-xs {{ str_contains($att->alasan, '⚠️') ? 'text-rose-700 font-semibold' : 'text-slate-500' }}">
                                                        {{ $att->alasan }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="w-full md:w-auto flex md:flex-col justify-between items-center md:items-end gap-2 text-xs sm:text-sm font-medium text-slate-600">
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-slate-500">Masuk:</span>
                                                <span class="font-bold text-slate-800 bg-white px-2.5 py-1 rounded-lg">
                                                    {{ $att->jam_masuk ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') . ' WIB' : '-' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-slate-500">Pulang:</span>
                                                <span class="font-bold text-slate-800 bg-white px-2.5 py-1 rounded-lg">
                                                    @if ($att->status == 'Izin' || $att->status == 'Sakit')
                                                        <span class="text-slate-400 font-normal">Tidak Ada</span>
                                                    @else
                                                        {{ $att->jam_pulang ? \Carbon\Carbon::parse($att->jam_pulang)->format('H:i') . ' WIB' : 'Belum Absen' }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-slate-400 text-sm">
                                        Belum ada riwayat presensi.
                                    </div>
                                @endforelse
                            </div>

                            <!-- MODAL POP-UP PRESENSI HARIAN -->
                            <div id="attendanceModal" x-show="modalOpen" x-cloak
                                class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                                <div @click.outside="modalOpen = false"
                                    class="bg-white rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-5 shadow-2xl">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 id="modal-title" class="font-bold text-base sm:text-lg text-slate-900"
                                                x-text="modalType === 'pulang' ? 'Konfirmasi Presensi Pulang' : 'Form Presensi Harian'">Form Presensi Harian</h4>
                                            <p class="text-xs text-slate-500">Validasi lokasi DUDI dan waktu kehadiran.</p>
                                        </div>
                                        <button type="button" @click="modalOpen = false" aria-label="Tutup Modal"
                                            class="min-h-[40px] min-w-[40px] rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition cursor-pointer">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>

                                    <form action="{{ route('attendance.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="lat" id="modal-lat">
                                        <input type="hidden" name="lng" id="modal-lng">

                                        <div class="bg-slate-50 rounded-xl p-4 space-y-1.5">
                                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Penempatan DUDI Anda</span>
                                            <div id="modal-dudi-name" class="font-bold text-sm text-slate-900">{{ Auth::user()->tempat_dudi ?? 'PT Ciptadra Softindo' }}</div>
                                            <div id="modal-gps-info" class="text-xs text-slate-600 font-medium">Mendeteksi koordinat GPS...</div>
                                        </div>

                                        <div id="status-container" x-show="modalType !== 'pulang'" class="space-y-1.5">
                                            <label class="text-xs font-semibold text-slate-700 block">Status Kehadiran *</label>
                                            <select name="status" id="attendance-status" x-model="attendanceStatus"
                                                class="w-full min-h-[44px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:outline-none focus:border-secondary">
                                                <option value="Hadir">Hadir</option>
                                                <option value="Izin">Izin</option>
                                                <option value="Sakit">Sakit</option>
                                            </select>
                                        </div>

                                        <div id="alasan-container" x-show="modalType !== 'pulang' && (attendanceStatus === 'Izin' || attendanceStatus === 'Sakit')" x-cloak class="space-y-1.5">
                                            <label class="text-xs font-semibold text-slate-700 block">Keterangan / Alasan</label>
                                            <input type="text" name="alasan" placeholder="Tulis alasan izin atau sakit..."
                                                class="w-full min-h-[44px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium text-slate-800 focus:outline-none focus:border-secondary">
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 text-xs">
                                            <div class="space-y-1">
                                                <label class="font-semibold text-slate-500 block">Tanggal</label>
                                                <input type="text" id="realtime-date"
                                                    class="w-full min-h-[40px] bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm font-bold text-slate-700"
                                                    readonly>
                                            </div>
                                            <div class="space-y-1">
                                                <label class="font-semibold text-slate-500 block">Waktu Saat Ini</label>
                                                <input type="text" id="realtime-clock"
                                                    class="w-full min-h-[40px] bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs sm:text-sm font-bold text-slate-700"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-2">
                                            <button type="button" @click="modalOpen = false"
                                                class="min-h-[44px] px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs sm:text-sm transition cursor-pointer">Batal</button>
                                            <button type="submit"
                                                class="min-h-[44px] px-5 py-2 bg-secondary hover:bg-blue-700 text-white font-semibold rounded-xl text-xs sm:text-sm shadow-sm transition cursor-pointer">Kirim Presensi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- MODAL POP-UP SEMUA RIWAYAT PRESENSI -->
                            <div id="allHistoryModal" x-show="allHistoryOpen" x-cloak
                                class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                                <div @click.outside="allHistoryOpen = false"
                                    class="bg-white rounded-2xl max-w-2xl w-full p-5 sm:p-6 space-y-5 shadow-2xl max-h-[85vh] flex flex-col">
                                    <div class="flex justify-between items-center shrink-0">
                                        <div>
                                            <h4 class="font-bold text-base sm:text-lg text-slate-900">Semua Riwayat Presensi Geotagging</h4>
                                            <p class="text-xs text-slate-500">Draf lengkap catatan kehadiran dan log lokasi PKL Anda.</p>
                                        </div>
                                        <button type="button" @click="allHistoryOpen = false" aria-label="Tutup Riwayat"
                                            class="min-h-[40px] min-w-[40px] rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition cursor-pointer">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>

                                    <div class="overflow-y-auto space-y-3 pr-1 flex-1">
                                        @php
                                            $allAttendances = App\Models\Attendance::where('user_id', $user->id)
                                                ->orderBy('tanggal', 'desc')
                                                ->orderBy('id', 'desc')
                                                ->get();
                                        @endphp

                                        @forelse($allAttendances as $item)
                                            <div class="p-4 rounded-xl bg-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-3 flex-wrap">
                                                        <span class="text-xs sm:text-sm font-bold text-slate-900">{{ $item->tanggal }}</span>
                                                        @if ($item->status == 'Izin')
                                                            <span class="inline-flex items-center gap-1.5 text-secondary text-xs font-semibold">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Izin (Tidak Hadir)
                                                            </span>
                                                        @elseif ($item->status == 'Sakit')
                                                            <span class="inline-flex items-center gap-1.5 text-amber-700 text-xs font-semibold">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sakit (Tidak Hadir)
                                                            </span>
                                                        @elseif (str_contains($item->status, 'Diluar'))
                                                            <span class="inline-flex items-center gap-1.5 text-rose-700 text-xs font-semibold">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Diluar Radius DUDI
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center gap-1.5 text-emerald-700 text-xs font-semibold">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Hadir
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-slate-600 flex items-center gap-1.5">
                                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-secondary"></i>
                                                        {{ $item->lokasi }}
                                                    </div>
                                                    @if ($item->alasan)
                                                        <div class="text-xs {{ str_contains($item->alasan, '⚠️') ? 'text-rose-700 font-semibold' : 'text-slate-500' }}">
                                                            {{ $item->alasan }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-xs font-semibold text-slate-700 bg-white px-3 py-2 rounded-xl flex gap-3 shrink-0">
                                                    <div>Masuk: <span class="text-emerald-700 font-bold">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</span></div>
                                                    <div>Pulang: <span class="text-secondary font-bold">{{ $item->jam_pulang && $item->status != 'Izin' && $item->status != 'Sakit' ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : 'Selesai' }}</span></div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-8 text-slate-400 text-sm">Belum ada data riwayat absensi sama sekali.</div>
                                        @endforelse
                                    </div>

                                    <div class="flex justify-end pt-2 shrink-0">
                                        <button type="button" @click="allHistoryOpen = false"
                                            class="min-h-[44px] px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs sm:text-sm transition cursor-pointer">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: REPORTS & LOGBOOK -->
                <div id="tab-reports" x-show="activeTab === 'reports'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Daftar Logbook &amp; Laporan Kegiatan</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Semua catatan kegiatan harian yang telah dikirimkan ke pembimbing.</p>
                            </div>
                            <a href="/dashboard/siswa/logbook/create"
                                class="w-full sm:w-auto min-h-[44px] bg-secondary text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                + Entri Baru
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($logbooks as $logbook)
                                <div class="bg-slate-50 p-4 rounded-xl flex flex-col sm:flex-row justify-between items-start gap-4">
                                    <div class="space-y-1.5">
                                        <h4 class="font-bold text-slate-900 text-sm sm:text-base">{{ $logbook->judul_kegiatan }}</h4>
                                        <p class="text-xs sm:text-sm text-slate-600">{{ $logbook->deskripsi }}</p>
                                        <p class="text-xs text-slate-500">
                                            {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d F Y') }} &bull; {{ $logbook->jam_kerja }}
                                        </p>

                                        @if ($logbook->catatan_mentor)
                                            <div class="mt-2 p-3 bg-blue-50 rounded-lg text-xs sm:text-sm text-primary">
                                                <strong>Catatan Mentor:</strong> {{ $logbook->catatan_mentor }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-2 shrink-0">
                                        @if ($logbook->status == 'Approved')
                                            <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                            </span>
                                        @elseif($logbook->status == 'Revisi')
                                            <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-rose-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Revisi
                                            </span>
                                            <details class="text-right">
                                                <summary class="cursor-pointer text-xs font-semibold text-secondary hover:underline">
                                                    Perbaiki Logbook
                                                </summary>
                                                <div class="mt-2 text-left p-4 bg-white rounded-xl w-72 sm:w-96 shadow-lg z-20 relative">
                                                    <form action="{{ route('siswa.logbook.update', $logbook->id) }}" method="POST" class="space-y-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <h5 class="font-bold text-sm text-primary">Perbaiki &amp; Ajukan Ulang Jurnal</h5>
                                                        <div>
                                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal</label>
                                                            <input type="date" name="tanggal" value="{{ $logbook->tanggal }}" required
                                                                class="w-full min-h-[40px] text-xs sm:text-sm px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Jam Kerja</label>
                                                            <input type="text" name="jam_kerja" value="{{ $logbook->jam_kerja }}" required
                                                                class="w-full min-h-[40px] text-xs sm:text-sm px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Judul Kegiatan</label>
                                                            <input type="text" name="judul_kegiatan" value="{{ $logbook->judul_kegiatan }}" required
                                                                class="w-full min-h-[40px] text-xs sm:text-sm px-3 py-2 border border-slate-200 rounded-lg bg-white">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Kegiatan</label>
                                                            <textarea name="deskripsi" rows="3" required
                                                                class="w-full text-xs sm:text-sm px-3 py-2 border border-slate-200 rounded-lg bg-white">{{ $logbook->deskripsi }}</textarea>
                                                        </div>
                                                        <button type="submit" class="w-full min-h-[44px] py-2 bg-secondary hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-lg transition cursor-pointer">
                                                            Simpan &amp; Kirim Ulang
                                                        </button>
                                                    </form>
                                                </div>
                                            </details>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-amber-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-400 text-sm">
                                    Belum ada logbook yang diisi. Klik tombol <strong>+ Entri Baru</strong> untuk menambah catatan harian.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- TAB 4: SETTINGS -->
                <div id="tab-settings" x-show="activeTab === 'settings'" x-cloak class="tab-content space-y-6 max-w-4xl mx-auto">

                    @if (session('success'))
                        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl text-xs sm:text-sm font-semibold">
                            <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Header Pengaturan -->
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-primary text-white flex-shrink-0 flex items-center justify-center font-bold text-xl">
                            {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}
                        </div>
                        <div class="space-y-1 flex-1">
                            <h3 class="text-lg font-bold text-slate-900">{{ Auth::user()->name ?? 'Siswa' }}</h3>
                            <p class="text-xs sm:text-sm font-medium text-slate-600">Siswa Praktikan &bull; SMKN 1 Depok</p>
                            <p class="text-xs sm:text-sm text-secondary">{{ Auth::user()->email ?? 'siswa@smkn1depok.sch.id' }}</p>
                        </div>
                    </div>

                    <!-- Sub-Navigasi Settings -->
                    <div class="inline-flex w-full sm:w-auto bg-slate-200/70 p-1 rounded-xl gap-1 overflow-x-auto">
                        <button type="button" @click="activeSub = 'profile'; $nextTick(() => ensureDudiMapReady())" id="btn-set-profile"
                            :class="activeSub === 'profile' ? 'bg-white text-primary font-semibold shadow-sm' : 'text-slate-600 hover:text-primary font-medium'"
                            class="flex-1 sm:flex-none min-h-[44px] settings-sub-btn px-4 py-2 rounded-lg text-xs sm:text-sm transition whitespace-nowrap cursor-pointer">Informasi Profil</button>
                        <button type="button" @click="activeSub = 'security'" id="btn-set-security"
                            :class="activeSub === 'security' ? 'bg-white text-primary font-semibold shadow-sm' : 'text-slate-600 hover:text-primary font-medium'"
                            class="flex-1 sm:flex-none min-h-[44px] settings-sub-btn px-4 py-2 rounded-lg text-xs sm:text-sm transition whitespace-nowrap cursor-pointer">Keamanan &amp; Sandi</button>
                    </div>

                    <!-- Panel 1: Profil & Peta Lokasi DUDI -->
                    <div id="settings-panel-profile" x-show="activeSub === 'profile'"
                        class="settings-panel bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <h4 class="font-bold text-base text-slate-900 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-secondary"></i> Detail Data &amp; Titik Koordinat PKL Siswa
                        </h4>

                        <form action="{{ route('siswa.profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Departemen / Kompetensi Keahlian</label>
                                    <input type="text" value="{{ Auth::user()->departemen ?? 'PPLG' }}"
                                        class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-medium"
                                        disabled>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Nomor Induk Siswa (NIS)</label>
                                    <input type="text" value="{{ Auth::user()->nis ?? '-' }}"
                                        class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-medium"
                                        disabled>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">NISN (Nasional)</label>
                                    <input type="text" value="{{ Auth::user()->nisn ?? '-' }}"
                                        class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-medium"
                                        disabled>
                                </div>
                                <div class="space-y-1.5 sm:col-span-3">
                                    <label class="text-xs font-semibold text-slate-700 block">Nomor WhatsApp / Kontak Aktif Siswa</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full min-h-[44px] bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-semibold focus:outline-none focus:border-secondary">
                                    <p class="text-xs text-slate-500">Nomor ini digunakan oleh Pembimbing Sekolah &amp; DUDI untuk koordinasi dan monitoring bimbingan.</p>
                                </div>

                                <div class="space-y-1.5 sm:col-span-3">
                                    <div class="flex items-center justify-between gap-2">
                                        <label class="text-xs font-semibold text-slate-600 block">Tempat DUDI (Dunia Usaha / Dunia Industri)</label>
                                        <span class="text-xs text-secondary font-semibold">Penempatan Resmi Hubin</span>
                                    </div>
                                    <input type="text" value="{{ Auth::user()->tempat_dudi ?? 'Belum Diplotting' }}"
                                        class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-medium"
                                        disabled>
                                    <p class="text-xs text-slate-500">Penempatan DUDI dan koordinat geofence presensi resmi dikelola terpusat oleh Pokja Hubin demi integritas sistem.</p>
                                </div>

                                <input type="hidden" id="input-lat" name="dudi_lat" value="{{ Auth::user()->dudi_lat ?? -6.4025 }}">
                                <input type="hidden" id="input-lng" name="dudi_lng" value="{{ Auth::user()->dudi_lng ?? 106.8186 }}">
                            </div>

                            <!-- Wadah Peta & Search Bar -->
                            <div class="space-y-3 pt-2">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                    <label class="text-xs sm:text-sm font-semibold text-slate-700">Titik Koordinat Lokasi DUDI Terdaftar</label>
                                    <button type="button" onclick="useCurrentLocation()"
                                        class="min-h-[40px] px-3.5 py-2 bg-blue-50 text-secondary hover:bg-blue-100 font-semibold rounded-xl transition flex items-center gap-1.5 text-xs cursor-pointer">
                                        <i data-lucide="crosshair" class="w-4 h-4"></i> Cek Lokasi Saya Saat Ini
                                    </button>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2">
                                    <div class="relative flex-1">
                                        <input type="text" id="map-search-input"
                                            placeholder="Ketik nama tempat/perusahaan (contoh: Ciptadra Softindo)..."
                                            class="w-full min-h-[44px] bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-medium focus:outline-none focus:border-secondary">
                                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                                    </div>
                                    <button type="button" onclick="searchLocation()"
                                        class="min-h-[44px] px-5 py-2.5 bg-primary hover:bg-third text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition flex items-center justify-center gap-1.5 shrink-0 cursor-pointer">
                                        Cari Lokasi
                                    </button>
                                </div>

                                <div id="dudiMap" class="w-full h-80 rounded-xl z-10"></div>
                                <p class="text-xs text-slate-500">Titik radius presensi GPS siswa diverifikasi berdasarkan koordinat kantor industri resmi di atas.</p>
                            </div>

                            <div class="pt-3 flex justify-end">
                                <button type="submit"
                                    class="w-full sm:w-auto min-h-[44px] bg-secondary hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                                    Simpan Perubahan Kontak Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Panel 2: Security (Keamanan & Sandi) -->
                    <div id="settings-panel-security" x-show="activeSub === 'security'" x-cloak
                        class="settings-panel bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <h4 class="font-bold text-base text-slate-900 flex items-center gap-2">
                            <i data-lucide="key-round" class="w-4 h-4 text-secondary"></i> Pengaturan Sandi &amp; Keamanan
                        </h4>

                        <form action="{{ route('siswa.password.update') }}" method="POST" class="space-y-4 max-w-xl">
                            @csrf
                            @method('PUT')

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700 block">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" placeholder="••••••••" required
                                    class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700 block">Kata Sandi Baru</label>
                                <input type="password" name="new_password" placeholder="Minimal 8 karakter" required
                                    class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700 block">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="new_password_confirmation" placeholder="Ulangi kata sandi baru" required
                                    class="w-full min-h-[44px] bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-secondary">
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button type="submit"
                                    class="w-full sm:w-auto min-h-[44px] bg-secondary hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                                    Perbarui Sandi
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <!-- Script GPS Geolocation, Jam Realtime & Peta Leaflet -->
    <script>
        function initAttendanceModalGps(type) {
            updateRealtimeClock();
            const gpsInfo = document.getElementById('modal-gps-info');

            if (navigator.geolocation) {
                if (gpsInfo) {
                    gpsInfo.innerHTML = '<span class="inline-flex items-center gap-1.5 text-secondary font-medium"><i data-lucide="loader" class="w-3.5 h-3.5 animate-spin"></i> Mengunci koordinat GPS perangkat Anda...</span>';
                    if (window.lucide) lucide.createIcons();
                }

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        const acc = Math.round(pos.coords.accuracy);

                        const latInput = document.getElementById('modal-lat');
                        const lngInput = document.getElementById('modal-lng');
                        if (latInput) latInput.value = lat.toFixed(6);
                        if (lngInput) lngInput.value = lng.toFixed(6);

                        const dudiLat = {{ $user->dudi_lat ?? -6.4025 }};
                        const dudiLng = {{ $user->dudi_lng ?? 106.8186 }};

                        const R = 6371000;
                        const dLat = (lat - dudiLat) * Math.PI / 180;
                        const dLon = (lng - dudiLng) * Math.PI / 180;
                        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(dudiLat * Math.PI / 180) * Math.cos(lat * Math.PI / 180) *
                            Math.sin(dLon / 2) * Math.sin(dLon / 2);
                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        const distance = Math.round(R * c);

                        if (gpsInfo) {
                            if (distance <= 150) {
                                gpsInfo.innerHTML =
                                    `<span class="text-emerald-700 font-bold block">Lokasi Valid (Dalam Radius DUDI)</span>
                                     <span class="text-xs text-slate-500">Jarak: <strong>${distance} meter</strong> (Akurasi GPS ±${acc}m)</span>`;
                            } else {
                                gpsInfo.innerHTML =
                                    `<span class="text-amber-700 font-bold block">Diluar Radius Kantor DUDI (&gt;150m)</span>
                                     <span class="text-xs text-slate-500">Jarak Anda: <strong>${distance} meter</strong> dari kantor (Akurasi ±${acc}m)</span>`;
                            }
                        }
                    },
                    (err) => {
                        let errMsg = "Gagal mendeteksi lokasi GPS. Pastikan izin lokasi aktif.";
                        if (err.code === 1) errMsg = "Akses lokasi ditolak browser. Harap izinkan GPS pada peramban Anda.";
                        else if (err.code === 2) errMsg = "Posisi GPS tidak tersedia. Pastikan perangkat memiliki koneksi & sinyal GPS.";
                        else if (err.code === 3) errMsg = "Waktu deteksi GPS habis. Silakan coba kembali.";

                        if (gpsInfo) {
                            gpsInfo.innerHTML = `<span class="text-rose-700 font-semibold">${errMsg}</span>`;
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else if (gpsInfo) {
                gpsInfo.innerText = "Browser Anda tidak mendukung Geolocation.";
            }
        }

        function updateRealtimeClock() {
            const now = new Date();
            const dateEl = document.getElementById('realtime-date');
            const clockEl = document.getElementById('realtime-clock');

            if (dateEl) {
                dateEl.value = now.toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            if (clockEl) {
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                clockEl.value = `${hours}:${minutes}:${seconds} WIB`;
            }
        }

        setInterval(() => {
            const modal = document.getElementById('attendanceModal');
            if (modal && getComputedStyle(modal).display !== 'none') {
                updateRealtimeClock();
            }
        }, 1000);

        // ==========================================
        // PETA LEAFLET & GEOFENCE RADIUS DI SETTINGS
        // ==========================================
        let map = null;
        let marker = null;
        let geofenceCircle = null;

        function initDudiMap() {
            const mapContainer = document.getElementById('dudiMap');
            if (!mapContainer || typeof L === 'undefined') return;

            const initialLat = parseFloat(document.getElementById('input-lat').value) || -6.4025;
            const initialLng = parseFloat(document.getElementById('input-lng').value) || 106.8186;

            if (!map) {
                map = L.map('dudiMap', {
                    scrollWheelZoom: false
                }).setView([initialLat, initialLng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                marker = L.marker([initialLat, initialLng]).addTo(map);
                marker.bindPopup('<b>Kantor DUDI Resmi</b><br>{{ Auth::user()->tempat_dudi ?? "Mitra Industri" }}').openPopup();

                geofenceCircle = L.circle([initialLat, initialLng], {
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.15,
                    weight: 2,
                    dashArray: '5, 5',
                    radius: 150
                }).addTo(map);
                geofenceCircle.bindPopup('<b>Radius Presensi Valid (150m)</b><br>Presensi di dalam lingkaran ini berstatus Hadir.');

                setTimeout(() => {
                    if (map) map.invalidateSize(true);
                }, 250);
            } else {
                map.invalidateSize(true);
                map.setView([initialLat, initialLng], 15);
                if (marker) marker.setLatLng([initialLat, initialLng]);
                if (geofenceCircle) geofenceCircle.setLatLng([initialLat, initialLng]);
            }
        }

        function ensureDudiMapReady() {
            setTimeout(() => {
                const mapContainer = document.getElementById('dudiMap');
                if (!mapContainer || mapContainer.offsetParent === null) return;

                if (!map) {
                    initDudiMap();
                } else {
                    map.invalidateSize(true);
                    const lat = parseFloat(document.getElementById('input-lat').value) || -6.4025;
                    const lng = parseFloat(document.getElementById('input-lng').value) || 106.8186;
                    map.setView([lat, lng], 15);
                    if (marker) marker.setLatLng([lat, lng]);
                    if (geofenceCircle) geofenceCircle.setLatLng([lat, lng]);
                }
            }, 150);
        }

        function searchLocation() {
            const query = document.getElementById('map-search-input').value.trim();
            if (!query) {
                alert('Mohon masukkan nama tempat atau perusahaan yang ingin dicari.');
                return;
            }

            let searchQuery = query;
            if (query.toLowerCase().includes('ciptadra')) {
                searchQuery = 'Jl. Margonda Raya, Pancoran Mas, Depok';
            } else if (!query.toLowerCase().includes('depok')) {
                searchQuery = query + ', Depok';
            }

            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);

                        document.getElementById('input-lat').value = lat.toFixed(6);
                        document.getElementById('input-lng').value = lon.toFixed(6);

                        if (map) {
                            map.flyTo([lat, lon], 16, { duration: 1.5 });
                            if (marker) marker.setLatLng([lat, lon]);
                            if (geofenceCircle) geofenceCircle.setLatLng([lat, lon]);
                        }
                    } else {
                        alert('Lokasi tidak ditemukan di peta publik. Coba kata kunci lain atau nama jalan.');
                    }
                })
                .catch(error => {
                    console.error('Error searching location:', error);
                    alert('Terjadi kendala jaringan saat mencari lokasi.');
                });
        }

        function useCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;

                    document.getElementById('input-lat').value = lat.toFixed(6);
                    document.getElementById('input-lng').value = lng.toFixed(6);

                    if (map) {
                        map.flyTo([lat, lng], 16, { duration: 1.5 });
                        if (marker) marker.setLatLng([lat, lng]);
                        if (geofenceCircle) geofenceCircle.setLatLng([lat, lng]);
                    }
                }, (err) => {
                    alert('Gagal mendeteksi lokasi GPS Anda: ' + err.message);
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                alert('Browser tidak mendukung Geolocation.');
            }
        }
    </script>
</body>

</html>
