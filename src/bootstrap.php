<?php

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(function ($class) {
    $file = BASE_PATH . '/src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require BASE_PATH . '/src/helpers.php';

$config = require BASE_PATH . '/config/config.php';

ini_set('display_errors', $config['debug'] ? '1' : '0');
error_reporting(E_ALL);

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);
