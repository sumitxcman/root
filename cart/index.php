<?php

// 2. Session & Auth
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Includes
require_once '../include/db.php';
require_once '../include/auth.php';

// Auth Check (Agar user logged in nahi hai)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

// 4. Products Fetch Karein
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
    $error = "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog - MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: #94a3b8; margin: 0; }
        
        /* Sidebar Styles (Fixed like Dashboard) */
        .sidebar { 
            width: 260px; height: 100vh; background-color: #111827; 
            position: fixed; left: 0; top: 0; border-right: 1px solid #1e293b; z-index: 100;
        }

        /* Main Content Shift */
        .main-content { 
            margin-left: 260px; width: calc(100% - 260px); min-height: 100vh;
        }

        .sidebar-link.active { 
            background: #3b82f6; color: white !important; 
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3); 
        }
    </style>
</head>
<body class="flex overflow-x-hidden">
 <aside class="sidebar p-6 flex flex-col">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                <iconify-icon icon="solar:shop-bold-duotone" class="text-2xl text-white"></iconify-icon>
            </div>
            <h1 class="text-white text-xl font-black tracking-tighter uppercase">MY SHOP</h1>
        </div>

       <nav class="space-y-6">
                <a href="dashboard.php" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20">
                    <iconify-icon icon="solar:widget-5-bold-duotone" class="text-xl"></iconify-icon>
                    Dashboard Overview
                </a>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Store Management</p>
                    <a href="products/index.php" class="flex items-center justify-between px-4 py-2 bg-[#1e293b] text-white rounded-xl text-sm border border-slate-700/30">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="solar:box-bold-duotone" class="text-lg text-blue-400"></iconify-icon> Catalog
                        </div>
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[10px]"></iconify-icon>
                    </a>
                    <a href="cart.php" class="flex items-center gap-3 px-4 py-2 hover:text-white transition-colors text-sm">
                        <iconify-icon icon="solar:cart-large-4-linear" class="text-lg"></iconify-icon> Manage Orders
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Application</p>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:text-white transition-colors text-sm text-slate-400">
                        <iconify-icon icon="solar:letter-linear" class="text-lg"></iconify-icon> Email
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:text-white transition-colors text-sm text-slate-400">
                        <iconify-icon icon="solar:chat-round-dots-linear" class="text-lg"></iconify-icon> Chat
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">UI Elements</p>
                    <div class="px-2">
                        <button onclick="toggleUsersMenu()" class="w-full bg-[#4f46e5] text-white flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-bold cursor-pointer transition-all hover:bg-[#4338ca]">
                            <div class="flex items-center gap-3">
                                <iconify-icon icon="solar:users-group-rounded-bold" class="text-xl"></iconify-icon> Users
                            </div>
                            <iconify-icon id="userArrow" icon="solar:alt-arrow-down-linear" class="text-xs transition-transform duration-300"></iconify-icon>
                        </button>

                        <div id="usersSubMenu" class="hidden mt-2 ml-4 space-y-3 border-l border-slate-800 pl-4">
                            <a href="users/index.php" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Users List
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Users Grid
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Add User
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> View Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800/50 space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Reports & Settings</p>
                    <a href="settings.php" class="flex items-center justify-between px-4 py-2 hover:text-white transition-colors text-sm">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="solar:settings-linear" class="text-lg"></iconify-icon> Site Settings
                        </div>
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[10px] text-slate-600"></iconify-icon>
                    </a>
                    <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/5 rounded-xl text-sm font-bold transition-all">
                        <iconify-icon icon="solar:logout-3-bold-duotone" class="text-lg"></iconify-icon> Logout
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <main class="main-content p-8">
        
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tighter italic">Storefront</h1>
                <p class="text-slate-500 text-[10px] uppercase tracking-[0.3em] mt-1">Components / Product Cards</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest bg-slate-800/30 px-4 py-2 rounded-full border border-slate-800">
                    <iconify-icon icon="solar:home-2-bold-duotone" class="text-blue-500"></iconify-icon>
                    <span>Dashboard</span>
                    <span class="text-slate-600">/</span>
                    <span class="text-blue-400">Shop</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            
            <?php if($products): foreach($products as $product): 
                $imgFile = trim($product['image']);
                $imgPath = "../assets/images/products/" . $imgFile;
            ?>
            <div class="bg-[#111827] rounded-[2rem] overflow-hidden border border-slate-800 shadow-2xl transition-all hover:-translate-y-2 group">
                
                <div class="aspect-[4/3] bg-slate-800 overflow-hidden relative">
                    <?php if(!empty($imgFile) && file_exists($imgPath)): ?>
                        <img src="<?= $imgPath ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-slate-900">
                            <iconify-icon icon="solar:gallery-bold-duotone" class="text-4xl text-slate-700"></iconify-icon>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-1.5 rounded-xl text-xs font-black shadow-lg shadow-blue-600/30">
                        ₹<?= number_format($product['price'] ?? 0, 2) ?>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black uppercase tracking-widest text-blue-500"><?= htmlspecialchars($product['category'] ?? 'Electronics') ?></span>
                        <h2 class="text-lg font-bold text-white leading-tight truncate"><?= htmlspecialchars($product['name'] ?? 'Untitled Product') ?></h2>
                    </div>
                    
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                        <?= htmlspecialchars($product['description'] ?: 'High-quality item available in our shop.') ?>
                    </p>

                    <div class="pt-4 flex items-center justify-between gap-4 border-t border-slate-800/50">
                        <a href="product-details.php?id=<?= $product['id'] ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                            View More <iconify-icon icon="solar:arrow-right-up-linear"></iconify-icon>
                        </a>
                        
                        <button class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-2xl transition-all shadow-xl shadow-blue-900/20 flex items-center justify-center group-hover:scale-110">
                            <iconify-icon icon="solar:cart-plus-bold" class="text-xl"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <div class="col-span-full py-20 text-center bg-[#111827] border-2 border-dashed border-slate-800 rounded-[3rem]">
                    <iconify-icon icon="solar:box-minimalistic-linear" class="text-6xl text-slate-700 mb-4"></iconify-icon>
                    <p class="text-slate-500 uppercase tracking-widest text-xs font-black">No products found in the database</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>