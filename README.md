# Retool Video Platform - Refactored & Modernized

A modern, refactored video sharing platform built with PHP, featuring a clean MVC architecture, responsive design, and Docker deployment.

## 🚀 Features

- **Modern Architecture**: Clean MVC pattern with separation of concerns
- **Responsive Design**: Mobile-first, fully responsive UI
- **Video Management**: Browse, search, and watch videos
- **Category System**: Organized content by categories
- **Advertisement System**: Flexible ad placement system
- **API Endpoints**: RESTful API for programmatic access
- **SQLite Database**: Lightweight, file-based database
- **Docker Support**: Easy deployment with Docker and Docker Compose
- **Test Data**: Pre-populated with sample videos and content

## 📋 Requirements

- Docker and Docker Compose (recommended)
- OR PHP 8.2+ with SQLite extension
- OR Any web server (Apache/Nginx) with PHP support

## 🛠️ Installation & Deployment

### Method 1: Docker (Recommended)

1. **Build and run with Docker Compose:**
   ```bash
   cd refactored_retool
   docker-compose up -d --build
   ```

2. **Access the application:**
   - Open your browser and navigate to `http://localhost:8080`

3. **Stop the application:**
   ```bash
   docker-compose down
   ```

### Method 2: Manual Installation

1. **Install PHP 8.2+ with SQLite:**
   ```bash
   # On Ubuntu/Debian
   sudo apt-get install php8.2 php8.2-sqlite3 php8.2-fpm
   
   # On macOS with Homebrew
   brew install php@8.2
   ```

2. **Initialize the database:**
   ```bash
   cd refactored_retool
   php database/init.php
   ```

3. **Start PHP built-in server:**
   ```bash
   cd public
   php -S localhost:8080
   ```

4. **Access the application:**
   - Open your browser and navigate to `http://localhost:8080`

### Method 3: Production Deployment

For production deployment, use the provided Docker configuration or set up with Nginx/Apache:

**Nginx Configuration Example:**
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/refactored_retool/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 📁 Project Structure

```
refactored_retool/
├── public/                 # Public web root
│   ├── index.php          # Application entry point
│   └── assets/            # Static assets (CSS, JS, images)
├── src/                   # Application source code
│   ├── Controllers/       # Request handlers
│   ├── Models/           # Data models
│   ├── Views/            # View templates
│   └── Config/           # Configuration files
├── database/             # Database files
│   ├── schema.sql        # Database schema
│   ├── seed.php          # Test data seeder
│   ├── init.php          # Database initialization
│   └── retool.db         # SQLite database file
├── docker/               # Docker configuration
│   ├── nginx.conf        # Nginx configuration
│   ├── default.conf      # Site configuration
│   └── supervisord.conf  # Supervisor configuration
├── Dockerfile            # Docker image definition
├── docker-compose.yml    # Docker Compose configuration
└── README.md            # This file
```

## 🎯 Key Features Explained

### Video Management
- Browse all videos with pagination
- View individual video details with player
- Search videos by title, description, or tags
- Filter videos by category
- View count tracking

### Category System
- Multiple video categories
- Category-based filtering
- Easy navigation between categories

### Advertisement System
- Multiple ad positions (header, sidebar, footer, video list)
- Flexible ad management
- Support for image-based ads with links

### API Endpoints
- `GET /api/videos` - List all videos
- `GET /api/video/{id}` - Get single video
- `GET /api/categories` - List all categories
- `GET /api/search?q={keyword}` - Search videos
- `GET /api/latest?limit={n}` - Get latest videos
- `GET /api/popular?limit={n}` - Get popular videos

## 🔧 Configuration

Edit `src/Config/config.php` to customize:

```php
return [
    'database' => [
        'driver' => 'sqlite',
        'path' => __DIR__ . '/../../database/retool.db',
    ],
    'app' => [
        'name' => 'Retool Video Platform',
        'url' => 'http://localhost:8080',
        'debug' => true,
    ],
    'pagination' => [
        'videos_per_page' => 24,
    ],
    // ... more configuration options
];
```

## 📊 Database Schema

The application uses SQLite with the following main tables:

- **videos**: Stores video information (title, description, URL, thumbnail, etc.)
- **categories**: Video categories
- **advertisements**: Advertisement data
- **users**: User accounts (for future admin functionality)
- **site_config**: Site-wide configuration

## 🎨 Customization

### Styling
- Edit `assets/css/style.css` to customize the appearance
- CSS variables are defined in `:root` for easy theming

### Adding Videos
- Use the database seeder to add more test data
- Or manually insert into the `videos` table

### Adding Categories
- Insert into the `categories` table
- Update navigation automatically reflects changes

## 🔐 Security Features

- SQL injection prevention with prepared statements
- XSS protection with output escaping
- CSRF protection ready (can be implemented)
- Secure headers configured in Nginx
- Input validation and sanitization

## 📈 Performance Optimization

- Lazy loading for images
- Gzip compression enabled
- Static asset caching
- Database query optimization
- Efficient pagination

## 🐛 Troubleshooting

### Database Issues
```bash
# Reinitialize database
rm database/retool.db
php database/init.php
```

### Permission Issues
```bash
# Fix permissions
chmod -R 755 refactored_retool
chmod -R 777 refactored_retool/database
chmod -R 777 refactored_retool/cache
```

### Docker Issues
```bash
# Rebuild containers
docker-compose down
docker-compose up -d --build --force-recreate
```

## 📝 Development

### Adding New Features

1. **Create a new model** in `src/Models/`
2. **Create a controller** in `src/Controllers/`
3. **Add routes** in `public/index.php`
4. **Create views** in `src/Views/`

### Database Migrations

To modify the database schema:
1. Update `database/schema.sql`
2. Run `php database/init.php` to recreate the database

## 🤝 Contributing

This is a demo/refactored project. Feel free to:
- Fork and modify for your needs
- Report issues or suggestions
- Submit improvements

## 📄 License

This project is open source and available for educational and commercial use.

## 🙏 Acknowledgments

- Original project: Retool Web Package
- Refactored and modernized with clean architecture
- Built with modern PHP best practices

## 📞 Support

For questions or issues:
- Check the troubleshooting section
- Review the code comments
- Examine the example implementations

---

**Built with ❤️ using PHP, SQLite, and modern web technologies**