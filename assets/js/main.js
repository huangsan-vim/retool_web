// Retool Video Platform - Main JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading for images
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
    
    // Search form enhancement
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchInput = this.querySelector('.search-input');
            if (!searchInput.value.trim()) {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }
    
    // Video card click handling
    const videoCards = document.querySelectorAll('.video-card');
    videoCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                const link = this.querySelector('.video-title a');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Active navigation highlighting
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
    
    // Video player initialization
    const videoPlayer = document.querySelector('.video-player');
    if (videoPlayer) {
        videoPlayer.addEventListener('loadedmetadata', function() {
            console.log('Video loaded successfully');
        });
        
        videoPlayer.addEventListener('error', function() {
            console.error('Error loading video');
            this.parentElement.innerHTML = '<div style="padding: 2rem; text-align: center; color: #ef4444;">Error loading video. Please try again later.</div>';
        });
    }
});

// Utility functions
function formatViews(views) {
    if (views >= 1000000) {
        return (views / 1000000).toFixed(1) + 'M';
    } else if (views >= 1000) {
        return (views / 1000).toFixed(1) + 'K';
    }
    return views.toString();
}

function formatDate(timestamp) {
    const date = new Date(timestamp * 1000);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);
    
    if (diff < 60) return 'Just now';
    if (diff < 3600) return Math.floor(diff / 60) + ' minutes ago';
    if (diff < 86400) return Math.floor(diff / 3600) + ' hours ago';
    if (diff < 604800) return Math.floor(diff / 86400) + ' days ago';
    
    return date.toLocaleDateString();
}

// API helper functions
async function fetchVideos(page = 1) {
    try {
        const response = await fetch(`/api/videos?page=${page}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching videos:', error);
        return null;
    }
}

async function fetchLatestVideos(limit = 12) {
    try {
        const response = await fetch(`/api/latest?limit=${limit}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching latest videos:', error);
        return null;
    }
}

async function searchVideos(keyword, page = 1) {
    try {
        const response = await fetch(`/api/search?q=${encodeURIComponent(keyword)}&page=${page}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error searching videos:', error);
        return null;
    }
}