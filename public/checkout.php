<?php
// public/checkout.php
require_once __DIR__ . '/../src/models/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Checkout – CodeSlayer Game Store</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <!-- Header -->
  <header class="site-header surface shadow-sm">
    <div class="header-container">
      <h1 class="logo">CodeSlayer</h1>
      <nav class="main-nav">
        <a class="nav-link" href="index.php">Home</a>
        <a class="nav-link" href="src/views/games_list.php">Games</a>
        <a class="nav-link" href="src/auth/login.php">Login</a>
        <form action="src/models/logout.php" method="POST" class="nav-inline">
          <button type="submit" class="btn btn-ghost">Logout</button>
        </form>
        <a class="nav-link" href="#" id="cart-link">
          Cart <span id="cart-count" class="badge badge-danger" style="display:none;">0</span>
        </a>
        <div class="nav-search">
          <input type="text" id="search" placeholder="Search games..." autocomplete="off" />
          <div id="search-results" class="search-results"></div>
        </div>
      </nav>
    </div>
  </header>

  <!-- Main Checkout Section -->
  <main class="main-content" style="max-width:900px; margin:2rem auto; padding:0 1rem;">
    <section class="checkout-panel surface shadow-md reveal" data-animate="fade-up" style="padding:2rem;">
      <h2 style="margin-top:0;">Checkout</h2>

      <!-- Items list -->
      <ul id="checkout-items" class="checkout-items" style="list-style:none; padding:0; margin:1rem 0; border-top:1px solid #e5e7eb; border-bottom:1px solid #e5e7eb;">
        <!-- Populated by checkout.js -->
      </ul>

      <!-- Total -->
      <div class="checkout-summary" style="display:flex; justify-content:space-between; font-weight:600; font-size:1.1rem; margin-bottom:1rem;">
        <span>Total:</span>
        <strong>$<span id="checkout-total">0.00</span></strong>
      </div>

      <!-- Order form -->
      <form id="checkout-form" action="/CodeSlayer/src/controllers/process_order.php" method="POST" class="checkout-form" style="display:grid; gap:1rem;">
        <div class="form-group" style="display:flex; flex-direction:column;">
          <label for="name" style="font-weight:500; margin-bottom:0.25rem;">Your Name</label>
          <input id="name" name="name" type="text" placeholder="Enter your name" required style="padding:0.5rem; border:1px solid #ccc; border-radius:var(--radius);" />
        </div>

        <div class="form-group" style="display:flex; flex-direction:column;">
          <label for="email" style="font-weight:500; margin-bottom:0.25rem;">Email Address</label>
          <input id="email" name="email" type="email" placeholder="you@example.com" required style="padding:0.5rem; border:1px solid #ccc; border-radius:var(--radius);" />
        </div>

        <input type="hidden" name="cartData" id="cartData" />

        <button type="submit" class="btn btn-primary btn-block" style="margin-top:0.5rem;">Place Order</button>
      </form>
    </section>
  </main>

  <!-- Footer -->
  <footer class="surface shadow-sm" style="text-align:center; padding:1rem; margin-top:2rem; background:linear-gradient(90deg,var(--primary),var(--accent)); color:#fff;">
    <p>&copy; <?= date('Y') ?> CodeSlayer.com, Inc.</p>
  </footer>

  <!-- Scripts -->
  <script src="js/app.js"></script>
  <script src="js/cart.js"></script>
  <script src="js/checkout.js"></script>
  <script src="js/search.js"></script>
  <script>
    // Reveal-on-scroll
    (function(){
      const els = document.querySelectorAll('.reveal');
      const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('reveal-in');
            io.unobserve(e.target);
          }
        });
      }, {threshold: 0.12});
      els.forEach(el => io.observe(el));
    })();
  </script>
  <!-- Loading Spinner Overlay -->
<div class="spinner-overlay" id="loading" style="display:none;">
  <div class="spinner"></div>
</div>

</body>
</html>
