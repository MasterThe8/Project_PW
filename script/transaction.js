let cart = [];

function addToCart(code, title, price, stock) {
    // Cek apakah buku sudah ada dalam cart berdasarkan code
    let existingItem = cart.find(item => item.code === code);

    if (existingItem) {
        // Jika buku sudah ada, tambahkan satu ke stock
        existingItem.stock += 1;
        existingItem.subtotal = existingItem.stock * price;
    } else {
        // Jika buku belum ada, buat objek baru
        let newItem = {
            code: code,
            title: title,
            price: price,
            stock: 1,
            subtotal: price
        };
    
        cart.push(newItem);
    }

    // Masukkan nilai ke Baris Tabel
    let cartTable = document.getElementById("cartTable");
    cartTable.innerHTML = ""; // Menghapus isi tbody sebelum memasukkan data baru

    cart.forEach((item, index) => {
        let tableRow = `<tr>
                            <td>${item.code}</td>
                            <td>${item.title}</td>
                            <td>${item.stock}</td>
                            <td>${item.price}</td>
                            <td>${item.subtotal}</td>
                            <td><button class="delete-cart-item" onclick="deleteCartItem('${item.code}')">Delete</button></td>
                        </tr>`;

        cartTable.innerHTML += tableRow;
    });

    let stockElement = document.getElementById('stock_' + code);
    let currentStock = parseInt(stockElement.textContent);
    let newStock = currentStock - 1;
    stockElement.textContent = newStock.toString();
}

function deleteCartItem(code) {
    // Cari indeks item yang akan dihapus
    let index = cart.findIndex(item => item.code === code);

    if (index !== -1) {
        // Hapus item dari array cart berdasarkan indeks
        cart.splice(index, 1);

        // Perbarui tampilan tabel cart
        let cartTable = document.getElementById("cartTable");
        cartTable.innerHTML = "";

        cart.forEach((item, index) => {
            let tableRow = `<tr>
                                <td>${item.code}</td>
                                <td>${item.title}</td>
                                <td>${item.stock}</td>
                                <td>${item.price}</td>
                                <td>${item.subtotal}</td>
                                <td><button onclick="deleteCartItem('${item.code}')">Delete</button></td>
                            </tr>`;

            cartTable.innerHTML += tableRow;
        });
    }
}

function prepareFormData() {
    // Ambil nilai cashierName, customerName, dan cartData dari elemen HTML
    let cashierName = document.getElementById("cashierName").value;
    let customerName = document.getElementById("customerName").value;
    let cartData = JSON.stringify(cart);

    // Isi nilai-nilai ke elemen input tersembunyi
    document.getElementById("cashierNameHidden").value = cashierName;
    document.getElementById("customerNameHidden").value = customerName;
    document.getElementById("cartDataHidden").value = cartData;
}

function clearCart() {
    cart = []; // Menghapus semua item di keranjang
    let cartTable = document.getElementById("cartTable");
    cartTable.innerHTML = ""; // Menghapus isi tbody
  
    // Refresh halaman
    location.reload();
  }
  