<?php
session_start();
require_once 'include/db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$username = $_SESSION['username'] ?? 'User';

// Products Fetch
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 12");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $products = []; }

// Add to Cart Logic
if (isset($_POST['add_id'])) {
    $add_id = $_POST['add_id'];
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$add_id])) $_SESSION['cart'][$add_id]++;
    else $_SESSION['cart'][$add_id] = 1;
    header("Location: cart/checkout.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MODEST MISSION | Global Luxury Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        :root { --lux-gold: #c5a059; --lux-blue: #2563eb; --lux-dark: #020617; }
        body { background-color: var(--lux-dark); color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--lux-gold); }

        .glass-header { background: rgba(2, 6, 23, 0.7); backdrop-filter: blur(30px); border-bottom: 1px solid rgba(255,255,255,0.03); }
        
        body { background-color: #020617; color: #94a3b8; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; position: relative; }
        body::before { content: ""; position: absolute; top: -10%; left: -10%; width: 50%; height: 50%; background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%); animation: drift 25s infinite alternate ease-in-out; z-index: -1; }
        body::after { content: ""; position: absolute; bottom: -10%; right: -10%; width: 40%; height: 40%; background: radial-gradient(circle, rgba(197,160,89,0.08) 0%, transparent 70%); animation: drift 30s infinite alternate-reverse ease-in-out; z-index: -1; }
        
        @keyframes drift {
            from { transform: translate(0, 0) scale(1) rotate(0deg); }
            to { transform: translate(10%, 15%) scale(1.1) rotate(5deg); }
        }

        .luxe-card { background: linear-gradient(135deg, #0f172a 0%, #020617 100%); border-radius: 3rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.03); transition: 1s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 40px 100px -20px rgba(0,0,0,0.8); position: relative; }
        .luxe-card::before { content: ""; position: absolute; inset: 0; background: linear-gradient(45deg, transparent 40%, rgba(197, 160, 89, 0.05) 50%, transparent 60%); transform: translateX(-100%); transition: 0.8s; z-index: 10; pointer-events: none; }
        .luxe-card:hover::before { transform: translateX(100%); }
        .luxe-card:hover { transform: translateY(-20px) scale(1.02); border-color: rgba(197, 160, 89, 0.3); box-shadow: 0 80px 140px -40px rgba(0,0,0,0.9), 0 0 50px rgba(197,160,89,0.08); }
        
        .image-box { height: 220px; width: 100%; border-bottom: 1px solid rgba(255,255,255,0.01); overflow: hidden; position: relative; z-index: 1; }
        .image-box img { width: 100%; height: 100%; object-fit: cover; transition: 2s cubic-bezier(0.16, 1, 0.3, 1); filter: grayscale(40%) contrast(1.1); }
        .luxe-card:hover .image-box img { transform: scale(1.18); filter: grayscale(0%) contrast(1.0); }
        
        .floating-price { position: absolute; bottom: 25px; right: 25px; background: rgba(2, 6, 23, 0.9); backdrop-filter: blur(15px); padding: 10px 22px; border-radius: 1.5rem; border: 1px solid rgba(255,255,255,0.08); z-index: 10; transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .luxe-card:hover .floating-price { background: #c5a059; color: black; transform: scale(1.1); box-shadow: 0 10px 30px rgba(197,160,89,0.3); }
        .luxe-card:hover .floating-price span { color: #020617; }

        .btn-protocol { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(10px); transition: 0.6s; border: 1px solid rgba(255,255,255,0.05); cursor: pointer; }
        .btn-protocol:hover { background: #c5a059; color: #020617; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(197,160,89,0.2); }
        .btn-protocol iconify-icon { transition: 0.5s; }
        .btn-protocol:hover iconify-icon { transform: rotate(15deg) scale(1.2); }
        .btn-protocol:hover { border-color: var(--lux-gold); color: var(--lux-gold); box-shadow: 0 0 20px rgba(197, 160, 89, 0.1); }

        .gold-underline { position: relative; width: fit-content; }
        .gold-underline::after { content: ''; position: absolute; bottom: -8px; left: 0; width: 40px; height: 4px; background: var(--lux-gold); border-radius: 2px; }
    </style>
</head>
<body class="antialiased selection:bg-amber-500/20">

    <div class="hero-glow"></div>

    <!-- Ultra-Luxe Navbar -->
    <nav class="glass-header sticky top-0 z-[100] h-[90px] flex items-center px-12 justify-between">
        <div class="flex items-center gap-6">
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
            
            <div class="flex items-center gap-6">
                <?php if(!$isLoggedIn): ?>
                    <a href="sign-in.php" class="text-[9px] font-black uppercase text-amber-500 tracking-[0.2em] border border-amber-500/20 px-8 py-3 rounded-full hover:bg-amber-500 hover:text-white transition-all shadow-xl shadow-amber-500/5">Client Authentication</a>
                <?php else: ?>
                    <div class="flex items-center gap-4 bg-white/5 border border-white/5 p-1.5 pr-6 rounded-2xl">
                        <img src="https://ui-avatars.com/api/?name=<?= $username ?>&background=c5a059&color=fff" class="w-10 h-10 rounded-xl">
                        <div class="text-left">
                            <p class="text-[9px] font-black text-white uppercase italic leading-none"><?= $username ?></p>
                            <a href="<?= $isAdmin ? 'dashboard.php' : 'user-dashboard.php' ?>" class="text-[8px] text-amber-500 font-bold uppercase tracking-widest mt-1 hover:underline">Access Console</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="max-w-[1600px] mx-auto p-6 md:p-14 overflow-hidden">
        
        <!-- Elevate Hero -->
        <section class="mb-20 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-3 px-4 py-1.5 bg-amber-500/5 border border-amber-500/10 rounded-full">
                        <span class="text-[8px] font-black uppercase tracking-[0.4em] text-amber-600">Established MMXXVI / Global Boutique</span>
                    </div>
                    <h1 class="text-6xl md:text-7xl font-black text-white uppercase tracking-tighter italic leading-[0.9]">
                        Refined <br> <span class="text-amber-500">Exclusivity.</span>
                    </h1>
                    <p class="text-base text-slate-400 max-w-md leading-relaxed font-light">
                        Discover a curated sanctuary of rare assets designed for those who demand precision, luxury, and undisputed quality.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#catalog" class="px-8 py-4 bg-white text-black font-black uppercase text-[9px] tracking-[0.3em] rounded-full hover:bg-amber-500 hover:text-white transition-all shadow-xl">Explore Boutique</a>
                        <a href="faq.php" class="px-8 py-4 text-slate-500 border border-slate-800 rounded-full text-[9px] font-black uppercase tracking-[0.3em] hover:text-white hover:border-white transition-all">The Philosophy</a>
                    </div>
                </div>
                <div class="hidden lg:block relative">
                    <div class="absolute inset-0 bg-blue-600/5 rounded-[3rem] blur-[100px] -z-10"></div>
                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=800" class="w-full h-[550px] object-cover rounded-[3rem] border border-white/5 grayscale hover:grayscale-0 transition-all duration-1000">
                </div>
            </div>
        </section>

        <!-- Brand Pillar -->
        <section class="mb-32 grid grid-cols-1 md:grid-cols-3 gap-12 border-t border-slate-900 pt-20">
            <a href="authenticity.php" class="space-y-4 group">
                <iconify-icon icon="solar:shield-check-bold-duotone" class="text-4xl text-amber-500 transition-transform group-hover:scale-110"></iconify-icon>
                <h3 class="text-white font-black uppercase italic tracking-tighter text-lg group-hover:text-amber-500 transition">Guaranteed Authenticity</h3>
                <p class="text-xs leading-relaxed text-slate-500">Every asset in our catalog undergoes rigorous 5-step cryptographic verification protocols.</p>
            </a>
            <a href="logistics.php" class="space-y-4 group">
                <iconify-icon icon="solar:delivery-bold-duotone" class="text-4xl text-blue-500 transition-transform group-hover:scale-110"></iconify-icon>
                <h3 class="text-white font-black uppercase italic tracking-tighter text-lg group-hover:text-blue-500 transition">Elite Logistics</h3>
                <p class="text-xs leading-relaxed text-slate-500">Overnight global delivery facilitated by our premium air-freight and private courier network.</p>
            </a>
            <a href="rarity.php" class="space-y-4 group">
                <iconify-icon icon="solar:medal-star-bold-duotone" class="text-4xl text-purple-500 transition-transform group-hover:scale-110"></iconify-icon>
                <h3 class="text-white font-black uppercase italic tracking-tighter text-lg group-hover:text-purple-500 transition">Curated Rarity</h3>
                <p class="text-xs leading-relaxed text-slate-500">We source only the finest, limited-run selections that represent the pinnacle of craftsmanship.</p>
            </a>
        </section>

        <!-- Product Showcase -->
        <section id="catalog">
            <header class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6">
                <div>
                    <h2 class="text-4xl font-black text-white uppercase italic tracking-tighter gold-underline">The Collection</h2>
                    <p class="text-slate-500 mt-4 max-w-md text-[9px] font-bold uppercase tracking-[0.3em] opacity-50 italic">Symphony of Luxury assets curated for the elite.</p>
                </div>
                <div class="flex gap-4">
                    <button class="w-12 h-12 rounded-full border border-slate-800 flex items-center justify-center text-slate-500 hover:border-amber-500 hover:text-white transition cursor-not-allowed"><iconify-icon icon="solar:alt-arrow-left-linear"></iconify-icon></button>
                    <button class="w-12 h-12 rounded-full border border-slate-800 flex items-center justify-center text-slate-500 hover:border-amber-500 hover:text-white transition cursor-not-allowed"><iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon></button>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
                <?php foreach ($products as $prod): 
                    $img = $prod['image'] ?: 'default.png';
                    $imgPath = (strpos($img, 'http') === 0 || strpos($img, 'https') === 0) ? $img : "assets/uploads/" . $img;
                ?>
                    <div class="luxe-card">
                        <div class="image-box">
                            <img src="<?= $imgPath ?>" onerror="this.src='https://placehold.co/800x800/020617/1e293b?text=ELITE+ASSET'">
                            <div class="floating-price">
                                <span class="text-xl font-black text-white italic tracking-tighter">₹<?= number_format((float)$prod['price']) ?></span>
                            </div>
                        </div>
                        
                        <div class="p-10 bg-gradient-to-b from-[#0f172a] to-[#020617]">
                            <div class="mb-6">
                                <p class="text-[9px] font-black text-amber-500 uppercase tracking-[0.4em] mb-2 leading-none italic"><?= htmlspecialchars($prod['category'] ?? 'Elite Asset') ?></p>
                                <h4 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-[1.1]"><?= htmlspecialchars($prod['name']) ?></h4>
                                <p class="text-[10px] text-slate-600 mt-4 leading-relaxed line-clamp-2"><?= htmlspecialchars($prod['description'] ?? 'Exclusive premium specifications restricted to authorized members.') ?></p>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <?php if($prod['stock'] > 0): ?>
                                    <form method="POST" class="w-full">
                                        <input type="hidden" name="add_id" value="<?= $prod['id'] ?>">
                                        <button type="submit" class="w-full btn-protocol py-4 rounded-2xl flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-white overflow-hidden group">
                                            <span>Acquire Asset</span>
                                            <iconify-icon icon="solar:cart-plus-bold" class="text-lg group-hover:translate-x-1 group-hover:text-amber-500 transition-all"></iconify-icon>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="w-full py-4 bg-slate-900/50 border border-slate-800 rounded-2xl text-center text-[9px] font-black uppercase tracking-[0.3em] text-red-500 italic">
                                        Temporarily Archived
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-32 text-center">
                <a href="#" class="inline-block text-[10px] font-black text-slate-500 hover:text-amber-500 uppercase tracking-[0.5em] italic transition-all border-b border-transparent hover:border-amber-500 pb-2">View Global Archive &rarr;</a>
            </div>
        </section>
    </main>

    <footer class="mt-40 bg-zinc-950/50 border-t border-slate-900 py-32 px-12 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-amber-500/20 to-transparent"></div>
        
        <div class="max-w-[1700px] mx-auto grid grid-cols-1 md:grid-cols-4 gap-20">
            <div class="col-span-2 space-y-8">
                <h3 class="text-3xl font-black text-white italic tracking-tighter uppercase">Modest Mission<span class="text-amber-500">.</span></h3>
                <p class="text-slate-500 max-w-sm text-sm leading-relaxed">The pinnacle of luxury e-commerce. We redefine digital acquisition through curation, security, and world-class logistics.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full border border-slate-800 flex items-center justify-center text-slate-500 hover:text-white transition"><iconify-icon icon="mdi:instagram" class="text-xl"></iconify-icon></a>
                    <a href="#" class="w-10 h-10 rounded-full border border-slate-800 flex items-center justify-center text-slate-500 hover:text-white transition"><iconify-icon icon="mdi:twitter" class="text-xl"></iconify-icon></a>
                </div>
            </div>
            <div class="space-y-6">
                <h4 class="text-white font-black uppercase text-[10px] tracking-widest italic">The Protocols</h4>
                <ul class="space-y-4 text-xs font-bold text-slate-500">
                    <li><a href="terms.php" class="hover:text-amber-500 transition">Terms of Engagement</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition">Privacy Governance</a></li>
                    <li><a href="faq.php" class="hover:text-amber-500 transition">Support Terminal</a></li>
                </ul>
            </div>
            <div class="space-y-6">
                <h4 class="text-white font-black uppercase text-[10px] tracking-widest italic">Global Nodes</h4>
                <ul class="space-y-4 text-xs font-bold text-slate-500">
                    <li>London, UK</li>
                    <li>New York, US</li>
                    <li>Mumbai, IN</li>
                </ul>
            </div>
        </div>
        
        <div class="mt-32 text-center">
            <span class="text-[9px] font-black text-slate-800 uppercase tracking-[0.8em] italic">Architecture &copy; 2026 MODEST MISSION INT.</span>
        </div>
    </footer>

</body>
</html>