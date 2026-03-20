<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY SHOP - Admin Dashboard</title>
    
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    
    <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
    
    <link rel="stylesheet" href="css/custom.css">

    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; @apply bg-gray-50; }
        
        /* Wowdash Sidebar Style */
        .sidebar {
            @apply w-72 bg-[#111827] min-h-screen fixed left-0 top-0 transition-all duration-300 z-50;
        }
        
        .sidebar-menu a {
            @apply flex items-center gap-3 px-6 py-4 text-gray-400 hover:text-white hover:bg-white/5 transition-all;
        }

        .sidebar-menu a.active {
            @apply text-white bg-blue-600 shadow-lg shadow-blue-900/20 rounded-r-full mr-4;
        }

        .menu-icon { @apply text-2xl; }

        /* Navbar Style */
        .navbar-main {
            @apply ml-72 h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-40;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="index.php" class="sidebar-logo">
            <h4 class="text-white mb-0">MY SHOP</h4>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="index.php" class="active">
                <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                <span>Dashboard</span>
            </a>
        </li>
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
            <a href="logout.php">
                <iconify-icon icon="solar:logout-outline" class="menu-icon"></iconify-icon>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>

<header class="navbar-main">
    <div class="d-flex align-items-center gap-3">
        <button class="sidebar-toggle">
            <iconify-icon icon="heroicons:bars-3-center-left" class="text-2xl"></iconify-icon>
        </button>
        
        <form class="navbar-search d-none d-md-block">
            <input type="text" placeholder="Search..." class="form-control border-0 bg-light">
        </form>
    </div>

    <div class="navbar-user-info d-flex align-items-center gap-3">
        <?php if(isset($_SESSION['username'])): ?>
            <span class="user-name fw-semibold">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <div class="user-avatar">
                <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['username'] ?>&background=random" alt="User">
            </div>
        <?php endif; ?>
    </div>
</header>



<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: {
            50: '#eff6ff',
            100: '#dbeafe',
            600: '#2563eb', // Wowdash blue
            700: '#1d4ed8',
          },
          dark: {
            900: '#111827', // Sidebar dark color
            800: '#1f2937',
          }
        },
        borderRadius: {
            'luxury': '2rem', // Wowdash style smooth corners
        }
      }
    }
  }
</script>