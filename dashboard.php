<?php
// 1. Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Session Start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Includes
require_once 'include/db.php';
require_once 'include/auth.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

/** --- DATABASE QUERIES FOR STATS --- **/

// 1. Total Users
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() ?: 0;

// 2. Pending Users (Status column ke basis par)
$pending_users = $pdo->query("SELECT COUNT(*) FROM users WHERE status = 'pending'")->fetchColumn() ?: 0;

// 3. Total Products
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn() ?: 0;

// 4. Pending Products
$pending_products = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 'pending'")->fetchColumn() ?: 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY SHOP - Luxury Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex">

    <aside class="w-64 min-h-screen bg-[#111827] text-gray-400 fixed left-0 top-0 z-50">
        <div class="p-6 border-b border-gray-800">
            <a href="index.php" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl"></div>
                <span class="text-white text-xl font-bold tracking-tight">MY SHOP</span>
            </a>
        </div>
        <nav class="p-4 mt-4 space-y-2">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 px-4 mb-4">Main Menu</p>
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 bg-blue-600 text-white rounded-xl transition-all shadow-lg shadow-blue-900/20">
                <iconify-icon icon="solar:widget-3-bold-duotone" class="text-xl"></iconify-icon>
                <span class="font-semibold text-sm">Dashboard</span>
            </a>
            <a href="manage-users.php" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800 hover:text-white rounded-xl transition-all">
                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-xl"></iconify-icon>
                <span class="font-medium text-sm">Manage Users</span>
            </a>
            <a href="manage-products.php" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-800 hover:text-white rounded-xl transition-all">
                <iconify-icon icon="solar:box-bold-duotone" class="text-xl"></iconify-icon>
                <span class="font-medium text-sm">Manage Products</span>
            </a>
            <div class="pt-10">
                <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-400/10 rounded-xl transition-all">
                    <iconify-icon icon="solar:logout-3-bold-duotone" class="text-xl"></iconify-icon>
                    <span class="font-medium text-sm">Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <div class="flex-1 ml-64">
        <header class="h-20 bg-white border-b border-gray-100 px-8 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-bold text-gray-800 tracking-tight">Overview</h2>
            </div>
            <div class="flex items-center gap-4">
                <?php if(isset($_SESSION['user_name'])): ?>
                    <span class="text-sm font-semibold text-gray-700 italic">Hi, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['user_name'] ?>&background=random&color=fff&rounded=true" class="w-10 h-10 border-2 border-white shadow-sm">
                <?php endif; ?>
            </div>
        </header>

        <main class="p-8">
            <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Admin Dashboard</h1>
                <p class="text-gray-400 mt-2 font-medium">Welcome back, <span class="text-blue-600">Admin Panel</span></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-[#9333ea] p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden group">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Total Users</p>
                    <h3 class="text-5xl font-extrabold mt-3"><?= $total_users ?></h3>
                    <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-6xl opacity-20 absolute -right-2 -bottom-2 group-hover:scale-110 transition-transform"></iconify-icon>
                </div>

                <div class="bg-[#fb923c] p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden group">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Pending Users</p>
                    <h3 class="text-5xl font-extrabold mt-3"><?= $pending_users ?></h3>
                    <iconify-icon icon="solar:user-plus-bold-duotone" class="text-6xl opacity-20 absolute -right-2 -bottom-2 group-hover:scale-110 transition-transform"></iconify-icon>
                </div>

                <div class="bg-[#2dd4bf] p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden group">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Total Products</p>
                    <h3 class="text-5xl font-extrabold mt-3"><?= $total_products ?></h3>
                    <iconify-icon icon="solar:box-bold-duotone" class="text-6xl opacity-20 absolute -right-2 -bottom-2 group-hover:scale-110 transition-transform"></iconify-icon>
                </div>

                <div class="bg-[#60a5fa] p-8 rounded-[2rem] text-white shadow-xl relative overflow-hidden group">
                    <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Pending Products</p>
                    <h3 class="text-5xl font-extrabold mt-3"><?= $pending_products ?></h3>
                    <iconify-icon icon="solar:clipboard-list-bold-duotone" class="text-6xl opacity-20 absolute -right-2 -bottom-2 group-hover:scale-110 transition-transform"></iconify-icon>
                </div>

            </div>
        </main>
    </div>

</body>
</html>