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
      <div style="position:relative;">
        <input type="password" name="password" id="password" required style="padding-right:40px;">
        <button type="button" id="togglePassword" style="position:absolute; right:5px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#0078d4;">Show</button>
      </div>

      <label>
        <input type="checkbox" name="remember"> Remember Me
      </label>

      <button type="submit">Login</button>
    </form>
    <?php if (isset($_SESSION['error'])): ?>
      <p class="login-error" style="color:red; margin-top:10px; animation: shake 0.3s;"> <?= $_SESSION['error'] ?> </p>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <p><a href="reset_request.php">Forgot Password?</a></p>
  </main>
</main>
<script src="js/login.js"></script>
</body>
</html>
