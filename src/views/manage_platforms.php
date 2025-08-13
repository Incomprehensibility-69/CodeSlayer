<?php
require_once __DIR__ . '/../models/db.php';

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    echo "<div style='background:#ffeaa7;padding:1rem;margin:1rem 0;border:1px solid #fdcb6e;'>
            <strong>Debug:</strong> Submitted platform name = '<code>" . htmlspecialchars($name) . "</code>'
          </div>";

    try {
        $check = $pdo->prepare("SELECT COUNT(*) FROM platforms WHERE name = ?");
        $check->execute([$name]);

        if ($check->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO platforms (name) VALUES (?)");
            $stmt->execute([$name]);
            header("Location: manage_platforms.php?message=Platform added successfully");
            exit;
        } else {
            echo "<div class='message error'>Platform already exists.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='message error'>Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}


// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM platforms WHERE platform_id = ?");
    $stmt->execute([$id]);
    header("Location: manage_platforms.php?message=Platform deleted");
    exit;
}

// Fetch platforms
$platforms = $pdo->query("SELECT * FROM platforms ORDER BY name ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Platforms</title>
    <link rel="stylesheet" href="/CodeSlayer/public/css/admin.css">
    <style>
        .btn-add.pulse {
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn-manage {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #3c40c6;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }

        .btn-manage:hover {
            background-color: #575fcf;
        }
    </style>
    <script>
    setTimeout(() => {
        const msg = document.querySelector('.message');
        if (msg) msg.style.opacity = '0';
    }, 3000);
    </script>
</head>
<body>
    <header>
        <h1>CodeSlayer Admin Panel</h1>
        <form action="/CodeSlayer/src/models/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <h2>Platform Management</h2>

        <?php if ($message): ?>
            <div class="message success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="game-form">
            <h3 style="margin-bottom: 1rem;">➕ Add New Platform</h3>
            <form method="POST" class="game-form">
                <label>Platform Name:
                    <input type="text" name="name" placeholder="e.g. PlayStation 5" required>
                </label>
                <button type="submit" name="add" class="btn-add pulse">➕ Add Platform</button>
            </form>
        </section>

        <section style="margin-top: 3rem;">
            <h3>Existing Platforms</h3>
            <?php if (!empty($platforms)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($platforms as $platform): ?>
                            <tr>
                                <td><?= htmlspecialchars($platform['name']) ?></td>
                                <td style="text-align:right;">
                                    <a href="edit_platform.php?id=<?= $platform['platform_id'] ?>" class="btn-edit">✏️ Edit</a>
                                    <a href="manage_platforms.php?delete=<?= $platform['platform_id'] ?>"
                                       class="btn-delete"
                                       onclick="return confirm('Delete this platform?')">🗑️ Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No platforms found. Add one above to get started.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 The Echo Project - Admin Panel</p>
    </footer>
</body>
</html>
