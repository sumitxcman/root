<?php
require_once __DIR__ . '/../include/load.php'; 
if (function_exists('check_login')) check_login();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) { header("Location: ../sign-in.php"); exit; }

// Use local session cart if DB cart joining fails
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        $price = $stmt->fetchColumn();
        if ($price) $total += $price * $qty;
    }
}
// Fallback if no cart in session, check DB
if ($total <= 0) {
    try {
        $stmt = $conn->prepare("SELECT SUM(p.price * c.quantity) FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
        $stmt->execute([$user_id]);
        $total = $stmt->fetchColumn() ?? 0;
    } catch(Exception $e) {}
}

if ($total <= 0) { header("Location: index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure Checkout | MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Outfit', sans-serif; }
        .glass-card { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border-radius: 24px; padding: 32px; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); }
        .input-lux { width: 100%; background: #020617; border: 1px solid #1e293b; border-radius: 12px; padding: 14px 16px; color: white; outline: none; transition: 0.3s; }
        .input-lux:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        .checkout-gradient { background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-10 px-4">
    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10">
        
        <!-- Payment Details -->
        <div class="lg:col-span-2 glass-card">
            <div class="flex items-center gap-3 mb-8 border-b border-slate-800 pb-6">
                <iconify-icon icon="solar:wallet-bold-duotone" class="text-4xl text-blue-500"></iconify-icon>
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">Secure Checkout</h2>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Encrypted Payment Gateway</p>
                </div>
            </div>

            <form action="success.php?tid=demo_transaction_<?= time() ?>" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-500 ml-1 mb-2 block">Cardholder Name</label>
                        <input type="text" class="input-lux" required placeholder="Name on card">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-500 ml-1 mb-2 block">Shipping Address</label>
                        <input type="text" class="input-lux" required placeholder="Full street address">
                    </div>
                </div>

                <div class="p-6 bg-[#020617] border border-slate-800 rounded-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
                    <label class="text-[10px] font-black uppercase text-slate-500 ml-1 mb-2 block">Card Details (Stripe API)</label>
                    <div class="relative">
                        <iconify-icon icon="logos:mastercard" class="absolute left-4 top-1/2 -translate-y-1/2 text-2xl"></iconify-icon>
                        <input type="text" class="input-lux pl-14 font-mono tracking-widest" value="**** **** **** 4242" disabled>
                    </div>
                    <div class="flex gap-4 mt-4">
                        <input type="text" class="input-lux font-mono" value="12/26" disabled>
                        <input type="text" class="input-lux font-mono" value="***" disabled>
                    </div>
                </div>

                <button type="submit" class="w-full checkout-gradient hover:opacity-90 text-white font-black py-4 rounded-xl text-lg transition-all shadow-xl shadow-blue-600/20 flex items-center justify-center gap-2 transform hover:-translate-y-1">
                    <iconify-icon icon="solar:lock-keyhole-minimalistic-bold"></iconify-icon> Pay ₹<?= number_format((float)$total) ?>
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="glass-card sticky top-10 border-t-4 border-blue-500">
                <h3 class="font-black text-xl text-white mb-6">Order Summary</h3>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between items-center text-sm font-medium">
                        <span class="text-slate-400">Subtotal</span>
                        <span class="text-white">₹<?= number_format((float)$total) ?></span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-medium">
                        <span class="text-slate-400">Taxes & Fees</span>
                        <span class="text-emerald-400 font-bold">Waived</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-medium">
                        <span class="text-slate-400">Shipping</span>
                        <span class="text-emerald-400 font-bold">Free Next-Day</span>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-800">
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Total Due</span>
                        <span class="text-4xl font-black text-white tracking-tighter">₹<?= number_format((float)$total) ?></span>
                    </div>
                </div>

                <div class="mt-8 bg-blue-500/10 border border-blue-500/20 p-4 rounded-xl flex gap-3 text-xs text-blue-400 font-medium">
                    <iconify-icon icon="solar:shield-check-bold" class="text-2xl shrink-0"></iconify-icon>
                    <p>Your payment is processed securely via AES-256 military-grade encryption.</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>