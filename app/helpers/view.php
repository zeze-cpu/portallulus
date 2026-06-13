<?php
declare(strict_types=1);

function view(string $page, array $data = []): void
{
  extract($data, EXTR_SKIP);

  $view_file = __DIR__ . '/../views/pages/' . $page . '.php';
  if (!file_exists($view_file)) {
    throw new RuntimeException("View not found: {$page}");
  }

  $layout      = $data['layout'] ?? 'main';
  $layout_file = __DIR__ . '/../views/layouts/' . $layout . '.php';

  if (!file_exists($layout_file)) {
    $layout_file = __DIR__ . '/../views/layouts/main.php';
  }

  require $layout_file;
}

function e($value): string
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function format_nilai(float|int|string|null $value): string
{
  return number_format((float)$value, 2, '.', '');
}

function parse_nilai(float|int|string|null $value): float
{
  $raw = is_string($value) ? str_replace(',', '.', trim($value)) : (string)$value;
  if ($raw === '' || $raw === '.') {
    return 0.0;
  }
  $num = (float)$raw;
  return round(max(0.0, min(100.0, $num)), 2);
}

function url(string $path = ''): string
{
  $base = rtrim(BASE_URL, '/');
  $path = '/' . ltrim($path, '/');
  return $base . ($path === '/' ? '' : $path);
}

function asset(string $path): string
{
  return url($path);
}
