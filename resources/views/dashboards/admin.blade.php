<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Jurnal PKL Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
    </style>
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
</head>

<body class="bg-slate-100 font-sans text-slate-800 antialiased overflow-x-hidden"
    x-data="{
        activeTab: ['dashboard', 'manajemen', 'plotting', 'timeline', 'settings'].includes(window.location.hash.replace('#', ''))
            ? window.location.hash.replace('#', '')
            : 'dashboard',
        sidebarOpen: false,
        activeSettingSub: 'umum',
        modalWaOpen: false,
        modalCetakOpen: false,
        cetakDocType: 'laporan',
        cetakStudentId: 'all',
        modalTambahAkunOpen: false,
        modalEditAkunOpen: false,
        modalImportOpen: false,
        modalKelompokOpen: false,
        editUser: { id: '', name: '', email: '', role: 'siswa', tempatDudi: '' },
        kelompokInfo: { dudi: '', mentorId: '' },
        titles: {
            dashboard: ['Dashboard Administrator', 'Pusat Kendali Sistem Informasi PKL SMKN 1 Depok'],
            manajemen: ['Manajemen Akun Pengguna', 'Kelola hak akses Admin, Guru, Siswa, dan Mentor DUDI'],
            plotting: ['Plotting & Kelompok PKL', 'Manajemen penempatan siswa dan bimbingan industri'],
            timeline: ['Timeline & Jadwal PKL', 'Pengaturan tenggat waktu dan agenda kegiatan'],
            settings: ['Pengaturan Sistem', 'Konfigurasi profil institusi dan keamanan']
        },
        openEditAkun(id, name, email, role, tempatDudi) {
            this.editUser = {
                id: id,
                name: name,
                email: email,
                role: role,
                tempatDudi: (tempatDudi && tempatDudi !== 'null') ? tempatDudi : ''
            };
            this.modalEditAkunOpen = true;
        },
        openKelompok(dudi, mentorId) {
            this.kelompokInfo = { dudi: dudi, mentorId: mentorId };
            this.modalKelompokOpen = true;
        },
        processDownload() {
            if (this.cetakDocType === 'laporan') {
                window.location.href = '{{ route('admin.export.laporan') }}';
            } else {
                window.location.href = '{{ route('admin.export.sertifikat') }}?student_id=' + this.cetakStudentId;
            }
            this.modalCetakOpen = false;
        }
    }">

    <!-- MOBILE DRAWER OVERLAY -->
    <div id="sidebar-overlay" x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-30 transition-opacity duration-300 md:hidden">
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR ADMIN -->
        <aside id="sidebar"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
            class="w-64 bg-primary text-white flex flex-col fixed inset-y-0 left-0 z-40 transform transition-transform duration-300 ease-in-out md:static shadow-xl">
            <!-- Pure Logo Brand Header -->
            <div class="h-20 flex items-center justify-between px-6 bg-primary">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-9 h-9 object-contain shrink-0">
                    <div>
                        <span class="text-sm font-bold tracking-wide text-white block">Admin Pusat</span>
                        <span class="text-xs text-blue-200 font-medium">Monitoring PKL</span>
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
                <a href="#manajemen" @click.prevent="activeTab = 'manajemen'; sidebarOpen = false"
                    :class="activeTab === 'manajemen' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-users-gear w-5 text-center"></i>
                        <span>Manajemen Akun</span>
                    </div>
                    @if(isset($pendingUsersCount) && $pendingUsersCount > 0)
                        <span class="text-amber-300 text-xs font-bold tabular-nums">{{ $pendingUsersCount }}</span>
                    @endif
                </a>
                <a href="#plotting" @click.prevent="activeTab = 'plotting'; sidebarOpen = false"
                    :class="activeTab === 'plotting' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-object-group w-5 text-center"></i>
                    <span>Plotting &amp; Kelompok</span>
                </a>
                <a href="#timeline" @click.prevent="activeTab = 'timeline'; sidebarOpen = false"
                    :class="activeTab === 'timeline' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Timeline Periode PKL</span>
                </a>
                <a href="#settings" @click.prevent="activeTab = 'settings'; sidebarOpen = false"
                    :class="activeTab === 'settings' ? 'bg-secondary text-white shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white'"
                    class="nav-link min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Setting</span>
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
                        <h2 id="page-title" x-text="(titles[activeTab] || titles.dashboard)[0]" class="text-base sm:text-xl font-bold text-primary truncate">Dashboard Administrator</h2>
                        <p class="text-xs text-slate-500 truncate hidden sm:block" x-text="(titles[activeTab] || titles.dashboard)[1]">Pusat Kendali Sistem Informasi PKL SMKN 1 Depok</p>
                    </div>
                </div>

                <!-- Admin Profile -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="text-right hidden sm:block">
                        <span class="block text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <span class="block text-xs text-slate-500">Super Admin</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-third text-white flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-6">

                <!-- 1. TAB: DASHBOARD ADMIN -->
                <div id="tab-dashboard" x-show="activeTab === 'dashboard'" class="tab-content space-y-6">

                    <!-- HERO BANNER -->
                    <div class="bg-gradient-to-r from-primary to-third text-white p-6 sm:p-8 rounded-xl shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="space-y-2">
                            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
                                Selamat Datang, Admin!
                            </h1>
                            <p class="text-xs sm:text-sm text-blue-100 max-w-2xl leading-relaxed">
                                Ringkasan sistem pengelolaan PKL SMKN 1 Depok &bull; Tahun Ajaran {{ session('pk_tahun_ajaran', '2023/2024') }} &bull; Input Logbook:
                                <span class="text-emerald-300 font-bold">DIBUKA</span>
                            </p>
                        </div>
                        <div class="hidden lg:flex items-center justify-center w-16 h-16 rounded-xl bg-white/10 text-blue-100 shrink-0">
                            <i class="fa-solid fa-building-columns text-2xl"></i>
                        </div>
                    </div>

                    <!-- 4 Kartu Statistik Atas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <div class="bg-white p-5 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Akun Terdaftar</span>
                                <h3 class="text-2xl font-bold text-slate-900 mt-1 tabular-nums">{{ $totalAkun ?? \App\Models\User::count() }} Akun</h3>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <a href="#manajemen" @click.prevent="activeTab = 'manajemen'"
                                    class="text-xs sm:text-sm font-semibold text-secondary hover:underline">Lihat Detail &rarr;</a>
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-secondary flex items-center justify-center">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Kapasitas Kuota DUDI</span>
                                <h3 class="text-2xl font-bold text-slate-900 mt-1 tabular-nums">{{ $totalSiswaTerplotting ?? 0 }} / {{ $kapasitasMaksimal ?? 150 }}</h3>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <span class="text-xs sm:text-sm font-semibold text-emerald-700">{{ \App\Models\User::where('role', 'siswa')->whereNotNull('tempat_dudi')->distinct('tempat_dudi')->count('tempat_dudi') }} Mitra</span>
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-rose-50 p-5 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-xs font-semibold text-rose-700 uppercase tracking-wide">Siswa Perlu Perhatian</span>
                                <h3 class="text-2xl font-bold text-slate-900 mt-1 tabular-nums">{{ $countSiswaPerhatian ?? 3 }} Siswa</h3>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <button type="button" @click="modalWaOpen = true"
                                    class="text-xs sm:text-sm font-semibold text-rose-700 cursor-pointer hover:underline">Tindak Lanjut &rarr;</button>
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Kelulusan &amp; Pengesahan</span>
                                <h3 class="text-2xl font-bold text-slate-900 mt-1 tabular-nums">{{ $siswaLulus ?? 115 }} / {{ $totalSemuaSiswa ?? 120 }}</h3>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <button type="button" @click="modalCetakOpen = true"
                                    class="text-xs sm:text-sm font-semibold text-third cursor-pointer hover:underline">Unduh Arsip &rarr;</button>
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-third flex items-center justify-center">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grid Bawah -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-4">
                            <h4 class="font-bold text-primary text-base flex items-center gap-2">
                                <i class="fa-solid fa-bolt text-secondary"></i> Aksi Cepat Administrator
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <button type="button" @click="activeTab = 'manajemen'"
                                    class="p-4 rounded-xl bg-slate-50 hover:bg-blue-50/70 transition cursor-pointer flex items-start text-left gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-secondary flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-900 text-sm">Tambah / Reset Akun</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun baru atau edit data pengguna.</p>
                                    </div>
                                </button>
                                <button type="button" @click="activeTab = 'plotting'"
                                    class="p-4 rounded-xl bg-slate-50 hover:bg-blue-50/70 transition cursor-pointer flex items-start text-left gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-object-group"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-900 text-sm">Plotting &amp; Penempatan</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">Atur penempatan kelompok dan mentor industri.</p>
                                    </div>
                                </button>
                                <button type="button" @click="modalWaOpen = true"
                                    class="p-4 rounded-xl bg-slate-50 hover:bg-blue-50/70 transition cursor-pointer flex items-start text-left gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-bullhorn"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-900 text-sm">Kirim Peringatan WA</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">Intervensi langsung siswa yang absensinya kurang.</p>
                                    </div>
                                </button>
                                <button type="button" @click="modalCetakOpen = true"
                                    class="p-4 rounded-xl bg-slate-50 hover:bg-blue-50/70 transition cursor-pointer flex items-start text-left gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-200 text-third flex items-center justify-center shrink-0 mt-0.5">
                                        <i class="fa-solid fa-print"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-900 text-sm">Cetak Dokumen &amp; Pengesahan</h5>
                                        <p class="text-xs text-slate-500 mt-0.5">Unduh berkas kelulusan &amp; rekapitulasi nilai.</p>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div class="bg-amber-50 p-5 sm:p-6 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-bold text-amber-900 text-base flex items-center gap-2">
                                        <i class="fa-solid fa-clock text-amber-600"></i> Masa Aktif PKL
                                    </h4>
                                    <span class="text-xs font-bold text-amber-800">TA {{ session('pk_tahun_ajaran', '2023/2024') }}</span>
                                </div>
                                <p class="text-xs sm:text-sm text-amber-900 leading-relaxed">
                                    Masa pengisian logbook harian oleh siswa aktif hingga <strong class="font-bold">{{ session('pk_tanggal_selesai', '2026-12-09') }}</strong> pukul <strong>21:00 WIB</strong>.
                                </p>
                                <div class="bg-white p-3.5 rounded-xl space-y-1">
                                    <span class="text-xs font-bold text-amber-800 uppercase tracking-wide block">Pengumuman Terpasang</span>
                                    <p class="text-xs text-slate-700 leading-relaxed">
                                        <i class="fa-solid fa-bullhorn text-amber-600 mr-1"></i>
                                        {{ session('setting_pesan_pengumuman', 'Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB.') }}
                                    </p>
                                </div>
                            </div>
                            <button type="button" @click="activeTab = 'timeline'"
                                class="w-full min-h-[44px] py-2.5 bg-primary hover:bg-third text-white rounded-xl font-semibold text-xs sm:text-sm shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                                Konfigurasi Jadwal &amp; Deadline
                            </button>
                        </div>
                    </div>
                </div>

                <!-- MODAL KIRIM PERINGATAN WA -->
                <div id="modalWa" x-show="modalWaOpen" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                    <div @click.outside="modalWaOpen = false" class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl">
                        <div class="flex justify-between items-center pb-2">
                            <h4 class="font-bold text-primary text-base sm:text-lg flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-lg"></i> Kirim Peringatan Absensi via WhatsApp
                            </h4>
                            <button type="button" @click="modalWaOpen = false" aria-label="Tutup Modal"
                                class="text-slate-400 hover:text-slate-600 min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Siswa yang Perlu Ditindaklanjuti</label>
                                <select id="select-siswa-wa"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                    <option value="">-- Pilih Nama Siswa / Ketik Manual --</option>
                                    @foreach (\App\Models\User::where('role', 'siswa')->get() as $siswa)
                                        <option value="{{ $siswa->name }}">{{ $siswa->name }} (DUDI: {{ $siswa->tempat_dudi ?? 'Belum ada' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp Siswa / Orang Tua (Format: 628xxx)</label>
                                <input type="text" id="wa-number" placeholder="Contoh: 6281234567890"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pesan Peringatan</label>
                                <textarea id="wa-message" rows="4"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">Halo, diberitahukan kepada orang tua/wali dari siswa peserta PKL SMKN 1 Depok, berdasarkan catatan kehadiran dan jarak geotagging, siswa tersebut memerlukan perhatian khusus. Mohon segera dikonfirmasi. Terima kasih.</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="modalWaOpen = false"
                                class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl cursor-pointer">Batal</button>
                            <button type="button" onclick="sendWhatsApp()" @click="modalWaOpen = false"
                                class="min-h-[44px] px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm flex items-center gap-2 cursor-pointer">
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
                <div id="modalCetak" x-show="modalCetakOpen" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                    <div @click.outside="modalCetakOpen = false" class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl">
                        <div class="flex justify-between items-center pb-2">
                            <h4 class="font-bold text-primary text-base sm:text-lg flex items-center gap-2">
                                <i class="fa-solid fa-print text-third text-lg"></i> Pusat Unduh &amp; Cetak Dokumen PKL
                            </h4>
                            <button type="button" @click="modalCetakOpen = false" aria-label="Tutup Modal"
                                class="text-slate-400 hover:text-slate-600 min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <div class="space-y-3">
                            <p class="text-xs sm:text-sm text-slate-500">Pilih jenis dokumen atau laporan rekapitulasi yang ingin di-generate:</p>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100">
                                    <input type="radio" name="doc_type" value="laporan" x-model="cetakDocType" class="text-secondary">
                                    <div>
                                        <span class="font-bold text-slate-800 block text-sm">Rekapitulasi Absensi &amp; Nilai DUDI (Gabungan)</span>
                                        <span class="text-xs text-slate-500">Laporan data kehadiran dan nilai seluruh siswa.</span>
                                    </div>
                                </label>

                                <label class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100">
                                    <input type="radio" name="doc_type" value="sertifikat" x-model="cetakDocType" class="text-secondary">
                                    <div>
                                        <span class="font-bold text-slate-800 block text-sm">Sertifikat / Lembar Pengesahan PKL</span>
                                        <span class="text-xs text-slate-500">Cetak sertifikat kelulusan siswa magang.</span>
                                    </div>
                                </label>
                            </div>

                            <div id="wrapper-select-siswa" x-show="cetakDocType === 'sertifikat'" x-cloak class="pt-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Nama Siswa Tertentu (Opsional)</label>
                                <select id="selected-student-id" x-model="cetakStudentId"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800">
                                    <option value="all">-- Cetak Semua Siswa (Massal) --</option>
                                    @foreach (App\Models\User::where('role', 'siswa')->get() as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->tempat_dudi ?? 'Belum ada DUDI' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="modalCetakOpen = false"
                                class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl cursor-pointer">Batal</button>
                            <button type="button" @click="processDownload()"
                                class="min-h-[44px] px-4 py-2 bg-primary hover:bg-third text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm flex items-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-download"></i> Unduh Dokumen
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. TAB: MANAJEMEN AKUN -->
                <div id="tab-manajemen" x-show="activeTab === 'manajemen'" x-cloak class="tab-content space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-xl shadow-sm">
                        <div>
                            <h3 class="font-bold text-primary text-lg flex items-center gap-2">
                                <i class="fa-solid fa-users-gear text-secondary"></i> Manajemen Akun Pengguna Sistem
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data akun hak akses untuk Administrator, Guru Pembimbing, Siswa PKL, dan Mentor DUDI.</p>
                        </div>
                        <button type="button" @click="modalTambahAkunOpen = true"
                            class="w-full md:w-auto min-h-[44px] px-4 py-2.5 bg-secondary hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm transition flex items-center justify-center gap-2 cursor-pointer shrink-0">
                            <i class="fa-solid fa-user-plus"></i> Tambah Akun Baru
                        </button>
                    </div>

                    <!-- Ringkasan Kartu Role Akun -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Super Admin</span>
                                <h4 class="text-xl font-bold text-slate-900 mt-0.5 tabular-nums">{{ $countAdmin ?? 0 }} Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>
                        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Guru Pembimbing</span>
                                <h4 class="text-xl font-bold text-slate-900 mt-0.5 tabular-nums">{{ $countGuru ?? 0 }} Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-secondary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                        </div>
                        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Siswa PKL</span>
                                <h4 class="text-xl font-bold text-slate-900 mt-0.5 tabular-nums">{{ $countSiswa ?? 0 }} Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Mentor DUDI</span>
                                <h4 class="text-xl font-bold text-slate-900 mt-0.5 tabular-nums">{{ $countMentor ?? 0 }} Akun</h4>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                        </div>
                    </div>

                    <!-- TABEL VERIFIKASI PENDAFTARAN AKUN BARU (PENDING APPROVAL) -->
                    @if(isset($pendingUsers) && $pendingUsers->count() > 0)
                        <div class="bg-amber-50 rounded-xl p-5 sm:p-6 shadow-sm space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-user-clock text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-amber-950 text-base">
                                        Antrean Persetujuan Akun Baru ({{ $pendingUsers->count() }} Menunggu)
                                    </h4>
                                    <p class="text-xs sm:text-sm text-amber-900">Pengguna berikut telah mendaftar mandiri dan memerlukan persetujuan Admin sebelum dapat masuk ke sistem.</p>
                                </div>
                            </div>

                            <div class="overflow-x-auto bg-white rounded-xl">
                                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                    <thead>
                                        <tr class="bg-amber-100/60 text-amber-950 font-semibold text-xs uppercase">
                                            <th class="p-3.5">Nama Pendaftar</th>
                                            <th class="p-3.5">Peran</th>
                                            <th class="p-3.5">Identitas / Afiliasi</th>
                                            <th class="p-3.5">Email &amp; Kontak</th>
                                            <th class="p-3.5">Waktu Daftar</th>
                                            <th class="p-3.5 text-center">Tindakan Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingUsers as $pending)
                                            <tr class="hover:bg-amber-50/40 transition">
                                                <td class="p-3.5 font-bold text-slate-900">{{ $pending->name }}</td>
                                                <td class="p-3.5 font-semibold">
                                                    @if($pending->role === 'siswa')
                                                        <span class="text-emerald-700">Siswa</span>
                                                    @elseif($pending->role === 'pembimbing')
                                                        <span class="text-secondary">Guru Pembimbing</span>
                                                    @elseif($pending->role === 'mentor')
                                                        <span class="text-third">Mentor DUDI</span>
                                                    @endif
                                                </td>
                                                <td class="p-3.5 text-slate-600">
                                                    @if($pending->role === 'siswa')
                                                        <div>
                                                            <span class="font-semibold">NIS:</span> {{ $pending->nis ?? '-' }} &bull;
                                                            <span class="font-semibold">NISN:</span> {{ $pending->nisn ?? '-' }}
                                                        </div>
                                                        <div class="text-xs font-semibold text-secondary">{{ $pending->departemen ?? '-' }}</div>
                                                    @elseif($pending->role === 'pembimbing')
                                                        <div><span class="font-semibold">NIP:</span> {{ $pending->nip ?? '-' }}</div>
                                                    @elseif($pending->role === 'mentor')
                                                        <div class="font-semibold text-slate-800">{{ $pending->tempat_dudi ?? '-' }}</div>
                                                    @endif
                                                </td>
                                                <td class="p-3.5 text-slate-600">
                                                    <div>{{ $pending->email }}</div>
                                                    <div class="text-xs text-slate-500">{{ $pending->phone ?? '-' }}</div>
                                                </td>
                                                <td class="p-3.5 text-slate-500">{{ $pending->created_at ? $pending->created_at->diffForHumans() : '-' }}</td>
                                                <td class="p-3.5 text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <form action="{{ route('admin.users.approve', $pending->id) }}" method="POST" onsubmit="return confirm('Setujui dan aktifkan akun {{ $pending->name }}?')">
                                                            @csrf
                                                            <button type="submit" class="min-h-[38px] px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold text-xs flex items-center gap-1 transition cursor-pointer">
                                                                <i class="fa-solid fa-check"></i> Setujui
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.reject', $pending->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran akun {{ $pending->name }}?')">
                                                            @csrf
                                                            <button type="submit" class="min-h-[38px] px-3 py-1.5 bg-schoolred hover:bg-red-700 text-white rounded-lg font-semibold text-xs flex items-center gap-1 transition cursor-pointer">
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
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <form method="GET" action="{{ route('admin.dashboard') }}"
                            class="p-4 sm:p-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                            <div class="relative w-full md:w-80">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                                    class="w-full min-h-[44px] pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary transition">
                            </div>
                            <select name="role" onchange="this.form.submit()"
                                class="min-h-[44px] bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl px-3.5 py-2 focus:outline-none focus:border-secondary">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="pembimbing" {{ request('role') == 'pembimbing' ? 'selected' : '' }}>Guru Pembimbing</option>
                                <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa PKL</option>
                                <option value="mentor" {{ request('role') == 'mentor' ? 'selected' : '' }}>Mentor DUDI</option>
                            </select>
                        </form>

                        <!-- Tabel Pengguna Dinamis -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-500 uppercase text-xs font-semibold">
                                        <th class="py-3 px-5">Pengguna</th>
                                        <th class="py-3 px-5">Role / Hak Akses</th>
                                        <th class="py-3 px-5">Departemen / DUDI</th>
                                        <th class="py-3 px-5">Status</th>
                                        <th class="py-3 px-5 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-700">
                                    @forelse($users ?? [] as $user)
                                        <tr class="hover:bg-slate-50 odd:bg-white even:bg-slate-50/40 transition">
                                            <td class="py-3.5 px-5 flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-slate-100 text-primary font-bold flex items-center justify-center shrink-0 text-xs">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <span class="font-bold text-slate-900 block">{{ $user->name }}</span>
                                                    <span class="text-xs text-slate-500">{{ $user->email }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-5 font-semibold whitespace-nowrap">
                                                <span class="{{ $user->role == 'admin' ? 'text-primary' : ($user->role == 'pembimbing' ? 'text-secondary' : ($user->role == 'siswa' ? 'text-emerald-700' : 'text-amber-700')) }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-5 text-slate-600">{{ $user->tempat_dudi ?? '-' }}</td>
                                            <td class="py-3.5 px-5 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-emerald-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-5 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button type="button"
                                                        @click="openEditAkun('{{ $user->id }}', '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', '{{ addslashes((string) $user->tempat_dudi) }}')"
                                                        title="Edit Akun" aria-label="Edit Akun"
                                                        class="min-h-[38px] min-w-[38px] rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-secondary transition flex items-center justify-center cursor-pointer">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus akun ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus Akun" aria-label="Hapus Akun"
                                                            class="min-h-[38px] min-w-[38px] rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-schoolred transition flex items-center justify-center cursor-pointer">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-slate-400 text-sm">Tidak ada data pengguna ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION FOOTER -->
                        <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm text-slate-500 bg-slate-50">
                            <div>
                                Menampilkan data ke-<span class="font-bold text-slate-700">{{ $users->firstItem() ?? 0 }}</span> sampai
                                <span class="font-bold text-slate-700">{{ $users->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-700">{{ $users->total() }}</span> total akun
                            </div>
                            <div>{{ $users->links() }}</div>
                        </div>
                    </div>
                </div>

                <!-- MODAL TAMBAH AKUN BARU -->
                <div id="modalTambahAkun" x-show="modalTambahAkunOpen" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                    <div @click.outside="modalTambahAkunOpen = false" class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl">
                        <div class="flex justify-between items-center pb-2">
                            <h4 class="font-bold text-primary text-base sm:text-lg">Tambah Akun Pengguna Baru</h4>
                            <button type="button" @click="modalTambahAkunOpen = false" aria-label="Tutup Modal"
                                class="text-slate-400 hover:text-slate-600 min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                                <input type="email" name="email" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Role / Hak Akses</label>
                                <select name="role" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin">Admin</option>
                                    <option value="pembimbing">Guru Pembimbing</option>
                                    <option value="siswa">Siswa PKL</option>
                                    <option value="mentor">Mentor DUDI</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Departemen / Tempat DUDI (Opsional)</label>
                                <input type="text" name="tempat_dudi"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                                <input type="password" name="password" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="modalTambahAkunOpen = false"
                                    class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="min-h-[44px] px-5 py-2 bg-secondary text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm cursor-pointer">Simpan Akun</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL EDIT AKUN -->
                <div id="modalEditAkun" x-show="modalEditAkunOpen" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                    <div @click.outside="modalEditAkunOpen = false" class="bg-white rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl">
                        <div class="flex justify-between items-center pb-2">
                            <h4 class="font-bold text-primary text-base sm:text-lg">Edit Akun Pengguna</h4>
                            <button type="button" @click="modalEditAkunOpen = false" aria-label="Tutup Modal"
                                class="text-slate-400 hover:text-slate-600 min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <form id="formEditAkun" :action="'/admin/users/' + editUser.id" method="POST" class="space-y-3.5">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" id="edit-name" name="name" x-model="editUser.name" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                                <input type="email" id="edit-email" name="email" x-model="editUser.email" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Role / Hak Akses</label>
                                <select id="edit-role" name="role" x-model="editUser.role" required
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                    <option value="admin">Admin</option>
                                    <option value="pembimbing">Guru Pembimbing</option>
                                    <option value="siswa">Siswa PKL</option>
                                    <option value="mentor">Mentor DUDI</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Departemen / Tempat DUDI (Opsional)</label>
                                <input type="text" id="edit-tempat_dudi" name="tempat_dudi" x-model="editUser.tempatDudi"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password Baru (Opsional)</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="modalEditAkunOpen = false"
                                    class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="min-h-[44px] px-5 py-2 bg-secondary text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm cursor-pointer">Perbarui Data</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL IMPORT EXCEL -->
                <div id="modalImportExcel" x-show="modalImportOpen" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                    <div @click.outside="modalImportOpen = false" class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl">
                        <div class="flex justify-between items-center pb-2">
                            <h4 class="font-bold text-primary text-base sm:text-lg">Import Data Akun dari Excel</h4>
                            <button type="button" @click="modalImportOpen = false" aria-label="Tutup Modal"
                                class="text-slate-400 hover:text-slate-600 min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih File Excel (.xlsx / .csv)</label>
                                <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required
                                    class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-600">
                            </div>
                            <p class="text-xs text-slate-500">Pastikan format kolom file Excel Anda sesuai dengan template sistem.</p>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="modalImportOpen = false"
                                    class="min-h-[44px] px-4 py-2 bg-slate-100 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl cursor-pointer">Batal</button>
                                <button type="submit"
                                    class="min-h-[44px] px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm cursor-pointer">Upload &amp; Import</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 3. TAB: PLOTTING & KELOMPOK PKL -->
                <div id="tab-plotting" x-show="activeTab === 'plotting'" x-cloak class="tab-content space-y-6">

                    <div class="space-y-1">
                        <h3 class="font-bold text-primary text-lg">Plotting &amp; Kelompok PKL</h3>
                        <p class="text-xs sm:text-sm text-slate-500">Manajemen penempatan siswa dan bimbingan industri.</p>
                    </div>

                    <!-- FORM TAMBAH KELOMPOK PKL -->
                    <form action="{{ route('admin.plotting.store') }}" method="POST"
                        class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-5">
                        @csrf

                        <div class="flex items-center gap-2.5 pb-1">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-secondary flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-circle-plus"></i>
                            </div>
                            <h4 class="font-bold text-primary text-base">Tambah Kelompok PKL</h4>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide">1. Pilih Jurusan</label>
                            <div class="relative">
                                <select name="jurusan"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary text-slate-800 font-medium appearance-none">
                                    <option value="PPLG">Pengembangan Perangkat Lunak dan Gim (PPLG)</option>
                                    <option value="TJKT">Teknik Jaringan Komputer dan Telekomunikasi (TJKT)</option>
                                    <option value="Animasi">Animasi</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 text-xs">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide">2. Pilih Siswa</label>

                            <div class="rounded-xl bg-slate-50 p-3.5 space-y-3">
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 text-xs">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </span>
                                    <input type="text" placeholder="Cari nama siswa..."
                                        class="w-full min-h-[40px] pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-secondary text-xs sm:text-sm text-slate-700">
                                </div>

                                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                    @forelse($siswas ?? [] as $siswa)
                                        <label class="flex items-start gap-3 p-3 bg-white rounded-xl hover:bg-blue-50/40 cursor-pointer transition">
                                            <input type="checkbox" name="student_ids[]" value="{{ $siswa->id }}"
                                                class="mt-0.5 rounded border-slate-300 text-secondary focus:ring-secondary w-4 h-4">
                                            <div>
                                                <span class="font-bold text-slate-900 block text-xs sm:text-sm">{{ $siswa->name }}</span>
                                                <span class="text-xs text-slate-500">Email: {{ $siswa->email }}</span>
                                            </div>
                                        </label>
                                    @empty
                                        <p class="text-xs sm:text-sm text-slate-400 text-center py-2">Tidak ada data siswa.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide">Nama Label Kelompok (Opsional)</label>
                            <input type="text" name="nama_kelompok" placeholder="Contoh: Kelompok Alpha, Tim Mobile Dev 1..."
                                class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary text-slate-800 font-medium">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide">3. Nama Tempat PKL (DUDI) <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama_dudi" placeholder="Contoh: PT. Teknologi Nusantara"
                                    class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary text-slate-800 font-medium"
                                    required>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide">4. Guru Pembimbing Sekolah</label>
                                <div class="relative">
                                    <select name="guru_pembimbing"
                                        class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary text-slate-800 font-medium appearance-none">
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

                        <div class="space-y-1.5">
                            <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide">5. Pembimbing Industri (Mentor) <span class="text-rose-500">*</span></label>
                            <select name="mentor_id"
                                class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary text-slate-800 font-medium"
                                required>
                                <option value="">-- Pilih Mentor / Pembimbing Industri --</option>
                                @foreach ($mentors ?? [] as $mentor)
                                    <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto min-h-[44px] px-6 py-2.5 bg-primary hover:bg-third text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-circle-check"></i> Simpan Kelompok
                            </button>
                        </div>
                    </form>

                    <!-- Bagian Daftar Kelompok Aktif -->
                    <div class="space-y-4 pt-2">
                        <h4 class="font-bold text-primary text-base sm:text-lg">Daftar Kelompok Aktif</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            @forelse($groups ?? [] as $group)
                                @php
                                    $jumlahSiswa = \App\Models\User::where('tempat_dudi', $group->tempat_dudi)->count();
                                    $mentorInfo = \App\Models\User::find($group->mentor_id);
                                @endphp
                                <div class="bg-white p-5 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-base">Kelompok - {{ $group->tempat_dudi }}</h5>
                                            <span class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i class="fa-solid fa-building text-slate-400"></i>
                                                {{ $group->tempat_dudi }}
                                            </span>
                                        </div>
                                        <span class="text-xs font-bold text-secondary shrink-0">PPLG</span>
                                    </div>

                                    <div class="bg-slate-50 p-3.5 rounded-xl flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ $mentorInfo ? strtoupper(substr($mentorInfo->name, 0, 2)) : 'MT' }}
                                        </div>
                                        <div class="text-xs sm:text-sm">
                                            <span class="text-xs text-slate-500 uppercase tracking-wide block font-semibold">Mentor Industri</span>
                                            <span class="font-bold text-slate-800">{{ $mentorInfo->name ?? 'Belum ditentukan' }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-1 text-xs sm:text-sm">
                                        <span class="font-medium text-slate-600 flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-group text-slate-400"></i>
                                            {{ $jumlahSiswa }} Siswa Terhubung
                                        </span>
                                        <button type="button"
                                            @click="openKelompok('{{ addslashes((string) $group->tempat_dudi) }}', '{{ $group->mentor_id }}')"
                                            class="min-h-[36px] font-semibold text-secondary hover:underline flex items-center gap-1 cursor-pointer">
                                            Detail &rarr;
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 col-span-2 text-center py-4">Belum ada kelompok PKL aktif.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- MODAL DETAIL KELOMPOK -->
                    <div id="modalDetailKelompok" x-show="modalKelompokOpen" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                        <div @click.outside="modalKelompokOpen = false"
                            class="bg-white rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl relative">
                            <div class="flex justify-between items-center pb-2">
                                <h4 class="font-bold text-primary text-base sm:text-lg" id="modal-title"
                                    x-text="'Kelompok - ' + kelompokInfo.dudi">Detail Kelompok PKL</h4>
                                <button type="button" @click="modalKelompokOpen = false" aria-label="Tutup Modal"
                                    class="text-slate-400 hover:text-slate-600 min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer">
                                    <i class="fa-solid fa-xmark text-lg"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-xs sm:text-sm">
                                <p class="text-slate-500 font-medium">Informasi penempatan kelompok industri:</p>
                                <div id="modal-student-list" class="space-y-2 max-h-60 overflow-y-auto pr-1">
                                    <div class="p-3.5 bg-slate-50 rounded-xl flex items-center justify-between gap-2">
                                        <div>
                                            <span class="font-bold text-slate-800 block">Siswa PKL Terdaftar</span>
                                            <span class="text-xs text-slate-500" x-text="'Penempatan: ' + kelompokInfo.dudi"></span>
                                        </div>
                                        <span class="inline-flex items-center gap-1.5 text-emerald-700 text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="button" @click="modalKelompokOpen = false"
                                    class="min-h-[44px] px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. TAB: TIMELINE PERIODE PKL -->
                <div id="tab-timeline" x-show="activeTab === 'timeline'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm">
                        <h3 class="font-bold text-primary text-lg">Pengaturan Periode PKL &amp; Kontrol Timeline Akademik</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Atur jadwal mulai dan selesai masa PKL, buka/tutup akses input jurnal bagi siswa.</p>
                    </div>

                    <form action="{{ route('admin.timeline.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-4">
                                <h4 class="font-bold text-primary text-base flex items-center gap-2 pb-1">
                                    <i class="fa-regular fa-calendar-days text-secondary"></i> 1. Kalender &amp; Jadwal Pelaksanaan PKL
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide mb-1.5">Tahun Ajaran</label>
                                        <input type="text" name="tahun_ajaran" value="{{ session('pk_tahun_ajaran', '2023/2024') }}"
                                            class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 font-medium">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide mb-1.5">Gelombang / Batch</label>
                                        <select name="gelombang"
                                            class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 font-medium">
                                            <option value="Gelombang 1 (Semester Ganjil)" {{ session('pk_gelombang') == 'Gelombang 1 (Semester Ganjil)' ? 'selected' : '' }}>Gelombang 1 (Semester Ganjil)</option>
                                            <option value="Gelombang 2 (Semester Genap)" {{ session('pk_gelombang') == 'Gelombang 2 (Semester Genap)' ? 'selected' : '' }}>Gelombang 2 (Semester Genap)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide mb-1.5">Tanggal Mulai PKL</label>
                                        <input type="date" name="tanggal_mulai" value="{{ session('pk_tanggal_mulai', '2023-09-01') }}"
                                            class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 font-medium">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-slate-700 uppercase text-xs tracking-wide mb-1.5">Tanggal Selesai PKL</label>
                                        <input type="date" name="tanggal_selesai" value="{{ session('pk_tanggal_selesai', '2026-12-09') }}"
                                            class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 font-medium">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-4 flex flex-col justify-between">
                                <div class="space-y-4">
                                    <h4 class="font-bold text-primary text-base flex items-center gap-2 pb-1">
                                        <i class="fa-solid fa-lock text-secondary"></i> 2. Kontrol Hak Pengisian Jurnal
                                    </h4>
                                    <div class="space-y-2">
                                        <label class="block font-semibold text-slate-700 text-xs sm:text-sm">Status Input Logbook Siswa</label>
                                        <select name="status_lockdown"
                                            class="w-full min-h-[44px] px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 font-medium">
                                            <option value="buka" {{ session('pk_status_lockdown') == 'buka' ? 'selected' : '' }}>Buka (Siswa bebas mengisi)</option>
                                            <option value="tutup" {{ session('pk_status_lockdown') == 'tutup' ? 'selected' : '' }}>Tutup / Lockdown (Akses dikunci)</option>
                                        </select>
                                        <span class="text-xs text-slate-500 block">Pilih 'Tutup' jika masa pengisian jurnal harian telah berakhir.</span>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full min-h-[44px] py-2.5 bg-secondary hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm transition cursor-pointer">
                                    Simpan Semua Pengaturan Timeline
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- 5. TAB: SETTING / PENGATURAN SISTEM -->
                <div id="tab-settings" x-show="activeTab === 'settings'" x-cloak class="tab-content space-y-6">
                    <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm">
                        <h3 class="font-bold text-primary text-lg flex items-center gap-2">
                            <i class="fa-solid fa-gear text-secondary"></i> Pengaturan Sistem &amp; Konfigurasi Aplikasi
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola konfigurasi umum, identitas instansi, batas keamanan, dan preferensi notifikasi sistem PKL.</p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Menu Navigasi Pengaturan -->
                        <div class="bg-white p-4 rounded-xl shadow-sm space-y-1.5 h-fit">
                            <button type="button" @click="activeSettingSub = 'umum'" id="btn-setting-umum"
                                :class="activeSettingSub === 'umum' ? 'bg-blue-50 text-secondary font-bold' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-primary'"
                                class="w-full min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition cursor-pointer">
                                <i class="fa-solid fa-sliders w-5 text-center"></i> Pengaturan Umum
                            </button>
                            <button type="button" @click="activeSettingSub = 'sekolah'" id="btn-setting-sekolah"
                                :class="activeSettingSub === 'sekolah' ? 'bg-blue-50 text-secondary font-bold' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-primary'"
                                class="w-full min-h-[44px] flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs sm:text-sm transition cursor-pointer">
                                <i class="fa-solid fa-school w-5 text-center"></i> Identitas Sekolah
                            </button>
                        </div>

                        <!-- Konten Form Pengaturan -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Sub-Tab 1: Umum -->
                            <div id="sub-setting-umum" x-show="activeSettingSub === 'umum'" x-cloak class="setting-section bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-5">
                                <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                                    <i class="fa-solid fa-sliders text-secondary"></i> Konfigurasi Sistem Utama
                                </h4>
                                <form action="{{ route('admin.settings.umum') }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Aplikasi / Sistem</label>
                                            <input type="text" name="nama_aplikasi" value="{{ session('set_nama_aplikasi', 'Sistem Informasi PKL SMKN 1 Depok') }}"
                                                class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tahun Ajaran Aktif</label>
                                                <select name="tahun_ajaran" class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                                    <option value="2023/2024" {{ session('set_tahun_ajaran') == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                                                    <option value="2024/2025" {{ session('set_tahun_ajaran') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Sistem Logbook</label>
                                                <select name="status_logbook" class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                                    <option value="Dibuka (Aktif)" {{ session('set_status_logbook') == 'Dibuka (Aktif)' ? 'selected' : '' }}>Dibuka (Aktif)</option>
                                                    <option value="Ditutup (Maintenance)" {{ session('set_status_logbook') == 'Ditutup (Maintenance)' ? 'selected' : '' }}>Ditutup (Maintenance)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pesan Pengumuman Global (Banner Dashboard)</label>
                                            <textarea name="pesan_pengumuman" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">{{ session('set_pesan_pengumuman', 'Batas akhir pengunggahan logbook pekan ke-8 adalah hari Jumat pukul 21:00 WIB.') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end pt-4">
                                        <button type="submit" class="w-full sm:w-auto min-h-[44px] px-6 py-2.5 bg-secondary hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm transition cursor-pointer">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sub-Tab 2: Sekolah -->
                            <div id="sub-setting-sekolah" x-show="activeSettingSub === 'sekolah'" x-cloak class="setting-section bg-white p-5 sm:p-6 rounded-xl shadow-sm space-y-5">
                                <h4 class="font-bold text-slate-900 text-base flex items-center gap-2">
                                    <i class="fa-solid fa-school text-secondary"></i> Identitas Instansi / Sekolah
                                </h4>
                                <form action="{{ route('admin.settings.sekolah') }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Resmi Sekolah</label>
                                            <input type="text" name="nama_sekolah" value="{{ \App\Models\Setting::get('school_name', 'SMK Negeri 1 Depok') }}"
                                                class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
                                            <input type="text" name="alamat" value="{{ \App\Models\Setting::get('school_address', 'Jl. Raya Tapos, Gg. Bhakti Suci No. 100, Cimpaeun, Tapos, Kota Depok, Jawa Barat 16459') }}"
                                                class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email Resmi</label>
                                                <input type="email" name="email" value="{{ \App\Models\Setting::get('school_email', 'smkn1depok@gmail.com') }}"
                                                    class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon / Fax</label>
                                                <input type="text" name="telepon" value="{{ \App\Models\Setting::get('school_phone', '(021) 8790-7233') }}"
                                                    class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">WhatsApp (Hanya Chat)</label>
                                                <input type="text" name="whatsapp" value="{{ \App\Models\Setting::get('school_whatsapp', '0877-4444-5006') }}"
                                                    class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Website Resmi</label>
                                                <input type="text" name="website" value="{{ \App\Models\Setting::get('school_website', 'https://www.smkn1depok.sch.id/') }}"
                                                    class="w-full min-h-[44px] px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-secondary">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end pt-4">
                                        <button type="submit" class="w-full sm:w-auto min-h-[44px] px-6 py-2.5 bg-secondary hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm transition cursor-pointer">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>

</html>
