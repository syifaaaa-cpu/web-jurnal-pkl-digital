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
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#3b5998] backdrop-blur-md border-b border-blue-400/30 shadow-lg transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-base font-extrabold tracking-tight text-white flex items-center gap-2.5">
                    <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo Jurnal PKL" class="w-10 h-10 object-contain"> JurnalPKL
                </span>
            </div>

            <div class="hidden md:flex space-x-8 text-xs font-medium text-blue-100">
                <a href="#" class="text-white font-semibold transition">Home</a>
                <a href="#about" class="hover:text-white transition">About Us</a>
                <a href="#services" class="hover:text-white transition">Services</a>
                <a href="#features" class="hover:text-white transition">Features</a>
                <a href="#partners" class="hover:text-white transition">Mitra DUDI</a>
                <a href="#evaluation" class="hover:text-white transition">Evaluation</a>
                <a href="#faq" class="hover:text-white transition">FAQ</a>
            </div>

            <div>
                <a href="/login" class="bg-white text-[#3b5998] px-5 py-2.5 rounded-full text-xs font-bold hover:bg-blue-50 transition shadow-md">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative overflow-hidden text-white pt-44 pb-36">
        <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('{{ asset('images/smkn 1 depok.jpg') }}');"></div>
        <div class="absolute inset-0 bg-slate-900/60 z-0"></div>
        <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-blue-400/20 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute -bottom-40 -right-40 w-[500px] h-[500px] bg-blue-400/15 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-6">
            <span class="inline-block text-[11px] font-bold text-blue-200 uppercase tracking-wider bg-white/10 px-4 py-1.5 rounded-full border border-white/20 backdrop-blur-md">
                Platform Resmi Pemantauan Vokasi
            </span>
            <h1 class="text-4xl sm:text-6xl font-black text-white leading-[1.12] tracking-tight drop-shadow-md">
                Transformasi Digital Monitoring PKL <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 via-sky-100 to-white">Tanpa Batas</span>
            </h1>
            <p class="text-blue-100 text-xs sm:text-sm leading-relaxed max-w-2xl mx-auto drop-shadow">
                Permudah pencatatan absensi harian, jurnal kegiatan magang, hingga rekapitulasi nilai akhir secara real-time dan terintegrasi antara sekolah dan industri.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <a href="/login" class="bg-[#3b5998] text-white px-7 py-3.5 rounded-full font-bold text-xs hover:bg-[#324b82] transition shadow-xl shadow-[#3b5998]/30 flex items-center gap-2 border border-blue-400/30">
                    Let's Get Started <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
            <div class="pt-6 flex items-center justify-center gap-4">
                <div class="flex items-center gap-1 text-yellow-400">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
                <div class="text-xs text-blue-100 font-medium drop-shadow">
                    <strong class="text-white">4.5 / 5.0</strong> (Ulasan Positif dari Siswa & Pembimbing)
                </div>
            </div>
        </div>
    </header>

    <!-- SECTION SERVICES -->
    <section id="services" class="relative z-20 max-w-7xl mx-auto px-6 -mt-20 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <div class="lg:col-span-4 bg-[#3b5998]/90 backdrop-blur-md text-white rounded-3xl p-6 relative overflow-hidden group shadow-xl flex flex-col justify-between border border-blue-300/30">
                <div class="absolute inset-0 bg-cover bg-center z-0 opacity-30 group-hover:scale-105 transition duration-500" style="background-image: url('{{ asset('images/profil.png') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#3b5998]/95 via-[#3b5998]/50 to-transparent z-0"></div>
                <div class="relative z-10 h-28"></div>
                <div class="relative z-10 space-y-2 mt-auto">
                    <h3 class="text-lg font-bold">How Does It Work?</h3>
                    <p class="text-[11px] text-blue-100 leading-relaxed">Siswa mencatat absensi & laporan harian langsung dari perangkat seluler secara real-time.</p>
                    <div class="pt-1">
                        <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-white hover:underline">Learn More <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white/90 backdrop-blur-md text-gray-900 p-6 rounded-3xl border border-blue-100 shadow-xl hover:shadow-2xl transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition">
                            <i data-lucide="map-pin" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base mb-2">Absensi GPS</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Validasi kehadiran magang berbasis koordinat lokasi industri yang akurat.</p>
                    </div>
                </div>

                <div class="bg-white/90 backdrop-blur-md text-gray-900 p-6 rounded-3xl border border-blue-100 shadow-xl hover:shadow-2xl transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#3b5998] flex items-center justify-center mb-4 border border-blue-100 group-hover:bg-[#3b5998] group-hover:text-white transition">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-base mb-2">Jurnal Harian</h4>
                        <p class="text-xs text-gray-600 leading-relaxed">Pencatatan kegiatan harian yang langsung dicek oleh guru pembimbing.</p>
                    </div>
                </div>

                <div class="bg-white/90 backdrop-blur-md text-gray-900 p-6 rounded-3xl border border-blue-100 shadow-xl hover:shadow-2xl transition flex flex-col justify-between group">
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
    <section id="about" class="py-20 bg-gradient-to-b from-blue-50/70 via-sky-50/30 to-white text-gray-800 border-t border-blue-100">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 grid grid-cols-2 gap-4">
                <div class="space-y-4">
                   <img src="{{ asset('images/smkn 1 depok.jpg') }}" alt="Deskripsi Gambar" class="rounded-2xl shadow-md object-cover w-full h-[180px]">
                    <div class="bg-white backdrop-blur-sm p-6 rounded-3xl border border-blue-100 shadow-sm">
                        <div class="text-[#3b5998] mb-2"><i data-lucide="target" class="w-6 h-6"></i></div>
                        <h5 class="font-bold text-sm text-gray-900 mb-1">Company Vission</h5>
                        <p class="text-[11px] text-gray-600">Mewujudkan ekosistem digitalisasi SMK vokasi yang transparan dan efisien.</p>
                    </div>
                </div>
                <div class="space-y-4 pt-8">
                    <div class="bg-white backdrop-blur-sm p-6 rounded-3xl border border-blue-100 shadow-sm">
                        <div class="text-[#3b5998] mb-2"><i data-lucide="award" class="w-6 h-6"></i></div>
                        <h5 class="font-bold text-sm text-gray-900 mb-1">Company Mission</h5>
                        <p class="text-[11px] text-gray-600">Menghubungkan sekolah dengan dunia industri secara real-time.</p>
                    </div>
                    <img src="{{ asset('images/smkn-1-depok-2.jpg') }}" alt="Deskripsi Gambar" class="rounded-2xl shadow-md object-cover w-full h-[180px]">
                </div>
            </div>

            <div class="lg:col-span-6 space-y-6">
                <span class="inline-block text-[11px] font-bold text-[#3b5998] uppercase tracking-wider bg-blue-100 px-4 py-1.5 rounded-full border border-blue-200">
                    About Us
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight leading-snug">
                    Solusi Terpadu Manajemen PKL Sekolah & Industri
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Platform Jurnal PKL Digital dirancang khusus untuk memangkas birokrasi manual, mengurangi penggunaan kertas, serta mempercepat proses evaluasi magang siswa secara menyeluruh.
                </p>
                <div class="bg-white backdrop-blur-sm p-5 rounded-2xl border border-blue-100 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#3b5998] text-white flex items-center justify-center font-bold">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800">Mendukung efisiensi pemantauan siswa magang di era digital.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FITUR UNGGULAN (DENGAN GAMBAR GAYA PINTEREST) -->
    <section id="features" class="py-24 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="inline-block text-[11px] font-bold text-[#3b5998] uppercase tracking-wider bg-blue-100 px-4 py-1.5 rounded-full border border-blue-200">
                    Fitur Unggulan
                </span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900">
                    Dirancang untuk Kemudahan Semua Pengguna
                </h2>
                <p class="text-xs sm:text-sm text-gray-600">
                    Fitur lengkap yang memfasilitasi siswa, guru pembimbing, dan mentor industri dalam satu sistem terintegrasi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-slate-50/80 p-6 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl transition-all space-y-4 flex flex-col justify-between">
                    <div class="w-full h-48 bg-blue-100/50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-200">
                        <img src="{{ asset('images/multi-device.jpg') }}" alt="Akses Multi-Device" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-bold text-base text-gray-900">Akses Multi-Device</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">Dapat diakses dengan mudah melalui <em>smartphone</em> maupun komputer, kapan saja dan di mana saja.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-50/80 p-6 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl transition-all space-y-4 flex flex-col justify-between">
                    <div class="w-full h-48 bg-blue-100/50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-200">
                        <img src="{{ asset('images/keamanan.jpg') }}" alt="Validasi & Keamanan" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-bold text-base text-gray-900">Validasi & Keamanan</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">Sistem penguncian lokasi berbasis GPS dan persetujuan digital untuk menghindari kecurangan absensi.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50/80 p-6 rounded-3xl border border-slate-200 hover:border-[#3b5998] hover:shadow-xl transition-all space-y-4 flex flex-col justify-between">
                    <div class="w-full h-48 bg-blue-100/50 rounded-2xl overflow-hidden flex items-center justify-center border border-slate-200">
                        <img src="{{ asset('images/laporan.jpg') }}" alt="Ekspor Laporan Otomatis" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-bold text-base text-gray-900">Ekspor Laporan Otomatis</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">Cetak laporan kegiatan harian dan rekap nilai akhir magang langsung ke format PDF atau Excel dengan rapi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION EVALUATION (STATISTIK) -->
    <section id="evaluation" class="py-24 bg-white text-gray-900 border-t border-slate-200 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="inline-block text-[11px] font-bold text-[#3b5998] uppercase tracking-wider bg-blue-100 px-4 py-1.5 rounded-full border border-blue-200">
                    Statistik & Aktivitas PKL
                </span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900">
                    Monitoring Aktivitas Magang Siswa Aktif
                </h2>
                <p class="text-xs sm:text-sm text-gray-600">
                    Rekapitulasi data harian pelaksanaan Praktik Kerja Lapangan secara real-time.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-[#3b5998] tracking-tight">450+</div>
                    <p class="text-xs text-gray-600 font-medium">Siswa Sedang Magang</p>
                </div>

                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="briefcase" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-[#3b5998] tracking-tight">85+</div>
                    <p class="text-xs text-gray-600 font-medium">Dudi / Industri Mitra</p>
                </div>

                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="book-open" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-[#3b5998] tracking-tight">12.5K</div>
                    <p class="text-xs text-gray-600 font-medium">Jurnal Harian Masuk</p>
                </div>

                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:border-[#3b5998] transition-all duration-300 text-center space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-100 text-[#3b5998] flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6"></i>
                    </div>
                    <div class="text-3xl sm:text-4xl font-black text-[#3b5998] tracking-tight">99%</div>
                    <p class="text-xs text-gray-600 font-medium">Kehadiran Valid GPS</p>
                </div>
            </div>
        </div>
    </section>
    <!-- SECTION FAQ (LAYOUT DUA KOLOM DENGAN IKON PANAH SVG) -->
<section id="faq" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

            <!-- KOLOM KIRI: JUDUL & DESKRIPSI -->
            <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-8">
                <span class="inline-block bg-blue-50 text-schoolblue text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-blue-100">BANTUAN & INFORMASI</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                <p class="text-slate-500 text-sm leading-relaxed">Temukan jawaban lengkap dan cepat atas pertanyaan umum seputar sistem monitoring, absensi, logbook, hingga pengelolaan PKL digital.</p>
                <div class="pt-4 hidden lg:block">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-xs text-slate-500 space-y-1">
                        <p class="font-bold text-slate-700">Butuh bantuan lebih lanjut?</p>
                        <p>Hubungi tim admin sekolah atau operator portal Jurnal PKL Digital.</p>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: DAFTAR PERTANYAAN (DROPDOWN / ACCORDION) -->
            <div class="lg:col-span-7 space-y-4">
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



    <!-- FOOTER -->
    <footer id="contact" class="bg-[#3b5998] text-white py-16 border-t border-blue-400/30">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <span class="text-base font-extrabold text-white flex items-center gap-2.5">
                        <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo Jurnal PKL" class="w-10 h-10 object-contain"> Jurnal PKL Digital
                    </span>
                </div>
                <p class="text-xs leading-relaxed text-blue-100">Platform digital terpadu untuk efisiensi dan transparansi pemantauan Praktik Kerja Lapangan siswa SMK.</p>
            </div>
            <div>
                <h4 class="text-white font-bold text-sm mb-4">Quick Links</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white transition">Home</a></li>
                    <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#services" class="hover:text-white transition">Services</a></li>
                    <li><a href="#features" class="hover:text-white transition">Features</a></li>
                    <li><a href="#partners" class="hover:text-white transition">Mitra DUDI</a></li>
                    <li><a href="#evaluation" class="hover:text-white transition">Evaluation</a></li>
                    <li><a href="#testimonials" class="hover:text-white transition">Testimonials</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold text-sm mb-4">Contact Us</h4>
                <ul class="space-y-3 text-xs">
                    <li class="flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 text-blue-200"></i> support@jurnalpkl.digital</li>
                    <li class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 text-blue-200"></i> +62 812-3456-7890</li>
                    <li class="flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4 text-blue-200"></i> Jl. Pendidikan Vokasi No. 10, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-blue-400/30 text-center text-xs text-blue-100">
            <p>&copy; 2026 Jurnal PKL Digital. All rights reserved.</p>
        </div>
    </footer>

    <!-- Inisialisasi Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
