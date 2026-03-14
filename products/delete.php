<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

\
require_once '../include/db.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
   

    try {
       
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() > 0) {
        
            header("Location: manage_products.php");
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