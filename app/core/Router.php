<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
  private array $routes = ['GET' => [], 'POST' => []];

  public function get(string $path, callable|array $handler): void
  {
    $this->routes['GET'][] = [$this->compile($path), $handler];
  }

  public function post(string $path, callable|array $handler): void
  {
    $this->routes['POST'][] = [$this->compile($path), $handler];
  }

  public function dispatch(): void
  {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri    = $_SERVER['REQUEST_URI']    ?? '/';
    $path   = $this->normalize(parse_url($uri, PHP_URL_PATH) ?: '/');
    $base   = rtrim(BASE_URL, '/');

    if ($base !== '' && str_starts_with($path, $base)) {
      $path = substr($path, strlen($base));
      $path = $this->normalize($path === '' ? '/' : $path);
    }

    foreach ($this->routes[$method] as [$compiled, $handler]) {
      [$regex, $paramNames] = $compiled;
      if (preg_match($regex, $path, $m)) {
        $params = [];
        foreach ($paramNames as $name) {
          $params[] = $m[$name] ?? null;
        }
        $this->invoke($handler, $params);
        return;
      }
    }

    http_response_code(404);
    echo "<h2 style='font-family:sans-serif;text-align:center;margin-top:80px'>404 - Halaman Tidak Ditemukan</h2>";
  }

  private function invoke(callable|array $handler, array $params): void
  {
    $params = array_map(function ($p) {
      if (is_string($p) && ctype_digit($p)) return (int)$p;
      return $p;
    }, $params);

    if (is_array($handler)) {
      [$class, $action] = $handler;
      (new $class())->$action(...$params);
      return;
    }
    $handler(...$params);
  }

  private function compile(string $path): array
  {
    $path = $this->normalize($path);
    preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $path, $matches);
    $paramNames = $matches[1] ?? [];
    $regex = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^\/]+)', $path);
    $regex = '#^' . $regex . '$#';
    return [$regex, $paramNames];
  }

  private function normalize(string $path): string
  {
    $path = '/' . trim($path, '/');
    return $path === '//' ? '/' : $path;
  }
}
