<?php
session_start();
include_once 'include/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Curated Collections | MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; position: relative; overflow-x: hidden; }
        body::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('https://www.transparenttextures.com/patterns/black-linen.png'); opacity: 0.1; pointer-events: none; z-index: 1; }
        html { font-size: 14px; }
        .hero-section { background: radial-gradient(circle at 50% 100%, rgba(197, 160, 89, 0.1) 0%, #020617 70%); border-bottom: 1px solid rgba(255,255,255,0.05); position: relative; z-index: 2; }
        .glass-card { background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.03); border-radius: 3rem; overflow: hidden; transition: 0.8s cubic-bezier(0.2, 1, 0.3, 1); cursor: pointer; position: relative; z-index: 2; }
        .glass-card:hover { transform: translateY(-12px) scale(1.01); border-color: rgba(197, 160, 89, 0.3); box-shadow: 0 40px 80px rgba(0,0,0,0.8), 0 0 30px rgba(197, 160, 89, 0.05); }
        .card-tag { position: absolute; top: 20px; left: 20px; background: rgba(197, 160, 89, 0.9); color: black; padding: 6px 14px; border-radius: 2rem; font-size: 8px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em; z-index: 10; box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .inventory-status { position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); color: white; padding: 6px 14px; border-radius: 2.5rem; font-size: 8px; font-weight: 800; border: 1px solid rgba(255,255,255,0.1); z-index: 10; }
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
                <a href="collections.php" class="text-amber-500 transition">Collections</a>
                <a href="archive.php" class="hover:text-white transition">The Archive</a>
                <a href="faq.php" class="hover:text-white transition">Bespoke Support</a>
            </div>
            <a href="index.php" class="text-[10px] font-black uppercase text-amber-500 tracking-widest border border-amber-500/20 px-6 py-3 rounded-full hover:bg-amber-500 hover:text-white transition bg-black/20 backdrop-blur-xl">Return</a>
        </div>
    </nav>

    <header class="hero-section text-center py-20 px-4">
        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-amber-500 italic mb-4 block">Premium Curation</span>
        <h1 class="text-6xl font-black text-white uppercase tracking-tighter italic leading-none">The<br><span class="text-amber-500">Collections.</span></h1>
        <p class="text-slate-500 mt-6 max-w-2xl mx-auto text-base leading-relaxed font-light">Explore our handpicked selections categorized by rarity, origin, and craftsmanship. Every collection represents a distinct chapter in the world of luxury.</p>
    </header>

    <main class="max-w-[1400px] mx-auto p-8 md:p-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <!-- 1. Horology -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag">Heritage Edition</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    12 ASSETS LEFT
                </div>
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-amber-500/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Fine Horology</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Horology Elite</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Precision timepieces sourced from independent Swiss watchmakers. Limited to strictly 50 units globally.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-amber-500 group-hover:translate-x-2 transition-all">Explore &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-01</span>
                </div>
            </div>
        </div>
        
        <!-- 2. Leather Goods -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-blue-600/90 text-white">Private Reserve</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                    LOCKED ACCESS
                </div>
                <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-blue-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Master Craftsmanship</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Artisan Leather</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Hand-stitched leather goods crafted in Florence, Italy. Each piece requires over 40 hours of manual labor.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-blue-500 group-hover:translate-x-2 transition-all">Explore &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-02</span>
                </div>
            </div>
        </div>

        <!-- 3. Jewelry -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-purple-600/90 text-white">Bespoke Only</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full animate-pulse"></span>
                    VAULT SECURED
                </div>
                <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-purple-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Haute Joaillerie</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Rare Diamonds</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Exquisite colorless diamonds and rare gemstones. Certified by the Global Gemological Authority.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-purple-500 group-hover:translate-x-2 transition-all">Inquire &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-03</span>
                </div>
            </div>
        </div>

        <!-- 4. Automotive -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-red-600/90 text-white">Collector Tier</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                    2 SLOTS AVAILABLE
                </div>
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-red-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Elite Motion</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Classic Rarities</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Iconic automotive masterpieces from the silver screen and historic races. Fully restored and certified.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-red-500 group-hover:translate-x-2 transition-all">Catalogue &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-04</span>
                </div>
            </div>
        </div>

        <!-- 5. Fine Art -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-cyan-600/90 text-white">Cultural Asset</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full animate-pulse"></span>
                    ESTATE SALE
                </div>
                <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-cyan-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Visual Legacy</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Contemporary Art</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Original creations from disruptive global artists. Each piece serves as a cornerstone for high-end collections.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-cyan-500 group-hover:translate-x-2 transition-all">Gallery View &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-05</span>
                </div>
            </div>
        </div>

        <!-- 6. Fragrances -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-white text-black">Limited Run</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-slate-100 rounded-full animate-pulse"></span>
                    BATCH-09 ACTIVE
                </div>
                <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-slate-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Olfactory Signature</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Exotic Fragrances</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Rare distillations from Grasse, France. Complex profiles designed to evolve on the skin over 24 hours.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-slate-400 group-hover:translate-x-2 transition-all">Discovery Set &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-06</span>
                </div>
            </div>
        </div>

        <!-- 7. Bespoke Tailoring -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-zinc-800 text-white border border-white/10">Savile Row Standard</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                    FIT SLOTS OPEN
                </div>
                <img src="https://images.unsplash.com/photo-1593032465175-481ac7f401a0?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-zinc-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Sartorial Precision</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Custom Coutoure</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Bespoke garments tailored to anatomical perfection using rare fabrics from Italian mills.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-zinc-400 group-hover:translate-x-2 transition-all">Consultation &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-07</span>
                </div>
            </div>
        </div>

        <!-- 8. Aviation -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-blue-900 text-white">Global Mobility</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-sky-400 rounded-full animate-pulse"></span>
                    PRE-ORDER ACTIVE
                </div>
                <img src="https://images.unsplash.com/photo-1540962351504-03099e0a754b?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-sky-400/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Aero Logistics</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Private Aviation</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Fractional ownership and bespoke interior assets for long-range global travel. The pinnacle of mobility.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-sky-400 group-hover:translate-x-2 transition-all">Fleet Portal &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-08</span>
                </div>
            </div>
        </div>

        <!-- 9. Spirits -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-amber-900 text-white">Vintage Library</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-amber-600 rounded-full"></span>
                    CELLAR VERIFIED
                </div>
                <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-amber-600/60 uppercase tracking-[0.4em] mb-2 leading-none italic">Liquid Assets</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Elite Spirits</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Rare vintages and aged single malts sourced from private cellars. Each bottle is a historical investment.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-amber-600 group-hover:translate-x-2 transition-all">The Vault &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-09</span>
                </div>
            </div>
        </div>

        <!-- 10. Home Sanctuary -->
        <div class="glass-card group h-full flex flex-col">
            <div class="h-60 overflow-hidden relative">
                <div class="card-tag bg-stone-300 text-black">Architectural Series</div>
                <div class="inventory-status flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-stone-500 rounded-full animate-pulse"></span>
                    BESPOKE ORDERS
                </div>
                <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] to-transparent opacity-60"></div>
            </div>
            <div class="p-8 flex-1 flex flex-col">
                <p class="text-[8px] font-black text-stone-400 uppercase tracking-[0.4em] mb-2 leading-none italic">Interior Philosophy</p>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Modern Sanctuary</h3>
                <p class="text-slate-400 mt-4 text-xs leading-relaxed font-light">Minimalist furniture and architectural accents designed to transform living spaces into private refuges.</p>
                <div class="mt-auto pt-8 flex items-center justify-between border-t border-white/5">
                    <div class="text-[9px] uppercase font-black tracking-widest text-stone-400 group-hover:translate-x-2 transition-all">Portfolio &rarr;</div>
                    <span class="text-[8px] font-bold text-slate-700 tracking-widest uppercase italic">MM-XXVI-10</span>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
