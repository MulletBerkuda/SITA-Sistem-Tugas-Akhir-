<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_bimbingan_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');

            // Hari disimpan string (Senin, Selasa, dll)
            $table->string('hari');

            // Jam mulai dan jam selesai
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // Kuota mahasiswa per jadwal
            $table->integer('kuota')->default(1);

            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_bimbingan_dosen');
    }
};
