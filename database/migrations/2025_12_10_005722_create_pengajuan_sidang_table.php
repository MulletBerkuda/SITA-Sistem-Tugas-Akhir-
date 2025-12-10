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
        Schema::create('pengajuan_sidang', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('mahasiswa_id');

    // 3 berkas wajib
    $table->string('berkas_toefl');
    $table->string('berkas_sertifikat_seminar');
    $table->string('berkas_bukti_sks');

    $table->string('catatan')->nullable();

    $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');

    $table->timestamps();

    $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sidang');
    }
};
