@extends('layouts.mahasiswa')

@section('title', 'Pengajuan Sidang')

@section('content')

<h2>Pengajuan Sidang</h2>

<a href="/mahasiswa/pengajuan-sidang/create" class="btn btn-primary mb-3">
    + Ajukan Sidang
</a>

<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="sidangTable">
        <tr>
            <td colspan="4">Loading...</td>
        </tr>
    </tbody>
</table>

<script>
const token = localStorage.getItem("token");

axios.get('/api/mahasiswa/pengajuan-sidang', {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    const list = res.data.data ?? res.data ?? [];

    let html = "";

    if (list.length === 0) {
        html = `<tr><td colspan='4'>Belum ada pengajuan.</td></tr>`;
    }

    list.forEach(item => {
        html += `
        <tr>
           <td>${ new Date(item.created_at).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
}) }</td>
            <td>
                <span class="badge bg-${item.status === 'pending' ? 'warning' : (item.status === 'diterima' ? 'success' : 'danger')}">
                    ${item.status}
                </span>
            </td>
            <td>${item.catatan ?? '-'}</td>
            <td>
                <a href="/mahasiswa/pengajuan-sidang/detail/${item.id}" class="btn btn-info btn-sm">Detail</a>
            </td>
        </tr>
        `;
    });

    document.getElementById("sidangTable").innerHTML = html;
});
</script>

@endsection
