<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mentor - Sistem PKL</title>
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
        <aside id="sidebar"
            class="hidden md:flex flex-col w-64 bg-schoolnavy text-white transition-all duration-300 z-30">
            <!-- Brand / Logo Header -->
            <div class="h-20 flex items-center px-6 gap-3 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div
                    class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <div>
                    <span class="text-xs font-black tracking-wider text-white block uppercase">Jurnal PKL</span>
                    <span class="text-[10px] text-blue-300 font-medium">Digital System</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors bg-schoolblue text-white shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#mahasiswa" onclick="switchTab('mahasiswa')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Daftar Siswa Bimbingan</span>
                </a>
                <a href="#laporan" onclick="switchTab('laporan')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-book-open w-5 text-center"></i>
                    <span>Validasi Jurnal & Laporan</span>
                    <span
                        class="ml-auto bg-schoolred text-white text-xs px-2 py-0.5 rounded-full font-bold">{{ $perluValidasi ?? 0 }}</span>
                </a>
                <a href="#nilai" onclick="switchTab('nilai')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-file-invoice w-5 text-center"></i>
                    <span>Penilaian PKL</span>
                </a>
            </nav>

            <!-- Sidebar Footer / Logout -->
            <div class="p-4 border-t border-blue-950">
                <a href="/"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-red-400 hover:bg-red-500/15 transition text-xs font-semibold">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Keluar</span>
                </a>
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
                        <h2 id="page-title" class="text-xl font-bold text-schoolnavy">Dashboard Pembimbing</h2>
                        <p class="text-xs text-slate-500">Selamat datang kembali, Bpk. Ahmad Fauzi, S.Kom.</p>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">Ahmad Fauzi, S.Kom.</span>
                        <span class="block text-xs text-slate-500">Mentor / Pembimbing Industri</span>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-schoolblue/10 text-schoolblue flex items-center justify-center font-bold border-2 border-schoolblue/20">
                        AF
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- TAB 1: DASHBOARD -->
                <div id="tab-dashboard" class="tab-content space-y-6">
                    <div
                        class="bg-gradient-to-r from-schoolnavy to-blue-900 rounded-2xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
                        <div class="relative z-10 space-y-2 mb-4 md:mb-0">
                            <span
                                class="bg-schoolblue/40 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-blue-400/30">Portal
                                Pembimbing Industri</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Monitoring Aktivitas PKL Siswa</h3>
                            <p class="text-slate-300 text-sm max-w-xl">Kelola absensi, validasi jurnal kegiatan harian,
                                serta berikan penilaian akhir untuk siswa bimbingan Anda dengan mudah.</p>
                        </div>
                        <div
                            class="relative z-10 w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/10 shadow-inner">
                            <i class="fa-solid fa-user-shield text-4xl text-blue-200"></i>
                        </div>
                        <div
                            class="absolute -right-10 -bottom-10 w-60 h-60 bg-schoolblue/20 rounded-full blur-3xl pointer-events-none">
                        </div>
                    </div>

                    <!-- Statistics Cards (Dinamis) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                                <h4 class="text-2xl font-bold text-slate-800">{{ $totalSiswa ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perlu Validasi
                                </p>
                                <h4 class="text-2xl font-bold text-slate-800">{{ $perluValidasi ?? 0 }} Jurnal</h4>
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hadir Hari Ini
                                </p>
                                <h4 class="text-2xl font-bold text-slate-800">{{ $totalSiswa ?? 0 }} Siswa</h4>
                            </div>
                        </div>
                        <div
                            class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Nilai
                                </p>
                                <h4 class="text-2xl font-bold text-slate-800">Draft</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-schoolnavy text-lg">Aktivitas Jurnal Terbaru</h4>
                            <button onclick="switchTab('laporan')"
                                class="text-xs font-semibold text-schoolblue hover:underline">Lihat Semua</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="border-b border-slate-200 text-xs font-semibold text-slate-400 uppercase">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Kegiatan</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @forelse($logbooks ?? [] as $logbook)
                                        <tr class="hover:bg-slate-50">
                                            <td class="py-3 px-4 font-semibold text-slate-800">
                                                {{ $logbook->user->name ?? 'Siswa' }}</td>
                                            <td class="py-3 px-4 text-slate-500">{{ $logbook->tanggal }}</td>
                                            <td class="py-3 px-4 text-slate-600">{{ $logbook->judul_kegiatan }}</td>
                                            <td class="py-3 px-4">
                                                <span
                                                    class="bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-full font-medium">{{ $logbook->status ?? 'Pending' }}</span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <button onclick="switchTab('laporan')"
                                                    class="px-3 py-1 bg-schoolblue text-white text-xs rounded-lg hover:bg-blue-700 transition">Periksa</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-slate-400 text-xs">Belum
                                                ada aktivitas jurnal terbaru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SISWA BIMBINGAN (Dinamis dari Plotting Admin) -->
                <div id="tab-mahasiswa" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Daftar Siswa Bimbingan PKL</h3>
                                <p class="text-xs text-slate-500">Daftar siswa yang ditempatkan di bawah bimbingan Anda
                                    (sesuai plotting admin).</p>
                            </div>
                            <div class="w-full sm:w-auto">
                                <input type="text" placeholder="Cari nama siswa..."
                                    class="w-full sm:w-64 px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-schoolblue">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($siswas ?? [] as $siswa)
                                <div
                                    class="border border-slate-200 rounded-2xl p-5 hover:shadow-md transition bg-slate-50/50 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center space-x-3 mb-3">
                                            <div
                                                class="w-12 h-12 rounded-full bg-schoolnavy text-white font-bold flex items-center justify-center">
                                                {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 text-base">{{ $siswa->name }}</h4>
                                                <p class="text-xs text-slate-500">
                                                    {{ $siswa->school ?? 'SMK Negeri 1 Depok' }}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-1 text-xs text-slate-600 mb-4">
                                            <p><span class="font-semibold text-slate-700">Email:</span>
                                                {{ $siswa->email }}</p>
                                            <p><span class="font-semibold text-slate-700">Jurusan:</span>
                                                {{ $siswa->jurusan ?? 'Rekayasa Perangkat Lunak' }}</p>
                                            <p><span class="font-semibold text-slate-700">Periode:</span> Jul - Okt
                                                2026</p>
                                        </div>
                                    </div>
                                    <button onclick="alert('Melihat detail siswa: {{ $siswa->name }}')"
                                        class="w-full py-2 bg-white border border-slate-300 text-schoolnavy text-xs font-semibold rounded-xl hover:bg-slate-100 transition">Lihat
                                        Detail Profil</button>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm col-span-3 text-center py-8">Belum ada siswa bimbingan
                                    yang di-plotting oleh Admin.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- TAB 3: VALIDASI JURNAL & LAPORAN -->
                <div id="tab-laporan" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">

                        <!-- Header & Sub-Tab Switcher -->
                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Validasi Jurnal & Rekap Laporan</h3>
                                <p class="text-xs text-slate-500">Periksa jurnal harian berdasarkan tanggal atau unduh
                                    rekap laporan lengkap per siswa.</p>
                            </div>
                            <div class="flex bg-slate-100 p-1 rounded-xl text-xs font-semibold">
                                <button onclick="switchSubLaporan('validasi')" id="btn-sub-val"
                                    class="px-4 py-2 rounded-lg bg-white text-schoolnavy shadow-sm transition">Validasi
                                    Harian</button>
                                <button onclick="switchSubLaporan('rekap')" id="btn-sub-rek"
                                    class="px-4 py-2 rounded-lg text-slate-500 hover:text-schoolnavy transition">Rekap
                                    Per Orang & PDF</button>
                            </div>
                        </div>

                        <!-- SUB-VIEW 1: VALIDASI HARIAN -->
                        <div id="sub-val-content" class="space-y-4">
                            <div
                                class="flex flex-col sm:flex-row gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 items-center justify-between">
                                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                                    <div class="flex items-center space-x-2">
                                        <label class="text-xs font-semibold text-slate-600">Tanggal:</label>
                                        <input type="date" value="2026-09-21"
                                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <label class="text-xs font-semibold text-slate-600">Siswa:</label>
                                        <select
                                            class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:outline-none focus:border-schoolblue">
                                            <option>Semua Siswa</option>
                                            @foreach ($siswas ?? [] as $s)
                                                <option>{{ $s->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <span
                                    class="bg-amber-100 text-amber-800 font-semibold text-xs px-3 py-1 rounded-full">{{ count($logbooks ?? []) }}
                                    Jurnal Ditampilkan</span>
                            </div>

                            @forelse($logbooks ?? [] as $logbook)
                                <div
                                    class="border border-slate-200 rounded-2xl p-5 hover:border-schoolblue/50 transition bg-white space-y-4 shadow-sm">
                                    <div
                                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-slate-100 pb-3">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-9 h-9 rounded-full bg-schoolnavy text-white text-xs font-bold flex items-center justify-center">
                                                {{ strtoupper(substr($logbook->user->name ?? 'S', 0, 2)) }}
                                            </div>
                                            <div>
                                                <span
                                                    class="font-bold text-slate-800 text-sm block">{{ $logbook->user->name ?? 'Siswa' }}</span>
                                                <span
                                                    class="text-xs text-slate-500">{{ $logbook->user->jurusan ?? 'Rekayasa Perangkat Lunak' }}</span>
                                            </div>
                                        </div>
                                        <span
                                            class="text-xs bg-schoolblue/10 text-schoolblue px-3 py-1 rounded-full font-semibold">{{ $logbook->tanggal }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-xs font-semibold text-slate-400 uppercase">Kegiatan Utama:</p>
                                        <p class="text-sm font-medium text-slate-700">{{ $logbook->judul_kegiatan }}
                                        </p>
                                        <div
                                            class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                            <span class="font-semibold text-slate-700">Deskripsi/Kendala:</span>
                                            {{ $logbook->deskripsi }}
                                        </div>
                                    </div>

                                    <!-- Form Validasi Status -->
                                    <form action="{{ route('mentor.logbook.update', $logbook->id) }}" method="POST"
                                        class="space-y-3 pt-2 border-t border-slate-100">
                                        @csrf
                                        <div class="space-y-1.5">
                                            <label class="block text-xs font-bold text-schoolnavy uppercase"><i
                                                    class="fa-solid fa-pen-nib mr-1 text-schoolblue"></i> Catatan /
                                                Umpan Balik Mentor</label>
                                            <textarea name="catatan_mentor" rows="2" placeholder="Tulis catatan atau arahan untuk siswa di sini..."
                                                class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs bg-slate-50 focus:outline-none focus:border-schoolblue">{{ $logbook->catatan_mentor }}</textarea>
                                        </div>
                                        <div class="flex items-center justify-end space-x-2 pt-1">
                                            <button type="submit" name="status" value="Revisi"
                                                class="px-4 py-2 bg-amber-500 text-white text-xs font-semibold rounded-xl hover:bg-amber-600 transition flex items-center space-x-1">
                                                <i class="fa-solid fa-pen-to-square"></i><span>Minta Revisi</span>
                                            </button>
                                            <button type="submit" name="status" value="Approved"
                                                class="px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition flex items-center space-x-1">
                                                <i class="fa-solid fa-check"></i><span>Setujui Jurnal</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm text-center py-8">Belum ada jurnal atau laporan dari
                                    siswa bimbingan.</p>
                            @endforelse
                        </div>

                        <!-- SUB-VIEW 2: REKAP LAPORAN PER ORANG & DOWNLOAD PDF -->
                        <div id="sub-rek-content" class="space-y-4 hidden">
                            <div
                                class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <div class="flex items-center space-x-3 w-full sm:w-auto">
                                    <label class="text-xs font-semibold text-slate-600">Pilih Siswa:</label>
                                    <select
                                        class="px-3 py-2 border border-slate-200 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue">
                                        @foreach ($siswas ?? [] as $s)
                                            <option>{{ $s->name }} ({{ $s->jurusan ?? 'RPL' }})</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                            </div>

                            <div class="border border-slate-200 rounded-2xl p-5 bg-white space-y-4">
                                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Rekapitulasi Jurnal Bimbingan
                                        </h4>
                                        <p class="text-xs text-slate-500">Periode Magang: Juli 2026 - Oktober 2026</p>
                                    </div>
                                    <span
                                        class="bg-emerald-100 text-emerald-800 text-xs px-3 py-1 rounded-full font-semibold">Status:
                                        Aktif</span>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse text-xs">
                                        <thead>
                                            <tr class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200">
                                                <th class="py-2.5 px-3">Tanggal</th>
                                                <th class="py-2.5 px-3">Aktivitas Utama</th>
                                                <th class="py-2.5 px-3">Catatan Mentor</th>
                                                <th class="py-2.5 px-3 text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @forelse($logbooks ?? [] as $logbook)
                                                <tr>
                                                    <td class="py-3 px-3 text-slate-600">{{ $logbook->tanggal }}</td>
                                                    <td class="py-3 px-3 text-slate-800 font-medium">
                                                        {{ $logbook->judul_kegiatan }}</td>
                                                    <td class="py-3 px-3 text-slate-500">
                                                        {{ $logbook->catatan_mentor ?? '-' }}</td>
                                                    <td class="py-3 px-3 text-center">
                                                        <span
                                                            class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-semibold">{{ $logbook->status }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-slate-400">Belum
                                                        ada data rekap.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- TAB 4: PENILAIAN -->
                <div id="tab-nilai" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">

                        <div class="border-b border-slate-200 pb-4">
                            <h3 class="font-bold text-schoolnavy text-lg">Form & Manajemen Penilaian Akhir PKL</h3>
                            <p class="text-xs text-slate-500">Berikan penilaian objektif berdasarkan berbagai aspek
                                kompetensi dan kedisiplinan.</p>
                        </div>

                        <!-- Grid Container Utama (Harus membungkus form dan bagian kanan secara berdampingan) -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- BAGIAN KIRI: Form Input Nilai (Mengambil 2 kolom dari 3 kolom) -->
                            <div class="lg:col-span-2 bg-slate-50/50 p-5 rounded-2xl border border-slate-200">
                                <form action="{{ route('mentor.store.nilai') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <h4 class="font-bold text-schoolnavy text-sm uppercase tracking-wider">
                                        <i class="fa-solid fa-pen-to-square mr-1 text-schoolblue"></i> Input Nilai
                                        Siswa
                                    </h4>

                                    <!-- Pilih Siswa Bimbingan -->

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pilih
                                            Siswa (Individu)</label>
                                        <select name="student_id"
                                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue"
                                            required>
                                            <option value="">-- Pilih Nama Siswa --</option>
                                            @forelse($siswas ?? [] as $s)
                                                <option value="{{ $s->id }}">{{ $s->name }} (DUDI:
                                                    {{ $s->tempat_dudi ?? 'Belum ada' }})</option>
                                            @empty
                                                <option value="">Tidak ada siswa bimbingan</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kompetensi
                                                Teknis (0-100)</label>
                                            <input type="number" name="nilai_teknis" placeholder="88"
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white"
                                                required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kedisiplinan
                                                & Absensi (0-100)</label>
                                            <input type="number" name="nilai_disiplin" placeholder="90"
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white"
                                                required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kerjasama
                                                Tim / Sikap (0-100)</label>
                                            <input type="number" name="nilai_kerjasama" placeholder="85"
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white"
                                                required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-semibold text-slate-700 uppercase mb-1">Inisiatif
                                                & Kreativitas (0-100)</label>
                                            <input type="number" name="nilai_inisiatif" placeholder="87"
                                                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white"
                                                required>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-semibold text-slate-700 uppercase mb-1">Catatan &
                                            Ulasan Perkembangan PKL</label>
                                        <textarea name="catatan" rows="3" placeholder="Siswa memiliki kemampuan teknis yang baik..."
                                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full sm:w-auto px-6 py-2.5 bg-schoolblue text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-md">
                                        Simpan & Kunci Nilai
                                    </button>
                                </form>
                            </div>

                            <!-- BAGIAN KANAN: Status Nilai Siswa Bimbingan -->
                            <div class="space-y-4 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                                <h4 class="font-bold text-schoolnavy text-sm uppercase tracking-wider">
                                    <i class="fa-solid fa-clipboard-list mr-1 text-schoolblue"></i> Status Nilai Siswa
                                </h4>
                                <div class="space-y-3">
                                    @forelse($siswas ?? [] as $s)
                                        @php
                                            // Cek apakah siswa ini sudah memiliki data nilai dari mentor di tabel grades
                                            $existingGrade = DB::table('grades')
                                                ->where('student_id', $s->id)
                                                ->whereNotNull('nilai_dudi')
                                                ->first();
                                        @endphp
                                        <div
                                            class="bg-white p-3.5 rounded-xl border border-slate-200 flex items-center justify-between">
                                            <div>
                                                <span
                                                    class="font-semibold text-xs text-slate-800 block">{{ $s->name }}</span>
                                                @if ($existingGrade)
                                                    <span class="text-[10px] text-emerald-600 font-bold"><i
                                                            class="fa-solid fa-check-circle"></i> Sudah Dinilai (DUDI:
                                                        {{ $existingGrade->nilai_dudi }})</span>
                                                @else
                                                    <span class="text-[10px] text-amber-600 font-bold"><i
                                                            class="fa-solid fa-clock"></i> Belum Dinilai</span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-schoolblue font-semibold">Aktif</span>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400 text-center py-4">Belum ada siswa bimbingan.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>

    </main>
    </div>
    </div>

    <!-- JavaScript untuk Navigasi Tab -->
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('tab-' + tabId).classList.remove('hidden');
        }

        function switchSubLaporan(subId) {
            if (subId === 'validasi') {
                document.getElementById('sub-val-content').classList.remove('hidden');
                document.getElementById('sub-rek-content').classList.add('hidden');
                document.getElementById('btn-sub-val').className =
                    "px-4 py-2 rounded-lg bg-white text-schoolnavy shadow-sm transition";
                document.getElementById('btn-sub-rek').className =
                    "px-4 py-2 rounded-lg text-slate-500 hover:text-schoolnavy transition";
            } else {
                document.getElementById('sub-val-content').classList.add('hidden');
                document.getElementById('sub-rek-content').classList.remove('hidden');
                document.getElementById('btn-sub-rek').className =
                    "px-4 py-2 rounded-lg bg-white text-schoolnavy shadow-sm transition";
                document.getElementById('btn-sub-val').className =
                    "px-4 py-2 rounded-lg text-slate-500 hover:text-schoolnavy transition";
            }
        }
    </script>
</body>

</html>
