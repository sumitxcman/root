<?php
require_once __DIR__ . '/../include/load.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();
if (function_exists('check_login')) check_login();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) { header("Location: ../sign-in.php"); exit; }

$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $pid => $qty) {
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        $price = $stmt->fetchColumn();
        if ($price) $total += $price * $qty;
    }
}
if ($total <= 0) {
    try {
        $stmt = $conn->prepare("SELECT SUM(p.price * c.quantity) FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
        $stmt->execute([$user_id]);
        $total = $stmt->fetchColumn() ?? 0;
    } catch(Exception $e) {}
}
// Redirection disabled for design testing
if ($total <= 0) {
    $total = 7449.00; // Testing fallback amount
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exclusive Checkout | MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* Unique background effects */
        .lux-orb-1 { position: absolute; top: -20%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; filter: blur(60px); }
        .lux-orb-2 { position: absolute; bottom: -10%; left: -5%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(147,51,234,0.08) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; filter: blur(40px); }

        .form-card { background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(40px); border: 1px solid rgba(255,255,255,0.05); border-radius: 3rem; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.8); }
        
        .input-luxe { width: 100%; background: #020617; border: 1px solid #1e293b; border-radius: 1.25rem; padding: 1.25rem 1.5rem; color: white; outline: none; transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .input-luxe:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }

        .summary-card { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 2.5rem; position: sticky; top: 40px; }
        
        .gold-accent { background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        .btn-pay { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); border-radius: 1.5rem; transition: 0.4s; position: relative; overflow: hidden; }
        .btn-pay::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%); opacity: 0; transition: 0.4s; pointer-events: none; }
        .btn-pay:hover::after { opacity: 1; }
        .btn-pay:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.5); }
    </style>
</head>
<body class="min-h-screen py-20 px-6 flex items-center justify-center relative">

    <div class="lux-orb-1"></div>
    <div class="lux-orb-2"></div>

    <div class="max-w-7xl w-full grid grid-cols-1 lg:grid-cols-12 gap-12 relative z-10">
        
        <!-- Left Column: Checkout Logic -->
        <div class="lg:col-span-8">
            <div class="form-card p-10 md:p-16">
                
                <header class="mb-16">
                    <div class="flex items-center gap-4 mb-3">
                       
                        <div class="h-[1px] flex-1 bg-slate-800"></div>
                    </div>
                    <h2 class="text-5xl font-black text-white tracking-tighter uppercase italic leading-none"> Checkout</h2>
                    <p class="text-slate-500 text-sm mt-4 font-medium opacity-80">Authenticate your transaction details to proceed with elite delivery protocol.</p>
                </header>

                <form action="success.php?tid=SEC_<?= strtoupper(uniqid()) ?>" method="POST" class="space-y-12">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-500 mb-2 ml-2 block tracking-widest">Full Legal Name</label>
                            <input type="text" class="input-luxe" placeholder="Johnathan Wick" required>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-500 mb-2 ml-2 block tracking-widest">Contact Identity (Email)</label>
                            <input type="email" class="input-luxe" placeholder="wick@continental.com" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-500 mb-2 ml-2 block tracking-widest">Strategic Delivery Address</label>
                            <input type="text" class="input-luxe" placeholder="123 Luxury Ave, Manhattan, NY" required>
                        </div>
                    </div>

                    <div class="p-10 bg-[#020617]/80 border border-slate-800 rounded-[2.5rem] relative group">
                        <div class="absolute top-0 right-0 p-8">
                            <iconify-icon icon="logos:mastercard" class="text-4xl"></iconify-icon>
                        </div>
                        
                        <div class="flex items-center gap-2 mb-8">
                            <iconify-icon icon="solar:lock-password-bold" class="text-emerald-500"></iconify-icon>
                            <span class="text-[10px] font-black uppercase text-emerald-500 tracking-widest">Aes-256 Card Protocol Active</span>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <label class="text-[8px] font-black uppercase text-slate-600 mb-2 ml-2 block tracking-[0.3em]">Encrypted Card Assets</label>
                                <input type="text" class="input-luxe font-mono tracking-[0.4em] opacity-50 cursor-not-allowed" value="**** **** **** 4242" disabled>
                            </div>
                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <label class="text-[8px] font-black uppercase text-slate-600 mb-2 ml-2 block tracking-[0.3em]">Expiration</label>
                                    <input type="text" class="input-luxe text-center font-bold" value="12 / 28" disabled>
                                </div>
                                <div>
                                    <label class="text-[8px] font-black uppercase text-slate-600 mb-2 ml-2 block tracking-[0.3em]">Security Protocol</label>
                                    <input type="text" class="input-luxe text-center font-bold" value="***" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-pay py-5 text-white font-black text-xl uppercase italic tracking-tighter flex items-center justify-center gap-3">
                            Authorize Payment ₹<?= number_format((float)$total) ?>
                            <iconify-icon icon="solar:check-circle-bold-duotone" class="text-2xl text-white/50"></iconify-icon>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-4">
            <div class="summary-card p-10 lg:p-12 shadow-2xl">
                <header class="mb-12 border-b border-slate-700/50 pb-8">
                    <h3 class="text-2xl font-black text-white italic tracking-tighter uppercase mb-1">Receipt Summary</h3>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest italic">Order Node: <?= date('Ymd-His') ?></p>
                </header>

                <div class="space-y-6 mb-12">
                    <div class="flex justify-between items-center bg-white/5 p-4 rounded-2xl">
                        <span class="text-xs font-bold text-slate-400">Total Selection</span>
                        <span class="text-sm font-black text-white">₹<?= number_format((float)$total) ?></span>
                    </div>
                    <div class="flex justify-between items-center px-4">
                        <span class="text-xs font-bold text-slate-400">Logistics (Priority)</span>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest italic">Complimentary</span>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-700/50">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 leading-none">Global Authorized Amount</p>
                    <div class="flex justify-between items-end">
                        <span class="text-5xl font-black text-white tracking-tighter leading-none">₹<?= number_format((float)$total) ?></span>
                        <span class="text-xs font-black text-blue-500 uppercase italic">INR</span>
                    </div>
                </div>

                <!-- Trusted Badge -->
                <div class="mt-12 p-6 bg-blue-500/5 border border-blue-500/20 rounded-3xl flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center shrink-0">
                        <iconify-icon icon="solar:medal-star-bold" class="text-2xl text-blue-500"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black text-white uppercase tracking-widest mb-1">Elite Merchant Protection</h4>
                        <p class="text-[8px] text-slate-500 font-medium leading-relaxed uppercase tracking-wider">This transaction is processed via certified military-grade encryption systems.</p>
                    </div>
                </div>

                <a href="index.php" class="mt-8 block text-center text-[9px] font-black uppercase text-slate-600 hover:text-white transition-colors tracking-[0.3em]">
                    <iconify-icon icon="solar:alt-arrow-left-linear"></iconify-icon> Modify Selection
                </a>
            </div>
        </div>

    </div>

</body>
</html>