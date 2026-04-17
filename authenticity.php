<?php
session_start();
include_once 'include/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authenticity Protocol | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; }
        .lux-card { background: #0f172a; border: 1px solid rgba(255,255,255,0.05); border-radius: 2.5rem; padding: 3rem; }
        .step-number { font-size: 8rem; font-weight: 900; -webkit-text-stroke: 1px rgba(197, 160, 89, 0.2); color: transparent; position: absolute; top: -2rem; right: 2rem; z-index: 0; }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 h-[90px] flex items-center px-12 justify-between bg-black/50 backdrop-blur-3xl border-b border-white/5">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 border border-amber-500/20 rounded-xl flex items-center justify-center bg-amber-500/5 rotate-45">
                <iconify-icon icon="solar:crown-minimalistic-bold-duotone" class="text-2xl text-amber-500 rotate-[-45deg]"></iconify-icon>
            </div>
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

    <main class="max-w-[1200px] mx-auto p-12 md:p-24">
        <header class="text-center mb-32">
            <span class="text-[10px] font-black uppercase tracking-[0.5em] text-amber-500 italic mb-6 block">The Trust Architecture</span>
            <h1 class="text-7xl font-black text-white uppercase tracking-tighter italic leading-none">Guaranteed<br><span class="text-amber-500">Authenticity.</span></h1>
            <p class="text-slate-500 mt-10 max-w-2xl mx-auto text-lg leading-relaxed font-light">At Modest Mission, authenticity is not an option—it is our fundamental law. Every item is subjected to a rigorous 5-step cryptographic and manual verification protocol before entering our archive.</p>
        </header>

        <div class="space-y-12">
            <!-- Step 1 -->
            <div class="lux-card relative overflow-hidden group">
                <span class="step-number">01</span>
                <div class="relative z-10 max-w-2xl">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-4">Master Origin Analysis</h3>
                    <p class="text-slate-400">We verify the lineage of the asset directly with original manufacturers and authorized distributors using direct-line verification.</p>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="lux-card relative overflow-hidden group">
                <span class="step-number">02</span>
                <div class="relative z-10 max-w-2xl">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-4">Manual Expert Review</h3>
                    <p class="text-slate-400">Our senior curators inspect every stitch, serial number, and texture under high-precision magnification to ensure zero deviations.</p>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="lux-card relative overflow-hidden group">
                <span class="step-number">03</span>
                <div class="relative z-10 max-w-2xl">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-4">Cryptographic Tagging</h3>
                    <p class="text-slate-400">Each authenticated item is assigned a unique digital certificate stored on our private ledger for eternal verification.</p>
                </div>
            </div>
            <!-- Step 4 -->
            <div class="lux-card relative overflow-hidden group">
                <span class="step-number">04</span>
                <div class="relative z-10 max-w-2xl">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-4">Condition Grading</h3>
                    <p class="text-slate-400">We only archive "Pristine+" grade items. Any item that does not meet our 99.9% quality score is immediately rejected.</p>
                </div>
            </div>
            <!-- Step 5 -->
            <div class="lux-card relative overflow-hidden group">
                <span class="step-number">05</span>
                <div class="relative z-10 max-w-2xl">
                    <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-4">Seal of Authority</h3>
                    <p class="text-slate-400">Once verified, the item receives the physical Modest Mission Golden Seal—the ultimate mark of global luxury assurance.</p>
                </div>
            </div>
        </div>

        <div class="mt-32 text-center p-20 bg-amber-500/5 rounded-[4rem] border border-amber-500/10">
            <iconify-icon icon="solar:shield-check-bold-duotone" class="text-6xl text-amber-500 mb-6"></iconify-icon>
            <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter">Shop with 100% confidence.</h2>
            <p class="text-slate-500 mt-4">Every purchase is protected by our Life-Term Authenticity Guarantee.</p>
            <a href="index.php" class="mt-10 inline-block px-12 py-5 bg-amber-500 text-white font-black uppercase text-[10px] tracking-widest rounded-full">Explore the Archive</a>
        </div>
    </main>

</body>
</html>
