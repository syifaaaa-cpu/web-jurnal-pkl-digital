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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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

        <!-- SIDEBAR ADMIN -->
        <aside id="sidebar"
            class="w-64 bg-schoolnavy text-white flex flex-col border-r border-blue-900/40 fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 md:static transition-transform duration-300 ease-in-out shadow-2xl">
            <!-- Brand / Logo Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40">
                        <i class="fa-solid fa-user-shield text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs font-black tracking-wider text-white block uppercase">Admin Pusat</span>
                        <span class="text-[10px] text-blue-300 font-medium">Monitoring PKL</span>
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
                <a href="#manajemen" onclick="switchTab('manajemen')"
                    class="nav-link flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-users-gear w-5 text-center"></i>
                        <span>Manajemen Akun</span>
                    </div>
                    @if(isset($pendingUsersCount) && $pendingUsersCount > 0)
                        <span class="bg-amber-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow-sm animate-pulse">{{ $pendingUsersCount }}</span>
                    @endif
                </a>
                <a href="#plotting" onclick="switchTab('plotting')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-object-group w-5 text-center"></i>
                    <span>Plotting & Kelompok</span>
                </a>
                <a href="#timeline" onclick="switchTab('timeline')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Timeline Periode PKL</span>
                </a>
                <a href="#settings" onclick="switchTab('settings')"
                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Setting</span>
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
                    <div
                        class="w-10 h-10 rounded-full bg-schoolnavy text-white flex items-center justify-center font-bold shadow-md text-sm border-2 border-schoolblue">
                        AD
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- 1. TAB: DASHBOARD ADMIN -->
                <div id="tab-dashboard" class="tab-content space-y-6">

                    <!-- HERO BANNER -->
                    <div
                        class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white p-6 md:p-8 rounded-3xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
                        <div class="space-y-3 z-10">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-schoolnavy border border-blue-600/40 text-blue-200 text-xs font-semibold tracking-wide">
                                <i class="fa-solid fa-shield-halved text-[11px]"></i> Pusat Kendali Administrator Hubin
                                & BKK
                            </div>
                            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-white">
                                Selamat Datang,Admin!
                            </h1>
                            <p class="text-xs md:text-sm text-blue-100/90 max-w-2xl leading-relaxed">
                                Berikut adalah ringkasan sistem pengelolaan PKL SMKN 1 Depok &bull; Tahun Ajaran
                                2023/2024 &bull; Sistem Input Logbook: <span
                                    class="text-emerald-400 font-bold">DIBUKA</span>
                            </p>
                        </div>
                        <div
                            class="hidden lg:flex items-center justify-center w-24 h-24 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md shadow-inner text-blue-200 z-10 flex-shrink-0">
                            <i class="fa-solid fa-building-columns text-4xl"></i>
                        </div>
                    </div>

                    <!-- KONTEN UTAMA: RINGKASAN ADMIN -->
                    <div class="space-y-6">
                        <!-- 4 Kartu Statistik Atas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                            <!-- 1. Total Akun Terdaftar -->
                            <div
                                class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total
                                        Akun Terdaftar</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">
                                        {{ $totalAkun ?? \App\Models\User::count() }} Akun</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <a href="#manajemen" onclick="switchTab('manajemen')"
                                        class="text-xs font-semibold text-schoolblue hover:underline">Lihat Detail
                                        &rarr;</a>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-users"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Kapasitas Kuota DUDI -->
                            <div
                                class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span
                                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kapasitas
                                        Kuota DUDI</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalSiswaTerplotting ?? 0 }}
                                        / {{ $kapasitasMaksimal ?? 150 }}</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <span
                                        class="text-xs font-semibold text-emerald-600">{{ \App\Models\User::where('role', 'siswa')->whereNotNull('tempat_dudi')->distinct('tempat_dudi')->count('tempat_dudi') }}
                                        Perusahaan Mitra</span>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Siswa Perlu Perhatian -->
                            <div
                                class="bg-red-50/60 p-5 rounded-2xl shadow-sm border border-red-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span class="text-xs font-semibold text-red-600 uppercase tracking-wider">Siswa
                                        Perlu Perhatian</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $countSiswaPerhatian ?? 3 }}
                                        Siswa</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-red-100">
                                    <span onclick="openModalWa()"
                                        class="text-xs font-semibold text-red-600 cursor-pointer hover:underline">Tindak
                                        Lanjut &rarr;</span>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Kelulusan & Pengesahan -->
                            <div
                                class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                <div>
                                    <span
                                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kelulusan
                                        & Pengesahan</span>
                                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $siswaLulus ?? 115 }} /
                                        {{ $totalSemuaSiswa ?? 120 }}</h3>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <span onclick="openModalCetak()"
                                        class="text-xs font-semibold text-purple-600 cursor-pointer hover:underline">Unduh
                                        Arsip & PDF &rarr;</span>
                                    <div
                                        class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-award"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grid Bawah -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div
                                class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                                <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                    <i class="fa-solid fa-bolt text-schoolblue"></i> Aksi Cepat Administrator
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div onclick="switchTab('manajemen')"
                                        class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-blue-100 text-schoolblue flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                            <i class="fa-solid fa-user-plus"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Tambah / Reset Akun Siswa &
                                                Guru</h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun baru atau edit data
                                                pengguna.</p>
                                        </div>
                                    </div>
                                    <div onclick="switchTab('plotting')"
                                        class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                            <i class="fa-solid fa-object-group"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Plotting & Penempatan Siswa
                                            </h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Atur penempatan kelompok dan
                                                pembimbing industri.</p>
                                        </div>
                                    </div>
                                    <!-- Kartu Aksi Cepat: Kirim Peringatan WA -->
                                    <div onclick="openModalWa()"
                                        class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                            <i class="fa-solid fa-bullhorn"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Kirim Peringatan WA</h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Intervensi langsung siswa yang
                                                absensinya kurang.</p>
                                        </div>
                                    </div>

                                    <!-- Kartu Aksi Cepat: Cetak Dokumen -->
                                    <div onclick="openModalCetak()"
                                        class="p-4 rounded-xl border border-slate-200 hover:border-schoolblue transition cursor-pointer bg-slate-50/50 hover:bg-white flex items-start space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                                            <i class="fa-solid fa-print"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-800 text-sm">Cetak Dokumen & Pengesahan
                                            </h5>
                                            <p class="text-xs text-slate-500 mt-0.5">Generate berkas kelulusan massal
                                                berlembar tanda tangan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-amber-50 to-orange-50 p-6 rounded-2xl shadow-sm border border-amber-200 flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-bold text-amber-900 text-sm flex items-center gap-2">
                                            <i class="fa-solid fa-clock text-amber-600"></i> Masa Aktif PKL
                                        </h4>
                                        <span
                                            class="bg-amber-900 text-white text-[10px] font-bold px-2 py-0.5 rounded">TA
                                            {{ session('pk_tahun_ajaran', '2023/2024') }}</span>
                                    </div>
                                    <p class="text-xs text-amber-800 leading-relaxed">
                                        Masa pengisian logbook harian oleh siswa aktif hingga <strong
                                            class="text-amber-950 font-bold">{{ session('pk_tanggal_selesai', '2026-12-09') }}</strong>
                                        pukul <strong class="text-amber-950 font-bold">21:00 WIB</strong>.
                                    </p>
                                    <div class="bg-white/80 border border-amber-200/60 p-3 rounded-xl space-y-1">
                                        <span
                                            class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Pengumuman
                                            Terpasang:</span>
                                        <p class="text-[11px] text-slate-700 leading-tight">
                                            <i class="fa-solid fa-bullhorn text-amber-600 mr-1"></i>
                                            {{ session('setting_pesan_pengumuman', 'Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB.') }}
                                        </p>
                                    </div>
                                </div>
                                <button onclick="switchTab('timeline')"
                                    class="w-full py-2.5 bg-[#0b1c3d] hover:bg-slate-900 text-white rounded-xl font-bold text-xs shadow transition flex items-center justify-center gap-2">
                                    Konfigurasi Jadwal & Deadline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL KIRIM PERINGATAN WA -->
                <div id="modalWa"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
                    <div class="bg-white rounded-2xl w-full max-w-lg p-6 space-y-4 shadow-xl text-xs">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-lg"></i> Kirim Peringatan Absensi
                                via WhatsApp
                            </h4>
                            <button type="button" onclick="closeModalWa()"
                                class="text-slate-400 hover:text-slate-600"><i
                                    class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pilih Siswa yang Perlu
                                    Ditindaklanjuti</label>
                                <select id="select-siswa-wa"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                                    <option value="">-- Pilih Nama Siswa / Ketik Manual --</option>
                                    @foreach (\App\Models\User::where('role', 'siswa')->get() as $siswa)
                                        <option value="{{ $siswa->name }}">{{ $siswa->name }} (DUDI:
                                            {{ $siswa->tempat_dudi ?? 'Belum ada' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp Siswa / Orang Tua
                                    (Format: 628xxx)</label>
                                <input type="text" id="wa-number" placeholder="Contoh: 6281234567890"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pesan Peringatan</label>
                                <textarea id="wa-message" rows="4"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">Halo, diberitahukan kepada orang tua/wali dari siswa peserta PKL SMKN 1 Depok, berdasarkan catatan kehadiran dan jarak geotagging, siswa tersebut memerlukan perhatian khusus. Mohon segera dikonfirmasi. Terima kasih.</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-3">
                            <button type="button" onclick="closeModalWa()"
                                class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-xl">Batal</button>
                            <button type="button" onclick="sendWhatsApp()"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp"></i> Kirim Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function sendWhatsApp() {
                        let phone = document.getElementById('wa-number').value;
                        let studentName = document.getElementById('select-siswa-wa').value;
                        let message = document.getElementById('wa-message').value;

                        if (studentName) {
                            message = `Kepada Yth. Orang Tua / Wali dari ${studentName}.\n\n` + message;
                        }

                        let url = `https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(message)}`;
                        window.open(url, '_blank');
                    }
                </script>
                <!-- MODAL CETAK DOKUMEN & PENGESAHAN -->
                <div id="modalCetak"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
                    <div class="bg-white rounded-2xl w-full max-w-lg p-6 space-y-4 shadow-xl text-xs">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-schoolnavy text-base flex items-center gap-2">
                                <i class="fa-solid fa-print text-purple-600 text-lg"></i> Pusat Unduh & Cetak Dokumen
                                PKL
                            </h4>
                            <button type="button" onclick="closeModalCetak()"
                                class="text-slate-400 hover:text-slate-600"><i
                                    class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <div class="space-y-3">
                            <p class="text-slate-500">Pilih jenis dokumen atau laporan rekapitulasi yang ingin
                                di-generate:</p>
                            <div class="space-y-2">
                                <label
                                    class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-100">
                                    <input type="radio" name="doc_type" value="laporan" checked
                                        class="text-schoolblue" onclick="toggleStudentSelect(false)">
                                    <div>
                                        <span class="font-bold text-slate-800 block">Rekapitulasi Absensi & Nilai DUDI
                                            (Gabungan)</span>
                                        <span class="text-[11px] text-slate-500">Laporan data kehadiran dan nilai
                                            seluruh siswa.</span>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-100">
                                    <input type="radio" name="doc_type" value="sertifikat" class="text-schoolblue"
                                        onclick="toggleStudentSelect(true)">
                                    <div>
                                        <span class="font-bold text-slate-800 block">Sertifikat / Lembar Pengesahan
                                            PKL</span>
                                        <span class="text-[11px] text-slate-500">Cetak sertifikat kelulusan siswa
                                            magang.</span>
                                    </div>
                                </label>
                            </div>

                            <!-- DROPDOWN PILIH SISWA (Hanya muncul jika opsi sertifikat dipilih) -->
                            <div id="wrapper-select-siswa" class="hidden pt-2">
                                <label class="block font-bold text-slate-700 mb-1">Pilih Nama Siswa Tertentu
                                    (Opsional)</label>
                                <select id="selected-student-id"
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800">
                                    <option value="all">-- Cetak Semua Siswa (Massal) --</option>
                                    @foreach (App\Models\User::where('role', 'siswa')->get() as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}
                                            ({{ $s->tempat_dudi ?? 'Belum ada DUDI' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-3">
                            <button type="button" onclick="closeModalCetak()"
                                class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-xl">Batal</button>
                            <button type="button" onclick="processDownload()"
                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl shadow flex items-center gap-2">
                                <i class="fa-solid fa-download"></i> Unduh Dokumen (PDF)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. TAB: MANAJEMEN AKUN -->
                <div id="tab-manajemen" class="tab-content space-y-6 hidden">
                    <div
                        class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div>
                            <h3 class="font-bold text-schoolnavy text-lg flex items-center gap-2">
                                <i class="fa-solid fa-users-gear text-schoolblue"></i> Manajemen Akun Pengguna Sistem
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Kelola data akun hak akses untuk Administrator,
                                Guru Pembimbing, Siswa PKL, dan Mentor DUDI.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="openModalTambahAkun()"
                                class="px-4 py-2 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-md shadow-blue-600/20 transition flex items-center gap-2">
                                <i class="fa-solid fa-user-plus"></i> Tambah Akun Baru
                            </button>
                        </div>
                    </div>

                    <!-- Ringkasan Kartu Filter Role Akun (Dinamis) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div
                            class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Super
                                    Admin</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">{{ $countAdmin ?? 0 }} Akun</h4>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>
                        <div
                            class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Guru
                                    Pembimbing</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">{{ $countGuru ?? 0 }} Akun</h4>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-50 text-schoolblue flex items-center justify-center font-bold">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                        </div>
                        <div
                            class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siswa
                                    PKL</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">{{ $countSiswa ?? 0 }} Akun</h4>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                        </div>
                        <div
                            class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mentor
                                    DUDI</span>
                                <h4 class="text-xl font-bold text-slate-800 mt-0.5">{{ $countMentor ?? 0 }} Akun</h4>
                            </div>
                            <div
                                class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                        </div>
                    </div>

                    <!-- TABEL VERIFIKASI PENDAFTARAN AKUN BARU (PENDING APPROVAL) -->
                    @if(isset($pendingUsers) && $pendingUsers->count() > 0)
                        <div class="bg-amber-50/80 border-2 border-amber-300 rounded-2xl p-6 shadow-sm space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold shadow-md shadow-amber-500/30 flex-shrink-0">
                                        <i class="fa-solid fa-user-clock text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-amber-950 text-base flex items-center gap-2">
                                            Antrean Persetujuan Pendaftaran Akun Baru
                                            <span class="bg-amber-500 text-white text-xs px-2.5 py-0.5 rounded-full font-extrabold">{{ $pendingUsers->count() }} Menunggu</span>
                                        </h4>
                                        <p class="text-xs text-amber-800">Pengguna berikut telah mendaftar mandiri dan memerlukan persetujuan Admin sebelum dapat masuk ke sistem.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-x-auto bg-white rounded-xl border border-amber-200">
                                <table class="w-full text-left border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-amber-100/70 text-amber-950 font-bold border-b border-amber-200">
                                            <th class="p-3">Nama Pendaftar</th>
                                            <th class="p-3">Peran (Role)</th>
                                            <th class="p-3">Identitas / Afiliasi</th>
                                            <th class="p-3">Email & Kontak</th>
                                            <th class="p-3">Waktu Daftar</th>
                                            <th class="p-3 text-center">Tindakan Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-amber-100">
                                        @foreach($pendingUsers as $pending)
                                            <tr class="hover:bg-amber-50/50 transition">
                                                <td class="p-3 font-bold text-slate-800">{{ $pending->name }}</td>
                                                <td class="p-3">
                                                    @if($pending->role === 'siswa')
                                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[10px] font-bold uppercase">Siswa</span>
                                                    @elseif($pending->role === 'pembimbing')
                                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-full text-[10px] font-bold uppercase">Guru Pembimbing</span>
                                                    @elseif($pending->role === 'mentor')
                                                        <span class="px-2.5 py-1 bg-purple-100 text-purple-800 rounded-full text-[10px] font-bold uppercase">Mentor DUDI</span>
                                                    @endif
                                                </td>
                                                <td class="p-3 text-slate-600">
                                                    @if($pending->role === 'siswa')
                                                        <div>
                                                            <span class="font-semibold">NIS:</span> {{ $pending->nis ?? '-' }} | 
                                                            <span class="font-semibold">NISN:</span> {{ $pending->nisn ?? '-' }}
                                                        </div>
                                                        <div class="text-[11px] font-semibold text-schoolblue">{{ $pending->departemen ?? '-' }}</div>
                                                    @elseif($pending->role === 'pembimbing')
                                                        <div><span class="font-semibold">NIP:</span> {{ $pending->nip ?? '-' }}</div>
                                                    @elseif($pending->role === 'mentor')
                                                        <div class="font-semibold text-slate-800">{{ $pending->tempat_dudi ?? '-' }}</div>
                                                    @endif
                                                </td>
                                                <td class="p-3 text-slate-600">
                                                    <div>{{ $pending->email }}</div>
                                                    <div class="text-[11px] text-slate-400">{{ $pending->phone ?? '-' }}</div>
                                                </td>
                                                <td class="p-3 text-slate-500">{{ $pending->created_at ? $pending->created_at->diffForHumans() : '-' }}</td>
                                                <td class="p-3 text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <form action="{{ route('admin.users.approve', $pending->id) }}" method="POST" onsubmit="return confirm('Setujui dan aktifkan akun {{ $pending->name }}?')">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-sm flex items-center gap-1 transition">
                                                                <i class="fa-solid fa-check"></i> Setujui
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.reject', $pending->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran akun {{ $pending->name }}?')">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold text-xs shadow-sm flex items-center gap-1 transition">
                                                                <i class="fa-solid fa-xmark"></i> Tolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Panel Tabel Data & Pencarian -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <form method="GET" action="{{ route('admin.dashboard') }}"
                            class="p-4 border-b border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <div class="relative w-full md:w-80">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari nama atau email..."
                                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue transition">
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                                <select name="role" onchange="this.form.submit()"
                                    class="bg-slate-50 border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:border-schoolblue">
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="pembimbing"
                                        {{ request('role') == 'pembimbing' ? 'selected' : '' }}>
                                        Guru Pembimbing</option>
                                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa
                                        PKL
                                    </option>
                                    <option value="mentor" {{ request('role') == 'mentor' ? 'selected' : '' }}>Mentor
                                        DUDI</option>
                                </select>
                            </div>
                        </form>

                        <!-- Tabel Pengguna Dinamis -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold tracking-wider border-b border-slate-200">
                                        <th class="py-3 px-6">Pengguna</th>
                                        <th class="py-3 px-6">Role / Hak Akses</th>
                                        <th class="py-3 px-6">Departemen / DUDI</th>
                                        <th class="py-3 px-6">Status</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                                    @forelse($users ?? [] as $user)
                                        <tr class="hover:bg-slate-50/70 transition">
                                            <td class="py-3.5 px-6 flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center flex-shrink-0 text-xs">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-bold text-slate-900 block">{{ $user->name }}</span>
                                                    <span
                                                        class="text-[11px] text-slate-400">{{ $user->email }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span
                                                    class="px-2.5 py-1 rounded-lg font-semibold text-[11px] border
                                    {{ $user->role == 'admin' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : '' }} {{ $user->role == 'pembimbing' ? 'bg-blue-50 text-schoolblue border-blue-100' : '' }}
                                    {{ $user->role == 'siswa' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : '' }} {{ $user->role == 'mentor' ? 'bg-amber-50 text-amber-700 border-amber-100' : '' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-6 text-slate-500">
                                                {{ $user->tempat_dudi ?? '-' }}
                                            </td>
                                            <td class="py-3.5 px-6">
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-6 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button"
                                                        onclick="openModalEditAkun('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->tempat_dudi }}')"
                                                        title="Edit Akun"
                                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-schoolblue transition flex items-center justify-center">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus akun ini?')"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus Akun"
                                                            class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 transition flex items-center justify-center">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-slate-400 text-xs">Tidak
                                                ada data pengguna ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION FOOTER -->
                        <div
                            class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 bg-slate-50/50">
                            <div>
                                Menampilkan data ke-<span
                                    class="font-bold text-slate-700">{{ $users->firstItem() ?? 0 }}</span> sampai
                                <span class="font-bold text-slate-700">{{ $users->lastItem() ?? 0 }}</span> dari <span
                                    class="font-bold text-slate-700">{{ $users->total() }}</span> total akun
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MODAL TAMBAH AKUN BARU -->
                <div id="modalTambahAkun"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
                    <div class="bg-white rounded-2xl w-full max-w-lg p-6 space-y-4 shadow-xl">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-schoolnavy text-base">Tambah Akun Pengguna Baru</h4>
                            <button type="button" onclick="closeModalTambahAkun()"
                                class="text-slate-400 hover:text-slate-600"><i
                                    class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3 text-xs">
                            @csrf
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Role / Hak Akses</label>
                                <select name="role" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="pembimbing">Guru Pembimbing</option>
                                    <option value="siswa">Siswa PKL</option>
                                    <option value="mentor">Mentor DUDI</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Departemen / Tempat DUDI
                                    (Opsional)</label>
                                <input type="text" name="tempat_dudi"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Password</label>
                                <input type="password" name="password" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div class="flex justify-end gap-2 pt-3">
                                <button type="button" onclick="closeModalTambahAkun()"
                                    class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-xl">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-schoolblue text-white font-semibold rounded-xl shadow">Simpan
                                    Akun</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL EDIT AKUN -->
                <div id="modalEditAkun"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
                    <div class="bg-white rounded-2xl w-full max-w-lg p-6 space-y-4 shadow-xl">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-schoolnavy text-base">Edit Akun Pengguna</h4>
                            <button type="button" onclick="closeModalEditAkun()"
                                class="text-slate-400 hover:text-slate-600"><i
                                    class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <form id="formEditAkun" method="POST" class="space-y-3 text-xs">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="edit-name" name="name" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Email</label>
                                <input type="email" id="edit-email" name="email" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Role / Hak Akses</label>
                                <select id="edit-role" name="role" required
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                                    <option value="admin">Admin</option>
                                    <option value="pembimbing">Guru Pembimbing</option>
                                    <option value="siswa">Siswa PKL</option>
                                    <option value="mentor">Mentor DUDI</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Departemen / Tempat DUDI
                                    (Opsional)</label>
                                <input type="text" id="edit-tempat_dudi" name="tempat_dudi"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Password Baru (Opsional)</label>
                                <input type="password" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengubah password"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue">
                            </div>
                            <div class="flex justify-end gap-2 pt-3">
                                <button type="button" onclick="closeModalEditAkun()"
                                    class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-xl">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-schoolblue text-white font-semibold rounded-xl shadow">Perbarui
                                    Data</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL IMPORT EXCEL -->
                <div id="modalImportExcel"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 space-y-4 shadow-xl">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-schoolnavy text-base">Import Data Akun dari Excel</h4>
                            <button type="button" onclick="closeModalImportExcel()"
                                class="text-slate-400 hover:text-slate-600"><i
                                    class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                            @csrf
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pilih File Excel (.xlsx /
                                    .csv)</label>
                                <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required
                                    class="w-full p-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-600">
                            </div>
                            <p class="text-[11px] text-slate-400">Pastikan format kolom file Excel Anda sesuai dengan
                                template sistem.</p>
                            <div class="flex justify-end gap-2 pt-3">
                                <button type="button" onclick="closeModalImportExcel()"
                                    class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-xl">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow">Upload
                                    & Import</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- 3. TAB: PLOTTING & KELOMPOK PKL -->
                <div id="tab-plotting" class="tab-content space-y-6 hidden">

                    <!-- Header -->
                    <div class="space-y-1">
                        <h3 class="font-bold text-schoolnavy text-lg">Plotting & Kelompok PKL</h3>
                        <p class="text-xs text-slate-500">Manajemen penempatan siswa dan bimbingan industri.</p>
                    </div>

                    <!-- FORM TAMBAH KELOMPOK PKL -->
                    <form action="{{ route('admin.plotting.store') }}" method="POST"
                        class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-5">
                        @csrf

                        <!-- Judul Form -->
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-4">
                            <div
                                class="w-7 h-7 rounded-full bg-blue-50 text-schoolblue flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-circle-plus"></i>
                            </div>
                            <h4 class="font-bold text-schoolnavy text-sm">Tambah Kelompok PKL</h4>
                        </div>

                        <!-- 1. Pilih Jurusan -->
                        <div class="space-y-1.5 text-xs">
                            <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">1. Pilih
                                Jurusan</label>
                            <div class="relative">
                                <select name="jurusan"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium appearance-none">
                                    <option value="PPLG">Pengembangan Perangkat Lunak dan Gim (PPLG)</option>
                                    <option value="TJKT">Teknik Jaringan Komputer dan Telekomunikasi (TJKT)</option>
                                    <option value="Animasi">Animasi</option>
                                </select>
                                <span
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 text-xs">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                        </div>

                        <!-- 2. Pilih Siswa (Dinamis) -->
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">2.
                                    Pilih Siswa</label>
                                <span
                                    class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-bold rounded border border-amber-200">Pilih
                                    Siswa</span>
                            </div>

                            <div class="border border-slate-200 rounded-xl bg-slate-50/50 p-3 space-y-3">
                                <!-- Input Pencarian Siswa -->
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400 text-xs">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" placeholder="Cari nama siswa..."
                                        class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-schoolblue text-xs text-slate-700">
                                </div>

                                <!-- List Item Siswa dari Database -->
                                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                    @forelse($siswas ?? [] as $siswa)
                                        <label
                                            class="flex items-start gap-3 p-2.5 bg-white border border-slate-200 rounded-xl hover:border-blue-300 cursor-pointer transition">
                                            <input type="checkbox" name="student_ids[]" value="{{ $siswa->id }}"
                                                class="mt-0.5 rounded border-slate-300 text-schoolblue focus:ring-schoolblue w-4 h-4">
                                            <div>
                                                <span
                                                    class="font-bold text-slate-900 block text-xs">{{ $siswa->name }}</span>
                                                <span class="text-[10px] text-slate-400">Email:
                                                    {{ $siswa->email }}</span>
                                            </div>
                                        </label>
                                    @empty
                                        <p class="text-xs text-slate-400 text-center py-2">Tidak ada data siswa.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Nama Label Kelompok (Opsional) -->
                        <div class="space-y-1.5 text-xs">
                            <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">Nama
                                Label Kelompok (Opsional)</label>
                            <input type="text" name="nama_kelompok"
                                placeholder="Contoh: Kelompok Alpha, Tim Mobile Dev 1..."
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium">
                        </div>

                        <!-- Grid 3 & 4 (Tempat PKL & Pembimbing Sekolah) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1.5">
                                <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">3.
                                    Nama Tempat PKL (DUDI) <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_dudi" placeholder="Contoh: PT. Teknologi Nusantara"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium"
                                    required>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">4.
                                    Guru Pembimbing Sekolah</label>
                                <div class="relative">
                                    <select name="guru_pembimbing"
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium appearance-none">
                                        <option>Bpk. Hendra Wijaya, S.Kom</option>
                                        <option>Ibu Rini Astuti, M.Pd</option>
                                        <option>Bpk. Ahmad Fauzi, S.T</option>
                                    </select>
                                    <span
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 text-xs">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Pembimbing Industri / Mentor (DUDI) -->
                        <div class="space-y-1.5 text-xs">
                            <label class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider">5.
                                Pembimbing Industri (Mentor) <span class="text-red-500">*</span></label>
                            <select name="mentor_id"
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-schoolblue text-slate-800 font-medium"
                                required>
                                <option value="">-- Pilih Mentor / Pembimbing Industri --</option>
                                @foreach ($mentors ?? [] as $mentor)
                                    <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="px-6 py-3 bg-[#0b1c3d] hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-circle-check"></i> Simpan Kelompok (Done)
                            </button>
                        </div>
                    </form>

                    <!-- Bagian Daftar Kelompok Aktif -->
                    <div class="space-y-3 pt-2">
                        <h4 class="font-bold text-schoolnavy text-base">Daftar Kelompok Aktif</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($groups ?? [] as $group)
                                @php
                                    // Hitung jumlah siswa di DUDI tersebut dan ambil data mentornya
                                    $jumlahSiswa = \App\Models\User::where('tempat_dudi', $group->tempat_dudi)->count();
                                    $mentorInfo = \App\Models\User::find($group->mentor_id);
                                @endphp
                                <div
                                    class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-base">Kelompok -
                                                {{ $group->tempat_dudi }}</h5>
                                            <span class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                                <i class="fa-solid fa-building text-slate-400 text-[10px]"></i>
                                                {{ $group->tempat_dudi }}
                                            </span>
                                        </div>
                                        <span
                                            class="px-2.5 py-1 bg-blue-50 text-schoolblue text-[10px] font-bold rounded-lg border border-blue-100">PPLG</span>
                                    </div>

                                    <div
                                        class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ $mentorInfo ? strtoupper(substr($mentorInfo->name, 0, 2)) : 'MT' }}
                                        </div>
                                        <div class="text-xs">
                                            <span
                                                class="text-[10px] text-slate-400 uppercase tracking-wider block font-semibold">Mentor
                                                Industri</span>
                                            <span
                                                class="font-bold text-slate-800">{{ $mentorInfo->name ?? 'Belum ditentukan' }}</span>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-center justify-between pt-2 border-t border-slate-100 text-xs">
                                        <span class="font-semibold text-slate-600 flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-group text-slate-400 text-xs"></i>
                                            {{ $jumlahSiswa }} Siswa Terhubung
                                        </span>
                                        <button type="button"
                                            onclick="openModalKelompok('{{ $group->tempat_dudi }}', '{{ $group->mentor_id }}')"
                                            class="font-bold text-schoolblue hover:underline flex items-center gap-1">
                                            Detail &rarr;
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 col-span-2 text-center py-4">Belum ada kelompok PKL
                                    aktif.</p>
                            @endforelse
                        </div>
                    </div>
                    <!-- MODAL DETAIL KELOMPOK -->
                    <div id="modalDetailKelompok"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
                        <div
                            class="bg-white rounded-2xl w-full max-w-md p-6 space-y-4 shadow-xl relative animate-in fade-in zoom-in duration-200">
                            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                                <h4 class="font-bold text-schoolnavy text-base" id="modal-title">Detail Kelompok PKL
                                </h4>
                                <button onclick="closeModalKelompok()" class="text-slate-400 hover:text-slate-600">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-xs">
                                <p class="text-slate-500 font-medium">Daftar siswa yang tergabung dalam kelompok ini:
                                </p>
                                <div id="modal-student-list" class="space-y-2 max-h-60 overflow-y-auto pr-1">
                                    <!-- List siswa akan dimuat di sini lewat JavaScript -->
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button onclick="closeModalKelompok()"
                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 4. TAB: TIMELINE PERIODE PKL -->
                <div id="tab-timeline" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <h3 class="font-bold text-schoolnavy text-lg">Pengaturan Periode PKL & Kontrol Timeline
                            Akademik</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Atur jadwal mulai dan selesai masa PKL, buka/tutup
                            akses input jurnal bagi siswa.</p>
                    </div>

                    <!-- SATU FORM UTAMA YANG MEMBUNGKUS KEDUA KOLOM -->
                    <form action="{{ route('admin.timeline.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- Kolom 1: Kalender & Jadwal Pelaksanaan PKL -->
                            <div
                                class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                                <h4 class="font-bold text-schoolnavy text-sm flex items-center gap-2 border-b pb-3">
                                    <i class="fa-regular fa-calendar-days text-schoolblue"></i> 1. Kalender & Jadwal
                                    Pelaksanaan PKL
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs pt-1">
                                    <div>
                                        <label
                                            class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Tahun
                                            Ajaran</label>
                                        <input type="text" name="tahun_ajaran"
                                            value="{{ session('pk_tahun_ajaran', '2023/2024') }}"
                                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                    </div>
                                    <div>
                                        <label
                                            class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Gelombang
                                            / Batch</label>
                                        <select name="gelombang"
                                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                            <option value="Gelombang 1 (Semester Ganjil)"
                                                {{ session('pk_gelombang') == 'Gelombang 1 (Semester Ganjil)' ? 'selected' : '' }}>
                                                Gelombang 1 (Semester Ganjil)</option>
                                            <option value="Gelombang 2 (Semester Genap)"
                                                {{ session('pk_gelombang') == 'Gelombang 2 (Semester Genap)' ? 'selected' : '' }}>
                                                Gelombang 2 (Semester Genap)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label
                                            class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Tanggal
                                            Mulai PKL</label>
                                        <input type="date" name="tanggal_mulai"
                                            value="{{ session('pk_tanggal_mulai', '2023-09-01') }}"
                                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                    </div>
                                    <div>
                                        <label
                                            class="block font-bold text-slate-700 uppercase text-[10px] tracking-wider mb-1">Tanggal
                                            Selesai PKL</label>
                                        <!-- Pastikan menggunakan format YYYY-MM-DD -->
                                        <input type="date" name="tanggal_selesai"
                                            value="{{ session('pk_tanggal_selesai', '2026-12-09') }}"
                                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium">
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom 2: Kontrol Hak Pengisian Jurnal (Lockdown) & Tombol Simpan -->
                            <div
                                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4 flex flex-col justify-between">
                                <div class="space-y-4">
                                    <h4
                                        class="font-bold text-schoolnavy text-sm flex items-center gap-2 border-b pb-3">
                                        <i class="fa-solid fa-lock text-schoolblue"></i> 2. Kontrol Hak Pengisian
                                        Jurnal (Lockdown)
                                    </h4>
                                    <div class="space-y-2">
                                        <label class="block font-bold text-slate-700 text-xs">Status Input Logbook
                                            Siswa</label>
                                        <select name="status_lockdown"
                                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 font-medium">
                                            <option value="buka"
                                                {{ session('pk_status_lockdown') == 'buka' ? 'selected' : '' }}>Buka
                                                (Siswa bebas mengisi)</option>
                                            <option value="tutup"
                                                {{ session('pk_status_lockdown') == 'tutup' ? 'selected' : '' }}>
                                                Tutup / Lockdown (Akses dikunci)</option>
                                        </select>
                                        <span class="text-[11px] text-slate-500 block">Pilih 'Tutup' jika masa
                                            pengisian jurnal harian telah berakhir.</span>
                                    </div>
                                </div>
                                <!-- Tombol simpan ini sekarang berfungsi untuk menyimpan jadwal kalender DAN status lockdown sekaligus -->
                                <button type="submit"
                                    class="w-full py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow transition">
                                    Simpan Semua Pengaturan Timeline
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
               <!-- 5. TAB: SETTING / PENGATURAN SISTEM -->
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

        </div>

        <!-- Konten Form Pengaturan (Kanan) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Sub-Tab 1: Umum -->
            <div id="sub-setting-umum" class="setting-section bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-schoolblue"></i> Konfigurasi Sistem Utama
                </h4>
                <form action="{{ route('admin.settings.umum') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Aplikasi / Sistem</label>
                            <input type="text" name="nama_aplikasi" value="{{ session('set_nama_aplikasi', 'Sistem Informasi PKL SMKN 1 Depok') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Ajaran Aktif</label>
                                <select name="tahun_ajaran" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    <option value="2023/2024" {{ session('set_tahun_ajaran') == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                                    <option value="2024/2025" {{ session('set_tahun_ajaran') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Sistem Logbook</label>
                                <select name="status_logbook" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                                    <option value="Dibuka (Aktif)" {{ session('set_status_logbook') == 'Dibuka (Aktif)' ? 'selected' : '' }}>Dibuka (Aktif)</option>
                                    <option value="Ditutup (Maintenance)" {{ session('set_status_logbook') == 'Ditutup (Maintenance)' ? 'selected' : '' }}>Ditutup (Maintenance)</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Pesan Pengumuman Global (Banner Dashboard)</label>
                            <textarea name="pesan_pengumuman" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">{{ session('set_pesan_pengumuman', 'Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB.') }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-5 py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- Sub-Tab 2: Sekolah -->
            <div id="sub-setting-sekolah" class="setting-section bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6 hidden">
                <h4 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-school text-schoolblue"></i> Identitas Instansi / Sekolah
                </h4>
                <form action="{{ route('admin.settings.sekolah') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Resmi Sekolah</label>
                            <input type="text" name="nama_sekolah" value="{{ \App\Models\Setting::get('school_name', 'SMK Negeri 1 Depok') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                            <input type="text" name="alamat" value="{{ \App\Models\Setting::get('school_address', 'Jl. Raya Tapos, Gg. Bhakti Suci No. 100, Cimpaeun, Tapos, Kota Depok, Jawa Barat 16459') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                                <input type="email" name="email" value="{{ \App\Models\Setting::get('school_email', 'smkn1depok@gmail.com') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / Fax</label>
                                <input type="text" name="telepon" value="{{ \App\Models\Setting::get('school_phone', '(021) 8790-7233') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">WhatsApp (Hanya Chat)</label>
                                <input type="text" name="whatsapp" value="{{ \App\Models\Setting::get('school_whatsapp', '0877-4444-5006') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Website Resmi</label>
                                <input type="text" name="website" value="{{ \App\Models\Setting::get('school_website', 'https://www.smkn1depok.sch.id/') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-schoolblue">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-5 py-2.5 bg-schoolblue hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition">Simpan Perubahan</button>
                    </div>
                </form>
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

            // Tutup sidebar otomatis di perangkat mobile / tablet setelah diklik
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
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

            event.currentTarget.classList.remove('text-slate-600', 'font-semibold', 'hover:bg-slate-50',
                'hover:text-schoolnavy');
            event.currentTarget.classList.add('bg-blue-50', 'text-schoolblue', 'font-bold');
        }

        function openModalKelompok(tempatDudi, mentorId) {
            document.getElementById('modal-title').innerText = 'Kelompok - ' + tempatDudi;

            // Contoh data siswa statis/dinamis penampil
            let listContainer = document.getElementById('modal-student-list');
            listContainer.innerHTML = `
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <span class="font-bold text-slate-800 block">Siswa PKL</span>
                    <span class="text-[10px] text-slate-500">Penempatan: ${tempatDudi}</span>
                </div>
                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-semibold rounded-full">Aktif</span>
            </div>
        `;

            document.getElementById('modalDetailKelompok').classList.remove('hidden');
        }

        function closeModalKelompok() {
            document.getElementById('modalDetailKelompok').classList.add('hidden');
        }
        // Kontrol Modal Tambah Akun
        function openModalTambahAkun() {
            document.getElementById('modalTambahAkun').classList.remove('hidden');
        }

        function closeModalTambahAkun() {
            document.getElementById('modalTambahAkun').classList.add('hidden');
        }

        // Kontrol Modal Edit Akun
        function openModalEditAkun(id, name, email, role, tempatDudi) {
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
            document.getElementById('edit-tempat_dudi').value = (tempatDudi !== 'null' && tempatDudi !== '') ? tempatDudi :
                '';

            document.getElementById('formEditAkun').action = '/admin/users/' + id;
            document.getElementById('modalEditAkun').classList.remove('hidden');
        }

        function closeModalEditAkun() {
            document.getElementById('modalEditAkun').classList.add('hidden');
        }

        // Kontrol Modal Import Excel
        function openModalImportExcel() {
            document.getElementById('modalImportExcel').classList.remove('hidden');
        }

        function closeModalImportExcel() {
            document.getElementById('modalImportExcel').classList.add('hidden');
        }
        // Kontrol Modal WhatsApp
        function openModalWa() {
            document.getElementById('modalWa').classList.remove('hidden');
        }

        function closeModalWa() {
            document.getElementById('modalWa').classList.add('hidden');
        }

        function sendWhatsApp() {
            const phone = document.getElementById('wa-number').value.trim();
            const message = encodeURIComponent(document.getElementById('wa-message').value);

            if (!phone) {
                alert('Mohon masukkan nomor WhatsApp tujuan terlebih dahulu!');
                return;
            }

            // Membuka tautan API WhatsApp langsung
            window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
            closeModalWa();
        }

        // Kontrol Modal Cetak Dokumen
        function openModalCetak() {
            document.getElementById('modalCetak').classList.remove('hidden');
        }

        function closeModalCetak() {
            document.getElementById('modalCetak').classList.add('hidden');
        }

        function processDownload() {
            const selectedDoc = document.querySelector('input[name="doc_type"]:checked').value;

            if (selectedDoc === 'presensi' || selectedDoc === 'nilai_dudi') {
                // Mengarah ke route ekspor rekapitulasi gabungan (Absensi & Nilai)
                window.location.href = "{{ route('admin.export.laporan') }}";
            } else if (selectedDoc === 'pengesahan') {
                // Mengarah ke route ekspor sertifikat massal resmi
                window.location.href = "{{ route('admin.export.sertifikat') }}";
            }

            closeModalCetak();
        }

        function toggleStudentSelect(show) {
            const wrapper = document.getElementById('wrapper-select-siswa');
            if (show) {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
        }

        function processDownload() {
            const selectedDoc = document.querySelector('input[name="doc_type"]:checked').value;

            if (selectedDoc === 'laporan') {
                window.location.href = "{{ route('admin.export.laporan') }}";
            } else if (selectedDoc === 'sertifikat') {
                const studentId = document.getElementById('selected-student-id').value;
                // Mengarahkan ke route dengan membawa parameter ID siswa yang dipilih
                window.location.href = "{{ route('admin.export.sertifikat') }}?student_id=" + studentId;
            }

            closeModalCetak();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById('tab-' + hash)) {
                switchTab(hash);
            }
        });
    </script>
</body>

</html>
