<?php
require_once __DIR__ . '/../models/db.php';

$game_id = $_GET['id'] ?? null;
if (!$game_id) {
    echo "Game ID is missing.";
    exit;
}

// Fetch game data
$stmt = $pdo->prepare("SELECT * FROM games WHERE game_id = ?");
$stmt->execute([$game_id]);
$game = $stmt->fetch();

if (!$game) {
    echo "Game not found.";
    exit;
}

// Fetch platforms
$platforms = $pdo->query("SELECT platform_id, name FROM platforms ORDER BY name ASC")->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $release_date = $_POST['release_date'] ?? '';
    $stock = $_POST['stock'] ?? 0;
    $platform_id = $_POST['platform_id'] ?? null;
    $tags = $_POST['tags'] ?? '';
    $screenshots = $_POST['screenshots'] ?? '';
    $reviews = $_POST['reviews'] ?? '';
    $image_path = $game['image_path']; // keep existing if not replaced

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $filename = basename($_FILES['image']['name']);
        $target = __DIR__ . '/../../public/img/' . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = $filename;
        }
    }

    $stmt = $pdo->prepare(
        "UPDATE games SET title = ?, price = ?, description = ?, image_path = ?, genre = ?, release_date = ?, stock = ?, platform_id = ?, tags = ?, screenshots = ?, reviews = ? 
         WHERE game_id = ?"
    );
    $stmt->execute([$title, $price, $description, $image_path, $genre, $release_date, $stock, $platform_id, $tags, $screenshots, $reviews, $game_id]);

    header('Location: games_list.php?message=Game updated successfully');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Game</title>
    <link rel="stylesheet" href="/CodeSlayer/public/css/admin.css">
    <script>
    function validateForm() {
        const platform = document.forms["gameForm"]["platform_id"].value;
        if (platform === "") {
            alert("Please select a platform.");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<header>
    <h1>CodeSlayer Admin Panel</h1>
</header>

<main>
    <h2>Edit Game</h2>
    <form name="gameForm" method="POST" class="game-form" onsubmit="return validateForm();" enctype="multipart/form-data">
        <label>Title:
            <input type="text" name="title" value="<?= htmlspecialchars($game['title']) ?>" required>
        </label>

        <label>Price:
            <input type="number" name="price" step="0.01" value="<?= $game['price'] ?>" required>
        </label>

        <label>Description:
            <textarea name="description" required><?= htmlspecialchars($game['description']) ?></textarea>
        </label>

        <label>Genre:
            <input type="text" name="genre" value="<?= htmlspecialchars($game['genre']) ?>">
        </label>

        <label>Platform:</label>
        <?php
        $selected_platform_id = $game['platform_id'];
        include __DIR__ . '/../components/platform_dropdown.php';
        ?>

        <label>Release Date:
            <input type="date" name="release_date" value="<?= $game['release_date'] ?>">
        </label>

        <label>Stock:
            <input type="number" name="stock" value="<?= $game['stock'] ?>" required>
        </label>

        <label>Tags (comma-separated):
            <input type="text" name="tags" value="<?= htmlspecialchars($game['tags']) ?>">
        </label>

        <label>Screenshots (comma-separated filenames):
            <input type="text" name="screenshots" value="<?= htmlspecialchars($game['screenshots']) ?>">
        </label>

        <label>Reviews (comma-separated):
            <textarea name="reviews" rows="3"><?= htmlspecialchars($game['reviews']) ?></textarea>
        </label>

        <label>Cover Image:</label>
        <div id="drop-zone" style="border:2px dashed #ccc; padding:20px; text-align:center; border-radius:8px; cursor:pointer;">
            <p>Drag & drop an image here or click to select</p>
            <input type="file" name="image" id="image-input" accept="image/*" style="display:none;">
            <img id="preview" 
                 src="<?= !empty($game['image_path']) ? '/CodeSlayer/public/img/' . htmlspecialchars($game['image_path']) : '' ?>" 
                 alt="Preview" 
                 style="max-width:100%; margin-top:10px; border-radius:6px; <?= empty($game['image_path']) ? 'display:none;' : '' ?>">
        </div>

        <button type="submit">Update Game</button>
    </form>
</main>

<footer>
    <p>&copy; 2025 The Echo Project - Admin Panel</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropZone = document.getElementById('drop-zone');
    const imageInput = document.getElementById('image-input');
    const preview = document.getElementById('preview');

    dropZone.addEventListener('click', () => imageInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#00b8d9';
        dropZone.style.background = '#f0faff';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = '#ccc';
        dropZone.style.background = '#fff';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        resetStyles();
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            imageInput.files = e.dataTransfer.files;
            showPreview(file);
        }
    });

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];
        if (file) showPreview(file);
    });

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    function resetStyles() {
        dropZone.style.borderColor = '#ccc';
        dropZone.style.background = '#fff';
    }
});
</script>
</body>
</html>
