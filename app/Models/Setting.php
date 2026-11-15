<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Setting mewakili konfigurasi dinamis aplikasi bersistem Key-Value Store.
 * Digunakan untuk pengaturan kuota industri, tanggal timeline PKL, identitas sekolah, dan notifikasi.
 *
 * @property int $id Primary Key (Auto-Increment)
 * @property string $key Kunci pengaturan unik (misal: 'kuota_dudi', 'tanggal_selesai')
 * @property string|null $value Nilai pengaturan dalam bentuk string teks / JSON
 * @property Carbon|null $created_at Waktu record dibuat
 * @property Carbon|null $updated_at Waktu record diperbarui
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment Protection).
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Helper cepat untuk mengambil nilai pengaturan berdasarkan kunci dengan nilai bawaan (default).
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * Helper cepat untuk menyimpan atau memperbarui nilai pengaturan secara instan.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now()]);
    }
}
