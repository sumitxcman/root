
<?php

require '../../include/load.php';


header('Content-Type: application/json');


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}


$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? null;

if ($id) {
   
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
