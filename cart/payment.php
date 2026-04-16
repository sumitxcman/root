<?php
require_once __DIR__ . '/../include/load.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../sign-in.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Gateways</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        body { background-color: #0b1121; color: #94a3b8; font-family: 'Inter', sans-serif; overflow: hidden; }
        .sidebar { width: 280px; background-color: #0f172a; border-right: 1px solid rgba(255,255,255,0.05); }
        .card-gate { background: #1e293b; border-radius: 20px; padding: 30px; border: 1px solid rgba(255,255,255,0.05); }
        .form-control { background: #0b1121; border: 1px solid #334155; border-radius: 10px; padding: 12px; color: white; width: 100%; outline: none; font-size: 14px; }
        .form-control:focus { border-color: #3b82f6; }
        
        /* Toggle Switch */
        .switch { position: relative; width: 44px; height: 22px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #334155; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #3b82f6; }
        input:checked + .slider:before { transform: translateX(22px); }
    </style>
</head>
<body class="flex h-screen">

    <aside class="sidebar flex flex-col p-6 h-full">
        <div class="mb-10 flex items-center gap-3">
            <div style="width: 40px; height: 40px; background: #3b82f6; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <iconify-icon icon="solar:shop-2-bold" class="text-white text-2xl"></iconify-icon>
            </div>
            <span class="text-white text-xl font-black italic uppercase tracking-tighter">MY SHOP</span>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="../dashboard.php" class="flex items-center gap-3 p-3 rounded-xl text-slate-400 hover:bg-white/5 transition">
                <iconify-icon icon="solar:widget-5-bold" class="text-xl"></iconify-icon> Dashboard
            </a>
            <p class="text-[10px] font-bold uppercase text-slate-600 mt-6 mb-2 px-3 tracking-widest">Management</p>
            <a href="../products/index.php" class="flex items-center gap-3 p-3 rounded-xl text-slate-400 hover:bg-white/5 transition">
                <iconify-icon icon="solar:box-bold" class="text-xl"></iconify-icon> Catalog
            </a>
            <a href="payment-gateways.php" class="flex items-center gap-3 p-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/20">
                <iconify-icon icon="solar:settings-bold" class="text-xl"></iconify-icon> Payment Settings
            </a>
        </nav>

        <a href="../logout.php" class="mt-auto flex items-center gap-3 p-3 text-red-500 hover:bg-red-500/10 rounded-xl transition font-bold">
            <iconify-icon icon="solar:logout-3-bold" class="text-xl"></iconify-icon> Logout
        </a>
    </aside>

    <div class="flex-1 flex flex-col">
        
        <header class="h-20 bg-[#0f172a] border-b border-white/5 flex items-center justify-between px-10">
            <div class="flex items-center gap-4">
                <iconify-icon icon="solar:hamburger-menu-bold" class="text-white text-2xl cursor-pointer"></iconify-icon>
                <div class="relative">
                    <input type="text" placeholder="Search..." class="bg-[#1e293b] text-sm text-white px-10 py-2 rounded-lg border border-transparent focus:border-blue-500 outline-none w-64">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-2.5 text-slate-400"></iconify-icon>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <iconify-icon icon="solar:bell-bing-bold" class="text-slate-400 text-xl cursor-pointer"></iconify-icon>
                <div class="w-10 h-10 rounded-full bg-blue-500 border-2 border-white/10 flex items-center justify-center font-bold text-white text-xs">AD</div>
            </div>
        </header>

        <main class="p-10 overflow-y-auto">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-white text-2xl font-bold tracking-tight italic uppercase">Gateway Settings</h2>
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <iconify-icon icon="solar:home-2-bold"></iconify-icon> Dashboard - Settings - <span class="text-blue-500">Payment</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="card-gate">
                    <div class="flex justify-between items-center mb-10">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="logos:paypal" class="text-2xl"></iconify-icon>
                            <span class="text-white font-bold text-lg">Paypal</span>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Environment *</label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2 text-sm text-white cursor-pointer"><input type="radio" name="p_env" checked class="accent-blue-500"> Sandbox</label>
                                <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer"><input type="radio" name="p_env" class="accent-blue-500"> Production</label>
                            </div>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Currency *</label>
                            <select class="form-control"><option>USD</option><option>INR</option></select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Secret Key *</label>
                            <input type="password" class="form-control" value="••••••••••••••••">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Public Key *</label>
                            <input type="text" class="form-control" value="publickey123">
                        </div>
                    </div>

                    <div class="flex items-end justify-between">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Logo *</label>
                            <input type="file" class="text-xs text-slate-500">
                        </div>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-600/20 transition">Save Change</button>
                    </div>
                </div>

                <div class="card-gate">
                    <div class="flex justify-between items-center mb-10">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="logos:razorpay-icon" class="text-3xl"></iconify-icon>
                            <span class="text-white font-bold text-lg">RazorPay</span>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Environment *</label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2 text-sm text-white cursor-pointer"><input type="radio" name="r_env" checked class="accent-blue-500"> Sandbox</label>
                                <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer"><input type="radio" name="r_env" class="accent-blue-500"> Production</label>
                            </div>
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Currency *</label>
                            <select class="form-control"><option>INR</option><option>USD</option></select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Secret Key *</label>
                            <input type="password" class="form-control" value="••••••••••••••••">
                        </div>
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Public Key *</label>
                            <input type="text" class="form-control" value="publickey123">
                        </div>
                    </div>

                    <div class="flex items-end justify-between">
                        <div>
                            <label class="text-[11px] font-bold text-slate-500 uppercase mb-2 block tracking-wider">Logo *</label>
                            <input type="file" class="text-xs text-slate-500">
                        </div>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-600/20 transition">Save Change</button>
                    </div>
                </div>

            </div>

            <footer class="mt-20 pt-8 border-t border-white/5 flex justify-between text-slate-500 text-[11px] font-medium">
                <p>© 2026  All Rights Reserved.</p>
                <p>Made by Pixcels Themes</p>
            </footer>
        </main>
    </div>
</body>
</html>