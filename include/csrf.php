<?php
// Session start hona lazmi hai (jo hamare session.php mein pehle se hai)

/**
 * Ek unique security token banata hai aur session mein save karta hai
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        // Random string generate karna
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Check karta hai ke form se aaya hua token sahi hai ya nahi
 */
function verify_csrf_token($token) {
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        return true;
    }
    return false;
}