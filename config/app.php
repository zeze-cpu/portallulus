<?php
declare(strict_types=1);

$envFile = __DIR__ . '/../.env';
if (!isset($env)) {
  $env = file_exists($envFile) ? parse_ini_file($envFile) : [];
}

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$autoBase = str_replace('/index.php', '', $scriptName);

define('BASE_URL', ($env['BASE_URL'] ?? '') ?: $autoBase);
