<?php
// 1. Composer Autoload (Sirf ek baar)
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

// 2. Configuration & Core Files
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/db.php';

// 3. Security & Helpers
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/auth.php';

