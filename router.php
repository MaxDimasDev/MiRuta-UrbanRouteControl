<?php
// Development router for PHP built-in server to properly serve static assets
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$fullPath = __DIR__ . $uri;

// If the requested path is a real file, let the server serve it directly
if ($uri !== '/' && file_exists($fullPath) && is_file($fullPath)) {
    return false;
}

// Otherwise, delegate to the application's front controller
require __DIR__ . '/index.php';