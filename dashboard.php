<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/include/db.php';
require_once __DIR__ . '/include/auth.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: sign-in.php");
    exit();
}

// Real-ish stats
$total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_products = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_revenue = $conn->query("SELECT SUM(total_amount) FROM orders")->fetchColumn() ?? 0;
$total_orders = $conn->query("SELECT COUNT(*) FROM orders")->fetchColumn();

// Low Stock Alert (Real-time)
$low_stock_items = $conn->query("SELECT name, stock FROM products WHERE stock <= 5 ORDER BY stock ASC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | MODEST PREMIUM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html { font-size: 12px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; }
        .main-content { margin-left: 19rem; min-height: 100vh; padding: 2rem; }
        .stat-card { background: #0f172a; border-radius: 20px; padding: 1.5rem; border: 1px solid #1e293b; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); border-color: #3b82f6; }
        .lux-chart-bg { background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(30, 41, 59, 0) 100%); }
    </style>
</head>
<body class="antialiased">

    <?php include 'partials/sidebar.php'; ?>

    <main class="main-content">
        <!-- Top Navbar -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-2xl font-black text-white tracking-tighter uppercase italic">MODEST MISSION</h1>
                <p class="text-slate-500 text-sm mt-1">Real-time performance metrics for your enterprise.</p>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4 bg-[#0f172a] p-1.5 pr-5 rounded-2xl border border-slate-800">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="w-10 h-10 rounded-xl shadow-lg shadow-blue-500/10">
                    <div>
                        <p class="text-xs font-black text-white uppercase leading-none">Admin Panel</p>
                        <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">Super Authority</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <div class="stat-card flex flex-col justify-between h-40">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-blue-600/10 rounded-xl flex items-center justify-center text-blue-500">
                        <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="text-2xl"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-black text-emerald-500">+12% vs LW</span>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white"><?= $total_users ?></h2>
                    <p class="text-[10px] uppercase font-black text-slate-500 tracking-widest mt-1">Customer Base</p>
                </div>
            </div>

            <div class="stat-card flex flex-col justify-between h-40">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-emerald-600/10 rounded-xl flex items-center justify-center text-emerald-500">
                        <iconify-icon icon="solar:wad-of-money-bold-duotone" class="text-2xl"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-black text-emerald-500">+5% Growth</span>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white">₹<?= number_format($total_revenue) ?></h2>
                    <p class="text-[10px] uppercase font-black text-slate-500 tracking-widest mt-1">Net Revenue</p>
                </div>
            </div>

            <div class="stat-card flex flex-col justify-between h-40">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-amber-600/10 rounded-xl flex items-center justify-center text-amber-500">
                        <iconify-icon icon="solar:cart-check-bold-duotone" class="text-2xl"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-black text-slate-500">Active Pipeline</span>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white"><?= $total_orders ?></h2>
                    <p class="text-[10px] uppercase font-black text-slate-500 tracking-widest mt-1">Order Volume</p>
                </div>
            </div>

            <div class="stat-card flex flex-col justify-between h-40 border-blue-600/30">
                <div class="flex justify-between items-start">
                    <div class="w-10 h-10 bg-indigo-600/10 rounded-xl flex items-center justify-center text-indigo-500">
                        <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="text-2xl"></iconify-icon>
                    </div>
                    <span class="text-[10px] font-black text-blue-500">Skus</span>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-white"><?= $total_products ?></h2>
                    <p class="text-[10px] uppercase font-black text-slate-500 tracking-widest mt-1">Global Inventory</p>
                </div>
            </div>

        </div>

        <!-- Main Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="lg:col-span-2 bg-[#0f172a] rounded-[2rem] border border-slate-800 lux-chart-bg p-8 relative overflow-hidden">
                <!-- Background Decorative Glow -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600/10 rounded-full blur-[80px]"></div>
                
                <div class="flex justify-between items-start mb-8 relative z-10">
                    <div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tighter">Growth Forecast</h3>
                        <p class="text-slate-500 text-xs mt-1 max-w-md">Our business is experiencing strong upward momentum, with consistent growth in sales and user engagement, indicating a scalable and high-performing future.</p>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center gap-2 text-emerald-500 font-black text-xl">
                            <iconify-icon icon="solar:round-alt-arrow-up-bold-duotone"></iconify-icon>
                            <span>+24.8%</span>
                        </div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">vs last month</p>
                    </div>
                </div>

                <!-- Mini Stats inside Chart Area -->
                <div class="flex gap-10 mb-8 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.8)]"></div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase leading-none">Revenue Growth</p>
                            <p class="text-sm font-bold text-white mt-1">+18.2%</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.8)]"></div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 uppercase leading-none">User Acquisition</p>
                            <p class="text-sm font-bold text-white mt-1">+12.5%</p>
                        </div>
                    </div>
                </div>

                <!-- Chart Area -->
                <div class="h-64 relative z-10">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

            <div class="bg-[#0f172a] rounded-[2rem] border border-slate-800 p-8">
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-8">Recent activity</h3>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-1.5 h-10 bg-blue-600 rounded-full"></div>
                        <div>
                            <p class="text-sm font-bold text-white leading-none">New Global Order #0042</p>
                            <p class="text-[10px] text-slate-500 mt-1 uppercase">2 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1.5 h-10 bg-emerald-600 rounded-full"></div>
                        <div>
                            <p class="text-sm font-bold text-white leading-none">Payout processed successfully</p>
                            <p class="text-[10px] text-slate-500 mt-1 uppercase">1 hour ago</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1.5 h-10 bg-slate-800 rounded-full"></div>
                        <div>
                            <p class="text-sm font-bold text-white leading-none">Inventory sync completed</p>
                            <p class="text-[10px] text-slate-500 mt-1 uppercase">3 hours ago</p>
                        </div>
                    </div>
                </div>
                
                <a href="orders.php" class="w-full mt-10 flex items-center justify-center gap-2 border border-slate-800 hover:border-blue-500 hover:text-white py-4 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                    View full activity
                </a>
            </div>

            <!-- Global Inventory Alert Widget -->
            <div class="bg-[#0f172a] rounded-[2rem] border border-red-500/20 p-8 shadow-2xl shadow-red-500/5 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-600/5 rounded-full blur-3xl"></div>
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-6 flex items-center gap-3">
                    <iconify-icon icon="solar:shield-warning-bold-duotone" class="text-red-500 text-3xl"></iconify-icon> Inventory Alerts
                </h3>
                
                <div class="space-y-4">
                    <?php if(empty($low_stock_items)): ?>
                        <div class="py-4 text-center">
                            <p class="text-xs font-bold text-emerald-500 uppercase tracking-widest italic">All stock levels healthy</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($low_stock_items as $item): ?>
                            <div class="flex items-center justify-between p-4 bg-red-500/5 border border-red-500/10 rounded-2xl">
                                <div>
                                    <p class="text-xs font-black text-white uppercase italic tracking-tighter"><?= htmlspecialchars($item['name']) ?></p>
                                    <p class="text-[9px] text-red-400 font-bold uppercase tracking-widest mt-1">Critical: Action Required</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xl font-black text-red-500"><?= $item['stock'] ?></span>
                                    <p class="text-[8px] text-slate-500 font-bold uppercase">Left</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <a href="products/index.php" class="mt-4 block text-center text-[9px] font-black text-slate-500 hover:text-white uppercase tracking-[0.3em] transition-all">Restock Inventory</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>

    <script>
        // Growth Chart Initialization
        const ctx = document.getElementById('growthChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue Trend',
                    data: [35, 48, 42, 65, 58, 85],
                    borderColor: '#3b82f6',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#475569', font: { size: 10, weight: 'bold' } }
                    },
                    y: {
                        grid: { color: 'rgba(71, 85, 105, 0.1)', drawBorder: false },
                        ticks: { color: '#475569', font: { size: 10, weight: 'bold' }, stepSize: 20 }
                    }
                }
            }
        });
    </script>
</body>
</html>