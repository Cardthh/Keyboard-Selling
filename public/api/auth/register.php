<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . '/../db.php';

// Ambil input dari JSON
$input = json_decode(file_get_contents('php://input'), true);

$username = trim($input['username'] ?? '');
$password = trim($input['password'] ?? '');

if ($username == '' || $password == '') {
    echo json_encode(['error' => 'Username dan password wajib diisi']);
    exit;
}

// Cek apakah username sudah digunakan
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    echo json_encode(['error' => 'Username sudah terdaftar']);
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert ke database
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed]);

echo json_encode(['success' => true, 'message' => 'Registrasi berhasil! Silakan login.']);
