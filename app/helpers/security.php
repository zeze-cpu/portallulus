<?php
declare(strict_types=1);

function password_policy_error(string $password): ?string
{
  if (strlen($password) < 8)             return 'Password minimal 8 karakter.';
  if (!preg_match('/[A-Za-z]/', $password)) return 'Password harus mengandung huruf.';
  if (!preg_match('/[0-9]/',    $password)) return 'Password harus mengandung angka.';
  return null;
}

function csrf_token(): string
{
  if (empty($_SESSION['_csrf'])) {
    $_SESSION['_csrf'] = bin2hex(random_bytes(32));
  }
  return (string)$_SESSION['_csrf'];
}

function csrf_field(): void
{
  $t = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
  echo '<input type="hidden" name="_csrf" value="' . $t . '">';
}

function csrf_verify(): void
{
  if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') return;

  $sent = (string)($_POST['_csrf'] ?? '');
  $real = (string)($_SESSION['_csrf'] ?? '');

  if ($sent === '' || $real === '' || !hash_equals($real, $sent)) {
    http_response_code(403);
    echo "403 Forbidden (CSRF)";
    exit;
  }

  unset($_SESSION['_csrf']);
}
