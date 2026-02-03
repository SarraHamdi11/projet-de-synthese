FROM php:8.2-cli

RUN apt-get update && apt-get install -y curl git unzip libzip-dev libpq-dev libpng-dev libjpeg-dev libfreetype6-dev npm nodejs && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-configure zip && \
    docker-php-ext-install -j$(nproc) zip pdo pdo_mysql pdo_pgsql bcmath gd && \
    docker-php-ext-enable zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /app
WORKDIR /app/hob

RUN /usr/local/bin/composer install --no-dev --no-interaction --prefer-dist
RUN npm ci && npm run build 2>/dev/null || true
RUN php artisan config:cache && php artisan route:cache

RUN chmod +x /app/start.sh

EXPOSE 8000

CMD ["/app/start.sh"]
