<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header"><a href="index.php" class="logo">KeyboardShop</a></header>
<main class="container">
  <h1>Checkout</h1>
  <form id="checkoutForm">
    <label>Nama <input name="name" required></label>
    <label>Email <input name="email" type="email" required></label>
    <label>Alamat <textarea name="address" required></textarea></label>
    <button type="submit" class="btn">Bayar</button>
  </form>
  <div id="result"></div>
</main>

<script>
document.getElementById('checkoutForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const form = new FormData(e.target);
  const payload = {
    name: form.get('name'),
    email: form.get('email'),
    address: form.get('address')
  };
  const res = await fetch('api/checkout.php', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body: JSON.stringify(payload)
  });
  const j = await res.json();
  if (j.success) {
    document.getElementById('result').innerHTML = `<p>Order berhasil. ID: ${j.order_id}</p><a href="products.php">Kembali ke toko</a>`;
  } else {
    document.getElementById('result').innerText = j.error || 'Checkout gagal';
  }
});
</script>
</body>
</html>
