<?php
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  if (isset($_COOKIE['remember_me'])) {
    $_SESSION['logged_in'] = true;
  } else {
    header("Location: login.php");
    exit;
  }
}

// Restrict access to admin users only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  echo "Access denied.";
  exit;
}
?>

<?php
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
$host = 'localhost';
$db = 'game_store';
$user = 'root';
$pass = ''; // adjust if needed

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM games";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <header>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
    <h1>Pixel Vault Admin</h1>
=======
=======
>>>>>>> Stashed changes
    <h1>CodeSlayer Admin</h1>
    <form action="logout.php" method="POST" style="text-align:right;">
      <button type="submit">Logout</button>
    </form>
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
  </header>

  <main>
    <h2>Game Inventory</h2>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Genre</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Image</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['genre']) ?></td>
          <td>$<?= number_format($row['price'], 2) ?></td>
          <td><?= $row['stock'] ?></td>
          <td><img src="<?= $row['image_path'] ?>" alt="<?= $row['title'] ?>" width="60"></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <td contenteditable="true" onblur="updateStock(this, 1)">10</td>
  </main>

  <footer>
    <p>&copy; 2025 CodeSlayer.com, Inc. - Admin Panel</p>
  </footer>
</body>
</html>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes

<?php
$hash = password_hash("Codeslayer", PASSWORD_DEFAULT);
echo $hash;
// You can use this PHP code to generate a secure password hash for storing in your users
?>
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
