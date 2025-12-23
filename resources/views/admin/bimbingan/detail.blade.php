@extends('layouts.admin')

@section('title', 'Detail Bimbingan')

@section('content')
<h2>Detail Bimbingan</h2>

<div class="card mt-3 p-3">
    <p><strong>Mahasiswa:</strong> <span id="mahasiswa">Loading...</span></p>
    <p><strong>Dosen:</strong> <span id="dosen">Loading...</span></p>
    <p><strong>Tanggal:</strong> <span id="tanggal">Loading...</span></p>
    <p><strong>Waktu:</strong> <span id="waktu">Loading...</span></p>
    <p><strong>Status:</strong> <span id="status">Loading...</span></p>
    <p><strong>Topik:</strong> <span id="topik">Loading...</span></p>
    <p><strong>Catatan:</strong> <span id="catatan">Loading...</span></p>
</div>

<a href="/admin/bimbingan" class="btn btn-secondary mt-3">Kembali</a>

<script>
const token = localStorage.getItem("token");
const id = "{{ $id }}";

axios.get(`/api/admin/bimbingan/${id}`, {
    headers:{
        Authorization: `Bearer ${token}`
    }
})
.then(res => {
    const d = res.data.data;

    document.getElementById("mahasiswa").innerText = d.mahasiswa?.name ?? '-';
    document.getElementById("dosen").innerText = d.dosen?.name ?? '-';
    document.getElementById("tanggal").innerText = d.tanggal ?? '-';
    document.getElementById("waktu").innerText =
    (d.jadwal?.jam_mulai ?? '-') + " - " + (d.jadwal?.jam_selesai ?? '-');
    document.getElementById("status").innerText = d.status ?? '-';
    document.getElementById("topik").innerText = d.topik ?? '-';
    document.getElementById("catatan").innerText = d.catatan ?? '-';
})
.catch(err => {
    alert("Gagal mengambil data / tidak ada akses");
    console.error(err);
});
</script>
@endsection
