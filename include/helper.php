<?php

/**
 * HELPER FUNCTIONS
 * Safe, Reusable shortcuts for our app
 */

// 1. Secure Output (Prevent XSS)
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

// 2. Quick Redirect
if (!function_exists('redirect')) {
    function redirect($path) {
        header("Location: $path");
        exit;
    }
}

// 3. Set Flash Message
if (!function_exists('set_message')) {
    function set_message($msg) {
        $_SESSION['message'] = $msg;
    }
}

// 4. Display Flash Message
if (!function_exists('display_message')) {
    function display_message() {
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . e($_SESSION['message']) . '</div>';
            unset($_SESSION['message']);
        }
    }
}

// --- NEW FUNCTION FOR MODULE 1 ---

/**
 * 5. Fetch Site Settings
 * Yeh function database se Site Title, Logo etc. nikalta hai
 */
if (!function_exists('getSetting')) {
    function getSetting($key, $pdo) {
        // SQL query: setting_key ke zariye value dhoondo
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();

        // Agar mil jaye toh value return karo, warna khali string
        return $result ? $result['setting_value'] : '';
    }
}