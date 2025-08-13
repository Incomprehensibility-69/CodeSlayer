document.addEventListener('DOMContentLoaded', () => {
  const checkoutList   = document.getElementById('checkout-items');
  const checkoutTotal  = document.getElementById('checkout-total');
  const cartDataInput  = document.getElementById('cartData');
  const checkoutForm   = document.getElementById('checkout-form');

  let cart = [];

  function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
  }

  function removeFromCart(index) {
    cart.splice(index, 1);
    saveCart();
    renderCheckout();
  }

  function renderCheckout() {
    checkoutList.innerHTML = '';
    let total = 0;

    if (!cart.length) {
      const li = document.createElement('li');
      li.textContent = 'Your cart is empty.';
      checkoutList.appendChild(li);
      checkoutTotal.textContent = '0.00';
      cartDataInput.value = '[]';
      return;
    }

    cart.forEach((item, index) => {
      const li = document.createElement('li');
      li.style.display = 'flex';
      li.style.justifyContent = 'space-between';
      li.style.alignItems = 'center';
      li.style.padding = '4px 0';
      li.style.borderBottom = '1px solid #e5e7eb';

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
        e.preventDefault();
        e.stopPropagation();
        removeFromCart(index);
      });

      li.appendChild(infoSpan);
      li.appendChild(removeBtn);
      checkoutList.appendChild(li);

      total += Number(item.price) || 0;
    });

    checkoutTotal.textContent = total.toFixed(2);
    cartDataInput.value = JSON.stringify(cart);
  }

  // Load cart from localStorage
  try {
    cart = JSON.parse(localStorage.getItem('cart')) || [];
  } catch {
    cart = [];
  }

  renderCheckout();

  // Ensure form posts to correct controller
  if (checkoutForm) {
    checkoutForm.action = '/CodeSlayer/src/controllers/process_order.php';
  }
});
