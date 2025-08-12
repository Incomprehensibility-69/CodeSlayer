<?php
session_start();
session_unset();
session_destroy();

// Remove cookie if set
setcookie("remember_me", "", time() - 3600, "/");

// Log activity
$host = 'localhost';
$db = 'game_store';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  // Optionally log error or ignore
  header("Location: login.php");
  exit;
}
$log_stmt = $conn->prepare("INSERT INTO activity_log (username, action) VALUES (?, 'Logged out')");
$log_stmt->bind_param("s", $_COOKIE['remember_me'] ?? 'unknown');
$log_stmt->execute();
$log_stmt->close();

header("Location: login.php");
exit;
?>
