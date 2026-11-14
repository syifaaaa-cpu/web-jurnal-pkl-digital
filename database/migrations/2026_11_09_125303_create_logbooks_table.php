<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users (siswa)
            $table->date('tanggal');
            $table->string('jam_kerja')->default('8 Jam');
            $table->string('judul_kegiatan');
            $table->text('deskripsi');
            $table->enum('status', ['Pending', 'Approved', 'Revisi'])->default('Pending');
            $table->text('catatan_mentor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
