<?php
require '../include/load.php';
checkLogin();

// Cart empty check
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php?msg=Your cart is empty");
    exit;
}

$total = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$pid]);
    $price = $stmt->fetchColumn();
    $total += $price * $qty;
}

include '../partials/header.php';
?>

<div style="max-width: 650px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); font-family: sans-serif;">
    <h2 style="text-align: center; color: #333;">Select Payment Method</h2>
    <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 20px 0; text-align: center;">
        <span style="color: #666;">Total Amount to Pay:</span>
        <h2 style="color: #4834d4; margin: 5px 0;">$<?php echo number_format($total, 2); ?></h2>
    </div>

    <form action="process_order.php" method="POST" id="payment-form">
        <div style="margin-bottom: 15px; border: 2px solid #eee; padding: 15px; border-radius: 12px;">
            <input type="radio" name="pay_method" value="Stripe" id="stripe_opt" checked>
            <label for="stripe_opt" style="font-weight: 600; margin-left: 10px; cursor: pointer;">Credit / Debit Card (Stripe)</label>
            <div id="stripe_area" style="margin-top: 15px; background: #fdfdfd; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                <div id="card-element"></div>
                <div id="card-errors" style="color: red; font-size: 12px; mt: 10px;"></div>
            </div>
        </div>

        <div style="margin-bottom: 15px; border: 2px solid #eee; padding: 15px; border-radius: 12px;">
            <input type="radio" name="pay_method" value="Scanner" id="scanner_opt">
            <label for="scanner_opt" style="font-weight: 600; margin-left: 10px; cursor: pointer;">Scan & Pay (UPI/Online)</label>
            <div id="qr_area" style="display: none; text-align: center; margin-top: 15px;">
                <p style="font-size: 13px; color: #555;">Scan QR to pay <b>$<?php echo $total; ?></b></p>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=shop@bank&am=<?php echo $total; ?>" style="border: 2px solid #4834d4; padding: 5px; border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 25px; border: 2px solid #eee; padding: 15px; border-radius: 12px;">
            <input type="radio" name="pay_method" value="COD" id="cod_opt">
            <label for="cod_opt" style="font-weight: 600; margin-left: 10px; cursor: pointer;">Cash on Delivery (COD)</label>
            <p style="font-size: 12px; color: #888; margin: 5px 0 0 25px;">Pay when you receive your order.</p>
        </div>

        <button type="submit" style="width: 100%; background: #4834d4; color: white; padding: 18px; border: none; border-radius: 10px; font-size: 16px; font-weight: bold; cursor: pointer;">
            Confirm Order & Pay
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe_opt = document.getElementById('stripe_opt');
    const scanner_opt = document.getElementById('scanner_opt');
    const cod_opt = document.getElementById('cod_opt');
    const stripe_area = document.getElementById('stripe_area');
    const qr_area = document.getElementById('qr_area');

    // Toggle view logic
    function toggleOptions() {
        stripe_area.style.display = stripe_opt.checked ? 'block' : 'none';
        qr_area.style.display = scanner_opt.checked ? 'block' : 'none';
    }

    [stripe_opt, scanner_opt, cod_opt].forEach(opt => opt.addEventListener('change', toggleOptions));

    // Stripe Initialization
    const stripe = Stripe('your_publishable_key');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');
</script>

<?php include '../partials/footer.php'; ?>