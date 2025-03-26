# Use official PHP image with extensions
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies including netcat-openbsd (alternative to netcat)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    default-mysql-client \
    netcat-openbsd \
    && rm -rf /var/lib/apt/lists/*  # Clean up cache to reduce image size

# Install GD and PDO extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Copy entrypoint script and make it executable
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port 8000
EXPOSE 8000

# Run entrypoint script
ENTRYPOINT ["/entrypoint.sh"]
