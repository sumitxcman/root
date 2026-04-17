<?php
session_start();
include_once 'include/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elite Logistics | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .hero-bg { background: linear-gradient(rgba(2,6,23,0.8), rgba(2,6,23,0.8)), url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=1200'); background-size: cover; background-position: center; height: 60vh; border-radius: 0 0 5rem 5rem; }
        .node-card { background: #0f172a; border: 1px solid rgba(255,255,255,0.05); border-radius: 2rem; padding: 2.5rem; }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="absolute top-0 left-0 w-full z-50 h-[90px] flex items-center px-12 justify-between">
        <div class="flex items-center gap-4">
            <iconify-icon icon="solar:crown-minimalistic-bold-duotone" class="text-3xl text-amber-500"></iconify-icon>
            <a href="index.php" class="text-white text-2xl font-black italic tracking-tighter uppercase">Modest Mission</a>
        </div>
        <div class="flex items-center gap-12">
            <div class="hidden lg:flex items-center gap-8 text-[9px] font-black uppercase tracking-[0.3em] text-slate-500">
                <a href="collections.php" class="hover:text-white transition">Collections</a>
                <a href="archive.php" class="hover:text-white transition">The Archive</a>
                <a href="faq.php" class="hover:text-white transition">Bespoke Support</a>
            </div>
            <a href="index.php" class="text-[10px] font-black uppercase text-amber-500 tracking-widest border border-amber-500/20 px-6 py-3 rounded-full hover:bg-amber-500 hover:text-white transition bg-black/20 backdrop-blur-xl">Return</a>
        </div>
    </nav>

    <header class="hero-bg flex items-center justify-center text-center p-12">
        <div class="max-w-4xl">
            <span class="text-[10px] font-black uppercase tracking-[0.6em] text-blue-500 mb-6 block">Supply Chain Mastery</span>
            <h1 class="text-7xl font-black text-white uppercase tracking-tighter italic leading-none">Elite<br><span class="text-blue-500">Logistics.</span></h1>
            <p class="text-slate-400 mt-8 text-lg font-light">Global reach at the speed of thought. Our private courier network ensures your assets are delivered with absolute security and unprecedented speed.</p>
        </div>
    </header>

    <main class="max-w-[1400px] mx-auto p-12 md:p-24">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center mb-32">
            <div class="space-y-8">
                <h2 class="text-4xl font-black text-white tracking-tighter italic uppercase">Overnight Access.</h2>
                <p class="text-slate-500 leading-relaxed">Leveraging our partnerships with elite air-freight and private aviation networks, we move assets across borders in record time. From New York to Dubai, our delivery timeline remains the industry benchmark.</p>
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600/10 rounded-xl flex items-center justify-center text-blue-500"><iconify-icon icon="solar:globus-bold-duotone" class="text-2xl"></iconify-icon></div>
                        <p class="text-sm font-bold text-white uppercase italic">150+ Global Strategic Nodes</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600/10 rounded-xl flex items-center justify-center text-blue-500"><iconify-icon icon="solar:box-bold-duotone" class="text-2xl"></iconify-icon></div>
                        <p class="text-sm font-bold text-white uppercase italic">Zero-Contact Tamper-Proof Packaging</p>
                    </div>
                </div>
            </div>
            <div class="node-card border-none shadow-2xl shadow-blue-500/10">
                <h4 class="text-xl font-black text-white uppercase italic mb-8">Current Active Hubs</h4>
                <div class="space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                        <span class="text-xs font-bold uppercase tracking-widest">London Node</span>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[8px] font-black rounded-full uppercase">Optimal</span>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                        <span class="text-xs font-bold uppercase tracking-widest">Dubai Prime Vault</span>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[8px] font-black rounded-full uppercase">Optimal</span>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-slate-800">
                        <span class="text-xs font-bold uppercase tracking-widest">Singapore Central</span>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[8px] font-black rounded-full uppercase">Optimal</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-widest">Mumbai Hub</span>
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[8px] font-black rounded-full uppercase">Optimal</span>
                    </div>
                </div>
            </div>
        </div>

        <section class="p-20 bg-slate-900 rounded-[4rem] text-center">
            <h2 class="text-4xl font-black text-white italic uppercase mb-10 tracking-tighter">Securing the last mile.</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="space-y-4">
                    <h5 class="text-blue-500 font-black uppercase text-xs tracking-[0.3em]">Armored Delivery</h5>
                    <p class="text-xs text-slate-500">For high-valuation assets, we deploy armored transit from regional nodes directly to your sanctuary.</p>
                </div>
                <div class="space-y-4">
                    <h5 class="text-blue-500 font-black uppercase text-xs tracking-[0.3em]">White Glove Service</h5>
                    <p class="text-xs text-slate-500">Unboxing and verification ceremonies conducted by trained hospitality and security specialists.</p>
                </div>
                <div class="space-y-4">
                    <h5 class="text-blue-500 font-black uppercase text-xs tracking-[0.3em]">Global Insurance</h5>
                    <p class="text-xs text-slate-500">100% replacement value coverage starting from the moment the asset leaves our master vault.</p>
                </div>
            </div>
        </section>

    </main>

</body>
</html>
