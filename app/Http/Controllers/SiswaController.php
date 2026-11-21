<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Logbook;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Controller SiswaController mengelola portal mandiri siswa magang:
 * menampilkan statistik logbook & absensi GPS, pembaharuan nomor telepon kontak,
 * dan penggantian kata sandi berstandar keamanan tinggi.
 */
class SiswaController extends Controller
{
    /**
     * Menampilkan halaman Dashboard Siswa Magang.
     * Mengagregasi data logbook harian, riwayat absensi geofencing, dan nilai akhir PKL.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $today = Carbon::today(config('app.timezone', 'Asia/Jakarta'))->toDateString();

        // --- LANGKAH 1: Ambil Seluruh Riwayat Logbook Siswa yang Login ---
        $logbooks = Logbook::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil Logbook Hari Ini untuk Kartu "Aktivitas Terbaru Hari Ini" di Dashboard
        $latestLogbook = Logbook::where('user_id', $user->id)
            ->where(function ($query) use ($today) {
                $query->whereDate('tanggal', $today)
                    ->orWhereDate('created_at', $today);
            })
            ->latest('id')
            ->first();

        // --- LANGKAH 2: Ambil Seluruh Riwayat Presensi GPS Siswa yang Login ---
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        // --- LANGKAH 3: Ambil Rekapitulasi Nilai Akhir & Predikat Kelulusan ---
        $grade = Grade::where('student_id', $user->id)->first();

        return view('dashboards.siswa', compact(
            'user',
            'logbooks',
            'latestLogbook',
            'attendances',
            'grade'
        ));
    }

    /**
     * Memperbarui Data Kontak Pribadi Siswa.
     *
     * Catatan Keamanan Arsitektur:
     * Siswa hanya diizinkan memperbarui nomor WhatsApp/telepon mandiri.
     * Atribut kritis seperti penempatan DUDI dan koordinat GPS (dudi_lat, dudi_lng)
     * dikunci dan hanya dapat diubah oleh Admin Pokja Hubin untuk mencegah manipulasi geofence.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'phone' => 'nullable|string|max:25',
        ]);

        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
            $user->save();
        }

        return back()->with('success', 'Data profil pribadi siswa berhasil diperbarui!');
    }

    /**
     * Memperbarui Kata Sandi / Password Akun Siswa.
     * Memeriksa verifikasi hash sandi lama dan menerapkan aturan kompleksitas sandi baru.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Validasi Kata Sandi Baru dengan Standar Kompleksitas Tinggi ---
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $user = Auth::user();

        // --- LANGKAH 2: Verifikasi Kesesuaian Kata Sandi Saat Ini (Bcrypt Check) ---
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok!']);
        }

        // --- LANGKAH 3: Simpan Kata Sandi Baru yang Telah Dihash ---
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi akun berhasil diperbarui!');
    }
}
