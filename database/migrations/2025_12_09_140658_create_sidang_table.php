<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sidang', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('pembimbing_id');
            $table->unsignedBigInteger('penguji_id');

            $table->dateTime('jadwal');
            $table->string('ruangan')->nullable();
            $table->enum('status', ['dijadwalkan','selesai'])->default('dijadwalkan');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pembimbing_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('penguji_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sidang');
    }
};
