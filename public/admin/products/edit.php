<?php
require '../auth_check.php';
require '../../api/db.php';

// Ambil ID
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Ambil data produk lama
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) {
    echo "Produk tidak ditemukan";
    exit;
}

$oldImage = $p['image'];

// form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc  = $_POST['description'];

    $imageName = $oldImage;

    // upload gambar baru
    if (!empty($_FILES['image']['name'])) {

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {

            $imageName = uniqid('product_') . '.' . $ext;
            $uploadPath = '../../assets/images/' . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {

             if ($oldImage && file_exists('../../assets/images/' . $oldImage)) {
                unlink('../../assets/images/' . $oldImage);
         }
        }

    }
    }
    // Update database
    $stmt = $pdo->prepare("
        UPDATE products 
        SET name = ?, price = ?, stock = ?, image = ?, description = ?
        WHERE id = ?
    ");
    $stmt->execute([
        $name,
        $price,
        $stock,
        $imageName,
        $desc,
        $id
    ]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>

<h2>Edit Produk</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nama Produk</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" required><br><br>

    <label>Harga</label><br>
    <input type="number" name="price" value="<?= $p['price'] ?>" required><br><br>

    <label>Stok</label><br>
    <input type="number" name="stock" value="<?= $p['stock'] ?>" required><br><br>

    <label>Gambar Saat Ini</label><br>
    <?php if ($p['image']): ?>
        <img src="/assets/images/products/<?= $p['image'] ?>" width="150"><br><br>
    <?php else: ?>
        <i>Tidak ada gambar</i><br><br>
    <?php endif; ?>

    <label>Ganti Gambar (opsional)</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <label>Deskripsi</label><br>
    <textarea name="description" rows="5"><?= htmlspecialchars($p['description']) ?></textarea><br><br>

    <button type="submit">Simpan Perubahan</button>
    <a href="index.php">Batal</a>
</form>

</body>
</html>

