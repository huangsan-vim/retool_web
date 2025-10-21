<?php
// Application Configuration

return [
    // Database configuration
    'database' => [
        'driver' => 'sqlite',
        'path' => __DIR__ . '/../../database/retool.db',
    ],
    
    // Application settings
    'app' => [
        'name' => 'Retool Video Platform',
        'url' => 'http://localhost:8080',
        'timezone' => 'UTC',
        'debug' => true,
    ],
    
    // Cache settings
    'cache' => [
        'enabled' => true,
        'duration' => 3600, // 1 hour
        'path' => __DIR__ . '/../../cache',
    ],
    
    // Pagination
    'pagination' => [
        'videos_per_page' => 24,
        'search_results_per_page' => 20,
    ],
    
    // Upload settings
    'upload' => [
        'max_file_size' => 100 * 1024 * 1024, // 100MB
        'allowed_types' => ['mp4', 'webm', 'ogg'],
        'upload_path' => __DIR__ . '/../../public/uploads',
    ],
    
    // Session settings
    'session' => [
        'lifetime' => 7200, // 2 hours
        'name' => 'retool_session',
    ],
    
    // Security
    'security' => [
        'password_min_length' => 8,
        'session_regenerate' => true,
    ],
];