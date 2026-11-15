<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Attendance mewakili catatan absensi harian berbasis geolokasi GPS siswa.
 *
 * @property int $id Primary Key (Auto-Increment)
 * @property int $user_id Foreign Key ke tabel users (Siswa)
 * @property Carbon $tanggal Tanggal presensi dicatat
 * @property string|null $jam_masuk Waktu check-in pagi (Format: HH:mm:ss)
 * @property string|null $jam_pulang Waktu check-out sore (Format: HH:mm:ss)
 * @property string $status Status kehadiran: 'Hadir', 'Izin', 'Sakit', 'Diluar Radius DUDI'
 * @property string|null $alasan Keterangan izin/sakit atau catatan jarak GPS (misal: "Dalam radius valid (45m)")
 * @property string|null $foto Path bukti foto absensi jika diunggah
 * @property string $lokasi Nama instansi/lokasi DUDIKA saat absensi dicatat
 * @property Carbon|null $created_at Waktu record dibuat
 * @property Carbon|null $updated_at Waktu record diperbarui
 */
class Attendance extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment Protection).
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'alasan',
        'foto',
        'lokasi',
    ];

    /**
     * Konversi tipe data otomatis (Type Casting) Eloquent.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Relasi Many-to-1: Setiap catatan absensi dimiliki oleh satu siswa (User).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
