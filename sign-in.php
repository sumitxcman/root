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
    <title>Sign In | MY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#020617] flex items-center justify-center h-screen">
    <div class="bg-[#0f172a] p-8 rounded-3xl border border-slate-800 w-full max-w-md">
        <h2 class="text-white text-2xl font-black mb-6 uppercase text-center italic">Login</h2>
        
        <?php if($error): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded-xl mb-4 text-xs font-bold text-center">
                <?= isset($helper_file) ? e($error) : htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="sign-in.php" class="space-y-4">
            <input type="email" name="email" placeholder="Email" required class="w-full bg-slate-900 border border-slate-800 p-3 rounded-xl text-white outline-none focus:border-blue-500">
            <input type="password" name="password" placeholder="Password" required class="w-full bg-slate-900 border border-slate-800 p-3 rounded-xl text-white outline-none focus:border-blue-500">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-3 rounded-xl uppercase transition-all">Sign In</button>
        </form>
    </div>
</body>
</html>