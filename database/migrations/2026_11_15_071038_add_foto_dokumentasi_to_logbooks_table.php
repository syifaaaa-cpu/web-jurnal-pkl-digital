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
        Schema::table('logbooks', function (Blueprint $table) {
            if (! Schema::hasColumn('logbooks', 'foto_dokumentasi')) {
                $table->string('foto_dokumentasi')->nullable()->after('catatan_mentor');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            if (Schema::hasColumn('logbooks', 'foto_dokumentasi')) {
                $table->dropColumn('foto_dokumentasi');
            }
        });
    }
};
