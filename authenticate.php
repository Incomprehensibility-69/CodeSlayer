<?php
session_start();
$host = 'localhost';
$db = 'game_store';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password_hash, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
  $stmt->bind_result($hash, $role);
  $stmt->fetch();
  if (password_verify($password, $hash)) {
    $_SESSION['logged_in'] = true;
    $_SESSION['role'] = $role;

    // Log activity
    $log_stmt = $conn->prepare("INSERT INTO activity_log (username, action) VALUES (?, 'Logged in')");
    $log_stmt->bind_param("s", $username);
    $log_stmt->execute();
    $log_stmt->close();

    // Set cookie if "Remember Me" is checked
    if (isset($_POST['remember'])) {
      setcookie("remember_me", $username, time() + (86400 * 30), "/"); // 30 days
    }

    header("Location: admin.php");
    exit;
  }
}

$_SESSION['error'] = "Invalid username or password.";
header("Location: login.php");
exit;
?>
