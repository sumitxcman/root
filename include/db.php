<?php
// include/db.php
require_once __DIR__ . '/config.php';

try {
    // $_ENV se data utha raha hai
    $conn = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Log the error internally and show generic message
    error_log("Connection failed: " . $e->getMessage());
    die("A database connection error occurred. Please try again later.");
}
?>