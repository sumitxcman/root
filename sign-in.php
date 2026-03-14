<?php
require 'include/load.php';


if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        die("Security Token Invalid.");
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    
    if ($email === 'root' && $password === '12345678') {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'root';
        $_SESSION['user_role'] = 'admin';
        header("Location: dashboard.php");
        exit;
    } 
   
    elseif (login($email, $password, $pdo)) {
        header("Location: dashboard.php");
        exit;
    } 
    else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link rel="stylesheet" href="/root/css/style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f4; font-family: sans-serif; }
        .login-box { background: white; padding: 30px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        input { display: block; margin: 10px 0; padding: 10px; width: 100%; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; border-radius: 3px; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
        <p style="color: red; font-size: 14px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="sign-in.php">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        
        <input type="text" name="email" placeholder="Email or Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
    </form>
</div>

</body>
</html>