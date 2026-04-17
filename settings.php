<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'include/db.php';
require_once 'include/auth.php';

// Auth Check (Admin Only)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: sign-in.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Global Settings | MODEST ADMIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 12px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; }
        .main-content { width: 100%; max-width: 1400px; margin: 0 auto; min-height: 100vh; padding: 3rem 1.5rem; }
        
        /* Amazon/Flipkart Style Cards but LUXURY */
        .setting-card { 
            background: #0f172a; 
            border: 1px solid #1e293b; 
            border-radius: 2rem; 
            padding: 2rem; 
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .setting-card:hover { 
            border-color: #3b82f6; 
            transform: translateY(-8px);
            box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.15);
        }
        .setting-card::after {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.05) 0%, transparent 60%);
            opacity: 0; transition: 0.4s;
        }
        .setting-card:hover::after { opacity: 1; }

        .icon-box {
            width: 60px; height: 60px; border-radius: 1.25rem;
            display: flex; items-center justify-center; margin-bottom: 1.5rem;
            font-size: 2rem; transition: 0.4s;
        }
        .setting-card:hover .icon-box { transform: scale(1.1) rotate(5deg); }
    </style>
</head>
<body class="antialiased">

    <main class="main-content">
        
        <header class="mb-16">
            <div class="flex items-center gap-4 mb-3">
                <a href="dashboard.php" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center hover:bg-blue-600 transition-all group">
                    <iconify-icon icon="solar:alt-arrow-left-linear" class="text-white opacity-50 group-hover:opacity-100"></iconify-icon>
                </a>
                <div class="h-[1px] flex-1 bg-slate-800/50"></div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-600 italic">System Node: Settings</span>
            </div>
            <h1 class="text-6xl font-black text-white italic tracking-tighter uppercase leading-none">Global Config.</h1>
            <p class="text-slate-500 mt-4 max-w-2xl text-lg">Orchestrate your luxury ecommerce ecosystem by configuring core business protocols and security layers.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Account Settings -->
            <div class="setting-card">
                <div class="icon-box bg-blue-600/10 text-blue-500 border border-blue-500/20">
                    <iconify-icon icon="solar:user-bold-duotone"></iconify-icon>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-2">Personal Identity</h3>
                <p class="text-xs leading-relaxed text-slate-500 font-medium">Update your administrative credentials, avatar, and contact information protocol.</p>
                <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-blue-400 uppercase tracking-widest group">
                    Configure Identity <iconify-icon icon="solar:arrow-right-line-duotone" class="group-hover:translate-x-1 transition-transform"></iconify-icon>
                </div>
            </div>

            <!-- Login & Security -->
            <div class="setting-card">
                <div class="icon-box bg-emerald-600/10 text-emerald-500 border border-emerald-500/20">
                    <iconify-icon icon="solar:shield-keyhole-bold-duotone"></iconify-icon>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-2">Login & Security</h3>
                <p class="text-xs leading-relaxed text-slate-500 font-medium">Reset master passwords, enable biometric authentication and review active sessions.</p>
                <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-emerald-400 uppercase tracking-widest group">
                    Secure Protocol <iconify-icon icon="solar:arrow-right-line-duotone" class="group-hover:translate-x-1 transition-transform"></iconify-icon>
                </div>
            </div>

            <!-- Business Profile -->
            <div class="setting-card">
                <div class="icon-box bg-amber-600/10 text-amber-500 border border-amber-500/20">
                    <iconify-icon icon="solar:shop-bold-duotone"></iconify-icon>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-2">Store Profile</h3>
                <h3 class="text-white text-xl font-black tracking-tighter uppercase italic"></h3>
                <p class="text-xs leading-relaxed text-slate-500 font-medium">Configure store name, global currency tier (INR/USD), and primary region settings.</p>
                <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-amber-400 uppercase tracking-widest group">
                    Manage Store <iconify-icon icon="solar:arrow-right-line-duotone" class="group-hover:translate-x-1 transition-transform"></iconify-icon>
                </div>
            </div>

            <!-- Merchant Services -->
            <div class="setting-card">
                <div class="icon-box bg-purple-600/10 text-purple-500 border border-purple-500/20">
                    <iconify-icon icon="solar:card-2-bold-duotone"></iconify-icon>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-2">Payment Gateways</h3>
                <p class="text-xs leading-relaxed text-slate-500 font-medium">Link Stripe, PayPal or custom bank protocols for international settlements.</p>
                <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-purple-400 uppercase tracking-widest group">
                    Merchant Keys <iconify-icon icon="solar:arrow-right-line-duotone" class="group-hover:translate-x-1 transition-transform"></iconify-icon>
                </div>
            </div>

            <!-- Notifications -->
            <div class="setting-card">
                <div class="icon-box bg-red-600/10 text-red-500 border border-red-500/20">
                    <iconify-icon icon="solar:bell-bing-bold-duotone"></iconify-icon>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-2">Internal Alerts</h3>
                <p class="text-xs leading-relaxed text-slate-500 font-medium">Manage email notifications for new orders, inventory alerts and system logs.</p>
                <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-red-400 uppercase tracking-widest group">
                    Configure Alerts <iconify-icon icon="solar:arrow-right-line-duotone" class="group-hover:translate-x-1 transition-transform"></iconify-icon>
                </div>
            </div>

            <!-- Cloud / Backups -->
            <div class="setting-card">
                <div class="icon-box bg-indigo-600/10 text-indigo-500 border border-indigo-500/20">
                    <iconify-icon icon="solar:cloud-storage-bold-duotone"></iconify-icon>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-2">Cloud Recovery</h3>
                <p class="text-xs leading-relaxed text-slate-500 font-medium">Schedule automated database backups and review cloud performance telemetry.</p>
                <div class="mt-8 flex items-center gap-2 text-[10px] font-black text-indigo-400 uppercase tracking-widest group">
                    Backup Assets <iconify-icon icon="solar:arrow-right-line-duotone" class="group-hover:translate-x-1 transition-transform"></iconify-icon>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
