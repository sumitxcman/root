<?php
require 'include/load.php';
checkLogin();

/* =========================
   SAFE COUNT FUNCTION
========================= */
function getCount($pdo, $sql) {
    try {
        return $pdo->query($sql)->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

/* =========================
   COUNTS
========================= */

$total_users      = getCount($pdo, "SELECT COUNT(*) FROM users");
$pending_users    = getCount($pdo, "SELECT COUNT(*) FROM users WHERE status='pending'");

$total_products   = getCount($pdo, "SELECT COUNT(*) FROM products");
$pending_products = getCount($pdo, "SELECT COUNT(*) FROM products WHERE status='pending'");

include 'partials/header.php';
?>

<div style="display:flex;min-height:100vh;background:#f4f7f6;">

    <?php include 'partials/sidebar.php'; ?>

    <div style="flex:1;padding:40px;">

        <!-- HEADER -->
        <div style="background:white;padding:25px;border-radius:12px;
        box-shadow:0 2px 10px rgba(0,0,0,0.05);margin-bottom:30px;">
            <h2 style="margin:0;color:#2d3436;">Admin Dashboard</h2>
            <p style="margin:5px 0 0;color:#636e72;">
                Welcome back,
                <b><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></b>
            </p>
        </div>

        <!-- DASHBOARD CARDS -->
        <div style="display:grid;
        grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
        gap:25px;">

            <!-- TOTAL USERS -->
            <div style="padding:30px;background:linear-gradient(135deg,#6c5ce7,#a29bfe);
            color:white;border-radius:15px;">
                <h5>Total Users</h5>
                <h1><?= $total_users ?></h1>
                <a href="users/index.php" style="color:white;">Manage Users →</a>
            </div>

            <!-- PENDING USERS -->
            <div style="padding:30px;background:linear-gradient(135deg,#fdcb6e,#e17055);
            color:white;border-radius:15px;">
                <h5>Pending Users</h5>
                <h1><?= $pending_users ?></h1>
            </div>

            <!-- TOTAL PRODUCTS -->
            <div style="padding:30px;background:linear-gradient(135deg,#00b894,#55efc4);
            color:white;border-radius:15px;">
                <h5>Total Products</h5>
                <h1><?= $total_products ?></h1>
                <a href="products.php" style="color:white;">Manage Products →</a>
            </div>

            <!-- PENDING PRODUCTS -->
            <div style="padding:30px;background:linear-gradient(135deg,#0984e3,#74b9ff);
            color:white;border-radius:15px;">
                <h5>Pending Products</h5>
                <h1><?= $pending_products ?></h1>
            </div>

        </div>

    </div>
</div>

<?php include 'partials/footer.php'; ?>