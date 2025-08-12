<?php
// Simple password hash generator for admin use only.
// Run this file manually, do not expose it publicly.

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    echo "<strong>Generated Hash:</strong><br><textarea rows='2' cols='80'>$hash</textarea>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password Hash Generator</title>
</head>
<body>
  <h2>Generate Password Hash</h2>
  <form method="POST">
    <label for="password">Enter Password:</label>
    <input type="text" name="password" id="password" required>
    <button type="submit">Generate Hash</button>
  </form>
</body>
</html>