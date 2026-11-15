<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User mewakili entitas pengguna sistem (Admin, Guru Pembimbing, Mentor DUDI, Siswa Magang).
 *
 * @property int $id Primary Key (Auto-Increment)
 * @property string $name Nama lengkap pengguna
 * @property string $email Alamat surel unik untuk autentikasi login
 * @property string|null $nis Nomor Induk Siswa (Khusus Siswa)
 * @property string|null $nisn Nomor Induk Siswa Nasional 10 digit unik (Khusus Siswa)
 * @property string|null $departemen Jurusan keahlian: PPLG, AKL, TKR, TBSM, PH, DKV (Khusus Siswa)
 * @property string|null $nip Nomor Identitas Pegawai (Khusus Pembimbing / Admin)
 * @property string|null $phone Nomor WhatsApp aktif pengguna
 * @property string $password Hash kata sandi terenkripsi Bcrypt
 * @property string $role Peran pengguna: 'admin', 'pembimbing', 'mentor', 'siswa'
 * @property string $status Status verifikasi akun: 'pending', 'approved', 'rejected'
 * @property string|null $tempat_dudi Nama instansi industri mitra tempat magang
 * @property float|null $dudi_lat Garis lintang (latitude) lokasi kantor DUDI untuk Geofencing
 * @property float|null $dudi_lng Garis bujur (longitude) lokasi kantor DUDI untuk Geofencing
 * @property int|null $mentor_id Foreign Key ke akun mentor pembimbing (User id)
 * @property Carbon|null $created_at Waktu pendaftaran akun
 * @property Carbon|null $updated_at Waktu perubahan data akun
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment Protection).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'nis',
        'nisn',
        'departemen',
        'nip',
        'phone',
        'tempat_dudi',
        'dudi_lat',
        'dudi_lng',
        'mentor_id',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi (JSON / Array).
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis (Type Casting) Eloquent.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dudi_lat' => 'float',
            'dudi_lng' => 'float',
        ];
    }

    /**
     * Relasi 1-to-Many: Siswa memiliki banyak catatan logbook harian.
     */
    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    /**
     * Relasi 1-to-Many: Siswa memiliki banyak riwayat catatan absensi GPS harian.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Relasi 1-to-1: Siswa memiliki satu rekap nilai akhir kelulusan PKL.
     */
    public function grade(): HasOne
    {
        return $this->hasOne(Grade::class, 'student_id');
    }

    /**
     * Relasi Many-to-1: Siswa dibimbing oleh satu orang Mentor Industri DUDI.
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Relasi 1-to-Many: Mentor industri membimbing banyak siswa magang.
     */
    public function bimbinganSiswa(): HasMany
    {
        return $this->hasMany(User::class, 'mentor_id');
    }
}
