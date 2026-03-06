<?php
require '../include/load.php';
checkLogin();

$tid = $_GET['tid'] ?? null;

if (!$tid) {
    die('Payment failed.');
}

\Stripe\Stripe::setApiKey('sk_test_key');

$intent = \Stripe\PaymentIntent::retrieve($tid);

if ($intent->status === 'succeeded') {

    $total = 0;

    foreach ($_SESSION['cart'] as $pid => $qty) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        $price = $stmt->fetchColumn();
        $total += $price * $qty;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO orders (user_id, total_amount, status, created_at)
         VALUES (?, ?, 'Pending', NOW())"
    );
    $stmt->execute([$_SESSION['user_id'], $total]);

    $order_id = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $pid => $qty) {
        $stmt = $pdo->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$order_id, $pid, $qty, $price]);
    }

    unset($_SESSION['cart']);

    echo "<h1>Payment Successful</h1>";

    $msg = "
        <h1>Order Confirmation</h1>
        <p>Transaction ID: $tid</p>
        <p>Total: $$total</p>
    ";

    sendEmail($_SESSION['user_email'], 'Your Order Receipt', $msg);

} else {
    echo "Payment not completed.";
}