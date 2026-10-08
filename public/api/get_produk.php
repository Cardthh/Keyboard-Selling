<?php
header('Content-Type: application/json');
require 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
  http_response_code(404);
  echo json_encode(['error'=>'Product not found']);
} else {
  echo json_encode($product);
}
