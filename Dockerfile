FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    curl git unzip libzip-dev libpq-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    npm nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) zip pdo pdo_mysql pdo_pgsql bcmath gd \
    && docker-php-ext-enable zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app

RUN cd hob && composer install --no-dev --no-interaction --prefer-dist
RUN cd hob && npm ci && npm run build 2>/dev/null || true
RUN cd hob && php artisan config:cache && php artisan route:cache

EXPOSE 8000
ENTRYPOINT ["/bin/sh", "-c"]
CMD ["cd hob && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
