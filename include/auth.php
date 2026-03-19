<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login($login_input, $password, $pdo) {
    try {
        // Username ya email se check karein
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$login_input, $login_input]);
        $user = $stmt->fetch();

        if ($user) {
            // Aapka password '12345678' hai, isliye direct match check karein
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['is_logged_in'] = true;
                return true;
            }
        }
    } catch (PDOException $e) {
        return false;
    }
    return false;
}
?>