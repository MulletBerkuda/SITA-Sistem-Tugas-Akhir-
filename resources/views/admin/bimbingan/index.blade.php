@extends('layouts.admin')

@section('title', 'Monitoring Bimbingan')

@section('content')
<h2>Monitoring Bimbingan</h2>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Mahasiswa</th>
            <th>Dosen</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="bimbinganTable">
        <tr><td colspan="6">Loading...</td></tr>
    </tbody>
</table>

<script>
const token = localStorage.getItem("token");

axios.get('/api/admin/bimbingan', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    let html = "";

    res.data.data.forEach(b => {
        html += `
            <tr>
                <td>${b.mahasiswa?.name ?? '-'}</td>
                <td>${b.dosen?.name ?? '-'}</td>
                <td>${b.tanggal}</td>
                <td>${b.waktu_mulai ?? '-'} - ${b.waktu_selesai ?? '-'}</td>
                <td>${b.status}</td>
                <td><a href="/admin/bimbingan/${b.id}">Detail</a></td>
            </tr>
        `;
    });

    document.getElementById("bimbinganTable").innerHTML = html;
});
</script>
@endsection
