<?php
require_once __DIR__ . '/../models/db.php';

$platform_id = $_GET['id'] ?? null;
if (!$platform_id) {
    echo "Platform ID is missing.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM platforms WHERE platform_id = ?");
$stmt->execute([$platform_id]);
$platform = $stmt->fetch();

if (!$platform) {
    echo "Platform not found.";
    exit;
}

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['name'] ?? '');
    if ($new_name !== '') {
        $check = $pdo->prepare("SELECT COUNT(*) FROM platforms WHERE name = ? AND platform_id != ?");
        $check->execute([$new_name, $platform_id]);

        if ($check->fetchColumn() == 0) {
            $update = $pdo->prepare("UPDATE platforms SET name = ? WHERE platform_id = ?");
            $update->execute([$new_name, $platform_id]);
            header("Location: manage_platforms.php?message=Platform updated");
            exit;
        } else {
            header("Location: edit_platform.php?id=$platform_id&error=Platform already exists");
            exit;
        }
    } else {
        header("Location: edit_platform.php?id=$platform_id&error=Platform name cannot be empty");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Platform</title>
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
        <h2>Edit Platform</h2>

        <?php if ($message): ?>
            <div class="message success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="game-form">
            <form method="POST" class="game-form">
                <label>Platform Name:
                    <input type="text" name="name" value="<?= htmlspecialchars($platform['name']) ?>" required>
                </label>
                <button type="submit" name="update" class="btn-add pulse">✅ Update Platform</button>
            </form>
        </section>

        <div>
            <a href="manage_platforms.php" class="btn-manage">← Back to Platform List</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 The Echo Project - Admin Panel</p>
    </footer>
</body>
</html>
