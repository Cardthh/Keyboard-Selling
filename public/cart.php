<?php
session_start();
require __DIR__ . '/api/db.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    echo "<h2>Silakan login untuk melihat keranjang</h2>";
    exit;
}

$user_id = $_SESSION['user_id'];

// ambil cart user
$stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if (!$cart) {
    echo "<h2>Keranjang masih kosong</h2>";
    exit;
}

$cart_id = $cart['id'];

// ambil item
$stmt = $pdo->prepare("
    SELECT p.name, p.price, ci.quantity
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.cart_id = ?
");
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - KeyboardStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body>

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

<div class="cart-container">
    <h2>Keranjang Belanja</h2>

    <?php if (!$items): ?>
        <p class="empty">Keranjang masih kosong.</p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            <strong>Total:</strong> Rp <?= number_format($total, 0, ',', '.') ?>
        </div>
        <button class="btn-checkout">Checkout</button>
    <?php endif; ?>
</div>
</body>
</html>
