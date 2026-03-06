<?php
require '../../include/load.php'; // Path check kar lein apne folder ke hisab se

header('Content-Type: application/json');

// Check karein ke user login hai ya nahi
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Pehle login karein!']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check karein ke product_id mil rahi hai ya nahi
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

    // Database mein insert karna
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$user_id, $product_id, $quantity])) {
        echo json_encode(['status' => 'success', 'message' => 'Item cart mein add ho gaya!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error!']);
    }
} else {
    // Agar direct URL khola jaye bina ID ke
    echo json_encode([
        'status' => 'error', 
        'message' => 'Product ID missing hai. URL ke aage ?product_id=6 lagakar check karein.'
    ]);
}