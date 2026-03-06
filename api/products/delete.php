
PHP


<?php
require '../../include/load.php';

// We are speaking JSON, not HTML
header('Content-Type: application/json');

// Get the data sent by JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    // Delete Logic
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$data['id']]);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
