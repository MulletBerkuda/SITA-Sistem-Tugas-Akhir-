<!DOCTYPE html>
<html>
<head>
    <title>Login SITA</title>
    @vite(['resources/css/login.css', 'resources/js/app.js'])
</head>

<body>

<div class="login-container">
    <h2>LOGIN SITA</h2>

    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p id="error"></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    axios.post('/api/login', {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    })
    .then(res => {
    const token = res.data.token;

    localStorage.setItem("token", token);

    const role = res.data.user.role;

    if (role === 'admin') {
        window.location.href = "/admin/dashboard";
    } else if (role === 'dosen') {
        window.location.href = "/dosen/dashboard";
    } else {
        window.location.href = "/mahasiswa/dashboard";
    }
})

    .catch(() => {
        document.getElementById("error").innerText = "Email atau password salah!";
    });
});
</script>

</body>
</html>
