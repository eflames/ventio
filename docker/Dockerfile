# syntax=docker/dockerfile:1

# =============================================================================
# Imagen de producción para Ventio (Laravel 12 + PHP-FPM)
# Etapas:
#   1. assets  - Node compila los bundles CSS/JS (build.js, sin dependencias npm)
#   2. vendor  - Composer instala las dependencias de producción optimizadas
#   3. final   - PHP-FPM 8.3 con extensiones, código y permisos listos para usar
# =============================================================================

# ---------------------------------------------------------------- Etapa assets
FROM node:22-alpine AS assets

WORKDIR /build

COPY package.json build.js ./
COPY resources/js ./resources/js
COPY resources/css ./resources/css

RUN node build.js

# --------------------------------------------------------------- Etapa vendor
FROM php:8.3-cli-alpine AS vendor

RUN apk add --no-cache \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        intl \
        pdo_mysql \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
        --no-dev \
        --prefer-dist \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --no-autoloader

# Copiamos el código fuente para regenerar el autoloader optimizado
COPY app/ ./app/
COPY bootstrap/ ./bootstrap/
COPY config/ ./config/
COPY database/ ./database/
COPY lang/ ./lang/
COPY public/ ./public/
COPY resources/ ./resources/
COPY routes/ ./routes/
COPY artisan ./

RUN composer dump-autoload --optimize --no-dev --no-scripts

# ---------------------------------------------------------------- Etapa final
FROM php:8.3-fpm-alpine AS final

LABEL org.opencontainers.image.title="Ventio" \
      org.opencontainers.image.description="Ventio POS - Laravel 12 + PHP-FPM"

RUN apk add --no-cache --virtual .build-deps \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        intl \
        opcache \
        pdo_mysql \
        zip \
    && apk del .build-deps \
    && apk add --no-cache \
        mariadb-client \
        icu-libs \
        libzip \
        libpng \
        libjpeg-turbo \
        freetype

# Configuración PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-ventio.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/99-opcache.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-ventio.conf

WORKDIR /var/www/html

# Copiar vendor + código
COPY --from=vendor /app/vendor ./vendor
COPY --from=vendor /app/composer.json /app/composer.lock ./
COPY --from=vendor /app/artisan ./
COPY --from=vendor /app/app ./app
COPY --from=vendor /app/bootstrap ./bootstrap
COPY --from=vendor /app/config ./config
COPY --from=vendor /app/database ./database
COPY --from=vendor /app/lang ./lang
COPY --from=vendor /app/routes ./routes
COPY --from=vendor /app/resources ./resources

# Assets compilados (sobrescriben los bundles css/js de public/)
COPY --from=vendor /app/public ./public
COPY --from=assets /build/public ./public

# Directorios de trabajo y permisos
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        storage/app/backup-temp \
        bootstrap/cache \
        public/images \
        public/backups \
    && touch storage/logs/laravel.log \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
        public/images \
        public/backups

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD ["php-fpm"]
