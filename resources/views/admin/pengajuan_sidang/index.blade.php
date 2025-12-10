@extends('layouts.admin')

@section('title', 'Pengajuan Sidang')

@section('content')
<h2>Pengajuan Sidang Mahasiswa</h2>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Mahasiswa</th>
            <th>TOEFL</th>
            <th>Sertifikat Seminar</th>
            <th>Bukti SKS</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="pengajuanTable">
        <tr><td colspan="6">Loading...</td></tr>
    </tbody>
</table>

<script>
const token = localStorage.getItem("token");

axios.get('/api/admin/pengajuan-sidang', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    let html = "";

    res.data.data.forEach(item => {
        html += `
        <tr>
            <td>${item.mahasiswa?.name ?? '-'}</td>
            <td><a href="/storage/${item.berkas_toefl}" target="_blank">Lihat</a></td>
            <td><a href="/storage/${item.berkas_sertifikat_seminar}" target="_blank">Lihat</a></td>
            <td><a href="/storage/${item.berkas_bukti_sks}" target="_blank">Lihat</a></td>
            <td>${item.status}</td>
            <td>
                <a href="/admin/pengajuan-sidang/${item.id}">Detail</a>
            </td>
        </tr>`;
    });

    document.getElementById("pengajuanTable").innerHTML = html;
});
</script>
@endsection
