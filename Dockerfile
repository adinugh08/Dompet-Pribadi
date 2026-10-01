FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev nginx

RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install && npm run build

COPY docker/nginx.conf /etc/nginx/sites-available/default

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

COPY scripts/00-laravel-deploy.sh /etc/profile.d/
RUN chmod +x scripts/00-laravel-deploy.sh

EXPOSE 10000

CMD service nginx start && php-fpm -D && bash scripts/00-laravel-deploy.sh && php artisan serve --host=0.0.0.0 --port=10000