<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../include/db.php';

// If user is not logged in, redirect to sign-in page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];

// [STRICT SEGREGATION] Redirect Admins AWAY from the user dashboard
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // FETCH REAL USER ORDERS
    $stmt_orders = $conn->prepare("
        SELECT o.*, GROUP_CONCAT(p.name SEPARATOR ', ') as item_names, GROUP_CONCAT(p.image SEPARATOR '|') as item_images
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    $stmt_orders->execute([$user_id]);
    $user_orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $user = [];
    $user_orders = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Portal | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --lux-gold: #c5a059; --lux-blue: #3b82f6; --lux-dark: #020617; }
        html { font-size: 14px; }
        body { background-color: var(--lux-dark); color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        .hero-gradient { background: #020617; position: relative; overflow: hidden; }
        .hero-gradient::before { content: ""; position: absolute; top: -20%; left: -10%; width: 60%; height: 60%; background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%); animation: drift 15s infinite alternate ease-in-out; z-index: 0; }
        .hero-gradient::after { content: ""; position: absolute; bottom: -10%; right: -10%; width: 50%; height: 50%; background: radial-gradient(circle, rgba(197,160,89,0.06) 0%, transparent 70%); animation: drift 20s infinite alternate-reverse ease-in-out; z-index: 0; }
        
        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(5%, 10%) scale(1.1); }
        }

        .glass-card { background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(40px); border: 1px solid rgba(255,255,255,0.02); border-radius: 3rem; transition: 0.8s cubic-bezier(0.2, 1, 0.3, 1); box-shadow: 0 50px 100px -20px rgba(0,0,0,0.5); }
        .glass-card:hover { transform: translateY(-12px) scale(1.01); border-color: rgba(197, 160, 89, 0.2); background: rgba(15, 23, 42, 0.7); box-shadow: 0 70px 120px -30px rgba(0,0,0,0.8), 0 0 30px rgba(197,160,89,0.05); }

        .vip-card { background: linear-gradient(135deg, #0f172a 0%, #020617 100%); border: 1px solid rgba(197, 160, 89, 0.15); border-radius: 2rem; position: relative; overflow: hidden; }
        .vip-card::before { content: ""; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(45deg, transparent 45%, rgba(197, 160, 89, 0.1) 50%, transparent 55%); animation: shine 6s infinite linear; }
        
        @keyframes shine {
            0% { transform: translateX(-50%) translateY(-50%) rotate(0deg); }
            100% { transform: translateX(-50%) translateY(-50%) rotate(360deg); }
        }

        .profile-ring { padding: 5px; background: linear-gradient(135deg, var(--lux-blue), var(--lux-gold)); border-radius: 50%; box-shadow: 0 0 50px rgba(59, 130, 246, 0.15); }
        
        .btn-luxe { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); border-radius: 1.5rem; transition: 0.5s; padding: 1.25rem 2rem; }
        .btn-luxe:hover { border-color: var(--lux-gold); color: white; background: rgba(197, 160, 89, 0.08); box-shadow: 0 0 20px rgba(197,160,89,0.1); }

        .nav-link { font-size: 8.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.35em; color: #64748b; transition: 0.4s; }
        .nav-link:hover { color: white; letter-spacing: 0.45em; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 3px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="hero-gradient min-h-screen relative z-10">
    
    <!-- Ultra-Luxe Header -->
    <header class="h-[90px] border-b border-white/5 flex items-center justify-between px-12 bg-black/20 backdrop-blur-3xl sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 border border-amber-500/20 rounded-xl flex items-center justify-center bg-amber-500/5 rotate-45">
                <iconify-icon icon="solar:crown-minimalistic-bold-duotone" class="text-2xl text-amber-500 rotate-[-45deg]"></iconify-icon>
            </div>
            <a href="../index.php" class="text-white text-2xl font-black italic tracking-tighter uppercase">Modest Mission</a>
        </div>
        
        <div class="flex items-center gap-12">
            <div class="hidden lg:flex items-center gap-8 text-[9px] font-black uppercase tracking-[0.3em] text-slate-500">
                <a href="../collections.php" class="hover:text-white transition">Collections</a>
                <a href="../archive.php" class="hover:text-white transition">The Archive</a>
                <a href="../faq.php" class="hover:text-white transition">Bespoke Support</a>
            </div>
            
            <div class="flex items-center gap-5">
                <a href="../logout.php" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-6 py-3 rounded-full text-[9px] font-black uppercase tracking-[0.2em] transition-all">Logout</a>
            </div>
        </div>
    </header>

    <main class="max-w-[1400px] mx-auto p-12 md:p-20">
        
        <!-- Welcome Section -->
        <div class="mb-20 flex flex-col md:flex-row items-center gap-10">
            <div class="profile-ring">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username'] ?? 'U') ?>&background=020617&color=fff&size=256" class="w-32 h-32 rounded-full border-4 border-[#020617]">
            </div>
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-500/5 border border-blue-500/10 rounded-full mb-4">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                    <span class="text-[8px] font-black text-blue-400 uppercase tracking-[0.3em]">Authenticated Private Member</span>
                </div>
                <h1 class="text-6xl font-black text-white uppercase tracking-tighter italic leading-none mb-2">
                    Welcome, <span class="text-amber-500"><?= htmlspecialchars($user['fullname'] ?? $user['username'] ?? 'User') ?></span>
                </h1>
                <p class="text-slate-500 text-sm font-light italic opacity-70">"Quality is not an act, it is a habit." — Member since <?= isset($user['created_at']) ? date('M Y', strtotime($user['created_at'])) : '2026' ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Account Overview Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <div class="vip-card p-10 shadow-2xl">
                    <div class="absolute top-0 right-0 p-6 opacity-20">
                        <iconify-icon icon="solar:crown-minimalistic-bold" class="text-4xl text-amber-500"></iconify-icon>
                    </div>
                    <h3 class="text-white font-black uppercase text-[10px] tracking-[0.4em] mb-10 flex items-center gap-2 italic">
                        <span class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_10px_rgba(197,160,89,1)]"></span> Digital Privilege
                    </h3>
                    <div class="space-y-8">
                        <div>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Member Identifier</p>
                            <p class="text-xl font-black text-white uppercase italic tracking-tighter">#ID-<?= str_pad($user_id, 4, '0', STR_PAD_LEFT) ?></p>
                        </div>
                        <div>
                            <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Verification Alias</p>
                            <p class="text-lg font-black text-amber-500 uppercase italic tracking-tighter"><?= htmlspecialchars($user['username'] ?? 'n/a') ?></p>
                        </div>
                        <div class="pt-4 border-t border-white/5">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1">Status Tier</p>
                                    <p class="text-xs font-black text-white uppercase italic tracking-widest">Master Curator</p>
                                </div>
                                <iconify-icon icon="solar:card-2-bold-duotone" class="text-3xl text-slate-800"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-10 bg-gradient-to-br from-blue-600/5 to-transparent relative overflow-hidden group">
                    <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-all"></div>
                    <h3 class="text-white font-black uppercase text-xs tracking-widest mb-6 italic">Support Terminal</h3>
                    <p class="text-[10px] text-slate-500 mb-8 leading-relaxed font-medium">Have questions regarding a high-valuation acquisition? Our bespoke assistants are ready to serve.</p>
                    <a href="../faq.php" class="flex items-center justify-between p-5 btn-luxe group">
                        <span class="text-[9px] font-black text-white uppercase tracking-[0.3em]">Direct Connect</span>
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="group-hover:translate-x-2 transition-transform text-amber-500"></iconify-icon>
                    </a>
                </div>
            </div>

            <!-- Main Interactive Content -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- Orders Portal -->
                <div class="glass-card p-10 border-t-2 border-blue-500/20">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="text-xl font-black text-white uppercase italic tracking-tighter">Your Acquisitions</h3>
                                <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.3em]">Total: <?= count($user_orders) ?> Assets</span>
                            </div>
                            
                            <?php if (!empty($user_orders)): ?>
                                <div class="space-y-4">
                                    <?php foreach ($user_orders as $o): 
                                        $images = explode('|', $o['item_images']);
                                        $display_img = (!empty($images[0]) && $images[0] !== 'default.png') ? (strpos($images[0], 'http') === 0 ? $images[0] : "../assets/uploads/".$images[0]) : 'https://placehold.co/100';
                                    ?>
                                        <div class="flex items-center justify-between p-6 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-all group">
                                            <div class="flex items-center gap-6">
                                                <div class="w-16 h-16 rounded-xl overflow-hidden border border-white/10">
                                                    <img src="<?= $display_img ?>" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <p class="text-[8px] font-bold text-amber-500 uppercase tracking-widest mb-1">Order #<?= $o['id'] ?></p>
                                                    <h4 class="text-sm font-black text-white uppercase italic tracking-tighter"><?= htmlspecialchars($o['item_names'] ?: 'Acquisition Batch') ?></h4>
                                                    <p class="text-[9px] text-slate-500 mt-1"><?= date('D, M d Y', strtotime($o['created_at'])) ?></p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-black text-white italic tracking-tighter">₹<?= number_format($o['total_amount']) ?></p>
                                                <span class="text-[7px] font-black text-emerald-500 uppercase tracking-widest"><?= $o['status'] ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="py-16 text-center bg-black/20 rounded-3xl border border-dashed border-white/5">
                                    <div class="w-16 h-16 bg-slate-800/20 border border-white/5 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                        <iconify-icon icon="solar:box-minimalistic-linear" class="text-3xl text-slate-700"></iconify-icon>
                                    </div>
                                    <p class="text-sm font-light text-slate-500 max-w-xs mx-auto mb-8 leading-relaxed">Your acquisition archive is currently empty. Explore our latest rarities to start your collection.</p>
                                    <a href="../index.php" class="px-10 py-4 bg-white text-black font-black uppercase text-[9px] tracking-widest rounded-full hover:bg-amber-500 hover:text-white transition-all shadow-xl shadow-white/5">Launch Boutique</a>
                                </div>
                            <?php endif; ?>
                        </div>

                <!-- Quick Action Hub -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <a href="../profile.php" class="glass-card p-8 flex items-center gap-6 group hover:border-emerald-500/30">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                            <iconify-icon icon="solar:tuning-square-2-bold-duotone" class="text-3xl"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-white font-black uppercase italic tracking-tighter">Identity Settings</h4>
                            <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest mt-1">Manage profile & keys</p>
                        </div>
                    </a>

                    <a href="../terms.php" class="glass-card p-8 flex items-center gap-6 group hover:border-blue-500/30">
                        <div class="w-14 h-14 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                            <iconify-icon icon="solar:document-text-bold-duotone" class="text-3xl"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-white font-black uppercase italic tracking-tighter">Legal Governance</h4>
                            <p class="text-[8px] text-slate-500 font-bold uppercase tracking-widest mt-1">Privacy & Terms</p>
                        </div>
                    </a>
                </div>

                <!-- Boutique Portal -->
                <a href="../index.php" class="p-10 bg-gradient-to-r from-blue-600/10 to-amber-500/10 border border-amber-500/20 rounded-[3rem] hover:border-amber-500 transition-all flex items-center justify-between group relative overflow-hidden">
                    <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-amber-500/10 rounded-full blur-[60px] group-hover:bg-amber-500/20 transition-all"></div>
                    <div class="flex items-center gap-8 relative z-10">
                        <div class="w-20 h-20 rounded-[1.5rem] bg-amber-500/10 flex items-center justify-center text-amber-500 border border-amber-500/20 shadow-2xl shadow-amber-500/5 group-hover:scale-110 transition-transform">
                            <iconify-icon icon="solar:crown-bold" class="text-4xl"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-white uppercase tracking-tighter italic">Return to Boutique</h4>
                            <p class="text-[9px] text-amber-500/70 font-bold uppercase tracking-[0.4em] mt-2">Resume your curated journey &rarr;</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </main>

    <footer class="mt-20 py-12 text-center opacity-30">
        <span class="text-[8px] font-black text-slate-600 uppercase tracking-[1em] italic">Authorized Member Access Only</span>
    </footer>

</body>
</html>
