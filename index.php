<?php

require_once './routes.php';

$request  = $_SERVER['REQUEST_URI'];
$request = str_replace('/shopping/', '', $request);
$request = trim($request, '/');

$urlComponents = parse_url($request);
$path = isset($urlComponents['path']) ? $urlComponents['path'] : '';
$queryString = isset($urlComponents['query']) ? $urlComponents['query'] : '';

//lưu biến $path vào session
$_SESSION['current_path'] = $path;

// Tạo mảng để chứa các query parameters
$queryParams = [];
parse_str($queryString, $queryParams);

if (array_key_exists($path, $routes)) {
  list($controller, $action) = explode('@', $routes[$path]);
  $controllerFile = __DIR__ . '/app/controllers/' . $controller . '.php';
  if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controller();
    if (method_exists($controllerInstance, $action)) {
      call_user_func_array([$controllerInstance, $action], [$queryParams]);
    }
  }
}
