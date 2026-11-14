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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom mentor_id untuk relasi plotting mentor (menggunakan foreign key ke tabel users)
            $table->unsignedBigInteger('mentor_id')->nullable()->after('role');

            // Opsional: Jika ingin langsung menghubungkan foreign key secara ketat
            // $table->foreign('mentor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropForeign(['mentor_id']);
            $table->dropColumn('mentor_id');
        });
    }
};
