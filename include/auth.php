<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * auth.php - Single Login Function
 */
function login($login_input, $password, $conn) {
    try {
        // Username ya Email dono se check karein
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->execute([$login_input, $login_input]);
        $user = $stmt->fetch();

        if ($user) {
            // Only use hashed passwords for security
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'] ?? $user['fullname'];
                $_SESSION['fullname'] = $user['fullname'] ?? $user['username'];
                $_SESSION['role'] = $user['role']; // Isse dashboard check hoga
                $_SESSION['is_logged_in'] = true;
                
                return $user; // Pura data return karein taaki sign-in.php ise use kar sake
            }
        }
    } catch (PDOException $e) {
        // Agar error aaye toh debugging ke liye: error_log($e->getMessage());
        return false;
    }
    return false;
}

/**
 * Check if user is logged in
 */
function check_login() {
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
        header("Location: sign-in.php");
        exit;
    }
}
?>