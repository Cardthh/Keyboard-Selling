<?php
session_start();
require __DIR__ . '/api/db.php';

// Cek apakah id ada
if (!isset($_GET['id'])) {
    die("Produk tidak ditemukan.");
}

$id = (int)$_GET['id'];

// Ambil produk berdasarkan id
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produk) {
    die("Produk tidak ditemukan di database.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produk['name']) ?> | KeyboardStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/detail.css">  
</head>

<body>

<!-- Navbar -->
<header class="navbar">
    <div class="logo">Keyboard<span>Store</span></div>
    <nav>
        <a href="index.php">Home</a>
        <a href="produk.php">Produk</a>
        <a href="contact.php">Kontak</a>
        <a href="cart.php">Keranjang</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>


<div class="container">

    <div class="product-wrapper">

        <div class="product-image">
            <img src="uploads/<?= htmlspecialchars($produk['image'] ?? 'noimage.png') ?>" alt="Produk">
        </div>

        <div class="product-info">
            <h1><?= htmlspecialchars($produk['name']) ?></h1>

            <div class="price">
                Rp<?= number_format($produk['price'], 0, ',', '.') ?>
            </div>

            <p class="description">
                <?= nl2br(htmlspecialchars($produk['description'] ?? "Tidak ada deskripsi.")) ?>
            </p>

            <button class="btn-add" onclick="add_to_cart(<?= $produk['id'] ?>)">
                Tambah ke Keranjang 🛒
            </button>
        </div>

    </div>

</div>

<div id="toast" class="toast">Berhasil ditambahkan ke keranjang!</div>

<script src="assets/js/app.js"></script>

</body>
</html>
