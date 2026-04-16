<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Connection include karein
require_once('./include/db.php');

$error = "";

// 3. Registration Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password_raw = isset($_POST['password']) ? trim($_POST['password']) : '';
    // Default Role
    $role = 'user';

    if (isset($conn)) {
        try {
            // Check karein ki email ya username pehle se toh nahi hai
            $checkUser = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $checkUser->execute([$email, $username]);
            
            if ($checkUser->rowCount() > 0) {
                $error = "Email ya Username pehle se maujood hai!";
            } else {
                // Password hashing
                $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                if ($stmt->execute([$fullname, $username, $email, $hashed_password, $role])) {
                    // Success! Login page par bhej rahe hain
                    header("Location: sign-in.php?signup=success");
                    exit;
                } else {
                    $error = "Kuch galat hua, dobara koshish karein.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | MY SHOP Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #020617; color: white; overflow: hidden; }
        /* Background Glows */
        .glow-circle-1 { position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(147,51,234,0.3) 0%, rgba(0,0,0,0) 70%); top: -100px; right: -100px; border-radius: 50%; z-index: -1; }
        .glow-circle-2 { position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, rgba(0,0,0,0) 70%); bottom: -150px; left: -100px; border-radius: 50%; z-index: -1; }
        
        /* Glass Card */
        .glass-card {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        /* Inputs */
        .lux-input {
            width: 100%; padding: 14px 16px 14px 48px; background: rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; color: white; outline: none; transition: 0.3s;
        }
        .lux-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); }
        .input-icon { position: absolute; left: 16px; top: 15px; color: #64748b; font-size: 20px; transition: 0.3s; }
        .input-wrapper:focus-within .input-icon { color: #3b82f6; }
        .toggle-password { position: absolute; right: 16px; top: 15px; color: #64748b; font-size: 20px; cursor: pointer; transition: 0.3s; }
        .toggle-password:hover { color: white; }

        /* Button */
        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; transition: 0.3s;
        }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(147, 51, 234, 0.5); }
        .btn-gradient:active { transform: translateY(0); }

        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease-in forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative">
    
    <div class="glow-circle-1"></div>
    <div class="glow-circle-2"></div>

    <div class="glass-card w-full max-w-[420px] p-10 rounded-3xl mx-4 relative z-10 my-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-white uppercase italic">Join Us</h1>
            <p class="text-slate-400 text-sm mt-1">Create your premium account.</p>
        </div>

        <?php if($error): ?>
            <div class="fade-in bg-red-500/10 border border-red-500/30 text-red-400 p-3.5 rounded-xl mb-6 text-xs font-medium text-center flex items-center justify-center gap-2">
                <iconify-icon icon="solar:danger-bold"></iconify-icon>
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="sign-up.php" class="space-y-4">
            
            <div class="relative input-wrapper">
                <iconify-icon icon="solar:user-bold-duotone" class="input-icon"></iconify-icon>
                <input type="text" name="fullname" placeholder="Full Name" required class="lux-input">
            </div>

            <div class="relative input-wrapper">
                <iconify-icon icon="solar:user-id-bold-duotone" class="input-icon"></iconify-icon>
                <input type="text" name="username" placeholder="Username" required class="lux-input">
            </div>
            
            <div class="relative input-wrapper">
                <iconify-icon icon="solar:letter-bold-duotone" class="input-icon"></iconify-icon>
                <input type="email" name="email" placeholder="Email Address" required class="lux-input">
            </div>
            
            <div class="relative input-wrapper">
                <iconify-icon icon="solar:lock-password-bold-duotone" class="input-icon"></iconify-icon>
                <input type="password" name="password" id="password" placeholder="Create Password" required class="lux-input pr-12">
                <iconify-icon icon="solar:eye-bold-duotone" id="togglePsw" class="toggle-password" onclick="togglePassword()"></iconify-icon>
            </div>

            <button type="submit" id="submitBtn" class="btn-gradient w-full py-4 text-sm mt-6 flex justify-center items-center gap-2" onclick="showLoading()">
                <span id="btnText">Register Now</span>
                <iconify-icon icon="solar:arrow-right-line-duotone" class="text-lg" id="btnIcon"></iconify-icon>
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 mt-8">
            Already have an account? <a href="sign-in.php" class="text-blue-400 font-medium hover:text-blue-300 transition-colors">Sign In</a>
        </p>
    </div>

    <script>
        function togglePassword() {
            const pswInput = document.getElementById('password');
            const icon = document.getElementById('togglePsw');
            if (pswInput.type === 'password') {
                pswInput.type = 'text';
                icon.setAttribute('icon', 'solar:eye-closed-bold-duotone');
            } else {
                pswInput.type = 'password';
                icon.setAttribute('icon', 'solar:eye-bold-duotone');
            }
        }

        function showLoading() {
            const form = document.querySelector('form');
            if(form.checkValidity()) {
                document.getElementById('btnText').innerText = 'Processing...';
                document.getElementById('btnIcon').setAttribute('icon', 'solar:refresh-circle-bold-duotone');
                document.getElementById('btnIcon').classList.add('animate-spin');
            }
        }
    </script>
</body>
</html>