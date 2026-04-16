<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../include/db.php';
require_once '../include/auth.php';

// Auth Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../sign-in.php");
    exit();
}

// Fetch Users
try {
    $stmt = $conn->query("SELECT * FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Management | MODEST SaaS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; margin: 0; }
        .main-content { width: 100%; max-width: 1400px; margin: 0 auto; min-height: 100vh; padding: 4rem 2rem; }
        .table-container { background: #0f172a; border-radius: 20px; border: 1px solid #1e293b; overflow: hidden; }
        .input-dark { background: #020617; border: 1px solid #1e293b; color: white; border-radius: 12px; padding: 10px 16px; outline: none; transition: 0.3s; }
    </style>
</head>
<body class="antialiased">

    <main class="main-content">
        <header class="mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Users Database</h1>
                <p class="text-slate-500 text-sm mt-1">Manage all registered users and their access levels.</p>
            </div>
            <a href="add.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-blue-500/20 transition-all">
                Create New Member
            </a>
        </header>

        <div class="table-container shadow-2xl">
            <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-[#1e293b]/20">
                <div class="relative">
                    <iconify-icon icon="solar:magnifer-linear" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></iconify-icon>
                    <input type="text" placeholder="Search by name or email..." class="input-dark pl-12 w-80 text-sm">
                </div>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-blue-500/10 text-blue-500 rounded-lg text-[10px] font-bold uppercase">All Roles</span>
                    <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-lg text-[10px] font-bold uppercase cursor-pointer">Administrators</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] bg-slate-900/50">
                            <th class="px-6 py-4">User Details</th>
                            <th class="px-6 py-4">Contact Information</th>
                            <th class="px-6 py-4">Account Status</th>
                            <th class="px-6 py-4">Join Date</th>
                            <th class="px-6 py-4 text-center">Identity</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        <?php foreach($users as $row): 
                            $status_class = (strtolower($row['status'] ?? 'active') == 'active') ? 'text-emerald-500 border-emerald-500/20 bg-emerald-500/10' : 'text-slate-400 border-slate-500/20 bg-slate-500/10';
                        ?>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['fullname']) ?>&background=random" class="w-10 h-10 rounded-xl">
                                    <div>
                                        <p class="text-white font-bold text-sm leading-none"><?= htmlspecialchars($row['fullname']) ?></p>
                                        <p class="text-[10px] text-slate-500 mt-1 italic">@<?= htmlspecialchars($row['username']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs text-white font-medium"><?= htmlspecialchars($row['email']) ?></p>
                                <p class="text-[10px] text-slate-500 mt-0.5"><?= htmlspecialchars($row['phone'] ?? 'Phone not verified') ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-lg text-[9px] font-black border uppercase tracking-widest <?= $status_class ?>">
                                    <?= htmlspecialchars($row['status'] ?? 'Pending') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-400 font-medium"><?= date('d F, Y', strtotime($row['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-1.5 bg-blue-600/10 border border-blue-600/20 text-blue-500 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    <?= strtoupper($row['role']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>