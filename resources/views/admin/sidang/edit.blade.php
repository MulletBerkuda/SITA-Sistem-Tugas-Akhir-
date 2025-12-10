@extends('layouts.admin')

@section('title', 'Edit Sidang')

@section('content')
<h2>Edit Sidang</h2>

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

    <div class="mb-3">
        <label>Status</label>
        <select id="status" class="form-control">
            <option value="dijadwalkan">Dijadwalkan</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

<script>
const token = localStorage.getItem("token");
const sidangId = "{{ $id }}";

// Load Users (mahasiswa + dosen)
function loadUsers(selected) {
    axios.get('/api/admin/users/mahasiswa', {
        headers: { Authorization: `Bearer ${token}` }
    }).then(res => {
        let opt = "";
        res.data.forEach(m => {
            opt += `<option value="${m.id}" ${selected.mahasiswa_id == m.id ? 'selected' : ''}>${m.name}</option>`;
        });
        document.getElementById("mahasiswa_id").innerHTML = opt;
    });

    axios.get('/api/admin/users/dosen', {
        headers: { Authorization: `Bearer ${token}` }
    }).then(res => {
        let opts = "";
        res.data.forEach(d => {
            opts += `<option value="${d.id}" 
                      ${selected.pembimbing_id == d.id ? 'selected' : ''}>${d.name}</option>`;
        });
        document.getElementById("pembimbing_id").innerHTML = opts;

        let opts2 = "";
        res.data.forEach(d => {
            opts2 += `<option value="${d.id}" 
                      ${selected.penguji_id == d.id ? 'selected' : ''}>${d.name}</option>`;
        });
        document.getElementById("penguji_id").innerHTML = opts2;
    });
}

// LOAD DETAIL SIDANG
axios.get(`/api/admin/sidang/${sidangId}`, {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    const s = res.data.data;

    document.getElementById("jadwal").value = s.jadwal.replace(" ", "T");
    document.getElementById("ruangan").value = s.ruangan ?? "";
    document.getElementById("status").value = s.status;

    loadUsers(s); // load dropdown + select yang sesuai
});

// SUBMIT UPDATE
document.getElementById("formSidang").addEventListener("submit", function(e) {
    e.preventDefault();

    axios.put(`/api/admin/sidang/${sidangId}`, {
        mahasiswa_id: document.getElementById("mahasiswa_id").value,
        pembimbing_id: document.getElementById("pembimbing_id").value,
        penguji_id: document.getElementById("penguji_id").value,
        jadwal: document.getElementById("jadwal").value,
        ruangan: document.getElementById("ruangan").value,
        status: document.getElementById("status").value,
    }, {
        headers: { Authorization: `Bearer ${token}` }
    }).then(() => {
        alert("Sidang berhasil diperbarui");
        window.location.href = "/admin/sidang";
    });
});
</script>

@endsection
