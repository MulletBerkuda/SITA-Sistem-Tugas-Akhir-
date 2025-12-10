<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BookingBimbingan;
use App\Models\JadwalBimbinganDosen;
use Illuminate\Http\Request;

class MahasiswaBimbinganController extends Controller
{
    public function storeBooking(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_bimbingan_dosen,id',
            'catatan_mahasiswa' => 'nullable|string'
        ]);

        $jadwal = JadwalBimbinganDosen::find($request->jadwal_id);

        // Tentukan tanggal otomatis sesuai hari jadwal
        $targetTanggal = now()->next($jadwal->hari)->format('Y-m-d');

        $booking = BookingBimbingan::create([
            'mahasiswa_id' => $request->user()->id,
            'dosen_id' => $jadwal->dosen_id,
            'jadwal_id' => $jadwal->id,
            'tanggal' => $targetTanggal,
            'waktu_mulai' => $jadwal->jam_mulai,
            'waktu_selesai' => $jadwal->jam_selesai,
            'catatan_mahasiswa' => $request->catatan_mahasiswa,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Permintaan bimbingan berhasil dikirim.',
            'data' => $booking
        ], 201);
    }

    public function index(Request $request)
{
    $mahasiswaId = $request->user()->id;

    $data = BookingBimbingan::with(['dosen:id,name', 'jadwal'])
            ->where('mahasiswa_id', $mahasiswaId)
            ->orderBy('tanggal', 'desc')
            ->get();

    return response()->json([
        'message' => 'Daftar bimbingan berhasil diambil',
        'data' => $data
    ]);
}

public function setPembimbing(Request $request)
{
    $request->validate([
        'dosen_id' => 'required|exists:users,id'
    ]);

    $mahasiswa = $request->user();
    $mahasiswa->dosen_id = $request->dosen_id;
    $mahasiswa->save();

    return response()->json([
        "message" => "Dosen pembimbing berhasil dipilih"
    ]);
}
public function listDosen()
{
    $dosen = \App\Models\User::where('role', 'dosen')
                ->select('id', 'name')
                ->get();

    return response()->json($dosen);
}


}
