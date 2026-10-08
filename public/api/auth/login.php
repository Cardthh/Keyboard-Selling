<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . '/../db.php';

$input = json_decode(file_get_contents('php://input'), true);

$username = trim($input['username'] ?? '');
$password = trim($input['password'] ?? '');

if ($username === '' || $password === '') {
    echo json_encode(['error' => 'Username dan password wajib diisi']);
    exit;
}

// Cek user
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    echo json_encode(['error' => 'Username atau password salah']);
    exit;
}

// Simpan session
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

$token = bin2hex(random_bytes(32));

// Set cookie
setcookie(
    'login_token',
    $token,
    time() + 300,
    '/',
    '',
    false,
    true
);

$_SESSION['login_token'] = $token;
$_SESSION['login_expire'] = time() + 300;


echo json_encode([
    'success' => true,
    'role' => $user['role'],
    'message' => 'Login berhasil'
]);
exit;
