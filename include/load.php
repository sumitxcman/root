<?php
// 1. Load Configurations
require_once __DIR__ . '/config.php';

// 2. Start Session
require_once __DIR__ . '/session.php';

// 3. Load CSRF Logic (Security)
require_once __DIR__ . '/csrf.php';

// 4. Connect to Database
require_once __DIR__ . '/db.php';

// 5. Load Helpers & Auth
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/auth.php';