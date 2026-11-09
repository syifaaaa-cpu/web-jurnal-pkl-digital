<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru Pembimbing - Sistem PKL</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                       schoolnavy: '#3c5897',
                        schoolblue: '#2563eb',
                        schoolred: '#dc2626',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="hidden md:flex flex-col w-64 bg-schoolnavy text-white transition-all duration-300 z-30">
            <!-- Brand / Logo Header -->
            <div class="h-20 flex items-center px-6 gap-3 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40">
                    <i class="fa-solid fa-chalkboard-user text-lg"></i>
                </div>
                <div>
                    <span class="text-xs font-black tracking-wider text-white block uppercase">Guru PKL</span>
                    <span class="text-[10px] text-blue-300 font-medium">Monitoring Sekolah</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors bg-schoolblue text-white shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#penempatan" onclick="switchTab('penempatan')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-building-user w-5 text-center"></i>
                    <span>DUDI & Penempatan</span>
                </a>
                <a href="#monitoring" onclick="switchTab('monitoring')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-clipboard-user w-5 text-center"></i>
                    <span>Monitoring Siswa</span>
                    <span class="ml-auto bg-schoolred text-white text-xs px-2 py-0.5 rounded-full font-bold">28</span>
                </a>
                <a href="#nilai" onclick="switchTab('nilai')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-file-shield w-5 text-center"></i>
                    <span>Rekap & Nilai Akhir</span>
                </a>
                <a href="#settings" onclick="switchTab('settings')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-blue-950">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/15 transition text-xs font-semibold">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOP NAVBAR -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-20 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button onclick="toggleSidebar()" class="text-slate-500 hover:text-schoolnavy md:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 id="page-title" class="text-xl font-bold text-schoolnavy">Dashboard Guru Pembimbing</h2>
                        <p class="text-xs text-slate-500">Portal Resmi Pengawasan PKL SMKN 1 Depok</p>
                    </div>
                </div>

                <!-- User Profile Badge -->
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">Nanang Suwandi, S.T.</span>
                        <span class="block text-xs text-slate-500">Role: Guru Pembimbing</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-schoolblue text-white flex items-center justify-center font-bold shadow-md">
                        SA
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- TAB 1: DASHBOARD GURU (REVISI: DITAMBAHKAN GRID DUDI YANG DIPEGANG GURU) -->
                <div id="tab-dashboard" class="tab-content space-y-6">
                    <!-- Banner Selamat Datang -->
                    <div class="bg-gradient-to-r from-schoolnavy to-blue-900 rounded-2xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
                        <div class="relative z-10 space-y-2 mb-4 md:mb-0">
                            <span class="bg-schoolblue/40 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-blue-400/30">Portal Guru Pembimbing</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Selamat Datang, Nanang Suwandi, S.T.</h3>
                            <p class="text-slate-300 text-sm max-w-xl">Berikut adalah ringkasan tempat PKL (DUDI) yang berada di bawah bimbingan Anda periode tahun ajaran ini.</p>
                        </div>
                        <div class="relative z-10 w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/10 shadow-inner">
                            <i class="fa-solid fa-school-flag text-4xl text-blue-200"></i>
                        </div>
                        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-schoolblue/20 rounded-full blur-3xl pointer-events-none"></div>
                    </div>

                    <!-- Statistik Singkat -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-user-graduate"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Siswa Binaan</p>
                                <h4 class="text-2xl font-bold text-slate-800">12 Siswa</h4>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-building"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">DUDI yang Anda Pegang</p>
                                <h4 class="text-2xl font-bold text-slate-800">3 Instansi</h4>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-clipboard-list"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Logbook Dinilai</p>
                                <h4 class="text-2xl font-bold text-slate-800">34 Berkas</h4>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM GRID TEMPAT PKL (DUDI) YANG DIPEGANG GURU TERSEBUT -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h4 class="text-base font-bold text-schoolnavy flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-schoolblue"></i> Daftar Tempat PKL (DUDI) Bimbingan Anda
                            </h4>
                            <span class="text-xs text-slate-500 font-medium">Klik tombol untuk memantau siswa</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- DUDI 1 -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-schoolblue transition space-y-4 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-schoolblue flex items-center justify-center font-bold">
                                            <i class="fa-solid fa-laptop-code"></i>
                                        </div>
                                        <span class="bg-blue-50 text-schoolblue text-xs font-bold px-2.5 py-1 rounded-full">3 Siswa</span>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-sm">PT.Ciptadra Sofindo</h5>
                                        <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-location-dot text-schoolred mr-1"></i>Ciptadra Innovation Tower, Jl. Margonda </p>
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 text-[11px] space-y-1">
                                        <div class="flex justify-between"><span class="text-slate-400">Mentor:</span><span class="font-bold text-slate-700">Camelia</span></div>
                                        <div class="flex justify-between"><span class="text-slate-400">Siswa:</span><span class="font-bold text-slate-700">Syifa, Dzikry, Salma</span></div>
                                    </div>
                                </div>
                                <button onclick="switchTab('monitoring')" class="w-full py-2 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                                    Lihat Detail & Siswa
                                </button>
                            </div>

                            <!-- DUDI 2 -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-schoolblue transition space-y-4 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                                            <i class="fa-solid fa-palette"></i>
                                        </div>
                                        <span class="bg-purple-50 text-purple-600 text-xs font-bold px-2.5 py-1 rounded-full">4 Siswa</span>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-sm">CV. Kreasi Digital Media</h5>
                                        <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-location-dot text-schoolred mr-1"></i>Jl. Gatot Subroto No. 12, Jakarta</p>
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 text-[11px] space-y-1">
                                        <div class="flex justify-between"><span class="text-slate-400">Mentor:</span><span class="font-bold text-slate-700">Dian Sastrowardoyo</span></div>
                                        <div class="flex justify-between"><span class="text-slate-400">Siswa:</span><span class="font-bold text-slate-700">Rizky, Dimas, dkk</span></div>
                                    </div>
                                </div>
                                <button onclick="switchTab('monitoring')" class="w-full py-2 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                                    Lihat Detail & Siswa
                                </button>
                            </div>

                            <!-- DUDI 3 -->
                            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-schoolblue transition space-y-4 flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                                            <i class="fa-solid fa-network-wired"></i>
                                        </div>
                                        <span class="bg-emerald-50 text-emerald-600 text-xs font-bold px-2.5 py-1 rounded-full">5 Siswa</span>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-sm">PT. Cyber Mandiri Integrasi</h5>
                                        <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-location-dot text-schoolred mr-1"></i>Jl. TB Simatupang No. 8, Jakarta</p>
                                    </div>
                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 text-[11px] space-y-1">
                                        <div class="flex justify-between"><span class="text-slate-400">Mentor:</span><span class="font-bold text-slate-700">Budi Santoso, MT.</span></div>
                                        <div class="flex justify-between"><span class="text-slate-400">Siswa:</span><span class="font-bold text-slate-700">Alya, Fajar, dkk</span></div>
                                    </div>
                                </div>
                                <button onclick="switchTab('monitoring')" class="w-full py-2 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                                   Lihat Detail & Siswa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- TAB 2: DUDI & PENEMPATAN -->
<div id="tab-penempatan" class="tab-content space-y-6 hidden">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
            <div>
                <h3 class="font-bold text-schoolnavy text-lg">Manajemen Penempatan Siswa & DUDI</h3>
                <p class="text-xs text-slate-500">Daftar perusahaan mitra tempat siswa melaksanakan Praktik Kerja Lapangan.</p>
            </div>
            <button onclick="alert('Membuka form tambah instansi DUDI baru')" class="px-4 py-2 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-2 shadow-sm">
                <i class="fa-solid fa-plus"></i><span>Tambah Mitra DUDI</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- DUDI 1: PT. Ciptadra Softindo -->
            <div class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-br from-white to-slate-50 shadow-sm space-y-4">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-schoolnavy text-white flex items-center justify-center font-bold text-lg shadow-md">
                            <i class="fa-solid fa-laptop-code"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base">PT. Ciptadra Softindo</h4>
                            <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> Jl. Margonda Jl. STM Mandiri No.1A</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">3 Siswa</span>
                </div>
                <div class="bg-white p-3 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Mentor Industri:</span>
                        <span class="font-bold text-slate-700">Camelia</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Kontak:</span>
                        <span class="font-bold text-slate-700">0812-3456-7890</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2 border-t border-slate-100">
                    <button onclick="switchTab('monitoring')" class="px-3 py-1.5 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-users"></i><span>Monitoring Siswa di Sini</span>
                    </button>
                </div>
            </div>

            <!-- DUDI 2: PT. Telkom Indonesia (Depok) -->
            <div class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-br from-white to-slate-50 shadow-sm space-y-4">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-schoolnavy text-white flex items-center justify-center font-bold text-lg shadow-md">
                            <i class="fa-solid fa-network-wired"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base">PT. Telkom Indonesia, Tbk</h4>
                            <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> Jl. Pemuda No.5, Pancoran Mas</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">4 Siswa</span>
                </div>
                <div class="bg-white p-3 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Mentor Industri:</span>
                        <span class="font-bold text-slate-700">Budi Santoso, S.Kom</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Kontak:</span>
                        <span class="font-bold text-slate-700">0821-9876-5432</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2 border-t border-slate-100">
                    <button onclick="switchTab('monitoring')" class="px-3 py-1.5 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-users"></i><span>Monitoring Siswa di Sini</span>
                    </button>
                </div>
            </div>

            <!-- DUDI 3: PT. Solusi Digital Nusantara -->
            <div class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-br from-white to-slate-50 shadow-sm space-y-4">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-schoolnavy text-white flex items-center justify-center font-bold text-lg shadow-md">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base">CV. Solusi Digital Nusantara</h4>
                            <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> Jl. Juanda Raya No. 42, Depok</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">2 Siswa</span>
                </div>
                <div class="bg-white p-3 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Mentor Industri:</span>
                        <span class="font-bold text-slate-700">Ahmad Fauzi, M.T.</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Kontak:</span>
                        <span class="font-bold text-slate-700">0856-1122-3344</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2 border-t border-slate-100">
                    <button onclick="switchTab('monitoring')" class="px-3 py-1.5 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-users"></i><span>Monitoring Siswa di Sini</span>
                    </button>
                </div>
            </div>

            <!-- DUDI 4: Diskominfo Kota Depok -->
            <div class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-br from-white to-slate-50 shadow-sm space-y-4">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-schoolnavy text-white flex items-center justify-center font-bold text-lg shadow-md">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base">Diskominfo Kota Depok</h4>
                            <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> Balaikota Depok, Lt. 3</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">5 Siswa</span>
                </div>
                <div class="bg-white p-3 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Mentor Industri:</span>
                        <span class="font-bold text-slate-700">Dra. Siti Rahmawati</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase font-semibold">Kontak:</span>
                        <span class="font-bold text-slate-700">021-7721-0000</span>
                    </div>
                </div>
                <div class="flex justify-end pt-2 border-t border-slate-100">
                    <button onclick="switchTab('monitoring')" class="px-3 py-1.5 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-users"></i><span>Monitoring Siswa di Sini</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
                <!-- TAB 3: MONITORING SISWA -->
                <div id="tab-monitoring" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Monitoring Absensi & Logbook Siswa per DUDI</h3>
                                <p class="text-xs text-slate-500">Pilih tempat penempatan mitra DUDI untuk melihat daftar siswa, absensi, dan unduh logbook harian.</p>
                            </div>
                        </div>

                        <!-- Filter Select DUDI -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/2 space-y-1">
                                <label class="text-xs font-semibold text-slate-600 block">Pilih Instansi / Mitra DUDI:</label>
                                <select id="select-dudi" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium">
                                    <option value="pt-solusi">PT. Solusi Teknologi Nusantara (Mentor: Ahmad Fauzi, S.Kom.)</option>
                                    <option value="cv-kreasi">CV. Kreasi Digital Media (Mentor: Dian Sastrowardoyo)</option>
                                </select>
                            </div>
                            <div class="text-xs text-slate-500 text-right hidden sm:block">
                                <span class="font-bold text-schoolnavy block">Total Siswa di DUDI Ini: 3 Orang</span>
                                <span>Status Sinkronisasi: <span class="text-emerald-600 font-bold">Terhubung</span></span>
                            </div>
                        </div>

                        <!-- Daftar Murid (Sifa, Dzikry, Salma) -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4 text-center">Rekap Absensi (Hadir/Izin/Sakit)</th>
                                        <th class="py-3 px-4">Aktivitas Terakhir / Pekerjaan di DUDI</th>
                                        <th class="py-3 px-4 text-center">Aksi & Logbook</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs">
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4">
                                            <span class="font-bold text-slate-800 text-sm block">Sifa Fauziah</span>
                                            <span class="text-[10px] text-slate-400">NIS: 10293 | Kelas XII RPL 1</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full text-[11px]">48 Hadir</span>
                                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-full text-[11px] ml-1">0 Izin</span>
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            <span class="font-semibold text-slate-800 block">Membuat REST API Backend Dashboard</span>
                                            <span class="text-[10px] text-slate-400">Divalidasi Mentor: 2 Jam lalu</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <button onclick="alert('Mengunduh dokumen Logbook/Jurnal Harian lengkap milik Sifa Fauziah (PDF)')" class="px-3 py-1.5 bg-schoolblue text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center space-x-1.5 mx-auto shadow-sm">
                                                <i class="fa-solid fa-file-pdf"></i><span>Unduh Logbook</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4">
                                            <span class="font-bold text-slate-800 text-sm block">Muhammad Dzikry</span>
                                            <span class="text-[10px] text-slate-400">NIS: 10294 | Kelas XII RPL 1</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full text-[11px]">46 Hadir</span>
                                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-[11px] ml-1">2 Izin</span>
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            <span class="font-semibold text-slate-800 block">Integrasi Database MySQL ke Frontend Vue.js</span>
                                            <span class="text-[10px] text-slate-400">Divalidasi Mentor: Kemarin</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <button onclick="alert('Mengunduh dokumen Logbook/Jurnal Harian lengkap milik Muhammad Dzikry (PDF)')" class="px-3 py-1.5 bg-schoolblue text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center space-x-1.5 mx-auto shadow-sm">
                                                <i class="fa-solid fa-file-pdf"></i><span>Unduh Logbook</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4">
                                            <span class="font-bold text-slate-800 text-sm block">Salma Nur Aulia</span>
                                            <span class="text-[10px] text-slate-400">NIS: 10295 | Kelas XII RPL 1</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full text-[11px]">47 Hadir</span>
                                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded-full text-[11px] ml-1">1 Sakit</span>
                                        </td>
                                        <td class="py-3 px-4 text-slate-600">
                                            <span class="font-semibold text-slate-800 block">Testing Quality Assurance (QA) Fitur Login</span>
                                            <span class="text-[10px] text-slate-400">Divalidasi Mentor: 3 Hari lalu</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <button onclick="alert('Mengunduh dokumen Logbook/Jurnal Harian lengkap milik Salma Nur Aulia (PDF)')" class="px-3 py-1.5 bg-schoolblue text-white rounded-xl hover:bg-blue-700 transition font-semibold flex items-center justify-center space-x-1.5 mx-auto shadow-sm">
                                                <i class="fa-solid fa-file-pdf"></i><span>Unduh Logbook</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: REKAP & NILAI AKHIR -->
                <div id="tab-nilai" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Input & Rekapitulasi Nilai Akhir PKL per DUDI</h3>
                                <p class="text-xs text-slate-500">Pilih instansi DUDI untuk menampilkan daftar siswa, input nilai laporan sekolah (40%), dan unduh PDF laporan.</p>
                            </div>
                            <button onclick="alert('Mengunduh Rekap Nilai Keseluruhan Semua Siswa (Excel)')" class="px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition flex items-center space-x-2 shadow-sm">
                                <i class="fa-solid fa-file-excel"></i><span>Download Rekap Excel</span>
                            </button>
                        </div>

                        <!-- Filter Select DUDI untuk Nilai -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/2 space-y-1">
                                <label class="text-xs font-semibold text-slate-600 block">Pilih Instansi / Mitra DUDI:</label>
                                <select id="select-dudi-nilai" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium">
                                    <option value="pt-solusi">PT. Solusi Teknologi Nusantara (Mentor: Ahmad Fauzi, S.Kom.)</option>
                                    <option value="cv-kreasi">CV. Kreasi Digital Media (Mentor: Dian Sastrowardoyo)</option>
                                </select>
                            </div>
                            <div class="text-xs text-slate-500 text-right hidden sm:block">
                                <span class="font-bold text-schoolnavy block">Kombinasi Bobot:</span>
                                <span>Nilai DUDI (60%) + Nilai Laporan (40%)</span>
                            </div>
                        </div>

                        <!-- Tabel Input Nilai -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4 text-center">Nilai DUDI (60%)</th>
                                        <th class="py-3 px-4 text-center">Nilai Laporan Sekolah (40%)</th>
                                        <th class="py-3 px-4 text-center">Nilai Akhir</th>
                                        <th class="py-3 px-4 text-center">Predikat</th>
                                        <th class="py-3 px-4 text-center">Aksi Guru & PDF</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs">
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4">
                                            <span class="font-bold text-slate-800 text-sm block">Sifa Fauziah</span>
                                            <span class="text-[10px] text-slate-400">NIS: 10293</span>
                                        </td>
                                        <td class="py-3 px-4 text-center font-bold text-slate-700 text-sm">90</td>
                                        <td class="py-3 px-4 text-center">
                                            <input type="number" value="88" class="w-16 px-2 py-1.5 border border-slate-300 rounded-lg text-center text-xs font-bold text-schoolblue bg-white focus:outline-none focus:border-schoolblue">
                                        </td>
                                        <td class="py-3 px-4 text-center font-extrabold text-schoolblue text-sm">89.2</td>
                                        <td class="py-3 px-4 text-center"><span class="bg-blue-100 text-blue-700 font-bold px-2.5 py-1 rounded">A</span></td>
                                        <td class="py-3 px-4 text-center space-x-1">
                                            <button onclick="alert('Menyimpan perubahan Nilai Laporan Sifa Fauziah')" class="px-2.5 py-1.5 bg-schoolblue text-white rounded-lg hover:bg-blue-700 transition font-semibold" title="Simpan Nilai">
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </button>
                                            <button onclick="alert('Mengunduh Laporan Lengkap PKL Sifa Fauziah (PDF)')" class="px-2.5 py-1.5 bg-schoolred text-white rounded-lg hover:bg-red-700 transition font-semibold" title="Download PDF Laporan Siswa">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: SETTINGS GURU (DENGAN SUB-TAB INTERAKTIF: PROFIL, KEAMANAN, NOTIFIKASI) -->
                <div id="tab-settings" class="tab-content space-y-6 hidden">
                    <!-- Kartu Header Profil -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 rounded-full bg-schoolblue text-white flex items-center justify-center font-bold text-2xl shadow-md border-4 border-slate-100">
                                SA
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-slate-800 text-lg">Nanang Suwandi, S.T.</h3>
                                    <span class="bg-blue-100 text-schoolblue text-[11px] font-bold px-2.5 py-0.5 rounded-full">Guru Pembimbing</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">SMKN 1 Depok • Vocational Excellence</p>
                                <p class="text-xs text-schoolblue font-medium mt-0.5">nanang.suwandi@smkn1depok.sch.id</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi Sub-Tab Pengaturan Kecil (Dapat Diklik) -->
                    <div class="flex border-b border-slate-200 space-x-6 text-xs font-semibold">
                        <button id="subtab-btn-profil" onclick="switchSubTab('profil')" class="subtab-btn pb-3 text-schoolblue border-b-2 border-schoolblue transition">Informasi Profil</button>
                        <button id="subtab-btn-keamanan" onclick="switchSubTab('keamanan')" class="subtab-btn pb-3 text-slate-400 hover:text-slate-600 transition">Keamanan & Sandi</button>
                        <button id="subtab-btn-notifikasi" onclick="switchSubTab('notifikasi')" class="subtab-btn pb-3 text-slate-400 hover:text-slate-600 transition">Notifikasi</button>
                    </div>

                    <!-- KONTEN SUB-TAB 1: INFORMASI PROFIL -->
                    <div id="subtab-profil" class="subtab-content space-y-6">
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                            <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-schoolblue"></i> Detail Data Guru Pembimbing
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Departemen / Kompetensi Keahlian Binaan</label>
                                    <input type="text" value="Rekayasa Perangkat Lunak dan Gim (PPLG)" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Nomor Induk Pegawai (NIP)</label>
                                    <input type="text" value="196805121994032001" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Nomor Telepon / WhatsApp</label>
                                    <input type="text" value="0812-9876-5432" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Jumlah Instansi DUDI Binaan</label>
                                    <input type="text" value="3 Instansi Mitra DUDI" disabled class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs bg-slate-50 text-slate-500 font-medium cursor-not-allowed">
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button onclick="alert('Perubahan profil berhasil disimpan!')" class="px-6 py-2.5 bg-schoolblue text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-600/20">
                                    Simpan Perubahan Profil
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KONTEN SUB-TAB 2: KEAMANAN & SANDI -->
                    <div id="subtab-keamanan" class="subtab-content space-y-6 hidden">
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                            <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                <i class="fa-solid fa-lock text-schoolblue"></i> Perbarui Kata Sandi Akun
                            </h4>
                            <p class="text-xs text-slate-500">Pastikan akun Anda menggunakan kata sandi yang kuat untuk menjaga kerahasiaan data penilaian siswa PKL.</p>

                            <div class="space-y-4 max-w-xl">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Kata Sandi Saat Ini</label>
                                    <input type="password" placeholder="••••••••••••" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Kata Sandi Baru</label>
                                    <input type="password" placeholder="Minimal 8 karakter" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" placeholder="Ulangi kata sandi baru" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button onclick="alert('Kata sandi berhasil diperbarui!')" class="px-6 py-2.5 bg-schoolblue text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-600/20">
                                    Perbarui Sandi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KONTEN SUB-TAB 3: NOTIFIKASI -->
                    <div id="subtab-notifikasi" class="subtab-content space-y-6 hidden">
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                            <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                <i class="fa-solid fa-bell text-schoolblue"></i> Pengaturan Preferensi Notifikasi
                            </h4>
                            <p class="text-xs text-slate-500">Pilih jenis pemberitahuan yang ingin Anda terima melalui sistem atau perangkat seluler.</p>

                            <div class="space-y-4 divide-y divide-slate-100">
                                <div class="flex items-center justify-between pt-3">
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-800">Logbook Harian Siswa Baru</h5>
                                        <p class="text-[11px] text-slate-500">Terima notifikasi ketika siswa bimbingan mengunggah logbook harian.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-schoolblue"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between pt-4">
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-800">Pembaruan Validasi Mentor Industri</h5>
                                        <p class="text-[11px] text-slate-500">Pemberitahuan saat mentor DUDI menyetujui absensi atau nilai siswa.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" checked class="sr-only peer">
                                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-schoolblue"></div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between pt-4">
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-800">Pengingat Rekap Nilai Akhir PKL</h5>
                                        <p class="text-[11px] text-slate-500">Kirim pengingat otomatis menjelang batas akhir pengumpulan nilai rapor.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-schoolblue"></div>
                                    </label>
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button onclick="alert('Pengaturan notifikasi berhasil disimpan!')" class="px-6 py-2.5 bg-schoolblue text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-600/20">
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Script Navigasi Utama & Sub-Tab Pengaturan -->
    <script>
        function switchTab(tabId) {
            // Sembunyikan semua konten tab utama
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(el => el.classList.add('hidden'));

            // Tampilkan tab utama yang dipilih
            const target = document.getElementById('tab-' + tabId);
            if(target) target.classList.remove('hidden');

            // Ubah status aktif pada menu sidebar utama
            const links = document.querySelectorAll('.nav-link');
            links.forEach(link => {
                link.classList.remove('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                link.classList.add('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                if(link.getAttribute('href') === '#' + tabId) {
                    link.classList.remove('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                    link.classList.add('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                }
            });
        }

        // Fungsi Switch Sub-Tab Pengaturan (Profil, Keamanan, Notifikasi)
        function switchSubTab(subId) {
            // Sembunyikan semua konten sub-tab
            const subContents = document.querySelectorAll('.subtab-content');
            subContents.forEach(el => el.classList.add('hidden'));

            // Tampilkan sub-tab yang dipilih
            const targetSub = document.getElementById('subtab-' + subId);
            if(targetSub) targetSub.classList.remove('hidden');

            // Perbarui styling tombol navigasi sub-tab
            const subBtns = document.querySelectorAll('.subtab-btn');
            subBtns.forEach(btn => {
                btn.classList.remove('text-schoolblue', 'border-b-2', 'border-schoolblue');
                btn.classList.add('text-slate-400', 'hover:text-slate-600');
            });

            const activeBtn = document.getElementById('subtab-btn-' + subId);
            if(activeBtn) {
                activeBtn.classList.remove('text-slate-400', 'hover:text-slate-600');
                activeBtn.classList.add('text-schoolblue', 'border-b-2', 'border-schoolblue');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('inset-y-0');
            sidebar.classList.toggle('left-0');
        }
    </script>
</body>
</html>
