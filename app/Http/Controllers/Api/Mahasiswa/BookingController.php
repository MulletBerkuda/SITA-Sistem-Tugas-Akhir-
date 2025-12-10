<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalBimbinganDosen;
use App\Models\BookingBimbingan;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // GET Slot Bimbingan Mahasiswa
    public function slot(Request $request)
    {
        $mahasiswa = $request->user();
        $dosenId = $mahasiswa->dosen_id;

        if (!$dosenId) {
            return response()->json([
                "message" => "Anda belum memiliki dosen pembimbing.",
                "data" => []
            ]);
        }

        // Ambil semua slot dari dosen tersebut
        $slots = JadwalBimbinganDosen::with('dosen:id,name')
            ->where('dosen_id', $dosenId)
            ->where('kuota', '>', 0)   // slot bisa dibooking kalau kuota > 0
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            "message" => "Slot berhasil diambil",
            "data" => $slots
        ]);
    }

    // POST Booking Slot
    public function booking(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:jadwal_bimbingan_dosen,id'
        ]);

        $mahasiswa = $request->user();
        $slot = JadwalBimbinganDosen::findOrFail($request->slot_id);

        // Cek kuota
        if ($slot->kuota <= 0) {
            return response()->json([
                'message' => 'Slot sudah penuh'
            ], 400);
        }

        // Create booking
        $booking = BookingBimbingan::create([
            'jadwal_id' => $slot->id,
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => $slot->dosen_id,
            'tanggal' => $slot->tanggal,
            'hari' => $slot->hari,
            'jam_mulai' => $slot->jam_mulai,
            'jam_selesai' => $slot->jam_selesai,
            'status' => 'menunggu'
        ]);

        // Kurangi kuota
        $slot->update([
            'kuota' => $slot->kuota - 1
        ]);

        return response()->json([
            "message" => "Booking berhasil",
            "bimbingan_id" => $booking->id
        ]);
    }
}
