<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/root/css/style.css">

<header style="background: #1a1a1a; color: white; padding: 12px 40px; display: flex; align-items: center; justify-content: space-between; font-family: 'Segoe UI', sans-serif; box-shadow: 0 2px 10px rgba(0,0,0,0.3);">
    <div class="logo-area">
        <a href="index.php" style="color: white; text-decoration: none; font-size: 20px; font-weight: 800; letter-spacing: 1px;">
            MY SHOP <span style="font-size: 22px;"></span>
        </a>
    </div>

    <nav style="display: flex; gap: 20px; align-items: center;">
        <?php if(isset($_SESSION['user_name'])): ?>
            <span style="color: #bbb; font-size: 14px;">Hi, <b style="color: #fff;"><?= htmlspecialchars($_SESSION['user_name']) ?></b></span>
        <?php endif; ?>
        <a href="dashboard.php" style="color: white; text-decoration: none; font-size: 14px; font-weight: 500;">Dashboard</a>
        <a href="logout.php" style="color: #ff6b81; text-decoration: none; font-size: 13px; font-weight: bold; border: 1px solid #ff6b81; padding: 5px 15px; border-radius: 5px; transition: 0.3s;">Logout</a>
    </nav>
</header>