let cart = [];

function addToCart(title, price) {
  cart.push({ title, price });
  saveCartToLocalStorage();
  updateCartDisplay();
}

function updateCartDisplay() {
  const cartList = document.getElementById('cart-items');
  const totalDisplay = document.getElementById('cart-total');

  if (!cartList || !totalDisplay) return;

  cartList.innerHTML = '';
  let total = 0;

  cart.forEach((item, index) => {
    const li = document.createElement('li');
    li.style.display = 'flex';
    li.style.justifyContent = 'space-between';
    li.style.alignItems = 'center';
    li.style.padding = '4px 0';

    const infoSpan = document.createElement('span');
    infoSpan.textContent = `${item.title} - $${Number(item.price).toFixed(2)}`;
    infoSpan.style.flex = '1';
    infoSpan.style.textAlign = 'left';

    const removeBtn = document.createElement('button');
    removeBtn.textContent = 'Remove';
    removeBtn.className = 'btn btn-ghost';
    removeBtn.style.background = 'var(--danger)';
    removeBtn.style.color = '#fff';
    removeBtn.style.border = 'none';
    removeBtn.style.borderRadius = '4px';
    removeBtn.style.padding = '2px 8px';
    removeBtn.style.cursor = 'pointer';

    removeBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      removeFromCart(index);
    });

    li.appendChild(infoSpan);
    li.appendChild(removeBtn);
    cartList.appendChild(li);

    total += Number(item.price) || 0;
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
  try {
    const stored = JSON.parse(localStorage.getItem('cart'));
    cart = Array.isArray(stored) ? stored : [];
  } catch {
    cart = [];
  }
  updateCartDisplay();
}

document.addEventListener('DOMContentLoaded', loadCartFromLocalStorage);
