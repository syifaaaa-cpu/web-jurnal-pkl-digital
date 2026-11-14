<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('grades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('mentor_id')->nullable()->constrained('users')->onDelete('set null');
        $table->decimal('nilai_teknis', 5, 2)->nullable();
        $table->decimal('nilai_disiplin', 5, 2)->nullable();
        $table->decimal('nilai_kerjasama', 5, 2)->nullable();
        $table->decimal('nilai_inisiatif', 5, 2)->nullable();
        $table->decimal('nilai_dudi', 5, 2)->nullable(); // Rata-rata 60% dari mentor
        $table->decimal('nilai_laporan', 5, 2)->nullable(); // 40% dari guru pembimbing
        $table->decimal('nilai_akhir', 5, 2)->nullable(); // Hasil akhir kombinasi
        $table->string('predikat', 5)->nullable(); // A, B, C, D
        $table->text('catatan_mentor')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
