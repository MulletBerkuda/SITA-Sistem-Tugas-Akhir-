<!DOCTYPE html>
<html>
<head>
    <title> SITA</title>
</head>
<body>
<h2>Dashboard</h2>


<div id="userInfo">Loading...</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
 const token = localStorage.getItem("token");

if (!token) {
    window.location.href = "/login";
}

axios.get('/api/me', {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => {
    console.log(res.data);
    if (res.data.role !== 'admin') {
        window.location.href = "/login";
    }
})
.catch(err => {
    localStorage.removeItem("token");
    window.location.href = "/login";
});

</script>



</body>
</html>
