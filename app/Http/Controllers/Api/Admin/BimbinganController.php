<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\User;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function getMahasiswa()
    {
        return User::where('role', 'mahasiswa')->get(['id', 'name']);
    }

    public function getDosen()
    {
        return User::where('role', 'dosen')->get(['id', 'name']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_id'     => 'required|exists:users,id',
            'tanggal'      => 'nullable|date',
            'catatan'      => 'nullable|string',
        ]);

        $data = Bimbingan::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_id'     => $request->dosen_id,
            'tanggal'      => $request->tanggal,
            'catatan'      => $request->catatan,
            'status'       => 'pending'
        ]);

        return response()->json([
            'message' => 'Bimbingan berhasil dibuat!',
            'data' => $data
        ]);
    }
}
