<?php require __DIR__ . '/header.php'; ?>

<main class="main-content">
    <div class="container">
        <div class="content-wrapper">
            <div class="main-column">
                <?php if (isset($video)): ?>
                    <div class="video-player-container">
                        <video class="video-player" controls>
                            <source src="<?php echo htmlspecialchars($video['video_url']); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        
                        <div class="video-details">
                            <h1><?php echo htmlspecialchars($video['title']); ?></h1>
                            
                            <div class="video-stats">
                                <span><?php echo number_format($video['views']); ?> views</span>
                                <span>Category: <?php echo htmlspecialchars($video['category']); ?></span>
                                <?php if (!empty($video['duration'])): ?>
                                    <span>Duration: <?php echo htmlspecialchars($video['duration']); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($video['description'])): ?>
                                <div class="video-description">
                                    <p><?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($video['tags'])): ?>
                                <div style="margin-top: 1rem;">
                                    <?php 
                                    $tags = explode(',', $video['tags']);
                                    foreach ($tags as $tag): 
                                        $tag = trim($tag);
                                        if (!empty($tag)):
                                    ?>
                                        <span class="video-category" style="margin-right: 0.5rem;">
                                            #<?php echo htmlspecialchars($tag); ?>
                                        </span>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (isset($relatedVideos) && is_array($relatedVideos) && count($relatedVideos) > 0): ?>
                        <div class="related-videos">
                            <h2>Related Videos</h2>
                            <div class="video-grid">
                                <?php foreach ($relatedVideos as $relVideo): ?>
                                    <?php if ($relVideo['id'] != $video['id']): ?>
                                        <div class="video-card">
                                            <div class="video-thumbnail">
                                                <img 
                                                    data-src="<?php echo htmlspecialchars($relVideo['thumbnail']); ?>" 
                                                    alt="<?php echo htmlspecialchars($relVideo['title']); ?>"
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 225'%3E%3Crect fill='%23374151' width='400' height='225'/%3E%3C/svg%3E"
                                                >
                                                <?php if (!empty($relVideo['duration'])): ?>
                                                    <span class="video-duration"><?php echo htmlspecialchars($relVideo['duration']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="video-info">
                                                <h3 class="video-title">
                                                    <a href="/video/<?php echo $relVideo['id']; ?>">
                                                        <?php echo htmlspecialchars($relVideo['title']); ?>
                                                    </a>
                                                </h3>
                                                <div class="video-meta">
                                                    <span class="video-category"><?php echo htmlspecialchars($relVideo['category']); ?></span>
                                                    <span><?php echo number_format($relVideo['views']); ?> views</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <?php if (isset($sidebarAds) && is_array($sidebarAds) && count($sidebarAds) > 0): ?>
                <aside class="sidebar">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Sponsored</h3>
                        <?php foreach ($sidebarAds as $ad): ?>
                            <div class="ad-container">
                                <a href="<?php echo htmlspecialchars($ad['link_url']); ?>" target="_blank" rel="noopener">
                                    <img src="<?php echo htmlspecialchars($ad['image_url']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/footer.php'; ?>