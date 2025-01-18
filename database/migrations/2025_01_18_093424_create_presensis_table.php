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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->date('date'); // Tanggal presensi
            $table->enum('jenis', ['hadir', 'izin', 'sakit'])->default('hadir'); // Jenis presensi
            $table->boolean('is_approved')->default(false); // Status persetujuan
            $table->string('keterangan')->nullable(); // Keterangan tambahan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
