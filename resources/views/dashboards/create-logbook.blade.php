<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entri Logbook Baru - Jurnal PKL Digital</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                        schoolred: '#dc2626'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased min-h-screen py-8 px-4">
    <div class="max-w-2xl mx-auto bg-white p-5 sm:p-8 rounded-2xl shadow-sm space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-bold text-primary">Tambah Entri Logbook</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Catat aktivitas harian PKL Anda dengan detail.</p>
            </div>
            <a href="/dashboard/siswa" class="text-xs sm:text-sm font-semibold text-secondary hover:underline inline-flex items-center min-h-[36px]">← Kembali ke Dashboard</a>
        </div>

        <!-- Form Input Logbook -->
        <form action="/dashboard/siswa/logbook" method="POST" class="space-y-4">
            @csrf

            <!-- Tanggal Kegiatan -->
            <div>
                <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wide mb-1.5">Tanggal Kegiatan</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary">
            </div>

            <!-- Jam Kerja -->
            <div>
                <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wide mb-1.5">Durasi Jam Kerja</label>
                <input type="text" name="jam_kerja" value="08:00 - 16:00 WIB (8 Jam)" required
                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary">
            </div>

            <!-- Judul Kegiatan -->
            <div>
                <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wide mb-1.5">Judul / Topik Pekerjaan</label>
                <input type="text" name="judul_kegiatan" placeholder="Contoh: Konfigurasi Switch & Router Mikrotik" required
                    class="w-full min-h-[44px] px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary">
            </div>

            <!-- Deskripsi Detail -->
            <div>
                <label class="block text-slate-700 text-xs font-semibold uppercase tracking-wide mb-1.5">Deskripsi Detail Kegiatan</label>
                <textarea name="deskripsi" rows="5" placeholder="Jelaskan secara ringkas tugas atau pekerjaan yang Anda lakukan hari ini..." required
                    class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:border-secondary"></textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-2">
                <a href="/dashboard/siswa" class="min-h-[44px] px-5 py-2.5 rounded-xl bg-slate-100 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition flex items-center justify-center">Batal</a>
                <button type="submit" class="min-h-[44px] bg-primary text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-third transition shadow-sm cursor-pointer">
                    Simpan &amp; Kirim Laporan
                </button>
            </div>
        </form>

    </div>
</body>
</html>
