<?php
session_start();

// --- Authentication & Authorization ---
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_COOKIE['remember_me'])) {
        $_SESSION['logged_in'] = true;
    } else {
        header('Location: login.php');
        exit;
    }
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo 'Access denied.';
    exit;
}

// --- Database ---
require_once __DIR__ . '/../models/db.php'; // provides $pdo

// --- Validate & Sanitize ID ---
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die('Invalid game ID.');
}

// --- Delete Game ---
$stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
$stmt->execute([$id]);

// --- Redirect Back to Dashboard ---
header('Location: dashboard.php');
exit;
