<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nis')) {
                $table->string('nis')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'departemen')) {
                $table->string('departemen')->nullable()->after('nis');
            }
            if (! Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->after('departemen');
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('nip');
            }
            if (! Schema::hasColumn('users', 'tempat_dudi')) {
                $table->string('tempat_dudi')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'dudi_lat')) {
                $table->decimal('dudi_lat', 10, 7)->nullable()->after('tempat_dudi');
            }
            if (! Schema::hasColumn('users', 'dudi_lng')) {
                $table->decimal('dudi_lng', 10, 7)->nullable()->after('dudi_lat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'departemen', 'nip', 'phone', 'tempat_dudi', 'dudi_lat', 'dudi_lng']);
        });
    }
};
