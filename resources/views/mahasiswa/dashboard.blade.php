@extends('layouts.mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<h2>Dashboard Mahasiswa</h2>

<div id="dashboard"></div>

<script>
const token = localStorage.getItem("token");

axios.get('/api/mahasiswa/dashboard', {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    const d = res.data;

    let html = `
        <h3>Bimbingan</h3>
        <p>Total selesai: ${d.bimbingan.selesai}</p>
        <p>Total pending: ${d.bimbingan.pending}</p>
        <p>Bimbingan terakhir: ${d.bimbingan.last ? d.bimbingan.last.tanggal : '-'}</p>

        <hr>

        <h3>Status Pengajuan Sidang</h3>
    `;

    if (!d.pengajuan_sidang) {
        html += `<p>Belum ada pengajuan</p>
                 <a href="/mahasiswa/pengajuan-sidang" class="btn btn-primary">Ajukan Sidang</a>`;
    } else {
        html += `<p>Status: ${d.pengajuan_sidang.status}</p>`;
    }

    html += `<hr><h3>Jadwal Sidang</h3>`;

    if (!d.jadwal_sidang) {
        html += `<p>Belum dijadwalkan</p>`;
    } else {
        html += `
            <p>Tanggal: ${d.jadwal_sidang.jadwal}</p>
            <p>Ruangan: ${d.jadwal_sidang.ruangan}</p>
            <p>Pembimbing: ${d.jadwal_sidang.pembimbing.name}</p>
            <p>Penguji: ${d.jadwal_sidang.penguji.name}</p>
        `;
    }

    html += `<hr><h3>Jadwal Bimbingan Dosen</h3>`;

    d.jadwal_bimbingan_dosen.forEach(j => {
        html += `
            <p>${j.hari}, ${j.jam_mulai} - ${j.jam_selesai} (Kuota: ${j.kuota})</p>
            <a href="/mahasiswa/bimbingan/booking/${j.id}" class="btn btn-success">Booking Slot</a>
            <hr>
        `;
    });

    document.getElementById("dashboard").innerHTML = html;
});
</script>

@endsection
