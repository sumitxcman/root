<?php
require '../include/load.php';

// Debugging ke liye check karein (Agar delete na ho toh ye kaam aayega)
if (!isset($_SESSION['user_id'])) {
    die("Error: Aap logged in nahi hain. Pehle login karein.");
}

if (!isset($_GET['id'])) {
    die("Error: Product ID nahi mili.");
}

$cart_id = (int)$_GET['id']; // ID ko number mein convert karein
$user_id = $_SESSION['user_id'];

try {
    // Sirf wahi row delete karein jo is user ki ho
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cart_id, $user_id]);

    // Check karein ke koi row delete hui bhi ya nahi
    if ($stmt->rowCount() > 0) {
        // Success: Wapas cart par bhej dein
        header("Location: index.php?msg=Item removed");
        exit;
    } else {
        // Masla: ID galat hai ya ye product is user ka nahi hai
        die("Error: Item delete nahi hua. Shayad ID galat hai.");
    }

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}