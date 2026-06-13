<?php
declare(strict_types=1);

$envFile = __DIR__ . '/../.env';
$env = file_exists($envFile) ? parse_ini_file($envFile) : [];

define('DB_HOST',    $env['DB_HOST']    ?? '127.0.0.1');
define('DB_NAME',    $env['DB_NAME']    ?? 'portallulus');
define('DB_USER',    $env['DB_USER']    ?? 'root');
define('DB_PASS',    $env['DB_PASS']    ?? '');
define('DB_CHARSET', $env['DB_CHARSET'] ?? 'utf8mb4');
