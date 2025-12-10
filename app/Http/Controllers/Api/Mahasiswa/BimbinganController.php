<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BookingBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    /**
     * GET /api/mahasiswa/bimbingan
     * Menampilkan daftar booking bimbingan milik mahasiswa
     */
    public function index()
    {
        $mahasiswaId = Auth::id();

        $data = BookingBimbingan::with([
            'dosen:id,name,email',
            'jadwal:id,jam_mulai,jam_selesai,tanggal'
        ])
        ->where('mahasiswa_id', $mahasiswaId)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * POST /api/mahasiswa/bimbingan
     * Mahasiswa melakukan booking bimbingan berdasarkan jadwal dosen
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_bimbingan_dosen,id',
            'dosen_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
        ]);

        $booking = BookingBimbingan::create([
            'mahasiswa_id' => Auth::id(),
            'dosen_id' => $request->dosen_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai ?? null,
            'waktu_selesai' => $request->waktu_selesai ?? null,
            'catatan_mahasiswa' => $request->catatan_mahasiswa ?? null,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'message' => 'Booking bimbingan berhasil dibuat',
            'data' => $booking
        ]);
    }

    /**
     * DELETE /api/mahasiswa/bimbingan/{id}
     * Hanya boleh dihapus jika status masih menunggu
     */
    public function destroy($id)
    {
        $mhsId = Auth::id();

        $booking = BookingBimbingan::where('id', $id)
            ->where('mahasiswa_id', $mhsId)
            ->firstOrFail();

        if ($booking->status !== 'menunggu') {
            return response()->json([
                'message' => 'Booking tidak dapat dihapus karena sudah diproses'
            ], 422);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking bimbingan berhasil dihapus'
        ]);
    }
}
