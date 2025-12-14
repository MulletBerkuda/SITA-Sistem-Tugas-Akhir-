<?php

namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Models\BookingBimbingan;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BookingBimbinganController extends Controller
{
    public function index()
    {
        return BookingBimbingan::with('mahasiswa','jadwal')
            ->where('dosen_id', auth()->id())
            ->orderByRaw("FIELD(status,'menunggu','disetujui','ditolak','dijadwal_ulang')")
            ->get();
    }

    public function show($id)
    {
        $booking = BookingBimbingan::with('mahasiswa','jadwal')->findOrFail($id);

        if ($booking->dosen_id !== auth()->id()) {
            abort(403);
        }

        return $booking;
    }

    public function acc(Request $request, $id)
    {
        $booking = BookingBimbingan::findOrFail($id);

        if ($booking->dosen_id !== auth()->id()) abort(403);
        if ($booking->status !== 'menunggu') {
            return response()->json(['message'=>'Booking sudah diproses'], 422);
        }

        $booking->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen
        ]);

        Bimbingan::create([
            'mahasiswa_id' => $booking->mahasiswa_id,
            'dosen_id'     => $booking->dosen_id,
            'jadwal_id'    => $booking->jadwal_id,
            'tanggal'      => $booking->tanggal,
            'status'       => 'aktif'
        ]);

        return response()->json(['message'=>'Booking disetujui']);
    }

public function tolak(Request $request, $id)
{
    $booking = BookingBimbingan::with('jadwal')->findOrFail($id);

    if ($booking->dosen_id !== auth()->id()) abort(403);

    // ⛔ Jangan boleh diproses dua kali
    if ($booking->status !== 'menunggu') {
        return response()->json([
            'message' => 'Booking sudah diproses'
        ], 422);
    }

    // 🔁 KEMBALIKAN KUOTA
    if ($booking->jadwal) {
        $booking->jadwal->increment('kuota');
    }

    // Update status booking
    $booking->update([
        'status' => 'ditolak',
        'catatan_dosen' => $request->catatan_dosen
    ]);

    return response()->json([
        'message' => 'Booking ditolak, kuota dikembalikan'
    ]);
}


    public function reschedule(Request $request, $id)
    {
        $booking = BookingBimbingan::findOrFail($id);

        if ($booking->dosen_id !== auth()->id()) abort(403);

        $booking->update([
            'status' => 'dijadwal_ulang',
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'catatan_dosen' => $request->catatan_dosen
        ]);

        return response()->json(['message'=>'Booking dijadwal ulang']);
    }
}
