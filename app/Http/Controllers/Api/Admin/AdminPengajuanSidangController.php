<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSidang;
use Illuminate\Http\Request;

class AdminPengajuanSidangController extends Controller
{
    // Get all pengajuan
    public function index()
    {
        $data = PengajuanSidang::with('mahasiswa:id,name')
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json([
            'message' => 'Daftar pengajuan sidang berhasil diambil',
            'data' => $data
        ]);
    }

    // Detail
    public function show($id)
    {
        $data = PengajuanSidang::with('mahasiswa:id,name,email')->findOrFail($id);

        return response()->json([
            'message' => 'Detail pengajuan berhasil diambil',
            'data' => $data
        ]);
    }

    // Admin menerima pengajuan
    public function terima($id)
    {
        $data = PengajuanSidang::findOrFail($id);
        $data->update(['status' => 'diterima']);

        return response()->json([
            'message' => 'Pengajuan diterima',
         'mahasiswa_id' => $data->mahasiswa_id
        ]);
    }

    // Admin menolak
    public function tolak(Request $request, $id)
    {
        $data = PengajuanSidang::findOrFail($id);

        $data->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'message' => 'Pengajuan ditolak'
        ]);
    }
}
