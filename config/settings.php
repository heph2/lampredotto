<?php

use Monolog\Logger;
// Should be set to 0 in production
// This set the errors to display at runtime
// https://www.php.net/manual/en/function.error-reporting.php
error_reporting(E_ALL);

// Should be set to '0' in production
// Values configuration options configured on php.ini
// https://www.php.net/manual/en/function.ini-set
ini_set('display_errors', '1');

$debug = true;

// Settings
$settings = [

    // monolog settings
    'logger' => [
        'name' => 'app',
        'path' =>  '../var/log/app.log',
        'level' => $debug ? Logger::DEBUG : Logger::INFO,
    ],
    // View settings
    'view' => [
        'template_path' => '../templates',
        'twig' => [
            'cache' => '../var/cache/twig',
            'debug' => true,
            'auto_reload' => true,
        ],
    ],
    "db" => [
        'driver' => 'pgsql',
        'host' => 'localhost',
        'username' => 'postgres',
        'database' => 'lampredotto_staging',
        'password' => 'postgres',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'flags' => [
            // Turn off persistent connections
            PDO::ATTR_PERSISTENT => false,
            // Enable exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Emulate prepared statements
            PDO::ATTR_EMULATE_PREPARES => true,
            // Set default fetch mode to array
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ],
    ],    
];
return $settings;