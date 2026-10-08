<?php
session_start();
header("Content-Type: application/json");
require __DIR__ . "/db.php";

// user harus login
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'error' => 'NOT_LOGIN',
        'message' => 'Silakan login terlebih dahulu'
    ]);
    exit;
}

if ($_SESSION['role'] === 'admin') {
    echo json_encode([
        'error' => 'ADMIN_FORBIDDEN',
        'message' => 'Admin tidak bisa belanja'
    ]);
    exit;
}


$user_id = $_SESSION['user_id'];

// ambil data POST JSON
$input = json_decode(file_get_contents("php://input"), true);
$product_id = (int)($input['product_id'] ?? 0);
$qty = (int)($input['qty'] ?? 1);

if ($product_id <= 0 || $qty <= 0) {
    echo json_encode([
        "error" => "INVALID_DATA",
        "message" => "Produk atau jumlah tidak valid"
    ]);
    exit;
}

// cek cart user
$stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cart) {
    $pdo->prepare("INSERT INTO cart (user_id) VALUES (?)")->execute([$user_id]);
    $cart_id = $pdo->lastInsertId();
} else {
    $cart_id = $cart['id'];
}

// cek apakah produk sudah ada di keranjang
$stmt = $pdo->prepare("
    SELECT id, quantity 
    FROM cart_items 
    WHERE cart_id = ? AND product_id = ?
");
$stmt->execute([$cart_id, $product_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    $newQty = $item['quantity'] + $qty;
    $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?")
        ->execute([$newQty, $item['id']]);
} else {
    $pdo->prepare("
        INSERT INTO cart_items (cart_id, product_id, quantity)
        VALUES (?, ?, ?)
    ")->execute([$cart_id, $product_id, $qty]);
}

echo json_encode([
    "success" => true,
    "message" => "Produk berhasil ditambahkan ke keranjang"
]);
