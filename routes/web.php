<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'auth.login');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/dosen/dashboard', function () {
    return view('dosen.dashboard');
});

Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard');
});


Route::get('/admin/bimbingan', fn() => view('admin.bimbingan.index'));
Route::get('/admin/bimbingan/create', fn() => view('admin.bimbingan.create'));
Route::get('/admin/bimbingan/edit/{id}', fn($id) => view('admin.bimbingan.edit', ['id' => $id]));

Route::get('/admin/bimbingan', fn() => view('admin.bimbingan.index'));
Route::get('/admin/bimbingan/create', fn() => view('admin.bimbingan.create'));
Route::get('/admin/bimbingan/edit/{id}', fn($id) => view('admin.bimbingan.edit', compact('id')));

// MANAGEMEN USER (Halaman Blade)
Route::get('/admin/users', fn() => view('admin.users.index'));
Route::get('/admin/users/create', fn() => view('admin.users.create'));
Route::get('/admin/users/{id}/edit', fn($id) => view('admin.users.edit', compact('id')));

// ADMIN SIDANG (Blade)
Route::get('/admin/sidang', fn() => view('admin.sidang.index'));
Route::get('/admin/sidang/create', fn() => view('admin.sidang.create'));
Route::get('/admin/sidang/edit/{id}', fn($id) => view('admin.sidang.edit', compact('id')));

// ADMIN PENGAJUAN SIDANG
Route::get('/admin/pengajuan-sidang', fn() => view('admin.pengajuan_sidang.index'));
Route::get('/admin/pengajuan-sidang/{id}', fn($id) => view('admin.pengajuan_sidang.detail', compact('id')));

Route::get('/admin/bimbingan', fn() => view('admin.bimbingan.index'));
Route::get('/admin/bimbingan/{id}', fn($id) => view('admin.bimbingan.detail', compact('id')));


// MAHASISWA BIMBINGAN (Blade)
Route::get('/mahasiswa/bimbingan', fn() => view('mahasiswa.bimbingan.index'));
Route::get('/mahasiswa/bimbingan/detail/{id}', fn($id) => view('mahasiswa.bimbingan.detail', compact('id')));
Route::get('/mahasiswa/bimbingan/booking', fn() => view('mahasiswa.bimbingan.booking'));
Route::get('/mahasiswa/pilih-pembimbing', fn() => view('mahasiswa.bimbingan.pilih_pembimbing'));

// MAHASISWA PENGAJUAN SIDANG (Blade)
// === PENGAJUAN SIDANG MAHASISWA (Blade Pages) ===
Route::get('/mahasiswa/pengajuan-sidang', fn() => view('mahasiswa.pengajuan_sidang.index'));

// Form create (HARUS DI ATAS route detail)
Route::get('/mahasiswa/pengajuan-sidang/create', fn() => view('mahasiswa.pengajuan_sidang.create'));

// Detail pengajuan
Route::get('/mahasiswa/pengajuan-sidang/{id}', fn($id) => view('mahasiswa.pengajuan_sidang.detail', compact('id')));

Route::get('/dosen/booking-bimbingan', function () {return view('dosen.booking.index');});

Route::get('/dosen/booking-bimbingan/{id}', function () {return view('dosen.booking.detail');});
Route::get('/dosen/jadwal-bimbingan', function () {
    return view('dosen.jadwal.index');
});
 Route::get('/dosen/jadwal-bimbingan/create', function () {
        return view('dosen.jadwal.create');
    });