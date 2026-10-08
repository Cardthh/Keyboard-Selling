<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - KeyboardStore</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="auth-container">
  <h2>Login Akun</h2>

  <form onsubmit="login(event)">
    <input type="text" id="username" placeholder="Username" required>
    <input type="password" id="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>

  <p class="text-center">Belum punya akun? <a href="register.php">Daftar</a></p>
</div>

<script>
function login(e) {
  e.preventDefault();

  fetch('api/auth/login.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      username: document.getElementById('username').value,
      password: document.getElementById('password').value
    })
  })
  .then(res => res.json())
  .then(d => {

    if (d.error) {
      alert(d.error);
      return;
    }

    alert(d.message);

    
    if (d.role === 'admin') {
      window.location.href = '/penjualan_keyboard/public/admin/dashboard.php';
    } else {
      window.location.href = '/penjualan_keyboard/public/index.php';
    }

  })
  .catch(err => {
    alert('Terjadi kesalahan server');
    console.error(err);
  });
}
</script>


</body>
</html>
