<?php
require '../include/load.php'; 
include '../partials/header.php';

$user_id = $_SESSION['user_id'] ?? null;

// Check user login
if (!$user_id) {
    echo "<div class='container mt-5 text-center'><h3>Pehle login karein!</h3><a href='../sign-in.php' class='btn btn-primary'>Login Page</a></div>";
    include '../partials/footer.php';
    exit;
}

// Fetch cart items
$stmt = $pdo->prepare("SELECT cart.*, products.name, products.price, products.image 
                       FROM cart 
                       JOIN products ON cart.product_id = products.id 
                       WHERE cart.user_id = ?");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll();

$grand_total = 0;
?>

<div class="container mt-5" style="min-height: 80vh;">
    <div class="d-flex justify-content-between align-items-center">
        <h2 style="font-weight: 700;">Shopping Cart </h2>
        <a href="../index.php" class="btn btn-outline-secondary btn-sm">Continue Shopping</a>
    </div>
    <hr>

    <?php if (empty($items)): ?>
        <div class="alert alert-info text-center shadow-sm">
            Your cart is empty. <a href="../index.php" class="alert-link">Go Back to Shop</a>
        </div>
    <?php else: ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover border mb-0" style="background: white;">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Product</th>
                        <th>Price</th>
                        <th class="text-center">Quantity</th>
                        <th>Total</th>
                        <th class="text-center pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td class="align-middle ps-4">
                            <div class="d-flex align-items-center">
                                <img src="../assets/uploads/<?= e($item['image']) ?>" width="50" height="50" class="rounded me-3" style="object-fit: cover;" onerror="this.src='https://via.placeholder.com/50'">
                                <b><?= e($item['name']) ?></b>
                            </div>
                        </td>
                        <td class="align-middle">$<?= number_format($item['price'], 2) ?></td>
                        <td class="align-middle text-center"><?= e($item['quantity']) ?></td>
                        <td class="align-middle" style="font-weight: 600;">$<?= number_format($subtotal, 2) ?></td>
                        <td class="align-middle text-center pe-4">
                            <a href="delete.php?id=<?= $item['id'] ?>" 
                               class="btn btn-sm btn-outline-danger border-0" 
                               onclick="return confirm('Kya aap ise cart se nikalna chahte hain?')">
                               <b>Remove</b>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end py-3">Grand Total:</th>
                        <th colspan="2" class="text-success h4 py-3 ps-3">$<?= number_format($grand_total, 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-end mt-4">
            <a href="checkout.php" class="btn btn-success btn-lg px-5 shadow">Proceed to Checkout →</a>
        </div>
    <?php endif; ?>
</div>

<?php include '../partials/footer.php'; ?>