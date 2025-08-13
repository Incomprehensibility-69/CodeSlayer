<?php
require_once __DIR__ . '/../models/db.php';

// Helper to sanitise
function clean($val) {
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

$name      = isset($_POST['name']) ? clean($_POST['name']) : '';
$email     = isset($_POST['email']) ? clean($_POST['email']) : '';
$cartData  = isset($_POST['cartData']) ? json_decode($_POST['cartData'], true) : [];

$errors = [];
if ($name === '') $errors[] = 'Name is required.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if (empty($cartData)) $errors[] = 'Cart is empty or invalid.';

// Prepare order string if valid
if (!$errors) {
    $order = "Order Date: " . date('Y-m-d H:i:s') . PHP_EOL;
    $order .= "Customer: {$name} <{$email}>" . PHP_EOL;
    $total = 0;
    foreach ($cartData as $item) {
        $title = clean($item['title'] ?? '');
        $price = (float)($item['price'] ?? 0);
        $order .= " - {$title} @ $" . number_format($price, 2) . PHP_EOL;
        $total += $price;
    }
    $order .= "Total: $" . number_format($total, 2) . PHP_EOL;
    $order .= str_repeat('-', 40) . PHP_EOL . PHP_EOL;
    file_put_contents(__DIR__ . '/orders.txt', $order, FILE_APPEND);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation – CodeSlayer</title>
  <link rel="stylesheet" href="/CodeSlayer/public/css/style.css">
</head>
<body>

<header class="site-header surface shadow-sm">
  <div class="header-container">
    <h1 class="logo">CodeSlayer</h1>
    <nav class="main-nav">
      <a class="nav-link" href="/CodeSlayer/public/index.php">Home</a>
      <a class="nav-link" href="/CodeSlayer/src/views/games_list.php">Games</a>
    </nav>
  </div>
</header>

<main style="max-width:800px;margin:2rem auto;padding:0 1rem;">
  <section class="surface shadow-md reveal" data-animate="fade-up" style="padding:2rem; text-align:center;">
    <?php if ($errors): ?>
      <h2>Order Error</h2>
      <ul style="color:var(--danger); text-align:left; display:inline-block;">
        <?php foreach ($errors as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
      <a href="/CodeSlayer/public/checkout.php" class="btn btn-primary" style="margin-top:1rem;">Return to Checkout</a>
    <?php else: ?>
      <h2>Thank you, <?= $name ?>!</h2>
      <p>Your order has been received and will be processed shortly.</p>
      <p><strong>Total:</strong> $<?= number_format($total, 2) ?></p>
      <a href="/CodeSlayer/public/index.php" class="btn btn-accent" style="margin-top:1rem;">Return to Store</a>
      <script>localStorage.removeItem('cart');</script>
    <?php endif; ?>
  </section>
</main>

<footer class="surface shadow-sm" style="text-align:center; padding:1rem; margin-top:2rem; background:linear-gradient(90deg,var(--primary),var(--accent)); color:#fff;">
  <p>&copy; <?= date('Y') ?> CodeSlayer.com, Inc.</p>
</footer>

<script>
  // Reveal animation
  (function(){
    const els = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('reveal-in'); io.unobserve(e.target); } });
    }, {threshold: 0.12});
    els.forEach(el => io.observe(el));
  })();
</script>

</body>
</html>
