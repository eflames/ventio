# Manual de uso y referencia — Ventio

> **Ventio** es un sistema POS (punto de venta) web para tiendas pequeñas:
> ventas, inventario por almacén, clientes, créditos (cuentas por cobrar y por
> pagar), gastos, reportes (HTML y PDF) y respaldo de base de datos.
>
> Este documento explica **cómo ejecutar el proyecto en cualquier computador**,
> cómo operarlo día a día y qué cambió en la migración de **Laravel 6 → Laravel 12**.

---

## Índice

1. [Requisitos](#1-requisitos)
2. [Instalación con Docker (recomendada)](#2-instalación-con-docker-recomendada)
3. [Instalación local sin Docker](#3-instalación-local-sin-docker)
4. [Primer arranque: licencia y usuarios](#4-primer-arranque-licencia-y-usuarios)
5. [Uso diario del sistema](#5-uso-diario-del-sistema)
6. [Configuración (variables de entorno)](#6-configuración-variables-de-entorno)
7. [Respaldos y restauración](#7-respaldos-y-restauración)
8. [Actualización y despliegue](#8-actualización-y-despliegue)
9. [Solución de problemas](#9-solución-de-problemas)
10. [Referencia de la migración Laravel 6 → 12](#10-referencia-de-la-migración-laravel-6--12)

---

## 1. Requisitos

### Con Docker (recomendada)

- **Docker Engine 24+** y **Docker Compose v2** (en Windows/Mac, Docker Desktop).
- 2 GB de RAM libres aproximados.
- No necesitas PHP, Composer ni Node instalados.

### Sin Docker (desarrollo)

| Herramienta | Versión |
|---|---|
| PHP | **8.3 o superior** |
| Extensiones PHP | `pdo_mysql` (o `pdo_sqlite`), `mbstring`, `xml`, `gd`, `zip`, `intl`, `bcmath` |
| Composer | 2.x |
| Node/npm | Solo si quieres regenerar assets (`npm run build`); los bundles ya vienen compilados |
| Base de datos | MySQL 5.7+/MariaDB 10.6+, o SQLite para pruebas |

---

## 2. Instalación con Docker (recomendada)

### Puesta en marcha

```bash
git clone git@github.com:isDOSe/ventio.git
cd ventio

# Construir e iniciar los tres servicios (app, web, db)
docker compose up -d --build
```

Al primer arranque, el contenedor `app` automáticamente:

1. Espera a que la base de datos esté disponible.
2. Ejecuta las migraciones (`php artisan migrate --force`).
3. Carga los datos iniciales (`php artisan db:seed --force`, idempotentes).
4. Cachea configuración, rutas y vistas cuando `APP_ENV=production`.

Después abre **http://localhost:8080** y continúa con el
[primer arranque](#4-primer-arranque-licencia-y-usuarios).

> Si prefieres otro puerto: `APP_PORT=9000 docker compose up -d`.

### Servicios

| Servicio | Imagen | Puerto | Descripción |
|---|---|---|---|
| `app` | `ventio:latest` (PHP-FPM 8.3-alpine) | 9000 (interno) | Laravel + extensiones gd/zip/intl/opcache + cliente mariadb para backups |
| `web` | `ventio-web:latest` (nginx 1.27) | **8080 → 80** | Sirve estáticos y delega PHP a `app:9000` |
| `db` | `mariadb:11.4` | 3306 (interno) | Base de datos con volumen persistente |

### Datos persistentes (volúmenes)

| Volumen | Contenido |
|---|---|
| `ventio_db-data` | Base de datos MariaDB |
| `ventio_app-storage` | Sesiones, cachés, logs, vistas compiladas |
| `ventio_app-bootstrap` | Manifest de paquetes y cachés de config/rutas |
| `ventio_app-backups` | Respaldos `.zip` (visible en la web en `/backups`) |

Para borrar **todo** (incluida la base de datos): `docker compose down -v`.

### Comandos útiles

```bash
docker compose ps                          # estado de los servicios
docker compose logs -f app                 # logs en vivo de la aplicación
docker compose exec app php artisan tinker # consola interactiva de Laravel
docker compose exec app sh                 # shell dentro del contenedor
docker compose exec db mariadb -uventio -psecret ventio   # cliente SQL
docker compose down                        # detener
docker compose up -d                       # volver a iniciar
```

> **Importante:** el código y los assets están "horneados" en la imagen. Tras
> editar código PHP o vistas hay que reconstruir:
>
> ```bash
> docker compose build app web && docker compose up -d
> ```

---

## 3. Instalación local sin Docker

### Opción A — con MySQL/MariaDB

```bash
composer install
cp .env.example .env
php artisan key:generate

# Edita .env con tus credenciales:
#   DB_HOST=127.0.0.1  DB_PORT=3306
#   DB_DATABASE=ventio DB_USERNAME=ventio DB_PASSWORD=...
mysql -u root -e "CREATE DATABASE ventio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

php artisan migrate --seed
php artisan serve        # http://127.0.0.1:8000
```

### Opción B — con SQLite (pruebas rápidas, sin servidor de BD)

```bash
composer install
cp .env.example .env
php artisan key:generate

# En .env deja únicamente:
#   DB_CONNECTION=sqlite
touch database/database.sqlite

php artisan migrate --seed
php artisan serve        # http://127.0.0.1:8000
```

> El repositorio incluye ya los bundles CSS/JS compilados en `public/`
> (`ventio-styles.css`, `ventio-icons.css`, `ventio-scripts.js`). Si cambias
> algo en `resources/js` o `resources/css`, regenéralos con `npm run build`
> (el script `build.js` no necesita dependencias npm).

---

## 4. Primer arranque: licencia y usuarios

### 1. Instalar la licencia

Ventio usa una llave de licencia instalada desde la web. Sin licencia, al
abrir `http://localhost:8080` serás redirigido a **`/license`**.

La licencia es un texto cifrado con la `APP_KEY` del proyecto, con el formato
interno `NOMBRE DEL NEGOCIO-Ernesto Flames-DD/MM/YYYY` (vence en la fecha
indicada). Para generar una y pegarla en el formulario:

```bash
# Con Docker
docker compose exec app php artisan tinker --execute="echo encrypt('Mi Tienda-Ernesto Flames-01/01/2100');"

# Sin Docker
php artisan tinker --execute="echo encrypt('Mi Tienda-Ernesto Flames-01/01/2100');"
```

Copia el resultado (`eyJpdiI6...`) y pégalo en el campo de `/license`.
La fecha de vencimiento queda codificada en el hash.

> ⚠️ La licencia se descifra con la `APP_KEY`. Si cambias la `APP_KEY`
> (o regeneras el contenedor sin `APP_KEY` fija), la licencia deja de ser
> válida y hay que reinstalarla.

### 2. Entrar al sistema

Usuario semilla creado por el seeder:

| Campo | Valor |
|---|---|
| Correo | `ernesto@ernestoflames.com` |
| Contraseña | `123456` |
| Rol | **Superadmin** (todos los permisos) |

> **Cambia esta contraseña** en *Mi perfil* antes de usar el sistema en producción.

### 3. Roles y permisos

El seeder crea 4 roles; cada permiso se controla con los checkboxes
`p_*` de la tabla `roles`:

| Rol | Permisos |
|---|---|
| Superadmin | Todos (vender, ventas, inventario, clientes, créditos, reportes, descuentos, usuarios, configuración) |
| Admin | Todo excepto gestión de usuarios |
| Vendedor | Vender, ventas, inventario, clientes, créditos, reportes |
| Consulta | Solo lectura de ventas/inventario/clientes/créditos/reportes |

Crea más usuarios (con su rol) desde **Usuarios** dentro del sistema.

---

## 5. Uso diario del sistema

Al iniciar sesión llegas al **panel (Inicio)** con el gráfico de ventas de los
últimos 6 meses. Menú principal según permisos:

- **Nueva venta**: busca productos, agrega ítems, cobra con uno o varios
  métodos de pago (efectivo, punto de venta, crédito), aplica descuentos,
  imprime/registra la venta.
- **Ventas**: listado con filtros, edición de ventas abiertas, devoluciones
  de ítems, abonos y cierre.
- **Inventario → Productos**: alta/edición de productos y categorías,
  importación masiva por CSV (plantilla en *Importar*).
- **Inventario → Stock**: existencias por almacén, entradas rápidas de
  cantidad, transferencias entre almacenes, precios y stock mínimo con
  alerta y reporte PDF.
- **Clientes**: fichas, historial, notificación de crédito por correo.
- **Créditos**: cuentas por cobrar (préstamos a clientes) y por pagar,
  con pagos parciales y cierre.
- **Gastos**: registro de salidas de dinero por categoría/fecha.
- **Reportes**: por fecha, cliente, producto, tipo, crédito, gastos,
  ganancia, comisiones, categoría, devoluciones, stock y cambios de
  inventario — en pantalla y en PDF (tamaño carta).
- **Configuración**: datos de la tienda (nombre, correo, logo — se
  redimensiona automáticamente), tasa de cambio, % de comisión,
  modos avanzados y respaldo de base de datos (botón *Sistema → Backup DB*).
- **Sistema → Export to WooCommerce**: exporta el catálogo a CSV compatible.

---

## 6. Configuración (variables de entorno)

### Con Docker

Docker Compose define las variables en `docker-compose.yml` y toma sus
valores del archivo **`.env` de la raíz del proyecto** si existe (sí: el
mismo `.env` de Laravel; úsalo para personalizar el stack).

Variables principales (todas con valores por defecto sensatos):

| Variable | Por defecto | Descripción |
|---|---|---|
| `APP_PORT` | `8080` | Puerto público de nginx |
| `APP_ENV` | `production` | Entorno (`production` cachea config/rutas/vistas) |
| `APP_KEY` | clave incluida | **⚠️ Cámbiala en producción** (`base64:...`) |
| `APP_DEBUG` | `false` | Muestra errores detallados |
| `APP_URL` | `http://localhost:8080` | URL pública (enlaces de correos, logo) |
| `DB_DATABASE` | `ventio` | Nombre de la BD |
| `DB_USERNAME` | `ventio` | Usuario de la BD |
| `DB_PASSWORD` | `secret` | Contraseña de la BD |
| `DB_ROOT_PASSWORD` | `root_secret` | Contraseña root de MariaDB |
| `RUN_MIGRATIONS` | `true` | Ejecuta migraciones+seeds al arrancar |
| `VENTIO_VERSION` | `v2.0.0` | Texto de versión mostrado en la UI |
| `MAIL_MAILER` | `log` | `smtp` + `MAIL_HOST/PORT/USERNAME/PASSWORD` para enviar correos |
| `CACHE_STORE` | `file` | `file`, `database` o `redis` |
| `SESSION_DRIVER` | `file` | `file` o `database` |

Generar una `APP_KEY` nueva:

```bash
docker compose exec app php artisan key:generate --show
# o sin contenedor:
php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"
```

### Sin Docker

Usa el `.env` copiado de `.env.example` (ya documentado con las claves
actuales: `MAIL_MAILER`, `CACHE_STORE`, `VENTIO_VERSION`, etc.).

---

## 7. Respaldos y restauración

### Crear respaldo

- **Desde la web**: *Sistema → Backup DB* (permiso de configuración) —
  descarga el zip directamente.
- **Por consola**:

```bash
docker compose exec app php artisan backup:run            # archivos + BD
docker compose exec app php artisan backup:run --only-db  # solo BD
docker compose exec app php artisan backup:clean          # aplicar política de borrado
docker compose exec app php artisan backup:monitor        # estado de salud
```

Los zip quedan en el volumen `app-backups` → **`public/backups/Ventio/`**
(accesibles también por web en `/backups/...`). Política de limpieza
configurada en `config/backup.php`: 7 días completos, luego 16 diarios,
8 semanales, 4 mensuales, 2 anuales, tope de 5000 MB.

El zip contiene el volcado en `db-dumps/mysql-ventio.sql`.

### Restaurar

```bash
# 1. Extraer el SQL del zip
docker compose exec app sh -c \
  "unzip -o /var/www/html/public/backups/Ventio/backup-FECHA.zip -d /tmp/bk"

# 2. Importar a la base de datos
docker compose exec app sh -c \
  "mariadb -h db -uventio -psecret ventio < /tmp/bk/db-dumps/mysql-ventio.sql"
```

> ⚠️ La licencia vive en la tabla `system` y está cifrada con la `APP_KEY`:
> restaura siempre en un proyecto con la **misma** `APP_KEY`.

---

## 8. Actualización y despliegue

### Ciclo de actualización del código (Docker)

```bash
git pull
docker compose build app web
docker compose up -d          # el entrypoint aplica migraciones nuevas
```

### Checklist de producción

1. `APP_KEY` propia (no la del compose).
2. `APP_DEBUG=false`, `APP_ENV=production`.
3. `DB_PASSWORD` y `DB_ROOT_PASSWORD` fuertes.
4. `APP_URL` con el dominio real (y HTTPS si se expone; poner un proxy TLS
   delante de nginx).
5. Cambiar la contraseña del usuario semilla.
6. Correo real (`MAIL_MAILER=smtp`, `MAIL_HOST=...`) si se usan notificaciones.
7. Configurar copias del volumen `db-data` fuera del servidor (o `backup:run`
   hacia un disco remoto/S3 en `config/backup.php`).

### Despliegue en otra máquina (sin git)

```bash
docker save ventio:latest ventio-web:latest | gzip > ventio-images.tar.gz
# en el destino:
docker load < ventio-images.tar.gz
docker compose up -d        # usa las imágenes locales, no recompila
```

---

## 9. Solución de problemas

| Síntoma | Causa probable | Solución |
|---|---|---|
| `File not found.` en todas las rutas | `app` y `web` con versiones distintas de `public/` | `docker compose build app web && docker compose up -d` |
| Todo 404 tras desplegar | caché de rutas vieja | `docker compose exec app php artisan optimize:clear` (o recrear contenedor) |
| `GET /login → 302 /license` en bucle | Licencia vencida o `APP_KEY` cambió | Reinstalar licencia en `/license` con un hash nuevo |
| La licencia no se instala | El hash no se pegó completo o expiró la fecha | Regenerar el hash y pegarlo de una sola línea |
| Backup falla con error de SSL/`mysqldump` | Cliente incompatible con el servidor | El stack ya usa `mariadb-client` ↔ `mariadb:11.4` con `ssl_flag: skip-ssl` — verifica no haber cambiado la imagen de BD |
| `could not find driver` | Falta `pdo_mysql`/`pdo_sqlite` en PHP local | Instalar/extender la extensión (con Docker no ocurre) |
| Permisos denegados en `storage/` | Propietario incorrecto | `docker compose exec app chown -R www-data:www-data storage bootstrap/cache public/images public/backups` |
| Sesiones se pierden al reiniciar | `SESSION_DRIVER=file` y volumen recreado | Es normal; usa `down` sin `-v` para conservar volúmenes |
| Correos no salen | `MAIL_MAILER=log` | Configurar SMTP real |
| Local: `.env` con `APP_ENV=local` cambia el comportamiento de Compose | Compose lee el `.env` raíz para interpolar variables | Para forzar producción: `APP_ENV=production docker compose up -d` |

Logs:

```bash
docker compose logs app web db       # logs de contenedores
docker compose exec app tail -f storage/logs/laravel.log
tail -f storage/logs/laravel.log     # sin Docker
```

---

## 10. Referencia de la migración Laravel 6 → 12

### 10.1 Stack resultante

| Componente | Antes | Ahora |
|---|---|---|
| Laravel | 6.x | **12.69** |
| PHP | 7.2+ | **8.3+** (fijado con `config.platform.php` en `composer.json`) |
| PHPUnit | 8 | 11 |
| Frontend build | laravel-mix (webpack) | **`build.js`** (Node puro, sin dependencias) |
| BD en Docker | — | MariaDB 11.4 (compatible con el cliente `mariadb-client` de la imagen) |

### 10.2 Dependencias Composer

| Paquete | Antes | Ahora | Nota |
|---|---|---|---|
| `laravel/framework` | ^6.0 | ^12.0 | |
| `laravel/tinker` | ^1.0 | ^3.0 | |
| `artesaos/seotools` | ^0.17.2 | ^1.4 | API compatible (`SEOMeta::`, `SEO::generate`) |
| `barryvdh/laravel-dompdf` | ^0.8.3 | ^3.1 | Import actualizado a `Barryvdh\DomPDF\Facade\Pdf` |
| `barryvdh/laravel-debugbar` | ^3.2 | ^4.4 (dev) | |
| `barryvdh/laravel-ide-helper` | ^2.5 | ^3.7 (dev) | |
| `intervention/image` | ^2.4 | `intervention/image-laravel` ^4.1 | `Image::make()` → `Image::read()`, `resize+aspectRatio` → `scale()` |
| `laravelcollective/html` | ^6.0 (abandonado) | **`nekhbet/laravel-collective-html` ^1.0** | Fork mantenido, mismo namespace `Collective\Html` — las ~110 vistas con `Form::` no se tocaron |
| `spatie/laravel-backup` | ^6.9 | ^10.3 | Eventos/notificaciones renombradas; `notifiable` obligatorio; `ssl_flag: skip-ssl` en el dump |
| `yajra/laravel-datatables` | ^1.0 | ^12.0 | |
| `fideloper/proxy` | ^4.0 | **eliminado** | `trustProxies()` nativo en `bootstrap/app.php` |
| `fzaninotto/faker` | ^1.4 | `fakerphp/faker` | |
| `beyondcode/laravel-dump-server` | ^1.0 | **eliminado** | Obsoleto |

### 10.3 Estructura (archivos nuevos / movidos / eliminados)

**Nuevos**

```
bootstrap/app.php            Configuración central (middleware, aliases, excepciones, rutas)
bootstrap/providers.php      Registro de providers de la app
build.js                     Build de assets (reemplaza a webpack.mix.js)
database/seeders/            Namespace Database\Seeders (antes database/seeds) + SystemTableSeeder
docker/Dockerfile            Imagen app (3 etapas: assets → composer → php-fpm)
docker/web/Dockerfile        Imagen nginx con public/ incluido
docker/nginx/default.conf    Virtual host Laravel
docker/php/{php.ini,opcache.ini,www.conf}
docker/entrypoint.sh         Espera BD → migrate → seed → cache → php-fpm
docker-compose.yml           app + web + db(mariadb) + volúmenes
.dockerignore
MANUAL.md                    Este manual
```

**Movidos**

```
app/User.php                        → app/Models/User.php   (namespace App\Models; ~75 referencias actualizadas)
database/seeds/*                    → database/seeders/*
resources/lang/*                    → lang/*                (ubicación estándar desde Laravel 9)
app/Providers/VentioCustomServerProvider.php → VentioSearchServiceProvider.php
```

**Eliminados** (funcionalidad migrada al framework o muerta)

```
app/Http/Kernel.php                 → bootstrap/app.php
app/Console/Kernel.php              → bootstrap/app.php + routes/console.php
app/Exceptions/Handler.php          → bootstrap/app.php (withExceptions)
app/Providers/RouteServiceProvider.php → bootstrap/app.php (withRouting)
app/Providers/BroadcastServiceProvider.php, routes/channels.php   (broadcasting no usado)
server.php, webpack.mix.js, public/mix-manifest.json
app/Http/Middleware/{CheckForMaintenanceMode,TrustProxies,EncryptCookies,TrimStrings,VerifyCsrfToken}.php
app/Http/Controllers/Auth/{Register,ForgotPassword,Reset,Verification}Controller.php  (traits eliminados del framework; no estaban enrutados)
config/maileclipse.php              (config huérfana de un paquete no instalado)
```

### 10.4 Cambios de código destacados

- **~160 rutas** convertidas de `'Controller@método'` a `[Controller::class, 'método']`.
- **`LoginController` reescrito** sin `AuthenticatesUsers` (eliminado del framework
  desde Laravel 10): validación, `Auth::attempt`, regeneración de sesión y logout seguro.
- **`ImageUtil`** adaptado a intervention/image v4 (`read()`, `scale()`, `save(public_path(...))`).
- **`ChartUtils`**: `format('F')` → `translatedFormat('F')` (Carbon 3 ya no localiza `format()`).
- **Middleware** actualizados a firmas modernas (`Request`/`Response` tipadas);
  `Authenticate::redirectTo(): ?string`; `RedirectIfAuthenticated` ahora redirige a `/`.
- **Seeders** idempotentes (`insertOrIgnore`) y con namespace — seguros para
  ejecutarse en cada arranque del contenedor. Nuevo `SystemTableSeeder` crea la
  fila de licencia (`system.id = 1`) necesaria para instalaciones limpias.
- **Rutas "api"**: se registran con middleware `web` + prefijo `api` (igual que
  antes: autenticación por sesión/CSRF desde el frontend con jQuery).
- **`PermissionPolicy`** sigue mapeada a `App\Models\User` vía `Gate::policy()`
  (los `@can(..., User::class)` de las vistas funcionan igual).
- **phpunit.xml** al esquema de PHPUnit 11; test de humo `test_home_redirects_guests_to_login`.
- **`public/index.php`** al estilo Laravel 12 (`$app->handleRequest()`).

### 10.5 Validaciones realizadas

- `composer validate` ✓ · `php artisan test` ✓ · `view:cache` (todas las vistas) ✓
- `config:cache`, `route:cache` ✓ · 202 rutas registradas ✓
- E2E en Docker: licencia → login → dashboard/reportes/stock → PDF → API → `backup:run` ✓
- Reinicio de contenedor: migraciones/seeds idempotentes ✓
