document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const quantityInput = document.getElementById("quantity");
    const pricePerProduct = 100; // Harga per produk

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Mengambil nilai input
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const address = document.getElementById("address").value;
        const quantity = parseInt(quantityInput.value);

        // Validasi input
        if (!name || !email || !address || isNaN(quantity) || quantity < 1) {
            alert("Harap isi semua bidang dengan benar.");
            return;
        }

        // Menghitung total harga
        const total = quantity * pricePerProduct;

        // Menampilkan pesan konfirmasi
        const confirmationMessage = `
            Terima kasih, ${name}!
            Pesanan Anda untuk Produk sejumlah ${quantity} telah diterima.
            Total harga: $${total}.
            Produk akan dikirim ke alamat berikut: ${address}.
            Email konfirmasi akan dikirimkan ke: ${email}.
        `;

        alert(confirmationMessage);

        // Reset form
        form.reset();

        // Kirim data ke server PHP
        fetch("order.php", {
            method: "POST",
            body: new URLSearchParams(new FormData(form)),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
            .then((response) => response.text())
            .then((data) => {
                console.log(data);
            })
            .catch((error) => {
                console.error("Kesalahan:", error);
            });
    });

    // Mengupdate total harga saat jumlah produk berubah
    quantityInput.addEventListener("input", function () {
        const quantity = parseInt(quantityInput.value);
        const total = quantity * pricePerProduct;
        document.getElementById("total").textContent = `$${total}`;
    });
});
