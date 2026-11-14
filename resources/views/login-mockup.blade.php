<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jurnal PKL Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        schoolnavy: '#3c5897',
                        schoolblue: '#2563eb',
                        schoolred: '#dc2626'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full border border-gray-100">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-xl font-extrabold text-schoolblue">Jurnal PKL Digital</h1>
            <p class="text-xs text-gray-400 mt-1">Vocational Excellence Portal</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Welcome Back</h2>
            <p class="text-xs text-gray-500 mt-1">Silakan masuk menggunakan akun terdaftar</p>
        </div>

        <!-- Teks Error jika Email/Password Salah -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-xl text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form Login Bersih tanpa Tombol Role -->
        <form action="/login" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Email / Username</label>
                <input type="email" name="email" placeholder="Masukkan email terdaftar..." required class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Password</label>
                <input type="password" name="password" placeholder="••••••••" required class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
            </div>

            <button type="submit" class="w-full bg-schoolnavy text-white py-3 rounded-xl font-bold text-sm hover:bg-blue-900 transition shadow-lg">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-xs text-schoolblue hover:underline font-medium">← Kembali ke Beranda Utama</a>
        </div>
    </div>
</body>
</html>
