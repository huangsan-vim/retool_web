-- Refactored Retool Web Database Schema (SQLite)
-- Created: 2025-10-21

-- Videos table
CREATE TABLE IF NOT EXISTS videos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(500),
    video_url VARCHAR(500),
    category VARCHAR(100),
    tags TEXT,
    views INTEGER DEFAULT 0,
    duration VARCHAR(20),
    status INTEGER DEFAULT 1,
    created_at INTEGER NOT NULL,
    updated_at INTEGER NOT NULL
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    display_order INTEGER DEFAULT 0,
    created_at INTEGER NOT NULL
);

-- Advertisements table
CREATE TABLE IF NOT EXISTS advertisements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    position VARCHAR(50) NOT NULL,
    image_url VARCHAR(500),
    link_url VARCHAR(500),
    display_order INTEGER DEFAULT 0,
    status INTEGER DEFAULT 1,
    created_at INTEGER NOT NULL,
    updated_at INTEGER NOT NULL
);

-- Users table (for admin)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    role VARCHAR(50) DEFAULT 'admin',
    created_at INTEGER NOT NULL
);

-- Site configuration table
CREATE TABLE IF NOT EXISTS site_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    config_key VARCHAR(100) NOT NULL UNIQUE,
    config_value TEXT,
    updated_at INTEGER NOT NULL
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_videos_status ON videos(status);
CREATE INDEX IF NOT EXISTS idx_videos_created ON videos(created_at DESC);
CREATE INDEX IF NOT EXISTS idx_videos_category ON videos(category);
CREATE INDEX IF NOT EXISTS idx_ads_position ON advertisements(position);
CREATE INDEX IF NOT EXISTS idx_ads_status ON advertisements(status);