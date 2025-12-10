<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // ========================
    // LIST USER SESUAI ROLE
    // ========================
    public function getMahasiswa()
    {
        return User::where('role', 'mahasiswa')->orderBy('name')->get();
    }

    public function getDosen()
    {
        return User::where('role', 'dosen')->orderBy('name')->get();
    }


    // ========================
    // CRUD USER
    // ========================

    // GET ALL USERS
    public function index()
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    // GET DETAIL USER
    public function show($id)
    {
        return User::findOrFail($id);
    }

    // CREATE USER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,dosen,mahasiswa'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Update password jika ada
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'User diperbarui']);
    }

    // DELETE USER
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User dihapus']);
    }
}
