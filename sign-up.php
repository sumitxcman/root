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
    <title>Create Account - MY SHOP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #020617; padding: 20px; }
        .form-container { width: 100%; max-width: 450px; padding: 40px; background-color: #0f172a; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); color: white; border: 1px solid #1e293b; }
        .form-control { width: 100%; padding: 14px 15px 14px 45px; border: 1px solid #1e293b; border-radius: 12px; background-color: #020617; color: white; outline: none; transition: 0.3s; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        .input-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #475569; font-size: 18px; }
        .btn-register { width: 100%; padding: 14px; border: none; border-radius: 12px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4); }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-center text-3xl font-extrabold mb-1">Join Us</h2>
        <p class="text-center text-slate-500 text-sm mb-8">Create your premium account, Sumit!</p>

        <?php if($error): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl mb-6 text-center text-xs font-bold">
                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="sign-up.php" method="POST" class="space-y-4">
            <div class="relative">
                <i class="bi bi-person-badge input-icon"></i>
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="relative">
                <i class="bi bi-at input-icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="relative">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="relative">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" class="form-control" placeholder="Create Password" required>
            </div>
            <button type="submit" class="btn-register mt-4">Register Now</button>
        </form>

        <div class="text-center text-slate-500 text-sm mt-8">
            Already have an account? <a href="sign-in.php" class="text-blue-500 font-bold hover:underline">Sign In here</a>
        </div>
    </div>
</body>
</html>