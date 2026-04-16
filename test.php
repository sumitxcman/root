<?php
// 1. Force errors to show
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<h2>--- MY SHOP Debugging Mode ---</h2>";

// 2. Check Database File
$db_file = __DIR__ . '/include/db.php';
echo "Checking db.php: ";
if (file_exists($db_file)) {
    echo "<span style='color:green'>Found ✅</span><br>";
    include_once $db_file;
    if (isset($conn)) {
        echo "Database Connection: <span style='color:green'>Connected Successfully! ✅</span><br>";
    } else {
        echo "Database Connection: <span style='color:red'>FAILED ($conn variable not found) ❌</span><br>";
    }
} else {
    echo "<span style='color:red'>NOT FOUND! ❌ (Path: $db_file)</span><br>";
}

// 3. Check Auth File
$auth_file = __DIR__ . '/include/auth.php';
echo "Checking auth.php: ";
if (file_exists($auth_file)) {
    echo "<span style='color:green'>Found ✅</span><br>";
    include_once $auth_file;
    if (function_exists('login')) {
        echo "Login Function: <span style='color:green'>Exists ✅</span><br>";
    } else {
        echo "Login Function: <span style='color:red'>MISSING in auth.php! ❌</span><br>";
    }
} else {
    echo "<span style='color:red'>NOT FOUND! ❌ (Path: $auth_file)</span><br>";
}

// 4. Check Tables
if (isset($conn)) {
    try {
        $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables in Database: <span style='color:blue'>" . implode(", ", $tables) . "</span><br>";
    } catch (Exception $e) {
        echo "Error fetching tables: " . $e->getMessage() . "<br>";
    }
}

echo "<h2>--- End of Test ---</h2>";
?>