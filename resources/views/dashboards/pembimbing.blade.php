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

<body class="bg-slate-100 font-sans text-slate-800 antialiased overflow-x-hidden">

    <!-- MOBILE DRAWER OVERLAY -->
    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-black/50 z-30 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="w-64 bg-schoolnavy text-white flex flex-col border-r border-blue-900/40 fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out shadow-2xl">
            <!-- Brand / Logo Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40">
                        <i class="fa-solid fa-chalkboard-user text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-black tracking-wider text-white block uppercase">Guru PKL</span>
                        <span class="text-[10px] text-blue-300 font-medium">Monitoring Sekolah</span>
                    </div>
                </div>
                <!-- Tombol Close Sidebar Khusus Mobile -->
                <button type="button" onclick="toggleSidebar()" class="md:hidden text-blue-200 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors bg-schoolblue text-white shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#penempatan" onclick="switchTab('penempatan')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-building-user w-5 text-center"></i>
                    <span>DUDI & Penempatan</span>
                </a>
                <a href="#monitoring" onclick="switchTab('monitoring')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-clipboard-user w-5 text-center"></i>
                    <span>Monitoring Siswa</span>
                    <span class="ml-auto bg-schoolred text-white text-xs px-2 py-0.5 rounded-full font-bold">28</span>
                </a>
                <a href="#nilai" onclick="switchTab('nilai')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-file-shield w-5 text-center"></i>
                    <span>Rekap & Nilai Akhir</span>
                </a>
                <a href="#settings" onclick="switchTab('settings')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-blue-950">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/15 transition text-xs font-semibold">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- TOP NAVBAR -->
            <header
                class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-20 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button onclick="toggleSidebar()"
                        class="text-slate-500 hover:text-schoolnavy md:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors">
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
                        <span class="block text-sm font-semibold text-slate-800">Guru pembimbing SMKN 1 DEPOK</span>
                        <span class="block text-xs text-slate-500">Role: Guru Pembimbing</span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-schoolblue text-white flex items-center justify-center font-bold shadow-md">
                        SA
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- ================= TAB 1: DASHBOARD ================= -->
                <div id="tab-dashboard" class="tab-content space-y-6">
                    <!-- Banner Selamat Datang -->
                    <div
                        class="bg-gradient-to-r from-schoolnavy to-blue-900 rounded-2xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
                        <div class="relative z-10 space-y-2 mb-4 md:mb-0">
                            <span
                                class="bg-schoolblue/40 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-blue-400/30">Portal
                                Guru Pembimbing</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Selamat Datang,
                                {{ $user->name ?? 'Guru Pembimbing' }}</h3>
                            <p class="text-slate-300 text-sm max-w-xl">Berikut adalah ringkasan tempat PKL (DUDI) yang
                                berada di bawah bimbingan Anda periode tahun ajaran ini.</p>
                        </div>
                        <div
                            class="relative z-10 w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/10 shadow-inner">
                            <i class="fa-solid fa-school-flag text-4xl text-blue-200"></i>
                        </div>
                    </div>

                    <!-- Statistik Singkat -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Siswa
                                    Binaan</p>
                                <h4 class="text-2xl font-bold text-slate-800">{{ $totalSiswaBinaan ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-building"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">DUDI yang Anda
                                    Pegang</p>
                                <h4 class="text-2xl font-bold text-slate-800">{{ $totalInstansi ?? 0 }} Instansi</h4>
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Siswa Sudah
                                    Dinilai</p>
                                <h4 class="text-2xl font-bold text-slate-800">{{ $siswaDinilaiCount ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Tempat PKL (DUDI) Dinamis -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <h4 class="text-base font-bold text-schoolnavy flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-schoolblue"></i> Daftar Tempat PKL (DUDI)
                                Bimbingan Anda
                            </h4>
                            <span class="text-xs text-slate-500 font-medium">Klik tombol untuk memantau siswa</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @forelse($dudiGroups ?? [] as $namaDudi => $siswasDiDudi)
                                @php
                                    $mentor = \App\Models\User::find($siswasDiDudi->first()->mentor_id);
                                    $namaSiswaList = $siswasDiDudi->pluck('name')->implode(', ');
                                @endphp
                                <div
                                    class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:border-schoolblue transition space-y-4 flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-start">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-blue-100 text-schoolblue flex items-center justify-center font-bold">
                                                <i class="fa-solid fa-laptop-code"></i>
                                            </div>
                                            <span
                                                class="bg-blue-50 text-schoolblue text-xs font-bold px-2.5 py-1 rounded-full">{{ $siswasDiDudi->count() }}
                                                Siswa</span>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">{{ $namaDudi }}</h5>
                                            <p class="text-xs text-slate-500 mt-0.5"><i
                                                    class="fa-solid fa-location-dot text-schoolred mr-1"></i> Mitra
                                                Industri PKL SMKN 1 Depok</p>
                                        </div>
                                        <div
                                            class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 text-[11px] space-y-1">
                                            <div class="flex justify-between"><span
                                                    class="text-slate-400">Mentor:</span><span
                                                    class="font-bold text-slate-700">{{ $mentor->name ?? 'Belum ditentukan' }}</span>
                                            </div>
                                            <div class="flex justify-between"><span
                                                    class="text-slate-400">Siswa:</span><span
                                                    class="font-bold text-slate-700 truncate max-w-[150px]">{{ $namaSiswaList }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="switchTab('monitoring')"
                                        class="w-full py-2 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition shadow-sm">
                                        Lihat Detail & Siswa
                                    </button>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 col-span-3 text-center py-6">Belum ada penempatan DUDI
                                    yang diatur.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 2: DUDI & PENEMPATAN ================= -->
                <div id="tab-penempatan" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Manajemen Penempatan Siswa & DUDI</h3>
                                <p class="text-xs text-slate-500">Daftar perusahaan mitra tempat siswa melaksanakan
                                    Praktik Kerja Lapangan.</p>
                            </div>
                            <button onclick="openDudiModal()"
                                class="px-4 py-2 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-2 shadow-sm">
                                <i class="fa-solid fa-plus"></i><span>Tambah Mitra DUDI</span>
                            </button>
                        </div>
                        <!-- MODAL PILIH MITRA DUDI DARI PLOTTING ADMIN -->
                        <div id="dudiModal"
                            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                            <div
                                class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200">
                                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                                    <h3 class="font-bold text-schoolnavy text-base"><i
                                            class="fa-solid fa-building text-schoolblue mr-2"></i> Pilih Mitra DUDI
                                    </h3>
                                    <button onclick="closeDudiModal()"
                                        class="text-slate-400 hover:text-slate-600 font-bold text-lg">&times;</button>
                                </div>

                                <p class="text-xs text-slate-500"> Pilih DUDI untuk memantau atau
                                    menambahkannya ke daftar bimbingan:</p>

                                <!-- Daftar List DUDI Dinamis dari Database -->
                                <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                                    @forelse($dudiGroups ?? [] as $namaDudi => $siswasDiDudi)
                                        @php
                                            $mentor = \App\Models\User::find($siswasDiDudi->first()->mentor_id);
                                        @endphp
                                        <div
                                            class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between hover:bg-blue-50/50 transition">
                                            <div>
                                                <span
                                                    class="font-bold text-slate-800 text-sm block">{{ $namaDudi }}</span>
                                                <span class="text-[11px] text-slate-500">Mentor:
                                                    {{ $mentor->name ?? 'Belum ditentukan' }} &bull; <b
                                                        class="text-schoolblue">{{ $siswasDiDudi->count() }}
                                                        Siswa</b></span>
                                            </div>
                                            <button onclick="selectDudiToView('{{ $namaDudi }}')"
                                                class="px-3 py-1.5 bg-schoolblue text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition">
                                                Pilih & Lihat
                                            </button>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400 text-center py-4">Belum ada data DUDI dari
                                            plotting Admin.</p>
                                    @endforelse
                                </div>

                                <div class="flex justify-end pt-3 border-t border-slate-100">
                                    <button onclick="closeDudiModal()"
                                        class="px-4 py-2 bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-300 transition">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Script untuk Mengontrol Modal -->
                        <script>
                            function openDudiModal() {
                                document.getElementById('dudiModal').classList.remove('hidden');
                            }

                            function closeDudiModal() {
                                document.getElementById('dudiModal').classList.add('hidden');
                            }

                            function selectDudiToView(namaDudi) {
                                closeDudiModal();
                                // Mengarahkan otomatis ke tab rekap nilai dengan filter DUDI yang dipilih
                                window.location.href = "{{ route('dashboard.pembimbing') }}?dudi=" + encodeURIComponent(namaDudi) + "#nilai";
                            }
                        </script>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($dudiGroups ?? [] as $namaDudi => $siswasDiDudi)
                                @php
                                    $mentor = \App\Models\User::find($siswasDiDudi->first()->mentor_id);
                                    $namaSiswaList = $siswasDiDudi->pluck('name')->implode(', ');
                                @endphp
                                <div
                                    class="border border-slate-200 rounded-2xl p-5 bg-gradient-to-br from-white to-slate-50 shadow-sm space-y-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-schoolnavy text-white flex items-center justify-center font-bold text-lg shadow-md">
                                                <i class="fa-solid fa-laptop-code"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 text-base">{{ $namaDudi }}
                                                </h4>
                                                <p class="text-xs text-slate-500"><i
                                                        class="fa-solid fa-location-dot text-slate-400 mr-1"></i>
                                                    Wilayah Kota Depok & Sekitarnya</p>
                                            </div>
                                        </div>
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">{{ $siswasDiDudi->count() }}
                                            Siswa</span>
                                    </div>
                                    <div
                                        class="bg-white p-3 rounded-xl border border-slate-200 flex justify-between items-center text-xs">
                                        <div>
                                            <span class="text-slate-400 block uppercase font-semibold">Mentor
                                                Industri:</span>
                                            <span
                                                class="font-bold text-slate-700">{{ $mentor->name ?? 'Belum ada' }}</span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 block uppercase font-semibold">Anggota
                                                Siswa:</span>
                                            <span
                                                class="font-bold text-slate-700 truncate max-w-[180px]">{{ $namaSiswaList }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-end pt-2 border-t border-slate-100">
                                        <button onclick="switchTab('monitoring')"
                                            class="px-3 py-1.5 bg-schoolblue text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition flex items-center space-x-1.5">
                                            <i class="fa-solid fa-users"></i><span>Monitoring Siswa di Sini</span>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-6 col-span-2">Belum ada data DUDI.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- ================= TAB 3: MONITORING SISWA ================= -->
                <div id="tab-monitoring" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Monitoring Absensi & Logbook Siswa per
                                    DUDI</h3>
                                <p class="text-xs text-slate-500">Pilih tempat penempatan mitra DUDI untuk melihat
                                    daftar siswa, absensi, dan unduh logbook harian.</p>
                            </div>
                        </div>

                        <!-- Filter Select DUDI Dinamis dari Database -->
                        <form method="GET" action="{{ route('dashboard.pembimbing') }}#monitoring"
                            class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/2 space-y-1">
                                <label class="text-xs font-semibold text-slate-600 block">Pilih Instansi / Mitra
                                    DUDI:</label>
                                <select name="monitoring_dudi" onchange="this.form.submit()"
                                    class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium">
                                    <option value="">-- Pilih Instansi DUDI --</option>
                                    @foreach ($dudis ?? [] as $dudi)
                                        @php
                                            $mentor = \App\Models\User::find($dudi->mentor_id);
                                        @endphp
                                        <option value="{{ $dudi->tempat_dudi }}"
                                            {{ ($selectedMonitoringDudi ?? '') == $dudi->tempat_dudi ? 'selected' : '' }}>
                                            {{ $dudi->tempat_dudi }} (Mentor:
                                            {{ $mentor->name ?? 'Belum ditentukan' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-xs text-slate-500 text-right hidden sm:block">
                                @php
                                    $totalSiswaDiDudi = isset($siswasMonitoring) ? $siswasMonitoring->count() : 0;
                                @endphp
                                <span class="font-bold text-schoolnavy block">Total Siswa di DUDI Ini:
                                    {{ $totalSiswaDiDudi }} Orang</span>
                                <span>Status Sinkronisasi: <span
                                        class="text-emerald-600 font-bold">Terhubung</span></span>
                            </div>
                        </form>

                        <!-- Daftar Murid Berdasarkan DUDI Terpilih -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 uppercase text-xs border-b border-slate-200">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4 text-center">Rekap Absensi (Hadir / Izin / Sakit)</th>
                                        <th class="py-3 px-4">Aktivitas Terakhir / Pekerjaan di DUDI</th>
                                        <th class="py-3 px-4 text-center">Aksi & Logbook</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs">
                                    @forelse($siswasMonitoring ?? [] as $siswa)
                                        @php
                                            // Hitung rekap absensi real-time dari tabel attendances
                                            $hadir = DB::table('attendances')
                                                ->where('user_id', $siswa->id)
                                                ->where('status', 'like', '%Hadir%')
                                                ->count();
                                            $izin = DB::table('attendances')
                                                ->where('user_id', $siswa->id)
                                                ->where('status', 'like', '%Izin%')
                                                ->count();
                                            $sakit = DB::table('attendances')
                                                ->where('user_id', $siswa->id)
                                                ->where('status', 'like', '%Sakit%')
                                                ->count();

                                            // Ambil logbook / aktivitas terakhir siswa
                                            $lastLogbook = DB::table('logbooks')
                                                ->where('user_id', $siswa->id)
                                                ->latest('created_at')
                                                ->first();
                                        @endphp
                                        <tr class="hover:bg-slate-50">
                                            <td class="py-3 px-4">
                                                <span
                                                    class="font-bold text-slate-800 text-sm block">{{ $siswa->name }}</span>
                                                <span class="text-[10px] text-slate-400">ID: {{ $siswa->id }} |
                                                    Email: {{ $siswa->email }}</span>
                                            </td>
                                            <!-- Perbaikan tampilan absensi agar tersusun rapi ke samping -->
                                            <td class="py-3 px-4 whitespace-nowrap">
                                                <div class="inline-flex items-center space-x-1.5">
                                                    <span
                                                        class="bg-emerald-100 text-emerald-800 font-bold px-2 py-1 rounded-md text-[11px]">{{ $hadir }}
                                                        Hadir</span>
                                                    <span
                                                        class="bg-amber-100 text-amber-800 font-semibold px-2 py-1 rounded-md text-[11px]">{{ $izin }}
                                                        Izin</span>
                                                    <span
                                                        class="bg-purple-100 text-purple-800 font-semibold px-2 py-1 rounded-md text-[11px]">{{ $sakit }}
                                                        Sakit</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-slate-600">
                                                @if ($lastLogbook)
                                                    <span
                                                        class="font-semibold text-slate-800 block">{{ $lastLogbook->activity ?? ($lastLogbook->deskripsi ?? 'Aktivitas PKL') }}</span>
                                                    <span class="text-[10px] text-slate-400">Dibuat:
                                                        {{ \Carbon\Carbon::parse($lastLogbook->created_at)->diffForHumans() }}
                                                        (Status: {{ $lastLogbook->status }})
                                                    </span>
                                                @else
                                                    <span class="text-slate-400 italic">Belum ada catatan
                                                        logbook</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <a href="{{ route('pembimbing.export.logbook', $siswa->id) }}"
                                                    class="px-3 py-1.5 bg-schoolblue text-white rounded-xl hover:bg-blue-700 transition font-semibold inline-flex items-center space-x-1.5 shadow-sm whitespace-nowrap">
                                                    <i class="fa-solid fa-file-pdf"></i><span>Unduh Logbook</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-6 text-slate-400">Silakan pilih
                                                instansi DUDI di atas untuk memantau absensi dan logbook siswa.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- TAB 4: REKAP & NILAI AKHIR -->
                <div id="tab-nilai" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Input & Rekapitulasi Nilai Akhir PKL per
                                    DUDI</h3>
                                <p class="text-xs text-slate-500">Pilih instansi DUDI untuk menampilkan daftar siswa,
                                    input nilai laporan sekolah (40%), dan unduh PDF laporan.</p>
                            </div>
                            <a href="{{ route('pembimbing.export.excel') }}"
                                class="px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition flex items-center space-x-2 shadow-sm">
                                <i class="fa-solid fa-file-excel"></i><span>Download Rekap Excel</span>
                            </a>
                        </div>

                        <!-- Filter Select DUDI untuk Nilai secara Dinamis -->
                        <form method="GET" action="{{ route('dashboard.pembimbing') }}"
                            class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/2 space-y-1">
                                <label class="text-xs font-semibold text-slate-600 block">Pilih Instansi / Mitra
                                    DUDI:</label>
                                <select name="dudi" onchange="this.form.submit()"
                                    class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium">
                                    <option value="">-- Pilih Instansi DUDI --</option>
                                    @foreach ($dudis ?? [] as $dudi)
                                        @php
                                            $mentor = \App\Models\User::find($dudi->mentor_id);
                                        @endphp
                                        <option value="{{ $dudi->tempat_dudi }}"
                                            {{ ($selectedDudi ?? '') == $dudi->tempat_dudi ? 'selected' : '' }}>
                                            {{ $dudi->tempat_dudi }} (Mentor:
                                            {{ $mentor->name ?? 'Belum ditentukan' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-xs text-slate-500 text-right hidden sm:block">
                                <span class="font-bold text-schoolnavy block">Kombinasi Bobot:</span>
                                <span>Nilai DUDI (60%) + Nilai Laporan (40%)</span>
                            </div>
                        </form>

                        <!-- Tabel Input Nilai Berdasarkan Siswa di DUDI Terpilih -->
                        <div class="overflow-x-auto mt-4">
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
                                    @forelse($siswasBimbingan ?? [] as $siswa)
                                        @php
                                            // Ambil data nilai dari tabel grades berdasarkan student_id
                                            $grade = DB::table('grades')->where('student_id', $siswa->id)->first();
                                        @endphp
                                        <tr class="hover:bg-slate-50">
                                            <td class="py-3 px-4">
                                                <span
                                                    class="font-bold text-slate-800 text-sm block">{{ $siswa->name }}</span>
                                                <span class="text-[10px] text-slate-400">ID:
                                                    {{ $siswa->id }}</span>
                                            </td>
                                            <!-- Nilai DUDI rata-rata dari mentor (60%) -->
                                            <td class="py-3 px-4 text-center font-bold text-slate-700 text-sm">
                                                {{ $grade->nilai_dudi ?? 'Belum Dinilai' }}
                                            </td>
                                            <!-- Form Input Nilai Laporan Sekolah (40%) -->
                                            <td class="py-3 px-4 text-center">
                                                <form action="{{ route('pembimbing.update.laporan', $siswa->id) }}"
                                                    method="POST" class="inline-flex items-center gap-1">
                                                    @csrf
                                                    <input type="number" name="nilai_laporan"
                                                        value="{{ $grade->nilai_laporan ?? '' }}" placeholder="0-100"
                                                        class="w-20 px-2 py-1.5 border border-slate-300 rounded-lg text-center text-xs font-bold text-schoolblue bg-white focus:outline-none"
                                                        required>
                                                    <button type="submit"
                                                        class="px-2.5 py-1.5 bg-schoolblue text-white rounded-lg hover:bg-blue-700 transition font-semibold"
                                                        title="Simpan Nilai">
                                                        <i class="fa-solid fa-floppy-disk"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <!-- Nilai Akhir Otomatis -->
                                            <td class="py-3 px-4 text-center font-extrabold text-schoolblue text-sm">
                                                {{ $grade->nilai_akhir ?? '-' }}
                                            </td>
                                            <!-- Predikat -->
                                            <td class="py-3 px-4 text-center">
                                                <span
                                                    class="bg-blue-100 text-blue-700 font-bold px-2.5 py-1 rounded">{{ $grade->predikat ?? '-' }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-center space-x-1">
                                                <a href="{{ route('export.sertifikat', ['student_id' => $siswa->id]) }}"
                                                    class="px-2.5 py-1.5 bg-schoolred text-white rounded-lg hover:bg-red-700 transition font-semibold inline-block"
                                                    title="Download PDF Laporan/Sertifikat">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-6 text-slate-400">Silakan pilih
                                                instansi DUDI di atas untuk menampilkan daftar siswa bimbingan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 5: SETTINGS (INFORMASI PROFIL) ================= -->
                <div id="tab-settings" class="tab-content space-y-6 hidden">
                    <!-- Kartu Header Profil (Real-Time dari Auth User) -->
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-20 h-20 rounded-full bg-schoolblue text-white flex items-center justify-center font-bold text-2xl shadow-md border-4 border-slate-100">
                                {{ strtoupper(substr($user->name ?? 'G', 0, 2)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-slate-800 text-lg">
                                        {{ $user->name ?? 'Guru Pembimbing' }}</h3>
                                    <span
                                        class="bg-blue-100 text-schoolblue text-[11px] font-bold px-2.5 py-0.5 rounded-full">Guru
                                        Pembimbing</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">SMKN 1 Depok • Vocational Excellence</p>
                                <p class="text-xs text-schoolblue font-medium mt-0.5">
                                    {{ $user->email ?? 'email@smkn1depok.sch.id' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigasi Sub-Tab Pengaturan -->
                    <div class="flex border-b border-slate-200 space-x-6 text-xs font-semibold">
                        <button type="button"
                            class="subtab-btn pb-3 text-schoolblue border-b-2 border-schoolblue transition">Informasi
                            Profil</button>
                    </div>

                    <!-- KONTEN SUB-TAB 1: INFORMASI PROFIL & FORM UPDATE -->
                    <div id="subtab-profil" class="subtab-content space-y-6">
                        <form action="{{ route('pembimbing.update.profile') }}" method="POST"
                            class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                            @csrf
                            <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                <i class="fa-solid fa-user-gear text-schoolblue"></i> Detail Data Guru Pembimbing
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ $user->name ?? '' }}"
                                        class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700"
                                        required>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Nomor Induk Pegawai
                                        (NIP)</label>
                                    <input type="text" name="nip"
                                        value="{{ $user->nip ?? '196805121994032001' }}"
                                        class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Nomor Telepon /
                                        WhatsApp</label>
                                    <input type="text" name="phone"
                                        value="{{ $user->phone ?? '0812-9876-5432' }}"
                                        class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue font-medium text-slate-700">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-semibold text-slate-600 block">Jumlah Instansi DUDI
                                        Binaan (Real-Time)</label>
                                    <input type="text" value="{{ $totalInstansi ?? 0 }} Instansi Mitra DUDI"
                                        disabled
                                        class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs bg-slate-50 text-slate-500 font-medium cursor-not-allowed">
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-schoolblue text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition shadow-md shadow-blue-600/20">
                                    Simpan Perubahan Profil
                                </button>
                            </div>
                        </form>
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
            if (target) target.classList.remove('hidden');

            // Ubah status aktif pada menu sidebar utama
            const links = document.querySelectorAll('.nav-link');
            links.forEach(link => {
                link.classList.remove('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                link.classList.add('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                if (link.getAttribute('href') === '#' + tabId) {
                    link.classList.remove('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                    link.classList.add('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                }
            });

            // Tutup sidebar otomatis di mobile setelah memilih tab
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            }
        }

        // Fungsi Switch Sub-Tab Pengaturan (Profil, Keamanan)
        function switchSubTab(subId) {
            // Sembunyikan semua konten sub-tab
            const subContents = document.querySelectorAll('.subtab-content');
            subContents.forEach(el => el.classList.add('hidden'));

            // Tampilkan sub-tab yang dipilih
            const targetSub = document.getElementById('subtab-' + subId);
            if (targetSub) targetSub.classList.remove('hidden');

            // Perbarui styling tombol navigasi sub-tab
            const subBtns = document.querySelectorAll('.subtab-btn');
            subBtns.forEach(btn => {
                btn.classList.remove('text-schoolblue', 'border-b-2', 'border-schoolblue');
                btn.classList.add('text-slate-400', 'hover:text-slate-600');
            });

            const activeBtn = document.getElementById('subtab-btn-' + subId);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-400', 'hover:text-slate-600');
                activeBtn.classList.add('text-schoolblue', 'border-b-2', 'border-schoolblue');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (!sidebar || !overlay) return;

            sidebar.classList.toggle('-translate-x-full');
            if (overlay.classList.contains('opacity-0')) {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                overlay.classList.add('opacity-0', 'pointer-events-none');
            }
        }
    </script>
</body>

</html>
