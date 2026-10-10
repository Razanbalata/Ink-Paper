
FROM dunglas/frankenphp:php8.3

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    redis \
    zip

RUN apt-get update && apt-get install -y unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts
