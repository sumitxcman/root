<?php

// 2. Session Start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Absolute Paths Use Karein
// __DIR__ matlab jahan ye sign-in.php rakhi hai wahi folder
$db_file = __DIR__ . '/include/db.php';
$auth_file = __DIR__ . '/include/auth.php';
$helper_file = __DIR__ . '/include/helper.php';

// File check logic
if (file_exists($db_file)) {
    require_once $db_file;
} else {
    die("<b style='color:red;'>Fatal Error:</b> 'include/db.php' nahi mili! Check karein ki folder ka naam 'include' hi hai na?");
}

if (file_exists($auth_file)) {
    require_once $auth_file;
} else {
    die("<b style='color:red;'>Fatal Error:</b> 'include/auth.php' nahi mili!");
}

if (file_exists($helper_file)) {
    require_once $helper_file;
}

$error = "";

// 4. Login Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($pass)) {
        // Auth function call
        if (function_exists('login')) {
            $user_data = login($email, $pass, $conn);
            if ($user_data) {
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['role'] = $user_data['role'];

                if ($user_data['role'] === 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $error = "Email ya Password galat hai!";
            }
        } else {
            die("<b style='color:red;'>Error:</b> 'auth.php' mein 'login' function define nahi hai!");
        }
    } else {
        $error = "Dono fields bharna zaroori hai.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | MODEST MISSION Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html { font-size: 14px; /* Global scale down */ }
        body { font-family: 'Poppins', sans-serif; background-color: #020617; color: white; overflow: hidden; }
        /* Background Glows */
        .glow-circle-1 { position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(59,130,246,0.3) 0%, rgba(0,0,0,0) 70%); top: -100px; left: -100px; border-radius: 50%; z-index: -1; }
        .glow-circle-2 { position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(147,51,234,0.2) 0%, rgba(0,0,0,0) 70%); bottom: -150px; right: -100px; border-radius: 50%; z-index: -1; }
        
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
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.5); }
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

    <div class="glass-card w-full max-w-[420px] p-10 rounded-3xl mx-4 relative z-10">
        
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl mx-auto flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                <iconify-icon icon="solar:shop-bold-duotone" class="text-3xl text-white"></iconify-icon>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-white">MODEST MISSION</h1>
            <p class="text-slate-400 text-sm mt-1">Admin Access Portal</p>
        </div>

        <?php if($error): ?>
            <div class="fade-in bg-red-500/10 border border-red-500/30 text-red-400 p-3.5 rounded-xl mb-6 text-xs font-medium text-center flex items-center justify-center gap-2">
                <iconify-icon icon="solar:danger-bold"></iconify-icon>
                <?= isset($helper_file) && function_exists('e') ? e($error) : htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="sign-in.php" class="space-y-5">
            
            <div class="relative input-wrapper">
                <iconify-icon icon="solar:letter-bold-duotone" class="input-icon"></iconify-icon>
                <input type="email" name="email" placeholder="Email Address" required class="lux-input">
            </div>
            
            <div class="relative input-wrapper">
                <iconify-icon icon="solar:lock-password-bold-duotone" class="input-icon"></iconify-icon>
                <input type="password" name="password" id="password" placeholder="Password" required class="lux-input pr-12">
                <iconify-icon icon="solar:eye-bold-duotone" id="togglePsw" class="toggle-password" onclick="togglePassword()"></iconify-icon>
            </div>

            <div class="flex items-center justify-between mt-2 mb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" class="rounded border-slate-700 bg-slate-800 text-blue-500 focus:ring-blue-500/20">
                    <span class="text-xs text-slate-400">Remember me</span>
                </label>
                <a href="forgot-password.php" class="text-xs text-blue-400 hover:text-blue-300 transition-colors font-medium">Forgot Password?</a>
            </div>

            <button type="submit" id="submitBtn" class="btn-gradient w-full py-4 text-sm mt-6 flex justify-center items-center gap-2" onclick="showLoading()">
                <span id="btnText">Sign In</span>
                <iconify-icon icon="solar:arrow-right-line-duotone" class="text-lg" id="btnIcon"></iconify-icon>
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 mt-8">
            Don't have an account? <a href="sign-up.php" class="text-blue-400 font-medium hover:text-blue-300 transition-colors">Apply here</a>
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
            // Optional: little loading effect on button
            const form = document.querySelector('form');
            if(form.checkValidity()) {
                document.getElementById('btnText').innerText = 'Authenticating...';
                document.getElementById('btnIcon').setAttribute('icon', 'solar:refresh-circle-bold-duotone');
                document.getElementById('btnIcon').classList.add('animate-spin');
            }
        }
    </script>
</body>
</html>