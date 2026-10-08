<?php
session_start();
include 'api/db.php';
$query = $pdo->query("SELECT * FROM products");
$produk = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk Keyboard | KeyboardStore</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <header class="navbar">
    <div class="logo">Keyboard<span>Store</span></div>
    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php" class="active">Produk</a>
        <a href="contact.php">Kontak</a>
        <a href="cart.php">🛒 Keranjang</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>


  <section class="product-section">
    <h2>Daftar Keyboard</h2>
    <div class="product-grid">
      <?php foreach ($produk as $p): ?>
        <div class="product-card">
          <img src="assets/images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>">
          <h3><?= $p['name'] ?></h3>
          <p>Rp <?= number_format($p['price'], 0, ',', '.') ?></p>
          <a href="detailproduk.php?id=<?= $p['id'] ?>" class="btn-primary">Lihat Detail</a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

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

  <div class="footer-bottom">
    <p>© 2025 KeyboardStore. Dibuat oleh <b>Candra</b>.</p>
  </div>
</footer>

</body>
</html>
