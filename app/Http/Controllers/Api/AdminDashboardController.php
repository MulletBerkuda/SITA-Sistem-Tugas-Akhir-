<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Sidang;

class AdminDashboardController extends Controller
{
    public function totalUsers()
    {
        return response()->json([
            'total' => User::count()
        ]);
    }

    public function totalBimbingan()
    {
        return response()->json([
            'total' => Bimbingan::count()
        ]);
    }

    public function totalSidang()
    {
        return response()->json([
            'total' => Sidang::count()
        ]);
    }

    public function recentActivity()
    {
        // UNTUK SEKARANG: dummy activity
        return response()->json([
            ['nama' => 'Admin', 'kegiatan' => 'Login', 'tanggal' => now()->toDateString()],
            ['nama' => 'Dosen 1', 'kegiatan' => 'Approve Bimbingan', 'tanggal' => now()->toDateString()],
            ['nama' => 'Mahasiswa 1', 'kegiatan' => 'Upload Berkas', 'tanggal' => now()->toDateString()],
        ]);
    }
}
