<?php
require_once __DIR__ . '/../models/db.php';

// Use $selected_platform_id if it's set, otherwise default to null
$selected_platform_id = $selected_platform_id ?? null;

// Fetch platforms from the database
$platforms = $pdo->query("SELECT platform_id, name FROM platforms ORDER BY name ASC")->fetchAll();
?>

<select name="platform_id" required>
    <option value="">-- Select Platform --</option>
    <?php foreach ($platforms as $platform): ?>
        <option value="<?= $platform['platform_id'] ?>"
            <?= $platform['platform_id'] == $selected_platform_id ? 'selected' : '' ?>>
            <?= htmlspecialchars($platform['name']) ?>
        </option>
    <?php endforeach; ?>
</select>
