@extends('layouts.admin')

@section('title', 'Detail Pengajuan Sidang')

@section('content')
<h2>Detail Pengajuan Sidang</h2>

<div id="detail"></div>

<button id="terima" class="btn btn-success">Terima Pengajuan</button>
<button id="tolak" class="btn btn-danger">Tolak Pengajuan</button>

<script>
const token = localStorage.getItem("token");
const pengajuanId = "{{ $id }}";

// TAMPIL DETAIL
axios.get(`/api/admin/pengajuan-sidang/${pengajuanId}`, {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    const p = res.data.data;

    document.getElementById("detail").innerHTML = `
        <p><b>Mahasiswa:</b> ${p.mahasiswa.name}</p>

        <p><b>TOEFL:</b> <a href="/storage/${p.berkas_toefl}" target="_blank">Lihat</a></p>
        <p><b>Sertifikat Seminar:</b> <a href="/storage/${p.berkas_sertifikat_seminar}" target="_blank">Lihat</a></p>
        <p><b>Bukti SKS:</b> <a href="/storage/${p.berkas_bukti_sks}" target="_blank">Lihat</a></p>

        <p><b>Status:</b> ${p.status}</p>
        <p><b>Catatan:</b> ${p.catatan ?? '-'}</p>
    `;

    // BUTTON TERIMA
    document.getElementById("terima").onclick = () => {
        axios.put(`/api/admin/pengajuan-sidang/${pengajuanId}/terima`, {}, {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => {

            const mahasiswaId = res.data.mahasiswa_id;

            alert("Pengajuan diterima! Mengarahkan ke form penjadwalan sidang...");

            window.location.href = `/admin/sidang/create?mahasiswa_id=${mahasiswaId}`;
        });
    };
});

// BUTTON TOLAK
document.getElementById("tolak").onclick = () => {
    const alasan = prompt("Masukkan alasan penolakan:");
    if (!alasan) return;

    axios.put(`/api/admin/pengajuan-sidang/${pengajuanId}/tolak`, {
        catatan: alasan
    }, {
        headers: { Authorization: `Bearer ${token}` }
    }).then(() => {
        alert("Pengajuan ditolak");
        location.reload();
    });
};
</script>

@endsection
