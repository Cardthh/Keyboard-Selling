<?php
header('Content-Type: application/json');
require 'db.php';
$stmt = $pdo->query("SELECT id, sku, name, price, stock, image FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($products);
