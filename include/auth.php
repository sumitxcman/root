<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function checkLogin() {
    if (!isLoggedIn()) {
        header("Location: sign-in.php");
        exit;
    }
}

function login($login_input, $password, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1");
    $stmt->execute([$login_input, $login_input]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) { 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['username'];
        return true;
    }
    return false;
}