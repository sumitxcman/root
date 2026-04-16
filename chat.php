<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/include/load.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Chat | MY SHOP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family= आउटफिट:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Outfit', sans-serif; overflow: hidden; }
        .glass-panel { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.05); }
        .chat-bubble-sent { background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%); color: white; border-radius: 20px 20px 4px 20px; }
        .chat-bubble-received { background: #1e293b; color: #e2e8f0; border-radius: 20px 20px 20px 4px; border: 1px solid #334155; }
        .hide-scroll::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="h-screen flex flex-col relative">
    <!-- Animated Orbs -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <header class="h-16 glass-panel border-b flex items-center px-6 justify-between flex-shrink-0 z-10">
        <div class="flex items-center gap-4">
            <a href="dashboard.php" class="text-slate-400 hover:text-white transition"><iconify-icon icon="solar:alt-arrow-left-line-duotone" class="text-2xl"></iconify-icon></a>
            <h1 class="text-xl font-black text-white italic">MY SHOP <span class="text-indigo-500 not-italic font-bold ml-2">Chat</span></h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <iconify-icon icon="solar:bell-bing-bold-duotone" class="text-xl text-slate-400 hover:text-white cursor-pointer"></iconify-icon>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden z-10">
        <!-- Contacts Sidebar -->
        <aside class="w-80 glass-panel border-r flex flex-col">
            <div class="p-4 border-b border-slate-800">
                <div class="relative">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></iconify-icon>
                    <input type="text" placeholder="Search customers..." class="w-full bg-[#0f172a] border border-slate-800 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white outline-none focus:border-blue-500">
                </div>
            </div>
            <div class="flex-1 overflow-y-auto hide-scroll p-2 space-y-1">
                <!-- Contact Item (Active) -->
                <div class="flex items-center gap-3 p-3 rounded-xl bg-blue-500/10 border border-blue-500/20 cursor-pointer">
                    <div class="relative shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Emma+W&background=10b981&color=fff" class="w-10 h-10 rounded-full">
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-[#0f172a]"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-0.5">
                            <h4 class="text-white font-bold text-sm truncate">Emma Watson</h4>
                            <span class="text-[10px] font-medium text-blue-400">Just now</span>
                        </div>
                        <p class="text-xs text-slate-400 truncate">Is the Rolex Cosmograph in stock?</p>
                    </div>
                </div>
                
                <!-- Contact Item -->
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-800/50 cursor-pointer transition">
                    <div class="relative shrink-0">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=f59e0b&color=fff" class="w-10 h-10 rounded-full opacity-60">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-0.5">
                            <h4 class="text-slate-300 font-bold text-sm truncate">John Doe</h4>
                            <span class="text-[10px] font-medium text-slate-600">2h ago</span>
                        </div>
                        <p class="text-xs text-slate-500 truncate">Thanks tracking received.</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Chat Area -->
        <main class="flex-1 flex flex-col bg-[#020617]/50 relative">
            <!-- Chat Header -->
            <div class="h-16 border-b border-slate-800 flex items-center justify-between px-6 bg-[#0f172a]/80 backdrop-blur z-10">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Emma+W&background=10b981&color=fff" class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="text-white font-bold">Emma Watson</h3>
                        <p class="text-[10px] text-emerald-400 flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> Online now</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-white hover:bg-slate-700 transition"><iconify-icon icon="solar:phone-bold"></iconify-icon></button>
                    <button class="w-9 h-9 rounded-full bg-slate-800 flex items-center justify-center text-white hover:bg-slate-700 transition"><iconify-icon icon="solar:menu-dots-bold"></iconify-icon></button>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 hide-scroll z-10">
                <div class="text-center"><span class="bg-slate-800 text-[10px] font-bold uppercase tracking-widest text-slate-400 px-3 py-1 rounded-full">Today</span></div>
                
                <!-- Received Msg -->
                <div class="flex items-end gap-2">
                    <img src="https://ui-avatars.com/api/?name=Emma+W&background=10b981&color=fff" class="w-6 h-6 rounded-full mb-1">
                    <div class="chat-bubble-received p-4 max-w-md shadow-lg text-sm">
                        Hi, I'm interested in the new Rolex Cosmograph Daytona catalog drop. Is it still available for immediate shipping?
                    </div>
                    <span class="text-[10px] text-slate-500 mb-1">10:42 AM</span>
                </div>

                <!-- Sent Msg -->
                <div class="flex items-end justify-end gap-2">
                    <span class="text-[10px] text-slate-500 mb-1">10:45 AM</span>
                    <div class="chat-bubble-sent p-4 max-w-md shadow-lg shadow-blue-500/20 text-sm">
                        Hello Emma! Yes, we have exactly one piece left in stock. I can hold it for you if you'd like to check out now. 💎
                    </div>
                </div>
            </div>

            <!-- Composer Input -->
            <div class="p-4 bg-[#0f172a] border-t border-slate-800 z-10">
                <div class="flex items-center gap-2 bg-[#020617] p-2 rounded-2xl border border-slate-800 focus-within:border-indigo-500 transition-colors">
                    <button class="p-2 text-slate-400 hover:text-white"><iconify-icon icon="solar:paperclip-linear" class="text-xl"></iconify-icon></button>
                    <input type="text" placeholder="Type a luxurious response..." class="flex-1 bg-transparent outline-none text-white text-sm">
                    <button class="w-10 h-10 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-white flex items-center justify-center shadow-lg shadow-indigo-500/30 transition-transform hover:scale-105">
                        <iconify-icon icon="solar:plain-2-bold" class="text-lg"></iconify-icon>
                    </button>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
