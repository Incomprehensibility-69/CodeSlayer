// cart.js
let cart = [];

function addToCart(title, price) {
  cart.push({ title, price });
  saveCartToLocalStorage();
  updateCartDisplay();
}

function updateCartDisplay() {
  const cartList = document.getElementById('cart-items');
  const totalDisplay = document.getElementById('cart-total');
  cartList.innerHTML = '';
  let total = 0;

  cart.forEach((item, index) => {
    const li = document.createElement('li');
    li.style.display = 'flex';
    li.style.justifyContent = 'space-between';
    li.style.alignItems = 'center';
    li.style.padding = '4px 0';

    // Game info on the left
    const infoSpan = document.createElement('span');
    infoSpan.textContent = `${item.title} - $${item.price.toFixed(2)}`;
    infoSpan.style.flex = '1';
    infoSpan.style.textAlign = 'left';

    // Remove button on the right
    const removeBtn = document.createElement('button');
    removeBtn.textContent = 'Remove';
    removeBtn.style.background = '#e74c3c';
    removeBtn.style.color = '#fff';
    removeBtn.style.border = 'none';
    removeBtn.style.borderRadius = '4px';
    removeBtn.style.padding = '2px 8px';
    removeBtn.style.cursor = 'pointer';
    removeBtn.onclick = function(e) {
      e.stopPropagation(); // Prevent cart dropdown from closing
      removeFromCart(index);
    };

    li.appendChild(infoSpan);
    li.appendChild(removeBtn);
    cartList.appendChild(li);
    total += item.price;
  });

  totalDisplay.textContent = total.toFixed(2);
}

function removeFromCart(index) {
  cart.splice(index, 1);
  saveCartToLocalStorage();
  updateCartDisplay();
}

function saveCartToLocalStorage() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function loadCartFromLocalStorage() {
  const storedCart = localStorage.getItem('cart');
  if (storedCart) {
    cart = JSON.parse(storedCart);
    updateCartDisplay();
  }
}

window.onload = loadCartFromLocalStorage;
