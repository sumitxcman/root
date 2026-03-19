<?php
// 1. Files include karein
include('./include/db.php');     
include('./include/auth.php');   

$error = "";

// 2. Login Process Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if (login($email, $password, $pdo)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "worng password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif;
            height: 100vh; display: flex; align-items: center; justify-content: center;
            background-color: #0f172a;
        }
        .form-container {
            width: 100%; max-width: 400px; padding: 40px;
            background-color: #1e293b; border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); color: white;
        }
        .form-container h2 { text-align: center; margin-bottom: 10px; font-size: 26px; }
        .form-container p.subtitle { text-align: center; color: #94a3b8; margin-bottom: 30px; font-size: 14px; }
        
        .error-msg {
            background-color: rgba(239, 68, 68, 0.2);
            color: #ef4444; padding: 10px; border-radius: 8px;
            margin-bottom: 20px; font-size: 13px; border: 1px solid #ef4444;
            text-align: center;
        }

        .form-group { margin-bottom: 20px; position: relative; }
        .form-control {
            width: 100%; padding: 14px 15px 14px 45px;
            border: 1px solid #334155; border-radius: 10px;
            background-color: #0f172a; color: white; box-sizing: border-box;
            outline: none; transition: 0.3s;
        }
        .form-control:focus { border-color: #3b82f6; }
        
        .input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #64748b; }
        .password-toggle { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #64748b; cursor: pointer; }

        .btn-sign-in {
            width: 100%; padding: 14px; border: none; border-radius: 10px;
            background-color: #3b82f6; color: white; font-weight: 600; cursor: pointer;
            font-size: 16px; margin-top: 10px;
        }
        .btn-sign-in:hover { background-color: #2563eb; }

        .separator { display: flex; align-items: center; color: #64748b; margin: 25px 0; font-size: 12px; }
        .separator::before, .separator::after { content: ''; flex: 1; border-bottom: 1px solid #334155; }
        .separator:not(:empty)::before { margin-right: 10px; }
        .separator:not(:empty)::after { margin-left: 10px; }

        .social-buttons { display: flex; gap: 12px; margin-bottom: 25px; }
        .social-btn {
            flex: 1; padding: 12px; border: 1px solid #334155; border-radius: 10px;
            background-color: transparent; color: white; text-decoration: none;
            display: flex; align-items: center; justify-content: center; font-size: 14px;
        }
        .sign-up-link { text-align: center; color: #94a3b8; font-size: 14px; }
        .sign-up-link a { color: #3b82f6; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Sign In</h2>
        <p class="subtitle">Welcome back! Please enter your details</p>

        <?php if($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="sign-in.php" method="POST">
            <div class="form-group">
                <i class="bi bi-envelope input-icon"></i>
                <input type="text" name="email" class="form-control" placeholder="Email or Username" required>
            </div>
            
            <div class="form-group">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <i class="bi bi-eye password-toggle" id="togglePassword"></i>
            </div>
            
            <div class="form-options" style="display:flex; justify-content: space-between; font-size: 13px; color: #94a3b8; margin-bottom: 20px;">
                <label style="display:flex; align-items:center; gap:5px; cursor:pointer;">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#" style="color: #94a3b8; text-decoration:none;">Forgot Password?</a>
            </div>
            
            <button type="submit" class="btn-sign-in">Sign In</button>
        </form>

        <div class="separator">Or sign in with</div>

        <div class="social-buttons">
            <a href="#" class="social-btn"><i class="bi bi-google" style="margin-right:8px; color:#ea4335;"></i> Google</a>
            <a href="#" class="social-btn"><i class="bi bi-facebook" style="margin-right:8px; color:#1877f2;"></i> Facebook</a>
        </div>

        <div class="sign-up-link">
            Don't have an account? <a href="sign-up.php">Sign Up</a>
        </div>
    </div>

    <script>
        $('#togglePassword').click(function() {
            const passwordField = $('#password');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            $(this).toggleClass('bi-eye bi-eye-slash');
        });
    </script>
</body>
</html>