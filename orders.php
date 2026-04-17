<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'include/db.php';
require_once 'include/auth.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: sign-in.php");
    exit();
}

// Fetch Orders with User details
// We aggregate products into a comma-separated string for simplicity in table view
$sql = "SELECT o.*, u.fullname, u.email, u.phone, u.address, 
        GROUP_CONCAT(p.name SEPARATOR ', ') as product_list
        FROM orders o
        JOIN users u ON o.user_id = u.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        GROUP BY o.id
        ORDER BY o.created_at DESC";

try {
    $stmt = $conn->query($sql);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $orders = [];
    $error = "DB Error: " . $e->getMessage();
}

function getStatusBadge($status) {
    $status = strtolower($status);
    $classes = "px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border ";
    switch ($status) {
        case 'delivered':
        case 'paid':
        case 'succeeded':
            return $classes . "bg-emerald-500/10 text-emerald-500 border-emerald-500/20";
        case 'pending':
        case 'unpaid':
            return $classes . "bg-amber-500/10 text-amber-500 border-amber-500/20";
        case 'cancelled':
            return $classes . "bg-red-500/10 text-red-500 border-red-500/20";
        default:
            return $classes . "bg-blue-500/10 text-blue-500 border-blue-500/20";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders | MODEST SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 12px; /* Global scale down */ }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; }
        .main-content { margin-left: 19rem; min-height: 100vh; padding: 2rem; }
        .table-container { background: #0f172a; border-radius: 20px; border: 1px solid #1e293b; overflow: hidden; }
        .table-row:hover { background: rgba(255,255,255,0.02); }
        .input-dark { background: #020617; border: 1px solid #1e293b; color: white; border-radius: 12px; padding: 10px 16px; outline: none; transition: 0.3s; }
        .input-dark:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="antialiased">

    <?php include 'partials/sidebar.php'; ?>

    <main class="main-content">
        <!-- Header -->
        <header class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-2xl font-black text-white tracking-tighter uppercase italic">Customer Orders</h2>
                <p class="text-slate-500 text-sm mt-1">Manage and track your global commerce transactions.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></iconify-icon>
                    <input type="text" placeholder="Search Order ID or Email..." class="input-dark pl-12 w-80">
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-blue-500/20 transition-all">
                    Export List
                </button>
            </div>
        </header>

        <!-- Stats Bar -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-slate-800">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Total Volume</p>
                <h3 class="text-2xl font-black text-white mt-1">₹<?= number_format(array_sum(array_column($orders, 'total_amount'))) ?></h3>
            </div>
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-slate-800">
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Total Orders</p>
                <h3 class="text-2xl font-black text-white mt-1"><?= count($orders) ?></h3>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container shadow-2xl">
            <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-[#1e293b]/20">
                <h4 class="text-sm font-black text-white uppercase tracking-widest">Recent Transactions</h4>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-500 rounded-lg text-[10px] font-bold uppercase">All Status</span>
                    <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-lg text-[10px] font-bold uppercase cursor-pointer">Unpaid</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] bg-slate-900/50">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Products</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        <?php if(empty($orders)): ?>
                            <tr>
                                <td colspan="8" class="p-20 text-center font-bold text-slate-600">No orders found in database.</td>
                            </tr>
                        <?php endif; ?>
                        
                        <?php foreach($orders as $row): ?>
                        <tr class="table-row group transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-white font-black text-sm">#<?= str_pad($row['id'], 6, '0', STR_PAD_LEFT) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-600/10 flex items-center justify-center text-blue-500 font-black border border-blue-500/20 uppercase text-xs">
                                        <?= substr($row['fullname'], 0, 1) ?>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-sm leading-none"><?= htmlspecialchars($row['fullname']) ?></p>
                                        <p class="text-[10px] text-slate-500 mt-1"><?= htmlspecialchars($row['email']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-[200px] truncate">
                                    <span class="text-xs text-slate-300 font-medium"><?= htmlspecialchars($row['product_list'] ?? 'Unknown Item') ?></span>
                                </div>
                                <p class="text-[10px] text-slate-500 mt-0.5"><?= htmlspecialchars($row['phone'] ?? 'No Phone') ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-white font-black">₹<?= number_format($row['total_amount']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="<?= getStatusBadge($row['status']) ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="<?= getStatusBadge($row['payment_status'] ?? 'pending') ?>">
                                    <?= htmlspecialchars($row['payment_status'] ?? 'Unpaid') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-500 font-medium italic"><?= date('d M, H:i', strtotime($row['created_at'])) ?></span>
                                <p class="text-[8px] uppercase text-slate-600 font-bold"><?= htmlspecialchars($row['address'] ?? 'Remote Order') ?></p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <iconify-icon icon="solar:eye-bold"></iconify-icon>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-slate-800 bg-slate-900/20 flex justify-between items-center">
                <p class="text-[10px] font-bold text-slate-600 uppercase">Showing <?= count($orders) ?> results</p>
                <div class="flex gap-2">
                    <button class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-500 hover:text-white"><iconify-icon icon="solar:alt-arrow-left-linear"></iconify-icon></button>
                    <button class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-bold">1</button>
                    <button class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-500 hover:text-white"><iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon></button>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
