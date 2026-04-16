<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'include/db.php';
require_once 'include/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Module Under Development | MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; overflow: hidden; }
        
        /* Premium Background Glows */
        .glow-1 { position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; }
        .glow-2 { position: absolute; bottom: -10%; right: -10%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(147,51,234,0.1) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; }

        /* Glassmorphism Card */
        .lux-container {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 3rem;
            animation: fadeInScale 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .rocket-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.2); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.5); }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex">

    <!-- Decorative Elements -->
    <div class="glow-1"></div>
    <div class="glow-2"></div>

    <?php include 'partials/sidebar.php'; ?>

    <main class="flex-1 flex items-center justify-center p-10 ml-72">
        
        <div class="lux-container w-full max-w-2xl p-16 text-center">
            
            <!-- Coming Soon Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/10 border border-blue-600/20 rounded-full mb-10">
                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_#3b82f6]"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-400">Coming Soon</span>
            </div>

            <!-- Animated Illustration -->
            <div class="relative mb-12">
                <div class="w-32 h-32 bg-gradient-to-br from-blue-600 to-purple-600 rounded-[2.5rem] mx-auto flex items-center justify-center pulse-glow rocket-float">
                    <iconify-icon icon="solar:rocket-bold-duotone" class="text-6xl text-white"></iconify-icon>
                </div>
                <!-- Little orbiting gears -->
                <iconify-icon icon="solar:settings-bold" class="absolute top-0 right-[35%] text-2xl text-slate-700 animate-spin" style="animation-duration: 4s"></iconify-icon>
                <iconify-icon icon="solar:settings-bold" class="absolute bottom-4 left-[38%] text-sm text-slate-800 animate-spin" style="animation-duration: 6s"></iconify-icon>
            </div>

            <!-- Content -->
            <h2 class="text-4xl font-black text-white uppercase tracking-tighter mb-4">Under Development</h2>
            <p class="text-slate-400 text-lg leading-relaxed max-w-lg mx-auto mb-10">
                This module is currently being refined and optimized to deliver a seamless, scalable SaaS experience. Stay tuned for powerful features and enhanced performance.
            </p>

            <!-- Progress Bar Placeholder -->
            <div class="w-64 h-1.5 bg-slate-900 rounded-full mx-auto overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-600 to-purple-600 w-2/3 rounded-full"></div>
            </div>
            <p class="text-[10px] uppercase font-black text-slate-600 mt-4 tracking-widest italic">Crafting Excellence...</p>

        </div>

    </main>

</body>
</html>
