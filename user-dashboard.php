<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/include/db.php';

// If user is not logged in, redirect to sign-in page
if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $user = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0b1121; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card { background: #1e293b; border-radius: 16px; padding: 24px; border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    
    <!-- Top Header -->
    <header class="h-20 border-b border-slate-800 flex items-center justify-between px-10 bg-[#0f172a] sticky top-0 z-50">
        <a href="index.php" class="text-white text-2xl font-black italic">MY SHOP</a>
        <div class="flex items-center gap-4">
            <a href="index.php" class="text-sm font-bold text-slate-400 hover:text-white transition">Home Menu</a>
            <a href="logout.php" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl text-xs font-bold uppercase transition">Logout</a>
        </div>
    </header>

    <main class="flex-1 p-10 max-w-5xl mx-auto w-full">
        <h1 class="text-3xl font-black text-white mb-2 uppercase">My Account</h1>
        <p class="text-sm text-slate-500 mb-8">Welcome back, <?= htmlspecialchars($user['fullname'] ?? $user['username'] ?? 'User') ?>!</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- User Info Card -->
            <div class="glass-card md:col-span-1 border-t-4 border-blue-500">
                <div class="flex flex-col items-center text-center">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username'] ?? 'U') ?>&background=3b82f6&color=fff&size=128" class="w-24 h-24 rounded-full border-4 border-slate-800 mb-4 shadow-lg shadow-blue-500/20">
                    <h2 class="text-xl font-bold text-white"><?= htmlspecialchars($user['fullname'] ?? 'Unknown User') ?></h2>
                    <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mt-1">@<?= htmlspecialchars($user['username'] ?? 'n/a') ?></p>
                    <p class="text-sm text-slate-500 mt-2"><?= htmlspecialchars($user['email'] ?? 'No email provided') ?></p>
                </div>
                
                <hr class="border-slate-800 my-6">
                
                <ul class="space-y-4">
                    <li class="flex items-center justify-between">
                        <span class="text-sm">Account Status:</span>
                        <span class="px-2 py-1 bg-emerald-500/10 text-emerald-500 rounded text-[10px] font-bold uppercase">Active</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-sm">Role</span>
                        <span class="text-white font-medium capitalize"><?= htmlspecialchars($user['role'] ?? 'User') ?></span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-sm">Member Since</span>
                        <span class="text-slate-400 font-medium text-xs"><?= isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : 'Recently' ?></span>
                    </li>
                </ul>
            </div>

            <!-- Recent Activity & Quick Links -->
            <div class="md:col-span-2 space-y-6">
                
                <div class="glass-card">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                        <iconify-icon icon="solar:cart-large-minimalistic-bold" class="text-blue-500"></iconify-icon> My Orders
                    </h3>
                    <div class="bg-slate-900/50 rounded-xl p-6 text-center border border-slate-800 border-dashed">
                        <iconify-icon icon="solar:box-minimalistic-linear" class="text-4xl text-slate-600 mb-2"></iconify-icon>
                        <p class="text-sm text-slate-400">You haven't placed any orders yet.</p>
                        <a href="index.php" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-lg uppercase tracking-widest transition-all">Start Shopping</a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <a href="cart/index.php" class="glass-card hover:border-blue-500 transition-all flex items-center gap-4 group cursor-pointer">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                            <iconify-icon icon="solar:cart-bold" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">View Cart</h4>
                            <p class="text-xs text-slate-500">Check selected items</p>
                        </div>
                    </a>

                    <a href="#" class="glass-card hover:border-emerald-500 transition-all flex items-center gap-4 group cursor-pointer">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                            <iconify-icon icon="solar:settings-bold" class="text-2xl"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm">Account Settings</h4>
                            <p class="text-xs text-slate-500">Update your profile</p>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </main>

</body>
</html>
