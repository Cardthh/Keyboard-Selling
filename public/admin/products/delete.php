<?php
require '../auth_check.php';
require '../../api/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
$stmt->execute([$id]);

header('Location: index.php');
