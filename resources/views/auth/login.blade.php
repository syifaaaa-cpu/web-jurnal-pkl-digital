<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Portal - Jurnal PKL Digital</title>
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
                        schoolred: '#dc2626',
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

    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header Identik Tema Register -->
        <div class="bg-primary p-6 sm:p-8 text-white text-center relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <img src="{{ asset('images/logo-onedek.png') }}" alt="Logo SMKN 1 Depok" class="w-14 h-14 mx-auto object-contain mb-2">
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight">Selamat Datang Kembali</h1>
                <p class="text-xs sm:text-sm text-blue-200 font-medium">Sistem Informasi Monitoring PKL - SMKN 1 Depok</p>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <!-- Teks Sukses jika Pendaftaran Berhasil -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-xl text-xs sm:text-sm flex items-start gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                    <div class="font-medium leading-relaxed">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Teks Error jika Login Gagal atau Menunggu Approval -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl text-xs sm:text-sm flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"></i>
                    <div class="font-medium leading-relaxed">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <!-- Form Login -->
            <form action="/login" method="POST" class="space-y-5">
                @csrf

                {{-- Anti-Bot Honeypot Field --}}
                <div style="display:none !important; opacity:0; position:absolute; left:-9999px;" aria-hidden="true">
                    <input type="text" name="_honey_guard" tabindex="-1" autocomplete="off">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Email Terdaftar
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="nama@email.com"
                            class="w-full min-h-[44px] pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" id="input-password" required
                            placeholder="••••••••"
                            class="w-full min-h-[44px] pl-10 pr-12 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition">
                        <button type="button" onclick="togglePasswordVisibility()" aria-label="Tampilkan Kata Sandi"
                            class="absolute inset-y-0 right-0 px-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full min-h-[44px] bg-primary hover:bg-third text-white font-semibold py-3 px-4 rounded-xl shadow-sm transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-4 text-center space-y-2">
                <p class="text-xs sm:text-sm text-slate-500">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-bold text-secondary hover:underline">Daftar Sekarang</a>
                </p>
                <p class="text-xs text-slate-500">
                    <a href="/" class="hover:text-slate-700 transition inline-flex items-center min-h-[36px]">← Kembali ke Beranda Utama</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('input-password');
            const eyeIcon = document.getElementById('eye-icon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                pwdInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
