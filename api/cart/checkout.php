<?php


require '../../include/load.php';

checkLogin(); 

if (empty($_SESSION['cart'])) {
    header("Location: ../../index.php");
    exit;
}

try {

    
    $db->beginTransaction();

    
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();

    $grandTotal = 0;

    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $grandTotal += $p['price'] * $qty;
    }

    
    $stmt = $db->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $grandTotal]);

    $orderId = $db->lastInsertId();

    
    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmtItems = $db->prepare($sql);

    foreach ($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $stmtItems->execute([$orderId, $p['id'], $qty, $p['price']]);
    }

    
    $db->commit();

    
    $_SESSION['cart'] = [];

    echo "<h1>Order Success! Order ID: #$orderId</h1>";
    echo "<a href='../../index.php'>Continue Shopping</a>";

} catch (Exception $e) {

    r
    $db->rollBack();
    die("Order failed: " . $e->getMessage());
}
