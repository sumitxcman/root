
<?php
// Note: We go back 2 levels to find 'include'
require '../../include/load.php';

// STRICT: No HTML Allowed here.
header('Content-Type: application/json');

// Check Login (Admins only!)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

// Get JSON Input
$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? null;

if ($id) {
    // Prevent deleting yourself!
    if ($id == $_SESSION['user_id']) {
        echo json_encode(['status' => 'error', 'message' => 'You cannot delete yourself!']);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No ID provided']);
}
?>
