FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    sqlite \
    sqlite-dev \
    bash

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Create application directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Create necessary directories
RUN mkdir -p /var/www/html/database \
    /var/www/html/cache \
    /var/www/html/public/uploads \
    /run/nginx \
    /var/log/supervisor

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/database \
    && chmod -R 777 /var/www/html/cache

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf

# Copy supervisor configuration
COPY docker/supervisord.conf /etc/supervisord.conf

# Create startup script that initializes database on first run
RUN echo '#!/bin/bash' > /startup.sh && \
    echo 'if [ ! -f /var/www/html/database/retool.db ]; then' >> /startup.sh && \
    echo '  echo "Initializing database..."' >> /startup.sh && \
    echo '  php /var/www/html/database/init.php' >> /startup.sh && \
    echo '  chown www-data:www-data /var/www/html/database/retool.db' >> /startup.sh && \
    echo '  chmod 666 /var/www/html/database/retool.db' >> /startup.sh && \
    echo 'fi' >> /startup.sh && \
    echo 'exec /usr/bin/supervisord -c /etc/supervisord.conf' >> /startup.sh && \
    chmod +x /startup.sh

# Expose port
EXPOSE 80

# Start with initialization script
CMD ["/startup.sh"]