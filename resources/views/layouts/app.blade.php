<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SITA - @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<div class="layout-container">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>SITA</h2>
        </div>

        <ul class="sidebar-menu" id="sidebar-menu">
            {{-- Menu akan dimuat via JS sesuai role --}}
        </ul>

        <button id="logoutBtn" class="logout-btn">Logout</button>
    </aside>

    {{-- CONTENT --}}
    <main class="content">
        <header class="top-header">
            <div id="user-info">Loading...</div>
        </header>

        <section class="page-content">
            @yield('content')
        </section>
    </main>

</div>

<script>
document.addEventListener("DOMContentLoaded", async () => {

    const token = localStorage.getItem("token");
    if (!token) return window.location.href = "/login";

    try {
        const res = await axios.get("/api/me", {
            headers: { Authorization: `Bearer ${token}` }
        });

        const user = res.data;
        document.getElementById('user-info').innerHTML = `${user.name} (${user.role})`;

        const sidebar = document.getElementById("sidebar-menu");

        // ROLE ADMIN
        if (user.role === "admin") {
            sidebar.innerHTML = `
                <li><a href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/users">Manajemen User</a></li>
                <li><a href="/admin/bimbingan">Bimbingan</a></li>
                <li><a href="/admin/sidang">Sidang</a></li>
            `;
        }

        // ROLE DOSEN
        if (user.role === "dosen") {
            sidebar.innerHTML = `
                <li><a href="/dosen/dashboard">Dashboard</a></li>
                <li><a href="/dosen/bimbingan">Bimbingan</a></li>
                <li><a href="/dosen/sidang">Sidang</a></li>
            `;
        }

        // ROLE MAHASISWA (VERSI LENGKAP)
        if (user.role === "mahasiswa") {
            sidebar.innerHTML = `
                <li><a href="/mahasiswa/dashboard">Dashboard</a></li>
                <li><a href="/mahasiswa/pilih-pembimbing">Pilih Pembimbing</a></li>
                <li><a href="/mahasiswa/bimbingan">Bimbingan</a></li>
                <li><a href="/mahasiswa/bimbingan/booking">Booking Bimbingan</a></li>
                <li><a href="/mahasiswa/pengajuan-sidang">Sidang</a></li>
            `;
        }

    } catch (err) {
        localStorage.removeItem("token");
        window.location.href = "/login";
    }

    // LOGOUT
    document.getElementById("logoutBtn").addEventListener("click", () => {
        localStorage.removeItem("token");
        window.location.href = "/login";
    });

});
</script>

@yield('scripts')

</body>
</html>
