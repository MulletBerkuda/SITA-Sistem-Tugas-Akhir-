@extends('layouts.dosen')

@section('title','Detail Booking Bimbingan')

@section('content')
<a href="/dosen/booking-bimbingan" class="btn btn-secondary mb-3">
    ← Kembali
</a>

<h2>Detail Booking Bimbingan</h2>

<div id="detail-booking">Loading...</div>

<hr>

<h3>Catatan Dosen</h3>
<textarea id="catatan_dosen" rows="4" style="width:100%" placeholder="Isi catatan untuk mahasiswa..."></textarea>

<br><br>

<button id="btn-acc" class="btn btn-success">ACC</button>
<button id="btn-tolak" class="btn btn-danger">Tolak</button>

<script>
const token = localStorage.getItem('token');
const bookingId = window.location.pathname.split('/').pop();

const btnAcc   = document.getElementById('btn-acc');
const btnTolak = document.getElementById('btn-tolak');

function disableButtons() {
    btnAcc.disabled = true;
    btnTolak.disabled = true;
}

function loadDetail() {
    axios.get(`/api/dosen/booking-bimbingan/${bookingId}`, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        const b = res.data;

        let html = `
            <p><b>Mahasiswa:</b> ${b.mahasiswa.name}</p>
            <p><b>Tanggal:</b> ${b.tanggal}</p>
            <p><b>Waktu:</b> ${b.jadwal?.jam_mulai ?? '-'} - ${b.jadwal?.jam_selesai ?? '-'}</p>
            <p><b>Status:</b> <span style="font-weight:bold">${b.status}</span></p>
            <p><b>Catatan Mahasiswa:</b><br>${b.catatan_mahasiswa ?? '-'}</p>
        `;

        document.getElementById('detail-booking').innerHTML = html;

        // 🔐 Disable tombol kalau bukan status menunggu
        if (b.status !== 'menunggu') {
            disableButtons();
            document.getElementById('catatan_dosen').disabled = true;
        }
    })
    .catch(err => {
        alert('Gagal memuat data booking');
        console.error(err);
    });
}

// ===================
// ACTION DOSEN
// ===================

btnAcc.addEventListener('click', function () {
    if (!confirm('Yakin ACC booking bimbingan ini?')) return;

    axios.post(`/api/dosen/booking-bimbingan/${bookingId}/acc`, {
        catatan_dosen: document.getElementById('catatan_dosen').value
    }, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        alert(res.data.message);
        window.location.href = '/dosen/booking-bimbingan';
    })
    .catch(err => {
        alert(err.response?.data?.message ?? 'Gagal ACC booking');
    });
});

btnTolak.addEventListener('click', function () {
    if (!confirm('Yakin menolak booking bimbingan ini?')) return;

    axios.post(`/api/dosen/booking-bimbingan/${bookingId}/tolak`, {
        catatan_dosen: document.getElementById('catatan_dosen').value
    }, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        alert(res.data.message);
        window.location.href = '/dosen/booking-bimbingan';
    })
    .catch(err => {
        alert(err.response?.data?.message ?? 'Gagal menolak booking');
    });
});

// Load awal
loadDetail();
</script>

@endsection
