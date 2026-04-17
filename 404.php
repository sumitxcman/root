<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Outfit', sans-serif; overflow: hidden; }
        .glitch-text { text-shadow: 2px 0 #3b82f6, -2px 0 #ef4444; animation: glitch 2s infinite linear alternate-reverse; }
        @keyframes glitch {
            0% { transform: skew(0deg); }
            5% { transform: skew(-5deg); }
            10% { transform: skew(0deg); }
            100% { transform: skew(0deg); }
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center relative">
    <!-- Grid Background -->
    <div class="absolute inset-0 z-0 opacity-10" style="background-size: 50px 50px; background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px);"></div>
    
    <div class="relative z-10 text-center px-4">
        <iconify-icon icon="solar:ghost-bold-duotone" class="text-9xl text-slate-700 mb-6 drop-shadow-2xl"></iconify-icon>
        <h1 class="text-9xl font-black text-white tracking-tighter glitch-text mb-4">404</h1>
        <h2 class="text-3xl font-bold text-white mb-2">Lost in the void.</h2>
        <p class="text-slate-400 mb-10 max-w-md mx-auto">The premium asset you are looking for does not exist on our servers, or has been relocated securely.</p>
        
        <div class="flex justify-center gap-4">
            <a href="dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl text-sm transition-all shadow-xl shadow-blue-600/20 uppercase tracking-widest flex items-center gap-2">
                <iconify-icon icon="solar:home-smile-bold-duotone" class="text-lg"></iconify-icon> Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
