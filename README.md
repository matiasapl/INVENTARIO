# INVENTARIO

Aplicación web de gestión de inventario con Laravel 12, React 19 e Inertia.js. Es un proyecto de portafolio en desarrollo; no usar para administrar inventario real ni introducir datos sensibles.

## Funcionalidades

- Gestión de productos y almacenes.
- Lotes vinculados a productos y almacenes, con cantidades.
- Registro de operaciones de inventario.
- Registro individual, autenticación con Laravel Fortify y segundo factor opcional.
- Landing pública con capturas sintéticas para explorar el proyecto.

El registro de operaciones no equivale a una auditoría completa de todos los eventos de la aplicación ni a una certificación de seguridad.

## Tecnologías

- PHP `^8.2`, Laravel `^12.0`, Fortify e Inertia Laravel.
- React 19, TypeScript, Tailwind CSS 4 e Inertia React.
- MariaDB; Docker Compose usa MariaDB 10.11.
- Node.js `^20.19.0` o `>=22.12.0` y npm, según la versión de Vite fijada en `inventario/package-lock.json`.

## Instalación local

El código de la aplicación está dentro de `inventario/`. Ejecuta los comandos siguientes desde esa carpeta:

```bash
git clone https://github.com/matiasapl/INVENTARIO.git
cd INVENTARIO/inventario
composer install
cp .env.example .env
php artisan key:generate
```

Configura en `.env` una base de datos MariaDB local y desechable. Para ejecutar Laravel fuera de Docker, configura el host y puerto de MariaDB accesibles desde tu máquina, por ejemplo `127.0.0.1:3306`. Después:

```bash
php artisan migrate
npm ci
npm run build
```

No reutilices datos ni credenciales de producción. Mantén `.env` fuera del control de versiones.

## Desarrollo

Desde `inventario/`, ejecuta:

```bash
composer run dev
```

El script inicia el servidor Laravel, Vite y el worker de colas. La aplicación queda normalmente en `http://localhost:8000`.

## Desarrollo con Docker Compose

Ejecuta desde `inventario/`. Antes de levantar Compose, prepara `.env` con valores exclusivos para desarrollo local. En una instalación nueva, copia `.env.example` a `.env` si el archivo aún no existe; ejecuta `composer install` para poder usar Artisan en el host y `php artisan key:generate` solo si `APP_KEY` está vacía. Compose construye la imagen y compila los assets; el arranque no instala dependencias, genera la clave ni aplica migraciones.

```bash
composer install
# Solo si .env todavía no existe:
cp .env.example .env
# Solo en una instalación nueva con APP_KEY vacía:
php artisan key:generate
docker compose up --build -d
docker compose ps
docker compose exec apache php artisan migrate
```

La aplicación queda en `http://localhost:8000`, phpMyAdmin en `http://localhost:8081` y MariaDB se publica en el puerto local `3307`. MariaDB guarda sus datos en el volumen persistente `db_data`. `docker compose down` conserva ese volumen; `docker compose down -v` lo elimina junto con la base de datos. Las credenciales de `.env.example` son solo valores de ejemplo para una instalación local desechable.

## Estructura

```text
INVENTARIO/
├── inventario/
│   ├── app/                 # Controladores, modelos, requests y servicios
│   ├── database/            # Migraciones y factories
│   ├── resources/           # Interfaz React y vistas Blade
│   ├── routes/              # Rutas web
│   ├── tests/               # Pruebas Pest
│   └── docker-compose.yml
├── specs/                   # Especificaciones de cambios no triviales
├── AGENTS.md
├── CONSTITUTION.md
└── MEMORY.md
```

## Pruebas y verificaciones

Ejecuta los comandos de esta sección desde `inventario/`. Las pruebas Feature y Unit usan `RefreshDatabase`; antes de ejecutarlas, confirma que la conexión efectiva apunta a una base local/efímera aislada. No las ejecutes contra bases con datos que quieras conservar.

```bash
composer run test
composer run test:unit
composer run test:feature
vendor/bin/pint --test
npm run types
npm run format:check
npm run build
```

`composer run test` limpia la configuración de Laravel antes de iniciar Pest. `composer run analyse` también limpia esa configuración antes de ejecutar PHPStan. `composer run format` y `npm run lint` modifican archivos; no son comandos de solo comprobación. `composer run test:coverage` requiere un controlador de cobertura PHP compatible instalado (por ejemplo, Xdebug o PCOV).

Las pruebas se organizan bajo `inventario/tests/Feature/` y `inventario/tests/Unit/`. La existencia de pruebas no garantiza por sí sola que todas las capacidades estén cubiertas. Actualmente no hay workflows de CI versionados en el repositorio; la verificación debe ejecutarse localmente.

Para el proceso de especificación y revisión de cambios no triviales, consulta [`specs/README.md`](specs/README.md).

## Licencia y autoría

Licencia MIT. Desarrollado por [matiasapl](https://github.com/matiasapl).
