<?php
namespace App\Models;

class Category {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll() {
        $sql = "SELECT * FROM categories ORDER BY display_order ASC";
        return $this->db->query($sql);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }
    
    public function getBySlug($slug) {
        $sql = "SELECT * FROM categories WHERE slug = ?";
        $result = $this->db->query($sql, [$slug]);
        return $result ? $result[0] : null;
    }
    
    public function create($data) {
        $sql = "INSERT INTO categories (name, slug, description, display_order, created_at) 
                VALUES (?, ?, ?, ?, ?)";
        
        $params = [
            $data['name'],
            $data['slug'],
            $data['description'] ?? '',
            $data['display_order'] ?? 0,
            time()
        ];
        
        if ($this->db->execute($sql, $params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    public function update($id, $data) {
        $sql = "UPDATE categories SET 
                name = ?, 
                slug = ?, 
                description = ?, 
                display_order = ? 
                WHERE id = ?";
        
        $params = [
            $data['name'],
            $data['slug'],
            $data['description'] ?? '',
            $data['display_order'] ?? 0,
            $id
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
}