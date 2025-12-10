@extends('layouts.mahasiswa')

@section('title', 'Ajukan Sidang')

@section('content')

<h2>Ajukan Sidang</h2>

<form id="formSidang" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Berkas TOEFL</label>
        <input type="file" name="berkas_toefl" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Sertifikat Seminar</label>
        <input type="file" name="berkas_sertifikat_seminar" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Bukti SKS</label>
        <input type="file" name="berkas_bukti_sks" class="form-control" required>
    </div>

    <button class="btn btn-primary" type="submit">Kirim Pengajuan</button>
</form>

<a href="/mahasiswa/pengajuan-sidang" class="btn btn-secondary mt-3">Kembali</a>

<script>
const token = localStorage.getItem("token");

document.getElementById("formSidang").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);

    axios.post('/api/mahasiswa/pengajuan-sidang', formData, {
        headers: {
            Authorization: `Bearer ${token}`,
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(res => {
        alert("Pengajuan sidang berhasil dikirim!");
        window.location.href = "/mahasiswa/pengajuan-sidang";
    })
    .catch(err => {
        alert("Gagal mengirim pengajuan");
        console.error(err);
    });
});
</script>

@endsection
