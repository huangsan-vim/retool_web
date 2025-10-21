# Deployment Guide - Retool Video Platform

## 🚀 Quick Start Deployment

### Option 1: Docker Deployment (Recommended)

**Prerequisites:**
- Docker installed
- Docker Compose installed

**Steps:**

1. **Clone or extract the project:**
   ```bash
   cd refactored_retool
   ```

2. **Build and start the containers:**
   ```bash
   docker-compose up -d --build
   ```

3. **Verify deployment:**
   ```bash
   docker-compose ps
   docker-compose logs -f
   ```

4. **Access the application:**
   - Local: `http://localhost:8080`
   - Production: `http://your-domain.com`

5. **Stop the application:**
   ```bash
   docker-compose down
   ```

### Option 2: Manual Deployment with PHP Built-in Server

**Prerequisites:**
- PHP 8.2 or higher
- SQLite extension enabled

**Steps:**

1. **Navigate to project directory:**
   ```bash
   cd refactored_retool
   ```

2. **Initialize database:**
   ```bash
   php database/init.php
   ```

3. **Start PHP server:**
   ```bash
   cd public
   php -S 0.0.0.0:8080
   ```

4. **Access the application:**
   - `http://localhost:8080`

### Option 3: Production Deployment with Nginx

**Prerequisites:**
- Ubuntu/Debian server
- Nginx installed
- PHP 8.2-FPM installed
- Domain name (optional)

**Steps:**

1. **Install required packages:**
   ```bash
   sudo apt update
   sudo apt install -y nginx php8.2-fpm php8.2-sqlite3 php8.2-cli
   ```

2. **Copy project files:**
   ```bash
   sudo mkdir -p /var/www/retool
   sudo cp -r refactored_retool/* /var/www/retool/
   ```

3. **Set permissions:**
   ```bash
   sudo chown -R www-data:www-data /var/www/retool
   sudo chmod -R 755 /var/www/retool
   sudo chmod -R 777 /var/www/retool/database
   sudo chmod -R 777 /var/www/retool/cache
   ```

4. **Initialize database:**
   ```bash
   cd /var/www/retool
   sudo -u www-data php database/init.php
   ```

5. **Create Nginx configuration:**
   ```bash
   sudo nano /etc/nginx/sites-available/retool
   ```

   Add the following configuration:
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;  # Change this
       root /var/www/retool/public;
       index index.php index.html;

       access_log /var/log/nginx/retool_access.log;
       error_log /var/log/nginx/retool_error.log;

       # Security headers
       add_header X-Frame-Options "SAMEORIGIN" always;
       add_header X-Content-Type-Options "nosniff" always;
       add_header X-XSS-Protection "1; mode=block" always;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
           fastcgi_read_timeout 300;
       }

       location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
           expires 1y;
           add_header Cache-Control "public, immutable";
       }

       location ~ /\. {
           deny all;
       }
   }
   ```

6. **Enable the site:**
   ```bash
   sudo ln -s /etc/nginx/sites-available/retool /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   sudo systemctl restart php8.2-fpm
   ```

7. **Configure SSL (Optional but recommended):**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

## 🔧 Configuration

### Environment-Specific Configuration

Edit `src/Config/config.php` for your environment:

```php
return [
    'app' => [
        'name' => 'Your Site Name',
        'url' => 'https://your-domain.com',
        'debug' => false,  // Set to false in production
    ],
    // ... other settings
];
```

### Database Configuration

The application uses SQLite by default. To use a different database:

1. Update `src/Config/config.php`
2. Modify `src/Models/Database.php` connection string
3. Update schema if needed

## 📊 Post-Deployment Checklist

- [ ] Database initialized successfully
- [ ] All file permissions set correctly
- [ ] Web server running and accessible
- [ ] Static assets loading (CSS, JS, images)
- [ ] Video playback working
- [ ] Search functionality working
- [ ] Category navigation working
- [ ] API endpoints responding
- [ ] Error logs configured
- [ ] Backup strategy in place

## 🔐 Security Hardening

### Production Security Checklist

1. **Disable debug mode:**
   ```php
   'debug' => false,
   ```

2. **Set proper file permissions:**
   ```bash
   chmod 755 /var/www/retool
   chmod 644 /var/www/retool/public/index.php
   chmod 600 /var/www/retool/src/Config/config.php
   ```

3. **Configure firewall:**
   ```bash
   sudo ufw allow 80/tcp
   sudo ufw allow 443/tcp
   sudo ufw enable
   ```

4. **Regular updates:**
   ```bash
   sudo apt update && sudo apt upgrade
   ```

5. **Backup database regularly:**
   ```bash
   cp /var/www/retool/database/retool.db /backup/retool_$(date +%Y%m%d).db
   ```

## 🐛 Troubleshooting

### Common Issues

**Issue: 500 Internal Server Error**
- Check PHP error logs: `tail -f /var/log/nginx/retool_error.log`
- Verify file permissions
- Check PHP-FPM status: `sudo systemctl status php8.2-fpm`

**Issue: Database not found**
- Run: `php database/init.php`
- Check database file permissions

**Issue: Static assets not loading**
- Verify Nginx configuration
- Check file paths in HTML
- Clear browser cache

**Issue: Videos not playing**
- Check video URLs in database
- Verify CORS settings if videos are external
- Test video URLs directly in browser

## 📈 Performance Optimization

### Production Optimizations

1. **Enable OPcache:**
   ```bash
   sudo nano /etc/php/8.2/fpm/php.ini
   ```
   Add:
   ```ini
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.max_accelerated_files=10000
   ```

2. **Configure Nginx caching:**
   ```nginx
   location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
       expires 1y;
       add_header Cache-Control "public, immutable";
   }
   ```

3. **Enable Gzip compression:**
   ```nginx
   gzip on;
   gzip_types text/plain text/css application/json application/javascript;
   ```

## 🔄 Updates and Maintenance

### Updating the Application

1. **Backup current installation:**
   ```bash
   cp -r /var/www/retool /backup/retool_backup_$(date +%Y%m%d)
   ```

2. **Update files:**
   ```bash
   # Copy new files
   sudo cp -r new_version/* /var/www/retool/
   ```

3. **Update database if needed:**
   ```bash
   php database/migrate.php
   ```

4. **Restart services:**
   ```bash
   sudo systemctl restart nginx
   sudo systemctl restart php8.2-fpm
   ```

## 📞 Support

For deployment issues:
1. Check logs: `/var/log/nginx/` and PHP error logs
2. Review configuration files
3. Verify all prerequisites are met
4. Test with minimal configuration first

---

**Deployment completed successfully? Great! Your Retool Video Platform is now live! 🎉**