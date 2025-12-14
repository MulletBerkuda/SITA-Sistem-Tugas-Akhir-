<?php
namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Models\BookingBimbingan;
use App\Models\Bimbingan;
use App\Models\JadwalBimbinganDosen;
use App\Models\Sidang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        return response()->json([
            'booking' => [
                'menunggu' => BookingBimbingan::where('dosen_id', $dosenId)
                    ->where('status', 'menunggu')->count(),

                'disetujui' => BookingBimbingan::where('dosen_id', $dosenId)
                    ->where('status', 'disetujui')->count(),

                'last' => BookingBimbingan::with('mahasiswa')
                    ->where('dosen_id', $dosenId)
                    ->latest()
                    ->first()
            ],

            'bimbingan' => [
                'aktif' => Bimbingan::where('dosen_id', $dosenId)
                    ->where('status', 'aktif')->count(),

                'selesai' => Bimbingan::where('dosen_id', $dosenId)
                    ->where('status', 'selesai')->count()
            ],

            'jadwal_bimbingan' => JadwalBimbinganDosen::where('dosen_id', $dosenId)->get(),

            'sidang' => [
                'pembimbing' => Sidang::where('pembimbing_id', $dosenId)->count(),
                'penguji' => Sidang::where('penguji_id', $dosenId)->count()
            ]
        ]);
    }
}
