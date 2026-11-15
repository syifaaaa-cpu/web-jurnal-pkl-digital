<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Standarisasi skema database, penambahan NISN, foreign keys formal, dan indeks performa.
     */
    public function up(): void
    {
        // 1. Tabel Users: Tambah NISN, index role & status, dan foreign key mentor_id
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nisn')) {
                $table->string('nisn', 20)->nullable()->unique()->after('nis');
            }

            // Tambahkan index untuk pencarian role & status akun jika belum ada
            $table->index('role');
            $table->index('status');
        });

        // 2. Foreign Key Constraint users.mentor_id -> users.id
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom mentor_id ada dan tambahkan foreign key jika belum di-constraint
            if (Schema::hasColumn('users', 'mentor_id')) {
                // MySQL foreign key
                try {
                    $table->foreign('mentor_id')->references('id')->on('users')->onDelete('set null');
                } catch (Throwable $e) {
                    // Abaikan jika constraint sudah ada
                }
            }
        });

        // 3. Tabel Attendances: Unique constraint untuk mencegah presensi ganda di hari yang sama
        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->unique(['user_id', 'tanggal'], 'attendances_user_tanggal_unique');
            } catch (Throwable $e) {
                // Abaikan jika constraint sudah ada
            }
        });

        // 4. Tabel Logbooks: Tambah index untuk filtering performa query bimbingan
        Schema::table('logbooks', function (Blueprint $table) {
            try {
                $table->index(['user_id', 'tanggal'], 'logbooks_user_tanggal_index');
                $table->index('status', 'logbooks_status_index');
            } catch (Throwable $e) {
                // Abaikan jika index sudah ada
            }
        });

        // 5. Tabel Grades: Unique constraint pada student_id (1 siswa 1 rekap nilai)
        Schema::table('grades', function (Blueprint $table) {
            try {
                $table->unique('student_id', 'grades_student_id_unique');
            } catch (Throwable $e) {
                // Abaikan jika unique sudah ada
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            try {
                $table->dropUnique('grades_student_id_unique');
            } catch (Throwable $e) {
            }
        });

        Schema::table('logbooks', function (Blueprint $table) {
            try {
                $table->dropIndex('logbooks_user_tanggal_index');
                $table->dropIndex('logbooks_status_index');
            } catch (Throwable $e) {
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->dropUnique('attendances_user_tanggal_unique');
            } catch (Throwable $e) {
            }
        });

        Schema::table('users', function (Blueprint $table) {
            try {
                $table->dropForeign(['mentor_id']);
            } catch (Throwable $e) {
            }

            try {
                $table->dropIndex(['role']);
                $table->dropIndex(['status']);
            } catch (Throwable $e) {
            }

            if (Schema::hasColumn('users', 'nisn')) {
                $table->dropColumn('nisn');
            }
        });
    }
};
