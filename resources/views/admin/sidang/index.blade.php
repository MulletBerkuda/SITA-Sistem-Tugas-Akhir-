@extends('layouts.admin')

@section('title', 'Manajemen Sidang')

@section('content')
<h2>Manajemen Sidang</h2>

<a href="/admin/sidang/create" class="btn btn-primary">+ Tambah Sidang</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Mahasiswa</th>
            <th>Pembimbing</th>
            <th>Penguji</th>
            <th>Jadwal</th>
            <th>Ruangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="sidangTable">
        <tr><td colspan="7">Loading...</td></tr>
    </tbody>
</table>

<script>
const token = localStorage.getItem("token");

axios.get('/api/admin/sidang', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    let html = "";

    res.data.data.forEach(item => {
        html += `
        <tr>
            <td>${item.mahasiswa?.name ?? '-'}</td>
            <td>${item.pembimbing?.name ?? '-'}</td>
            <td>${item.penguji?.name ?? '-'}</td>
            <td>${item.jadwal}</td>
            <td>${item.ruangan ?? '-'}</td>
            <td>${item.status}</td>
            <td>
                <a href="/admin/sidang/edit/${item.id}">Edit</a> |
                <a href="#" onclick="hapus(${item.id})">Delete</a>
            </td>
        </tr>
        `;
    });

    document.getElementById("sidangTable").innerHTML = html;
});

function hapus(id) {
    if (!confirm("Yakin ingin menghapus?")) return;

    axios.delete(`/api/admin/sidang/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
    }).then(() => {
        alert("Sidang berhasil dihapus");
        location.reload();
    });
}
</script>
@endsection
