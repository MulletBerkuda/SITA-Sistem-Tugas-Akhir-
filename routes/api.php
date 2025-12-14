<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\Admin\AdminBimbinganController;
use App\Http\Controllers\Api\Admin\AdminUserController;
use App\Http\Controllers\Api\Admin\SidangController;
use App\Http\Controllers\Api\Admin\AdminPengajuanSidangController;
use App\Http\Controllers\Api\Admin\AdminBookingBimbinganController;
use App\Http\Controllers\Api\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\Api\Mahasiswa\BookingController;
use App\Http\Controllers\Api\Mahasiswa\MahasiswaBimbinganController;
use App\Http\Controllers\Api\Mahasiswa\PengajuanSidangController;
use App\Http\Controllers\Api\Mahasiswa\PengajuanSidangMahasiswaController;
use App\Http\Controllers\Api\Dosen\DashboardController; 
use App\Http\Controllers\Api\Dosen\BookingBimbinganController;
use App\Http\Controllers\Api\Dosen\JadwalBimbinganController;

// LOGIN API
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ME
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);


// ========================
// ADMIN DASHBOARD API
// ========================
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/total-users', [AdminDashboardController::class, 'totalUsers']);
    Route::get('/total-bimbingan', [AdminDashboardController::class, 'totalBimbingan']);
    Route::get('/total-sidang', [AdminDashboardController::class, 'totalSidang']);
    Route::get('/activity', [AdminDashboardController::class, 'recentActivity']);
    // === Users Role-based ===
    Route::get('/users/mahasiswa', [AdminUserController::class, 'getMahasiswa']);
    Route::get('/users/dosen', [AdminUserController::class, 'getDosen']);
    // Bimbingan CRUD
    Route::get('/bimbingan', [AdminBimbinganController::class, 'index']);
    Route::post('/bimbingan', [AdminBimbinganController::class, 'store']);
    Route::get('/bimbingan/{id}', [AdminBimbinganController::class, 'show']);
    Route::put('/bimbingan/{id}', [AdminBimbinganController::class, 'update']);
    Route::delete('/bimbingan/{id}', [AdminBimbinganController::class, 'destroy']);
    // USER MANAGEMENT
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/users/{id}', [AdminUserController::class, 'show']);
    Route::put('/users/{id}', [AdminUserController::class, 'update']);
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);

        // SIDANG CRUD
    Route::get('/sidang', [SidangController::class, 'index']);
    Route::post('/sidang', [SidangController::class, 'store']);
    Route::get('/sidang/{id}', [SidangController::class, 'show']);
    Route::put('/sidang/{id}', [SidangController::class, 'update']);
    Route::delete('/sidang/{id}', [SidangController::class, 'destroy']);

    // PENGAJUAN SIDANG
Route::get('/pengajuan-sidang', [AdminPengajuanSidangController::class, 'index']);
Route::get('/pengajuan-sidang/{id}', [AdminPengajuanSidangController::class, 'show']);
Route::put('/pengajuan-sidang/{id}/terima', [AdminPengajuanSidangController::class, 'terima']);
Route::put('/pengajuan-sidang/{id}/tolak', [AdminPengajuanSidangController::class, 'tolak']);

 // Monitoring Bimbingan
    Route::get('/bimbingan', [AdminBookingBimbinganController::class, 'index']);
    Route::get('/bimbingan/{id}', [AdminBookingBimbinganController::class, 'show']);

});

//mahasiswa
Route::middleware(['auth:sanctum', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {

    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index']);
    Route::get('/bimbingan', [MahasiswaBimbinganController::class, 'index']);

    Route::get('/slot-bimbingan', [BookingController::class, 'slot']);
    Route::post('/booking-bimbingan', [BookingController::class, 'booking']);

    // Dosen
    Route::get('/dosen', [MahasiswaBimbinganController::class, 'listDosen']);
    Route::put('/set-pembimbing', [MahasiswaBimbinganController::class, 'setPembimbing']);

    // === PENGAJUAN SIDANG ===
    Route::get('/pengajuan-sidang', [PengajuanSidangMahasiswaController::class, 'index']);
    Route::get('/pengajuan-sidang/create', [PengajuanSidangMahasiswaController::class, 'create']);
    Route::get('/pengajuan-sidang/{id}', [PengajuanSidangMahasiswaController::class, 'show']);
    Route::post('/pengajuan-sidang', [PengajuanSidangMahasiswaController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'role:dosen'])->prefix('dosen')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index']);

        // BOOKING BIMBINGAN
        Route::get('/booking-bimbingan', [BookingBimbinganController::class, 'index']);
        Route::get('/booking-bimbingan/{id}', [BookingBimbinganController::class, 'show']);
        Route::post('/booking-bimbingan/{id}/acc', [BookingBimbinganController::class, 'acc']);
        Route::post('/booking-bimbingan/{id}/tolak', [BookingBimbinganController::class, 'tolak']);
        Route::post('/booking-bimbingan/{id}/reschedule', [BookingBimbinganController::class, 'reschedule']);


          Route::get('/jadwal-bimbingan', [JadwalBimbinganController::class, 'index']);
        Route::post('/jadwal-bimbingan', [JadwalBimbinganController::class, 'store']);
        Route::delete('/jadwal-bimbingan/{id}', [JadwalBimbinganController::class, 'destroy']);
    });