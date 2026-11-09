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
        </div>

        <!-- Quick Access Multi-Role Demo -->
        <div class="bg-blue-50/60 p-3 rounded-xl border border-blue-100 mb-6">
            <p class="text-[10px] font-bold text-schoolnavy uppercase tracking-wider text-center mb-2">Pilih Akses Cepat (Multi-Role Demo):</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="/login?role=siswa" class="text-xs font-semibold py-2 px-3 rounded-lg text-center transition {{ $role == 'siswa' ? 'bg-schoolnavy text-white shadow' : 'bg-white text-gray-700 hover:bg-gray-100 border' }}">1. Siswa</a>
                <a href="/login?role=mentor-dudi" class="text-xs font-semibold py-2 px-3 rounded-lg text-center transition {{ $role == 'mentor-dudi' ? 'bg-schoolnavy text-white shadow' : 'bg-white text-gray-700 hover:bg-gray-100 border' }}">2. Mentor Dudi</a>
                <a href="/login?role=pembimbing" class="text-xs font-semibold py-2 px-3 rounded-lg text-center transition {{ $role == 'pembimbing' ? 'bg-schoolnavy text-white shadow' : 'bg-white text-gray-700 hover:bg-gray-100 border' }}">3. Guru</a>
                <a href="/login?role=Admin" class="text-xs font-semibold py-2 px-3 rounded-lg text-center transition {{ $role == 'Admin' ? 'bg-schoolnavy text-white shadow' : 'bg-white text-gray-700 hover:bg-gray-100 border' }}">4. Admin</a>
            </div>
        </div>

        <!-- Form Login -->
        <form action="/dashboard/{{ $role }}" method="GET">
            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Select Role Active</label>
                <input type="text" value="{{ ucfirst($role) }}" disabled class="w-full px-3 py-2.5 bg-gray-50 border rounded-xl text-sm text-gray-700 font-bold capitalize">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">NIS / NISN / Email / Username</label>
                <input type="text" placeholder="Masukkan ID / Email..." class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Password</label>
                <input type="password" placeholder="••••••••" class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
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
