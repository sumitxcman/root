<?php

// 2. Session & Auth
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Includes
require_once '../include/db.php';
require_once '../include/auth.php';

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

// 4. Products Fetch Logic
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}

// 5. Add to Cart Logic (POST)
if (isset($_POST['add_id'])) {
    $add_id = $_POST['add_id'];
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    
    if (isset($_SESSION['cart'][$add_id])) {
        $_SESSION['cart'][$add_id]++;
    } else {
        $_SESSION['cart'][$add_id] = 1;
    }
    header("Location: checkout.php"); // Seedhe checkout par bhej rahe hain for testing
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog - MODEST MISSION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; margin: 0; }
        .main-content { width: 100%; max-width: 1400px; margin: 0 auto; min-height: 100vh; padding: 4rem 2rem; }
    </style>
</head>
<body class="antialiased">

    <main class="main-content">
        
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter italic leading-none">Global Showcase</h1>
                <p class="text-slate-500 text-[10px] uppercase tracking-[0.3em] mt-2">Home / Premium Collection</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 border border-blue-500/20">
                    <iconify-icon icon="solar:magnifer-bold-duotone" class="text-2xl"></iconify-icon>
                </div>
                <div class="px-6 py-3 bg-white/5 border border-white/10 rounded-2xl">
                    <span class="text-xs font-black text-white uppercase tracking-widest">Filter Items</span>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            
            <?php if($products): foreach($products as $product): 
                $img = $product['image'] ?: 'default.png';
                if (strpos($img, 'http') === 0) { $imgPath = $img; } 
                else { $imgPath = "../assets/uploads/" . $img; }
            ?>
            <div class="bg-[#0f172a] rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl transition-all hover:-translate-y-2 group">
                
                <div class="aspect-[1/1] bg-slate-800 overflow-hidden relative">
                    <img src="<?= $imgPath ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute top-6 right-6 bg-blue-600 text-white px-5 py-2 rounded-2xl text-[10px] font-black shadow-xl shadow-blue-600/30">
                        ₹<?= number_format($product['price'] ?? 0, 2) ?>
                    </div>
                </div>

                <div class="p-8 space-y-4">
                    <div class="space-y-1">
                        <span class="text-[9px] font-black uppercase tracking-widest text-blue-500"><?= htmlspecialchars($product['category'] ?? 'General Asset') ?></span>
                        <h2 class="text-lg font-bold text-white leading-tight truncate"><?= htmlspecialchars($product['name'] ?? 'Untitled Asset') ?></h2>
                    </div>
                    
                    <p class="text-[11px] text-slate-500 leading-relaxed line-clamp-2 italic">
                        <?= htmlspecialchars($product['description'] ?: 'High-performance luxury item.') ?>
                    </p>

                    <div class="pt-6 flex items-center justify-between gap-4 border-t border-white/5">
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-600">Stock: Optimal</span>
                        
                        <form method="POST">
                            <input type="hidden" name="add_id" value="<?= $product['id'] ?>">
                            <button type="submit" class="bg-blue-600 hover:bg-white hover:text-blue-600 text-white p-3.5 rounded-2xl transition-all shadow-xl shadow-blue-900/10 flex items-center justify-center group-hover:scale-110">
                                <iconify-icon icon="solar:cart-plus-bold" class="text-xl"></iconify-icon>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <div class="col-span-full py-20 text-center bg-[#0f172a] border border-dashed border-slate-800 rounded-[3rem]">
                    <iconify-icon icon="solar:box-minimalistic-linear" class="text-6xl text-slate-700 mb-4"></iconify-icon>
                    <p class="text-slate-500 uppercase tracking-widest text-xs font-black">No products found</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

</body>
</html>