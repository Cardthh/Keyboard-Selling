<?php
require 'auth_check.php';
?>



<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <h2>Dashboard Admin</h2>

  <p>Halo, <b><?= $_SESSION['username'] ?></b></p>

  <ul>
    <li><a href="products/index.php">Kelola Produk</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>
</html>
