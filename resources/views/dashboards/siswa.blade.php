<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Jurnal PKL Digital</title>
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"></div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR UTAMA (Desktop & Mobile Drawer) -->
        <aside id="sidebar" class="w-64 bg-schoolnavy text-gray-300 flex flex-col border-r border-blue-900/40 fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out shadow-2xl">
            <!-- Logo Brand -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40 flex-shrink-0">
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
                <div class="w-9 h-9 rounded-xl bg-schoolblue/20 text-schoolblue flex items-center justify-center font-bold border border-schoolblue/30 flex-shrink-0">
                    <i data-lucide="school" class="w-4 h-4"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-white">SMKN 1 Depok</h4>
                    <span class="text-[10px] text-blue-200/80">Vocational Excellence</span>
                </div>
            </div>

            <!-- Navigasi Menu -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 text-xs font-medium overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')" id="nav-dashboard" class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl bg-schoolblue text-white font-semibold shadow-lg shadow-blue-600/30 transition-all duration-200">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                <a href="#attendance" onclick="switchTab('attendance')" id="nav-attendance" class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i data-lucide="calendar-check" class="w-4 h-4"></i> Attendance
                </a>
                <a href="#reports" onclick="switchTab('reports')" id="nav-reports" class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Reports & Logbook
                </a>
                <a href="#settings" onclick="switchTab('settings')" id="nav-settings" class="menu-item flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/5 hover:text-white transition-all duration-200">
                    <i data-lucide="settings" class="w-4 h-4"></i> Settings
                </a>
            </nav>

            <!-- Tombol Logout -->
            <div class="p-4 border-t border-blue-900/50">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-red-300 hover:bg-red-500/15 transition text-xs font-semibold">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar Aplikasi
                </a>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOPBAR -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex justify-between items-center px-4 sm:px-8 sticky top-0 z-10 shadow-sm flex-shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Tombol Hamburger Mobile -->
                    <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-xl bg-slate-100 text-schoolnavy hover:bg-slate-200 transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <h2 class="text-xs sm:text-sm font-extrabold text-gray-900 tracking-tight truncate max-w-[180px] sm:max-w-none" id="page-title">Dashboard Siswa</h2>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex bg-blue-50 text-schoolblue px-3.5 py-1.5 rounded-full text-[11px] font-bold border border-blue-100 items-center gap-1.5 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Role: Siswa
                    </div>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-tr from-schoolnavy to-schoolblue overflow-hidden border-2 border-white shadow-md flex items-center justify-center font-bold text-white text-xs flex-shrink-0">
                        BS
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN DINAMIS -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-8 space-y-6">

                <!-- TAB 1: DASHBOARD -->
                <div id="tab-dashboard" class="tab-content space-y-6">

                    <!-- Banner Pengumuman Resmi Sekolah -->
                    <div class="bg-gradient-to-r from-blue-600/10 via-blue-600/5 to-transparent border-l-4 border-schoolblue p-4 rounded-2xl flex items-center justify-between shadow-sm text-blue-950">
                        <div class="flex items-start sm:items-center gap-3">
                            <div class="bg-schoolblue text-white p-2 rounded-xl flex-shrink-0 shadow-md shadow-blue-600/20">
                                <i data-lucide="info" class="w-4 h-4"></i>
                            </div>
                            <p class="text-xs font-medium leading-relaxed">
                                <strong class="uppercase font-bold tracking-wider mr-1 text-schoolnavy block sm:inline">Pengumuman:</strong>
                                Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB. Pastikan mentor industri sudah memberikan approval.
                            </p>
                        </div>
                    </div>

                    <!-- Header Selamat Pagi & Action Button -->
                    <div class="bg-gradient-to-br from-schoolnavy via-blue-800 to-schoolblue p-6 sm:p-8 rounded-3xl text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                        <div class="space-y-2 relative z-10">
                            <h1 class="text-xl sm:text-3xl font-black tracking-tight">
                                Selamat Pagi, Dzikry!
                            </h1>
                            <p class="text-xs text-blue-100 max-w-xl leading-relaxed">
                                Pantau terus kehadiran dan progres laporan Praktek Kerja Lapangan (PKL) Anda langsung dari dashboard digital SMKN 1 Depok.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row w-full md:w-auto items-center gap-3 relative z-10">
                            <button onclick="switchTab('attendance')" class="w-full sm:w-auto bg-white text-schoolnavy hover:bg-blue-50 text-xs font-bold px-5 py-3 rounded-2xl shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="calendar-check" class="w-4 h-4 text-schoolblue"></i> Isi Absensi
                            </button>
                            <button onclick="switchTab('reports')" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="file-plus" class="w-4 h-4"></i> Tambah Logbook
                            </button>
                        </div>
                    </div>

                    <!-- 3 Kartu Statistik Dashboard Interaktif -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between group">
                            <div class="space-y-1">
                                <div class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Kehadiran Total</div>
                                <div class="text-2xl sm:text-3xl font-black text-gray-900 group-hover:text-schoolblue transition-colors">21 <span class="text-xs sm:text-sm font-semibold text-slate-500">Hari</span></div>
                                <div class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                    <i data-lucide="trending-up" class="w-3 h-3"></i> 98.5% Kehadiran Valid
                                </div>
                            </div>
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 text-schoolblue flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform flex-shrink-0">
                                <i data-lucide="calendar" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between group">
                            <div class="space-y-1">
                                <div class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Logbook Dikirim</div>
                                <div class="text-2xl sm:text-3xl font-black text-gray-900 group-hover:text-schoolblue transition-colors">18 <span class="text-xs sm:text-sm font-semibold text-slate-500">Entri</span></div>
                                <div class="text-[10px] text-blue-600 font-bold flex items-center gap-1">
                                    <i data-lucide="check-circle-2" class="w-3 h-3"></i> Semua Tepat Waktu
                                </div>
                            </div>
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform flex-shrink-0">
                                <i data-lucide="book-open" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center justify-between group">
                            <div class="space-y-1">
                                <div class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Status Validasi</div>
                                <div class="text-lg sm:text-xl font-black text-emerald-600 pt-1">Terverifikasi</div>
                                <div class="text-[10px] text-slate-400 font-medium">Oleh Pembimbing DUDI</div>
                            </div>
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform flex-shrink-0">
                                <i data-lucide="shield-check" class="w-6 h-6 sm:w-7 sm:h-7"></i>
                            </div>
                        </div>

                    </div>

                    <!-- Aktivitas Terbaru -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-black text-xs sm:text-sm text-gray-900 tracking-tight flex items-center gap-2">
                                <i data-lucide="activity" class="w-4 h-4 text-schoolblue"></i> Aktivitas Terbaru Hari Ini
                            </h3>
                            <button onclick="switchTab('reports')" class="text-xs font-bold text-schoolblue hover:underline flex items-center gap-1">
                                Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>

                        <div class="p-4 sm:p-6 rounded-2xl border border-slate-200/60 bg-gradient-to-br from-slate-50/80 to-blue-50/20 space-y-4">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-schoolblue text-white flex items-center justify-center shadow-md shadow-blue-500/20 flex-shrink-0">
                                        <i data-lucide="wrench" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-gray-900">Maintenance Server & Jaringan</h4>
                                        <span class="text-[10px] text-slate-500">PT.Ciptadra Softindo</span>
                                    </div>
                                </div>
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-3 py-1 rounded-full border border-emerald-200 flex items-center gap-1">
                                    <i data-lucide="check" class="w-3 h-3"></i> Approved
                                </span>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed bg-white p-3.5 sm:p-4 rounded-xl border border-slate-200/50">
                                Melakukan pengecekan rutin pada server lokal dan mengganti kabel LAN yang bermasalah di ruang lab komputer utama. Melakukan konfigurasi ulang switch serta memantau traffic jaringan agar lancar.
                            </p>

                            <!-- Catatan Mentor Box -->
                            <div class="bg-blue-50/80 border border-blue-200/80 p-3.5 rounded-xl flex items-start gap-2.5 text-blue-950 text-xs shadow-sm">
                                <i data-lucide="message-square-quote" class="w-4 h-4 text-schoolblue flex-shrink-0 mt-0.5"></i>
                                <div><strong class="font-bold text-schoolnavy">Catatan Mentor:</strong> Pekerjaan sangat rapi dan dokumentasi lengkap. Pertahankan etos kerja yang baik!</div>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-[11px] text-slate-400 pt-1 gap-1 font-medium">
                                <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> 12 Oktober 2026</span>
                                <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5"></i> 08:00 - 16:00 WIB (8 Jam)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: ATTENDANCE -->
                <div id="tab-attendance" class="tab-content hidden space-y-6">

                    <!-- HEADER SECTION & TOMBOL PRESENSI -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="space-y-1">
                            <span class="inline-block px-3 py-1 bg-blue-50 text-schoolblue text-[11px] font-bold rounded-lg uppercase tracking-wider mb-1">
                                Modul Siswa
                            </span>
                            <h3 class="text-lg sm:text-xl font-black text-gray-900">Presensi & Geotagging PKL</h3>
                            <p class="text-xs text-slate-500">Pencatatan waktu kehadiran siswa dengan validasi radius lokasi industri.</p>
                        </div>
                        <button onclick="alert('Mengakses GPS Perangkat...')" class="w-full md:w-auto bg-schoolnavy hover:bg-blue-900 text-white text-xs font-bold px-6 py-3.5 rounded-2xl shadow-lg shadow-blue-900/20 transition-all duration-200 flex items-center justify-center gap-2.5 active:scale-95 flex-shrink-0">
                            <i data-lucide="map-pin" class="w-4 h-4 text-blue-300"></i> Presensi Hari Ini
                        </button>
                    </div>

                    <!-- STATS CARDS -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:border-blue-200 transition">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Tingkat Kehadiran</span>
                                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-emerald-600">98.5%</div>
                                <div class="text-xs text-slate-500 mt-1">Total 20 Hari Kerja Aktif</div>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:border-blue-200 transition">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Radius Kantor DUDI</span>
                                <div class="w-8 h-8 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center">
                                    <i data-lucide="crosshair" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-gray-900">&le; 50 M</div>
                                <div class="text-xs text-slate-500 mt-1">Akurasi GPS Sangat Baik</div>
                            </div>
                        </div>

                        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:border-blue-200 transition">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Izin / Sakit</span>
                                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-schoolblue flex items-center justify-center">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text-2xl sm:text-3xl font-black text-schoolblue">0 Hari</div>
                                <div class="text-xs text-slate-500 mt-1">Tidak ada catatan ketidakhadiran</div>
                            </div>
                        </div>
                    </div>

                    <!-- RIWAYAT PRESENSI -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-5">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-slate-100 pb-4 gap-2">
                            <div>
                                <h4 class="font-black text-sm text-gray-900">Riwayat Presensi Geotagging</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Catatan log kehadiran harian di lokasi perusahaan penempatan.</p>
                            </div>
                            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-xl">Bulan Oktober 2026</span>
                        </div>

                        <div class="space-y-3">
                            <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 hover:border-slate-300 transition-all flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/40">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2.5 flex-wrap">
                                            <span class="text-xs font-bold text-gray-900">2026-10-26</span>
                                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full">Hadir Tepat Waktu</span>
                                        </div>
                                        <div class="text-xs text-slate-600 flex items-center gap-1.5 pt-0.5">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-schoolblue flex-shrink-0"></i>
                                            <span class="font-medium">PT. Ciptadra Softindo (Depok)</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full md:w-auto flex md:flex-col justify-between items-center md:items-end gap-1 pt-3 md:pt-0 border-t md:border-t-0 border-slate-200 text-xs font-medium text-slate-600">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[11px] text-slate-400">Masuk:</span>
                                        <span class="font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200">07:45 WIB</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <span class="text-[11px] text-slate-400">Pulang:</span>
                                        <span class="font-bold text-slate-800 bg-white px-2 py-0.5 rounded border border-slate-200">17:05 WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: REPORTS & LOGBOOK -->
                <div id="tab-reports" class="tab-content hidden space-y-6">
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <div class="flex justify-between items-center flex-wrap gap-4">
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-gray-900">Daftar Logbook & Laporan Kegiatan</h3>
                                <p class="text-xs text-slate-500">Semua catatan kegiatan harian yang telah dikirimkan ke pembimbing.</p>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                <button onclick="alert('Mengunduh laporan PDF... (Simulasi)')" class="flex-1 sm:flex-none bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                                    <i data-lucide="download" class="w-4 h-4"></i> Download PDF
                                </button>
                                <button class="flex-1 sm:flex-none bg-schoolblue text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                    <i data-lucide="plus" class="w-4 h-4"></i> Entri Baru
                                </button>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-50/50">
                                <div>
                                    <div class="text-xs font-bold text-gray-900">Konfigurasi Switch & Router Mikrotik</div>
                                    <div class="text-[11px] text-slate-500">11 Oktober 2026 • 8 Jam Kerja</div>
                                </div>
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full">Approved</span>
                            </div>
                            <div class="p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-50/50">
                                <div>
                                    <div class="text-xs font-bold text-gray-900">Instalasi OS Client & Software Pendukung</div>
                                    <div class="text-[11px] text-slate-500">10 Oktober 2026 • 8 Jam Kerja</div>
                                </div>
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-3 py-1 rounded-full">Approved</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: SETTINGS -->
                <div id="tab-settings" class="tab-content hidden space-y-6 max-w-4xl mx-auto">

                    <!-- Header Pengaturan -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full pointer-events-none"></div>
                        <div class="w-16 h-16 rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 flex-shrink-0 flex items-center justify-center font-bold text-schoolnavy text-lg">
                            <img src="{{ asset('images/profile-siswa.jpeg') }}" alt="Avatar" srcset="">
                        </div>
                        <div class="space-y-1.5 flex-1 relative z-10">
                            <div class="flex items-center gap-3 flex-wrap">
                                <h3 class="text-base sm:text-lg font-black text-gray-900">Dzikry Fikry</h3>
                                <span class="bg-blue-100 text-schoolblue text-[11px] font-extrabold px-3 py-0.5 rounded-full shadow-sm">Siswa Praktikan</span>
                            </div>
                            <p class="text-xs font-semibold text-slate-700">SMKN 1 Depok • Vocational Excellence</p>
                            <p class="text-xs text-slate-500">dzikry.fikry@smkn1depok.sch.id</p>
                        </div>
                    </div>

                    <!-- Sub-Navigasi Settings Interaktif (Scrollable di HP) -->
                    <div class="flex gap-2 border-b border-slate-200 pb-2 overflow-x-auto">
                        <button onclick="switchSettingsSub('profile')" id="btn-set-profile" class="settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold bg-schoolblue text-white shadow-sm transition whitespace-nowrap">Informasi Profil</button>
                        <button onclick="switchSettingsSub('security')" id="btn-set-security" class="settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/60 transition whitespace-nowrap">Keamanan & Sandi</button>
                        <button onclick="switchSettingsSub('notifications')" id="btn-set-notifications" class="settings-sub-btn px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-200/60 transition whitespace-nowrap">Notifikasi</button>
                    </div>

                    <!-- Panel 1: Profil -->
                    <div id="settings-panel-profile" class="settings-panel bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <h4 class="font-black text-sm text-gray-900 flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4 text-schoolblue"></i> Detail Data PKL Siswa
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1">
                                <label class="font-bold text-slate-500">Departemen / Kompetensi Keahlian</label>
                                <input type="text" value="Pengembangan Perangkat Lunak dan Gim (PPLG)" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-medium" disabled>
                            </div>
                            <div class="space-y-1">
                                <label class="font-bold text-slate-500">Nomor Induk Siswa (NIS)</label>
                                <input type="text" value="102938" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-medium" disabled>
                            </div>
                            <div class="space-y-1 sm:col-span-2">
                                <label class="font-bold text-slate-500">Tempat DUDI (Dunia Usaha / Dunia Industri)</label>
                                <input type="text" value="PT. Ciptadra Softindo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-gray-800 font-medium" disabled>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="alert('Data profil diperbarui!')" class="w-full sm:w-auto bg-schoolblue hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </div>

                    <!-- Panel 2: Security -->
                    <div id="settings-panel-security" class="settings-panel hidden bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <h4 class="font-black text-sm text-gray-900 flex items-center gap-2">
                            <i data-lucide="key-round" class="w-4 h-4 text-schoolblue"></i> Pengaturan Sandi & Keamanan
                        </h4>

                        <div class="space-y-4 text-xs max-w-xl">
                            <div class="space-y-1">
                                <label class="font-bold text-slate-700">Kata Sandi Saat Ini</label>
                                <input type="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-schoolblue">
                            </div>
                            <div class="space-y-1">
                                <label class="font-bold text-slate-700">Kata Sandi Baru</label>
                                <input type="password" placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-schoolblue">
                            </div>
                            <div class="space-y-1">
                                <label class="font-bold text-slate-700">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" placeholder="Ulangi kata sandi baru" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-schoolblue">
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <a href="/" class="text-red-600 hover:underline font-bold text-xs flex items-center gap-1.5 order-2 sm:order-1">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </a>
                            <button onclick="alert('Kata sandi berhasil diperbarui!')" class="w-full sm:w-auto bg-schoolblue hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition order-1 sm:order-2">
                                Perbarui Sandi
                            </button>
                        </div>
                    </div>

                    <!-- Panel 3: Notifications -->
                    <div id="settings-panel-notifications" class="settings-panel hidden bg-white p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                        <h4 class="font-black text-sm text-gray-900 flex items-center gap-2">
                            <i data-lucide="bell" class="w-4 h-4 text-schoolblue"></i> Pengaturan Notifikasi
                        </h4>
                        <div class="space-y-3 text-xs">
                            <label class="flex items-start sm:items-center gap-3 cursor-pointer">
                                <input type="checkbox" checked class="w-4 h-4 rounded text-schoolblue focus:ring-schoolblue mt-0.5 sm:mt-0 flex-shrink-0">
                                <span class="font-medium text-slate-700 leading-relaxed">Notifikasi pengingat pengisian logbook harian</span>
                            </label>
                            <label class="flex items-start sm:items-center gap-3 cursor-pointer">
                                <input type="checkbox" checked class="w-4 h-4 rounded text-schoolblue focus:ring-schoolblue mt-0.5 sm:mt-0 flex-shrink-0">
                                <span class="font-medium text-slate-700 leading-relaxed">Pemberitahuan approval/catatan dari mentor industri</span>
                            </label>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Script Inisialisasi Lucide Icons & Interaksi Mobile -->
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
    </script>
</body>
</html>
