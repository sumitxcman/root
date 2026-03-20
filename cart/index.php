<?php 
    session_start();
    $title = 'Shopping Cart';
    include '../partials/header.php'; 
    // Yahan humne database include kiya hai agar items fetch karne hon
    // include '../include/db.php'; 
?>

<div class="flex">
    <?php include '../partials/sidebar.php'; ?>

    <main class="flex-1 ml-64 bg-[#0f172a] min-h-screen p-8">
        <div class="max-w-6xl mx-auto">
            <header class="mb-12">
                <h2 class="text-white text-3xl font-black uppercase tracking-[0.2em]">Your Selection</h2>
                <p class="text-slate-500 text-xs mt-2 uppercase tracking-widest">Luxury E-commerce Terminal v1.0</p>
            </header>
            
            <div class="grid grid-cols-12 gap-10">
                <div class="col-span-12 lg:col-span-8 space-y-6">
                    
                    <?php 
                    $subtotal = 0;
                    // Check karein agar cart mein items hain
                    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): 
                        foreach($_SESSION['cart'] as $id => $item): 
                            $item_price = isset($item['price']) ? $item['price'] : 0;
                            $qty = isset($item['quantity']) ? $item['quantity'] : 1;
                            $subtotal += ($item_price * $qty);
                    ?>
                        <div class="group bg-[#1e293b]/50 border border-slate-800 p-8 transition-all hover:border-slate-600">
                            <div class="flex gap-8">
                                <div class="w-32 h-40 bg-white flex items-center justify-center p-4 overflow-hidden">
                                    <img src="../assets/images/products/<?php echo $item['image']; ?>" 
                                         alt="Product" 
                                         class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                                </div>

                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-white font-bold text-base uppercase tracking-wider">
                                                <?php echo $item['name']; ?>
                                            </h3>
                                            <p class="text-white font-black text-lg">$<?php echo number_format($item_price, 2); ?></p>
                                        </div>
                                        <p class="text-[10px] text-slate-500 mt-1">REF NO: <?php echo $id; ?></p>
                                        <div class="mt-4 flex gap-6 text-[11px] text-slate-400 uppercase font-bold tracking-tighter">
                                            <span>Size: <span class="text-white">OS</span></span>
                                            <span>Color: <span class="text-white">Black</span></span>
                                            <span>Qty: <span class="text-white"><?php echo $qty; ?></span></span>
                                        </div>
                                    </div>

                                    <div class="flex gap-6 items-center pt-6 border-t border-slate-800/50 mt-4">
                                        <a href="process_cart.php?action=remove&id=<?php echo $id; ?>" 
                                           class="text-[10px] text-slate-500 hover:text-red-500 uppercase font-black tracking-widest transition-colors">
                                            Remove Item
                                        </a>
                                        <span class="text-slate-800">/</span>
                                        <button class="text-[10px] text-slate-500 hover:text-white uppercase font-black tracking-widest transition-colors">
                                            Move to Wishlist
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <div class="border border-dashed border-slate-800 p-20 text-center">
                            <p class="text-slate-500 uppercase tracking-[0.3em] text-xs">Your cart is currently empty</p>
                            <a href="index.php" class="inline-block mt-6 text-white text-[10px] font-black uppercase border-b border-white pb-1 hover:text-slate-400 hover:border-slate-400 transition-all">
                                Return to Boutique
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-span-12 lg:col-span-4">
                    <div class="bg-[#1e293b] border border-slate-800 p-8 sticky top-8">
                        <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-8">Execution Summary</h4>
                        
                        <div class="space-y-5">
                            <div class="flex justify-between text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                                <span>Subtotal</span>
                                <span class="text-white">$<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="flex justify-between text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                                <span>Shipping</span>
                                <span class="text-green-500 italic">Complimentary</span>
                            </div>
                            <div class="flex justify-between text-[11px] text-slate-400 font-bold uppercase tracking-widest">
                                <span>Tax Estimate</span>
                                <span class="text-white">$<?php echo number_format($subtotal * 0.08, 2); ?></span>
                            </div>
                        </div>

                        <div class="border-t border-slate-700 mt-8 pt-6 flex justify-between text-white font-black text-xl uppercase">
                            <span class="text-xs self-center">Total</span>
                            <span>$<?php echo number_format($subtotal * 1.08, 2); ?></span>
                        </div>