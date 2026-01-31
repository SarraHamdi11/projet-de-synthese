FROM php:8.1-cli

WORKDIR /app

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app files
COPY . /app/

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 10000

# Start server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
