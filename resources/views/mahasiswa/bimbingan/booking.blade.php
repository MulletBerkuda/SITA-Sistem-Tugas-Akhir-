@extends('layouts.app')

@section('title', 'Booking Bimbingan')

@section('content')
<h2>Booking Slot Bimbingan</h2>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Hari</th>
            <th>Waktu</th>
            <th>Dosen</th>
            <th>Kuota</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="slotTable">
        <tr><td colspan="5">Loading...</td></tr>
    </tbody>
</table>

<script>
const token = localStorage.getItem("token");

axios.get('/api/mahasiswa/slot-bimbingan', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {

    const slots = res.data.data ?? [];

    let html = "";

    slots.forEach(s => {
        html += `
        <tr>
            <td>${s.hari}</td>
            <td>${s.jam_mulai} - ${s.jam_selesai}</td>
            <td>${s.dosen?.name ?? '-'}</td>
            <td>${s.kuota}</td>
            <td>
                ${s.kuota > 0 
                    ? `<button onclick="booking(${s.id})" class="btn btn-primary">Pesan</button>`
                    : `<span class="badge bg-danger">Penuh</span>`
                }
            </td>
        </tr>`;
    });

    document.getElementById("slotTable").innerHTML = html;
});

function booking(slotId) {
    if (!confirm("Pesan slot ini?")) return;

    axios.post('/api/mahasiswa/booking-bimbingan', {
        slot_id: slotId
    }, {
        headers: { Authorization: `Bearer ${token}` }
    }).then(res => {
        alert("Booking berhasil!");
        window.location.href = "/mahasiswa/bimbingan/detail/" + res.data.bimbingan_id;
    });
}
</script>
@endsection
