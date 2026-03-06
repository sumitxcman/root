<?php
// Errors on karein takay pata chale kyun delete nahi ho raha
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection file ka rasta (Apne structure ke hisaab se check karein)
require_once '../include/db.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Debug: Check karne ke liye ke ID mil rahi hai ya nahi
    // die("ID mil gayi hai: " . $id); 

    try {
        // 1. Database se delete karein
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() > 0) {
            // Agar delete ho gaya toh wapas list par bhej do
            header("Location: manage_products.php"); // Yahan apni list wali file ka naam likhein
            exit();
        } else {
            echo "Galti: Is ID ka koi product database mein nahi mila.";
        }

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
} else {
    echo "ID nahi mili. Link sahi nahi hai.";
}