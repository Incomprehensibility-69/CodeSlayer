<?php
require_once __DIR__ . '/../models/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT g.*, p.name AS platform_name FROM games g LEFT JOIN platforms p ON g.platform_id = p.platform_id WHERE g.game_id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) {
    echo "<h2>Game not found.</h2>";
    exit;
}

$title = htmlspecialchars($game['title']);
$price = number_format($game['price'], 2);
$image = htmlspecialchars($game['image_path']);
$platform = htmlspecialchars($game['platform_name'] ?? 'Unknown');
$description = nl2br(htmlspecialchars($game['description'] ?? 'No description available.'));
$screenshots = isset($game['screenshots']) ? explode(',', $game['screenshots']) : [];
$reviews = isset($game['reviews']) ? explode(',', $game['reviews']) : [];
$tags = isset($game['tags']) ? explode(',', $game['tags']) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?> - Game Details</title>
  <link rel="stylesheet" href="/CodeSlayer/public/css/style.css">
  <style>
    .detail-container {
      max-width: 800px;
      margin: 2rem auto;
      padding: 1rem;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }
    .detail-container img {
      max-width: 100%;
      border-radius: 6px;
    }
    .screenshot-gallery img {
      max-width: 180px;
      margin: 8px;
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
    .review-box {
      background: #f9f9f9;
      padding: 1rem;
      margin-top: 1rem;
      border-left: 4px solid #00b8d9;
    }
  </style>
</head>
<body>
  <header>
    <h1 style="text-align:center;">Game Details</h1>
  </header>

  <main>
    <div class="detail-container">
      <img src="/CodeSlayer/public/img/<?= $image ?>" alt="<?= $title ?>">
      <h2><?= $title ?></h2>
      <p><strong>Price:</strong> $<?= $price ?></p>
      <p><strong>Platform:</strong> <?= $platform ?></p>
      <div class="game-tags">
        <?php
          if (!empty($tags)) {
            foreach ($tags as $tag) {
              echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';
            }
          } else {
            echo '<span class="tag">No tags</span>';
          }
        ?>
      </div>

      <h3>Description</h3>
      <p><?= $description ?></p>

      <?php if (!empty($screenshots)): ?>
        <h3>Screenshots</h3>
        <div class="screenshot-gallery">
          <?php foreach ($screenshots as $shot): ?>
            <img src="/CodeSlayer/public/img/<?= htmlspecialchars(trim($shot)) ?>" alt="Screenshot">
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($reviews)): ?>
        <h3>Reviews</h3>
        <?php foreach ($reviews as $review): ?>
          <div class="review-box"><?= htmlspecialchars(trim($review)) ?></div>
        <?php endforeach; ?>
      <?php endif; ?>

      <button onclick="addToCart('<?= addslashes($title) ?>', <?= $price ?>)">Add to Cart</button>
    </div>
  </main>

  <footer>
    <p style="text-align:center;">&copy; 2025 CodeSlayer Game Store</p>
  </footer>
</body>
</html>
