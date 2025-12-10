<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSidang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_sidang';

    protected $fillable = [
        'mahasiswa_id',
        'berkas_toefl',
        'berkas_sertifikat_seminar',
        'berkas_bukti_sks',
        'catatan',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
