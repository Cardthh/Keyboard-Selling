<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['items' => []]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if (!$cart) {
    echo json_encode(['items' => []]);
    exit;
}

$cart_id = $cart['id'];

$stmt = $pdo->prepare("
    SELECT p.id AS product_id, p.name, p.price, p.image, c.quantity
    FROM cart_items c
    JOIN products p ON p.id = c.product_id
    WHERE c.cart_id = ?
");
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['items' => $items]);
