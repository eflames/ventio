#!/bin/sh
set -e

# -----------------------------------------------------------------------------
# Entrypoint del contenedor de Ventio
# 1. Espera a que la base de datos esté disponible (solo MySQL/MariaDB)
# 2. Ejecuta migraciones y seeds (si RUN_MIGRATIONS=true)
# 3. Cachea config/rutas/vistas cuando APP_ENV=production
# 4. Arranca php-fpm
# -----------------------------------------------------------------------------

if [ "${DB_CONNECTION:-mysql}" != "sqlite" ] && [ -n "${DB_HOST:-}" ]; then
    echo "> Esperando a la base de datos ${DB_HOST}:${DB_PORT:-3306}..."
    i=0
    until php -r '
        try {
            new PDO(
                sprintf("mysql:host=%s;port=%s", getenv("DB_HOST"), getenv("DB_PORT") ?: "3306"),
                getenv("DB_USERNAME"),
                getenv("DB_PASSWORD"),
                [PDO::ATTR_TIMEOUT => 3]
            );
            exit(0);
        } catch (Throwable $e) {
            exit(1);
        }
    ' >/dev/null 2>&1; do
        i=$((i + 1))
        if [ "$i" -ge 30 ]; then
            echo "> ERROR: no se pudo conectar a la base de datos tras 90s" >&2
            exit 1
        fi
        sleep 3
    done
    echo "> Base de datos disponible."
fi

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "> Ejecutando migraciones..."
    php artisan migrate --force

    echo "> Ejecutando seeds (idempotentes)..."
    php artisan db:seed --force
fi

if [ "${APP_ENV:-production}" = "production" ]; then
    echo "> Cacheando configuración, rutas y vistas..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

exec "$@"
