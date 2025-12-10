<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingBimbingan extends Model
{
    use HasFactory;

    protected $table = 'booking_bimbingan';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'jadwal_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'catatan_mahasiswa',
        'catatan_dosen',
        'status'
    ];

    // RELASI
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalBimbinganDosen::class, 'jadwal_id');
    }
}
