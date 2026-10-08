<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kontak Kami | KeyboardStore</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Navbar -->
  <header class="navbar">
    <div class="logo">Keyboard<span>Store</span></div>
    <nav>
      <a href="index.php">Beranda</a>
      <a href="produk.php">Produk</a>
      <a href="contact.php" class="active">Kontak</a>
      <a href="cart.php">🛒 Keranjang</a>
    </nav>
  </header>

  <section class="contact-section">
    <h2>Hubungi Kami</h2>
    <p>Butuh bantuan atau ingin bertanya tentang produk kami? Silakan kirim pesan melalui form di bawah ini.</p>

    <div class="contact-container">
      <form class="contact-form">
        <label>Nama</label>
        <input type="text" placeholder="Masukkan nama anda" required>

        <label>Email</label>
        <input type="email" placeholder="Masukkan email anda" required>

        <label>Pesan</label>
        <textarea rows="5" placeholder="Tulis pesan anda..." required></textarea>

        <button type="submit" class="btn-primary">Kirim Pesan</button>
      </form>

      <div class="contact-map">
        <iframe src="https://www.google.com/maps?q=Jakarta&output=embed" loading="lazy"></iframe>
      </div>
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
