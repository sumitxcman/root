<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODEST MISSION - Management</title>
    
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <style>
        html { font-size: 12px; /* Global scale down */ }
        /* Body background ko dark kiya gaya hai taake white box na dikhe */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #0f172a; 
            color: white;
        }
        
        .sidebar {
            @apply w-72 bg-[#111827] min-h-screen fixed left-0 top-0 transition-all duration-300 z-50 border-r border-gray-800;
        }
        
        .sidebar-menu a {
            @apply flex items-center gap-3 px-6 py-4 text-gray-400 hover:text-white hover:bg-white/5 transition-all;
        }

        .menu-icon { @apply text-2xl; }

        /* Navbar ko dark kar diya gaya hai white strip hatane ke liye */
        .navbar-main {
            @apply ml-72 h-20 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8 sticky top-0 z-40;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="p-6 border-b border-gray-800">
        <a href="index.php" class="flex items-center gap-2">
            <h4 class="text-white font-bold mb-0 uppercase tracking-wider">MODEST MISSION</h4>
        </a>
    </div>
    <ul class="sidebar-menu mt-4">
        <li>
            <a href="users/index.php">
                <iconify-icon icon="gridicons:multiple-users" class="menu-icon"></iconify-icon>
                <span>Manage Users</span>
            </a>
        </li>
        <li>
            <a href="products.php">
                <iconify-icon icon="fluent:box-20-filled" class="menu-icon"></iconify-icon>
                <span>Manage Products</span>
            </a>
        </li>
        <li>
            <a href="logout.php" class="mt-10 text-red-400 hover:bg-red-500/10">
                <iconify-icon icon="solar:logout-outline" class="menu-icon"></iconify-icon>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>

<header class="navbar-main">
    <div class="flex items-center gap-3">
        <button class="text-white">
            <iconify-icon icon="heroicons:bars-3-center-left" class="text-2xl"></iconify-icon>
        </button>
        </div>

    <div class="flex items-center gap-3 text-white">
        <?php if(isset($_SESSION['username'])): ?>
            <span class="text-sm font-medium">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <div class="w-10 h-10 rounded-full border border-gray-700 overflow-hidden">
                <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['username'] ?>&background=random" alt="User">
            </div>
        <?php endif; ?>
    </div>
</header>

<main class="ml-72 p-8">
    </main>

</body>
</html>