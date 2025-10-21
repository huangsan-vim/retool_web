<?php
// Database seeding script for test data

function seedDatabase($dbPath) {
    try {
        $db = new PDO("sqlite:$dbPath");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "Seeding database with test data...\n";
        
        // Seed categories
        $categories = [
            ['name' => 'Action', 'slug' => 'action', 'description' => 'Action videos'],
            ['name' => 'Comedy', 'slug' => 'comedy', 'description' => 'Comedy videos'],
            ['name' => 'Drama', 'slug' => 'drama', 'description' => 'Drama videos'],
            ['name' => 'Documentary', 'slug' => 'documentary', 'description' => 'Documentary videos'],
            ['name' => 'Animation', 'slug' => 'animation', 'description' => 'Animation videos'],
            ['name' => 'Thriller', 'slug' => 'thriller', 'description' => 'Thriller videos'],
        ];
        
        $stmt = $db->prepare("INSERT INTO categories (name, slug, description, display_order, created_at) VALUES (?, ?, ?, ?, ?)");
        foreach ($categories as $index => $cat) {
            $stmt->execute([$cat['name'], $cat['slug'], $cat['description'], $index, time()]);
        }
        echo "✓ Seeded " . count($categories) . " categories\n";
        
        // Seed videos
        $videoTitles = [
            'The Great Adventure',
            'Mystery of the Lost City',
            'Comedy Night Special',
            'Journey Through Time',
            'The Last Stand',
            'Secrets of the Ocean',
            'Mountain Expedition',
            'Urban Stories',
            'Wildlife Documentary',
            'Space Exploration',
            'Ancient Civilizations',
            'Modern Art Showcase',
            'Cooking Masterclass',
            'Tech Innovations 2025',
            'Music Festival Highlights',
            'Sports Championship',
            'Travel Diaries',
            'Science Explained',
            'Historical Events',
            'Future of Technology',
            'Nature\'s Wonders',
            'Cultural Heritage',
            'Extreme Sports',
            'Fashion Week',
            'Automotive Excellence',
            'Architecture Marvels',
            'Photography Tips',
            'Gaming Tournament',
            'Dance Performance',
            'Theater Production',
        ];
        
        $thumbnails = [
            'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=400',
            'https://images.unsplash.com/photo-1574267432644-f610a5b6e6e5?w=400',
            'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=400',
            'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400',
            'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=400',
            'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=400',
            'https://images.unsplash.com/photo-1518676590629-3dcbd9c5a5c9?w=400',
            'https://images.unsplash.com/photo-1524712245354-2c4e5e7121c0?w=400',
            'https://images.unsplash.com/photo-1533158326339-7f3cf2404354?w=400',
            'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=400',
        ];
        
        $videoUrls = [
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
            'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
        ];
        
        $stmt = $db->prepare("INSERT INTO videos (title, description, thumbnail, video_url, category, tags, views, duration, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($videoTitles as $index => $title) {
            $category = $categories[array_rand($categories)]['name'];
            $thumbnail = $thumbnails[array_rand($thumbnails)];
            $videoUrl = $videoUrls[array_rand($videoUrls)];
            $views = rand(100, 50000);
            $duration = sprintf("%02d:%02d", rand(5, 60), rand(0, 59));
            $tags = implode(',', array_slice(['trending', 'popular', 'new', 'featured', 'recommended'], 0, rand(1, 3)));
            $description = "This is a sample description for $title. Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
            $createdAt = time() - rand(0, 30 * 24 * 3600); // Random time within last 30 days
            
            $stmt->execute([
                $title,
                $description,
                $thumbnail,
                $videoUrl,
                $category,
                $tags,
                $views,
                $duration,
                1,
                $createdAt,
                $createdAt
            ]);
        }
        echo "✓ Seeded " . count($videoTitles) . " videos\n";
        
        // Seed advertisements
        $adPositions = [
            ['position' => 'header', 'title' => 'Header Banner Ad'],
            ['position' => 'sidebar', 'title' => 'Sidebar Ad 1'],
            ['position' => 'sidebar', 'title' => 'Sidebar Ad 2'],
            ['position' => 'footer', 'title' => 'Footer Banner Ad'],
            ['position' => 'video_list', 'title' => 'Video List Ad 1'],
            ['position' => 'video_list', 'title' => 'Video List Ad 2'],
        ];
        
        $adImages = [
            'https://via.placeholder.com/960x240/4A90E2/ffffff?text=Advertisement+Banner',
            'https://via.placeholder.com/300x250/E24A4A/ffffff?text=Sidebar+Ad',
            'https://via.placeholder.com/728x90/4AE290/ffffff?text=Footer+Banner',
        ];
        
        $stmt = $db->prepare("INSERT INTO advertisements (title, position, image_url, link_url, display_order, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($adPositions as $index => $ad) {
            $imageUrl = $adImages[array_rand($adImages)];
            $linkUrl = 'https://example.com/ad-' . ($index + 1);
            $stmt->execute([
                $ad['title'],
                $ad['position'],
                $imageUrl,
                $linkUrl,
                $index,
                1,
                time(),
                time()
            ]);
        }
        echo "✓ Seeded " . count($adPositions) . " advertisements\n";
        
        // Seed admin user (password: admin123)
        $stmt = $db->prepare("INSERT INTO users (username, password, email, role, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            'admin',
            password_hash('admin123', PASSWORD_BCRYPT),
            'admin@example.com',
            'admin',
            time()
        ]);
        echo "✓ Seeded admin user (username: admin, password: admin123)\n";
        
        // Seed site configuration
        $configs = [
            ['site_name', 'Retool Video Platform'],
            ['site_description', 'A modern video sharing platform'],
            ['videos_per_page', '24'],
            ['enable_cache', '1'],
            ['cache_duration', '3600'],
        ];
        
        $stmt = $db->prepare("INSERT INTO site_config (config_key, config_value, updated_at) VALUES (?, ?, ?)");
        foreach ($configs as $config) {
            $stmt->execute([$config[0], $config[1], time()]);
        }
        echo "✓ Seeded " . count($configs) . " configuration items\n";
        
        echo "\n✅ Database seeding completed successfully!\n";
        
    } catch (PDOException $e) {
        echo "❌ Error seeding database: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Run seeding if called directly
if (php_sapi_name() === 'cli') {
    $dbPath = __DIR__ . '/retool.db';
    seedDatabase($dbPath);
}