<?php
require '../include/load.php';
checkLogin(); // Security check


if (!isset($_GET['id'])) {
    redirect('index.php');
}
$id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product nahi mila!");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
    if ($stmt->execute([$name, $price, $id])) {
        set_message("Product update ho gaya!");
        redirect('index.php');
    }
}
?>

<h2>Edit Product <?= e($product['id']) ?></h2>
<form method="POST">
    <label>Product Name:</label><br>
    <input type="text" name="name" value="<?= e($product['name']) ?>" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" value="<?= e($product['price']) ?>" required><br><br>

    <button type="submit">Update Product</button>
    <a href="index.php">Cancel</a>
</form>