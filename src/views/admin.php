<?php
session_start();

// --- Authentication & Authorization ---
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_COOKIE['remember_me'])) {
        $_SESSION['logged_in'] = true;
    } else {
        header('Location: /CodeSlayer/src/auth/login.php');
        exit;
    }
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo 'Access denied.';
    exit;
}

// --- Database (PDO) ---
require_once __DIR__ . '/../models/db.php';

// --- Fetch Games ---
try {
    $stmt = $pdo->query("SELECT game_id, title, genre, price, stock, image_path FROM games ORDER BY title ASC");
    $games = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error retrieving games: " . htmlspecialchars($e->getMessage()));
}

// --- Dashboard Summary ---
$totalGames = $pdo->query("SELECT COUNT(*) FROM games")->fetchColumn();
$totalPlatforms = $pdo->query("SELECT COUNT(*) FROM platforms")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Game Inventory</title>
    <link rel="stylesheet" href="/CodeSlayer/public/css/admin.css">
</head>
<body>
    <header>
        <h1>CodeSlayer Admin Panel</h1>
        <form action="/CodeSlayer/src/models/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <h2>Dashboard Summary</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Games</h3>
                <p><?= $totalGames ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Platforms</h3>
                <p><?= $totalPlatforms ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $totalUsers ?></p>
            </div>
        </div>

        <h2>Game Inventory</h2>
        <div class="admin-actions">
            <a href="add_game.php" class="btn-add">+ Add New Game</a>
            <a href="manage_platforms.php" class="btn-manage">🧩 Manage Platforms</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($games)): ?>
                    <?php foreach ($games as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['genre']) ?></td>
                            <td>$<?= number_format((float)$row['price'], 2) ?></td>
                            <td><?= (int)$row['stock'] ?></td>
                            <td>
                                <?php if (!empty($row['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($row['image_path']) ?>"
                                         alt="<?= htmlspecialchars($row['title']) ?>"
                                         width="60">
                                <?php else: ?>
                                    <span>No image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_game.php?id=<?= $row['game_id'] ?>" class="btn-edit">Edit</a>
                                <a href="delete_game.php?id=<?= $row['game_id'] ?>"
                                   class="btn-delete"
                                   onclick="return confirm('Are you sure you want to delete this game?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No games found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2025 The Echo Project - Admin Panel</p>
    </footer>
</body>
</html>
