<?php
header('Content-Type: application/json');
require 'db.php';

$input = json_decode(file_get_contents('php://input'), true);
$name = trim($input['name'] ?? '');
$email = trim($input['email'] ?? '');
$address = trim($input['address'] ?? '');

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) { http_response_code(400); echo json_encode(['error'=>'cart empty']); exit; }
if ($name==='' || $email==='' || $address==='') { http_response_code(400); echo json_encode(['error'=>'missing data']); exit; }

 
$ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id, price, stock FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = 0;
foreach ($rows as $r) {
  $pid = $r['id']; $qty = $cart[$pid];
  if ($qty > $r['stock']) { http_response_code(400); echo json_encode(['error'=>'Not enough stock', 'product_id'=>$pid]); exit; }
  $total += $r['price'] * $qty;
}

 
$pdo->beginTransaction();
try {
  $ins = $pdo->prepare("INSERT INTO orders (name, email, address, total) VALUES (?, ?, ?, ?)");
  $ins->execute([$name, $email, $address, $total]);
  $order_id = $pdo->lastInsertId();
  $insItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, qty, price) VALUES (?, ?, ?, ?)");
  $updStock = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
  foreach ($rows as $r) {
    $pid = $r['id']; $qty = $cart[$pid];
    $insItem->execute([$order_id, $pid, $qty, $r['price']]);
    $updStock->execute([$qty, $pid]);
  }
  $pdo->commit();
  unset($_SESSION['cart']);
  echo json_encode(['success'=>true, 'order_id'=>$order_id]);
} catch(Exception $e) {
  $pdo->rollBack();
  http_response_code(500);
  echo json_encode(['error'=>'checkout failed']);
}
