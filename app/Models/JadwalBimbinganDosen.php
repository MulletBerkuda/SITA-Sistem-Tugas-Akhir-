<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBimbinganDosen extends Model
{
    use HasFactory;

    protected $table = 'jadwal_bimbingan_dosen';

    protected $fillable = [
        'dosen_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota'
    ];

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function booking()
    {
        return $this->hasMany(BookingBimbingan::class, 'jadwal_id');
    }
}
