<?php

define('BASE_PATH', dirname(__DIR__));

if (file_exists(BASE_PATH . '/.env')) {

    $lines = file(BASE_PATH . '/.env');

    foreach ($lines as $line) {

        if (strpos(trim($line), '#') === 0) continue;

        if (strpos($line, '=') !== false) {

            list($name, $value) = explode('=', $line, 2);

            $value = trim($value, "\"'");

            $_ENV[trim($name)] = trim($value);
        }
    }
}

if ($_ENV['DEBUG'] === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}