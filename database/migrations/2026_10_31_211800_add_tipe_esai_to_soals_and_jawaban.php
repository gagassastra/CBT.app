<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mendukung jenis soal Pilihan Ganda dan Esai (Uraian).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->string('tipe', 20)->default('pilihan_ganda')->after('ujian_id'); // pilihan_ganda | esai
            $table->text('pedoman')->nullable(); // pedoman/kunci jawaban esai (untuk guru saat koreksi)
        });

        // Soal esai tidak punya opsi & kunci pilihan ganda
        Schema::table('soals', function (Blueprint $table) {
            $table->text('opsi_a')->nullable()->change();
            $table->text('opsi_b')->nullable()->change();
            $table->text('opsi_c')->nullable()->change();
            $table->text('opsi_d')->nullable()->change();
            $table->enum('jawaban_benar', ['A', 'B', 'C', 'D', 'E'])->nullable()->change();
        });

        // Jawaban siswa dapat berupa teks panjang (esai) dan memiliki skor koreksi
        Schema::table('jawaban_siswas', function (Blueprint $table) {
            $table->text('jawaban')->nullable()->change();
            $table->decimal('skor', 8, 2)->nullable();
        });

        Schema::table('hasil_ujians', function (Blueprint $table) {
            $table->integer('esai_belum_dinilai')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('hasil_ujians', function (Blueprint $table) {
            $table->dropColumn('esai_belum_dinilai');
        });

        Schema::table('jawaban_siswas', function (Blueprint $table) {
            $table->dropColumn('skor');
        });

        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'pedoman']);
        });
    }
};
