<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingBimbingan;
use Illuminate\Http\Request;

class AdminBookingBimbinganController extends Controller
{
    // GET all bimbingan (monitoring)
    public function index()
    {
        $data = BookingBimbingan::with([
            'mahasiswa:id,name',
            'dosen:id,name',
            'jadwal'
        ])
        ->orderBy('tanggal', 'desc')
        ->get();

        return response()->json([
            'message' => 'Daftar bimbingan berhasil diambil',
            'data' => $data
        ]);
    }

    // GET detail
    public function show($id)
    {
        $data = BookingBimbingan::with([
            'mahasiswa',
            'dosen',
            'jadwal'
        ])->findOrFail($id);

        return response()->json([
            'message' => 'Detail bimbingan berhasil diambil',
            'data' => $data
        ]);
    }
}
