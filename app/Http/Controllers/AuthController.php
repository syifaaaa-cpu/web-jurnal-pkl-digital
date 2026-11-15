<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Controller AuthController mengatur alur autentikasi, registrasi mandiri,
 * gerbang persetujuan admin (approval gate), proteksi anti-bot honeypot,
 * dan perutean dinamis berbasis peran (RBAC).
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman formulir login.
     * Jika pengguna sudah terautentikasi, otomatis dialihkan ke dashboard perannya.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Memproses otentikasi login pengguna.
     *
     * Alur Keamanan & Logika Bisnis:
     * 1. Deteksi jebakan anti-bot Honeypot.
     * 2. Validasi format email dan kata sandi.
     * 3. Percobaan autentikasi via Auth::attempt().
     * 4. Pemeriksaan status persetujuan (Gerbang Approval):
     *    - 'pending'  -> Ditolak sementara (menunggu verifikasi Admin).
     *    - 'rejected' -> Ditolak permanen.
     *    - 'approved' -> Lolos verifikasi.
     * 5. Regenerasi session ID untuk mencegah serangan Session Fixation.
     * 6. Pengalihan cerdas ke dashboard sesuai role pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Pemeriksaan Jebakan Honeypot Anti-Bot ---
        // Jika field tersembunyi _honey_guard terisi, penyerang teridentifikasi sebagai bot web scanner
        if ($request->filled('_honey_guard')) {
            return back()->withErrors([
                'email' => 'Permintaan Anda terdeteksi sebagai aktivitas otomatis yang mencurigakan.',
            ]);
        }

        // --- LANGKAH 2: Validasi Format Masukan Kredensial ---
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // --- LANGKAH 3: Autentikasi Pengguna Menggunakan Hash Bcrypt ---
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // --- LANGKAH 4: Gerbang Pemeriksaan Status Persetujuan Akun (Approval Gate) ---
            if ($user->status === 'pending') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Pendaftaran akun Anda berhasil, namun saat ini masih MENUNGGU PERSETUJUAN dari Admin Pokja Hubin. Silakan hubungi admin sekolah.',
                ])->onlyInput('email');
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Pendaftaran akun Anda DITOLAK oleh Admin. Silakan hubungi admin sekolah.',
                ])->onlyInput('email');
            }

            // --- LANGKAH 5: Pertahanan Session Fixation ---
            $request->session()->regenerate();

            // --- LANGKAH 6: Pengalihan Dashboard Berbasis Peran ---
            return $this->redirectBasedOnRole($user);
        }

        // Jika kredensial salah, berikan pesan generik untuk mencegah serangan enumerasi akun
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan formulir registrasi mandiri.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Memproses pendaftaran akun mandiri untuk Siswa, Guru Pembimbing, dan Mentor DUDI.
     *
     * Alur Validasi & Logika Bisnis:
     * 1. Deteksi jebakan anti-bot Honeypot.
     * 2. Validasi standar umum: nama, email unik, kekuatan sandi, dan nomor telepon.
     * 3. Validasi khusus per peran:
     *    - Siswa: Wajib NIS unik, NISN unik 10 digit, dan 6 jurusan resmi SMKN 1 Depok.
     *    - Mentor: Wajib nama tempat DUDI dan nomor telepon aktif.
     *    - Pembimbing: NIP opsional.
     * 4. Pembuatan record User dengan status awal 'pending'.
     */
    public function register(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Jebakan Honeypot Anti-Bot ---
        if ($request->filled('_honey_guard')) {
            return back()->withErrors([
                'email' => 'Permintaan pendaftaran ditolak oleh sistem keamanan anti-bot.',
            ]);
        }

        $role = $request->input('role');

        // --- LANGKAH 2: Aturan Validasi Utama & Kompleksitas Password ---
        $rules = [
            'role' => 'required|in:siswa,pembimbing,mentor',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'phone' => 'nullable|string|max:25',
        ];

        // --- LANGKAH 3: Validasi Spesifik Kolom Sesuai Peran Pendaftar ---
        if ($role === 'siswa') {
            // Siswa wajib mencantumkan identitas akademik lengkap
            $rules['nis'] = 'required|string|max:50|unique:users,nis';
            $rules['nisn'] = 'required|string|size:10|unique:users,nisn';
            $rules['departemen'] = 'required|in:PPLG,AKL,TKR,TBSM,PH,DKV';
        } elseif ($role === 'pembimbing') {
            $rules['nip'] = 'nullable|string|max:50';
        } elseif ($role === 'mentor') {
            $rules['tempat_dudi'] = 'required|string|max:255';
            $rules['phone'] = 'required|string|max:25';
        }

        $validated = $request->validate($rules);

        // --- LANGKAH 4: Simpan Data Pengguna Baru dengan Status Menunggu Persetujuan ---
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'status' => 'pending', // Wajib persetujuan Admin Pokja Hubin
            'nis' => $request->input('nis'),
            'nisn' => $request->input('nisn'),
            'departemen' => $request->input('departemen'),
            'nip' => $request->input('nip'),
            'phone' => $request->input('phone'),
            'tempat_dudi' => $request->input('tempat_dudi'),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda telah tersimpan dan sedang menunggu persetujuan (approval) dari Admin Pokja Hubin sebelum dapat digunakan.');
    }

    /**
     * Memproses keluar dari sistem (Logout) dan membersihkan seluruh sesi.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Pengalihan rute dashboard internal berdasarkan peran (Role-Based Routing).
     */
    private function redirectBasedOnRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'siswa' => redirect()->intended('/dashboard/siswa'),
            'mentor' => redirect()->intended('/dashboard/mentor-dudi'),
            'pembimbing' => redirect()->intended('/dashboard/pembimbing'),
            'admin' => redirect()->intended('/dashboard/admin'),
            default => redirect()->intended('/dashboard/siswa'),
        };
    }
}
