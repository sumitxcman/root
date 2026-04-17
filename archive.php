<?php
session_start();
include_once 'include/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Vault - Archive | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; }
        html { font-size: 14px; /* Global scale down */ }
        .hero-section { background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.1) 0%, #020617 70%); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .archive-item { opacity: 0.7; transition: 0.4s; cursor: not-allowed; }
        .archive-item:hover { opacity: 1; }
    </style>
</head>
<body class="antialiased">

    <nav class="sticky top-0 z-50 h-[90px] flex items-center px-12 justify-between bg-black/50 backdrop-blur-3xl border-b border-white/5">
        <div class="flex items-center gap-4">
            <iconify-icon icon="solar:crown-minimalistic-bold-duotone" class="text-3xl text-amber-500"></iconify-icon>
            <a href="index.php" class="text-white text-2xl font-black italic tracking-tighter uppercase">Modest Mission</a>
        </div>
        <div class="flex items-center gap-12">
            <div class="hidden lg:flex items-center gap-8 text-[9px] font-black uppercase tracking-[0.3em] text-slate-500">
                <a href="collections.php" class="hover:text-white transition">Collections</a>
                <a href="archive.php" class="text-amber-500 transition">The Archive</a>
                <a href="faq.php" class="hover:text-white transition">Bespoke Support</a>
            </div>
            <a href="index.php" class="text-[10px] font-black uppercase text-amber-500 tracking-widest border border-amber-500/20 px-6 py-3 rounded-full hover:bg-amber-500 hover:text-white transition bg-black/20 backdrop-blur-xl">Return</a>
        </div>
    </nav>

    <header class="hero-section text-center py-32 px-4">
        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-slate-500 italic mb-6 block">Historical Records</span>
        <h1 class="text-7xl font-black text-white uppercase tracking-tighter italic leading-none">The<br><span class="text-slate-500">Archive.</span></h1>
        <p class="text-slate-500 mt-8 max-w-2xl mx-auto text-lg leading-relaxed font-light">A museum of legacy assets that have completed their lifecycle. These items are permanently out of stock and serve solely as a testament to our history.</p>
    </header>

    <main class="max-w-[1200px] mx-auto p-12 md:p-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="archive-item bg-[#0f172a] rounded-3xl overflow-hidden border border-slate-800 p-6 text-center shadow-inner">
                <iconify-icon icon="solar:lock-bold-duotone" class="text-4xl text-slate-600 mb-4"></iconify-icon>
                <h4 class="text-white font-black uppercase tracking-widest text-sm mb-2">Series Alpha</h4>
                <p class="text-[10px] text-slate-500 uppercase">Archived: 2024</p>
            </div>
            <div class="archive-item bg-[#0f172a] rounded-3xl overflow-hidden border border-slate-800 p-6 text-center shadow-inner">
                <iconify-icon icon="solar:lock-bold-duotone" class="text-4xl text-slate-600 mb-4"></iconify-icon>
                <h4 class="text-white font-black uppercase tracking-widest text-sm mb-2">Founder's Edition</h4>
                <p class="text-[10px] text-slate-500 uppercase">Archived: 2025</p>
            </div>
            <div class="archive-item bg-[#0f172a] rounded-3xl overflow-hidden border border-slate-800 p-6 text-center shadow-inner">
                <iconify-icon icon="solar:lock-bold-duotone" class="text-4xl text-slate-600 mb-4"></iconify-icon>
                <h4 class="text-white font-black uppercase tracking-widest text-sm mb-2">Omega Concept</h4>
                <p class="text-[10px] text-slate-500 uppercase">Archived: 2026</p>
            </div>
        </div>
    </main>

</body>
</html>
