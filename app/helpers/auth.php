<?php
declare(strict_types=1);

function redirect(string $to): void
{
  if (preg_match('#^https?://#', $to)) { header("Location: {$to}"); exit; }
  $base = rtrim(BASE_URL, '/');
  $to   = '/' . ltrim($to, '/');
  header("Location: " . $base . $to);
  exit;
}

function is_logged_in(): bool
{
  return !empty($_SESSION['user']);
}

function require_login(string $role = 'admin'): void
{
  if (!is_logged_in()) {
    redirect($role === 'admin' ? '/login' : '/siswa/login');
  }
}

function require_role(string $role): void
{
  require_login($role);
  $current = $_SESSION['user']['role'] ?? null;
  $allowed = array_map('trim', explode(',', $role));

  if (!in_array($current, $allowed, true)) {
    if ($current === 'admin') redirect('/admin');
    if ($current === 'siswa') redirect('/siswa/dashboard');
    
    http_response_code(403);
    echo "403 Forbidden";
    exit;
  }
}

function current_path(): string
{
  $uri  = $_SERVER['REQUEST_URI'] ?? '/';
  $path = parse_url($uri, PHP_URL_PATH) ?: '/';
  $base = rtrim(BASE_URL, '/');

  if ($base !== '' && str_starts_with($path, $base)) {
    $path = substr($path, strlen($base));
    if ($path === '') $path = '/';
  }

  $path = '/' . trim($path, '/');
  return $path === '//' ? '/' : $path;
}

function is_active(string $path): bool
{
  $want = '/' . trim($path, '/');
  $cur  = current_path();
  return rtrim($cur, '/') === rtrim($want, '/');
}
