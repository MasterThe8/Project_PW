let cart = [];

function updateStock(code) {
    fetch('updateStock.php', {
    method: 'POST',
    headers: {
        'Content-type': 'application/x-www-form-urlencoded'
    },
    body: 'code=' + encodeURIComponent(code)
    })
    .then(response => {
        if (response.ok) {
        let stockElement = document.getElementById('stock_' + code);
        let currentStock = parseInt(stockElement.textContent);
        if (currentStock > 0) {
            let newStock = currentStock - 1;
            stockElement.textContent = newStock.toString();
        }
        } else {
        throw new Error('Failed to update stock');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Failed to update stock');
    });
}

function addToCart(code, title, price) {
  let stockElement = document.getElementById('stock_' + code);
  let initialStock = parseInt(stockElement.dataset.initialStock);

  if (initialStock <= 0) {
    alert("Stock Habis!");
    return;
  }

  updateStock(code);

  let existingItem = cart.find(item => item.code === code);

  if (existingItem) {
    existingItem.stock += 1;
    existingItem.subtotal = existingItem.stock * price;
  } else {
    let newItem = {
      code: code,
      title: title,
      price: price,
      stock: 1,
      subtotal: price
    };

    cart.push(newItem);
  }

  let cartTable = document.getElementById("cartTable");
  cartTable.innerHTML = "";

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
}



function deleteCartItem(code) {
    let index = cart.findIndex(item => item.code === code);

    if (index !== -1) {
        cart.splice(index, 1);
        let cartTable = document.getElementById("cartTable");
        cartTable.innerHTML = "";

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
        let initialStock = stockElement.getAttribute('data-initial-stock');
        stockElement.textContent = initialStock;
    }
}


function prepareFormData() {
    
    let cashierName = document.getElementById("cashierName").value;
    let customerName = document.getElementById("customerName").value;
    let cartData = JSON.stringify(cart);

    
    document.getElementById("cashierNameHidden").value = cashierName;
    document.getElementById("customerNameHidden").value = customerName;
    document.getElementById("cartDataHidden").value = cartData;
}

function clearCart() {
    cart = []; 
    let cartTable = document.getElementById("cartTable");
    cartTable.innerHTML = "";

    location.reload();
}
