<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem PKL SMKN 1 Depok</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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

        <!-- SIDEBAR ADMIN -->
        <aside id="sidebar" class="hidden md:flex flex-col w-64 bg-schoolnavy text-white transition-all duration-300 z-30">
            <!-- Brand / Logo Header -->
            <div class="h-20 flex items-center px-6 gap-3 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40">
                    <i class="fa-solid fa-user-shield text-lg"></i>
                </div>
                <div>
                    <span class="text-xs font-black tracking-wider text-white block uppercase">Admin Pusat</span>
                    <span class="text-[10px] text-blue-300 font-medium">Monitoring PKL</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors bg-schoolblue text-white shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#manajemen" onclick="switchTab('manajemen')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-users-gear w-5 text-center"></i>
                    <span>Manajemen Akun</span>
                </a>
                <a href="#plotting" onclick="switchTab('plotting')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-object-group w-5 text-center"></i>
                    <span>Plotting & Kelompok</span>
                </a>
                <a href="#timeline" onclick="switchTab('timeline')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Timeline Periode PKL</span>
                </a>
                <a href="#settings" onclick="switchTab('settings')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Setting</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-blue-950">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/15 transition text-xs font-semibold">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Keluar Sistem</span>
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
                        <h2 id="page-title" class="text-xl font-bold text-schoolnavy">Dashboard Administrator</h2>
                        <p class="text-xs text-slate-500">Pusat Kendali Sistem Informasi PKL SMKN 1 Depok</p>
                    </div>
                </div>

                <!-- Admin Profile Badge -->
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">Drs. H. Administrator</span>
                        <span class="block text-xs text-slate-500">Role: Super Admin</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-schoolnavy text-white flex items-center justify-center font-bold shadow-md text-sm border-2 border-schoolblue">
                        AD
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- 1. TAB: DASHBOARD ADMIN -->
                <div id="tab-dashboard" class="tab-content space-y-6">

                    <!-- HERO BANNER -->
                    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white p-6 md:p-8 rounded-3xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                        <div class="space-y-3 z-10">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-schoolnavy border border-blue-600/40 text-blue-200 text-xs font-semibold tracking-wide">
                                <i class="fa-solid fa-shield-halved text-[11px]"></i> Pusat Kendali Administrator Hubin & BKK
                            </div>
                            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                                Selamat Datang,Admin!
                            </h1>
                            <p class="text-xs md:text-sm text-blue-100/90 max-w-2xl leading-relaxed">
                                Berikut adalah ringkasan sistem pengelolaan PKL SMKN 1 Depok &bull; Tahun Ajaran 2023/2024 &bull; Sistem Input Logbook: <span class="text-emerald-400 font-bold">DIBUKA</span>
                            </p>
                        </div>
                        <div class="hidden lg:flex items-center justify-center w-24 h-24 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md shadow-inner text-blue-200 z-10 flex-shrink-0">
                            <i class="fa-solid fa-building-columns text-4xl"></i>
                        </div>
                    </div>

                    <!-- KONTEN UTAMA: RINGKASAN ADMIN -->
                    <div class="space-y-6">
                        <!-- 4 Kartu Statistik Atas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Akun Terdaftar</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">142 Akun</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <a href="#manajemen" onclick="switchTab('manajemen')" class="text-xs font-semibold text-schoolblue hover:underline">Lihat Detail &rarr;</a>
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center font-bold"><i class="fa-solid fa-users"></i></div>
                                </div>
                            </div>
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kapasitas Kuota DUDI</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">120 / 150</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <span class="text-xs font-semibold text-emerald-600">25 Perusahaan Mitra</span>
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold"><i class="fa-solid fa-building"></i></div>
                                </div>
                            </div>
                            <div class="bg-red-50/60 p-5 rounded-2xl shadow-sm border border-red-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-red-600 uppercase tracking-wider">Siswa Perlu Perhatian</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">3 Siswa</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-red-100">
                                    <span class="text-xs font-semibold text-red-600">Tindak Lanjut &rarr;</span>
                                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                </div>
                            </div>
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kelulusan & Pengesahan</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">115 / 120</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <span class="text-xs font-semibold text-purple-600 cursor-pointer hover:underline">Unduh Arsip & PDF &rarr;</span>
                                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold"><i class="fa-solid fa-award"></i></div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid Bawah -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                                <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                    <i class="fa-solid fa-bolt text-schoolblue"></i> Aksi Cepat Administrator
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div onclick="switchTab('manajemen')" class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-schoolblue flex items-center justify-center font-bold flex-shrink-0 mt-0.5"><i class="fa-solid fa-user-plus"></i></div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Tambah / Reset Akun Siswa & Guru</h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun baru atau edit data pengguna.</p>
                                        </div>
                                    </div>
                                    <div onclick="switchTab('plotting')" class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0 mt-0.5"><i class="fa-solid fa-object-group"></i></div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Plotting & Penempatan Siswa</h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Atur penempatan kelompok dan pembimbing industri.</p>
                                        </div>
                                    </div>
                                    <div class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold flex-shrink-0 mt-0.5"><i class="fa-solid fa-bullhorn"></i></div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Kirim Peringatan WA</h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Intervensi langsung siswa yang absensinya kurang.</p>
                                        </div>
                                    </div>
                                    <div class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold flex-shrink-0 mt-0.5"><i class="fa-solid fa-print"></i></div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Cetak Dokumen & Pengesahan</h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Generate berkas kelulusan massal berlembar tanda tangan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-2xl shadow-sm border border-amber-200 flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-bold text-amber-900 text-sm flex items-center gap-2">
                                            <i class="fa-solid fa-clock text-amber-600"></i> Masa Aktif PKL
                                        </h4>
                                        <span class="bg-amber-900 text-white text-[10px] font-bold px-2 py-0.5 rounded">TA 2023/2024</span>
                                    </div>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        Masa pengisian logbook harian oleh siswa aktif hingga <strong class="text-amber-950 font-bold">2026-12-09</strong> pukul <strong class="text-amber-950 font-bold">21:00 WIB</strong>.
                                    </p>
                                    <div class="bg-white/80 border border-amber-200/60 p-3 rounded-xl space-y-1">
                                        <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Pengumuman Terpasang:</span>
                                        <p class="text-[11px] text-slate-700 leading-tight">
                                            <i class="fa-solid fa-bullhorn text-amber-600 mr-1"></i> Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB.
                                        </p>
                                    </div>
                                </div>
                                <button onclick="switchTab('timeline')" class="w-full py-2.5 bg-[#0b1c3d] hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow transition flex items-center justify-center gap-2">
                                    Konfigurasi Jadwal & Deadline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. TAB: MANAJEMEN AKUN (DIPERBARUI DENGAN MULTI AKUN & PAGINATION) -->
                <div id="tab-manajemen" class="tab-content space-y-6 hidden">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div>
                            <h3 class="font-bold text-schoolnavy text-lg flex items-center gap-2">
                                <i class="fa-solid fa-users-gear text-schoolblue"></i> Manajemen Akun Pengguna Sistem
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola data akun hak akses untuk Administrator, Guru Pembimbing, Siswa PKL, dan Mentor DUDI.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition flex items-center gap-2">
                                <i class="fa-solid fa-file-excel text-emerald-600"></i> Import Excel
                            </button>
                            <button class="px-4 py-2 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-600/20 transition flex items-center gap-2">
                                <i class="fa-solid fa-user-plus"></i> Tambah Akun Baru
                            </button>
                        </div>
                    </div>

                    <!-- Ringkasan Kartu Filter Role Akun -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Super Admin</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">2 Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Guru Pembimbing</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">15 Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-schoolblue flex items-center justify-center font-bold">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siswa PKL</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">120 Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mentor DUDI</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">25 Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Tabel Data & Pencarian -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <div class="relative w-full md:w-80">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                    </span>
                                    <input type="text" placeholder="Cari nama, email, atau NISN..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue transition">
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                                <select class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-schoolblue">
                                    <option value="">Semua Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="guru">Guru Pembimbing</option>
                                    <option value="siswa">Siswa PKL</option>
                                    <option value="dudi">Mentor DUDI</option>
                                </select>
                                <select class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-schoolblue">
                                    <option value="">Status: Aktif</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non-Aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tabel Pengguna Multi Role -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-slate-200">
                                        <th class="py-3 px-6">Pengguna</th>
                                        <th class="py-3 px-6">Role / Hak Akses</th>
                                        <th class="py-3 px-6">Kelas / Departemen</th>
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                                    <!-- Baris 1: Super Admin -->
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="py-3.5 px-6 flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center flex-shrink-0 text-xs">DA</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block">Drs. H. Administrator</span>
                                                <span class="text-[11px] text-slate-400">admin.pusat@smkn1depok.sch.id</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-6"><span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-semibold text-[11px] border border-indigo-100">Super Admin</span></td>
                                        <td class="py-3.5 px-6 text-slate-500">Hubin & BKK</td>
                                        <td class="py-3.5 px-6"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                                        <td class="py-3.5 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button title="Edit Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-schoolblue transition flex items-center justify-center"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button title="Hapus Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 transition flex items-center justify-center"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Baris 2: Guru Pembimbing -->
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="py-3.5 px-6 flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-blue-100 text-schoolblue font-bold flex items-center justify-center flex-shrink-0 text-xs">HW</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block">Bpk. Hendra Wijaya, S.Kom</span>
                                                <span class="text-[11px] text-slate-400">hendra.wijaya@smkn1depok.sch.id</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-6"><span class="px-2.5 py-1 rounded-lg bg-blue-50 text-schoolblue font-semibold text-[11px] border border-blue-100">Guru Pembimbing</span></td>
                                        <td class="py-3.5 px-6 text-slate-500">PPLG (Rumpun IT)</td>
                                        <td class="py-3.5 px-6"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                                        <td class="py-3.5 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button title="Edit Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-schoolblue transition flex items-center justify-center"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button title="Hapus Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 transition flex items-center justify-center"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Baris 3: Siswa PKL -->
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="py-3.5 px-6 flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center flex-shrink-0 text-xs">SN</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block">Siti Nurhaliza</span>
                                                <span class="text-[11px] text-slate-400">NIS: 102939 | PPLG-1</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-6"><span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-semibold text-[11px] border border-emerald-100">Siswa PKL</span></td>
                                        <td class="py-3.5 px-6 text-slate-500">XII PPLG 1</td>
                                        <td class="py-3.5 px-6"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                                        <td class="py-3.5 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button title="Edit Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-schoolblue transition flex items-center justify-center"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button title="Hapus Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 transition flex items-center justify-center"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Baris 4: Mentor DUDI -->
                                    <tr class="hover:bg-slate-50/70 transition">
                                        <td class="py-3.5 px-6 flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center flex-shrink-0 text-xs">BS</div>
                                            <div>
                                                <span class="font-bold text-slate-900 block">Budi Setiawan, S.T</span>
                                                <span class="text-[11px] text-slate-400">budi@solusidigital.co.id</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-6"><span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 font-semibold text-[11px] border border-amber-100">Mentor DUDI</span></td>
                                        <td class="py-3.5 px-6 text-slate-500">PT. Solusi Digital Indonesia</td>
                                        <td class="py-3.5 px-6"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                                        <td class="py-3.5 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button title="Edit Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-schoolblue transition flex items-center justify-center"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button title="Hapus Akun" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 transition flex items-center justify-center"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION FOOTER -->
                        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 bg-slate-50/50">
                            <div>
                                Menampilkan <span class="font-bold text-slate-700">1</span> sampai <span class="font-bold text-slate-700">4</span> dari <span class="font-bold text-slate-700">142</span> total akun
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-400 cursor-not-allowed font-semibold"><i class="fa-solid fa-chevron-left text-[10px]"></i> Prev</button>
                                <button class="px-3 py-1.5 rounded-lg border border-schoolblue bg-schoolblue text-white font-bold shadow-sm">1</button>
                                <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold">2</button>
                                <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold">3</button>
                                <span class="px-1 text-slate-400">...</span>
                                <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold">36</button>
                                <button class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold">Next <i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. TAB: PLOTTING & KELOMPOK PKL -->
                <div id="tab-plotting" class="tab-content space-y-6 hidden">

                    <!-- Header -->
                    <div class="space-y-1">
                        <h3 class="font-bold text-schoolnavy text-lg">Plotting & Kelompok PKL</h3>
                        <p class="text-xs text-slate-500">Manajemen penempatan siswa dan bimbingan industri.</p>
                    </div>

                    <!-- Card Form Tambah Kelompok PKL -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-5">

                        <!-- Judul Form -->
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-4">
                            <div class="w-7 h-7 rounded-full bg-blue-50 text-schoolblue flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-circle-plus"></i>
                            </div>
                            <h4 class="font-bold text-schoolnavy text-sm">Tambah Kelompok PKL</h4>
                        </div>

                        <!-- 1. Pilih Jurusan -->
                        <div class="space-y-1.5 text-xs">
                            <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">1. Pilih Jurusan</label>
                            <div class="relative">
                                <select class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium appearance-none">
                                    <option>Pengembangan Perangkat Lunak dan Gim (PPLG)</option>
                                    <option>Teknik Jaringan Komputer dan Telekomunikasi (TJKT)</option>
                                    <option>Animasi</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 text-xs">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                        </div>

                        <!-- 2. Pilih Siswa -->
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">2. Pilih Siswa</label>
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-bold rounded border border-amber-200">1/5 Terpilih</span>
                            </div>

                            <!-- Kotak Container Checkbox Siswa -->
                            <div class="border border-slate-200 rounded-xl bg-slate-50/50 p-3 space-y-3">
                                <!-- Input Pencarian Siswa -->
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 text-xs">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" placeholder="Cari nama siswa..." class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-schoolblue text-xs text-slate-700">
                                </div>

                                <!-- List Item Siswa -->
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                    <label class="flex items-start gap-3 p-2.5 bg-white border border-slate-200 rounded-xl hover:border-blue-300 cursor-pointer transition">
                                        <input type="checkbox" class="mt-0.5 rounded border-slate-300 text-schoolblue focus:ring-schoolblue w-4 h-4">
                                        <div>
                                            <span class="font-bold text-slate-900 block text-xs">Ahmad Budi Santoso</span>
                                            <span class="text-[10px] text-slate-400">NIS: 102938 | PPLG-1</span>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 p-2.5 bg-blue-50/70 border border-blue-200 rounded-xl cursor-pointer transition">
                                        <input type="checkbox" checked class="mt-0.5 rounded border-slate-300 text-schoolblue focus:ring-schoolblue w-4 h-4">
                                        <div>
                                            <span class="font-bold text-slate-900 block text-xs">Siti Nurhaliza</span>
                                            <span class="text-[10px] text-slate-500">NIS: 102939 | PPLG-1</span>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-3 p-2.5 bg-white border border-slate-200 rounded-xl hover:border-blue-300 cursor-pointer transition">
                                        <input type="checkbox" class="mt-0.5 rounded border-slate-300 text-schoolblue focus:ring-schoolblue w-4 h-4">
                                        <div>
                                            <span class="font-bold text-slate-900 block text-xs">Rizky Firmansyah</span>
                                            <span class="text-[10px] text-slate-400">NIS: 102940 | PPLG-2</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Nama Label Kelompok (Opsional) -->
                        <div class="space-y-1.5 text-xs">
                            <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">Nama Label Kelompok (Opsional)</label>
                            <input type="text" placeholder="Contoh: Kelompok Alpha, Tim Mobile Dev 1..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium">
                        </div>

                        <!-- Grid 3 & 4 (Tempat PKL & Guru Pembimbing) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">3. Nama Tempat PKL (DUDI) <span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Contoh: PT. Teknologi Nusantara" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">4. Guru Pembimbing Sekolah</label>
                                <div class="relative">
                                    <select class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium appearance-none">
                                        <option>Bpk. Hendra Wijaya, S.Kom</option>
                                        <option>Ibu Rini Astuti, M.Pd</option>
                                        <option>Bpk. Ahmad Fauzi, S.T</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 text-xs">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Pembimbing Industri (DUDI) -->
                        <div class="space-y-1.5 text-xs">
                            <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">5. Pembimbing Industri (DUDI)</label>
                            <input type="text" placeholder="Pilih atau ketik nama pembimbing di kantor industri..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium">
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end pt-2">
                            <button class="px-6 py-3 bg-[#0b1c3d] hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-circle-check"></i> Simpan Kelompok (Done)
                            </button>
                        </div>
                    </div>

                    <!-- Bagian Daftar Kelompok Aktif -->
                    <div class="space-y-3 pt-2">
                        <h4 class="font-bold text-schoolnavy text-base">Daftar Kelompok Aktif</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Kartu Kelompok 1 -->
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h5 class="font-bold text-slate-900 text-base">Kelompok Alpha</h5>
                                        <span class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                            <i class="fa-solid fa-building text-slate-400 text-[10px]"></i> PT. Solusi Digital Indonesia
                                        </span>
                                    </div>
                                    <span class="px-2.5 py-1 bg-blue-50 text-schoolblue text-[10px] font-bold rounded-lg border border-blue-100">PPLG</span>
                                </div>

                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">HW</div>
                                    <div class="text-xs">
                                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-semibold">Guru Pembimbing</span>
                                        <span class="font-bold text-slate-800">Bpk. Hendra Wijaya, S.Kom</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                                    <span class="font-semibold text-slate-600 flex items-center gap-1.5"><i class="fa-solid fa-user-group text-slate-400 text-xs"></i> 4 Siswa</span>
                                    <a href="#" class="font-bold text-schoolblue hover:underline flex items-center gap-1">Detail &rarr;</a>
                                </div>
                            </div>

                            <!-- Kartu Kelompok 2 -->
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h5 class="font-bold text-slate-900 text-base">Studio Kreatif</h5>
                                        <span class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                            <i class="fa-solid fa-building text-slate-400 text-[10px]"></i> Animasi Nusantara Studio
                                        </span>
                                    </div>
                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold rounded-lg border border-purple-100">Animasi</span>
                                </div>

                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">RA</div>
                                    <div class="text-xs">
                                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-semibold">Guru Pembimbing</span>
                                        <span class="font-bold text-slate-800">Ibu Rini Astuti, M.Pd</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                                    <span class="font-semibold text-slate-600 flex items-center gap-1.5"><i class="fa-solid fa-user-group text-slate-400 text-xs"></i> 3 Siswa</span>
                                    <a href="#" class="font-bold text-schoolblue hover:underline flex items-center gap-1">Detail &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 4. TAB: TIMELINE PERIODE PKL -->
                <div id="tab-timeline" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <h3 class="font-bold text-schoolnavy text-lg">Pengaturan Periode PKL & Kontrol Timeline Akademik</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Atur jadwal mulai dan selesai masa PKL, buka/tutup akses input jurnal bagi siswa, serta siarkan pengumuman massal.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                            <h4 class="font-bold text-schoolnavy text-sm flex items-center gap-2 border-b pb-3">
                                <i class="fa-regular fa-calendar-days text-schoolblue"></i> 1. Kalender & Jadwal Pelaksanaan PKL
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-1">
                                <div>
                                    <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Tahun Ajaran</label>
                                    <input type="text" value="2023/2024" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Gelombang / Batch</label>
                                    <select class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                        <option>Gelombang 1 (Semester Ganjil)</option>
                                        <option>Gelombang 2 (Semester Genap)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Tanggal Mulai PKL</label>
                                    <input type="text" value="09/01/2023" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Tanggal Selesai PKL</label>
                                    <input type="text" value="12/20/2023" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4 flex flex-col justify-between">
                            <div class="space-y-4">
                                <h4 class="font-bold text-schoolnavy text-sm flex items-center gap-2 border-b pb-3">
                                    <i class="fa-solid fa-lock text-schoolblue"></i> 2. Kontrol Hak Pengisian Jurnal (Lockdown)
                                </h4>
                                <div class="bg-slate-50 border border-slate-200 p-3.5 rounded-xl space-y-1">
                                    <span class="font-bold text-slate-800 text-xs block">Status Input Logbook Siswa</span>
                                    <span class="text-[11px] text-slate-500">Siswa bebas mengisi presensi & logbook harian.</span>
                                </div>
                            </div>
                            <button class="w-full py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow transition">Simpan Kontrol Akses</button>
                        </div>
                    </div>
                </div>

              <!-- 5. TAB: SETTING / PENGATURAN SISTEM (DITAMBAHKAN DI SINI) -->
                <div id="tab-settings" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <h3 class="font-bold text-schoolnavy text-lg flex items-center gap-2">
                            <i class="fa-solid fa-gear text-schoolblue"></i> Pengaturan Sistem & Konfigurasi Aplikasi
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kelola konfigurasi umum, identitas instansi, batas keamanan, dan preferensi notifikasi sistem PKL.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Menu Navigasi Pengaturan (Kiri) -->
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 space-y-1 h-fit">
                            <button onclick="switchSettingSub('umum')" id="btn-setting-umum" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition bg-blue-50 text-schoolblue">
                                <i class="fa-solid fa-sliders w-5 text-center"></i> Pengaturan Umum
                            </button>
                            <button onclick="switchSettingSub('sekolah')" id="btn-setting-sekolah" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-schoolnavy transition">
                                <i class="fa-solid fa-school w-5 text-center"></i> Identitas Sekolah
                            </button>
                            <button onclick="switchSettingSub('keamanan')" id="btn-setting-keamanan" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-schoolnavy transition">
                                <i class="fa-solid fa-shield-halved w-5 text-center"></i> Keamanan & Akun
                            </button>
                            <button onclick="switchSettingSub('notifikasi')" id="btn-setting-notifikasi" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-schoolnavy transition">
                                <i class="fa-solid fa-bell w-5 text-center"></i> Notifikasi & WhatsApp
                            </button>
                        </div>

                        <!-- Konten Form Pengaturan (Kanan) -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Sub-Tab 1: Umum -->
                            <div id="sub-setting-umum" class="setting-section bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-sliders text-schoolblue"></i> Konfigurasi Sistem Utama
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Aplikasi / Sistem</label>
                                        <input type="text" value="Sistem Informasi PKL SMKN 1 Depok" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Ajaran Aktif</label>
                                            <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                                <option selected>2023/2024</option>
                                                <option>2024/2025</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Sistem Logbook</label>
                                            <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                                <option selected>Dibuka (Aktif)</option>
                                                <option>Ditutup (Maintenance)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Pesan Pengumuman Global (Banner Dashboard)</label>
                                        <textarea rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB.</textarea>
                                    </div>
                                </div>
                                <div class="flex justify-end pt-2">
                                    <button class="px-5 py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition">Simpan Perubahan</button>
                                </div>
                            </div>

                            <!-- Sub-Tab 2: Sekolah -->
                            <div id="sub-setting-sekolah" class="setting-section bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6 hidden">
                                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-school text-schoolblue"></i> Identitas Instansi / Sekolah
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Resmi Sekolah</label>
                                            <input type="text" value="SMKN 1 Depok" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                                            <input type="text" value="Jl. Raya Bogor KM. 33, Cisalak, Sukmajaya, Depok" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                                            <input type="email" value="info@smkn1depok.sch.id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / Kontak</label>
                                            <input type="text" value="(021) 8740631" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end pt-2">
                                    <button class="px-5 py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition">Simpan Perubahan</button>
                                </div>
                            </div>

                            <!-- Sub-Tab 3: Keamanan -->
                            <div id="sub-setting-keamanan" class="setting-section bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6 hidden">
                                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-shield-halved text-schoolblue"></i> Keamanan & Kata Sandi Administrator
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                                        <input type="password" placeholder="••••••••••••" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Baru</label>
                                        <input type="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                                        <input type="password" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    </div>
                                </div>
                                <div class="flex justify-end pt-2">
                                    <button class="px-5 py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition">Perbarui Kata Sandi</button>
                                </div>
                            </div>

                            <!-- Sub-Tab 4: Notifikasi -->
                            <div id="sub-setting-notifikasi" class="setting-section bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6 hidden">
                                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-bell text-schoolblue"></i> Pengaturan Notifikasi & Gateway WhatsApp
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl">
                                        <div>
                                            <span class="block font-bold text-slate-800 text-xs">Kirim Notifikasi Otomatis via WhatsApp</span>
                                            <span class="text-[11px] text-slate-500">Kirim peringatan absen dan rekap logbook langsung ke nomor siswa/orang tua.</span>
                                        </div>
                                        <input type="checkbox" checked class="w-4 h-4 text-schoolblue rounded border-slate-300 focus:ring-schoolblue">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">API Token WhatsApp Gateway</label>
                                        <input type="text" value="WA_TOKEN_SMKN1DEPOK_SECURE_9981" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue font-mono">
                                    </div>
                                </div>
                                <div class="flex justify-end pt-2">
                                    <button class="px-5 py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-600/20 transition">Simpan Pengaturan</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>



    <!-- JAVASCRIPT CONTROLLER -->
    <script>
        function switchTab(tabId) {
            // Sembunyikan semua konten tab
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(el => el.classList.add('hidden'));

            // Tampilkan tab yang dipilih
            const targetTab = document.getElementById('tab-' + tabId);
            if (targetTab) {
                targetTab.classList.remove('hidden');
            }

            // Perbarui judul halaman di topbar sesuai pilihan
            const titles = {
                'dashboard': ['Dashboard Administrator', 'Pusat Kendali Sistem Informasi PKL SMKN 1 Depok'],
                'manajemen': ['Manajemen Akun Pengguna', 'Kelola hak akses Admin, Guru, Siswa, dan Mentor DUDI'],
                'plotting': ['Plotting & Kelompok PKL', 'Manajemen penempatan siswa dan bimbingan industri'],
                'timeline': ['Timeline & Jadwal PKL', 'Pengaturan tenggat waktu dan agenda kegiatan'],
                'settings': ['Pengaturan Sistem', 'Konfigurasi profil institusi dan keamanan']
            };

            if (titles[tabId]) {
                document.getElementById('page-title').innerText = titles[tabId][0];
                document.querySelector('header p').innerText = titles[tabId][1];
            }

            // Perbarui status aktif pada link sidebar
            const links = document.querySelectorAll('.nav-link');
            links.forEach(link => {
                link.classList.remove('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                link.classList.add('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                if (link.getAttribute('href') === '#' + tabId) {
                    link.classList.add('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                    link.classList.remove('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                }
            });

            // Tutup sidebar otomatis di perangkat mobile setelah diklik
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768) {
                sidebar.classList.add('hidden');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            if (!sidebar.classList.contains('hidden')) {
                sidebar.classList.add('absolute', 'inset-y-0', 'left-0');
            }
        }
        // Fungsi khusus untuk sub-menu di dalam Halaman Setting
        function switchSettingSub(subId) {
            const sections = document.querySelectorAll('.setting-section');
            sections.forEach(sec => sec.classList.add('hidden'));

            const targetSec = document.getElementById('sub-setting-' + subId);
            if (targetSec) {
                targetSec.classList.remove('hidden');
            }

            const buttons = document.querySelectorAll('#tab-settings .lg\\:col-span-1 button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-50', 'text-schoolblue', 'font-bold');
                btn.classList.add('text-slate-600', 'font-semibold', 'hover:bg-slate-50', 'hover:text-schoolnavy');
            });

            event.currentTarget.classList.remove('text-slate-600', 'font-semibold', 'hover:bg-slate-50', 'hover:text-schoolnavy');
            event.currentTarget.classList.add('bg-blue-50', 'text-schoolblue', 'font-bold');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('h-full');
        }
    </script>
</body>
</html>

