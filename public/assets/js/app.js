function add_to_cart(product_id) {

    fetch("/api/add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            product_id: product_id,
            qty: 1
        })
    })
    .then(res => res.json())
    .then(d => {

        if (d.error === 'NOT_LOGIN') {
            alert(d.message);
            window.location.href = "/login.php";
            return;
        }

        if (d.error === 'ADMIN_FORBIDDEN') {
            alert(d.message);
            return;
        }

        if (d.error) {
            alert(d.message || d.error);
            return;
        }

        alert(d.message);
    });
}
