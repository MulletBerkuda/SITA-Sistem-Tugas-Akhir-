<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sidang;
use Illuminate\Http\Request;

class SidangController extends Controller
{
    // GET ALL
    public function index()
    {
        $sidang = Sidang::with([
            'mahasiswa:id,name',
            'pembimbing:id,name',
            'penguji:id,name'
        ])
        ->orderBy('jadwal', 'asc')
        ->get();

        return response()->json([
            'message' => 'Daftar sidang berhasil diambil',
            'data' => $sidang
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'pembimbing_id' => 'required|exists:users,id',
            'penguji_id' => 'required|exists:users,id',
            'jadwal' => 'required|date',
            'ruangan' => 'nullable|string',
            'status' => 'nullable|in:dijadwalkan,selesai'
        ]);

        $sidang = Sidang::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'pembimbing_id' => $request->pembimbing_id,
            'penguji_id' => $request->penguji_id,
            'jadwal' => $request->jadwal,
            'ruangan' => $request->ruangan,
            'status' => $request->status ?? 'dijadwalkan'
        ]);

        return response()->json([
            'message' => 'Sidang berhasil dibuat',
            'data' => $sidang
        ]);
    }

    // SHOW DETAIL
    public function show($id)
    {
        $sidang = Sidang::with(['mahasiswa', 'pembimbing', 'penguji'])
            ->findOrFail($id);

        return response()->json([
            'message' => 'Detail sidang berhasil diambil',
            'data' => $sidang
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $sidang = Sidang::findOrFail($id);

        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'pembimbing_id' => 'required|exists:users,id',
            'penguji_id' => 'required|exists:users,id',
            'jadwal' => 'required|date',
            'ruangan' => 'nullable|string',
            'status' => 'required|in:dijadwalkan,selesai'
        ]);

        $sidang->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'pembimbing_id' => $request->pembimbing_id,
            'penguji_id' => $request->penguji_id,
            'jadwal' => $request->jadwal,
            'ruangan' => $request->ruangan,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Sidang berhasil diperbarui',
            'data' => $sidang
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $sidang = Sidang::findOrFail($id);
        $sidang->delete();

        return response()->json([
            'message' => 'Sidang berhasil dihapus'
        ]);
    }
}
