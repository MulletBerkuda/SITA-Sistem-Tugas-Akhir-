@extends('layouts.app')

@section('content')

<div class="layout">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="brand">SITA</div>
        
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/users">Manajemen User</a>
        <a href="/admin/bimbingan">Bimbingan</a>
        <a href="/admin/sidang">Sidang</a>
         <a href="/admin/pengajuan-sidang">pengajuan Sidang</a>

        <div class="logout-btn" onclick="logout()">Logout</div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="main-content">

        <h1>Dashboard Admin</h1>

        {{-- CARDS --}}
        <div class="cards">
            <div class="card">
                <h3>Total Pengguna</h3>
                <div class="value" id="total-users">Loading...</div>
            </div>

            <div class="card">
                <h3>Total Bimbingan</h3>
                <div class="value" id="total-bimbingan">Loading...</div>
            </div>

            <div class="card">
                <h3>Total Sidang</h3>
                <div class="value" id="total-sidang">Loading...</div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="table-box">
            <h3>Aktivitas Terbaru</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody id="recent-activity">
                    <tr><td colspan="3">Loading...</td></tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
function logout() {
    localStorage.removeItem("token");
    window.location.href = "/login";
}

const token = localStorage.getItem("token");

// Jika tidak ada token → kembali login
if (!token) {
    window.location.href = "/login";
}

// Total Pengguna
axios.get('/api/admin/total-users', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    document.getElementById("total-users").innerText = res.data.total;
});

// Total Bimbingan
axios.get('/api/admin/total-bimbingan', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    document.getElementById("total-bimbingan").innerText = res.data.total;
});

// Total Sidang
axios.get('/api/admin/total-sidang', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    document.getElementById("total-sidang").innerText = res.data.total;
});

// Aktivitas Terbaru
axios.get('/api/admin/activity', {
    headers: { Authorization: `Bearer ${token}` }
}).then(res => {
    const tbody = document.getElementById("recent-activity");
    tbody.innerHTML = "";

    res.data.forEach(item => {
        tbody.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>${item.kegiatan}</td>
                <td>${item.tanggal}</td>
            </tr>
        `;
    });
});
</script>


@endsection
