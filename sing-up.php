<?php
// Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database include karein
include('./include/db.php');

$error = "";
$success = "";

// Registration Process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Default role 'user' rahega
    $role = 'user';

    if (isset($conn)) {
        try {
            // Check karein ki email ya username pehle se toh nahi hai
            $checkUser = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $checkUser->execute([$email, $username]);
            
            if ($checkUser->rowCount() > 0) {
                $error = "Email ya Username pehle se maujood hai!";
            } else {
                // Password ko hash karna security ke liye acha hota hai
                // Lekin aapke logic ke hisaab se hum ise simple ya hash dono rakh sakte hain
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                
                if ($stmt->execute([$fullname, $username, $email, $hashed_password, $role])) {
                    // Success! Ab login page par bhej rahe hain
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #0f172a; padding: 20px; }
        .form-container { width: 100%; max-width: 450px; padding: 40px; background-color: #1e293b; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); color: white; border: 1px solid #334155; }
        .form-container h2 { text-align: center; margin-bottom: 5px; font-size: 28px; font-weight: 800; color: #fff; }
        .subtitle { text-align: center; color: #94a3b8; margin-bottom: 30px; font-size: 14px; }
        .error-msg { background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; border: 1px solid rgba(239, 68, 68, 0.2); text-align: center; }
        .form-group { margin-bottom: 18px; position: relative; }
        .form-control { width: 100%; padding: 14px 15px 14px 45px; border: 1px solid #334155; border-radius: 12px; background-color: #0f172a; color: white; box-sizing: border-box; outline: none; transition: 0.3s; font-size: 14px; }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        .input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 18px; }
        .btn-sign-up { width: 100%; padding: 14px; border: none; border-radius: 12px; background-color: #3b82f6; color: white; font-weight: 700; cursor: pointer; font-size: 16px; margin-top: 10px; transition: 0.3s; }
        .btn-sign-up:hover { background-color: #2563eb; transform: translateY(-1px); }
        .login-link { text-align: center; color: #94a3b8; font-size: 14px; margin-top: 25px; }
        .login-link a { color: #3b82f6; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Join Us</h2>
        <p class="subtitle">Create your premium account, Sumit!</p>

        <?php if($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="sign-up.php" method="POST">
            <div class="form-group">
                <i class="bi bi-person-badge input-icon"></i>
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <i class="bi bi-at input-icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="form-group">
                <i class="bi bi-envelope input-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            
            <div class="form-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" class="form-control" placeholder="Create Password" required>
            </div>
            
            <button type="submit" class="btn-sign-up">Register Now</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="sign-in.php">Sign In here</a>
        </div>
    </div>

</body>
</html>