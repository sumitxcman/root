<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/include/load.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Marketing | MY SHOP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Outfit', sans-serif; overflow: hidden; }
        .glass-panel { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.05); }
        .mail-list-item:hover { background: rgba(59, 130, 246, 0.1); border-left: 3px solid #3b82f6; }
        .input-glass { background: rgba(2, 6, 23, 0.5); border: 1px solid #1e293b; color: white; outline: none; }
        .input-glass:focus { border-color: #3b82f6; }
    </style>
</head>
<body class="h-screen flex flex-col">
    <header class="h-16 glass-panel border-b flex items-center px-6 justify-between flex-shrink-0 z-10 relative">
        <div class="flex items-center gap-4">
            <a href="dashboard.php" class="text-slate-400 hover:text-white transition"><iconify-icon icon="solar:alt-arrow-left-line-duotone" class="text-2xl"></iconify-icon></a>
            <h1 class="text-xl font-black text-white italic">MY SHOP <span class="text-blue-500 not-italic font-bold ml-2">Mailer</span></h1>
        </div>
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="w-8 h-8 rounded-full border border-blue-500/50">
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden relative">
        <!-- Sidebar Folders -->
        <aside class="w-64 glass-panel border-r h-full p-4 flex flex-col gap-2 relative z-10">
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl mb-6 shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
                <iconify-icon icon="solar:pen-bold"></iconify-icon> Compose
            </button>
            <p class="text-[10px] uppercase font-black tracking-widest text-slate-500 px-3 mb-2">Folders</p>
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-500/10 text-blue-500 cursor-pointer font-semibold"><iconify-icon icon="solar:inbox-bold" class="text-lg"></iconify-icon> Inbox <span class="ml-auto bg-blue-500 text-white px-2 py-0.5 rounded-full text-[10px]">14</span></div>
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white cursor-pointer transition"><iconify-icon icon="solar:plain-2-linear" class="text-lg"></iconify-icon> Sent</div>
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white cursor-pointer transition"><iconify-icon icon="solar:document-linear" class="text-lg"></iconify-icon> Drafts</div>
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white cursor-pointer transition"><iconify-icon icon="solar:trash-bin-linear" class="text-lg"></iconify-icon> Trash</div>
        </aside>

        <!-- Main Composer -->
        <main class="flex-1 overflow-y-auto p-8 relative z-10">
            <div class="max-w-4xl mx-auto glass-panel rounded-2xl p-6 shadow-2xl">
                <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-2"><iconify-icon icon="solar:letter-bold-duotone" class="text-blue-500"></iconify-icon> New Message</h2>
                <div class="space-y-4">
                    <div class="flex items-center border-b border-slate-800 py-2">
                        <span class="text-slate-500 font-bold text-sm w-16">To:</span>
                        <input type="text" class="flex-1 bg-transparent border-none text-white outline-none font-medium" placeholder="customer@example.com">
                    </div>
                    <div class="flex items-center border-b border-slate-800 py-2">
                        <span class="text-slate-500 font-bold text-sm w-16">Subject:</span>
                        <input type="text" class="flex-1 bg-transparent border-none text-white outline-none font-medium text-lg" placeholder="Exclusive Offer for You!">
                    </div>
                    <div class="mt-4">
                        <textarea class="w-full h-64 input-glass rounded-xl p-4 resize-none" placeholder="Write something luxurious..."></textarea>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                        <div class="flex gap-2">
                            <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-slate-800 text-slate-400 transition"><iconify-icon icon="solar:text-bold" class="text-xl"></iconify-icon></button>
                            <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-slate-800 text-slate-400 transition"><iconify-icon icon="solar:paperclip-linear" class="text-xl"></iconify-icon></button>
                        </div>
                        <button class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:opacity-90 text-white font-bold py-2.5 px-8 rounded-xl flex items-center gap-2 shadow-lg shadow-indigo-500/30 transition-transform hover:-translate-y-0.5">
                            Send Email <iconify-icon icon="solar:plain-2-bold"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Animated Background Orbs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] pointer-events-none"></div>
    </div>
</body>
</html>
