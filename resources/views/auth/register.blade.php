<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - Jurnal PKL Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
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
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen py-8 px-4 flex items-center justify-center">

    <div class="max-w-xl w-full bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-primary p-6 sm:p-8 text-white text-center relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-14 h-14 mx-auto object-contain mb-2">
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight">Pendaftaran Akun Baru</h1>
                <p class="text-xs sm:text-sm text-blue-200 font-medium">Sistem Informasi Monitoring PKL - SMKN 1 Depok</p>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Teks Error Validasi -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl text-xs sm:text-sm space-y-1">
                    <div class="font-bold flex items-center gap-1.5 mb-1">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i> Terjadi kesalahan pendaftaran:
                    </div>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tab Pilihan Role -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Pilih Peran Pendaftaran</label>
                <div class="grid grid-cols-3 gap-1.5 p-1.5 bg-slate-100 rounded-xl text-xs sm:text-sm font-semibold">
                    <button type="button" onclick="selectRole('siswa')" id="btn-role-siswa"
                        class="role-btn min-h-[44px] py-2 px-2 sm:px-3 rounded-lg transition text-center bg-white text-primary shadow-sm">
                        <i data-lucide="graduation-cap" class="w-4 h-4 mx-auto mb-1"></i>
                        Siswa
                    </button>
                    <button type="button" onclick="selectRole('pembimbing')" id="btn-role-pembimbing"
                        class="role-btn min-h-[44px] py-2 px-2 sm:px-3 rounded-lg transition text-center text-slate-600 hover:text-primary">
                        <i data-lucide="award" class="w-4 h-4 mx-auto mb-1"></i>
                        Guru Pembimbing
                    </button>
                    <button type="button" onclick="selectRole('mentor')" id="btn-role-mentor"
                        class="role-btn min-h-[44px] py-2 px-2 sm:px-3 rounded-lg transition text-center text-slate-600 hover:text-primary">
                        <i data-lucide="briefcase" class="w-4 h-4 mx-auto mb-1"></i>
                        Mentor DUDI
                    </button>
                </div>
            </div>

            <!-- Form Registrasi -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Anti-Bot Honeypot Field --}}
                <div style="display:none !important; opacity:0; position:absolute; left:-9999px;" aria-hidden="true">
                    <input type="text" name="_honey_guard" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" name="role" id="input-role" value="{{ old('role', 'siswa') }}">

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5" id="label-name">Nama Lengkap Siswa</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                        placeholder="Masukkan nama lengkap...">
                </div>

                <!-- Input Khusus Siswa: NIS, NISN & Jurusan -->
                <div id="field-siswa" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Siswa (NIS)</label>
                            <input type="text" name="nis" value="{{ old('nis') }}"
                                class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                                placeholder="Contoh: 212210045">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Siswa Nasional (NISN)</label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" maxlength="10"
                                class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                                placeholder="10 Digit, contoh: 0081234567">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kompetensi Keahlian (Jurusan)</label>
                        <select name="departemen" class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-secondary">
                            <option value="">-- Pilih Jurusan Resmi SMKN 1 Depok --</option>
                            <option value="PPLG" {{ old('departemen') == 'PPLG' ? 'selected' : '' }}>PPLG — Pengembangan Perangkat Lunak dan Gim</option>
                            <option value="AKL" {{ old('departemen') == 'AKL' ? 'selected' : '' }}>AKL — Akuntansi dan Keuangan Lembaga</option>
                            <option value="TKR" {{ old('departemen') == 'TKR' ? 'selected' : '' }}>TKR — Teknik Kendaraan Ringan</option>
                            <option value="TBSM" {{ old('departemen') == 'TBSM' ? 'selected' : '' }}>TBSM — Teknik dan Bisnis Sepeda Motor</option>
                            <option value="PH" {{ old('departemen') == 'PH' ? 'selected' : '' }}>PH — Perhotelan</option>
                            <option value="DKV" {{ old('departemen') == 'DKV' ? 'selected' : '' }}>DKV — Desain Komunikasi Visual</option>
                        </select>
                    </div>
                </div>

                <!-- Input Khusus Guru Pembimbing: NIP -->
                <div id="field-pembimbing" class="hidden space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">NIP / NUPTK (Opsional)</label>
                        <input type="text" name="nip" value="{{ old('nip') }}"
                            class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                            placeholder="Contoh: 19800512 200501 1 003">
                    </div>
                </div>

                <!-- Input Khusus Mentor: Tempat DUDI -->
                <div id="field-mentor" class="hidden space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Perusahaan / Instansi DUDI</label>
                        <input type="text" name="tempat_dudi" value="{{ old('tempat_dudi') }}"
                            class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                            placeholder="Contoh: PT Ciptadra Softindo / Dinas Kominfo">
                    </div>
                </div>

                <!-- Email & Nomor Telepon -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email Aktif</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                            placeholder="nama@email.com">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                            placeholder="0812xxxxxxxx">
                    </div>
                </div>

                <!-- Password & Konfirmasi Password -->
                <div class="space-y-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                            <input type="password" name="password" required
                                class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                                placeholder="Minimal 8 karakter">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full min-h-[44px] px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary"
                                placeholder="Ulangi kata sandi">
                        </div>
                    </div>
                    <div class="p-3.5 bg-blue-50 rounded-xl text-xs text-blue-900 flex items-start gap-2.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-secondary flex-shrink-0 mt-0.5"></i>
                        <span><strong>Standar Keamanan Kata Sandi:</strong> Wajib minimal 8 karakter dengan kombinasi huruf besar (A-Z), huruf kecil (a-z), angka (0-9), dan simbol (@$!%*#?&).</span>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit"
                        class="w-full min-h-[44px] bg-primary hover:bg-third text-white font-semibold py-3 px-4 rounded-xl shadow-sm transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Ajukan Pendaftaran Akun
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-4 text-center space-y-2">
                <p class="text-xs sm:text-sm text-slate-500">
                    Sudah memiliki akun terdaftar?
                    <a href="{{ route('login') }}" class="font-bold text-secondary hover:underline">Masuk ke Sini</a>
                </p>
                <p class="text-xs text-slate-500">
                    <a href="/" class="hover:text-slate-700 transition inline-flex items-center min-h-[36px]">← Kembali ke Beranda Utama</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function selectRole(role) {
            document.getElementById('input-role').value = role;

            // Update tab button styles
            const roles = ['siswa', 'pembimbing', 'mentor'];
            roles.forEach(r => {
                const btn = document.getElementById('btn-role-' + r);
                if (r === role) {
                    btn.className = "role-btn min-h-[44px] py-2 px-2 sm:px-3 rounded-lg transition text-center bg-white text-primary shadow-sm";
                } else {
                    btn.className = "role-btn min-h-[44px] py-2 px-2 sm:px-3 rounded-lg transition text-center text-slate-600 hover:text-primary";
                }
            });

            // Toggle role specific fields
            document.getElementById('field-siswa').classList.add('hidden');
            document.getElementById('field-pembimbing').classList.add('hidden');
            document.getElementById('field-mentor').classList.add('hidden');

            const labelName = document.getElementById('label-name');

            if (role === 'siswa') {
                document.getElementById('field-siswa').classList.remove('hidden');
                labelName.innerText = "Nama Lengkap Siswa";
            } else if (role === 'pembimbing') {
                document.getElementById('field-pembimbing').classList.remove('hidden');
                labelName.innerText = "Nama Lengkap Guru Pembimbing & Gelar";
            } else if (role === 'mentor') {
                document.getElementById('field-mentor').classList.remove('hidden');
                labelName.innerText = "Nama Pembimbing Lapangan / PIC DUDI";
            }

            lucide.createIcons();
        }

        // Jalankan initial check sesuai old input jika ada
        window.addEventListener('DOMContentLoaded', () => {
            const currentRole = document.getElementById('input-role').value || 'siswa';
            selectRole(currentRole);
        });
    </script>
</body>
</html>
