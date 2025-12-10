<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BookingBimbingan;
use App\Models\JadwalBimbinganDosen;
use App\Models\PengajuanSidang;
use App\Models\Sidang;
use Illuminate\Http\Request;

class MahasiswaDashboardController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswaId = $request->user()->id;

        // Bimbingan selesai & pending
        $totalSelesai = BookingBimbingan::where('mahasiswa_id', $mahasiswaId)
                        ->where('status', 'selesai')->count();

        $totalPending = BookingBimbingan::where('mahasiswa_id', $mahasiswaId)
                        ->where('status', 'pending')->count();

        $lastBimbingan = BookingBimbingan::where('mahasiswa_id', $mahasiswaId)
                        ->orderBy('created_at', 'desc')
                        ->first();

        // Pengajuan sidang mahasiswa
        $pengajuan = PengajuanSidang::where('mahasiswa_id', $mahasiswaId)
                        ->orderBy('created_at', 'desc')
                        ->first();

        // Jadwal sidang jika sudah ada
        $sidang = Sidang::with(['pembimbing', 'penguji'])
                        ->where('mahasiswa_id', $mahasiswaId)
                        ->first();

        // Jadwal bimbingan dosen mahasiswa ini
        $jadwalDosen = JadwalBimbinganDosen::where('dosen_id', $request->user()->pembimbing_id ?? null)->get();

        return response()->json([
            'bimbingan' => [
                'selesai' => $totalSelesai,
                'pending' => $totalPending,
                'last' => $lastBimbingan
            ],
            'pengajuan_sidang' => $pengajuan,
            'jadwal_sidang' => $sidang,
            'jadwal_bimbingan_dosen' => $jadwalDosen
        ]);
    }
}
