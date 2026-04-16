<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/include/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: sign-in.php");
    exit();
}

// Stats from image_4f292b.png
$total_users = 6;
$total_products = 4;
$pending_orders = 30;
$sales_30_days = "1,84,800";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Wowdash AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        body { background-color: #0b1121; color: #94a3b8; font-family: 'Inter', sans-serif; }
        .sidebar { background-color: #0f172a; border-right: 1px solid #1e293b; width: 280px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; transition: 0.3s; font-size: 14px; cursor: pointer; }
        .nav-link:hover { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .nav-active { background: #3b82f6 !important; color: white !important; }
        .section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #475569; margin: 25px 0 10px 15px; }
        .stat-card { background: #1e293b; border-radius: 16px; padding: 24px; border: 1px solid rgba(255,255,255,0.05); }
        .sub-menu { padding-left: 45px; display: none; margin-top: 5px; }
        .sub-link { display: flex; align-items: center; gap: 10px; padding: 8px 0; font-size: 13px; color: #94a3b8; }
        .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="sidebar h-full flex flex-col p-6 overflow-y-auto">
        <div class="mb-10 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                <iconify-icon icon="solar:shop-bold" class="text-white text-2xl"></iconify-icon>
            </div>
            <span class="text-white text-xl font-bold italic uppercase">MY SHOP</span>
        </div>

        <nav class="flex-1">
            <a href="dashboard.php" class="nav-link nav-active">
                <iconify-icon icon="solar:widget-5-bold" class="text-xl"></iconify-icon> Dashboard Overview
            </a>

            <div class="section-label">Store Management</div>
            <div onclick="toggleSub('prodMenu')" class="nav-link">
                <iconify-icon icon="solar:box-bold" class="text-xl"></iconify-icon> Catalog
                <iconify-icon icon="solar:alt-arrow-down-bold" class="ml-auto text-xs"></iconify-icon>
            </div>
            <div id="prodMenu" class="sub-menu">
                <a href="products/index.php" class="sub-link"><span class="dot bg-blue-500"></span> View Products</a>
                <a href="products/add.php" class="sub-link"><span class="dot bg-emerald-500"></span> Add Product</a>
                <a href="products/edit.php" class="sub-link"><span class="dot bg-orange-500"></span> Edit Product</a>
                <a href="products/delete.php" class="sub-link"><span class="dot bg-red-500"></span> Delete Product</a>
            </div>
           

            <div onclick="toggleSub('cartMenu')" class="nav-link">
                <iconify-icon icon="solar:cart-check-bold" class="text-xl"></iconify-icon> Cart System
                <iconify-icon icon="solar:alt-arrow-down-bold" class="ml-auto text-xs"></iconify-icon>
            </div>
            <div id="cartMenu" class="sub-menu">
                <a href="cart/index.php" class="sub-link"><span class="dot bg-blue-500"></span> Cart Index</a>
                <a href="cart/checkout.php" class="sub-link"><span class="dot bg-purple-500"></span> Checkout</a>
                <a href="cart/payment.php" class="sub-link"><span class="dot bg-emerald-500"></span> Payment</a>
                <a href="cart/delete.php" class="sub-link"><span class="dot bg-red-500"></span> Remove Item</a>
            </div>

            <div class="section-label">Application</div>
            <a href="email.php" class="nav-link"><iconify-icon icon="solar:letter-bold" class="text-xl"></iconify-icon> Email</a>
            <a href="chat.php" class="nav-link"><iconify-icon icon="solar:chat-round-dots-bold" class="text-xl"></iconify-icon> Chat</a>
            
            <div onclick="toggleSub('authMenu')" class="nav-link">
                <iconify-icon icon="solar:lock-password-bold" class="text-xl"></iconify-icon> Authentication
                <iconify-icon icon="solar:alt-arrow-down-bold" class="ml-auto text-xs"></iconify-icon>
            </div>
            <div id="authMenu" class="sub-menu">
                <a href="sign-in.php" class="sub-link"><span class="dot bg-blue-500"></span> Sign In</a>
                <a href="sign-up.php" class="sub-link"><span class="dot bg-orange-500"></span> Sign Up</a>
                <a href="forgot-password.php" class="sub-link"><span class="dot bg-blue-500"></span> Forgot Password</a>
            </div>

            <div class="section-label">UI Elements</div>
            <div onclick="toggleSub('usersMenu')" class="nav-link bg-indigo-500/10 text-indigo-400">
                <iconify-icon icon="solar:users-group-rounded-bold" class="text-xl"></iconify-icon> Users
                <iconify-icon icon="solar:alt-arrow-down-bold" class="ml-auto text-xs"></iconify-icon>
            </div>
            <div id="usersMenu" class="sub-menu" style="display: block;">
                <a href="users/index.php" class="sub-link"><span class="dot bg-blue-500"></span> Users List</a>
                <a href="users/add.php" class="sub-link"><span class="dot bg-emerald-500"></span> Add User</a>
                <a href="users/edit.php" class="sub-link"><span class="dot bg-orange-500"></span> Edit User</a>
                <a href="profile.php" class="sub-link"><span class="dot bg-red-500"></span> View Profile</a>
            </div>

            <div class="section-label">Pages</div>
            <a href="faq.php" class="nav-link"><iconify-icon icon="solar:question-square-bold" class="text-xl"></iconify-icon> FAQs.</a>
            <a href="404.php" class="nav-link"><iconify-icon icon="solar:smile-circle-bold" class="text-xl"></iconify-icon> 404</a>
            <a href="terms.php" class="nav-link"><iconify-icon icon="solar:document-text-bold" class="text-xl"></iconify-icon> Terms & Conditions</a>

            <div class="section-label">Reports & Settings</div>
            <div onclick="toggleSub('setMenu')" class="nav-link">
                <iconify-icon icon="solar:settings-bold" class="text-xl"></iconify-icon> Settings
                <iconify-icon icon="solar:alt-arrow-down-bold" class="ml-auto text-xs"></iconify-icon>
            </div>
            <div id="setMenu" class="sub-menu">
                <a href="settings.php" class="sub-link"><span class="dot bg-blue-500"></span> Main Settings</a>
                <a href="settings/update.php" class="sub-link"><span class="dot bg-emerald-500"></span> Update Config</a>
            </div>
        </nav>

        <a href="logout.php" class="mt-10 nav-link text-red-500 hover:bg-red-500/10">
            <iconify-icon icon="solar:logout-3-bold" class="text-xl"></iconify-icon> Logout
        </a>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-20 border-b border-white/5 flex items-center justify-between px-10">
            <h1 class="text-xl font-bold text-white">Dashboard Overview</h1>
            <div class="flex items-center gap-4 text-sm font-medium">
                <iconify-icon icon="solar:home-2-bold" class="text-blue-500"></iconify-icon>
                <span>Dashboard - AI</span>
            </div>
        </header>

        <main class="p-10 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="stat-card flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-500">Total Users</p>
                        <h2 class="text-4xl font-black text-white mt-2"><?= $total_users ?></h2>
                    </div>
                    <iconify-icon icon="solar:users-group-rounded-bold" class="text-blue-500 text-3xl"></iconify-icon>
                </div>

                <div class="stat-card flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-500">Total Products</p>
                        <h2 class="text-4xl font-black text-blue-500 mt-2"><?= $total_products ?></h2>
                    </div>
                    <iconify-icon icon="solar:box-bold" class="text-indigo-500 text-3xl"></iconify-icon>
                </div>

                <div class="stat-card flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-500">Pending Orders</p>
                        <h2 class="text-4xl font-black text-orange-500 mt-2"><?= $pending_orders ?></h2>
                    </div>
                    <iconify-icon icon="solar:clock-circle-bold" class="text-orange-500 text-3xl"></iconify-icon>
                </div>

                <div class="stat-card flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-500">30 Day Sales</p>
                        <h2 class="text-4xl font-black text-emerald-500 mt-2">₹<?= $sales_30_days ?></h2>
                    </div>
                    <iconify-icon icon="solar:wad-of-money-bold" class="text-emerald-500 text-3xl"></iconify-icon>
                </div>

            </div>
        </main>
    </div>

    <script>
        function toggleSub(id) {
            const menu = document.getElementById(id);
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
    </script>
</body>
</html>