<?php
/**
 * db.php
 * Central PDO connection file for the admin system.
 */

$host     = 'localhost';     // Hostname
$dbname   = 'game_store';    // Database name
$username = 'root';          // DB username (XAMPP default is 'root')
$password = '';              // DB password (XAMPP default is empty)

// Data Source Name (DSN) — tells PDO how to connect
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Create PDO instance with recommended options
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return rows as associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements if available
    ]);
} catch (PDOException $e) {
    // Stop script and display a safe error
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
