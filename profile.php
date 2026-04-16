<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once 'include/db.php';
    require_once 'include/auth.php';
    require_once 'include/helper.php';

    // Auth Check
    if (!isset($_SESSION['user_id'])) {
        header("Location: sign-in.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    
    // Fetch User Data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        header("Location: sign-in.php");
        exit();
    }

    $title = 'My Profile - Modest Mission';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; }
        .glass-header { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid #1e293b; }
        .lux-card { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(16px); border: 1px solid #1e293b; border-radius: 2rem; }
        .profile-glow { box-shadow: 0 0 50px -10px rgba(59, 130, 246, 0.5); }
        .gradient-text { background: linear-gradient(135deg, #fff 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-card { background: #0f172a; border: 1px solid #1e293b; border-radius: 1.5rem; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); border-color: #3b82f6; }
        .btn-lux { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.8rem 2rem; border-radius: 1rem; font-weight: 700; transition: 0.3s; box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); }
        .btn-lux:hover { transform: scale(1.05); }
    </style>
</head>
<body class="antialiased min-h-screen bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950">

    <header class="glass-header sticky top-0 z-50 h-[80px] flex items-center px-12 justify-between">
        <a href="index.php" class="text-white text-2xl font-black italic tracking-tighter">MODEST MISSION</a>
        <div class="flex items-center gap-6">
            <a href="dashboard.php" class="text-sm font-bold text-slate-400 hover:text-white transition">Dashboard</a>
            <div class="h-8 w-[1px] bg-slate-800"></div>
            <a href="logout.php" class="text-sm font-bold text-red-500 hover:text-red-400">Logout</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Panel: Profile Info -->
            <div class="lg:col-span-1 space-y-8">
                <div class="lux-card p-10 text-center">
                    <div class="relative inline-block mb-6">
                        <div class="w-40 h-40 rounded-full border-4 border-blue-600/30 p-1 profile-glow">
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=3b82f6&color=fff&size=200" class="w-full h-full rounded-full object-cover">
                        </div>
                        <div class="absolute bottom-2 right-2 w-8 h-8 bg-emerald-500 border-4 border-[#0f172a] rounded-full"></div>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-white mb-1"><?= htmlspecialchars($user['fullname']) ?></h2>
                    <p class="text-blue-500 font-bold text-sm uppercase tracking-widest mb-4">@<?= htmlspecialchars($user['username']) ?></p>
                    <span class="px-4 py-1.5 bg-blue-600/10 border border-blue-600/20 text-blue-500 rounded-full text-[10px] font-black uppercase tracking-widest">
                        <?= strtoupper($user['role']) ?>
                    </span>

                    <div class="mt-10 pt-10 border-t border-slate-800 space-y-4">
                        <div class="flex items-center gap-4 text-left">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center border border-slate-800">
                                <iconify-icon icon="solar:letter-bold-duotone" class="text-xl text-blue-500"></iconify-icon>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Email</p>
                                <p class="text-sm text-white font-medium"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-left">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center border border-slate-800">
                                <iconify-icon icon="solar:phone-bold-duotone" class="text-xl text-emerald-500"></iconify-icon>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Phone</p>
                                <p class="text-sm text-white font-medium"><?= htmlspecialchars($user['phone'] ?? 'Not set') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Activity & Settings -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="stat-card p-6 text-center">
                        <iconify-icon icon="solar:bag-check-bold-duotone" class="text-4xl text-blue-500 mb-2"></iconify-icon>
                        <h4 class="text-2xl font-black text-white">0</h4>
                        <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Total Orders</p>
                    </div>
                    <div class="stat-card p-6 text-center">
                        <iconify-icon icon="solar:wad-of-money-bold-duotone" class="text-4xl text-emerald-500 mb-2"></iconify-icon>
                        <h4 class="text-2xl font-black text-white">₹0</h4>
                        <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Total Spent</p>
                    </div>
                    <div class="stat-card p-6 text-center">
                        <iconify-icon icon="solar:star-bold-duotone" class="text-4xl text-amber-500 mb-2"></iconify-icon>
                        <h4 class="text-2xl font-black text-white">V.I.P</h4>
                        <p class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Membership</p>
                    </div>
                </div>

                <!-- Bio / Bio Details -->
                <div class="lux-card p-10">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3">
                            <iconify-icon icon="solar:notification-lines-duotone" class="text-blue-500"></iconify-icon>
                            Account Details
                        </h3>
                        <a href="users/edit.php?id=<?= $user['id'] ?>" class="text-[10px] uppercase font-bold text-blue-500 underline tracking-widest">Edit Details</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase mb-2">Department</p>
                                <p class="text-white font-semibold"><?= htmlspecialchars($user['department'] ?? 'General') ?></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase mb-2">Designation</p>
                                <p class="text-white font-semibold"><?= htmlspecialchars($user['designation'] ?? 'Customer') ?></p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase mb-2">Join Date</p>
                                <p class="text-white font-semibold"><?= date('d F, Y', strtotime($user['created_at'])) ?></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-500 uppercase mb-2">Last Login</p>
                                <p class="text-white font-semibold">Today</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-6">
                    <button class="px-8 py-3 rounded-2xl border border-slate-800 text-sm font-bold text-slate-400 hover:text-white hover:bg-slate-900 transition-all">Download Data</button>
                    <a href="index.php" class="btn-lux">Start Shopping</a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
