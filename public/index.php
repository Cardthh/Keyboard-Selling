<?php
session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['login_token'])) {
    if (
        isset($_SESSION['login_token'], $_SESSION['login_expire']) &&
        $_COOKIE['login_token'] === $_SESSION['login_token'] &&
        time() < $_SESSION['login_expire']
    ) {
        // session masih valid → lanjut
    } else {
        // token kadaluarsa
        setcookie('login_token', '', time() - 300, '/');
        session_destroy();
        header("Location: login.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keyboard Store | Home</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- 🔹 NAVBAR -->
  <header class="navbar">
    <div class="logo">Keyboard<span>Store</span></div>
   <nav>
  <a href="index.php">Beranda</a>
  <a href="produk.php">Produk</a>
  <a href="contact.php">Kontak</a>
  <a href="cart.php" class="cart-btn">🛒 Keranjang</a>

  <?php if (isset($_SESSION['user_id'])): ?>
      <a href="logout.php" class="logout-btn">Logout (<?= htmlspecialchars($_SESSION['username']); ?>)</a>
  <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
  <?php endif; ?>
</nav>

  </header>

  <!--SECTION -->
  <section class="hero">
    <div class="hero-text">
      <h1>Temukan Keyboard Impianmu</h1>
      <p>Keyboard mekanik dan wireless terbaik untuk gaming maupun produktivitas.</p>
      <a href="produk.php" class="btn-primary">Belanja Sekarang</a>
    </div>
    <div class="hero-img">
      <img src="assets/images/keyboard-banner.png" alt="Keyboard">
    </div>
  </section>

  <!-- FEATURE SECTION -->
  <section class="features">
    <div class="feature-card">
      <img src="assets/images/mechanical.png" alt="Mechanical">
      <h3>Mechanical Switch</h3>
      <p>Respons cepat dan tactile untuk pengalaman mengetik terbaik.</p>
    </div>
    <div class="feature-card">
      <img src="assets/images/wireless.png" alt="Wireless">
      <h3>Wireless</h3>
      <p>Tanpa kabel, tetap stabil dengan koneksi cepat.</p>
    </div>
    <div class="feature-card">
      <img src="assets/images/lighting.png" alt="RGB">
      <h3>RGB Lighting</h3>
      <p>Sesuaikan warna lampu sesukamu dengan berbagai mode efek.</p>
    </div>
  </section>

  <!--  FOOTER -->
  <footer class="footer">
  <div class="footer-container">

    <div class="footer-column">
      <h3>KeyboardStore</h3>
      <p>Menjual berbagai macam keyboard berkualitas tinggi. Nikmati pengalaman belanja online yang nyaman dan aman.</p>
    </div>

    <div class="footer-column">
      <h3>Link Cepat</h3>
      <ul>
        <li><a href="index.php">Beranda</a></li>
        <li><a href="produk.php">Produk</a></li>
        <li><a href="contact.php">Kontak</a></li>
        <li><a href="cart.php">Keranjang</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Kontak</h3>
      <p>Email: support@keyboardstore.com</p>
      <p>Telp: +62 812 3456 7890</p>
      <div class="social-icons">
        <a href="#"><img src="assets/icons/facebook.svg" alt="Facebook"></a>
        <a href="#"><img src="assets/icons/instagram.svg" alt="Instagram"></a>
        <a href="#"><img src="assets/icons/twitter.svg" alt="Twitter"></a>
      </div>
    </div>

  </div>

  <script src="assets/js/app.js"></script>
</body>
</html>
