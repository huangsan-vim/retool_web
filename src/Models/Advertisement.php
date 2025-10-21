<?php
namespace App\Models;

class Advertisement {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getByPosition($position) {
        $sql = "SELECT * FROM advertisements WHERE position = ? AND status = 1 ORDER BY display_order ASC";
        return $this->db->query($sql, [$position]);
    }
    
    public function getAll() {
        $sql = "SELECT * FROM advertisements WHERE status = 1 ORDER BY position, display_order ASC";
        return $this->db->query($sql);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM advertisements WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }
    
    public function create($data) {
        $sql = "INSERT INTO advertisements (title, position, image_url, link_url, display_order, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['title'],
            $data['position'],
            $data['image_url'] ?? '',
            $data['link_url'] ?? '',
            $data['display_order'] ?? 0,
            $data['status'] ?? 1,
            time(),
            time()
        ];
        
        if ($this->db->execute($sql, $params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    public function update($id, $data) {
        $sql = "UPDATE advertisements SET 
                title = ?, 
                position = ?, 
                image_url = ?, 
                link_url = ?, 
                display_order = ?, 
                status = ?, 
                updated_at = ? 
                WHERE id = ?";
        
        $params = [
            $data['title'],
            $data['position'],
            $data['image_url'] ?? '',
            $data['link_url'] ?? '',
            $data['display_order'] ?? 0,
            $data['status'] ?? 1,
            time(),
            $id
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM advertisements WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
}