<?php
// Database initialization script

echo "Initializing database...\n";

// Set paths
$dbPath = __DIR__ . '/retool.db';
$schemaFile = __DIR__ . '/schema.sql';

// Remove existing database if it exists
if (file_exists($dbPath)) {
    unlink($dbPath);
    echo "Removed existing database\n";
}

// Create new database
try {
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Execute schema
    if (file_exists($schemaFile)) {
        $schema = file_get_contents($schemaFile);
        $db->exec($schema);
        echo "✓ Database schema created\n";
    } else {
        die("❌ Schema file not found\n");
    }
    
    // Run seeding (only if not already seeded)
    $checkStmt = $db->query("SELECT COUNT(*) as count FROM categories");
    $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        require __DIR__ . '/seed.php';
        seedDatabase($dbPath);
    } else {
        echo "✓ Database already seeded\n";
    }
    
    echo "\n✅ Database initialization completed!\n";
    
} catch (PDOException $e) {
    die("❌ Database initialization failed: " . $e->getMessage() . "\n");
}