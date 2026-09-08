# syntax=docker/dockerfile:1

# Imagen de nginx para Ventio: incluye el directorio public/ estático.
# IMPORTANTE: el contenido debe coincidir con el del contenedor "app"
# (misma ruta /var/www/html/public) para que fastCGI resuelva bien los scripts.

FROM nginx:1.27-alpine

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY public /var/www/html/public
