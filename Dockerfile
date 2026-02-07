FROM php:8.2-apache

# Install system packages and PHP extensions required by the app (curl used server-side)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    mariadb-client \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    ca-certificates \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip curl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy composer files first to leverage layer caching (if present)
COPY composer.json composer.lock* /var/www/html/

# Install Composer and project dependencies (best-effort; may be skipped if vendor present)
RUN php -r "copy('https://getcomposer.org/installer','composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader --no-interaction --no-scripts || true; fi

# Copy remaining project files
COPY . /var/www/html

# Ensure uploads dir exists and set permissions
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/uploads

# Expose port 80 and run Apache
EXPOSE 80

CMD ["apache2-foreground"]
