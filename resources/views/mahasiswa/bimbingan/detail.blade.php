@extends('layouts.app')

@section('title', 'Detail Bimbingan')

@section('content')

<h2>Detail Bimbingan</h2>

<table class="table mt-3" id="detailTable">
    <tbody>
        <tr><td>Loading...</td></tr>
    </tbody>
</table>

<a href="/mahasiswa/bimbingan" class="btn btn-secondary mt-3">Kembali</a>

<script>
const token = localStorage.getItem("token");
const id = "{{ $id }}";

// --- Fetch data bimbingan ---
axios.get('/api/mahasiswa/bimbingan', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {

    // Format API aman: bisa array atau {data: []}
    const list = res.data.data ?? res.data ?? [];

    const data = list.find(x => x.id == id);

    const tbody = document.querySelector("#detailTable tbody");

    if (!data) {
        tbody.innerHTML = `
            <tr>
                <td>Data bimbingan tidak ditemukan.</td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = `
        <tr>
            <th style="width:200px;">Dosen</th>
            <td>${data.dosen?.name ?? '-'}</td>
        </tr>

        <tr>
            <th>Tanggal</th>
            <td>${data.tanggal}</td>
        </tr>

        <tr>
            <th>Waktu</th>
           <td>${data.jadwal?.jam_mulai ?? '-'} - ${data.jadwal?.jam_selesai ?? '-'}</td>

        </tr>

        <tr>
            <th>Status</th>
            <td>${data.status}</td>
        </tr>

        <tr>
            <th>Catatan Anda</th>
            <td>${data.catatan_mahasiswa ?? '-'}</td>
        </tr>

        <tr>
            <th>Catatan Dosen</th>
            <td>${data.catatan_dosen ?? '-'}</td>
        </tr>
    `;
});
</script>

@endsection
