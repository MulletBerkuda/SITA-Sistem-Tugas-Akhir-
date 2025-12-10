@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<h2>Tambah User</h2>

<form id="createForm">

    <label for="name">Nama</label>
    <input type="text" id="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" required>

    <label for="role">Role</label>
    <select id="role" required>
        <option value="">-- pilih role --</option>
        <option value="admin">Admin</option>
        <option value="dosen">Dosen</option>
        <option value="mahasiswa">Mahasiswa</option>
    </select>

    <label for="password">Password</label>
    <input type="password" id="password" required>

    <button type="submit">Simpan</button>
</form>

<p id="msg"></p>
@endsection

@section('scripts')
<script>
document.getElementById("createForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const token = localStorage.getItem("token");
    const headers = { Authorization: `Bearer ${token}` };

    axios.post('/api/admin/users', {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        role: document.getElementById("role").value,
        password: document.getElementById("password").value
    }, { headers })
    .then(res => {
        document.getElementById("msg").innerText = "User berhasil ditambahkan!";
        setTimeout(() => window.location.href = "/admin/users", 1200);
    })
    .catch(err => {
        console.log(err.response.data); // lihat error real-nya
        document.getElementById("msg").innerText = "Gagal menambahkan user.";
    });
});
</script>
@endsection
