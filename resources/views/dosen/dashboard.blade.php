@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@section('content')

<h2>Dashboard Dosen</h2>
<div id="dashboard"></div>

<script>
const token = localStorage.getItem("token");

axios.get('/api/dosen/dashboard', {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    const d = res.data;

    let html = `
        <h3>Bimbingan</h3>
        <p>Booking menunggu: ${d.booking.menunggu}</p>
        <p>Bimbingan aktif: ${d.bimbingan.aktif}</p>
        <p>Bimbingan selesai: ${d.bimbingan.selesai}</p>
    `;

    if (d.booking.last) {
        html += `
            <hr>
            <h3>Booking Terbaru</h3>
            <p>Mahasiswa: ${d.booking.last.mahasiswa.name}</p>
            <p>Tanggal: ${d.booking.last.tanggal}</p>
            <p>Status: ${d.booking.last.status}</p>
            <a href="/dosen/booking-bimbingan/${d.booking.last.id}" class="btn btn-primary">
                Lihat Detail
            </a>
        `;
    }

    html += `<hr><h3>Jadwal Bimbingan Saya</h3>`;

    d.jadwal_bimbingan.forEach(j => {
        html += `
            <p>${j.hari}, ${j.jam_mulai} - ${j.jam_selesai} (Kuota: ${j.kuota})</p>
            <hr>
        `;
    });

    html += `
        <h3>Sidang</h3>
        <p>Sebagai Pembimbing: ${d.sidang.pembimbing}</p>
        <p>Sebagai Penguji: ${d.sidang.penguji}</p>
    `;

    document.getElementById("dashboard").innerHTML = html;
});
</script>

@endsection
