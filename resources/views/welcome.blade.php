<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal PKL Digital - Beranda</title>
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
                        customblue: '#3b5998',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-800 font-sans antialiased overflow-x-hidden selection:bg-[#3b5998] selection:text-white">

    <!-- NAVBAR STICKY DI ATAS -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <a href="#" class="text-base sm:text-lg font-bold tracking-tight text-slate-800 flex items-center gap-2.5">
                    <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo Jurnal PKL" class="w-10 h-10 object-contain">
                    <span class="truncate">Jurnal PKL Digital</span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6 lg:space-x-8 text-sm font-medium">
                <a href="#" class="text-slate-800 hover:text-black transition">Beranda</a>
                <a href="#about" class="text-slate-800 hover:text-black transition">Tentang Kami</a>
                <a href="#services" class="text-slate-800 hover:text-black transition">Layanan</a>
                <a href="#features" class="text-slate-800 hover:text-black transition">Fitur</a>
                <a href="https://www.smkn1depok.sch.id/dudika" target="_blank" rel="noopener noreferrer" class="text-slate-800 hover:text-black transition">DUDIKA</a>
                <a href="#evaluation" class="text-slate-800 hover:text-black transition">Penilaian</a>
                <a href="#faq" class="text-slate-800 hover:text-black transition">FAQ</a>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="/login" class="bg-[#3b5998] hover:bg-[#324b82] text-white px-5 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-bold shadow-md shadow-[#3b5998]/20 transition flex items-center gap-1.5">
                    <span>Masuk</span>
                </a>
                <!-- HAMBURGER MENU BUTTON FOR MOBILE -->
                <button type="button" id="mobile-menu-btn" onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-xl text-slate-700 hover:text-black hover:bg-slate-100 transition focus:outline-none" aria-label="Buka Menu Navigasi">
                    <i data-lucide="menu" id="menu-icon-open" class="w-6 h-6"></i>
                    <i data-lucide="x" id="menu-icon-close" class="w-6 h-6 hidden"></i>
                </button>
            </div>
        </div>

        <!-- MOBILE NAVIGATION DRAWER (RESPONSIF SMARTPHONE) -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/98 border-b border-slate-200 shadow-xl px-5 py-4 space-y-2 backdrop-blur-md animate-in slide-in-from-top duration-200">
            <div class="flex flex-col space-y-1 text-sm font-medium text-slate-700">
                <a href="#" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>Beranda</span> <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="#about" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>Tentang Kami</span> <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="#services" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>Layanan</span> <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="#features" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>Fitur</span> <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="https://www.smkn1depok.sch.id/dudika" target="_blank" rel="noopener noreferrer" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>DUDIKA</span> <i data-lucide="external-link" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="#evaluation" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>Penilaian</span> <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="#faq" onclick="toggleMobileMenu()" class="px-3 py-2.5 rounded-xl hover:bg-blue-50 hover:text-[#3b5998] transition flex items-center justify-between">
                    <span>FAQ</span> <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
            </div>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <a href="/login" class="w-full bg-[#3b5998] hover:bg-[#324b82] text-white py-2.5 rounded-full text-center text-xs font-bold shadow-md shadow-[#3b5998]/20 transition flex items-center justify-center gap-1.5">
                    Masuk ke Sistem <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative overflow-hidden text-white pt-32 sm:pt-36 pb-32 sm:pb-36">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ asset('images/smkn 1 depok.jpg') }}');"></div>
        <div class="absolute inset-0 bg-slate-900/65 z-0"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10 space-y-5 sm:space-y-6">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.18] sm:leading-[1.12] tracking-tight drop-shadow-md">
                Transformasi Digital Monitoring PKL <br class="hidden sm:inline">
                Tanpa Batas
            </h1>
            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed max-w-2xl mx-auto drop-shadow px-2">
                Permudah pencatatan absensi harian, jurnal kegiatan magang, hingga rekapitulasi nilai akhir secara real-time dan terintegrasi antara sekolah dan industri.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2">
                <a href="/login" class="w-full sm:w-auto bg-[#3b5998] text-white px-8 py-3.5 rounded-full font-bold text-xs sm:text-sm hover:bg-[#324b82] transition shadow-xl shadow-[#3b5998]/30 flex items-center justify-center gap-2 border border-blue-400/30">
                    <span>Masuk ke Sistem</span> <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- SECTION SERVICES -->
    <section id="services" class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 -mt-20 pb-14 scroll-mt-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <div class="lg:col-span-4 bg-[#3b5998] text-white rounded-3xl p-6 relative overflow-hidden group shadow-xl flex flex-col justify-between border border-blue-400/30">
                <div class="absolute inset-0 bg-cover bg-center z-0 opacity-20 group-hover:scale-105 transition duration-500" style="background-image: url('{{ asset('images/profil.png') }}');"></div>
                <div class="absolute inset-0 bg-[#3b5998]/90 z-0"></div>
                <div class="relative z-10 h-8"></div>
                <div class="relative z-10 space-y-2 mt-auto">
                    <h3 class="text-lg font-bold">Bagaimana Cara Kerjanya?</h3>
                    <p class="text-[11px] text-blue-100 leading-relaxed">Siswa mencatat absensi & laporan harian langsung dari perangkat seluler secara real-time.</p>
                    <div class="pt-1">
                        <a href="#about" class="inline-flex items-center gap-1.5 text-xs font-bold text-white hover:underline">Pelajari Lebih Lanjut <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white text-gray-900 p-6 rounded-3xl border border-slate-200 shadow-md hover:shadow-xl transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base mb-2">Absensi GPS</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Validasi kehadiran magang berbasis koordinat lokasi industri yang akurat.</p>
                    </div>
                </div>

                <div class="bg-white text-gray-900 p-6 rounded-3xl border border-slate-200 shadow-md hover:shadow-xl transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base mb-2">Jurnal Harian</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Pencatatan kegiatan harian yang langsung dicek oleh guru pembimbing.</p>
                    </div>
                </div>

                <div class="bg-white text-gray-900 p-6 rounded-3xl border border-slate-200 shadow-md hover:shadow-xl transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition">
                            <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base mb-2">Rekap Nilai</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Rekapitulasi nilai akhir PKL tersaji instan dalam format terstandarisasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION ABOUT US -->
    <section id="about" class="py-16 sm:py-20 bg-white text-gray-800 border-t border-slate-200 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-4">
                   <img src="{{ asset('images/smkn 1 depok.jpg') }}" alt="Deskripsi Gambar" class="rounded-2xl shadow-md object-cover w-full h-[180px]">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <div class="text-[#3b5998] mb-2"><i data-lucide="target" class="w-6 h-6"></i></div>
                        <h5 class="font-bold text-sm text-gray-900 mb-1">Visi Program</h5>
                        <p class="text-[11px] text-gray-600">Mewujudkan ekosistem digitalisasi SMK vokasi yang transparan dan efisien.</p>
                    </div>
                </div>
                <div class="space-y-4 pt-0 sm:pt-8">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <div class="text-[#3b5998] mb-2"><i data-lucide="award" class="w-6 h-6"></i></div>
                        <h5 class="font-bold text-sm text-gray-900 mb-1">Misi Program</h5>
                        <p class="text-[11px] text-gray-600">Menghubungkan sekolah dengan dunia industri secara real-time.</p>
                    </div>
                    <img src="{{ asset('images/smkn-1-depok-2.jpg') }}" alt="Deskripsi Gambar" class="rounded-2xl shadow-md object-cover w-full h-[180px]">
                </div>
            </div>

            <div class="lg:col-span-6 space-y-6">
                <span class="inline-block text-[11px] font-bold text-[#3b5998] uppercase tracking-wider bg-blue-100 px-4 py-1.5 rounded-full border border-blue-200">
                    Tentang Kami
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight leading-snug">
                    Solusi Terpadu Manajemen PKL Sekolah & Industri
                </h2>
                <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                    Platform Jurnal PKL Digital dirancang khusus untuk memangkas birokrasi manual, mengurangi penggunaan kertas, serta mempercepat proses evaluasi magang siswa secara menyeluruh.
                </p>
                <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#3b5998] text-white flex items-center justify-center font-bold shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800">Mendukung efisiensi pemantauan siswa magang di era digital.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FITUR UNGGULAN & ROLE TABS -->
    <section id="features" class="py-16 sm:py-24 bg-slate-50 border-t border-slate-200 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-4xl mx-auto mb-10 sm:mb-14 space-y-3">
                <span class="inline-block text-[11px] font-bold text-[#3b5998] uppercase tracking-wider bg-blue-100 px-4 py-1.5 rounded-full border border-blue-200">
                    Fitur
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-gray-900">
                    Dirancang untuk Kemudahan Semua Pengguna
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 max-w-2xl mx-auto">
                    Fitur terintegrasi yang disesuaikan khusus untuk kebutuhan siswa magang, guru pembimbing, dan mentor industri.
                </p>
            </div>

            <!-- ROLE TABS SELECTOR (RESPONSIF MOBILE HORIZONTAL SCROLL) -->
            <div class="flex items-center justify-start sm:justify-center gap-2 sm:gap-3 overflow-x-auto pb-3 mb-8 sm:mb-10 no-scrollbar">
                <button type="button" id="tab-btn-siswa" onclick="switchRoleTab('siswa')" class="role-tab-btn flex items-center gap-2 px-5 py-3 rounded-full text-xs sm:text-sm font-bold bg-[#3b5998] hover:bg-[#324b82] text-white shadow-md shadow-[#3b5998]/25 transition shrink-0">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span>Siswa Magang</span>
                </button>
                <button type="button" id="tab-btn-guru" onclick="switchRoleTab('guru')" class="role-tab-btn flex items-center gap-2 px-5 py-3 rounded-full text-xs sm:text-sm font-medium bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 transition shrink-0">
                    <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                    <span>Guru Pembimbing</span>
                </button>
                <button type="button" id="tab-btn-mentor" onclick="switchRoleTab('mentor')" class="role-tab-btn flex items-center gap-2 px-5 py-3 rounded-full text-xs sm:text-sm font-medium bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 transition shrink-0">
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    <span>Mentor DUDIKA</span>
                </button>
            </div>

            <!-- ROLE PANELS -->
            <!-- Panel 1: Siswa Magang -->
            <div id="role-panel-siswa" class="role-panel">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="map-pin" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Presensi Geofencing GPS</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Absen masuk dan pulang secara akurat berbasis koordinat lokasi industri mitra tanpa resiko fake GPS.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Radius lokasi akurat & otomatis</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="camera" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Jurnal & Foto Kegiatan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Catat deskripsi pekerjaan harian dan unggah bukti foto pelaksanaan magang langsung dari kamera ponsel.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Upload instan langsung di HP</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="calendar-check" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Rekap Kehadiran Realtime</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Pantau akumulasi kehadiran, status persetujuan jurnal oleh pembimbing, dan rekapitulasi mandiri setiap saat.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Transparan & terpantau setiap hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel 2: Guru Pembimbing -->
            <div id="role-panel-guru" class="role-panel hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="map" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Monitoring Sebaran Siswa</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Pantau sebaran lokasi seluruh anak bimbingan di berbagai mitra industri secara real-time dan terpusat.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Dashboard peta sebaran praktis</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Verifikasi & Catatan Jurnal</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Tinjau logbook harian, berikan feedback bimbingan, dan setujui jurnal siswa secara berkala dari mana saja.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Approval cepat dalam satu klik</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Lembar Bimbingan & Rekap</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Cetak lembar riwayat monitoring dan rekapitulasi penilaian sekolah yang tersusun rapi standar dinas.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Format laporan resmi otomatis</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel 3: Mentor DUDIKA -->
            <div id="role-panel-mentor" class="role-panel hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="shield-check" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Validasi Presensi Industri</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Konfirmasi presensi kehadiran dan kedisiplinan jam operasional siswa di lingkungan industri secara akurat.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Mencegah ketidakhadiran tanpa izin</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="file-check" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Approval Kegiatan Lapangan</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Pastikan pekerjaan yang dicatat siswa di logbook telah sesuai dengan SOP dan capaian kerja divisi mitra.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Sinkronisasi standar kerja industri</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition duration-300">
                                <i data-lucide="award" class="w-6 h-6"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-base sm:text-lg mb-2 group-hover:text-[#3b5998] transition">Penilaian Kinerja Industri</h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">Input nilai kompetensi teknis, inisiatif, dan etika kerja siswa langsung ke formulir evaluasi digital.</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-[#3b5998]">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> <span>Bobot penilaian industri terstandar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KEUNGGULAN PLATFORM TERPADU (KARTU GAMBAR ASSET) -->
            <div class="mt-14 sm:mt-16 pt-10 sm:pt-12 border-t border-slate-200">
                <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-10 space-y-2">
                    <h3 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Keunggulan Platform Terpadu</h3>
                    <p class="text-xs sm:text-sm text-gray-600">Standar teknologi modern untuk keamanan data dan fleksibilitas akses di seluruh perangkat.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all space-y-4 flex flex-col justify-between">
                        <div class="w-full h-48 bg-blue-50/50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-100">
                            <img src="{{ asset('images/multi-device.jpg') }}" alt="Akses Multi-Device" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-base text-gray-900">Akses Multi-Device</h3>
                            <p class="text-xs text-gray-600 leading-relaxed">Dapat diakses dengan mudah melalui <em>smartphone</em> Android & iOS maupun komputer, kapan saja dan di mana saja.</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all space-y-4 flex flex-col justify-between">
                        <div class="w-full h-48 bg-blue-50/50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-100">
                            <img src="{{ asset('images/keamanan.jpg') }}" alt="Validasi & Keamanan" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-base text-gray-900">Validasi & Keamanan</h3>
                            <p class="text-xs text-gray-600 leading-relaxed">Sistem penguncian lokasi berbasis GPS dan persetujuan digital ganda untuk menghindari kecurangan absensi.</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl shadow-sm transition-all space-y-4 flex flex-col justify-between">
                        <div class="w-full h-48 bg-blue-50/50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-100">
                            <img src="{{ asset('images/laporan.jpg') }}" alt="Ekspor Laporan Otomatis" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-base text-gray-900">Ekspor Laporan Otomatis</h3>
                            <p class="text-xs text-gray-600 leading-relaxed">Cetak laporan kegiatan harian dan rekap nilai akhir magang langsung ke format PDF atau Excel dengan rapi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION EVALUATION (STATISTIK) -->
    <section id="evaluation" class="py-16 sm:py-24 bg-white text-gray-900 border-t border-slate-200 relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center max-w-4xl mx-auto mb-10 sm:mb-16 space-y-3">
                <span class="inline-block text-[11px] font-bold text-[#3b5998] uppercase tracking-wider bg-blue-100 px-4 py-1.5 rounded-full border border-blue-200">
                    Penilaian
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-gray-900">
                    Monitoring Aktivitas Magang Siswa Aktif
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 max-w-2xl mx-auto">
                    Rekapitulasi data harian pelaksanaan Praktik Kerja Lapangan secara real-time.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-slate-50 p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-2 sm:space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="users" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-black text-[#3b5998] tracking-tight">450+</div>
                    <p class="text-[11px] sm:text-xs text-gray-600 font-medium">Siswa Sedang Magang</p>
                </div>

                <div class="bg-slate-50 p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-2 sm:space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="briefcase" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-black text-[#3b5998] tracking-tight">85+</div>
                    <p class="text-[11px] sm:text-xs text-gray-600 font-medium">Dudi / Industri Mitra</p>
                </div>

                <div class="bg-slate-50 p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-2 sm:space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="book-open" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-black text-[#3b5998] tracking-tight">12.5K</div>
                    <p class="text-[11px] sm:text-xs text-gray-600 font-medium">Jurnal Harian Masuk</p>
                </div>

                <div class="bg-slate-50 p-5 sm:p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-2 sm:space-y-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-black text-[#3b5998] tracking-tight">99%</div>
                    <p class="text-[11px] sm:text-xs text-gray-600 font-medium">Kehadiran Valid GPS</p>
                </div>
            </div>
        </div>
    </section>
    <!-- SECTION FAQ (LAYOUT DUA KOLOM DENGAN IKON PANAH SVG) -->
<section id="faq" class="py-16 sm:py-20 bg-slate-50 border-t border-slate-200 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-stretch">

            <!-- KOLOM KIRI: JUDUL & DESKRIPSI -->
            <div class="lg:col-span-5 flex flex-col justify-between h-full">
                <div class="space-y-4">
                    <span class="inline-block bg-blue-100 text-[#3b5998] text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider border border-blue-200">FAQ</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                    <p class="text-slate-600 text-sm leading-relaxed text-justify">Temukan jawaban lengkap dan cepat atas pertanyaan umum seputar sistem monitoring, absensi, logbook, hingga pengelolaan PKL digital.</p>
                </div>
                <div class="pt-6 hidden lg:block mt-auto">
                    <div class="p-4 bg-white rounded-2xl border border-slate-200 text-xs text-slate-600 space-y-1 shadow-sm">
                        <p class="font-bold text-slate-800">Butuh bantuan lebih lanjut?</p>
                        <p>Hubungi tim admin sekolah atau operator portal Jurnal PKL Digital.</p>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: DAFTAR PERTANYAAN (DROPDOWN / ACCORDION) -->
            <div class="lg:col-span-7 space-y-4 flex flex-col justify-between">
                <!-- Item 1 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-schoolblue/50 shadow-sm bg-white">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-slate-50/50 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800 text-sm md:text-base pr-4">Bagaimana cara siswa melakukan absensi harian PKL?</span>
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0 transition-transform duration-300 arrow-box text-slate-600">
                            <svg class="w-4 h-4 transition-transform duration-300 arrow-svg" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-slate-600 text-xs md:text-sm leading-relaxed border-t border-slate-100 pt-3">
                        Siswa dapat melakukan absensi langsung melalui menu <b>Attendance</b> di dashboard masing-masing. Sistem menggunakan validasi otomatis (GPS / lokasi dan waktu real-time) yang terhubung langsung dengan sekolah dan pembimbing DUDI.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-schoolblue/50 shadow-sm bg-white">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-slate-50/50 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800 text-sm md:text-base pr-4">Kapan batas waktu pengunggahan logbook atau jurnal harian?</span>
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0 transition-transform duration-300 arrow-box text-slate-600">
                            <svg class="w-4 h-4 transition-transform duration-300 arrow-svg" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-slate-600 text-xs md:text-sm leading-relaxed border-t border-slate-100 pt-3">
                        Batas pengunggahan logbook harian disesuaikan dengan kebijakan sekolah atau tenggat waktu pekanan (biasanya setiap hari Jumat pukul 21:00 WIB). Pastikan mentor industri sudah memberikan persetujuan (approval) sebelum batas waktu berakhir.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-schoolblue/50 shadow-sm bg-white">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-slate-50/50 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800 text-sm md:text-base pr-4">Bagaimana cara guru pembimbing memantau siswa bimbingannya?</span>
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0 transition-transform duration-300 arrow-box text-slate-600">
                            <svg class="w-4 h-4 transition-transform duration-300 arrow-svg" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-slate-600 text-xs md:text-sm leading-relaxed border-t border-slate-100 pt-3">
                        Guru pembimbing dapat masuk ke Dashboard Guru, memilih menu <b>Monitoring Siswa</b> atau <b>DUDI & Penempatan</b> untuk melihat rekapitulasi kehadiran, progres pekerjaan harian di industri, serta mengunduh rekap logbook dalam format PDF.
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200 hover:border-schoolblue/50 shadow-sm bg-white">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between p-5 text-left bg-white hover:bg-slate-50/50 transition-colors focus:outline-none">
                        <span class="font-bold text-slate-800 text-sm md:text-base pr-4">Apakah orang tua atau wali murid bisa memantau aktivitas PKL?</span>
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0 transition-transform duration-300 arrow-box text-slate-600">
                            <svg class="w-4 h-4 transition-transform duration-300 arrow-svg" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div class="faq-content hidden px-5 pb-5 text-slate-600 text-xs md:text-sm leading-relaxed border-t border-slate-100 pt-3">
                        Ya, portal Jurnal PKL Digital dirancang transparan. Wali murid atau orang tua dapat memantau status kehadiran serta rekapitulasi nilai akhir secara berkala melalui akses akun khusus yang disediakan oleh pihak sekolah.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SCRIPT INTERAKSI FAQ ACCORDION -->
<script>
    function toggleFaq(button) {
        const content = button.nextElementSibling;
        const arrowBox = button.querySelector('.arrow-box');
        const arrowSvg = button.querySelector('.arrow-svg');

        // Tutup item lain yang sedang terbuka
        const allContents = document.querySelectorAll('.faq-content');
        const allBoxes = document.querySelectorAll('.arrow-box');
        const allSvgs = document.querySelectorAll('.arrow-svg');

        allContents.forEach(item => {
            if (item !== content) {
                item.classList.add('hidden');
            }
        });

        allBoxes.forEach(box => {
            if (box !== arrowBox) {
                box.classList.remove('bg-blue-100', 'text-schoolblue');
                box.classList.add('bg-slate-100', 'text-slate-600');
            }
        });

        allSvgs.forEach(svg => {
            if (svg !== arrowSvg) {
                svg.style.transform = 'rotate(0deg)';
            }
        });

        // Toggle item yang diklik
        content.classList.toggle('hidden');
        if (!content.classList.contains('hidden')) {
            arrowBox.classList.remove('bg-slate-100', 'text-slate-600');
            arrowBox.classList.add('bg-blue-100', 'text-schoolblue');
            arrowSvg.style.transform = 'rotate(180deg)';
        } else {
            arrowBox.classList.remove('bg-blue-100', 'text-schoolblue');
            arrowBox.classList.add('bg-slate-100', 'text-slate-600');
            arrowSvg.style.transform = 'rotate(0deg)';
        }
    }
</script>



    <!-- SECTION PRE-FOOTER CTA -->
    <section class="py-12 sm:py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="rounded-3xl bg-[#3b5998] text-white p-8 sm:p-12 md:p-16 shadow-xl border border-blue-400/20 relative overflow-hidden group">
                <!-- Background Image Layer -->
                <div class="absolute inset-0 bg-cover bg-center z-0 opacity-20 group-hover:scale-105 transition duration-700" style="background-image: url('{{ asset('images/profil.png') }}');"></div>
                <!-- Blue Color Overlay Layer -->
                <div class="absolute inset-0 bg-[#3b5998]/90 z-0"></div>

                <div class="max-w-3xl mx-auto text-center space-y-5 sm:space-y-6 relative z-10">
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                        Siap Memulai Pengalaman PKL Digital?
                    </h2>
                    <p class="text-blue-100 text-xs sm:text-sm md:text-base leading-relaxed max-w-2xl mx-auto">
                        Akses platform sekarang untuk mencatat kehadiran GPS, mengisi logbook harian, dan memantau evaluasi magang secara transparan dan terintegrasi.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4 pt-2">
                        <a href="/login" class="w-full sm:w-auto bg-white hover:bg-slate-100 text-[#3b5998] px-8 py-3.5 rounded-full font-bold text-xs sm:text-sm shadow-md transition flex items-center justify-center gap-2">
                            <i data-lucide="log-in" class="w-4 h-4"></i> Masuk ke Portal
                        </a>
                        <a href="https://wa.me/6287744445006" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto bg-[#324b82] hover:bg-[#283c67] text-white border border-blue-400/40 px-8 py-3.5 rounded-full font-semibold text-xs sm:text-sm transition flex items-center justify-center gap-2">
                            <i data-lucide="message-circle" class="w-4 h-4 text-emerald-300"></i> Bantuan WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contact" class="bg-[#3b5998] text-white pt-10 pb-5 border-t border-blue-400/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <span class="text-lg font-black text-white flex items-center gap-3">
                        <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo Jurnal PKL" class="w-11 h-11 object-contain"> Jurnal PKL Digital
                    </span>
                </div>
                <p class="text-xs leading-relaxed text-blue-100">
                    Platform digital terpadu SMK Negeri 1 Depok yang dirancang untuk memodernisasi pemantauan, validasi presensi berbasis GPS, pengisian jurnal harian, dan evaluasi berkala pelaksanaan Praktik Kerja Lapangan (PKL) siswa vokasi.
                </p>
                <p class="text-xs leading-relaxed text-blue-100">
                    Menghubungkan ekosistem sekolah secara langsung dengan Dunia Usaha, Dunia Industri, dan Dunia Kerja (DUDIKA) guna mewujudkan program magang yang transparan, akuntabel, dan berstandar industri.
                </p>
            </div>
            <div class="md:flex md:justify-center">
                <div class="text-left">
                    <h4 class="text-white font-bold text-base mb-4 text-left">Tautan Cepat</h4>
                    <ul class="space-y-2.5 text-sm text-left">
                        <li><a href="#" class="text-blue-100 hover:text-white transition font-medium">Beranda</a></li>
                        <li><a href="#about" class="text-blue-100 hover:text-white transition font-medium">Tentang Kami</a></li>
                        <li><a href="#services" class="text-blue-100 hover:text-white transition font-medium">Layanan</a></li>
                        <li><a href="#features" class="text-blue-100 hover:text-white transition font-medium">Fitur</a></li>
                        <li><a href="https://www.smkn1depok.sch.id/dudika" target="_blank" rel="noopener noreferrer" class="text-blue-100 hover:text-white transition font-medium">DUDIKA</a></li>
                        <li><a href="#evaluation" class="text-blue-100 hover:text-white transition font-medium">Penilaian</a></li>
                        <li><a href="#faq" class="text-blue-100 hover:text-white transition font-medium">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <h4 class="text-white font-bold text-base mb-4">Informasi Kontak</h4>
                <ul class="space-y-3 text-sm text-blue-100 font-medium">
                    <li class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-200 flex-shrink-0 mt-1"></i>
                        <span class="leading-relaxed">Jl. Raya Tapos, Gg. Bhakti Suci No. 100, Cimpaeun, Tapos, Kota Depok, Jawa Barat 16459</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-4 h-4 text-blue-200 flex-shrink-0"></i>
                        <span>(021) 8790-7233 (Telepon / Fax)</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="message-circle" class="w-4 h-4 text-blue-200 flex-shrink-0"></i>
                        <span>0877-4444-5006 (WhatsApp Chat)</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-200 flex-shrink-0"></i>
                        <a href="mailto:smkn1depok@gmail.com" class="hover:underline text-white">smkn1depok@gmail.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="globe" class="w-4 h-4 text-blue-200 flex-shrink-0"></i>
                        <a href="https://www.smkn1depok.sch.id/" target="_blank" rel="noopener noreferrer" class="hover:underline text-white">www.smkn1depok.sch.id</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-5 border-t border-blue-400/30 text-center text-xs text-blue-100">
            <p>&copy; 2026 SMK Negeri 1 Depok - Jurnal PKL Digital. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Inisialisasi Script Interaktif -->
    <script>
        // Inisialisasi Lucide Icons
        lucide.createIcons();

        // Toggle Mobile Menu Drawer
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-icon-open');
            const closeIcon = document.getElementById('menu-icon-close');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (openIcon) openIcon.classList.add('hidden');
                if (closeIcon) closeIcon.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                if (openIcon) openIcon.classList.remove('hidden');
                if (closeIcon) closeIcon.classList.add('hidden');
            }
        }

        // Switch Role Tabs in Section Features
        function switchRoleTab(role) {
            document.querySelectorAll('.role-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
            const target = document.getElementById('role-panel-' + role);
            if (target) {
                target.classList.remove('hidden');
            }

            const activeClasses = ['bg-[#3b5998]', 'hover:bg-[#324b82]', 'text-white', 'shadow-md', 'shadow-[#3b5998]/25', 'font-bold'];
            const inactiveClasses = ['bg-white', 'text-slate-700', 'border', 'border-slate-200', 'hover:bg-slate-100', 'font-medium'];

            document.querySelectorAll('.role-tab-btn').forEach(btn => {
                btn.classList.remove(...activeClasses);
                btn.classList.add(...inactiveClasses);
            });

            const activeBtn = document.getElementById('tab-btn-' + role);
            if (activeBtn) {
                activeBtn.classList.remove(...inactiveClasses);
                activeBtn.classList.add(...activeClasses);
            }

            if (window.lucide) {
                lucide.createIcons();
            }
        }
    </script>
</body>
</html>
