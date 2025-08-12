<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <main>
    <h2>Login to Admin Panel</h2>
    <form action="authenticate.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" required>

      <label for="password">Password:</label>
      <input type="password" name="password" required>

      <label>
        <input type="checkbox" name="remember"> Remember Me
      </label>

      <button type="submit">Login</button>
    </form>
    <?php if (isset($_SESSION['error'])): ?>
      <p style="color:red"><?= $_SESSION['error'] ?></p>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <p><a href="reset_request.php">Forgot Password?</a></p>
  </main>
</body>
</html>
