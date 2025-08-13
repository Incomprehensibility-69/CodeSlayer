<?php
function renderGameCard($game) {
    $title = htmlspecialchars($game['title']);
    $price = number_format($game['price'], 2);
    $image = htmlspecialchars($game['image_path']);
    $platform = htmlspecialchars($game['platform_name'] ?? 'Unknown');
    $tags = isset($game['tags']) ? explode(',', $game['tags']) : [];
    $id = (int)$game['game_id'];

    echo '<div class="game-card">';
    echo '<a href="/CodeSlayer/src/views/game_detail.php?id=' . $id . '">';
    echo '<img src="/CodeSlayer/public/img/' . $image . '" alt="' . $title . '">';
    echo '</a>';
    echo '<h4><a href="/CodeSlayer/src/views/game_detail.php?id=' . $id . '">' . $title . '</a></h4>';
    echo '<p><strong>Price:</strong> $' . $price . '</p>';

    // Platform icon
    $iconFile = strtolower(str_replace(' ', '', $platform)) . '.png';
    echo '<div class="platform-icons">';
    echo '<img src="/CodeSlayer/public/img/' . $iconFile . '" alt="' . $platform . '" title="' . $platform . '" class="platform-icon">';
    echo '</div>';

    // Tags
    echo '<div class="game-tags">';
    if (!empty($tags)) {
        foreach ($tags as $tag) {
            echo '<span class="tag">' . htmlspecialchars(trim($tag)) . '</span>';
        }
    } else {
        echo '<span class="tag">No tags</span>';
    }
    echo '</div>';

    echo '<button onclick="addToCart(\'' . addslashes($title) . '\', ' . $price . ')">Add to Cart</button>';
    echo '</div>';
}
?>
