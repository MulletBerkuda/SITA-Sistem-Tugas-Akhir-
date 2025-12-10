@extends('layouts.app')

@section('title', 'Edit Bimbingan')

@section('content')

<h2>Edit Bimbingan</h2>

<form id="editForm">

    <label for="mahasiswa_id">Mahasiswa</label>
    <select id="mahasiswa_id" required></select>

    <label for="dosen_id">Dosen Pembimbing</label>
    <select id="dosen_id" required></select>

    <label for="tanggal">Tanggal</label>
    <input type="datetime-local" id="tanggal">

    <label for="catatan">Catatan</label>
    <textarea id="catatan"></textarea>

    <label for="status">Status</label>
    <select id="status" required>
        <option value="pending">Pending</option>
        <option value="disetujui">Disetujui</option>
        <option value="ditolak">Ditolak</option>
    </select>

    <button type="submit">Update</button>

</form>

<p id="msg"></p>

@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', async () => {

    const token = localStorage.getItem("token");
    const headers = { Authorization: `Bearer ${token}` };

    const id = window.location.pathname.split('/').pop(); // ambil ID dari URL

    // === Load Mahasiswa ===
    axios.get('/api/admin/users/mahasiswa', { headers }).then(res => {
        const select = document.getElementById('mahasiswa_id');
        select.innerHTML = '<option value="">-- Pilih Mahasiswa --</option>';

        res.data.forEach(m =>
            select.innerHTML += `<option value="${m.id}">${m.name}</option>`
        );
    });

    // === Load Dosen ===
    axios.get('/api/admin/users/dosen', { headers }).then(res => {
        const select = document.getElementById('dosen_id');
        select.innerHTML = '<option value="">-- Pilih Dosen --</option>';

        res.data.forEach(d =>
            select.innerHTML += `<option value="${d.id}">${d.name}</option>`
        );
    });

    // === Load Data Lama ===
    const old = await axios.get(`/api/admin/bimbingan/${id}`, { headers });
    const data = old.data;

    document.getElementById('mahasiswa_id').value = data.mahasiswa_id;
    document.getElementById('dosen_id').value = data.dosen_id;
    document.getElementById('tanggal').value = data.tanggal.replace(' ', 'T');
    document.getElementById('catatan').value = data.catatan;
    document.getElementById('status').value = data.status;

    // === Submit Update ===
    document.getElementById("editForm").addEventListener("submit", function(e){
        e.preventDefault();

        axios.put(`/api/admin/bimbingan/${id}`, {
            mahasiswa_id: document.getElementById('mahasiswa_id').value,
            dosen_id: document.getElementById('dosen_id').value,
            tanggal: document.getElementById('tanggal').value,
            catatan: document.getElementById('catatan').value,
            status: document.getElementById('status').value
        }, { headers })
        .then(res => {
            document.getElementById('msg').innerText = "Berhasil update bimbingan!";
            setTimeout(() => window.location.href = "/admin/bimbingan", 1200);
        })
        .catch(err => {
            document.getElementById('msg').innerText = "Gagal update bimbingan";
        });

    });

});
</script>
@endsection
