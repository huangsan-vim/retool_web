<?php
// Main entry point for the application

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Load configuration
$config = require __DIR__ . '/../src/Config/config.php';

// Simple router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Route handling
if (empty($uri) || $uri === 'index.php') {
    // Home page
    $controller = new \App\Controllers\HomeController();
    $controller->index();
} elseif (preg_match('/^video\/(\d+)$/', $uri, $matches)) {
    // Video detail page
    $controller = new \App\Controllers\HomeController();
    $controller->video($matches[1]);
} elseif (preg_match('/^category\/([a-z0-9\-]+)$/', $uri, $matches)) {
    // Category page
    $controller = new \App\Controllers\HomeController();
    $controller->category($matches[1]);
} elseif ($uri === 'search') {
    // Search page
    $controller = new \App\Controllers\HomeController();
    $controller->search();
} elseif ($uri === 'api/videos') {
    // API: Get videos
    $controller = new \App\Controllers\ApiController();
    $controller->videos();
} elseif (preg_match('/^api\/video\/(\d+)$/', $uri, $matches)) {
    // API: Get single video
    $controller = new \App\Controllers\ApiController();
    $controller->video($matches[1]);
} elseif ($uri === 'api/categories') {
    // API: Get categories
    $controller = new \App\Controllers\ApiController();
    $controller->categories();
} elseif ($uri === 'api/search') {
    // API: Search
    $controller = new \App\Controllers\ApiController();
    $controller->search();
} elseif ($uri === 'api/latest') {
    // API: Latest videos
    $controller = new \App\Controllers\ApiController();
    $controller->latest();
} elseif ($uri === 'api/popular') {
    // API: Popular videos
    $controller = new \App\Controllers\ApiController();
    $controller->popular();
} else {
    // 404 Not Found
    header("HTTP/1.0 404 Not Found");
    $controller = new \App\Controllers\HomeController();
    require __DIR__ . '/../src/Views/404.php';
}