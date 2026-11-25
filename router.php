<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$public = __DIR__ . '/public';
if ($path !== '/' && is_file($public . $path) && !str_ends_with($path, '.php')) {
    return false;
}
if (preg_match('#^/(api|up|storage|sanctum)(/|$)#', $path)) {
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = $public . '/index.php';
    require $public . '/index.php';
    return true;
}
header('Content-Type: text/html; charset=utf-8');
readfile($public . '/spa.html');
