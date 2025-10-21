<?php
namespace App\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Models\Advertisement;

class ApiController {
    private $videoModel;
    private $categoryModel;
    private $adModel;
    
    public function __construct() {
        $this->videoModel = new Video();
        $this->categoryModel = new Category();
        $this->adModel = new Advertisement();
        
        header('Content-Type: application/json');
    }
    
    public function videos() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 24;
        $offset = ($page - 1) * $perPage;
        
        $videos = $this->videoModel->getAll($perPage, $offset);
        $totalVideos = $this->videoModel->getTotalCount();
        
        echo json_encode([
            'success' => true,
            'data' => $videos,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $totalVideos,
                'total_pages' => ceil($totalVideos / $perPage)
            ]
        ]);
    }
    
    public function video($id) {
        $video = $this->videoModel->getById($id);
        
        if (!$video) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Video not found'
            ]);
            return;
        }
        
        echo json_encode([
            'success' => true,
            'data' => $video
        ]);
    }
    
    public function categories() {
        $categories = $this->categoryModel->getAll();
        
        echo json_encode([
            'success' => true,
            'data' => $categories
        ]);
    }
    
    public function search() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($keyword)) {
            echo json_encode([
                'success' => false,
                'message' => 'Search keyword is required'
            ]);
            return;
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 20;
        $offset = ($page - 1) * $perPage;
        
        $videos = $this->videoModel->search($keyword, $perPage, $offset);
        
        echo json_encode([
            'success' => true,
            'data' => $videos,
            'keyword' => $keyword
        ]);
    }
    
    public function latest() {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
        $videos = $this->videoModel->getLatest($limit);
        
        echo json_encode([
            'success' => true,
            'data' => $videos
        ]);
    }
    
    public function popular() {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;
        $videos = $this->videoModel->getPopular($limit);
        
        echo json_encode([
            'success' => true,
            'data' => $videos
        ]);
    }
}