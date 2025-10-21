<?php
namespace App\Models;

class Video {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($limit = 24, $offset = 0) {
        $sql = "SELECT * FROM videos WHERE status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?";
        return $this->db->query($sql, [$limit, $offset]);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM videos WHERE id = ? AND status = 1";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }
    
    public function getByCategory($category, $limit = 24, $offset = 0) {
        $sql = "SELECT * FROM videos WHERE category = ? AND status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?";
        return $this->db->query($sql, [$category, $limit, $offset]);
    }
    
    public function search($keyword, $limit = 20, $offset = 0) {
        $sql = "SELECT * FROM videos WHERE (title LIKE ? OR description LIKE ? OR tags LIKE ?) AND status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $searchTerm = "%$keyword%";
        return $this->db->query($sql, [$searchTerm, $searchTerm, $searchTerm, $limit, $offset]);
    }
    
    public function getLatest($limit = 12) {
        $sql = "SELECT * FROM videos WHERE status = 1 ORDER BY created_at DESC LIMIT ?";
        return $this->db->query($sql, [$limit]);
    }
    
    public function getPopular($limit = 12) {
        $sql = "SELECT * FROM videos WHERE status = 1 ORDER BY views DESC LIMIT ?";
        return $this->db->query($sql, [$limit]);
    }
    
    public function incrementViews($id) {
        $sql = "UPDATE videos SET views = views + 1 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    public function getTotalCount() {
        $sql = "SELECT COUNT(*) as count FROM videos WHERE status = 1";
        $result = $this->db->query($sql);
        return $result[0]['count'] ?? 0;
    }
    
    public function getCategoryCount($category) {
        $sql = "SELECT COUNT(*) as count FROM videos WHERE category = ? AND status = 1";
        $result = $this->db->query($sql, [$category]);
        return $result[0]['count'] ?? 0;
    }
    
    public function create($data) {
        $sql = "INSERT INTO videos (title, description, thumbnail, video_url, category, tags, duration, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['title'],
            $data['description'] ?? '',
            $data['thumbnail'] ?? '',
            $data['video_url'] ?? '',
            $data['category'] ?? '',
            $data['tags'] ?? '',
            $data['duration'] ?? '',
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
        $sql = "UPDATE videos SET 
                title = ?, 
                description = ?, 
                thumbnail = ?, 
                video_url = ?, 
                category = ?, 
                tags = ?, 
                duration = ?, 
                status = ?, 
                updated_at = ? 
                WHERE id = ?";
        
        $params = [
            $data['title'],
            $data['description'] ?? '',
            $data['thumbnail'] ?? '',
            $data['video_url'] ?? '',
            $data['category'] ?? '',
            $data['tags'] ?? '',
            $data['duration'] ?? '',
            $data['status'] ?? 1,
            time(),
            $id
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function delete($id) {
        $sql = "UPDATE videos SET status = 0 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
}