<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidang extends Model
{
    use HasFactory;

    protected $table = 'sidang';

    protected $fillable = [
        'mahasiswa_id',
        'pembimbing_id',
        'penguji_id',
        'jadwal',
        'ruangan',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    public function penguji()
    {
        return $this->belongsTo(User::class, 'penguji_id');
    }
}
