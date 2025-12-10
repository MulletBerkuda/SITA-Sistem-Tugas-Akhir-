@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<h2>Manajemen User</h2>
<a href="/admin/users/create" class="btn">Tambah User</a>

<table border="1" width="100%" id="userTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem("token");
    const headers = { Authorization: `Bearer ${token}` };
    
    // Load users
    axios.get("/api/admin/users", { headers }).then(res => {
        const tbody = document.querySelector("#userTable tbody");
        tbody.innerHTML = "";

        res.data.forEach(u => {
            tbody.innerHTML += `
                <tr>
                    <td>${u.id}</td>
                    <td>${u.name}</td>
                    <td>${u.email}</td>
                    <td>${u.role}</td>
                    <td>
                        <a href="/admin/users/${u.id}/edit">Edit</a>
                        <button onclick="deleteUser(${u.id})">Hapus</button>
                    </td>
                </tr>
            `;
        });
    });
});

// Delete user
function deleteUser(id) {
    if (!confirm("Hapus user?")) return;

    const token = localStorage.getItem("token");
    axios.delete(`/api/admin/users/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(() => location.reload());
}
</script>
@endsection
