<?php
require '../include/load.php'; 
include '../partials/header.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) { header("Location: ../sign-in.php"); exit; }


$stmt = $pdo->prepare("SELECT SUM(p.price * c.quantity) FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$total = $stmt->fetchColumn() ?? 0;

if ($total <= 0) { header("Location: index.php"); exit; }
?>

<div class="container mt-5" style="min-height: 80vh;">
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4 shadow-sm border-0">
                <h4 class="mb-4">Shipping & Payment</h4>
                <form action="payment_success.php" method="POST">
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" required placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label>Shipping Address</label>
                        <textarea class="form-control" rows="3" required placeholder="Address..."></textarea>
                    </div>
                    <hr>
                    <div class="alert alert-secondary">Payment Method: <b>Stripe (Card)</b></div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Pay $<?= number_format($total, 2) ?> Now</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 bg-light border-0">
                <h5>Order Summary</h5>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Total Amount:</span>
                    <span class="h4 text-primary">$<?= number_format($total, 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?> 