<?php
require '../auth_check.php';
require '../../api/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid() . '.' . $ext;
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            '../../assets/images/products/' . $imageName
        );
    }

    $stmt = $pdo->prepare("
        INSERT INTO products (name, price, stock, image, description)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $_POST['name'],
        $_POST['price'],
        $_POST['stock'],
        $imageName,
        $_POST['description']
    ]);

    header('Location: index.php');
}
?>

<h2>Tambah Produk</h2>

<form method="POST" enctype="multipart/form-data">
  Nama: <input name="name" required><br>
  Harga: <input name="price" required><br>
  Stok: <input name="stock" required><br>
  Gambar: <input type="file" name="image"><br>
  Deskripsi:<br>
  <textarea name="description"></textarea><br>
  <button>Simpan</button>
</form>
