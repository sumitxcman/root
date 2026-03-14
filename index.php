<?php
require 'include/load.php';


$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();


$cart_count = 0;
if(isset($_SESSION['user_id'])) {
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
    $stmt_count->execute([$_SESSION['user_id']]);
    $cart_count = $stmt_count->fetchColumn() ?: 0;
}

include 'partials/head.php';
?>

<style>
   
    .products-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 40px 20px;
        background: #f8f9fa;
        align-items: flex-start; 
    }
    .product-card {
        background: white;
        width: 220px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .img-container {
        width: 100%;
        height: 180px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }
    .img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .card-body {
        padding: 15px;
        text-align: left;
    }
</style>

<nav style="background: #1a1a1a; color: white; padding: 0 40px; height: 60px; display: flex; justify-content: space-between; align-items: center; font-family: 'Inter', sans-serif; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
    
    <div style="display: flex; align-items: center;">
        <a href="index.php" style="color: white; text-decoration: none; font-size: 20px; font-weight: 800; letter-spacing: 1px;">
            MY SHOP <span style="font-size: 22px;"></span>
            <link rel="stylesheet" href="/root/css/style.css">
        </a>
    </div>

    <div style="display: flex; gap: 25px; align-items: center;">
        
        <a href="cart/index.php" style="color: white; text-decoration: none; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); padding: 6px 15px; border-radius: 20px; transition: 0.3s;">
            <span>Cart</span>
            <span style="background: #ff4757; color: white; min-width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold;">
                <?= $cart_count ?>
            </span>
        </a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" style="color: #eccc68; text-decoration: none; font-size: 14px; font-weight: 500;">Dashboard</a>
            <a href="logout.php" style="color: #ff6b81; text-decoration: none; font-size: 14px; font-weight: 500; border: 1px solid #ff6b81; padding: 5px 15px; border-radius: 5px; transition: 0.3s;">Logout</a>
        <?php else: ?>
            <a href="sign-in.php" style="color: white; text-decoration: none; font-size: 14px; font-weight: 500;">Login</a>
        <?php endif; ?>

    </div>
</nav>

<div class="products-container">
    <?php foreach ($products as $p): ?>
    <div class="product-card">
        <div class="img-container">
            <img src="assets/uploads/<?= e($p['image']) ?>" onerror="this.src='https://via.placeholder.com/220x180?text=No+Image'">
        </div>
        <div class="card-body">
            <h3 style="margin: 0 0 10px; font-size: 16px; color: #333; height: 40px; overflow: hidden;"><?= e($p['name']) ?></h3>
            <p style="color: #2ed573; font-weight: bold; font-size: 18px; margin-bottom: 15px;">$<?= number_format($p['price'], 2) ?></p>
            <button onclick="addToCart(<?= $p['id'] ?>)" style="background: #007bff; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold;">
                Add to Cart
            </button>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
function addToCart(productId) {
    fetch('api/cart/add.php?product_id=' + productId)
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success') {
            alert('Added to cart! ');
            location.reload(); 
        } else {
            alert(data.message);
        }
    });
}
</script>
</body>