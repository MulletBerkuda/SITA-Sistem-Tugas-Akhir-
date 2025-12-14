@extends('layouts.dosen')

@section('title','Tambah Jadwal Bimbingan')

@section('content')

<a href="/dosen/jadwal-bimbingan" class="btn btn-secondary mb-3">
    ← Kembali
</a>

<h2>Tambah Jadwal Bimbingan</h2>

<form id="form-jadwal">
    <div>
        <label>Hari</label>
        <input type="text" id="hari" required>
    </div>

    <div>
        <label>Tanggal</label>
        <input type="date" id="tanggal" required>
    </div>

    <div>
        <label>Jam Mulai</label>
        <input type="time" id="jam_mulai" required>
    </div>

    <div>
        <label>Jam Selesai</label>
        <input type="time" id="jam_selesai" required>
    </div>

    <div>
        <label>Kuota</label>
        <input type="number" id="kuota" min="1" required>
    </div>

    <br>
    <button type="submit" class="btn btn-success">Simpan Jadwal</button>
</form>

<script>
const token = localStorage.getItem('token');

document.getElementById('form-jadwal').addEventListener('submit', function(e) {
    e.preventDefault();

    axios.post('/api/dosen/jadwal-bimbingan', {
        hari: document.getElementById('hari').value,
        tanggal: document.getElementById('tanggal').value,
        jam_mulai: document.getElementById('jam_mulai').value,
        jam_selesai: document.getElementById('jam_selesai').value,
        kuota: document.getElementById('kuota').value
    }, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        alert('Jadwal berhasil ditambahkan');
        window.location.href = '/dosen/jadwal-bimbingan';
    })
    .catch(err => {
        alert(err.response?.data?.message ?? 'Gagal menambah jadwal');
    });
});
</script>

@endsection
