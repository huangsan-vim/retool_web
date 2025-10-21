<?php
namespace App\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Models\Advertisement;

class HomeController {
    private $videoModel;
    private $categoryModel;
    private $adModel;
    
    public function __construct() {
        $this->videoModel = new Video();
        $this->categoryModel = new Category();
        $this->adModel = new Advertisement();
    }
    
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 24;
        $offset = ($page - 1) * $perPage;
        
        $videos = $this->videoModel->getAll($perPage, $offset);
        $totalVideos = $this->videoModel->getTotalCount();
        $totalPages = ceil($totalVideos / $perPage);
        
        $categories = $this->categoryModel->getAll();
        $headerAds = $this->adModel->getByPosition('header');
        $sidebarAds = $this->adModel->getByPosition('sidebar');
        
        $data = [
            'videos' => $videos,
            'categories' => $categories,
            'headerAds' => $headerAds,
            'sidebarAds' => $sidebarAds,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => 'Home - Video Platform'
        ];
        
        $this->render('home', $data);
    }
    
    public function video($id) {
        $video = $this->videoModel->getById($id);
        
        if (!$video) {
            header("HTTP/1.0 404 Not Found");
            $this->render('404', ['pageTitle' => 'Video Not Found']);
            return;
        }
        
        // Increment view count
        $this->videoModel->incrementViews($id);
        
        // Get related videos
        $relatedVideos = $this->videoModel->getByCategory($video['category'], 6);
        
        $categories = $this->categoryModel->getAll();
        $sidebarAds = $this->adModel->getByPosition('sidebar');
        
        $data = [
            'video' => $video,
            'relatedVideos' => $relatedVideos,
            'categories' => $categories,
            'sidebarAds' => $sidebarAds,
            'pageTitle' => $video['title'] . ' - Video Platform'
        ];
        
        $this->render('video', $data);
    }
    
    public function category($slug) {
        $category = $this->categoryModel->getBySlug($slug);
        
        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            $this->render('404', ['pageTitle' => 'Category Not Found']);
            return;
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 24;
        $offset = ($page - 1) * $perPage;
        
        $videos = $this->videoModel->getByCategory($category['name'], $perPage, $offset);
        $totalVideos = $this->videoModel->getCategoryCount($category['name']);
        $totalPages = ceil($totalVideos / $perPage);
        
        $categories = $this->categoryModel->getAll();
        $sidebarAds = $this->adModel->getByPosition('sidebar');
        
        $data = [
            'videos' => $videos,
            'category' => $category,
            'categories' => $categories,
            'sidebarAds' => $sidebarAds,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => $category['name'] . ' - Video Platform'
        ];
        
        $this->render('category', $data);
    }
    
    public function search() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($keyword)) {
            header('Location: /');
            exit;
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        
        $videos = $this->videoModel->search($keyword, $perPage, $offset);
        $categories = $this->categoryModel->getAll();
        $sidebarAds = $this->adModel->getByPosition('sidebar');
        
        $data = [
            'videos' => $videos,
            'keyword' => $keyword,
            'categories' => $categories,
            'sidebarAds' => $sidebarAds,
            'currentPage' => $page,
            'pageTitle' => 'Search: ' . htmlspecialchars($keyword) . ' - Video Platform'
        ];
        
        $this->render('search', $data);
    }
    
    private function render($view, $data = []) {
        extract($data);
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}