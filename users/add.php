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

    $error = "";
    $success = "";

    // Add User Logic
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $dept = trim($_POST['department']);
        $desig = trim($_POST['designation']);
        $status = trim($_POST['status']);
        $password_raw = trim($_POST['password']);
        $role = trim($_POST['role']);

        if (empty($fullname) || empty($email) || empty($password_raw)) {
            $error = "Please fill all required protocol fields.";
        } else {
            try {
                $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $check->execute([$email]);
                if ($check->rowCount() > 0) {
                    $error = "This identity (email) already exists in our database.";
                } else {
                    $username = explode('@', $email)[0] . rand(10, 99);
                    $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);
                    
                    $sql = "INSERT INTO users (fullname, email, phone, department, designation, status, username, password, role, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
                    $stmt = $conn->prepare($sql);
                    
                    if ($stmt->execute([$fullname, $email, $phone, $dept, $desig, $status, $username, $hashed_password, $role])) {
                        $success = "New identity authorized successfully!";
                    } else {
                        $error = "Protocol failure. Please re-authenticate and try again.";
                    }
                }
            } catch (PDOException $e) {
                $error = "System Error: " . $e->getMessage();
            }
        }
    }

    $title = 'Register Member | LUXURY ADMIN';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; color: #94a3b8; overflow-x: hidden; }
        
        /* Premium Background Glooms */
        .lux-orb-1 { position: absolute; top: -10%; left: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; filter: blur(80px); }
        .lux-orb-2 { position: absolute; bottom: -5%; right: -5%; width: 600px; height: 600px; background: radial-gradient(circle, rgba(147,51,234,0.08) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; filter: blur(60px); }

        .main-content { width: 100%; max-width: 1000px; margin: 0 auto; min-height: 100vh; padding: 4rem 2rem; position: relative; z-index: 10; }
        
        .lux-container {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 3rem;
            box-shadow: 0 40px 100px -20px rgba(0,0,0,0.8);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .lux-input { 
            background: rgba(2, 6, 23, 0.6); border: 1px solid #1e293b; border-radius: 1.25rem; 
            padding: 1.25rem 1.5rem; color: white; transition: 0.3s; width: 100%; outline: none;
        }
        .lux-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.1); }
        
        .btn-premium { 
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); color: white; 
            padding: 1.25rem 2.5rem; border-radius: 1.5rem; font-weight: 800; transition: 0.4s; 
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.4);
            text-transform: uppercase; letter-spacing: 0.1em; italic: true;
        }
        .btn-premium:hover { transform: translateY(-3px); opacity: 0.9; }
    </style>
</head>
<body class="antialiased selection:bg-blue-500/30">

    <div class="lux-orb-1"></div>
    <div class="lux-orb-2"></div>

    <main class="main-content">
        
        <header class="mb-12 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/10 border border-blue-600/20 rounded-full mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_8px_#3b82f6]"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-400">Security Protocol</span>
            </div>
            <h2 class="text-5xl font-black text-white uppercase tracking-tighter italic leading-none mb-3">Add Identity</h2>
            <p class="text-slate-500 font-medium opacity-80 uppercase text-[10px] tracking-[0.4em]">Authorized Personnel Registration</p>
        </header>

        <div class="lux-container p-10 md:p-16">
            
            <?php if($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-500 p-5 rounded-2xl mb-10 text-xs font-bold flex items-center gap-3">
                    <iconify-icon icon="solar:danger-bold-duotone" class="text-2xl"></iconify-icon>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if($success): ?>
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-5 rounded-2xl mb-10 text-xs font-bold flex items-center gap-3">
                    <iconify-icon icon="solar:check-circle-bold-duotone" class="text-2xl"></iconify-icon>
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <form action="add.php" method="POST" enctype="multipart/form-data" class="space-y-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Full Legal Name</label>
                        <input type="text" name="fullname" class="lux-input" placeholder="Sumit Singh" required>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Secure Email Identity</label>
                        <input type="email" name="email" class="lux-input" placeholder="sumit@modest.mission" required>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Verified Phone Number</label>
                        <input type="text" name="phone" class="lux-input" placeholder="+91 99999 99999">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Department Node</label>
                        <select name="department" class="lux-input appearance-none">
                            <option value="Management">Global Management</option>
                            <option value="Sales">Premium Sales</option>
                            <option value="IT Department">Infrastructure Logic</option>
                            <option value="Marketing">Growth Protocol</option>
                        </select>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Security Authorization</label>
                        <select name="role" class="lux-input">
                            <option value="user">Standard Agent</option>
                            <option value="admin">Principal Admin</option>
                        </select>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Master Password</label>
                        <input type="password" name="password" class="lux-input" placeholder="••••••••" required>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Protocol Designation</label>
                        <input type="text" name="designation" class="lux-input" placeholder="Elite Consultant">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Account Status</label>
                        <select name="status" class="lux-input">
                            <option value="active">Active Layer</option>
                            <option value="inactive">Encrypted/Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8">
                    <a href="index.php" class="text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-white transition-all">
                        <iconify-icon icon="solar:alt-arrow-left-linear" class="align-middle mr-1"></iconify-icon> Revoke & Dismiss
                    </a>
                    <button type="submit" name="submit" class="btn-premium w-full md:w-auto">
                        Authorize Identity
                    </button>
                </div>
            </form>
        </div>

        <footer class="mt-12 text-center text-[9px] font-black uppercase text-slate-700 tracking-[0.5em] italic">
            Secure Member Registration Protocol v.03
        </footer>
    </main>

</body>
</html>