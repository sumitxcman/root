<?php
require_once '../include/load.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Purana data nikalna
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found!");
}

include '../partials/head.php';
include '../partials/header.php';
include '../partials/sidebar.php';
?>

<div class="main-content">
    <h2>Edit User</h2>
    <form action="../api/users/edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        
        <div class="form-group">
            <label>Full Name:</label><br>
            <input type="text" name="name" value="<?= $user['name'] ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label><br>
            <input type="email" name="email" value="<?= $user['email'] ?>" required>
        </div>
        <p><small>Leave password blank if you don't want to change it.</small></p>
        <div class="form-group">
            <label>New Password:</label><br>
            <input type="password" name="password">
        </div>
        <br>
        <button type="submit">Update User</button>
        <a href="index.php">Cancel</a>
    </form>
</div>

<?php include '../partials/footer.php'; ?>