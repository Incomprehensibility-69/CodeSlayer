<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="/CodeSlayer/public/css/login.css" />
</head>
<body>
  <main>
    <h2>Login to Admin Panel</h2>

    <form action="../models/authenticate.php" method="POST" autocomplete="off">
      <!-- Username -->
      <label for="username">Username:</label>
      <input id="username" type="text" name="username" required />

      <!-- Password -->
      <label for="password">Password:</label>
      <input
        id="password"
        type="password"
        name="password"
        placeholder="Password"
        required
      />

      <!-- Submit -->
      <button type="submit">Login</button>
    </form>

    <!-- Error message -->
    <?php if (isset($_SESSION['error'])): ?>
      <p class="login-error">
        <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
      </p>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Forgot password link -->
    <p><a href="../controllers/reset_request.php">Forgot Password?</a></p>
  </main>
</body>
</html>
