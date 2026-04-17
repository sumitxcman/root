<?php
    $current_dir = basename(getcwd());
    $prefix = ($current_dir === 'users' || $current_dir === 'products' || $current_dir === 'cart' || $current_dir === 'orders') ? '../' : '';
?>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<aside class="w-72 h-screen bg-[#020617] text-gray-400 fixed left-0 top-0 z-50 flex flex-col border-r border-slate-800/60 shadow-2xl overflow-hidden" 
       x-data="{ openStore: true, openUsers: false, openFinance: false }">
    
    <!-- Premium Branding -->
    <div class="p-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
            <iconify-icon icon="solar:shop-bold-duotone" class="text-2xl text-white"></iconify-icon>
        </div>
        <div>
            <h1 class="text-white text-xl font-black tracking-tighter uppercase leading-none">MODEST MISSION</h1>
            <p class="text-[8px] font-bold text-blue-500 tracking-[0.3em] uppercase mt-1">Admin</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        <div class="px-2 mb-6">
            <a href="<?= $prefix ?>dashboard.php" 
               class="flex items-center gap-3 bg-white/5 text-white px-5 py-3.5 rounded-2xl font-bold transition-all hover:bg-white/10 group border border-white/5">
                <iconify-icon icon="solar:widget-5-bold-duotone" class="text-2xl text-blue-500"></iconify-icon>
                <span class="text-sm">Dashboard</span>
            </a>
        </div>

        <!-- Store Management Section -->
        <div class="space-y-1">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 px-5 mb-3">Store Management</p>
            
            <div class="px-2">
                <button @click="openStore = !openStore" 
                        class="w-full flex items-center justify-between px-5 py-3 rounded-xl hover:bg-white/5 transition-all text-sm font-semibold group">
                    <div class="flex items-center gap-3">
                        <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-xl group-hover:text-blue-500"></iconify-icon>
                        <span>Inventory</span>
                    </div>
                    <iconify-icon :icon="openStore ? 'solar:alt-arrow-up-linear' : 'solar:alt-arrow-down-linear'" class="text-[10px]"></iconify-icon>
                </button>
                <div x-show="openStore" x-transition class="mt-1 ml-6 space-y-1 border-l border-slate-800/50 pl-4">
                    <a href="<?= $prefix ?>products/index.php" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white transition-colors">
                        All Products
                    </a>
                    <a href="<?= $prefix ?>products/add.php" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white transition-colors">
                        Add Product
                    </a>
                    <a href="<?= $prefix ?>categories.php" class="flex items-center gap-3 py-2 text-sm text-slate-400 hover:text-white transition-colors">
                        Categories
                    </a>
                </div>
            </div>

            <div class="px-2">
                <a href="<?= $prefix ?>orders.php" class="flex items-center gap-3 px-5 py-3 rounded-xl hover:bg-white/5 transition-all group">
                    <iconify-icon icon="solar:cart-large-4-bold-duotone" class="text-xl group-hover:text-emerald-500"></iconify-icon>
                    <span class="text-sm font-semibold">Orders</span>
                    <span class="ml-auto bg-emerald-500/10 text-emerald-500 px-2 py-0.5 rounded text-[10px] font-black">ACTIVE</span>
                </a>
            </div>
        </div>

        <!-- User Management -->
        <div class="space-y-1 pt-6">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 px-5 mb-3">Community</p>
            <div class="px-2">
                <a href="<?= $prefix ?>users/index.php" class="flex items-center gap-3 px-5 py-3 rounded-xl hover:bg-white/5 transition-all group">
                    <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-xl group-hover:text-amber-500"></iconify-icon>
                    <span class="text-sm font-semibold">All Users</span>
                </a>
            </div>
        </div>

        <!-- Payments Section -->
        <div class="space-y-1 pt-6">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 px-5 mb-3">Finance</p>
            <div class="px-2">
                <a href="<?= $prefix ?>transactions.php" class="flex items-center gap-3 px-5 py-3 rounded-xl hover:bg-white/5 transition-all group">
                    <iconify-icon icon="solar:card-2-bold-duotone" class="text-xl group-hover:text-purple-500"></iconify-icon>
                    <span class="text-sm font-semibold">Transactions</span>
                </a>
            </div>
        </div>

        <!-- Settings Section -->
        <div class="space-y-1 pt-6">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 px-5 mb-3">Preferences</p>
            <div class="px-2">
                <a href="<?= $prefix ?>settings.php" class="flex items-center gap-3 px-5 py-3 rounded-xl hover:bg-white/5 transition-all group text-slate-400">
                    <iconify-icon icon="solar:settings-bold-duotone" class="text-xl group-hover:text-slate-200"></iconify-icon>
                    <span class="text-sm font-semibold">Settings</span>
                </a>
            </div>
        </div>


    </nav>

    <!-- Logout Area -->
    <div class="p-6 border-t border-slate-800/60 bg-[#020617]">
        <a href="<?= $prefix ?>logout.php" class="flex items-center gap-3 px-5 py-3.5 text-red-500 bg-red-500/5 hover:bg-red-500 hover:text-white rounded-2xl transition-all group font-bold">
            <iconify-icon icon="solar:logout-3-bold-duotone" class="text-xl group-hover:translate-x-1 transition-transform"></iconify-icon>
            <span class="text-sm">Logout</span>
        </a>
    </div>
</aside>