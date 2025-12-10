<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanSidangMahasiswaController extends Controller
{
    /**
     * GET /api/mahasiswa/pengajuan-sidang
     * List pengajuan milik mahasiswa
     */
    public function index()
    {
        $mhsId = Auth::id();

        $data = PengajuanSidang::where('mahasiswa_id', $mhsId)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'message' => 'Daftar pengajuan sidang diambil',
            'data' => $data
        ]);
    }

    /**
     * GET /api/mahasiswa/pengajuan-sidang/{id}
     */
    public function show($id)
    {
        $mhsId = Auth::id();

        $data = PengajuanSidang::where('mahasiswa_id', $mhsId)
                ->where('id', $id)
                ->firstOrFail();

        return response()->json([
            'message' => 'Detail pengajuan sidang diambil',
            'data' => $data
        ]);
    }

    /**
     * POST /api/mahasiswa/pengajuan-sidang
     */
    public function store(Request $request)
    {
        $request->validate([
            'berkas_toefl' => 'required|file|mimes:pdf',
            'berkas_sertifikat_seminar' => 'required|file|mimes:pdf',
            'berkas_bukti_sks' => 'required|file|mimes:pdf',
        ]);

        $mhsId = Auth::id();

        // Upload
        $toefl = $request->file('berkas_toefl')->store('sidang', 'public');
        $seminar = $request->file('berkas_sertifikat_seminar')->store('sidang', 'public');
        $sks = $request->file('berkas_bukti_sks')->store('sidang', 'public');

        $data = PengajuanSidang::create([
            'mahasiswa_id' => $mhsId,
            'berkas_toefl' => $toefl,
            'berkas_sertifikat_seminar' => $seminar,
            'berkas_bukti_sks' => $sks,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Pengajuan sidang berhasil dikirim',
            'data' => $data
        ]);
    }

    public function create()
{
    return response()->json([
        'message' => 'Form pengajuan sidang',
        'data' => [
            'max_file_size' => '2MB',
            'required_files' => [
                'berkas_toefl',
                'berkas_sertifikat_seminar',
                'berkas_bukti_sks'
            ],
        ]
    ]);
}

}
