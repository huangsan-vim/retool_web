<?php require __DIR__ . '/header.php'; ?>

<main class="main-content">
    <div class="container">
        <div class="content-wrapper">
            <div class="main-column">
                <h1 style="margin-bottom: 1.5rem; font-size: 1.75rem;">Latest Videos</h1>
                
                <?php if (isset($videos) && is_array($videos) && count($videos) > 0): ?>
                    <div class="video-grid">
                        <?php foreach ($videos as $video): ?>
                            <div class="video-card">
                                <div class="video-thumbnail">
                                    <img 
                                        data-src="<?php echo htmlspecialchars($video['thumbnail']); ?>" 
                                        alt="<?php echo htmlspecialchars($video['title']); ?>"
                                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 225'%3E%3Crect fill='%23374151' width='400' height='225'/%3E%3C/svg%3E"
                                    >
                                    <?php if (!empty($video['duration'])): ?>
                                        <span class="video-duration"><?php echo htmlspecialchars($video['duration']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="video-info">
                                    <h3 class="video-title">
                                        <a href="/video/<?php echo $video['id']; ?>">
                                            <?php echo htmlspecialchars($video['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="video-meta">
                                        <span class="video-category"><?php echo htmlspecialchars($video['category']); ?></span>
                                        <span><?php echo number_format($video['views']); ?> views</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                        <div class="pagination">
                            <?php if ($currentPage > 1): ?>
                                <a href="?page=<?php echo $currentPage - 1; ?>">← Previous</a>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php if ($i == $currentPage): ?>
                                    <span class="active"><?php echo $i; ?></span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?page=<?php echo $currentPage + 1; ?>">Next →</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="text-align: center; padding: 3rem; color: #9ca3af;">No videos found.</p>
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