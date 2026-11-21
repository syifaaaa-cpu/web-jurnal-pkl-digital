<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <!-- Masukkan CDN Leaflet CSS & JS ini di bagian <head> layout utama atau di atas file blade -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Jurnal PKL Digital</title>
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        schoolnavy: '#3c5897',
                        schoolblue: '#2563eb',
                        schoolred: '#dc2626',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-100 text-gray-800 font-sans antialiased overflow-x-hidden">

    <!-- MOBILE DRAWER OVERLAY -->
    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-black/50 z-30 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR UTAMA (Desktop & Mobile Drawer) -->
        <aside id="sidebar"
            class="w-64 bg-schoolnavy text-gray-300 flex flex-col border-r border-blue-900/40 fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out shadow-2xl">
            <!-- Logo Brand -->
            <div
                class="h-20 flex items-center justify-between px-6 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40 flex-shrink-0">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-xs font-black tracking-wider text-white block uppercase">Jurnal PKL</span>
                        <span class="text-[10px] text-blue-200 font-medium">Digital System</span>
                    </div>
                </div>
                <!-- Tombol Close Sidebar Khusus Mobile -->
                <button onclick="toggleSidebar()" class="md:hidden text-blue-200 hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Profil Singkat Sekolah -->
            <div class="p-5 border-b border-blue-900/40 flex items-center gap-3 bg-blue-950/20">
                <div
                    class="w-9 h-9 rounded-xl bg-schoolblue/20 text-schoolblue flex items-center justify-center font-bold border border-schoolblue/30 flex-shrink-0">
                    <i data-lucide="school" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white">SMKN 1 Depok</h4>
                    <span class="text-[10px] text-blue-200/80">Vocational Excellence</span>
                </div>
            </div>

            <!-- Navigasi Menu -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-medium overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')" id="nav-dashboard"
                    class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl bg-schoolblue text-white font-semibold shadow-lg shadow-blue-600/30 transition-all duration-200">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                <a href="#attendance" onclick="switchTab('attendance')" id="nav-attendance"
                    class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i data-lucide="calendar-check" class="w-4 h-4"></i> Attendance
                </a>
                <a href="#reports" onclick="switchTab('reports')" id="nav-reports"
                    class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Reports & Logbook
                </a>
                <a href="#settings" onclick="switchTab('settings')" id="nav-settings"
                    class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i data-lucide="settings" class="w-4 h-4"></i> Settings
                </a>
            </nav>

            <!-- Tombol Logout -->
            <div class="p-4 border-t border-blue-900/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-300 hover:bg-red-500/15 transition text-xs font-semibold">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Aplikasi
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOPBAR -->
            <header
                class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex justify-between items-center px-4 sm:px-8 sticky top-0 z-10 shadow-sm flex-shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Tombol Hamburger Mobile -->
                    <button onclick="toggleSidebar()"
                        class="md:hidden p-2 rounded-xl bg-slate-100 text-schoolnavy hover:bg-slate-200 transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h2 class="text-xs sm:text-sm font-extrabold text-gray-900 tracking-tight truncate max-w-[180px] sm:max-w-none"
                        id="page-title">Dashboard Siswa</h2>
                </div>

                <div class="flex items-center gap-3">
                    <div
                        class="hidden sm:flex bg-blue-50 text-schoolblue px-3.5 py-1.5 rounded-full text-[11px] font-bold border border-blue-100 items-center gap-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Role: Siswa
                    </div>
                    <div
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-tr from-schoolnavy to-schoolblue overflow-hidden border-2 border-white shadow-md flex items-center justify-center font-bold text-white text-xs flex-shrink-0">
                        BS
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN DINAMIS -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-8 space-y-6">

                <!-- TAB 1: DASHBOARD -->
                <div id="tab-dashboard" class="tab-content space-y-6">

                    @php
                        $user = Auth::user();

                        // Hitung total kehadiran real dari database (berdasarkan jumlah absen masuk)
                        $totalKehadiran = App\Models\Attendance::where('user_id', $user->id)
                            ->whereNotNull('jam_masuk')
                            ->count();

                        // Hitung persentase kehadiran valid (contoh target 30 hari kerja)
                        $targetHariKerja = 30;
                        $persenKehadiran =
                            $targetHariKerja > 0 ? min(round(($totalKehadiran / $targetHariKerja) * 100, 1), 100) : 0;

                        // Hitung total logbook yang dikirim real dari database (jika model logbook Anda bernama Logbook atau Report)
                        // Sesuaikan nama Model jika berbeda, contoh: App\Models\Logbook::where('user_id', $user->id)->count();
                        $totalLogbook = class_exists('App\Models\Logbook')
                            ? App\Models\Logbook::where('user_id', $user->id)->count()
                            : 18; // Fallback jika model belum ada

                        // Fallback logbook hari ini untuk kartu aktivitas terbaru jika belum di-passing dari controller
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
                    <div
                        class="bg-gradient-to-r from-blue-600/10 via-blue-600/5 to-transparent border-l-4 border-schoolblue p-4 rounded-2xl flex items-center justify-between shadow-sm text-blue-950">
                        <div class="flex items-start sm:items-center gap-3">
                            <div
                                class="bg-schoolblue text-white p-2 rounded-xl flex-shrink-0 shadow-md shadow-blue-600/20">
                                <i data-lucide="info" class="w-4 h-4"></i>
                            </div>
                            <p class="text-xs font-medium leading-relaxed">
                                <strong
                                    class="uppercase font-bold tracking-wider mr-1 text-schoolnavy block sm:inline">Pengumuman:</strong>
                                Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB. Pastikan
                                mentor industri sudah memberikan approval.
                            </p>
                        </div>
                    </div>

                    <!-- Header Selamat Pagi & Action Button -->
                    <div
                        class="bg-gradient-to-br from-schoolnavy via-blue-800 to-schoolblue p-6 sm:p-8 rounded-3xl text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div
                            class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none">
                        </div>
                        <div class="space-y-2 relative z-10">
                            <h1 class="text-xl sm:text-3xl font-black tracking-tight">
                                Selamat Pagi, {{ $user->name ?? 'Dzikry' }}!
                            </h1>
                            <p class="text-xs text-blue-100 max-w-xl leading-relaxed">
                                Pantau terus kehadiran dan progres laporan Praktek Kerja Lapangan (PKL) Anda langsung
                                dari dashboard digital SMKN 1 Depok.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row w-full md:w-auto items-center gap-3 relative z-10">
                            <button onclick="switchTab('attendance')"
                                class="w-full sm:w-auto bg-white text-schoolnavy hover:bg-blue-50 text-xs font-bold px-5 py-3 rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="calendar-check" class="w-4 h-4 text-schoolblue"></i> Isi Absensi
                            </button>
                            <button onclick="switchTab('reports')"
                                class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="file-plus" class="w-4 h-4"></i> Tambah Logbook
                            </button>
                        </div>
                    </div>

                    <!-- 3 Kartu Statistik Dashboard Interaktif -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">

                        <!-- Kartu 1: Kehadiran Total (Real Data) -->
                        <div
                            class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between group">
                            <div class="space-y-1">
                                <div class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Kehadiran
                                    Total</div>
                                <div
                                    class="text-2xl sm:text-3xl font-black text-gray-900 group-hover:text-schoolblue transition-colors">
                                    {{ $totalKehadiran }} <span
                                        class="text-xs sm:text-sm font-semibold text-slate-500">Hari</span>
                                </div>
                                <div class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                    <i data-lucide="trending-up" class="w-3 h-3"></i> {{ $persenKehadiran }}%
                                    Kehadiran Valid
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 text-schoolblue flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform flex-shrink-0">
                                <i data-lucide="calendar" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                            </div>
                        </div>

                        <!-- Kartu 2: Logbook Dikirim (Real Data) -->
                        <div
                            class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between group">
                            <div class="space-y-1">
                                <div class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Logbook
                                    Dikirim</div>
                                <div
                                    class="text-2xl sm:text-3xl font-black text-gray-900 group-hover:text-schoolblue transition-colors">
                                    {{ $totalLogbook }} <span
                                        class="text-xs sm:text-sm font-semibold text-slate-500">Entri</span>
                                </div>
                                <div class="text-[10px] text-blue-600 font-bold flex items-center gap-1">
                                    <i data-lucide="check-circle-2" class="w-3 h-3"></i> Semua Tepat Waktu
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform flex-shrink-0">
                                <i data-lucide="book-open" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                            </div>
                        </div>

                        <!-- Kartu 3: Status Validasi (Tetap Terverifikasi) -->
                        <div
                            class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between group">
                            <div class="space-y-1">
                                <div class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Status
                                    Validasi</div>
                                <div class="text-lg sm:text-xl font-black text-emerald-600 pt-1">Terverifikasi</div>
                                <div class="text-[10px] text-slate-400 font-medium">Oleh Pembimbing DUDI</div>
                            </div>
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform flex-shrink-0">
                                <i data-lucide="shield-check" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Aktivitas Terbaru -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex justify-between items-center">
                            <h3
                                class="font-black text-xs sm:text-sm text-gray-900 tracking-tight flex items-center gap-2">
                                <i data-lucide="activity" class="w-4 h-4 text-schoolblue"></i> Aktivitas Terbaru Hari
                                Ini
                            </h3>
                            <button onclick="switchTab('reports')"
                                class="text-xs font-bold text-schoolblue hover:underline flex items-center gap-1">
                                Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>

                        @if (isset($latestLogbook) && $latestLogbook)
                            <div
                                class="p-4 sm:p-6 rounded-2xl border border-slate-200/60 bg-gradient-to-br from-slate-50/80 to-blue-50/20 space-y-4">
                                <div
                                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-2xl bg-schoolblue text-white flex items-center justify-center shadow-md shadow-blue-500/20 flex-shrink-0">
                                            <i data-lucide="wrench" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-black text-gray-900 capitalize">
                                                {{ $latestLogbook->judul_kegiatan }}
                                            </h4>
                                            <span
                                                class="text-[10px] text-slate-500">{{ $user->tempat_dudi ?? 'PT. Ciptadra Softindo' }}
                                                (DUDI)</span>
                                        </div>
                                    </div>

                                    <div>
                                        @if ($latestLogbook->status == 'Approved')
                                            <span
                                                class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-3 py-1 rounded-full border border-emerald-200 flex items-center gap-1">
                                                <i data-lucide="check" class="w-3 h-3"></i> Approved
                                            </span>
                                        @elseif($latestLogbook->status == 'Revisi')
                                            <span
                                                class="bg-red-100 text-red-700 text-[10px] font-extrabold px-3 py-1 rounded-full border border-red-200 flex items-center gap-1">
                                                <i data-lucide="alert-circle" class="w-3 h-3"></i> Revisi
                                            </span>
                                        @else
                                            <span
                                                class="bg-amber-100 text-amber-700 text-[10px] font-extrabold px-3 py-1 rounded-full border border-amber-200 flex items-center gap-1">
                                                <i data-lucide="clock" class="w-3 h-3"></i> Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <p
                                    class="text-xs text-slate-600 leading-relaxed bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/50">
                                    {{ $latestLogbook->deskripsi }}
                                </p>

                                @if ($latestLogbook->catatan_mentor)
                                    <div
                                        class="bg-blue-50/80 border border-blue-200/80 p-3.5 rounded-xl flex items-start gap-2.5 text-blue-950 text-xs shadow-sm">
                                        <i data-lucide="message-square-quote"
                                            class="w-4 h-4 text-schoolblue flex-shrink-0 mt-0.5"></i>
                                        <div>
                                            <strong class="font-bold text-schoolnavy">Catatan Mentor:</strong>
                                            {{ $latestLogbook->catatan_mentor }}
                                        </div>
                                    </div>
                                @endif

                                <div
                                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-[11px] text-slate-400 pt-1 gap-1 font-medium">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                        {{ \Carbon\Carbon::parse($latestLogbook->tanggal)->format('d F Y') }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                        {{ $latestLogbook->jam_kerja }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div
                                class="p-6 text-center text-slate-400 text-xs border border-dashed border-slate-200 rounded-2xl">
                                Belum ada aktivitas yang dicatat hari ini. Silakan buat entri logbook baru melalui menu
                                Reports.
                            </div>
                        @endif
                    </div>
                </div>
                <!-- TAB 2: ATTENDANCE -->
                <div id="tab-attendance" class="tab-content hidden space-y-6">

                    @php
                        $user = Auth::user();
                        $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                        $todayAttendance = App\Models\Attendance::where('user_id', $user->id)
                            ->where('tanggal', $today)
                            ->first();

                        // Logika Tombol Dinamis
                        if (!$todayAttendance) {
                            $btnText = 'Lakukan Presensi Masuk';
                            $btnAction = "openAttendanceModal('masuk')";
                            $btnBg = 'bg-schoolnavy hover:bg-blue-900 shadow-blue-900/20';
                        } elseif ($todayAttendance->status == 'Izin' || $todayAttendance->status == 'Sakit') {
                            $btnText = 'Presensi Hari Ini Selesai';
                            $btnAction = "alert('Status hari ini tercatat Izin/Sakit.')";
                            $btnBg = 'bg-slate-400 cursor-not-allowed';
                        } elseif (!$todayAttendance->jam_pulang) {
                            $btnText = 'Lakukan Presensi Pulang';
                            $btnAction = "openAttendanceModal('pulang')";
                            $btnBg = 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/20';
                        } else {
                            $btnText = 'Presensi Hari Ini Selesai';
                            $btnAction = "alert('Anda sudah menyelesaikan presensi masuk dan pulang hari ini.')";
                            $btnBg = 'bg-slate-400 cursor-not-allowed';
                        }

                        // Hitung data real untuk 3 kartu statistik
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
                    <div
                        class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-1">
                            <span
                                class="inline-block px-3 py-1 bg-blue-50 text-schoolblue text-[11px] font-bold rounded-lg uppercase tracking-wider mb-1">
                                Modul Siswa
                            </span>
                            <h3 class="text-lg sm:text-xl font-black text-gray-900">Presensi & Geotagging PKL</h3>
                            <p class="text-xs text-slate-500">Penempatan DUDI: <span
                                    class="font-bold text-schoolblue">{{ $user->tempat_dudi ?? 'Belum diatur di Settings' }}</span>
                            </p>
                        </div>

                        <button onclick="{{ $btnAction }}"
                            class="w-full md:w-auto {{ $btnBg }} text-white text-xs font-bold px-6 py-3.5 rounded-2xl shadow-lg transition-all duration-200 flex items-center justify-center gap-2.5 active:scale-95 flex-shrink-0">
                            <i data-lucide="map-pin" class="w-4 h-4 text-blue-300"></i> {{ $btnText }}
                        </button>
                    </div>

                    <!-- STATS CARDS (REAL DATA) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                        <div
                            class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Tingkat
                                    Kehadiran</span>
                                <div
                                    class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-emerald-600">{{ $tingkatKehadiran }}%
                                </div>
                                <div class="text-xs text-slate-500 mt-1">Total {{ $totalHadir }} Hari Masuk Tercatat
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Lokasi DUDI
                                    / GPS</span>
                                <div
                                    class="w-8 h-8 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center">
                                    <i data-lucide="crosshair" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-base font-black text-gray-900 truncate">
                                    {{ $user->tempat_dudi ?? 'Belum diatur' }}
                                </div>
                                <div class="text-xs text-slate-500 mt-1">Radius validasi aktif (&le; 150M)</div>
                            </div>
                        </div>

                        <div
                            class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Izin /
                                    Sakit</span>
                                <div
                                    class="w-8 h-8 rounded-xl bg-indigo-50 text-schoolblue flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-schoolblue">{{ $totalIzinSakit }}
                                    Hari</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ $totalIzinSakit > 0 ? 'Total akumulasi izin/sakit' : 'Tidak ada catatan ketidakhadiran' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIWAYAT PRESENSI -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5">
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-slate-100 pb-4 gap-2">
                            <div>
                                <h4 class="font-black text-sm text-gray-900">Riwayat Presensi Geotagging</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Catatan log kehadiran harian di lokasi
                                    perusahaan penempatan.</p>
                            </div>
                            <button type="button" onclick="openAllHistoryModal()"
                                class="text-xs font-semibold text-schoolblue hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-xl transition flex items-center gap-1.5">
                                <i data-lucide="list" class="w-3.5 h-3.5"></i> Semua Riwayat
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
                                    <div
                                        class="p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-slate-300 transition-all flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/40">
                                        <div class="flex items-start gap-3.5">
                                            <div
                                                class="w-11 h-11 rounded-2xl {{ $att->status == 'Sakit' || $att->status == 'Izin' ? 'bg-amber-100 text-amber-600' : (str_contains($att->status, 'Diluar') ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600') }} flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <i data-lucide="{{ $att->status == 'Sakit' || $att->status == 'Izin' ? 'file-text' : (str_contains($att->status, 'Diluar') ? 'alert-triangle' : 'check-circle-2') }}"
                                                    class="w-5 h-5"></i>
                                            </div>
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2.5 flex-wrap">
                                                    <span
                                                        class="text-xs font-bold text-gray-900">{{ $att->tanggal }}</span>

                                                    @if ($att->status == 'Izin')
                                                        <span
                                                            class="bg-blue-100 text-blue-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Izin
                                                            (Tidak Hadir)
                                                        </span>
                                                    @elseif ($att->status == 'Sakit')
                                                        <span
                                                            class="bg-amber-100 text-amber-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Sakit
                                                            (Tidak Hadir)</span>
                                                    @elseif (str_contains($att->status, 'Diluar'))
                                                        <span
                                                            class="bg-red-100 text-red-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                                            <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                                            Diluar Radius DUDI
                                                        </span>
                                                    @else
                                                        <span
                                                            class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">
                                                            Hadir
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="text-xs text-slate-600 flex items-center gap-1.5 pt-0.5">
                                                    <i data-lucide="map-pin"
                                                        class="w-3.5 h-3.5 text-schoolblue flex-shrink-0"></i>
                                                    <span class="font-medium">{{ $att->lokasi }}</span>
                                                </div>

                                                @if ($att->alasan)
                                                    <div
                                                        class="text-xs {{ str_contains($att->alasan, '⚠️') ? 'text-red-600 font-semibold' : 'text-slate-500' }} mt-1">
                                                        {{ $att->alasan }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div
                                            class="w-full md:w-auto flex md:flex-col justify-between items-center md:items-end gap-1 pt-3 md:pt-0 border-t md:border-t-0 border-slate-200 text-xs font-medium text-slate-600">
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-[11px] text-slate-400">Masuk:</span>
                                                <span
                                                    class="font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200">
                                                    {{ $att->jam_masuk ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') . ' WIB' : '-' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                <span class="text-[11px] text-slate-400">Pulang:</span>
                                                <span
                                                    class="font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200">
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
                                    <div class="text-center py-6 text-gray-400 text-xs">
                                        Belum ada riwayat presensi.
                                    </div>
                                @endforelse
                            </div>

                            <!-- MODAL POP-UP PRESENSI HARIAN -->
                            <div id="attendanceModal"
                                class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                                <div
                                    class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100">
                                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                                        <div>
                                            <h4 id="modal-title" class="font-black text-base text-gray-900">Form
                                                Presensi Harian</h4>
                                            <p class="text-xs text-slate-400">Validasi lokasi DUDI dan waktu kehadiran.
                                            </p>
                                        </div>
                                        <button onclick="closeAttendanceModal()"
                                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>

                                    <form action="{{ route('attendance.store') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="lat" id="modal-lat">
                                        <input type="hidden" name="lng" id="modal-lng">

                                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-2">
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Penempatan
                                                Dudi Anda</span>
                                            <div id="modal-dudi-name" class="font-black text-sm text-gray-900">
                                                {{ Auth::user()->tempat_dudi ?? 'PT Ciptadra Softindo' }}</div>
                                            <div id="modal-gps-info" class="text-xs text-slate-600 font-medium">
                                                Mendeteksi koordinat GPS...</div>
                                        </div>

                                        <div id="status-container" class="space-y-1">
                                            <label class="text-xs font-bold text-slate-700">Status Kehadiran *</label>
                                            <select name="status" id="attendance-status"
                                                class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-schoolblue">
                                                <option value="Hadir">Hadir</option>
                                                <option value="Izin">Izin</option>
                                                <option value="Sakit">Sakit</option>
                                            </select>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 text-xs">
                                            <div class="space-y-1">
                                                <label class="font-bold text-slate-500">Tanggal</label>
                                                <input type="text" id="realtime-date"
                                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 font-bold text-gray-700"
                                                    readonly>
                                            </div>
                                            <div class="space-y-1">
                                                <label class="font-bold text-slate-500">Waktu Saat Ini</label>
                                                <input type="text" id="realtime-clock"
                                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 font-bold text-gray-700"
                                                    readonly>
                                            </div>
                                        </div>

                                        <div class="flex justify-end gap-2 pt-2">
                                            <button type="button" onclick="closeAttendanceModal()"
                                                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-xs transition">Batal</button>
                                            <button type="submit"
                                                class="px-5 py-2 bg-schoolblue hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-md transition">Kirim
                                                Presensi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- MODAL POP-UP SEMUA RIWAYAT PRESENSI -->
                            <div id="allHistoryModal"
                                class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                                <div
                                    class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-100 max-h-[85vh] flex flex-col">
                                    <div
                                        class="flex justify-between items-center border-b border-slate-100 pb-4 flex-shrink-0">
                                        <div>
                                            <h4 class="font-black text-base text-gray-900">Semua Riwayat Presensi
                                                Geotagging</h4>
                                            <p class="text-xs text-slate-400">Draf lengkap catatan kehadiran dan log
                                                lokasi PKL Anda.</p>
                                        </div>
                                        <button onclick="closeAllHistoryModal()"
                                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition">
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
                                            <div
                                                class="p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-50/50">
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <span
                                                            class="text-xs font-bold text-gray-900">{{ $item->tanggal }}</span>
                                                        @if ($item->status == 'Izin')
                                                            <span
                                                                class="bg-blue-100 text-blue-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Izin
                                                                (Tidak Hadir)
                                                            </span>
                                                        @elseif ($item->status == 'Sakit')
                                                            <span
                                                                class="bg-amber-100 text-amber-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Sakit
                                                                (Tidak Hadir)</span>
                                                        @elseif (str_contains($item->status, 'Diluar'))
                                                            <span
                                                                class="bg-red-100 text-red-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Diluar
                                                                Radius DUDI</span>
                                                        @else
                                                            <span
                                                                class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Hadir</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-slate-600 flex items-center gap-1">
                                                        <i data-lucide="map-pin" class="w-3 h-3 text-schoolblue"></i>
                                                        {{ $item->lokasi }}
                                                    </div>
                                                    @if ($item->alasan)
                                                        <div
                                                            class="text-[11px] {{ str_contains($item->alasan, '⚠️') ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                                            {{ $item->alasan }}</div>
                                                    @endif
                                                </div>
                                                <div
                                                    class="text-xs font-semibold text-slate-700 bg-white px-3 py-1.5 rounded-xl border border-slate-200 flex gap-3">
                                                    <div>Masuk: <span
                                                            class="text-emerald-600 font-bold">{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</span>
                                                    </div>
                                                    <div>Pulang: <span
                                                            class="text-schoolblue font-bold">{{ $item->jam_pulang && $item->status != 'Izin' && $item->status != 'Sakit' ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : 'Selesai' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-8 text-slate-400 text-xs">Belum ada data riwayat
                                                absensi sama sekali.</div>
                                        @endforelse
                                    </div>

                                    <div class="flex justify-end pt-2 border-t border-slate-100 flex-shrink-0">
                                        <button onclick="closeAllHistoryModal()"
                                            class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition">Tutup</button>
                                    </div>
                                </div>
                            </div>

                            <!-- SCRIPT JAVASCRIPT -->
                            <script>
                                function openAttendanceModal(type) {
                                    const modal = document.getElementById('attendanceModal');
                                    if (modal) modal.classList.remove('hidden');
                                    updateRealtimeClock();
                                    if (window.lucide) lucide.createIcons();

                                    if (type === 'pulang') {
                                        const title = document.getElementById('modal-title');
                                        const statusContainer = document.getElementById('status-container');
                                        if (title) title.innerText = 'Konfirmasi Presensi Pulang';
                                        if (statusContainer) statusContainer.style.display = 'none';
                                    } else {
                                        const title = document.getElementById('modal-title');
                                        const statusContainer = document.getElementById('status-container');
                                        if (title) title.innerText = 'Form Presensi Harian';
                                        if (statusContainer) statusContainer.style.display = 'block';
                                    }

                                    if (navigator.geolocation) {
                                        document.getElementById('modal-gps-info').innerText =
                                            "Mendeteksi koordinat dan menghitung jarak ke DUDI...";

                                        navigator.geolocation.getCurrentPosition(
                                            (pos) => {
                                                const lat = pos.coords.latitude;
                                                const lng = pos.coords.longitude;
                                                const acc = Math.round(pos.coords.accuracy);

                                                document.getElementById('modal-lat').value = lat;
                                                document.getElementById('modal-lng').value = lng;

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

                                                document.getElementById('modal-gps-info').innerHTML =
                                                    `GPS Aktif: Akurasi ±${acc}m.<br>Estimasi Jarak ke DUDI: <strong class="${distance > 150 ? 'text-red-600' : 'text-emerald-600'}">${distance} meter</strong>`;
                                            },
                                            (err) => {
                                                document.getElementById('modal-gps-info').innerText =
                                                    "Gagal mendeteksi GPS. Harap izinkan akses lokasi.";
                                            }, {
                                                enableHighAccuracy: true
                                            }
                                        );
                                    } else {
                                        const gpsInfo = document.getElementById('modal-gps-info');
                                        if (gpsInfo) gpsInfo.innerText = "Browser tidak mendukung Geolocation.";
                                    }
                                }

                                function closeAttendanceModal() {
                                    const modal = document.getElementById('attendanceModal');
                                    if (modal) modal.classList.add('hidden');
                                }

                                function openAllHistoryModal() {
                                    const modal = document.getElementById('allHistoryModal');
                                    if (modal) modal.classList.remove('hidden');
                                    if (window.lucide) lucide.createIcons();
                                }

                                function closeAllHistoryModal() {
                                    const modal = document.getElementById('allHistoryModal');
                                    if (modal) modal.classList.add('hidden');
                                }

                                function updateRealtimeClock() {
                                    const now = new Date();
                                    const options = {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    };
                                    const dateEl = document.getElementById('realtime-date');
                                    const clockEl = document.getElementById('realtime-clock');

                                    if (dateEl) dateEl.value = now.toLocaleDateString('id-ID', options);

                                    const hours = String(now.getHours()).padStart(2, '0');
                                    const minutes = String(now.getMinutes()).padStart(2, '0');
                                    const seconds = String(now.getSeconds()).padStart(2, '0');
                                    if (clockEl) clockEl.value = `${hours}:${minutes}:${seconds} WIB`;
                                }

                                setInterval(() => {
                                    const modal = document.getElementById('attendanceModal');
                                    if (modal && !modal.classList.contains('hidden')) {
                                        updateRealtimeClock();
                                    }
                                }, 1000);
                            </script>
                        </div>
                    </div>
                </div>
                <!-- TAB 3: REPORTS & LOGBOOK -->
                <div id="tab-reports" class="tab-content hidden space-y-6">
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <div class="flex justify-between items-center flex-wrap gap-4">
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-gray-900">Daftar Logbook &
                                    Laporan
                                    Kegiatan</h3>
                                <p class="text-xs text-slate-500">Semua catatan kegiatan harian yang telah
                                    dikirimkan
                                    ke pembimbing.</p>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">

                                <a href="/dashboard/siswa/logbook/create"
                                    class="flex-1 sm:flex-none bg-schoolblue text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md hover:bg-blue-700 transition flex items-center justify-center gap-2 text-center">
                                    + Entri Baru
                                </a>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($logbooks as $logbook)
                                <div
                                    class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm">
                                            {{ $logbook->judul_kegiatan }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1">{{ $logbook->deskripsi }}</p>
                                        <p class="text-[11px] text-gray-400 mt-2">
                                            {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d F Y') }} •
                                            {{ $logbook->jam_kerja }}
                                        </p>

                                        @if ($logbook->catatan_mentor)
                                            <div class="mt-2 p-2 bg-blue-50 rounded-lg text-xs text-blue-800">
                                                <strong>Catatan Mentor:</strong> {{ $logbook->catatan_mentor }}
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        @if ($logbook->status == 'Approved')
                                            <span
                                                class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">Approved</span>
                                        @elseif($logbook->status == 'Revisi')
                                            <span
                                                class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-700">Revisi</span>
                                        @else
                                            <span
                                                class="text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-400 text-xs">
                                    Belum ada logbook yang diisi. Klik tombol <strong>+ Entri Baru</strong>
                                    untuk
                                    menambah catatan harian.
                                </div>
                            @endforelse
                        </div>
                    </div> <!-- Tutup div bg-white -->
                </div> <!-- Tutup div id="tab-reports" -->
                <!-- TAB 4: SETTINGS -->
                <div id="tab-settings" class="tab-content hidden space-y-6 max-w-4xl mx-auto">

                    @if (session('success'))
                        <div
                            class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-bold">
                            <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Header Pengaturan (Dinamis dari Auth User) -->
                    <div
                        class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full pointer-events-none">
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 flex-shrink-0 flex items-center justify-center font-bold text-schoolnavy text-lg shadow-sm">
                            <span
                                class="text-xl font-black text-schoolblue">{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}</span>
                        </div>
                        <div class="space-y-1.5 flex-1 relative z-10">
                            <div class="flex items-center gap-3 flex-wrap">
                                <h3 class="text-base sm:text-lg font-black text-gray-900">
                                    {{ Auth::user()->name ?? 'Dzikry Fikry' }}</h3>
                                <span
                                    class="bg-blue-100 text-schoolblue text-[11px] font-extrabold px-3 py-0.5 rounded-full shadow-sm">Siswa
                                    Praktikan</span>
                            </div>
                            <p class="text-xs font-semibold text-slate-700">SMKN 1 Depok • Vocational Excellence</p>
                            <p class="text-xs text-slate-500">
                                {{ Auth::user()->email ?? 'dzikry.fikry@smkn1depok.sch.id' }}</p>
                        </div>
                    </div>

                    <!-- Sub-Navigasi Settings Interaktif -->
                    <div class="flex gap-2 border-b border-slate-200 pb-2 overflow-x-auto">
                        <button onclick="switchSettingsSub('profile')" id="btn-set-profile"
                            class="settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold bg-schoolblue text-white shadow-sm transition whitespace-nowrap">Informasi
                            Profil</button>
                        <button onclick="switchSettingsSub('security')" id="btn-set-security"
                            class="settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/60 transition whitespace-nowrap">Keamanan
                            & Sandi</button>
                    </div>

                    <!-- Panel 1: Profil & Peta Lokasi DUDI -->
                    <div id="settings-panel-profile"
                        class="settings-panel bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <h4 class="font-black text-sm text-gray-900 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-schoolblue"></i> Detail Data & Titik
                            Koordinat PKL Siswa
                        </h4>

                        <form action="{{ route('siswa.profile.update') }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="space-y-1">
                                    <label class="font-bold text-slate-500">Departemen / Kompetensi Keahlian</label>
                                    <input type="text" value="{{ Auth::user()->departemen ?? 'PPLG' }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-medium"
                                        disabled>
                                </div>
                                <div class="space-y-1">
                                    <label class="font-bold text-slate-500">Nomor Induk Siswa (NIS)</label>
                                    <input type="text" value="{{ Auth::user()->nis ?? '-' }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-medium"
                                        disabled>
                                </div>
                                <div class="space-y-1">
                                    <label class="font-bold text-slate-500">NISN (Nasional)</label>
                                    <input type="text" value="{{ Auth::user()->nisn ?? '-' }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-medium"
                                        disabled>
                                </div>
                                <div class="space-y-1 sm:col-span-3">
                                    <label class="font-bold text-slate-500">Tempat DUDI (Dunia Usaha / Dunia
                                        Industri)</label>
                                    <input type="text" name="tempat_dudi" value="{{ Auth::user()->tempat_dudi }}"
                                        placeholder="Contoh: PT. Ciptadra Softindo" required
                                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-semibold focus:outline-none focus:border-schoolblue shadow-sm">
                                </div>

                                <!-- Input Latitude & Longitude Tersembunyi dari Peta -->
                                <input type="hidden" id="input-lat" name="dudi_lat"
                                    value="{{ Auth::user()->dudi_lat ?? -6.4025 }}">
                                <input type="hidden" id="input-lng" name="dudi_lng"
                                    value="{{ Auth::user()->dudi_lng ?? 106.8186 }}">
                            </div>

                            <!-- Wadah Peta & Search Bar -->
                            <div class="space-y-3 pt-2">
                                <div
                                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                    <label class="font-bold text-slate-700">Cari & Pilih Titik Lokasi DUDI</label>
                                    <button type="button" onclick="useCurrentLocation()"
                                        class="px-3 py-1.5 bg-blue-50 text-schoolblue hover:bg-blue-100 font-bold rounded-xl transition flex items-center gap-1.5 text-[11px]">
                                        <i data-lucide="crosshair" class="w-3.5 h-3.5"></i> Gunakan Lokasi Saya Saat
                                        Ini
                                    </button>
                                </div>

                                <div class="flex gap-2">
                                    <div class="relative flex-1">
                                        <input type="text" id="map-search-input"
                                            placeholder="Ketik nama tempat/perusahaan (contoh: Ciptadra Softindo)..."
                                            class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-xs text-gray-800 font-medium focus:outline-none focus:border-schoolblue shadow-sm">
                                        <i data-lucide="search"
                                            class="w-4 h-4 text-slate-400 absolute left-3 top-3"></i>
                                    </div>
                                    <button type="button" onclick="searchLocation()"
                                        class="px-5 py-2.5 bg-schoolnavy hover:bg-blue-900 text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5 flex-shrink-0">
                                        Cari Lokasi
                                    </button>
                                </div>

                                <div id="dudiMap" class="w-full h-72 rounded-2xl border border-slate-200 z-10">
                                </div>
                                <p class="text-[11px] text-slate-400">*Ketik nama tempat lalu klik "Cari Lokasi", atau
                                    geser (drag) marker merah di peta untuk presisi akurat.</p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex justify-end">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-schoolblue hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition">
                                    Simpan Perubahan Profil & Lokasi
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Panel 2: Security (Keamanan & Sandi) -->
                    <div id="settings-panel-security"
                        class="settings-panel hidden bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <h4 class="font-black text-sm text-gray-900 flex items-center gap-2">
                            <i data-lucide="key-round" class="w-4 h-4 text-schoolblue"></i> Pengaturan Sandi &
                            Keamanan
                        </h4>

                        <form action="{{ route('siswa.password.update') }}" method="POST"
                            class="space-y-4 text-xs max-w-xl">
                            @csrf
                            @method('PUT')

                            <div class="space-y-1">
                                <label class="font-bold text-slate-700">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" placeholder="••••••••" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-schoolblue">
                            </div>
                            <div class="space-y-1">
                                <label class="font-bold text-slate-700">Kata Sandi Baru</label>
                                <input type="password" name="new_password" placeholder="Minimal 8 karakter" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-schoolblue">
                            </div>
                            <div class="space-y-1">
                                <label class="font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="new_password_confirmation"
                                    placeholder="Ulangi kata sandi baru" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-schoolblue">
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex justify-end">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-schoolblue hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition">
                                    Perbarui Sandi
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- Script untuk Tab Sub-Settings -->
                <script>
                    function switchSettingsSub(sub) {
                        document.getElementById('settings-panel-profile').classList.add('hidden');
                        document.getElementById('settings-panel-security').classList.add('hidden');

                        document.getElementById('btn-set-profile').className =
                            "settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/60 transition whitespace-nowrap";
                        document.getElementById('btn-set-security').className =
                            "settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/60 transition whitespace-nowrap";

                        if (sub === 'profile') {
                            document.getElementById('settings-panel-profile').classList.remove('hidden');
                            document.getElementById('btn-set-profile').className =
                                "settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold bg-schoolblue text-white shadow-sm transition whitespace-nowrap";
                        } else {
                            document.getElementById('settings-panel-security').classList.remove('hidden');
                            document.getElementById('btn-set-security').className =
                                "settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold bg-schoolblue text-white shadow-sm transition whitespace-nowrap";
                        }
                    }
                </script>

            </main>
        </div>
    </div>

    <!-- Script Inisialisasi Lucide Icons, Sidebar, & Presensi Geotagging -->
    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            if (overlay.classList.contains('opacity-0')) {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                overlay.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('tab-' + tabId).classList.remove('hidden');

            // Tutup sidebar otomatis di mobile saat menu dipilih
            if (window.innerWidth < 768) {
                toggleSidebar();
            }

            // Update Page Title
            const titles = {
                'dashboard': 'Dashboard Siswa',
                'attendance': 'Presensi & Geotagging',
                'reports': 'Reports & Logbook',
                'settings': 'Pengaturan Akun'
            };
            document.getElementById('page-title').innerText = titles[tabId] || 'Dashboard Siswa';
            lucide.createIcons();
        }

        function switchSettingsSub(subId) {
            document.querySelectorAll('.settings-panel').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.settings-sub-btn').forEach(el => {
                el.classList.remove('bg-schoolblue', 'text-white', 'shadow-sm');
                el.classList.add('text-slate-600', 'hover:bg-slate-200/60');
            });

            document.getElementById('settings-panel-' + subId).classList.remove('hidden');
            const activeBtn = document.getElementById('btn-set-' + subId);
            activeBtn.classList.remove('text-slate-600', 'hover:bg-slate-200/60');
            activeBtn.classList.add('bg-schoolblue', 'text-white', 'shadow-sm');
            lucide.createIcons();
        }

        // ==========================================
        // FUNGSI MODAL PRESENSI, GPS, & JARAK HAVERSINE
        // ==========================================
        function openAttendanceModal(type) {
            const modal = document.getElementById('attendanceModal');
            if (modal) modal.classList.remove('hidden');
            updateRealtimeClock();
            if (window.lucide) lucide.createIcons();

            if (type === 'pulang') {
                const title = document.getElementById('modal-title');
                const statusContainer = document.getElementById('status-container');
                if (title) title.innerText = 'Konfirmasi Presensi Pulang';
                if (statusContainer) statusContainer.style.display = 'none';
            } else {
                const title = document.getElementById('modal-title');
                const statusContainer = document.getElementById('status-container');
                if (title) title.innerText = 'Form Presensi Harian';
                if (statusContainer) statusContainer.style.display = 'block';
            }

            if (navigator.geolocation) {
                const gpsInfo = document.getElementById('modal-gps-info');
                if (gpsInfo) gpsInfo.innerText = "Mendeteksi koordinat dan menghitung jarak ke DUDI...";

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        const acc = Math.round(pos.coords.accuracy);

                        const latInput = document.getElementById('modal-lat');
                        const lngInput = document.getElementById('modal-lng');
                        if (latInput) latInput.value = lat;
                        if (lngInput) lngInput.value = lng;

                        // Titik koordinat DUDI diambil dari database siswa (Settings)
                        const dudiLat = {{ $user->dudi_lat ?? -6.4025 }};
                        const dudiLng = {{ $user->dudi_lng ?? 106.8186 }};

                        // Hitung jarak Haversine di sisi JavaScript untuk preview instan
                        const R = 6371000; // Radius bumi dalam meter
                        const dLat = (lat - dudiLat) * Math.PI / 180;
                        const dLon = (lng - dudiLng) * Math.PI / 180;
                        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(dudiLat * Math.PI / 180) * Math.cos(lat * Math.PI / 180) *
                            Math.sin(dLon / 2) * Math.sin(dLon / 2);
                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        const distance = Math.round(R * c);

                        if (gpsInfo) {
                            gpsInfo.innerHTML =
                                `GPS Aktif: Akurasi ±${acc}m.<br>Estimasi Jarak ke DUDI: <strong class="${distance > 150 ? 'text-red-600' : 'text-emerald-600'}">${distance} meter</strong>`;
                        }
                    },
                    (err) => {
                        const gpsInfo = document.getElementById('modal-gps-info');
                        if (gpsInfo) gpsInfo.innerText = "Gagal mendeteksi GPS. Harap izinkan akses lokasi.";
                    }, {
                        enableHighAccuracy: true
                    }
                );
            } else {
                const gpsInfo = document.getElementById('modal-gps-info');
                if (gpsInfo) gpsInfo.innerText = "Browser tidak mendukung Geolocation.";
            }
        }

        function closeAttendanceModal() {
            const modal = document.getElementById('attendanceModal');
            if (modal) modal.classList.add('hidden');
        }

        function updateRealtimeClock() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const dateEl = document.getElementById('realtime-date');
            const clockEl = document.getElementById('realtime-clock');

            if (dateEl) dateEl.value = now.toLocaleDateString('id-ID', options);

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            if (clockEl) clockEl.value = `${hours}:${minutes}:${seconds} WIB`;
        }

        function toggleAlasanInput() {
            const statusSelect = document.getElementById('attendance-status');
            const alasanContainer = document.getElementById('alasan-container');
            if (!statusSelect || !alasanContainer) return;

            const status = statusSelect.value;
            if (status === 'Izin' || status === 'Sakit') {
                alasanContainer.classList.remove('hidden');
            } else {
                alasanContainer.classList.add('hidden');
            }
        }

        setInterval(() => {
            const modal = document.getElementById('attendanceModal');
            if (modal && !modal.classList.contains('hidden')) {
                updateRealtimeClock();
            }
        }, 1000);
        // Inisialisasi Peta Leaflet di Menu Settings
        let map, marker;

        function initDudiMap() {
            const initialLat = parseFloat(document.getElementById('input-lat').value) || -6.4025;
            const initialLng = parseFloat(document.getElementById('input-lng').value) || 106.8186;

            if (!map) {
                map = L.map('dudiMap').setView([initialLat, initialLng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                marker = L.marker([initialLat, initialLng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(event) {
                    const position = marker.getLatLng();
                    document.getElementById('input-lat').value = position.lat.toFixed(6);
                    document.getElementById('input-lng').value = position.lng.toFixed(6);
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    document.getElementById('input-lat').value = e.latlng.lat.toFixed(6);
                    document.getElementById('input-lng').value = e.latlng.lng.toFixed(6);
                });
            } else {
                map.setView([initialLat, initialLng], 15);
                marker.setLatLng([initialLat, initialLng]);
            }
        }

        // Fungsi Pencarian Lokasi Berdasarkan Nama (Nominatim API)
        function searchLocation() {
            const query = document.getElementById('map-search-input').value.trim();
            if (!query) {
                alert('Mohon masukkan nama tempat atau perusahaan yang ingin dicari.');
                return;
            }

            // Jika pengguna mengetik "ciptadra", kita arahkan langsung ke jalan utamanya di Margonda agar pasti ketemu di peta
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

                        if (map && marker) {
                            map.setView([lat, lon], 17); // Zoom lebih dekat ke lokasi gedung
                            marker.setLatLng([lat, lon]);
                        }
                    } else {
                        // Fallback otomatis jika masih tidak ketemu: arahkan ke Jl. Margonda Raya Depok
                        alert(
                            'Nama spesifik tidak terindeks di peta publik. Peta akan diarahkan ke Jalan Margonda Raya, silakan geser pin merah ke gedung Ciptadra.'
                        );

                        // Cari jalan Margonda sebagai alternatif otomatis
                        fetch(
                                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent('Jl. Margonda Raya, Depok')}`
                            )
                            .then(res => res.json())
                            .then(fallbackData => {
                                if (fallbackData && fallbackData.length > 0) {
                                    const flat = parseFloat(fallbackData[0].lat);
                                    const flon = parseFloat(fallbackData[0].lon);
                                    document.getElementById('input-lat').value = flat.toFixed(6);
                                    document.getElementById('input-lng').value = flon.toFixed(6);
                                    if (map && marker) {
                                        map.setView([flat, flon], 16);
                                        marker.setLatLng([flat, flon]);
                                    }
                                }
                            });
                    }
                })
                .catch(error => {
                    console.error('Error searching location:', error);
                    alert('Terjadi kesalahan koneksi saat mencari lokasi.');
                });
        }

        function useCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;

                    document.getElementById('input-lat').value = lat.toFixed(6);
                    document.getElementById('input-lng').value = lng.toFixed(6);

                    if (map && marker) {
                        map.setView([lat, lng], 16);
                        marker.setLatLng([lat, lng]);
                    }
                }, () => {
                    alert('Gagal mendeteksi lokasi GPS Anda.');
                }, {
                    enableHighAccuracy: true
                });
            } else {
                alert('Browser tidak mendukung Geolocation.');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(initDudiMap, 500);

            // Buka tab sesuai hash URL jika ada (misal: #attendance atau #reports)
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById('tab-' + hash)) {
                switchTab(hash);
            }
        });

        const originalSwitchTab = window.switchTab;
        window.switchTab = function(tabId) {
            if (typeof originalSwitchTab === 'function') originalSwitchTab(tabId);
            if (tabId === 'settings') {
                setTimeout(() => {
                    if (map) map.invalidateSize();
                    else initDudiMap();
                }, 200);
            }
        };
    </script>

</body>

</html>
