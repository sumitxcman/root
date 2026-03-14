<?php

/**
 
 */


if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}


if (!function_exists('redirect')) {
    function redirect($path) {
        header("Location: $path");
        exit;
    }
}


if (!function_exists('set_message')) {
    function set_message($msg) {
        $_SESSION['message'] = $msg;
    }
}


if (!function_exists('display_message')) {
    function display_message() {
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . e($_SESSION['message']) . '</div>';
            unset($_SESSION['message']);
        }
    }
}



/**
 
 */
if (!function_exists('getSetting')) {
    function getSetting($key, $pdo) {
        
        $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();

        
        return $result ? $result['setting_value'] : '';
    }
}