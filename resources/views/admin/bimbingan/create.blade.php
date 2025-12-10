@extends('layouts.admin')

@section('title', 'Create Bimbingan')

@section('content')

<h2>Create Bimbingan</h2>

<form id="createForm">

    <!-- Mahasiswa -->
    <div class="form-group">
        <label for="mahasiswa_id">Mahasiswa</label>
        <select id="mahasiswa_id" class="form-control" required>
            <option value="">Loading...</option>
        </select>
    </div>

    <!-- Dosen -->
    <div class="form-group">
        <label for="dosen_id">Dosen Pembimbing</label>
        <select id="dosen_id" class="form-control" required>
            <option value="">Loading...</option>
        </select>
    </div>

    <!-- Tanggal -->
    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="datetime-local" id="tanggal" class="form-control">
    </div>

    <!-- Catatan -->
    <div class="form-group">
        <label for="catatan">Catatan</label>
        <textarea id="catatan" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>

</form>

<p id="msg" style="margin-top: 10px; color: green;"></p>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {

    const token = localStorage.getItem("token");
    const headers = { Authorization: `Bearer ${token}` };

    // === Load Mahasiswa ===
axios.get('/api/admin/users/mahasiswa', { headers })
    .then(res => {
        console.log("Mahasiswa Response:", res.data);
        const select = document.getElementById('mahasiswa_id');
        select.innerHTML = '<option value="">-- Pilih Mahasiswa --</option>';

        res.data.forEach(m =>
            select.innerHTML += `<option value="${m.id}">${m.name}</option>`
        );
    })
    .catch(err => {
        console.error("Mahasiswa ERROR:", err.response);
    });
    
    // === Load Dosen ===
   axios.get('/api/admin/users/dosen', { headers })
    .then(res => {
        console.log("Dosen Response:", res.data);
        const select = document.getElementById('dosen_id');
        select.innerHTML = '<option value="">-- Pilih Dosen --</option>';

        res.data.forEach(d =>
            select.innerHTML += `<option value="${d.id}">${d.name}</option>`
        );
    })
    .catch(err => {
        console.error("Dosen ERROR:", err.response);
    });

    // === Submit Form ===
    document.getElementById("createForm").addEventListener("submit", function(e) {
        e.preventDefault();

        axios.post('/api/admin/bimbingan', {
            mahasiswa_id: document.getElementById('mahasiswa_id').value,
            dosen_id: document.getElementById('dosen_id').value,
            tanggal: document.getElementById('tanggal').value,
            catatan: document.getElementById('catatan').value
        }, { headers })
        .then(res => {
            document.getElementById('msg').style.color = "green";
            document.getElementById('msg').innerText = "Berhasil menambahkan bimbingan!";
            setTimeout(() => window.location.href = "/admin/bimbingan", 1200);
        })
        .catch(err => {
            document.getElementById('msg').style.color = "red";
            document.getElementById('msg').innerText = "Gagal membuat bimbingan";
        });
    });

});
</script>
@endsection
