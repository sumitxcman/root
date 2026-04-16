<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../include/db.php';
    require_once '../include/auth.php';
    require_once '../include/helper.php';

    // Auth Check
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../sign-in.php");
        exit();
    }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $error = "";
    $success = "";

    // Fetch User Data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        header("Location: index.php");
        exit();
    }

    // Update User Logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $dept = trim($_POST['department']);
        $desig = trim($_POST['designation']);
        $status = trim($_POST['status']);
        $role = trim($_POST['role']);
        $new_password = trim($_POST['password']);

        if (empty($fullname) || empty($email)) {
            $error = "Name and Email are required.";
        } else {
            try {
                // Determine update query based on if password is provided
                if (!empty($new_password)) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET fullname = ?, email = ?, phone = ?, department = ?, designation = ?, status = ?, role = ?, password = ? WHERE id = ?";
                    $params = [$fullname, $email, $phone, $dept, $desig, $status, $role, $hashed_password, $id];
                } else {
                    $sql = "UPDATE users SET fullname = ?, email = ?, phone = ?, department = ?, designation = ?, status = ?, role = ? WHERE id = ?";
                    $params = [$fullname, $email, $phone, $dept, $desig, $status, $role, $id];
                }

                $update_stmt = $conn->prepare($sql);
                if ($update_stmt->execute($params)) {
                    $success = "User updated successfully!";
                    // Refresh data
                    $stmt->execute([$id]);
                    $user = $stmt->fetch();
                } else {
                    $error = "Failed to update member.";
                }
            } catch (PDOException $e) {
                $error = "Database Error: " . $e->getMessage();
            }
        }
    }

    $title = 'Edit Member - Modest Mission';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; }
        .main-content { width: 100%; max-width: 1000px; margin: 0 auto; min-height: 100vh; padding: 4rem 2rem; }
        .btn-lux { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; transition: 0.3s; border: none; cursor: pointer; }
        .btn-lux:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); }
    </style>
</head>
<body class="antialiased">

    <main class="main-content">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Edit Member</h2>
                    <p class="text-slate-500 mt-1">Update details for <span class="text-blue-500 font-bold"><?= htmlspecialchars($user['fullname']) ?></span></p>
                </div>
            </div>

            <?php if($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl mb-6 text-sm font-bold flex items-center gap-3">
                    <iconify-icon icon="solar:danger-bold" class="text-xl"></iconify-icon>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if($success): ?>
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-4 rounded-xl mb-6 text-sm font-bold flex items-center gap-3">
                    <iconify-icon icon="solar:check-circle-bold" class="text-xl"></iconify-icon>
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <form action="edit.php?id=<?= $id ?>" method="POST" class="lux-card p-10 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Full Name</label>
                        <input type="text" name="fullname" class="lux-input" value="<?= htmlspecialchars($user['fullname']) ?>" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Email Address</label>
                        <input type="email" name="email" class="lux-input" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Phone Number</label>
                        <input type="text" name="phone" class="lux-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Department</label>
                        <select name="department" class="lux-input">
                            <option value="Management" <?= $user['department'] == 'Management' ? 'selected' : '' ?>>Management</option>
                            <option value="Sales" <?= $user['department'] == 'Sales' ? 'selected' : '' ?>>Sales</option>
                            <option value="IT Department" <?= $user['department'] == 'IT Department' ? 'selected' : '' ?>>IT Department</option>
                            <option value="Marketing" <?= $user['department'] == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Designation</label>
                        <input type="text" name="designation" class="lux-input" value="<?= htmlspecialchars($user['designation'] ?? '') ?>">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Account Role</label>
                        <select name="role" class="lux-input">
                            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Standard User</option>
                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Password (Leave blank to keep same)</label>
                        <input type="password" name="password" class="lux-input" placeholder="••••••••">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest px-1">Status</label>
                        <select name="status" class="lux-input">
                            <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-slate-800 pt-8 flex justify-end gap-4">
                    <a href="index.php" class="px-6 py-3 text-slate-400 hover:text-white font-bold transition-all">Back to List</a>
                    <button type="submit" name="submit" class="btn-lux">Update Member</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>