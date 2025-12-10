<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    /**
     * GET: /api/mahasiswa/bimbingan
     * Menampilkan semua bimbingan milik mahasiswa ini
     */
    public function index()
    {
        $mahasiswaId = Auth::id();

        $data = Bimbingan::with('dosen:id,nama,email')
            ->where('mahasiswa_id', $mahasiswaId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }

    /**
     * POST: /api/mahasiswa/bimbingan
     * Mahasiswa mengajukan bimbingan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:users,id',
            'catatan' => 'required',
        ]);

        $data = Bimbingan::create([
            'mahasiswa_id' => Auth::id(),
            'dosen_id' => $request->dosen_id,
            'catatan' => $request->catatan,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Bimbingan berhasil diajukan',
            'data' => $data
        ]);
    }

    /**
     * DELETE: /api/mahasiswa/bimbingan/{id}
     * Hanya boleh dihapus jika masih pending
     */
    public function destroy($id)
    {
        $mhsId = Auth::id();

        $bimbingan = Bimbingan::where('id', $id)
            ->where('mahasiswa_id', $mhsId)
            ->firstOrFail();

        if ($bimbingan->status !== 'pending') {
            return response()->json(['message' => 'Bimbingan tidak bisa dihapus'], 422);
        }

        $bimbingan->delete();

        return response()->json(['message' => 'Bimbingan dihapus']);
    }
}
