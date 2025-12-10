@extends('layouts.app')

@section('title', 'Pilih Dosen Pembimbing')

@section('content')
<h2>Pilih Dosen Pembimbing</h2>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Nama Dosen</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody id="dosenTable">
        <tr><td colspan="2">Loading...</td></tr>
    </tbody>
</table>

<script>
const token = localStorage.getItem("token");

// Load list dosen (khusus mahasiswa)
axios.get('/api/mahasiswa/dosen', {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    let html = "";
    res.data.forEach(d => {
        html += `
        <tr>
            <td>${d.name}</td>
            <td><button class="btn btn-primary" onclick="pilih(${d.id})">Pilih</button></td>
        </tr>`;
    });

    document.getElementById("dosenTable").innerHTML = html;
});
        
function pilih(dosenId) {
    if (!confirm("Yakin memilih dosen ini sebagai pembimbing?")) return;

    axios.put('/api/mahasiswa/set-pembimbing', {
        dosen_id: dosenId
    }, {
        headers: { Authorization: `Bearer ${token}` }
    }).then(() => {
        alert("Pembimbing berhasil diatur!");
        window.location.href = "/mahasiswa/bimbingan";
    });
}
</script>


@endsection
