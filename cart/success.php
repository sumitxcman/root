<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../include/load.php';

// Check correct auth
if (function_exists('check_login')) {
    check_login();
}

$tid = $_GET['tid'] ?? null;

if (!$tid) {
    die('<div style="background-color: #0b1121; color: white; padding: 50px; text-align: center; font-family: sans-serif;"><h2>❌ Invalid Transaction</h2><p>Payment failed or session expired.</p><a href="../index.php">Go Back</a></div>');
}

// In a real production app we'd verify the Stripe webhook or Intent here 
// \Stripe\Stripe::setApiKey('sk_test_key');
// $intent = \Stripe\PaymentIntent::retrieve($tid);
$payment_status = 'succeeded'; // Skipping Stripe validation for testing

$total = 0;
$order_items = [];

if ($payment_status === 'succeeded' && !empty($_SESSION['cart'])) {
    
    // First loop: calculate proper price for EACH individual item
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $stmt = $conn->prepare("SELECT price, name, image FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($prod) {
            $total += $prod['price'] * $qty;
            $order_items[] = [
                'id' => $pid,
                'qty' => $qty,
                'price' => $prod['price'],
                'name' => $prod['name'],
                'image' => $prod['image']
            ];
        }
    }

    if ($total > 0) {
        // Insert main order record
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (?, ?, 'Paid', NOW())");
        if($_SESSION['user_id'] ?? false) {
            $stmt->execute([$_SESSION['user_id'], $total]);
            $order_id = $conn->lastInsertId();

            // Store items with mapped correct pricing & REDUCE STOCK
            foreach ($order_items as $item) {
                // 1. Insert into order_items
                $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $item_stmt->execute([$order_id, $item['id'], $item['qty'], $item['price']]);

                // 2. Decrement Stock centrally
                $stock_stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $stock_stmt->execute([$item['qty'], $item['id']]);
            }
        }
        // Clear the cart successfully!
        unset($_SESSION['cart']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; overflow: hidden; }
        .glass-card { background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(40px); border-radius: 3rem; padding: 3rem; border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="glass-card max-w-lg w-full text-center border-t-4 border-emerald-500 shadow-2xl shadow-emerald-500/20 scale-up">
        
        <div class="w-24 h-24 bg-emerald-500/10 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 transform -translate-y-12 shadow-lg border border-emerald-500/20 bg-clip-padding backdrop-filter backdrop-blur-xl">
            <iconify-icon icon="solar:check-circle-bold" class="text-6xl drop-shadow-md"></iconify-icon>
        </div>
        
        <div class="mt-[-40px]">
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter mb-2">Order Confirmed!</h1>
            <p class="text-slate-400 text-sm mb-8">Thank you for shopping with us. Your transaction was successful and your order is being processed.</p>
            
            <div class="bg-slate-900/50 rounded-2xl p-6 border border-slate-800 mb-8 border-dashed shadow-inner flex flex-col justify-center items-center">
                <p class="text-[10px] uppercase font-bold tracking-[0.2em] text-slate-500 mb-1">Total Paid</p>
                <h2 class="text-4xl font-black text-emerald-400 drop-shadow-sm">₹<?= number_format((float)$total) ?></h2>
                <div class="mt-4 px-4 py-2 bg-emerald-500/10 rounded-xl text-xs font-bold text-emerald-500 border border-emerald-500/20">
                    Trans. ID: #<?= htmlspecialchars($tid) ?>
                </div>
            </div>

            <div class="flex gap-4 justify-center">
                <a href="../user-dashboard.php" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-3.5 px-6 rounded-[14px] text-xs uppercase tracking-widest transition-all shadow-lg w-full">View Dashboard</a>
                <a href="../index.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-[14px] text-xs uppercase tracking-widest shadow-xl shadow-blue-600/20 transition-all w-full">Keep Shopping</a>
            </div>
        </div>
    </div>
    
    <!-- Micro-animation scale up -->
    <style>
        html { font-size: 14px; /* Global scale down */ }
        @keyframes scaleUp {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .scale-up { animation: scaleUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</body>
</html>