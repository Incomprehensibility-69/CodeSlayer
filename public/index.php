<?php
require_once __DIR__ . '/../src/models/db.php';
require_once __DIR__ . '/../src/components/game_card.php';

// Featured game
$featured = $pdo->query("
    SELECT g.*, p.name AS platform_name
    FROM games g
    LEFT JOIN platforms p ON g.platform_id = p.platform_id
    WHERE featured = 1
    LIMIT 1
")->fetch();

// All games
$games = $pdo->query("
    SELECT g.*, p.name AS platform_name
    FROM games g
    LEFT JOIN platforms p ON g.platform_id = p.platform_id
    ORDER BY g.title ASC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CodeSlayer Game Store</title>
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
        <a class="nav-link" href="src\views\games_list.php">Games</a>
        <a class="nav-link" href="../src/auth/login.php">Login</a>
        <form action="../src/models/logout.php" method="POST" class="nav-inline">
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

  <!-- Hero -->
  <section class="hero surface reveal" data-animate="fade-up">
    <div class="hero-bg" style="background-image:url('img/hero-bg.jpg');"></div>
    <div class="hero-content">
      <h2>Discover Your Next Favorite Game</h2>
      <p>Curated classics and indie gems, all in one place.</p>
      <a href="src/views/games_list.php" class="btn btn-primary">Browse Collection</a>
    </div>
  </section>

  <!-- Featured -->
  <?php if (!empty($featured)): ?>
    <section class="slider reveal" data-animate="fade-up">
      <div class="featured-slider">
        <div class="featured-main">
          <img class="featured-img"
               src="img/<?= htmlspecialchars($featured['image_path']) ?>"
               alt="<?= htmlspecialchars($featured['title']) ?>">
        </div>
        <div class="featured-details surface shadow-md">
          <h2><?= htmlspecialchars($featured['title']) ?></h2>
          <div class="featured-tags">
            <?php foreach (explode(',', (string)$featured['tags']) as $tag): ?>
              <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
            <?php endforeach; ?>
          </div>
          <p class="featured-desc">
            <?= nl2br(htmlspecialchars(substr((string)$featured['description'], 0, 220))) ?>...
          </p>
          <div class="featured-meta">
            <span class="price">$<?= number_format($featured['price'], 2) ?></span>
            <a href="src/views/game_detail.php?id=<?= (int)$featured['game_id'] ?>" class="btn btn-accent">View Game</a>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- Game Grid -->
  <section class="featured reveal" data-animate="fade-up">
    <div class="section-header">
      <h3>Available Games</h3>
    </div>
    <div class="game-grid">
      <?php foreach ($games as $game): ?>
        <div class="reveal" data-animate="fade-up">
          <?php renderGameCard($game); ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- More to Explore -->
  <section class="explore surface shadow-sm reveal" data-animate="fade-up" style="max-width:1200px; margin:2rem auto; padding:1.5rem; border-radius:var(--radius);">
    <h3 style="margin-top:0;">More to Explore</h3>
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:1rem; margin-top:1rem;">
      <div class="explore-card surface shadow-sm" style="padding:1rem;">
        <h4>Top Sellers</h4>
        <p>See what everyone’s playing and loving right now.</p>
        <a href="src/views/games_list.php" class="btn btn-accent">View List</a>
      </div>
      <div class="explore-card surface shadow-sm" style="padding:1rem;">
        <h4>Upcoming Releases</h4>
        <p>Get ready for the hottest games launching soon.</p>
        <a href="src/views/games_list.php" class="btn btn-accent">See Upcoming</a>
      </div>
      <div class="explore-card surface shadow-sm" style="padding:1rem;">
        <h4>Indie Spotlight</h4>
        <p>Discover hidden gems from independent studios.</p>
        <a href="src/views/games_list.php" class="btn btn-accent">Explore Indies</a>
      </div>
    </div>
  </section>

  <!-- Cart Dropdown -->
  <div id="cart-dropdown" class="cart-dropdown surface shadow-md">
    <h3>Your Cart</h3>
    <ul id="cart-items"></ul>
    <div class="cart-total">Total: $<span id="cart-total">0.00</span></div>
    <a href="checkout.php" class="btn btn-primary btn-block">Go to Checkout</a>
  </div>

  <!-- Footer -->
  <footer class="surface shadow-sm" style="text-align:center; padding:1rem; margin-top:2rem;">
    <p>&copy; <?= date('Y') ?> CodeSlayer.com, Inc. All rights reserved.</p>
  </footer>

  <!-- Scripts -->
  <script src="js/app.js"></script>
  <script src="js/cart.js"></script>
  <script src="js/search.js"></script>
  <script>
    // Search highlight on Enter
    document.getElementById('search').addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        let searchValue = this.value.trim().toLowerCase();
        let games = document.querySelectorAll('.game-card');
        let found = false;
        games.forEach(game => {
          const title = (game.querySelector('h4')?.textContent || '').toLowerCase();
          if (title === searchValue) {
            found = true;
            game.scrollIntoView({ behavior: 'smooth', block: 'center' });
            game.classList.add('highlight');
            setTimeout(() => game.classList.remove('highlight'), 2000);
          }
        });
        if (!found) alert('Game not found!');
      }
    });

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
      }, { threshold: 0.12 });
      els.forEach(el => io.observe(el));
    })();

    // Cart dropdown toggle with click-outside close
    (function(){
      const link = document.getElementById('cart-link');
      const dropdown = document.getElementById('cart-dropdown');
      document.addEventListener('click', (e) => {
        if (e.target.closest('#cart-link')) {
          e.preventDefault();
          dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
        } else if (!e.target.closest('#cart-dropdown')) {
          dropdown.style.display = 'none';
        }
      });
    })();

    // Update cart badge from localStorage
    function updateCartBadge() {
      const badge = document.getElementById('cart-count');
      let cart = [];
      try { cart = JSON.parse(localStorage.getItem('cart')) || []; } catch {}
      const count = cart.length;
      badge.textContent = String(count);
      badge.style.display = count > 0 ? 'inline-block' : 'none';
    }

    // Show cart dropdown briefly after add
    function showCartDropdown() {
      const dropdown = document.getElementById('cart-dropdown');
      dropdown.style.display = 'block';
      setTimeout(() => {
        if (!dropdown.matches(':hover')) dropdown.style.display = 'none';
      }, 2000);
    }

    // Wrap addToCart to ensure homepage UI updates
    (function(){
      const original = window.addToCart;
      if (typeof original === 'function') {
        window.addToCart = function(title, price) {
          try { original(title, price); } catch (e) { console.error(e); }
          updateCartBadge();
          showCartDropdown();
        };
      }
    })();

    // Initialize badge and listen for cross-tab updates
    document.addEventListener('DOMContentLoaded', updateCartBadge);
    window.addEventListener('storage', updateCartBadge);

    // Event delegation for Add-to-Cart buttons rendered by renderGameCard()
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.add-to-cart');
      if (!btn) return;
      const title = btn.dataset.title;
      const price = parseFloat(btn.dataset.price);
      if (title && !isNaN(price) && typeof window.addToCart === 'function') {
        window.addToCart(title, price);
      }
    });
  </script>
  <!-- Loading Spinner Overlay -->
<div class="spinner-overlay" id="loading" style="display:none;">
  <div class="spinner"></div>
</div>

</body>
</html>
