<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entri Logbook Baru - Jurnal PKL Digital</title>
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
<body class="bg-gray-50 min-h-screen py-10 px-4">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-100">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Tambah Entri Logbook</h1>
                <p class="text-xs text-gray-500 mt-0.5">Catat aktivitas harian PKL Anda dengan detail.</p>
            </div>
            <a href="/dashboard/siswa" class="text-xs font-semibold text-schoolblue hover:underline">← Kembali ke Dashboard</a>
        </div>

        <!-- Form Input Logbook -->
        <form action="/dashboard/siswa/logbook" method="POST">
            @csrf

            <!-- Tanggal Kegiatan -->
            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Tanggal Kegiatan</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
            </div>

            <!-- Jam Kerja -->
            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Durasi Jam Kerja</label>
                <input type="text" name="jam_kerja" value="08:00 - 16:00 WIB (8 Jam)" required class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
            </div>

            <!-- Judul Kegiatan -->
            <div class="mb-4">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Judul / Topik Pekerjaan</label>
                <input type="text" name="judul_kegiatan" placeholder="Contoh: Konfigurasi Switch & Router Mikrotik" required class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue">
            </div>

            <!-- Deskripsi Detail -->
            <div class="mb-6">
                <label class="block text-gray-700 text-xs font-bold uppercase mb-2">Deskripsi Detail Kegiatan</label>
                <textarea name="deskripsi" rows="5" placeholder="Jelaskan secara ringkas tugas atau pekerjaan yang Anda lakukan hari ini..." required class="w-full px-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-schoolblue"></textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3">
                <a href="/dashboard/siswa" class="px-5 py-2.5 rounded-xl border text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</a>
                <button type="submit" class="bg-schoolnavy text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-900 transition shadow-md">
                    Simpan & Kirim Laporan
                </button>
            </div>
        </form>

    </div>
</body>
</html>
