@extends('layouts.dosen')

@section('title','Booking Bimbingan')

@section('content')

<h2>Booking Bimbingan Masuk</h2>

<table border="1" width="100%" cellpadding="8">
    <thead>
        <tr>
            <th>Mahasiswa</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="booking-data"></tbody>
</table>

<script>
const token = localStorage.getItem('token');

axios.get('/api/dosen/booking-bimbingan', {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    let html = '';

    res.data.forEach(item => {
        html += `
            <tr>
                <td>${item.mahasiswa.name}</td>
                <td>${item.tanggal}</td>
                <td>${item.jadwal?.jam_mulai ?? '-'} - ${item.jadwal?.jam_selesai ?? '-'}</td>
                <td>${item.status}</td>
                <td>
                    <a href="/dosen/booking-bimbingan/${item.id}" class="btn btn-primary">Detail</a>
                </td>
            </tr>
        `;
    });

    document.getElementById('booking-data').innerHTML = html;
});

</script>

@endsection
