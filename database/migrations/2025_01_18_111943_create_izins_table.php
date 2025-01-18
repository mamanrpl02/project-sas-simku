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
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade'); // Relasi ke user (siswa)
            $table->enum('jenis', ['Sakit', 'Izin']);
            $table->text('alasan');
            $table->boolean('is_approved')->default(false); // Status disetujui atau tidak
            $table->string('bukti')->nullable(); // Kolom untuk menyimpan file bukti
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
