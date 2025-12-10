<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class AdminBimbinganController extends Controller
{
    // GET all
    public function index()
    {
        return response()->json(
            Bimbingan::with(['mahasiswa:id,name', 'dosen:id,name'])
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    // GET detail (SHOW)
    public function show($id)
    {
        $bimbingan = Bimbingan::with(['mahasiswa', 'dosen'])->findOrFail($id);
        return response()->json($bimbingan);
    }

    // // POST create
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'mahasiswa_id' => 'required',
    //         'dosen_id' => 'required',
    //         'tanggal' => 'nullable|date',
    //         'catatan' => 'nullable|string'
    //     ]);

    //     $bimbingan = Bimbingan::create($request->all());

    //     return response()->json(['message' => 'Bimbingan ditambahkan', 'data' => $bimbingan]);
    // }

    // // PUT update
    // public function update(Request $request, $id)
    // {
    //     $bimbingan = Bimbingan::findOrFail($id);

    //     $bimbingan->update([
    //         'mahasiswa_id' => $request->mahasiswa_id,
    //         'dosen_id' => $request->dosen_id,
    //         'tanggal' => $request->tanggal,
    //         'catatan' => $request->catatan,
    //         'status' => $request->status,
    //     ]);

    //     return response()->json(['message' => 'Bimbingan berhasil diperbarui']);
    // }

    // // DELETE
    // public function destroy($id)
    // {
    //     Bimbingan::findOrFail($id)->delete();

    //     return response()->json(['message' => 'Bimbingan dihapus']);
    // }
}
