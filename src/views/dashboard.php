<?php
session_start();

// --- Authentication & Authorization ---
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_COOKIE['remember_me'])) {
        $_SESSION['logged_in'] = true;
    } else {
        header('Location: src\auth\login.php');
        exit;
    }
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo 'Access denied.';
    exit;
}

// --- Database (PDO) ---
require_once __DIR__ . '/../models/db.php'; // sets up $pdo

// --- Fetch Totals ---
try {
    $userCount = (int) $pdo->query("SELECT COUNT(*) AS total FROM users")
                           ->fetch()['total'];

    $gameCount = (int) $pdo->query("SELECT COUNT(*) AS total FROM games")
                           ->fetch()['total'];

    $activity = $pdo->query(
        "SELECT username, action, timestamp
         FROM activity_log
         ORDER BY timestamp DESC
         LIMIT 5"
    )->fetchAll();
} catch (PDOException $e) {
    // In production, log this instead of showing
    die("Query error: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Admin</title>
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
        <h2>Dashboard Overview</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $userCount ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Games</h3>
                <p><?= $gameCount ?></p>
            </div>
        </div>

        <h2>Recent Activity</h2>
        <?php if (!empty($activity)): ?>
            <ul class="activity-list">
                <?php foreach ($activity as $row): ?>
                    <li>
                        <span class="timestamp"><?= htmlspecialchars($row['timestamp']) ?></span>
                        —
                        <strong><?= htmlspecialchars($row['username']) ?></strong>:
                        <?= htmlspecialchars($row['action']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No recent activity recorded.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 The Echo Project - Admin Panel</p>
    </footer>
</body>
</html>
