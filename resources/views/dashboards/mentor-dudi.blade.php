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
        <aside id="sidebar" class="hidden md:flex flex-col w-64 bg-schoolnavy text-white transition-all duration-300 z-30">
            <!-- Brand / Logo Header -->
            <div class="h-20 flex items-center px-6 gap-3 border-b border-blue-900/50 bg-schoolnavy/50 backdrop-blur">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-schoolblue to-blue-400 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-600/40">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <div>
                    <span class="text-xs font-black tracking-wider text-white block uppercase">Jurnal PKL</span>
                    <span class="text-[10px] text-blue-300 font-medium">Digital System</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#dashboard" onclick="switchTab('dashboard')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors bg-schoolblue text-white shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-house w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#mahasiswa" onclick="switchTab('mahasiswa')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Daftar Siswa Bimbingan</span>
                </a>
                <a href="#laporan" onclick="switchTab('laporan')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-book-open w-5 text-center"></i>
                    <span>Validasi Jurnal & Laporan</span>
                    <span class="ml-auto bg-schoolred text-white text-xs px-2 py-0.5 rounded-full font-bold">5</span>
                </a>
                <a href="#nilai" onclick="switchTab('nilai')" class="nav-link flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-white/10 hover:text-white transition-colors">
                    <i class="fa-solid fa-file-invoice w-5 text-center"></i>
                    <span>Penilaian PKL</span>
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
                    <div class="w-10 h-10 rounded-full bg-schoolblue/10 text-schoolblue flex items-center justify-center font-bold border-2 border-schoolblue/20">
                        AF
                    </div>
                </div>
            </header>

            <!-- SCROLLABLE PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- TAB 1: DASHBOARD (KEMBALI SEPERTI SEMULA) -->
                <div id="tab-dashboard" class="tab-content space-y-6">
                    <div class="bg-gradient-to-r from-schoolnavy to-blue-900 rounded-2xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
                        <div class="relative z-10 space-y-2 mb-4 md:mb-0">
                            <span class="bg-schoolblue/40 text-blue-200 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider border border-blue-400/30">Portal Pembimbing Industri</span>
                            <h3 class="text-2xl md:text-3xl font-bold">Monitoring Aktivitas PKL Siswa</h3>
                            <p class="text-slate-300 text-sm max-w-xl">Kelola absensi, validasi jurnal kegiatan harian, serta berikan penilaian akhir untuk siswa bimbingan Anda dengan mudah.</p>
                        </div>
                        <div class="relative z-10 w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md border border-white/10 shadow-inner">
                            <i class="fa-solid fa-user-shield text-4xl text-blue-200"></i>
                        </div>
                        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-schoolblue/20 rounded-full blur-3xl pointer-events-none"></div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-schoolblue flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-users"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                                <h4 class="text-2xl font-bold text-slate-800">12 Siswa</h4>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-clock-rotate-left"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perlu Validasi</p>
                                <h4 class="text-2xl font-bold text-slate-800">5 Jurnal</h4>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-circle-check"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Hadir Hari Ini</p>
                                <h4 class="text-2xl font-bold text-slate-800">11 Siswa</h4>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold"><i class="fa-solid fa-award"></i></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Nilai</p>
                                <h4 class="text-2xl font-bold text-slate-800">Draft</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-schoolnavy text-lg">Aktivitas Jurnal Terbaru</h4>
                            <button onclick="switchTab('laporan')" class="text-xs font-semibold text-schoolblue hover:underline">Lihat Semua</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                               <thead>
                                    <tr class="border-b border-slate-200 text-xs font-semibold text-slate-400 uppercase">
                                        <th class="py-3 px-4">Nama Siswa</th>
                                        <th class="py-3 px-4">Tanggal</th>
                                        <th class="py-3 px-4">Kegiatan</th>
                                        <th class="py-3 px-4">Status</th>
                                        <th class="py-3 px-4 text-center">Aksi</th>
                                    </tr>
                               </thead>
                               <tbody class="divide-y divide-slate-100 text-sm">
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4 font-semibold text-slate-800">Rizky Pratama</td>
                                        <td class="py-3 px-4 text-slate-500">21 Sep 2026</td>
                                        <td class="py-3 px-4 text-slate-600">Membuat konfigurasi database PostgreSQL</td>
                                        <td class="py-3 px-4"><span class="bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span></td>
                                        <td class="py-3 px-4 text-center">
                                            <button onclick="switchTab('laporan')" class="px-3 py-1 bg-schoolblue text-white text-xs rounded-lg hover:bg-blue-700 transition">Periksa</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50">
                                        <td class="py-3 px-4 font-semibold text-slate-800">Siti Rahmawati</td>
                                        <td class="py-3 px-4 text-slate-500">21 Sep 2026</td>
                                        <td class="py-3 px-4 text-slate-600">Slice UI design Figma ke Tailwind CSS</td>
                                        <td class="py-3 px-4"><span class="bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-full font-medium">Pending</span></td>
                                        <td class="py-3 px-4 text-center">
                                            <button onclick="switchTab('laporan')" class="px-3 py-1 bg-schoolblue text-white text-xs rounded-lg hover:bg-blue-700 transition">Periksa</button>
                                        </td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SISWA BIMBINGAN (KEMBALI SEPERTI SEMULA) -->
                <div id="tab-mahasiswa" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Daftar Siswa Bimbingan PKL</h3>
                                <p class="text-xs text-slate-500">Daftar siswa yang ditempatkan di bawah bimbingan Anda.</p>
                            </div>
                            <div class="w-full sm:w-auto">
                                <input type="text" placeholder="Cari nama siswa..." class="w-full sm:w-64 px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-schoolblue">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="border border-slate-200 rounded-2xl p-5 hover:shadow-md transition bg-slate-50/50 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-12 h-12 rounded-full bg-schoolnavy text-white font-bold flex items-center justify-center">RP</div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-base">Rizky Pratama</h4>
                                            <p class="text-xs text-slate-500">SMK Negeri 1 Jakarta</p>
                                        </div>
                                    </div>
                                    <div class="space-y-1 text-xs text-slate-600 mb-4">
                                        <p><span class="font-semibold text-slate-700">Jurusan:</span> Rekayasa Perangkat Lunak</p>
                                        <p><span class="font-semibold text-slate-700">Periode:</span> Jul - Okt 2026</p>
                                    </div>
                                </div>
                                <button onclick="alert('Melihat detail siswa')" class="w-full py-2 bg-white border border-slate-300 text-schoolnavy text-xs font-semibold rounded-xl hover:bg-slate-100 transition">Lihat Detail Profil</button>
                            </div>
                            <div class="border border-slate-200 rounded-2xl p-5 hover:shadow-md transition bg-slate-50/50 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="w-12 h-12 rounded-full bg-schoolblue text-white font-bold flex items-center justify-center">SR</div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-base">Siti Rahmawati</h4>
                                            <p class="text-xs text-slate-500">SMK Negeri 1 Jakarta</p>
                                        </div>
                                    </div>
                                    <div class="space-y-1 text-xs text-slate-600 mb-4">
                                        <p><span class="font-semibold text-slate-700">Jurusan:</span> Rekayasa Perangkat Lunak</p>
                                        <p><span class="font-semibold text-slate-700">Periode:</span> Jul - Okt 2026</p>
                                    </div>
                                </div>
                                <button onclick="alert('Melihat detail siswa')" class="w-full py-2 bg-white border border-slate-300 text-schoolnavy text-xs font-semibold rounded-xl hover:bg-slate-100 transition">Lihat Detail Profil</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: VALIDASI JURNAL & LAPORAN (DENGAN FILTER TANGGAL & REKAP PDF) -->
                <div id="tab-laporan" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">

                        <!-- Header & Sub-Tab Switcher -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-200 pb-4">
                            <div>
                                <h3 class="font-bold text-schoolnavy text-lg">Validasi Jurnal & Rekap Laporan</h3>
                                <p class="text-xs text-slate-500">Periksa jurnal harian berdasarkan tanggal atau unduh rekap laporan lengkap per siswa.</p>
                            </div>
                            <div class="flex bg-slate-100 p-1 rounded-xl text-xs font-semibold">
                                <button onclick="switchSubLaporan('validasi')" id="btn-sub-val" class="px-4 py-2 rounded-lg bg-white text-schoolnavy shadow-sm transition">Validasi Harian</button>
                                <button onclick="switchSubLaporan('rekap')" id="btn-sub-rek" class="px-4 py-2 rounded-lg text-slate-500 hover:text-schoolnavy transition">Rekap Per Orang & PDF</button>
                            </div>
                        </div>

                        <!-- SUB-VIEW 1: VALIDASI HARIAN -->
                        <div id="sub-val-content" class="space-y-4">
                            <div class="flex flex-col sm:flex-row gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 items-center justify-between">
                                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                                    <div class="flex items-center space-x-2">
                                        <label class="text-xs font-semibold text-slate-600">Tanggal:</label>
                                        <input type="date" value="2026-09-21" class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <label class="text-xs font-semibold text-slate-600">Siswa:</label>
                                        <select class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs bg-white focus:outline-none focus:border-schoolblue">
                                            <option>Semua Siswa</option>
                                            <option>Rizky Pratama</option>
                                            <option>Siti Rahmawati</option>
                                        </select>
                                    </div>
                                </div>
                                <span class="bg-amber-100 text-amber-800 font-semibold text-xs px-3 py-1 rounded-full">2 Jurnal Ditampilkan</span>
                            </div>

                            <!-- Jurnal 1 -->
                            <div class="border border-slate-200 rounded-2xl p-5 hover:border-schoolblue/50 transition bg-white space-y-4 shadow-sm">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-slate-100 pb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-schoolnavy text-white text-xs font-bold flex items-center justify-center">RP</div>
                                        <div>
                                            <span class="font-bold text-slate-800 text-sm block">Rizky Pratama</span>
                                            <span class="text-xs text-slate-500">Teknik Komputer & Jaringan</span>
                                        </div>
                                    </div>
                                    <span class="text-xs bg-schoolblue/10 text-schoolblue px-3 py-1 rounded-full font-semibold">21 Sep 2026</span>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs font-semibold text-slate-400 uppercase">Kegiatan Utama:</p>
                                    <p class="text-sm font-medium text-slate-700">Membuat konfigurasi database PostgreSQL dan integrasi dengan Express.js</p>
                                    <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                        <span class="font-semibold text-slate-700">Kendala Siswa:</span> Sedikit error pada koneksi port env, sudah diselesaikan dengan bantuan mentor.
                                    </div>
                                </div>
                                <div class="space-y-1.5 pt-2 border-t border-slate-100">
                                    <label class="block text-xs font-bold text-schoolnavy uppercase"><i class="fa-solid fa-pen-nib mr-1 text-schoolblue"></i> Catatan / Umpan Balik Mentor</label>
                                    <textarea rows="2" placeholder="Tulis catatan atau arahan untuk siswa di sini..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs bg-slate-50 focus:outline-none focus:border-schoolblue"></textarea>
                                </div>
                                <div class="flex items-center justify-end space-x-2 pt-1">
                                    <button onclick="alert('Catatan tersimpan & status: DIREVISI')" class="px-4 py-2 bg-amber-500 text-white text-xs font-semibold rounded-xl hover:bg-amber-600 transition flex items-center space-x-1">
                                        <i class="fa-solid fa-pen-to-square"></i><span>Minta Revisi</span>
                                    </button>
                                    <button onclick="alert('Catatan tersimpan & status: DISETUJUI')" class="px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition flex items-center space-x-1">
                                        <i class="fa-solid fa-check"></i><span>Setujui Jurnal</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Jurnal 2 -->
                            <div class="border border-slate-200 rounded-2xl p-5 hover:border-schoolblue/50 transition bg-white space-y-4 shadow-sm">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-slate-100 pb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-schoolblue text-white text-xs font-bold flex items-center justify-center">SR</div>
                                        <div>
                                            <span class="font-bold text-slate-800 text-sm block">Siti Rahmawati</span>
                                            <span class="text-xs text-slate-500">Rekayasa Perangkat Lunak</span>
                                        </div>
                                    </div>
                                    <span class="text-xs bg-schoolblue/10 text-schoolblue px-3 py-1 rounded-full font-semibold">21 Sep 2026</span>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs font-semibold text-slate-400 uppercase">Kegiatan Utama:</p>
                                    <p class="text-sm font-medium text-slate-700">Melakukan slice layout design dari Figma ke komponen Tailwind CSS untuk halaman login.</p>
                                    <div class="text-xs text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                        <span class="font-semibold text-slate-700">Kendala Siswa:</span> Tidak ada kendala berarti.
                                    </div>
                                </div>
                                <div class="space-y-1.5 pt-2 border-t border-slate-100">
                                    <label class="block text-xs font-bold text-schoolnavy uppercase"><i class="fa-solid fa-pen-nib mr-1 text-schoolblue"></i> Catatan / Umpan Balik Mentor</label>
                                    <textarea rows="2" placeholder="Tulis catatan atau arahan untuk siswa di sini..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs bg-slate-50 focus:outline-none focus:border-schoolblue"></textarea>
                                </div>
                                <div class="flex items-center justify-end space-x-2 pt-1">
                                    <button onclick="alert('Catatan tersimpan & status: DIREVISI')" class="px-4 py-2 bg-amber-500 text-white text-xs font-semibold rounded-xl hover:bg-amber-600 transition flex items-center space-x-1">
                                        <i class="fa-solid fa-pen-to-square"></i><span>Minta Revisi</span>
                                    </button>
                                    <button onclick="alert('Catatan tersimpan & status: DISETUJUI')" class="px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-xl hover:bg-emerald-700 transition flex items-center space-x-1">
                                        <i class="fa-solid fa-check"></i><span>Setujui Jurnal</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- SUB-VIEW 2: REKAP LAPORAN PER ORANG & DOWNLOAD PDF -->
                        <div id="sub-rek-content" class="space-y-4 hidden">
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-3">
                                <div class="flex items-center space-x-3 w-full sm:w-auto">
                                    <label class="text-xs font-semibold text-slate-600">Pilih Siswa:</label>
                                    <select class="px-3 py-2 border border-slate-200 rounded-xl text-xs bg-white focus:outline-none focus:border-schoolblue">
                                        <option>Rizky Pratama (RPL)</option>
                                        <option>Siti Rahmawati (RPL)</option>
                                    </select>
                                </div>
                                <button onclick="alert('Mengunduh Laporan Rekap PDF...')" class="w-full sm:w-auto px-4 py-2 bg-schoolred text-white text-xs font-semibold rounded-xl hover:bg-red-700 transition flex items-center justify-center space-x-2 shadow-sm">
                                    <i class="fa-solid fa-file-pdf text-sm"></i>
                                    <span>Download Rekap PDF</span>
                                </button>
                            </div>

                            <div class="border border-slate-200 rounded-2xl p-5 bg-white space-y-4">
                                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-base">Rekapitulasi Jurnal: Rizky Pratama</h4>
                                        <p class="text-xs text-slate-500">Periode Magang: Juli 2026 - Oktober 2026 (Total Kehadiran: 45 Hari)</p>
                                    </div>
                                    <span class="bg-emerald-100 text-emerald-800 text-xs px-3 py-1 rounded-full font-semibold">Validasi Selesai: 95%</span>
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
                                            <tr>
                                                <td class="py-3 px-3 text-slate-600">21 Sep 2026</td>
                                                <td class="py-3 px-3 text-slate-800 font-medium">Membuat konfigurasi database PostgreSQL</td>
                                                <td class="py-3 px-3 text-slate-500">Pertahankan kerapian kodingannya.</td>
                                                <td class="py-3 px-3 text-center"><span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-semibold">Disetujui</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- TAB 4: PENILAIAN (DETAIL DAN KOMPREHENSIF) -->
                <div id="tab-nilai" class="tab-content space-y-6 hidden">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">

                        <div class="border-b border-slate-200 pb-4">
                            <h3 class="font-bold text-schoolnavy text-lg">Form & Manajemen Penilaian Akhir PKL</h3>
                            <p class="text-xs text-slate-500">Berikan penilaian objektif berdasarkan berbagai aspek kompetensi dan kedisiplinan.</p>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- Bagian Form Input Nilai -->
                            <div class="lg:col-span-2 space-y-4 bg-slate-50/50 p-5 rounded-2xl border border-slate-200">
                                <h4 class="font-bold text-schoolnavy text-sm uppercase tracking-wider"><i class="fa-solid fa-pen-to-square mr-1 text-schoolblue"></i> Input Nilai Siswa</h4>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pilih Siswa</label>
                                    <select class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue">
                                        <option>Rizky Pratama - Rekayasa Perangkat Lunak</option>
                                        <option>Siti Rahmawati - Rekayasa Perangkat Lunak</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kompetensi Teknis (0-100)</label>
                                        <input type="number" placeholder="88" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kedisiplinan & Absensi (0-100)</label>
                                        <input type="number" placeholder="90" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kerjasama Tim / Sikap (0-100)</label>
                                        <input type="number" placeholder="85" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Inisiatif & Kreativitas (0-100)</label>
                                        <input type="number" placeholder="87" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Catatan & Ulasan Perkembangan PKL</label>
                                    <textarea rows="3" placeholder="Siswa memiliki kemampuan teknis yang baik..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-schoolblue"></textarea>
                                </div>

                                <button onclick="alert('Penilaian akhir berhasil disimpan!')" class="w-full sm:w-auto px-6 py-2.5 bg-schoolblue text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition shadow-md shadow-blue-600/20">
                                    Simpan & Kunci Nilai
                                </button>
                            </div>

                            <!-- Bagian Status Nilai Siswa Lainnya -->
                            <div class="space-y-4 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                                <h4 class="font-bold text-schoolnavy text-sm uppercase tracking-wider"><i class="fa-solid fa-clipboard-list mr-1 text-schoolblue"></i> Status Nilai Siswa</h4>
                                <div class="space-y-3">
                                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 flex items-center justify-between">
                                        <div>
                                            <span class="font-semibold text-xs text-slate-800 block">Rizky Pratama</span>
                                            <span class="text-[10px] text-emerald-600 font-bold">Sudah Dinilai (87.5)</span>
                                        </div>
                                        <button onclick="alert('Edit nilai')" class="text-xs text-schoolblue hover:underline font-semibold">Edit</button>
                                    </div>
                                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 flex items-center justify-between">
                                        <div>
                                            <span class="font-semibold text-xs text-slate-800 block">Siti Rahmawati</span>
                                            <span class="text-[10px] text-amber-600 font-bold">Belum Dinilai</span>
                                        </div>
                                        <button onclick="alert('Beri nilai')" class="text-xs text-schoolblue hover:underline font-semibold">Beri Nilai</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- JavaScript Controller -->
    <script>
        function switchTab(tabId) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(el => el.classList.add('hidden'));

            const target = document.getElementById('tab-' + tabId);
            if (target) {
                target.classList.remove('hidden');
            }

            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                link.classList.add('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                if (link.getAttribute('href') === '#' + tabId) {
                    link.classList.add('bg-schoolblue', 'text-white', 'shadow-md', 'shadow-blue-600/20');
                    link.classList.remove('text-slate-300', 'hover:bg-white/10', 'hover:text-white');
                }
            });

            const titles = {
                'dashboard': 'Dashboard Pembimbing',
                'mahasiswa': 'Daftar Siswa Bimbingan',
                'laporan': 'Validasi Jurnal & Rekap Laporan',
                'nilai': 'Penilaian PKL'
            };
            document.getElementById('page-title').innerText = titles[tabId] || 'Dashboard';

            const sidebar = document.getElementById('sidebar');
            if (!sidebar.classList.contains('hidden') && window.innerWidth < 768) {
                sidebar.classList.add('hidden');
            }
        }

        function switchSubLaporan(subType) {
            const valContent = document.getElementById('sub-val-content');
            const rekContent = document.getElementById('sub-rek-content');
            const btnVal = document.getElementById('btn-sub-val');
            const btnRek = document.getElementById('btn-sub-rek');

            if (subType === 'validasi') {
                valContent.classList.remove('hidden');
                rekContent.classList.add('hidden');
                btnVal.classList.add('bg-white', 'text-schoolnavy', 'shadow-sm');
                btnVal.classList.remove('text-slate-500');
                btnRek.classList.remove('bg-white', 'text-schoolnavy', 'shadow-sm');
                btnRek.classList.add('text-slate-500');
            } else {
                valContent.classList.add('hidden');
                rekContent.classList.remove('hidden');
                btnRek.classList.add('bg-white', 'text-schoolnavy', 'shadow-sm');
                btnRek.classList.remove('text-slate-500');
                btnVal.classList.remove('bg-white', 'text-schoolnavy', 'shadow-sm');
                btnVal.classList.add('text-slate-500');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            if(!sidebar.classList.contains('hidden')) {
                sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-50');
            }
        }
    </script>
</body>
</html>
