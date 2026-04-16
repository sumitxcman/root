<?php
// 1. Load configuration and DB connection
require_once __DIR__ . '/../../include/load.php';

// 2. We are speaking JSON, not HTML
header('Content-Type: application/json');

// 3. Get the data sent by JavaScript
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

if (isset($data['id'])) {
    try {
        // 4. Delete Logic (Products table use karein users ki jagah agar product delete kar rahe hain)
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$data['id']]);
        
        echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No ID provided']);
}
?>