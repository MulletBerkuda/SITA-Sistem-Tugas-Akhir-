@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')

<h2>Edit User</h2>

<form id="editForm">
    <label for="name">Nama</label>
    <input id="name" type="text" required>

    <label for="email">Email</label>
    <input id="email" type="email" required>

    <label for="role">Role</label>
    <select id="role" required>
        <option value="admin">Admin</option>
        <option value="dosen">Dosen</option>
        <option value="mahasiswa">Mahasiswa</option>
    </select>

    <label for="password">Password (opsional)</label>
    <input id="password" type="password">

    <button type="submit">Update</button>
</form>

<p id="msg"></p>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {

    const id = "{{ $id }}";   // Ambil ID dari route
    const token = localStorage.getItem("token");
    const headers = { Authorization: `Bearer ${token}` };

    // === LOAD DATA USER (agar tidak kosong) ===
    axios.get(`/api/admin/users/${id}`, { headers })
    .then(res => {
        const u = res.data;

        document.getElementById('name').value = u.name;
        document.getElementById('email').value = u.email;
        document.getElementById('role').value = u.role;
    })
    .catch(err => {
        document.getElementById('msg').innerText = "Gagal mengambil data user";
    });

    // === UPDATE USER ===
    document.getElementById("editForm").addEventListener("submit", function(e){
        e.preventDefault();

        axios.put(`/api/admin/users/${id}`, {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            role: document.getElementById('role').value,
            password: document.getElementById('password').value || null
        }, { headers })
        .then(res => {
            document.getElementById('msg').innerText = "Berhasil mengupdate user!";
            setTimeout(() => window.location.href = "/admin/users", 1200);
        })
        .catch(err => {
            document.getElementById('msg').innerText = "Gagal update user";
        });
    });

});
</script>
@endsection
