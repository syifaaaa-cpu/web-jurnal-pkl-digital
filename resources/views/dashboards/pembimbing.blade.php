<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru Pembimbing - Jurnal PKL Digital</title>
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
        activeTab: ['dashboard', 'penempatan', 'monitoring', 'nilai', 'settings'].includes(window.location.hash.replace('#', ''))
            ? window.location.hash.replace('#', '')
            : (new URLSearchParams(window.location.search).has('monitoring_dudi') ? 'monitoring' : 'dashboard'),
        sidebarOpen: false,
        dudiModalOpen: false,
        titles: {
            dashboard: 'Dashboard Guru Pembimbing',
            penempatan: 'DUDI & Penempatan',
            monitoring: 'Monitoring Siswa',
            nilai: 'Rekap & Nilai Akhir',
            settings: 'Pengaturan Akun'
        }
    }">

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
                        <span class="text-sm font-bold tracking-wide text-white block">Guru PKL</span>
                        <span class="text-xs text-blue-200 font-medium">Monitoring Sekolah</span>
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
                <a href="#penempatan" @click.prevent="activeTab = 'penempatan'; sidebarOpen = false"
                    :class="activeTab === 'penempatan' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-building-user w-5 text-center"></i>
                    <span>DUDI &amp; Penempatan</span>
                </a>
                <a href="#monitoring" @click.prevent="activeTab = 'monitoring'; sidebarOpen = false"
                    :class="activeTab === 'monitoring' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-clipboard-user w-5 text-center"></i>
                    <span>Monitoring Siswa</span>
                    <span class="ml-auto text-xs font-bold text-blue-200 tabular-nums">{{ $totalSiswaBinaan ?? 0 }}</span>
                </a>
                <a href="#nilai" @click.prevent="activeTab = 'nilai'; sidebarOpen = false"
                    :class="activeTab === 'nilai' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-file-shield w-5 text-center"></i>
                    <span>Rekap &amp; Nilai Akhir</span>
                </a>
                <a href="#settings" @click.prevent="activeTab = 'settings'; sidebarOpen = false"
                    :class="activeTab === 'settings' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Settings</span>
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
                        <h2 id="page-title" x-text="titles[activeTab] || 'Dashboard Guru Pembimbing'" class="text-base sm:text-xl font-bold text-primary truncate">Dashboard Guru Pembimbing</h2>
                        <p class="text-xs text-slate-500 truncate hidden sm:block">Portal Resmi Pengawasan PKL SMKN 1 Depok</p>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">{{ $user->name ?? 'Guru Pembimbing' }}</span>
                        <span class="block text-xs text-slate-500">Guru Pembimbing</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($user->name ?? 'GP', 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6">

                <!-- ================= TAB 1: DASHBOARD ================= -->
                <div id="tab-dashboard" x-show="activeTab === 'dashboard'" class="tab-content space-y-6">
                    <!-- Banner Selamat Datang -->
                    <div class="bg-gradient-to-r from-primary to-third rounded-xl p-6 sm:p-8 text-white shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <h3 class="text-xl sm:text-2xl font-bold">Selamat Datang, {{ $user->name ?? 'Guru Pembimbing' }}</h3>
                            <p class="text-blue-100 text-sm max-w-xl leading-relaxed">Berikut adalah ringkasan tempat PKL (DUDI) yang berada di bawah bimbingan Anda periode tahun ajaran ini.</p>
                        </div>
                        <div class="hidden md:flex w-16 h-16 bg-white/10 rounded-xl items-center justify-center shrink-0">
                            <i class="fa-solid fa-school-flag text-2xl text-blue-100"></i>
                        </div>
                    </div>

                    <!-- Statistik Singkat -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-secondary flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Siswa Binaan</p>
                                <h4 class="text-2xl font-bold text-slate-900 tabular-nums">{{ $totalSiswaBinaan ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">DUDI yang Anda Pegang</p>
                                <h4 class="text-2xl font-bold text-slate-900 tabular-nums">{{ $totalInstansi ?? 0 }} Instansi</h4>
                            </div>
                        </div>
                        <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Siswa Sudah Dinilai</p>
                                <h4 class="text-2xl font-bold text-slate-900 tabular-nums">{{ $siswaDinilaiCount ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Tempat PKL (DUDI) Dinamis -->
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
                            <h4 class="text-base sm:text-lg font-bold text-primary flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-secondary"></i> Daftar Tempat PKL (DUDI) Bimbingan Anda
                            </h4>
                            <span class="text-xs text-slate-500 font-medium">Klik tombol untuk memantau siswa</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                            @forelse($dudiGroups ?? [] as $namaDudi => $siswasDiDudi)
                                @php
                                    $mentor = \App\Models\User::find($siswasDiDudi->first()->mentor_id);
                                    $namaSiswaList = $siswasDiDudi->pluck('name')->implode(', ');
                                @endphp
                                <div class="bg-white rounded-xl p-5 shadow-sm space-y-4 flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-secondary flex items-center justify-center">
                                                <i class="fa-solid fa-laptop-code"></i>
                                            </div>
                                            <span class="text-xs font-bold text-secondary">{{ $siswasDiDudi->count() }} Siswa</span>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-base">{{ $namaDudi }}</h5>
                                            <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-location-dot text-schoolred mr-1"></i> Mitra Industri PKL SMKN 1 Depok</p>
                                        </div>
                                        <div class="bg-slate-50 p-3 rounded-lg text-xs space-y-1.5">
                                            <div class="flex justify-between gap-2"><span class="text-slate-500">Mentor:</span><span class="font-semibold text-slate-800">{{ $mentor->name ?? 'Belum ditentukan' }}</span></div>
                                            <div class="flex justify-between gap-2"><span class="text-slate-500">Siswa:</span><span class="font-semibold text-slate-800 truncate max-w-[160px]">{{ $namaSiswaList }}</span></div>
                                        </div>
                                    </div>
                                    <button type="button" @click="activeTab = 'monitoring'"
                                        class="w-full min-h-[44px] py-2 bg-secondary text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-blue-700 transition cursor-pointer">
                                        Lihat Detail &amp; Siswa
                                    </button>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 col-span-3 text-center py-6">Belum ada penempatan DUDI yang diatur.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 2: DUDI & PENEMPATAN ================= -->
                <div id="tab-penempatan" x-show="activeTab === 'penempatan'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h3 class="font-bold text-primary text-lg">Manajemen Penempatan Siswa &amp; DUDI</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Daftar perusahaan mitra tempat siswa melaksanakan Praktik Kerja Lapangan.</p>
                            </div>
                            <button type="button" @click="dudiModalOpen = true"
                                class="w-full sm:w-auto min-h-[44px] px-4 py-2 bg-secondary text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                                <i class="fa-solid fa-plus"></i><span>Tambah Mitra DUDI</span>
                            </button>
                        </div>

                        <!-- MODAL PILIH MITRA DUDI -->
                        <div id="dudiModal" x-show="dudiModalOpen" x-cloak
                            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                            <div @click.outside="dudiModalOpen = false"
                                class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl">
                                <div class="flex justify-between items-center pb-2">
                                    <h3 class="font-bold text-primary text-base sm:text-lg"><i class="fa-solid fa-building text-secondary mr-2"></i> Pilih Mitra DUDI</h3>
                                    <button type="button" @click="dudiModalOpen = false" aria-label="Tutup Modal"
                                        class="text-slate-400 hover:text-slate-600 font-bold text-lg min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer">&times;</button>
                                </div>

                                <p class="text-xs sm:text-sm text-slate-500">Pilih DUDI untuk memantau atau menambahkannya ke daftar bimbingan:</p>

                                <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                                    @forelse($dudiGroups ?? [] as $namaDudi => $siswasDiDudi)
                                        @php
                                            $mentor = \App\Models\User::find($siswasDiDudi->first()->mentor_id);
                                        @endphp
                                        <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between gap-2 hover:bg-blue-50/50 transition">
                                            <div>
                                                <span class="font-bold text-slate-800 text-sm block">{{ $namaDudi }}</span>
                                                <span class="text-xs text-slate-500">Mentor: {{ $mentor->name ?? 'Belum ditentukan' }} &bull; <b class="text-secondary">{{ $siswasDiDudi->count() }} Siswa</b></span>
                                            </div>
                                            <button type="button" @click="dudiModalOpen = false; activeTab = 'monitoring'"
                                                class="min-h-[40px] px-3.5 py-1.5 bg-secondary text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition cursor-pointer shrink-0">
                                                Pilih &amp; Lihat
                                            </button>
                                        </div>
                                    @empty
                                        <p class="text-xs sm:text-sm text-slate-400 text-center py-4">Belum ada data DUDI dari plotting Admin.</p>
                                    @endforelse
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="button" @click="dudiModalOpen = false"
                                        class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl hover:bg-slate-200 transition cursor-pointer">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            @forelse($dudiGroups ?? [] as $namaDudi => $siswasDiDudi)
                                @php
                                    $mentor = \App\Models\User::find($siswasDiDudi->first()->mentor_id);
                                    $namaSiswaList = $siswasDiDudi->pluck('name')->implode(', ');
                                @endphp
                                <div class="rounded-xl p-5 bg-slate-50 space-y-4">
                                    <div class="flex justify-between items-start gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-base shrink-0">
                                                <i class="fa-solid fa-laptop-code"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-base">{{ $namaDudi }}</h4>
                                                <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot text-slate-400 mr-1"></i> Wilayah Kota Depok &amp; Sekitarnya</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-secondary shrink-0">{{ $siswasDiDudi->count() }} Siswa</span>
                                    </div>
                                    <div class="bg-white p-3.5 rounded-xl flex flex-col sm:flex-row justify-between gap-2 text-xs sm:text-sm">
                                        <div>
                                            <span class="text-slate-400 block uppercase text-xs font-semibold">Mentor Industri:</span>
                                            <span class="font-semibold text-slate-800">{{ $mentor->name ?? 'Belum ada' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block uppercase text-xs font-semibold">Anggota Siswa:</span>
                                            <span class="font-semibold text-slate-800 truncate max-w-[200px] block">{{ $namaSiswaList }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" @click="activeTab = 'monitoring'"
                                            class="w-full sm:w-auto min-h-[40px] px-4 py-2 bg-secondary text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-blue-700 transition inline-flex items-center justify-center gap-1.5 cursor-pointer">
                                            <i class="fa-solid fa-users"></i><span>Monitoring Siswa di Sini</span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-6 col-span-2">Belum ada data DUDI.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 3: MONITORING SISWA (LIVEWIRE) ================= -->
                <div id="tab-monitoring" x-show="activeTab === 'monitoring'" x-cloak class="tab-content space-y-6">
                    <livewire:pembimbing-monitoring :initial-dudi="$selectedMonitoringDudi ?? ''" />
                </div>

                <!-- TAB 4: REKAP & NILAI AKHIR -->
                <div id="tab-nilai" x-show="activeTab === 'nilai'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h3 class="font-bold text-primary text-lg">Input &amp; Rekapitulasi Nilai Akhir PKL per DUDI</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Pilih instansi DUDI untuk menampilkan daftar siswa, input nilai laporan sekolah (40%), dan unduh PDF laporan.</p>
                            </div>
                            <a href="{{ route('pembimbing.export.excel') }}"
                                class="w-full sm:w-auto min-h-[44px] px-4 py-2 bg-emerald-600 text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-emerald-700 transition flex items-center justify-center gap-2 shadow-sm">
                                <i class="fa-solid fa-file-excel"></i><span>Download Rekap Excel</span>
                            </a>
                        </div>

                        <!-- Filter Select DUDI -->
                        <form method="GET" action="{{ route('dashboard.pembimbing') }}#nilai"
                            class="bg-slate-50 p-4 rounded-xl flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                            <div class="w-full sm:w-1/2 space-y-1.5">
                                <label class="text-xs sm:text-sm font-semibold text-slate-600 block">Pilih Instansi / Mitra DUDI:</label>
                                <select name="dudi" onchange="this.form.submit()"
                                    class="w-full min-h-[44px] px-3 py-2 border border-slate-200 rounded-xl text-xs sm:text-sm bg-white focus:outline-none focus:border-secondary font-medium">
                                    <option value="">-- Pilih Instansi DUDI --</option>
                                    @foreach ($dudis ?? [] as $dudi)
                                        @php
                                            $mentor = \App\Models\User::find($dudi->mentor_id);
                                        @endphp
                                        <option value="{{ $dudi->tempat_dudi }}"
                                            {{ ($selectedDudi ?? '') == $dudi->tempat_dudi ? 'selected' : '' }}>
                                            {{ $dudi->tempat_dudi }} (Mentor: {{ $mentor->name ?? 'Belum ditentukan' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-xs sm:text-sm text-slate-500 sm:text-right">
                                <span class="font-bold text-primary block">Kombinasi Bobot:</span>
                                <span>Nilai DUDI (60%) + Nilai Laporan (40%)</span>
                            </div>
                        </form>

                        <!-- Tabel Input Nilai -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 uppercase text-xs">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4 text-center">Nilai DUDI (60%)</th>
                                        <th class="py-3 px-4 text-center">Nilai Laporan Sekolah (40%)</th>
                                        <th class="py-3 px-4 text-center">Nilai Akhir</th>
                                        <th class="py-3 px-4 text-center">Predikat</th>
                                        <th class="py-3 px-4 text-center">Aksi Guru &amp; PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswasBimbingan ?? [] as $siswa)
                                        @php
                                            $grade = DB::table('grades')->where('student_id', $siswa->id)->first();
                                        @endphp
                                        <tr class="hover:bg-slate-50 odd:bg-white even:bg-slate-50/40">
                                            <td class="py-3.5 px-4">
                                                <span class="font-bold text-slate-800 text-sm block">{{ $siswa->name }}</span>
                                                <span class="text-xs text-slate-500">ID: {{ $siswa->id }}</span>
                                            </td>
                                            <td class="py-3.5 px-4 text-center font-bold text-slate-700 text-sm tabular-nums">
                                                {{ $grade->nilai_dudi ?? 'Belum Dinilai' }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                <form action="{{ route('pembimbing.update.laporan', $siswa->id) }}"
                                                    method="POST" class="inline-flex items-center gap-1.5">
                                                    @csrf
                                                    <input type="number" name="nilai_laporan"
                                                        value="{{ $grade->nilai_laporan ?? '' }}" placeholder="0-100"
                                                        class="w-20 min-h-[38px] px-2 py-1.5 border border-slate-200 rounded-lg text-center text-xs sm:text-sm font-bold text-secondary bg-white focus:outline-none focus:border-secondary"
                                                        required>
                                                    <button type="submit" aria-label="Simpan Nilai"
                                                        class="min-h-[38px] min-w-[38px] px-2.5 py-1.5 bg-secondary text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                                                        title="Simpan Nilai">
                                                        <i class="fa-solid fa-floppy-disk"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="py-3.5 px-4 text-center font-bold text-secondary text-sm tabular-nums">
                                                {{ $grade->nilai_akhir ?? '-' }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center font-bold text-primary">
                                                {{ $grade->predikat ?? '-' }}
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                <a href="{{ route('export.sertifikat', ['student_id' => $siswa->id]) }}"
                                                    class="min-h-[38px] min-w-[38px] px-3 py-1.5 bg-schoolred text-white rounded-lg hover:bg-red-700 transition font-semibold inline-flex items-center justify-center"
                                                    title="Download PDF Laporan/Sertifikat">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-6 text-slate-400">Silakan pilih instansi DUDI di atas untuk menampilkan daftar siswa bimbingan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 5: SETTINGS ================= -->
                <div id="tab-settings" x-show="activeTab === 'settings'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white rounded-xl p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-xl shrink-0">
                                {{ strtoupper(substr($user->name ?? 'G', 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">{{ $user->name ?? 'Guru Pembimbing' }}</h3>
                                <p class="text-xs sm:text-sm text-slate-500">Guru Pembimbing &bull; SMKN 1 Depok</p>
                                <p class="text-xs sm:text-sm text-secondary font-medium mt-0.5">{{ $user->email ?? 'email@smkn1depok.sch.id' }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('pembimbing.update.profile') }}" method="POST"
                        class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-5">
                        @csrf
                        <h4 class="font-bold text-primary text-base flex items-center gap-2">
                            <i class="fa-solid fa-user-gear text-secondary"></i> Detail Data Guru Pembimbing
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-600 block">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name ?? '' }}"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary font-medium text-slate-700"
                                    required>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-600 block">Nomor Induk Pegawai (NIP)</label>
                                <input type="text" name="nip" value="{{ $user->nip ?? '' }}" placeholder="Contoh: 196805121994032001"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary font-medium text-slate-700">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-600 block">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="phone" value="{{ $user->phone ?? '' }}" placeholder="Contoh: 081298765432"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary font-medium text-slate-700">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-600 block">Jumlah Instansi DUDI Binaan (Real-Time)</label>
                                <input type="text" value="{{ $totalInstansi ?? 0 }} Instansi Mitra DUDI" disabled
                                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-slate-50 text-slate-500 font-medium cursor-not-allowed">
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit"
                                class="w-full sm:w-auto min-h-[44px] px-6 py-2.5 bg-secondary text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition shadow-sm cursor-pointer">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>

            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
