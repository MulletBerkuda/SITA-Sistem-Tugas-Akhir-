@extends('layouts.admin')

@section('title', 'Tambah Sidang')

@section('content')
<h2>Tambah Sidang</h2>

<form id="formSidang">
    <div class="mb-3">
        <label>Mahasiswa</label>
        <select id="mahasiswa_id" class="form-control"></select>
    </div>

    <div class="mb-3">
        <label>Pembimbing</label>
        <select id="pembimbing_id" class="form-control"></select>
    </div>

    <div class="mb-3">
        <label>Penguji</label>
        <select id="penguji_id" class="form-control"></select>
    </div>

    <div class="mb-3">
        <label>Jadwal</label>
        <input type="datetime-local" id="jadwal" class="form-control">
    </div>

    <div class="mb-3">
        <label>Ruangan</label>
        <input type="text" id="ruangan" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<script>
    const urlParams = new URLSearchParams(window.location.search);
const selectedMahasiswaId = urlParams.get('mahasiswa_id');

const token = localStorage.getItem("token");

// ============ LOAD USER ==============
function loadUsers() {
    // === Load Mahasiswa (dengan auto-select dari URL) ===
    axios.get('/api/admin/users/mahasiswa', {
        headers: { Authorization: `Bearer ${token}` }
    }).then(res => {
        let opt = "";
        res.data.forEach(m => {
            opt += `<option value="${m.id}" ${selectedMahasiswaId == m.id ? 'selected' : ''}>${m.name}</option>`;
        });
        document.getElementById("mahasiswa_id").innerHTML = opt;
    });

    // === Load Dosen ===
    axios.get('/api/admin/users/dosen', {
        headers: { Authorization: `Bearer ${token}` }
    }).then(res => {
        let opts = "";
        res.data.forEach(d => {
            opts += `<option value="${d.id}">${d.name}</option>`;
        });

        document.getElementById("pembimbing_id").innerHTML = opts;
        document.getElementById("penguji_id").innerHTML = opts;
    });
}


loadUsers();

// ============ SUBMIT FORM ==============
document.getElementById("formSidang").addEventListener("submit", function(e) {
    e.preventDefault();

    axios.post('/api/admin/sidang', {
        mahasiswa_id: document.getElementById("mahasiswa_id").value,
        pembimbing_id: document.getElementById("pembimbing_id").value,
        penguji_id: document.getElementById("penguji_id").value,
        jadwal: document.getElementById("jadwal").value,
        ruangan: document.getElementById("ruangan").value
    }, {
        headers: { Authorization: `Bearer ${token}` }
    }).then(() => {
        alert("Sidang berhasil dibuat");
        window.location.href = "/admin/sidang";
    });
});
</script>
@endsection
