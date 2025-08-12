<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your test code below
$password = 'nathanael1028';
$hash = '$2y$10$WYr2edI8yPdq89CRhwCzAOGvpCLHjRkFs25kUuZBKtiSu/upnwOQm';

echo password_verify($password, $hash) ? 'Match' : 'No match';
?>

