<?php
require_once __DIR__ . '/../include/load.php';
// Use explicit auth function
if (function_exists('check_login')) check_login();

if ($_SESSION['role'] !== 'admin') {
    die(json_encode(['status' => 'error', 'message' => 'Unauthorized Access']));
}

header('Content-Type: application/json');

$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

// If ID passed via JSON (fetch/axios) OR $_GET
$target_id = $data['id'] ?? current(array_keys($_GET)) ?? $_GET['id'] ?? null;

if ($target_id) {
    try {
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        if($stmt->execute([$target_id])) {
            // Also delete associated order items for referential integrity if needed
            echo json_encode(['status' => 'success', 'message' => 'Product successfully removed from catalog']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete']);
        }
    } catch (PDOException $e) {
        // If error 1451 foreign key constraint fails
        echo json_encode(['status' => 'error', 'message' => 'Cannot delete product because it is associated with past orders.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Product ID']);
}
?>