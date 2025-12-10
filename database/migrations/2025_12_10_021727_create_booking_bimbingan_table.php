<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_bimbingan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('jadwal_id'); // jadwal_bimbingan_dosen.id

            // Slot waktu final dipilih mahasiswa
            $table->date('tanggal');
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();

            // Catatan mahasiswa & dosen
            $table->text('catatan_mahasiswa')->nullable();
            $table->text('catatan_dosen')->nullable();

            // Status
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'selesai'])->default('pending');

            $table->timestamps();

            // Foreign keys
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal_bimbingan_dosen')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_bimbingan');
    }
};
