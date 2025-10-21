<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Video Platform'); ?></title>
    <meta name="description" content="Modern video sharing platform with a wide variety of content">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="/" class="logo">🎬 Retool Video</a>
                
                <div class="search-bar">
                    <form action="/search" method="GET" class="search-form">
                        <input 
                            type="text" 
                            name="q" 
                            class="search-input" 
                            placeholder="Search videos..." 
                            value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"
                        >
                        <button type="submit" class="btn">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <nav class="nav">
        <div class="container">
            <ul class="nav-list">
                <li><a href="/" class="nav-link">Home</a></li>
                <?php if (isset($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="/category/<?php echo htmlspecialchars($cat['slug']); ?>" class="nav-link">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    
    <?php if (isset($headerAds) && is_array($headerAds) && count($headerAds) > 0): ?>
        <div class="container" style="margin-top: 1rem;">
            <?php foreach ($headerAds as $ad): ?>
                <div class="ad-container">
                    <a href="<?php echo htmlspecialchars($ad['link_url']); ?>" target="_blank" rel="noopener">
                        <img src="<?php echo htmlspecialchars($ad['image_url']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>