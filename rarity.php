<?php
session_start();
include_once 'include/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Curated Rarity | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; }
        .rarity-hero { background: radial-gradient(circle at center, #1e293b 0%, #020617 100%); padding: 100px 20px; text-align: center; }
        .gallery-item { background: #0f172a; border-radius: 3rem; position: relative; overflow: hidden; height: 500px; }
        .overlay { position: absolute; inset: 0; background: linear-gradient(to top, #020617, transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 3rem; }
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
                <a href="archive.php" class="hover:text-white transition">The Archive</a>
                <a href="faq.php" class="hover:text-white transition">Bespoke Support</a>
            </div>
            <a href="index.php" class="text-[10px] font-black uppercase text-amber-500 tracking-widest border border-amber-500/20 px-6 py-3 rounded-full hover:bg-amber-500 hover:text-white transition bg-black/20 backdrop-blur-xl">Return</a>
        </div>
    </nav>

    <header class="rarity-hero">
        <span class="text-[10px] font-black uppercase tracking-[0.8em] text-purple-500 mb-6 block">The Sourcing Philosophy</span>
        <h1 class="text-8xl font-black text-white italic tracking-tighter uppercase leading-none">Curated<br><span class="text-purple-500">Rarity.</span></h1>
        <p class="text-slate-500 mt-12 max-w-2xl mx-auto text-lg font-light leading-relaxed">We don't stock inventory; we archive legacies. Our selection process is ruthlessly exclusive, accepting only 1% of the assets we evaluate.</p>
    </header>

    <main class="max-w-[1600px] mx-auto p-12 md:p-24">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="gallery-item group">
                <img src="https://images.unsplash.com/photo-1590736913614-2ec5b5ed7d01?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                <div class="overlay">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-2">Mechanical Art</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Limited Series Horology</p>
                </div>
            </div>
            <div class="gallery-item group">
                <img src="https://images.unsplash.com/photo-1547991270-d1624f48674a?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                <div class="overlay">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-2">Leather Legends</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Private Atelier Commissions</p>
                </div>
            </div>
        </div>

        <section class="mt-32 border-t border-slate-900 pt-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-32">
                <div class="space-y-10">
                    <h2 class="text-5xl font-black text-white italic tracking-tighter uppercase leading-tight">Ruthless Selection. <br>Pinnacle Results.</h2>
                    <p class="text-slate-500 text-lg leading-relaxed">Our scouts are stationed in world capitals, attending private auctions and secret atelier reveals. We source assets that are often unavailable to the general public, ensuring your collection remains peerless.</p>
                </div>
                <div class="grid grid-cols-2 gap-12">
                    <div class="space-y-4">
                        <span class="text-5xl font-black text-purple-500 italic">0.2%</span>
                        <p class="text-[10px] font-black text-white uppercase tracking-widest">Acceptance Rate</p>
                    </div>
                    <div class="space-y-4">
                        <span class="text-5xl font-black text-purple-500 italic">100%</span>
                        <p class="text-[10px] font-black text-white uppercase tracking-widest">Asset Integrity</p>
                    </div>
                    <div class="space-y-4">
                        <span class="text-5xl font-black text-purple-500 italic">1 OF 1</span>
                        <p class="text-[10px] font-black text-white uppercase tracking-widest">Unique Archiving</p>
                    </div>
                    <div class="space-y-4">
                        <span class="text-5xl font-black text-purple-500 italic">85+</span>
                        <p class="text-[10px] font-black text-white uppercase tracking-widest">Global Watchpoints</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="mt-32 p-20 text-center border-t border-white/5 opacity-50">
        <span class="text-[10px] font-black text-slate-800 uppercase tracking-[1em] italic">Authorized Selection Only</span>
    </footer>

</body>
</html>
