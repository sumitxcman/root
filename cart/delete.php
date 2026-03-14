<?php
require '../include/load.php';


if (!isset($_SESSION['user_id'])) {
    die("Error: Aap logged in nahi hain. Pehle login karein.");
}

if (!isset($_GET['id'])) {
    die("Error: Product ID nahi mili.");
}

$cart_id = (int)$_GET['id']; 
$user_id = $_SESSION['user_id'];

try {
    
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cart_id, $user_id]);

    
    if ($stmt->rowCount() > 0) {
        
        header("Location: index.php?msg=Item removed");
        exit;
    } else {
      
        die("Error: Item delete nahi hua. Shayad ID galat hai.");
    }

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}