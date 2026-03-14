<?php
require '../include/load.php';

checkLogin();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die('Your cart is empty.');
}

$total = 0;

foreach ($_SESSION['cart'] as $pid => $qty) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$pid]);
    $price = $stmt->fetchColumn();
    $total += $price * $qty;
}

\Stripe\Stripe::setApiKey('sk_test_key');

$intent = \Stripe\PaymentIntent::create([
    'amount' => $total * 100,
    'currency' => 'usd',
]);
?>