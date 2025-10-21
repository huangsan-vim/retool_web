<?php
namespace App\Models;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $connection;
    private $config;
    
    private function __construct() {
        $this->config = require __DIR__ . '/../Config/config.php';
        $this->connect();
    }
    
    private function connect() {
        try {
            $dbPath = $this->config['database']['path'];
            
            // Create database directory if it doesn't exist
            $dbDir = dirname($dbPath);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }
            
            $this->connection = new PDO("sqlite:$dbPath");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Initialize database if it doesn't exist
            if (!file_exists($dbPath) || filesize($dbPath) === 0) {
                $this->initializeDatabase();
            }
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    private function initializeDatabase() {
        $schemaFile = __DIR__ . '/../../database/schema.sql';
        if (file_exists($schemaFile)) {
            $schema = file_get_contents($schemaFile);
            $this->connection->exec($schema);
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            return [];
        }
    }
    
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Execute error: " . $e->getMessage());
            return false;
        }
    }
    
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollback() {
        return $this->connection->rollBack();
    }
}