@extends('layouts.mahasiswa')

@section('title', 'Detail Pengajuan Sidang')

@section('content')

<h2>Detail Pengajuan Sidang</h2>

<table class="table" id="detailTable">
    <tbody>
        <tr><td>Loading...</td></tr>
    </tbody>
</table>

<a href="/mahasiswa/pengajuan-sidang" class="btn btn-secondary mt-3">Kembali</a>

<script>
const token = localStorage.getItem("token");
const id = "{{ $id }}";

axios.get('/api/mahasiswa/pengajuan-sidang/' + id, {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    const data = res.data.data ?? res.data;

    document.querySelector("#detailTable tbody").innerHTML = `
        <tr>
            <th>Tanggal Ajukan</th>
            <td>${data.created_at}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge bg-${data.status === 'pending' ? 'warning' : (data.status === 'diterima' ? 'success' : 'danger')}">
                    ${data.status}
                </span>
            </td>
        </tr>
        <tr>
            <th>Catatan</th>
            <td>${data.catatan ?? '-'}</td>
        </tr>
        <tr>
            <th>Berkas TOEFL</th>
            <td><a href="/storage/${data.berkas_toefl}" target="_blank">Lihat</a></td>
        </tr>
        <tr>
            <th>Sertifikat Seminar</th>
            <td><a href="/storage/${data.berkas_sertifikat_seminar}" target="_blank">Lihat</a></td>
        </tr>
        <tr>
            <th>Bukti SKS</th>
            <td><a href="/storage/${data.berkas_bukti_sks}" target="_blank">Lihat</a></td>
        </tr>
    `;
});
</script>

@endsection
