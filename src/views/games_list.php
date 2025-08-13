<?php
require_once __DIR__ . '/../models/db.php';

// Join games with platforms
$sql = "SELECT g.*, p.name AS platform_name
        FROM games g
        LEFT JOIN platforms p ON g.platform_id = p.platform_id
        ORDER BY g.title ASC";

$games = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game List</title>
  <link rel="stylesheet" href="/CodeSlayer/public/css/style.css">
  <style>
    .game-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      padding: 2rem;
    }
    .game-card {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 1rem;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .game-card img {
      max-width: 100%;
      border-radius: 4px;
    }
    .game-tags .tag {
      display: inline-block;
      background: #eee;
      padding: 4px 8px;
      margin: 2px;
      border-radius: 4px;
      font-size: 0.85em;
    }
  </style>
</head>
<body>
  <header>
    <h1 style="text-align:center;">All Games</h1>
  </header>

  <main>
    <div class="game-list">
      <?php foreach ($games as $game): ?>
        <div class="game-card">
          <img src="/CodeSlayer/public/img/<?= htmlspecialchars($game['image_path']) ?>" alt="<?= htmlspecialchars($game['title']) ?>">
          <h3><?= htmlspecialchars($game['title']) ?></h3>
          <p><strong>Price:</strong> $<?= number_format($game['price'], 2) ?></p>
          <p><strong>Platform:</strong> <?= htmlspecialchars($game['platform_name'] ?? 'Unknown') ?></p>
          <div class="game-tags">
            <?php
              if (!empty($game['tags'])) {
                foreach (explode(',', $game['tags']) as $tag) {
                  echo "<span class='tag'>" . htmlspecialchars(trim($tag)) . "</span>";
                }
              } else {
                echo "<span class='tag'>No tags</span>";
              }
            ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer>
    <p style="text-align:center;">&copy; 2025 CodeSlayer Game Store</p>
  </footer>
  <!-- Loading Spinner Overlay -->
<div class="spinner-overlay" id="loading" style="display:none;">
  <div class="spinner"></div>
</div>
    <script src="/CodeSlayer/public/js/app.js"></script>
    </script>
</body>
</html>
