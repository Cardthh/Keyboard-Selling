<?php
require '../auth_check.php';
require '../../api/db.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Daftar Produk</h2>
<a href="create.php">+ Tambah Produk</a>

<table border="1" cellpadding="10">
<tr>
  <th>Nama</th>
  <th>Harga</th>
  <th>Stok</th>
  <th>Aksi</th>
  <th>Gambar</th>
</tr>

<?php foreach ($products as $p): ?>
<tr>
  <td><?= $p['name'] ?></td>
  <td><?= $p['price'] ?></td>
  <td><?= $p['stock'] ?></td>
  <td>
    <a href="edit.php?id=<?= $p['id'] ?>">Edit</a> |
    <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Hapus produk?')">Hapus</a>
  </td>
  <td>
<?php if ($p['image']): ?>
  <img src="/assets/images/products/<?= $p['image'] ?>" width="80">
<?php else: ?>
  -
<?php endif; ?>
</td>

</tr>
<?php endforeach; ?>
</table>
