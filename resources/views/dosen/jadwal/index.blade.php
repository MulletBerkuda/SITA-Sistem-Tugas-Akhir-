@extends('layouts.dosen')

@section('title','Jadwal Bimbingan')

@section('content')

<h2>Jadwal Bimbingan</h2>

<a href="/dosen/jadwal-bimbingan/create" class="btn btn-success mb-3">
    + Tambah Jadwal
</a>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Kuota</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="jadwal-data"></tbody>
</table>

<script>
const token = localStorage.getItem('token');

function loadJadwal() {
    axios.get('/api/dosen/jadwal-bimbingan', {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        let html = '';
        res.data.forEach(j => {
            html += `
                <tr>
                    <td>${j.hari}</td>
                    <td>${j.tanggal}</td>
                    <td>${j.jam_mulai} - ${j.jam_selesai}</td>
                    <td>${j.kuota}</td>
                    <td>
                        <button onclick="hapus(${j.id})" class="btn btn-danger">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
        });
        document.getElementById('jadwal-data').innerHTML = html;
    });
}

function hapus(id) {
    if (!confirm('Hapus jadwal ini?')) return;

    axios.delete(`/api/dosen/jadwal-bimbingan/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        alert(res.data.message);
        loadJadwal();
    })
    .catch(err => {
        alert(err.response?.data?.message ?? 'Gagal menghapus jadwal');
    });
}

loadJadwal();
</script>

@endsection
