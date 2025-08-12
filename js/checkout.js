<<<<<<< Updated upstream
<<<<<<< Updated upstream
window.onload = function() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const list = document.getElementById('checkout-items');
  const totalDisplay = document.getElementById('checkout-total');
  const cartDataInput = document.getElementById('cartData');

  let total = 0;
  cart.forEach(item => {
    const li = document.createElement('li');
    li.textContent = `${item.title} - $${item.price.toFixed(2)}`;
    list.appendChild(li);
    total += item.price;
  });

  totalDisplay.textContent = total.toFixed(2);
  cartDataInput.value = JSON.stringify(cart);
};
=======
=======
>>>>>>> Stashed changes
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/checkout.js" defer></script>
</head>
<body>
    <h1>Checkout</h1>
    <ul id="checkout-items"></ul>
    <p>Total: $<span id="checkout-total">0.00</span></p>
    <input type="hidden" id="cartData" name="cartData">
    <button id="checkout-button">Checkout</button>

    <script>
        window.onload = function() {
          const cart = JSON.parse(localStorage.getItem('cart')) || [];
          const list = document.getElementById('checkout-items');
          const totalDisplay = document.getElementById('checkout-total');
          const cartDataInput = document.getElementById('cartData');

          let total = 0;
          cart.forEach(item => {
            const li = document.createElement('li');
            li.textContent = `${item.title} - $${item.price.toFixed(2)}`;
            list.appendChild(li);
            total += item.price;
          });

          totalDisplay.textContent = total.toFixed(2);
          cartDataInput.value = JSON.stringify(cart);
        };
    </script>
</body>
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
</html>
>>>>>>> Stashed changes
