<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../include/db.php';
require_once '../include/auth.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../sign-in.php");
    exit();
}

// Fetch Products and Stats
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn() ?? 0;
    $total_revenue = $conn->query("SELECT SUM(total_amount) FROM orders")->fetchColumn() ?? 0;
    $total_products = count($products);
} catch (PDOException $e) {
    $products = [];
    $total_orders = 0;
    $total_revenue = 0;
    $total_products = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Management | MODEST SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; margin: 0; }
        .main-content { width: 100%; max-width: 1400px; margin: 0 auto; min-height: 100vh; padding: 4rem 2rem; }
        .table-container { background: #0f172a; border-radius: 20px; border: 1px solid #1e293b; overflow: hidden; }
        .input-dark { background: #020617; border: 1px solid #1e293b; color: white; border-radius: 12px; padding: 10px 16px; outline: none; }
    </style>
</head>
<body class="antialiased">

    <main class="main-content">
        <header class="mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Global Catalog</h1>
                <p class="text-slate-500 text-sm mt-1">Real-time inventory sync and collection management.</p>
            </div>
            <a href="add.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-blue-500/20 transition-all">
                Add Premium Asset
            </a>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-slate-800 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total Inventory</p>
                        <h3 class="text-3xl font-black text-white mt-1"><?= $total_products ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-600/10 rounded-xl flex items-center justify-center text-blue-500">
                        <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-3xl"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="bg-[#0f172a] p-6 rounded-2xl border border-slate-800 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Total Volume (Revenue)</p>
                        <h3 class="text-3xl font-black text-white mt-1">₹<?= number_format($total_revenue) ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-emerald-600/10 rounded-xl flex items-center justify-center text-emerald-500">
                        <iconify-icon icon="solar:wad-of-money-bold-duotone" class="text-3xl"></iconify-icon>
                    </div>
                </div>
            </div>

            <div class="bg-[#0f172a] p-6 rounded-2xl border border-slate-800 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Global Orders</p>
                        <h3 class="text-3xl font-black text-white mt-1"><?= $total_orders ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-600/10 rounded-xl flex items-center justify-center text-amber-500">
                        <iconify-icon icon="solar:cart-check-bold-duotone" class="text-3xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container shadow-2xl">
            <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-[#1e293b]/20">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <iconify-icon icon="solar:magnifer-linear" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></iconify-icon>
                        <input type="text" placeholder="Search product..." class="input-dark pl-12 w-64 text-sm">
                    </div>
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-blue-500 text-white rounded-lg text-[10px] font-black uppercase">Grid View</span>
                    <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-lg text-[10px] font-bold uppercase cursor-pointer">List</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] bg-slate-900/50">
                            <th class="px-6 py-4">Thumbnail</th>
                            <th class="px-6 py-4">Product Specs</th>
                            <th class="px-6 py-4">Classification</th>
                            <th class="px-6 py-4">Price Tier</th>
                            <th class="px-6 py-4 text-center">Lifecycle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        <?php foreach($products as $prod): 
                            $img = $prod['image'] ?: 'default.png';
                            if (strpos($img, 'http') === 0) {
                                $imgPath = $img;
                            } else {
                                $imgPath = "../assets/uploads/" . $img;
                            }
                        ?>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-slate-700 overflow-hidden shadow-lg">
                                    <img src="<?= $imgPath ?>" class="w-full h-full object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-white font-bold text-sm leading-none"><?= htmlspecialchars($prod['name']) ?></p>
                                <p class="text-[10px] text-slate-500 mt-1 italic"><?= htmlspecialchars($prod['description'] ?? 'No metadata provided') ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-4 py-1.5 bg-blue-600/10 border border-blue-600/20 text-blue-500 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    <?= htmlspecialchars($prod['category'] ?? 'General') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-white text-sm">
                                ₹<?= number_format((float)$prod['price']) ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="w-8 h-8 rounded-lg bg-blue-600/10 text-blue-500 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                        <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                    </button>
                                    <button class="w-8 h-8 rounded-lg bg-red-600/10 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                        <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>