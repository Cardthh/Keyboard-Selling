<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun - KeyboardStore</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

<div class="auth-container">
  <h2>Daftar Akun</h2>

  <form onsubmit="register(event)">
    <input type="text" id="username" placeholder="Username" required>
    <input type="password" id="password" placeholder="Password" required>
    <button type="submit">Daftar</button>
  </form>

  <p class="text-center">Sudah punya akun? <a href="login.php">Login</a></p>
</div>

<script>
function register(e) {
  e.preventDefault();

  fetch('api/auth/register.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      username: document.getElementById('username').value,
      password: document.getElementById('password').value
    })
  })
  .then(res => res.json())
  .then(d => alert(d.message || d.error));
}
</script>

</body>
</html>
