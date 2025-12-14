<?php

namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalBimbinganDosen;
use Illuminate\Http\Request;

class JadwalBimbinganController extends Controller
{
    public function index()
    {
        return JadwalBimbinganDosen::where('dosen_id', auth()->id())
            ->orderBy('tanggal')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'kuota' => 'required|integer|min:1'
        ]);

        return JadwalBimbinganDosen::create([
            'dosen_id' => auth()->id(),
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'kuota' => $request->kuota
        ]);
    }

    public function destroy($id)
    {
        $jadwal = JadwalBimbinganDosen::findOrFail($id);

        if ($jadwal->dosen_id !== auth()->id()) {
            abort(403);
        }

        // Optional: cek apakah sudah ada booking
        if ($jadwal->booking()->count() > 0) {
            return response()->json([
                'message' => 'Jadwal sudah dibooking, tidak bisa dihapus'
            ], 422);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal dihapus']);
    }
}
