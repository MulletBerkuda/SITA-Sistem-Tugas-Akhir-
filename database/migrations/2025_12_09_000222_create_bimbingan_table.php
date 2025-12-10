<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingan', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('dosen_id');

            // Data bimbingan
            $table->dateTime('tanggal')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');

            $table->timestamps();

            // Foreign key
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan');
    }
};
