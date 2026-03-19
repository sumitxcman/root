<?php
// Base Path definition
define('BASE_PATH', dirname(__DIR__));

// .env file loader logic
if (file_exists(BASE_PATH . '/.env')) {
    $lines = file(BASE_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) continue;
        
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Remove quotes from value
            $value = trim($value, "\"' ");
            
            // Set in $_ENV and putenv for compatibility
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}

// Debug Mode check (Simple check)
$debug = isset($_ENV['DEBUG']) && ($_ENV['DEBUG'] === 'true' || $_ENV['DEBUG'] === '1');

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>