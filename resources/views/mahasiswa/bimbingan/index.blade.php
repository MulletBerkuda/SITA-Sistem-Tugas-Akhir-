@extends('layouts.mahasiswa')

@section('title', 'Bimbingan Saya')

@section('content')
<h2>Bimbingan Saya</h2>
<a href="/mahasiswa/bimbingan/booking" class="btn btn-primary mb-3">
    + Booking Bimbingan
</a>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Dosen</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="bimbinganTable">
        <tr><td colspan="5">Loading...</td></tr>
    </tbody>
</table>

<a href="/mahasiswa/dashboard" class="btn btn-secondary mt-3">Kembali</a>

<script>
const token = localStorage.getItem("token");

axios.get('/api/mahasiswa/bimbingan', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    let html = "";

    // FIX AMAN
    const list = res.data.data ?? res.data ?? [];

    list.forEach(item => {
        html += `
        <tr>
            <td>${item.tanggal}</td>
            <td>${item.dosen?.name ?? '-'}</td>
           <td>${item.jadwal?.jam_mulai ?? '-'} - ${item.jadwal?.jam_selesai ?? '-'}</td>
            <td>${item.status}</td>
            <td><a href="/mahasiswa/bimbingan/detail/${item.id}">Detail</a></td>
        </tr>
        `;
    });

    document.getElementById("bimbinganTable").innerHTML = html;
});

</script>

@endsection
