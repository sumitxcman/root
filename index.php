<?php
session_start();
include_once 'include/db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$username = $_SESSION['username'] ?? 'User';

// Products Fetch
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $products = []; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MY SHOP | Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-header { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid #1e293b; }
        .product-card { background: #0f172a; border: 1px solid #1e293b; border-radius: 1.5rem; transition: 0.3s; }
        .product-card:hover { border-color: #3b82f6; transform: translateY(-5px); }
    </style>
</head>
<body>
    <header class="glass-header sticky top-0 z-50 h-[80px] flex items-center px-8 justify-between">
        <div class="text-white text-2xl font-black italic">MY SHOP</div>
        
        <div class="flex items-center gap-4">
            <?php if(!$isLoggedIn): ?>
                <a href="sign-in.php" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">Login</a>
            <?php else: ?>
                <div class="flex items-center gap-3 bg-slate-900/50 p-1 pr-4 rounded-2xl border border-slate-800">
                    <?php if($isAdmin): ?>
                        <a href="dashboard.php" class="bg-blue-500/10 text-blue-500 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase border border-blue-500/20">Admin Panel</a>
                    <?php else: ?>
                        <a href="user-dashboard.php" class="bg-emerald-500/10 text-emerald-500 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase border border-emerald-500/20">My Account</a>
                    <?php endif; ?>
                    <img src="https://ui-avatars.com/api/?name=<?= $username ?>&background=3b82f6&color=fff" class="w-8 h-8 rounded-lg">
                    <a href="logout.php" class="text-[10px] font-bold text-red-400 uppercase">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main class="max-w-[1440px] mx-auto p-12">
        <h2 class="text-3xl font-black text-white uppercase mb-8">New Arrivals</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($products as $prod): ?>
                <div class="product-card p-4">
                    <img src="assets/uploads/<?= $prod['image'] ?>" class="w-full h-48 object-cover rounded-xl mb-4" onerror="this.src='https://placehold.co/400x400/1e293b/3b82f6?text=Product'">
                    <h4 class="text-white font-bold"><?= htmlspecialchars($prod['name']) ?></h4>
                    <p class="text-blue-500 font-black mt-2">₹<?= number_format($prod['price']) ?></p>
                    <button class="w-full bg-slate-800 hover:bg-blue-600 text-white py-2 rounded-lg mt-4 text-xs font-bold transition-all">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>