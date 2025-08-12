<?php
// Check if required POST data is set
if (!isset($_POST['new_password'], $_POST['token'])) {
    echo "Missing data.";
    exit;
}

// Make sure $conn is initialized before using it
// Example: $conn = new mysqli($host, $user, $pass, $db);

$new_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password_hash=?, reset_token=NULL, token_expiry=NULL WHERE reset_token=?");
if (!$stmt) {
    echo "Prepare failed: " . $conn->error;
    exit;
}
$stmt->bind_param("ss", $new_hash, $_POST['token']);
if (!$stmt->execute()) {
    echo "Execute failed: " . $stmt->error;
    exit;
}
echo "Password updated!";
?>
