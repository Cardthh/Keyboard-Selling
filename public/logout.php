<?php
session_start();

// Hapus session
session_unset();
session_destroy();

// Hapus cookie login
setcookie('login_token', '', time() - 300, '/');

// Kembali ke login
header("Location: login.php");
exit;
