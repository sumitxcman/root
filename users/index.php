<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Connection
require_once '../include/db.php';
require_once '../include/auth.php';

// Auth Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

// 3. User Add Karne ka Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $dept = $_POST['department'];
    $desig = $_POST['designation'];
    $status = $_POST['status'];

    try {
        $username = explode('@', $email)[0] . rand(100, 999);
        $default_password = password_hash('password123', PASSWORD_DEFAULT);
        $role = 'user';
        
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, department, designation, status, username, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $dept, $desig, $status, $username, $default_password, $role]);
        header("Location: index.php?success=1");
        exit();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// 4. Fetch Users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: #94a3b8; margin: 0; }
        
        /* Sidebar Fix */
        .sidebar { 
            width: 260px; height: 100vh; background-color: #111827; 
            position: fixed; left: 0; top: 0; border-right: 1px solid #1e293b; z-index: 100;
        }

        /* Main Content Shift */
        .main-content { 
            margin-left: 260px; width: calc(100% - 260px); min-height: 100vh;
        }

        .sidebar-link.active { 
            background: #0ea5e9; color: white !important; 
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.2); 
        }

        .input-dark { background-color: #1e293b; border: 1px solid #334155; color: white; outline: none; }
        .input-dark:focus { border-color: #3b82f6; }
    </style>
</head>
<body class="flex overflow-x-hidden">

  
    <aside class="sidebar p-6 flex flex-col">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                <iconify-icon icon="solar:shop-bold-duotone" class="text-2xl text-white"></iconify-icon>
            </div>
            <h1 class="text-white text-xl font-black tracking-tighter uppercase">MY SHOP</h1>
        </div>

       <nav class="space-y-6">
                <a href="dashboard.php" class="sidebar-link active flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20">
                    <iconify-icon icon="solar:widget-5-bold-duotone" class="text-xl"></iconify-icon>
                    Dashboard Overview
                </a>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Store Management</p>
                    <a href="products/index.php" class="flex items-center justify-between px-4 py-2 bg-[#1e293b] text-white rounded-xl text-sm border border-slate-700/30">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="solar:box-bold-duotone" class="text-lg text-blue-400"></iconify-icon> Catalog
                        </div>
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[10px]"></iconify-icon>
                    </a>
                    <a href="cart.php" class="flex items-center gap-3 px-4 py-2 hover:text-white transition-colors text-sm">
                        <iconify-icon icon="solar:cart-large-4-linear" class="text-lg"></iconify-icon> Manage Orders
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Application</p>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:text-white transition-colors text-sm text-slate-400">
                        <iconify-icon icon="solar:letter-linear" class="text-lg"></iconify-icon> Email
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 hover:text-white transition-colors text-sm text-slate-400">
                        <iconify-icon icon="solar:chat-round-dots-linear" class="text-lg"></iconify-icon> Chat
                    </a>
                </div>

                <div class="space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">UI Elements</p>
                    <div class="px-2">
                        <button onclick="toggleUsersMenu()" class="w-full bg-[#4f46e5] text-white flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-bold cursor-pointer transition-all hover:bg-[#4338ca]">
                            <div class="flex items-center gap-3">
                                <iconify-icon icon="solar:users-group-rounded-bold" class="text-xl"></iconify-icon> Users
                            </div>
                            <iconify-icon id="userArrow" icon="solar:alt-arrow-down-linear" class="text-xs transition-transform duration-300"></iconify-icon>
                        </button>

                        <div id="usersSubMenu" class="hidden mt-2 ml-4 space-y-3 border-l border-slate-800 pl-4">
                            <a href="users/index.php" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Users List
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Users Grid
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Add User
                            </a>
                            <a href="#" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> View Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-800/50 space-y-2">
                    <p class="text-[10px] uppercase font-bold text-slate-500 px-4 tracking-widest">Reports & Settings</p>
                    <a href="settings.php" class="flex items-center justify-between px-4 py-2 hover:text-white transition-colors text-sm">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="solar:settings-linear" class="text-lg"></iconify-icon> Site Settings
                        </div>
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="text-[10px] text-slate-600"></iconify-icon>
                    </a>
                    <a href="logout.php" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/5 rounded-xl text-sm font-bold transition-all">
                        <iconify-icon icon="solar:logout-3-bold-duotone" class="text-lg"></iconify-icon> Logout
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <main class="main-content p-8">
        
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase">Users Management</h1>
                <p class="text-sm text-slate-500 mt-1">Total Registered Users: <span class="text-blue-400 font-bold"><?= count($users) ?></span></p>
            </div>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-600/20 transition-all">
                <iconify-icon icon="solar:add-circle-bold" class="text-lg"></iconify-icon>
                Add New User
            </button>
        </div>

        <div class="bg-[#111827] p-4 rounded-t-[2rem] border-x border-t border-slate-800 flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></iconify-icon>
                    <input type="text" placeholder="Search users..." class="input-dark rounded-xl pl-10 pr-4 py-2 text-sm w-64 border-slate-800">
                </div>
                <select class="input-dark rounded-xl px-4 py-2 text-sm border-slate-800">
                    <option>All Departments</option>
                </select>
            </div>
        </div>

        <div class="bg-[#111827] rounded-b-[2rem] border border-slate-800 shadow-2xl overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#1e293b]/30 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 border-b border-slate-800">
                        <th class="p-6">User</th>
                        <th class="p-6">Join Date</th>
                        <th class="p-6">Department</th>
                        <th class="p-6">Designation</th>
                        <th class="p-6 text-center">Status</th>
                        <th class="p-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50">
                    <?php foreach($users as $user): 
                        $status = strtolower($user['status'] ?? 'active');
                        $badge = ($status == 'active') ? 'text-emerald-500 border-emerald-500/20 bg-emerald-500/10' : 'text-slate-400 border-slate-500/20 bg-slate-500/10';
                        
                        $words = explode(" ", $user['fullname']);
                        $initials = (count($words) > 1) ? $words[0][0] . $words[1][0] : $words[0][0];
                        $initials = strtoupper(substr($initials, 0, 2));
                    ?>
                    <tr class="hover:bg-white/[0.02] transition-all group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-blue-600/10 flex items-center justify-center text-xs font-black text-blue-500 border border-blue-500/20 uppercase shadow-inner">
                                    <?= $initials ?>
                                </div>
                                <div>
                                    <p class="font-bold text-white text-sm"><?= htmlspecialchars($user['fullname']) ?></p>
                                    <p class="text-[10px] text-slate-500 italic"><?= htmlspecialchars($user['email']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-xs text-slate-400">
                            <iconify-icon icon="solar:calendar-bold" class="mr-1 inline-block"></iconify-icon>
                            <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?>
                        </td>
                        <td class="p-6">
                            <span class="text-slate-300 text-sm font-medium"><?= htmlspecialchars($user['department'] ?? 'N/A') ?></span>
                        </td>
                        <td class="p-6 text-slate-400 text-sm">
                            <?= htmlspecialchars($user['designation'] ?? 'N/A') ?>
                        </td>
                        <td class="p-6 text-center">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black border uppercase tracking-widest <?= $badge ?>">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="w-9 h-9 rounded-xl bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                    <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                </button>
                                <button class="w-9 h-9 rounded-xl bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all">
                                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-[200] p-4">
        <div class="bg-[#111827] w-full max-w-md rounded-[2.5rem] border border-slate-800 shadow-2xl overflow-hidden">
            <div class="p-8 border-b border-slate-800/50 flex justify-between items-center bg-[#1e293b]/20">
                <h2 class="text-xl font-black text-white uppercase tracking-tighter">Add User</h2>
                <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-slate-500 hover:text-white transition-colors">
                    <iconify-icon icon="solar:close-circle-bold" class="text-3xl"></iconify-icon>
                </button>
            </div>
            
            <form method="POST" class="p-8 space-y-4">
                <input type="hidden" name="add_user" value="1">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-500 uppercase px-1">Full Name</label>
                    <input type="text" name="fullname" required class="w-full input-dark rounded-2xl px-5 py-4 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-500 uppercase px-1">Email</label>
                    <input type="email" name="email" required class="w-full input-dark rounded-2xl px-5 py-4 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="department" placeholder="Dept" class="input-dark rounded-2xl px-5 py-4 text-sm">
                    <input type="text" name="designation" placeholder="Title" class="input-dark rounded-2xl px-5 py-4 text-sm">
                </div>
                <select name="status" class="w-full input-dark rounded-2xl px-5 py-4 text-sm">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-[1.5rem] shadow-xl shadow-blue-600/20 transition-all uppercase tracking-widest text-xs mt-4">
                    Register User
                </button>
            </form>
        </div>
    </div>

            

</body>
</html>