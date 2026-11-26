<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal PKL Digital - SMK Negeri 1 Depok</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        [x-cloak] { display: none !important; }
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
                        customblue: '#3c5897',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased overflow-x-hidden selection:bg-primary selection:text-white">

    <!-- 1. TOP NAVBAR -->
    <nav x-data="{ mobileMenuOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex justify-between items-center gap-4">
            <a href="#" class="text-base font-bold tracking-tight text-slate-900 flex items-center gap-3 min-w-0">
                <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-9 h-9 object-contain shrink-0">
                <span class="truncate">Jurnal PKL Digital</span>
            </a>

            <div class="hidden md:flex items-center space-x-6 lg:space-x-7 text-sm font-semibold text-slate-600">
                <a href="#" class="hover:text-primary transition-colors">Beranda</a>
                <a href="#services" class="hover:text-primary transition-colors">Layanan</a>
                <a href="#about" class="hover:text-primary transition-colors">Tentang Kami</a>
                <a href="#features" class="hover:text-primary transition-colors">Fitur</a>
                <a href="https://www.smkn1depok.sch.id/dudika" target="_blank" rel="noopener noreferrer" class="hover:text-primary transition-colors">DUDIKA</a>
                <a href="#evaluation" class="hover:text-primary transition-colors">Penilaian</a>
                <a href="#faq" class="hover:text-primary transition-colors">FAQ</a>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <a href="/login" class="bg-primary hover:bg-third text-white px-5 py-2.5 min-h-[44px] rounded-lg text-sm font-semibold transition-colors flex items-center gap-2 cursor-pointer">
                    <span>Masuk</span>
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen"
                    class="md:hidden min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer"
                    aria-label="Buka Menu Navigasi">
                    <i data-lucide="menu" x-show="!mobileMenuOpen" class="w-5 h-5" aria-hidden="true"></i>
                    <i data-lucide="x" x-show="mobileMenuOpen" x-cloak class="w-5 h-5" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen" x-cloak x-transition.opacity.duration.150ms
            class="md:hidden bg-white shadow-md px-4 py-4 space-y-2">
            <div class="grid grid-cols-1 gap-1 text-sm font-medium text-slate-700">
                <a href="#" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>Beranda</span><i data-lucide="chevron-right" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
                <a href="#services" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>Layanan</span><i data-lucide="chevron-right" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
                <a href="#about" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>Tentang Kami</span><i data-lucide="chevron-right" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
                <a href="#features" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>Fitur</span><i data-lucide="chevron-right" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
                <a href="https://www.smkn1depok.sch.id/dudika" target="_blank" rel="noopener noreferrer" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>DUDIKA</span><i data-lucide="external-link" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
                <a href="#evaluation" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>Penilaian</span><i data-lucide="chevron-right" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
                <a href="#faq" @click="mobileMenuOpen = false" class="min-h-[44px] px-3 rounded-lg hover:bg-slate-50 hover:text-primary flex items-center justify-between">
                    <span>FAQ</span><i data-lucide="chevron-right" class="w-4 h-4 text-slate-400" aria-hidden="true"></i>
                </a>
            </div>
            <div class="pt-2">
                <a href="/login" class="w-full min-h-[44px] bg-primary hover:bg-third text-white py-2.5 rounded-lg text-center text-sm font-semibold flex items-center justify-center gap-2">
                    <span>Masuk ke Sistem</span><i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- 2. HERO HEADER -->
    <header class="relative overflow-hidden text-white pt-28 sm:pt-32 pb-24 sm:pb-28 bg-slate-900">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ asset('images/smkn 1 depok.jpg') }}');"></div>
        <div class="absolute inset-0 bg-slate-950/75 z-0"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-5">
            <p class="text-xs sm:text-sm font-semibold text-blue-200 tracking-wide">
                SMK Negeri 1 Depok
            </p>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight tracking-tight">
                Transformasi Digital Monitoring PKL Tanpa Batas
            </h1>
            <p class="text-slate-200 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
                Permudah pencatatan absensi harian berbasis GPS, jurnal kegiatan magang, hingga rekapitulasi nilai akhir secara real-time dan terintegrasi antara sekolah dan industri.
            </p>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 pt-2">
                <a href="/login" class="w-full sm:w-auto min-h-[44px] bg-secondary hover:bg-blue-700 text-white px-7 py-3 rounded-lg font-semibold text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                    <span>Masuk ke Sistem</span>
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
                <a href="#services" class="w-full sm:w-auto min-h-[44px] bg-white/15 hover:bg-white/25 text-white px-7 py-3 rounded-lg font-semibold text-sm transition-colors flex items-center justify-center backdrop-blur-sm cursor-pointer">
                    Lihat Alur Layanan
                </a>
            </div>
        </div>
    </header>

    <!-- 3. LAYANAN & CARA KERJA -->
    <section id="services" class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 -mt-12 pb-16 scroll-mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-4 bg-primary text-white p-6 sm:p-7 rounded-xl shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[210px]">
                <div class="absolute inset-0 bg-cover bg-center z-0 opacity-15" style="background-image: url('{{ asset('images/profil.png') }}');"></div>
                <div class="absolute inset-0 bg-primary/90 z-0"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-blue-200">Alur Kerja</span>
                    <i data-lucide="layers" class="w-5 h-5 text-blue-200" aria-hidden="true"></i>
                </div>
                <div class="relative z-10 space-y-2.5 mt-6">
                    <h2 class="text-lg sm:text-xl font-bold tracking-tight">Bagaimana Cara Kerjanya?</h2>
                    <p class="text-sm text-blue-100 leading-relaxed">Siswa mencatat absensi GPS dan laporan harian langsung dari perangkat seluler secara real-time.</p>
                    <div class="pt-1">
                        <a href="#about" class="inline-flex items-center gap-1.5 text-sm font-semibold text-white hover:underline min-h-[44px]">
                            <span>Pelajari Lebih Lanjut</span>
                            <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="map-pin" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Absensi GPS</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Validasi kehadiran magang berbasis koordinat lokasi industri dengan radius geofencing 150 meter.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="file-text" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Jurnal Harian</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Pencatatan kegiatan harian terstruktur yang langsung divalidasi oleh mentor industri dan guru pembimbing.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="bar-chart-3" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-2">Rekap Nilai</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Kalkulasi otomatis bobot ganda (60% DUDI + 40% Sekolah) beserta sertifikat kelulusan resmi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PROFIL SMKN 1 DEPOK & TENTANG KAMI -->
    <section id="about" class="py-16 sm:py-20 bg-white text-slate-900 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-4">
                    <img src="{{ asset('images/smkn 1 depok.jpg') }}" alt="Gedung SMKN 1 Depok" class="rounded-xl object-cover w-full h-44 shadow-sm">
                    <div class="bg-slate-50 p-5 rounded-xl space-y-2">
                        <div class="flex items-center gap-2 text-secondary">
                            <i data-lucide="target" class="w-4 h-4" aria-hidden="true"></i>
                            <h3 class="font-bold text-base text-slate-900">Visi Program</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed">Mewujudkan ekosistem digitalisasi SMK vokasi yang transparan dan efisien.</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="bg-slate-50 p-5 rounded-xl space-y-2">
                        <div class="flex items-center gap-2 text-secondary">
                            <i data-lucide="award" class="w-4 h-4" aria-hidden="true"></i>
                            <h3 class="font-bold text-base text-slate-900">Misi Program</h3>
                        </div>
                        <p class="text-sm text-slate-600 leading-relaxed">Menghubungkan sekolah dengan dunia industri secara real-time.</p>
                    </div>
                    <img src="{{ asset('images/smkn-1-depok-2.jpg') }}" alt="Lingkungan Belajar SMKN 1 Depok" class="rounded-xl object-cover w-full h-44 shadow-sm">
                </div>
            </div>

            <div class="lg:col-span-6 space-y-5">
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug">
                    Solusi Terpadu Manajemen PKL Sekolah &amp; Industri
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Platform Jurnal PKL Digital SMK Negeri 1 Depok dirancang khusus untuk memangkas birokrasi manual, mengurangi penggunaan kertas, serta mempercepat proses evaluasi magang siswa secara menyeluruh.
                </p>
                <div class="bg-slate-50 p-4 rounded-xl flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center shrink-0">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-800">Mendukung efisiensi pemantauan siswa magang di era digital dengan audit trail terverifikasi.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FITUR UTAMA PLATFORM & KEUNGGULAN TERPADU -->
    <section id="features" x-data="{ activeRole: 'siswa' }" class="py-16 sm:py-20 bg-slate-50 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div class="space-y-2 max-w-2xl">
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                        Dirancang untuk Kemudahan Semua Pengguna
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600">
                        Fitur terintegrasi yang disesuaikan khusus untuk kebutuhan siswa magang, guru pembimbing, dan mentor industri.
                    </p>
                </div>

                <!-- Role Tabs Selector (Alpine.js) -->
                <div class="inline-flex w-full md:w-auto bg-white rounded-xl p-1.5 gap-1.5 shadow-sm overflow-x-auto shrink-0">
                    <button type="button" @click="activeRole = 'siswa'"
                        :class="activeRole === 'siswa' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-medium'"
                        class="flex-1 md:flex-none min-h-[44px] flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm transition-colors shrink-0 cursor-pointer">
                        <i data-lucide="user-check" class="w-4 h-4" aria-hidden="true"></i>
                        <span>Siswa Magang</span>
                    </button>
                    <button type="button" @click="activeRole = 'guru'"
                        :class="activeRole === 'guru' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-medium'"
                        class="flex-1 md:flex-none min-h-[44px] flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm transition-colors shrink-0 cursor-pointer">
                        <i data-lucide="graduation-cap" class="w-4 h-4" aria-hidden="true"></i>
                        <span>Guru Pembimbing</span>
                    </button>
                    <button type="button" @click="activeRole = 'mentor'"
                        :class="activeRole === 'mentor' ? 'bg-primary text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-medium'"
                        class="flex-1 md:flex-none min-h-[44px] flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm transition-colors shrink-0 cursor-pointer">
                        <i data-lucide="briefcase" class="w-4 h-4" aria-hidden="true"></i>
                        <span>Mentor DUDIKA</span>
                    </button>
                </div>
            </div>

            <!-- Panel 1: Siswa Magang -->
            <div x-show="activeRole === 'siswa'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="map-pin" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Presensi Geofencing GPS</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Absen masuk dan pulang secara akurat berbasis koordinat lokasi industri mitra tanpa risiko manipulasi lokasi.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Radius lokasi akurat 150m</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="camera" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Jurnal &amp; Kegiatan Harian</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Catat deskripsi pekerjaan harian, perbaiki entri revisi, dan pantau umpan balik mentor langsung dari perangkat.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Sinkronisasi instan di HP</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="calendar-check" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Rekap Kehadiran &amp; Nilai</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Pantau akumulasi kehadiran, status persetujuan jurnal, nilai akhir, dan unduh sertifikat resmi kelulusan.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Transparan &amp; terpantau harian</span>
                    </div>
                </div>
            </div>

            <!-- Panel 2: Guru Pembimbing -->
            <div x-show="activeRole === 'guru'" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="map" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Monitoring Sebaran Siswa</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Pantau sebaran lokasi seluruh anak bimbingan di berbagai mitra industri secara real-time dan terpusat.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Filter jurusan &amp; status reaktif</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="check-circle-2" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Verifikasi &amp; Catatan Jurnal</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Tinjau logbook harian, pantau status presensi luar radius, dan cetak riwayat logbook bimbingan siswa.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Monitoring akurat tanpa lag</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="clipboard-list" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Input Nilai Laporan &amp; Ekspor</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Input nilai naskah laporan sekolah (40%) untuk kalkulasi nilai akhir otomatis serta ekspor rekap CSV/Word.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Format laporan resmi otomatis</span>
                    </div>
                </div>
            </div>

            <!-- Panel 3: Mentor DUDIKA -->
            <div x-show="activeRole === 'mentor'" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="shield-check" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Validasi Presensi Industri</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Pantau kehadiran harian dan kedisiplinan jam operasional siswa binaan di lingkungan industri secara akurat.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Metrik kehadiran harian riil</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="file-check" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Approval Kegiatan Lapangan</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Setujui atau minta revisi logbook siswa binaan secara instan tanpa reload halaman dengan catatan pembinaan.</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Approval instan satu klik</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-primary flex items-center justify-center mb-4">
                            <i data-lucide="award" class="w-5 h-5" aria-hidden="true"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Penilaian Kinerja Industri</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Input 4 pilar kompetensi teknis, disiplin, kerjasama, dan inisiatif siswa ke formulir evaluasi digital (bobot 60%).</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-secondary">
                        <i data-lucide="check" class="w-4 h-4" aria-hidden="true"></i><span>Sinkronisasi nilai akhir otomatis</span>
                    </div>
                </div>
            </div>

            <!-- KEUNGGULAN PLATFORM TERPADU -->
            <div class="mt-14">
                <div class="mb-8 space-y-1">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">Keunggulan Platform Terpadu</h3>
                    <p class="text-sm text-slate-600">Standar keamanan data dan fleksibilitas akses di seluruh perangkat.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-5 shadow-sm space-y-4">
                        <div class="w-full h-44 bg-slate-100 rounded-lg overflow-hidden">
                            <img src="{{ asset('images/multi-device.jpg') }}" alt="Akses Multi-Device" class="w-full h-full object-cover">
                        </div>
                        <div class="space-y-1.5">
                            <h4 class="font-bold text-base text-slate-900">Akses Multi-Device</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Dapat diakses dengan mudah melalui smartphone Android &amp; iOS maupun komputer, kapan saja dan di mana saja.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm space-y-4">
                        <div class="w-full h-44 bg-slate-100 rounded-lg overflow-hidden">
                            <img src="{{ asset('images/keamanan.jpg') }}" alt="Validasi & Keamanan" class="w-full h-full object-cover">
                        </div>
                        <div class="space-y-1.5">
                            <h4 class="font-bold text-base text-slate-900">Validasi &amp; Keamanan</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Penguncian koordinat DUDI berbasis geofence GPS dan otorisasi berbasis peran (RBAC) yang ketat.</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 shadow-sm space-y-4">
                        <div class="w-full h-44 bg-slate-100 rounded-lg overflow-hidden">
                            <img src="{{ asset('images/laporan.jpg') }}" alt="Ekspor Laporan Otomatis" class="w-full h-full object-cover">
                        </div>
                        <div class="space-y-1.5">
                            <h4 class="font-bold text-base text-slate-900">Ekspor Laporan Otomatis</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">Cetak laporan kegiatan harian, sertifikat kelulusan resmi, dan rekap nilai CSV terstandar dinas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. STATISTIK & OVERVIEW COUNTER -->
    <section id="evaluation" class="py-16 sm:py-20 bg-white text-slate-900 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                    Monitoring Aktivitas Magang Siswa Aktif
                </h2>
                <p class="text-sm sm:text-base text-slate-600">
                    Rekapitulasi data pelaksanaan Praktik Kerja Lapangan secara real-time di SMKN 1 Depok.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-slate-50 rounded-xl p-5 sm:p-6 space-y-3">
                    <i data-lucide="users" class="w-5 h-5 text-secondary" aria-hidden="true"></i>
                    <div>
                        <div class="tabular-nums text-2xl sm:text-3xl font-bold text-primary tracking-tight">450+</div>
                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1">Siswa Sedang Magang</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-5 sm:p-6 space-y-3">
                    <i data-lucide="briefcase" class="w-5 h-5 text-secondary" aria-hidden="true"></i>
                    <div>
                        <div class="tabular-nums text-2xl sm:text-3xl font-bold text-primary tracking-tight">85+</div>
                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1">DUDI / Industri Mitra</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-5 sm:p-6 space-y-3">
                    <i data-lucide="book-open" class="w-5 h-5 text-secondary" aria-hidden="true"></i>
                    <div>
                        <div class="tabular-nums text-2xl sm:text-3xl font-bold text-primary tracking-tight">12.5K</div>
                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1">Jurnal Harian Masuk</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-5 sm:p-6 space-y-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-secondary" aria-hidden="true"></i>
                    <div>
                        <div class="tabular-nums text-2xl sm:text-3xl font-bold text-primary tracking-tight">99%</div>
                        <p class="text-xs sm:text-sm text-slate-600 font-medium mt-1">Kehadiran Valid GPS</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. FAQ ACCORDION (ALPINE.JS) -->
    <section id="faq" x-data="{ activeFaq: null }" class="py-16 sm:py-20 bg-slate-50 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                <div class="lg:col-span-5 space-y-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 leading-tight">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        Temukan jawaban cepat seputar sistem monitoring, absensi GPS, logbook, hingga pengelolaan PKL digital.
                    </p>
                    <div class="p-5 bg-white rounded-xl shadow-sm text-sm text-slate-600 space-y-1">
                        <p class="font-bold text-slate-900">Butuh bantuan lebih lanjut?</p>
                        <p>Hubungi tim Pokja Hubin atau operator portal Jurnal PKL Digital SMKN 1 Depok.</p>
                    </div>
                </div>

                <div class="lg:col-span-7 space-y-3">
                    <!-- FAQ 1 -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <button type="button" @click="activeFaq = (activeFaq === 1 ? null : 1)" :aria-expanded="activeFaq === 1"
                            class="w-full min-h-[44px] flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors cursor-pointer gap-4">
                            <span class="font-semibold text-slate-900 text-sm sm:text-base">Bagaimana cara siswa melakukan absensi harian PKL?</span>
                            <span :class="activeFaq === 1 ? 'bg-primary text-white rotate-180' : 'bg-slate-100 text-slate-600'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-transform duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 1" x-cloak class="px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                            Siswa dapat melakukan absensi langsung melalui menu <b>Attendance</b> di dashboard masing-masing. Sistem menggunakan validasi otomatis (GPS koordinat kantor DUDI radius 150 meter dan waktu real-time) yang terhubung langsung dengan sekolah dan pembimbing DUDI.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <button type="button" @click="activeFaq = (activeFaq === 2 ? null : 2)" :aria-expanded="activeFaq === 2"
                            class="w-full min-h-[44px] flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors cursor-pointer gap-4">
                            <span class="font-semibold text-slate-900 text-sm sm:text-base">Kapan batas waktu pengunggahan logbook atau jurnal harian?</span>
                            <span :class="activeFaq === 2 ? 'bg-primary text-white rotate-180' : 'bg-slate-100 text-slate-600'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-transform duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 2" x-cloak class="px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                            Batas pengunggahan logbook harian disesuaikan dengan kebijakan sekolah atau tenggat waktu pekanan (setiap hari Jumat pukul 21:00 WIB). Pastikan mentor industri sudah memberikan persetujuan (approval) sebelum batas waktu berakhir.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <button type="button" @click="activeFaq = (activeFaq === 3 ? null : 3)" :aria-expanded="activeFaq === 3"
                            class="w-full min-h-[44px] flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors cursor-pointer gap-4">
                            <span class="font-semibold text-slate-900 text-sm sm:text-base">Bagaimana cara guru pembimbing memantau siswa bimbingannya?</span>
                            <span :class="activeFaq === 3 ? 'bg-primary text-white rotate-180' : 'bg-slate-100 text-slate-600'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-transform duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 3" x-cloak class="px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                            Guru pembimbing dapat masuk ke Dashboard Guru, memilih menu <b>Monitoring Siswa</b> atau <b>DUDI &amp; Penempatan</b> untuk melihat rekapitulasi kehadiran, progres pekerjaan harian di industri, serta mengunduh rekap logbook bimbingan.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <button type="button" @click="activeFaq = (activeFaq === 4 ? null : 4)" :aria-expanded="activeFaq === 4"
                            class="w-full min-h-[44px] flex items-center justify-between p-5 text-left hover:bg-slate-50 transition-colors cursor-pointer gap-4">
                            <span class="font-semibold text-slate-900 text-sm sm:text-base">Bagaimana mekanisme penghitungan nilai akhir PKL?</span>
                            <span :class="activeFaq === 4 ? 'bg-primary text-white rotate-180' : 'bg-slate-100 text-slate-600'"
                                class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition-transform duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </button>
                        <div x-show="activeFaq === 4" x-cloak class="px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                            Sistem menerapkan penilaian ganda (Dual-Assessment): 60% dari evaluasi 4 pilar kompetensi Mentor Industri (DUDIKA) dan 40% dari nilai naskah laporan Guru Pembimbing Sekolah, yang langsung terkonversi menjadi predikat resmi dan sertifikat PKL.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CTA BANNER & FOOTER -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="rounded-xl bg-primary text-white p-6 sm:p-10 shadow-sm relative overflow-hidden">
                <div class="absolute inset-0 bg-cover bg-center z-0 opacity-15" style="background-image: url('{{ asset('images/profil.png') }}');"></div>
                <div class="absolute inset-0 bg-primary/90 z-0"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="space-y-2 max-w-2xl">
                        <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                            Siap Memulai Pengalaman PKL Digital?
                        </h2>
                        <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                            Masuk ke portal untuk mencatat kehadiran GPS, mengisi logbook harian, dan memantau evaluasi magang secara transparan.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                        <a href="/login" class="min-h-[44px] bg-white hover:bg-slate-100 text-primary px-6 py-3 rounded-lg font-semibold text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                            <i data-lucide="log-in" class="w-4 h-4" aria-hidden="true"></i>
                            <span>Masuk ke Portal</span>
                        </a>
                        <a href="https://wa.me/6287744445006" target="_blank" rel="noopener noreferrer" class="min-h-[44px] bg-third hover:bg-secondary text-white px-6 py-3 rounded-lg font-semibold text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                            <i data-lucide="message-circle" class="w-4 h-4 text-emerald-300" aria-hidden="true"></i>
                            <span>Bantuan WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-slate-900 text-slate-200 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-3 gap-8 pb-8">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-10 h-10 object-contain shrink-0">
                    <div>
                        <span class="text-base font-bold text-white block">Jurnal PKL Digital</span>
                        <span class="text-xs text-slate-400">SMK Negeri 1 Depok</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-slate-400">
                    Platform digital terpadu SMK Negeri 1 Depok untuk pemantauan, validasi presensi berbasis GPS, pengisian jurnal harian, dan evaluasi Praktik Kerja Lapangan (PKL).
                </p>
            </div>

            <div class="md:flex md:justify-center">
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2.5 text-sm text-slate-300">
                        <li><a href="#" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#services" class="hover:text-white transition-colors">Layanan</a></li>
                        <li><a href="#about" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Fitur</a></li>
                        <li><a href="https://www.smkn1depok.sch.id/dudika" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">DUDIKA</a></li>
                        <li><a href="#evaluation" class="hover:text-white transition-colors">Penilaian</a></li>
                        <li><a href="#faq" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4">Informasi Kontak</h4>
                <ul class="space-y-2.5 text-sm text-slate-300">
                    <li class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-400 shrink-0 mt-1" aria-hidden="true"></i>
                        <span class="leading-relaxed">Jl. Raya Tapos, Gg. Bhakti Suci No. 100, Cimpaeun, Tapos, Kota Depok, Jawa Barat 16459</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="w-4 h-4 text-blue-400 shrink-0" aria-hidden="true"></i>
                        <span>(021) 8790-7233 (Telepon / Fax)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="message-circle" class="w-4 h-4 text-blue-400 shrink-0" aria-hidden="true"></i>
                        <span>0877-4444-5006 (WhatsApp Chat)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-400 shrink-0" aria-hidden="true"></i>
                        <a href="mailto:smkn1depok@gmail.com" class="hover:underline text-white">smkn1depok@gmail.com</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="globe" class="w-4 h-4 text-blue-400 shrink-0" aria-hidden="true"></i>
                        <a href="https://www.smkn1depok.sch.id/" target="_blank" rel="noopener noreferrer" class="hover:underline text-white">www.smkn1depok.sch.id</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 text-center text-xs text-slate-400">
            <p>&copy; 2026 SMK Negeri 1 Depok - Jurnal PKL Digital. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
    </script>
</body>
</html>
