<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'bimbingan';

protected $fillable = [
    'mahasiswa_id',
    'dosen_id',
    'tanggal',
    'catatan',
    'status',
];


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
