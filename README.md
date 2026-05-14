# INVENTARIO

Sistema de gestión de inventario desarrollado con **Laravel 12** y **React 19**, integrados mediante **Inertia.js**.

## 🚀 Características

- **Gestión de Productos** - CRUD completo con eliminación lógica
- **Administración de Almacenes** - Múltiples ubicaciones de almacenamiento
- **Control de Lotes** - Seguimiento de lotes por producto y almacén
- **Registro de Actividades** - Auditoría completa de operaciones
- **Autenticación Segura** - Laravel Fortify con verificación de dos factores
- **Interfaz Moderna** - React con Tailwind CSS y componentes Radix UI

## 🛠️ Stack Tecnológico

### Backend

- **Laravel 12** - Framework PHP 8.2+
- **Laravel Fortify** - Autenticación y seguridad
- **Inertia.js** - Puente entre Laravel y React
- **MariaDB** - Base de datos relacional

### Frontend

- **React 19** - Biblioteca de interfaz de usuario
- **TypeScript** - Tipado estático
- **Tailwind CSS 4** - Estilos utilitarios
- **Radix UI** - Componentes accesibles
- **React Hook Form** - Gestión de formularios
- **Zod** - Validación de datos
- **Vite** - Build tool y dev server

## 📋 Requisitos

- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- **MariaDB** (requerido - el proyecto utiliza la función UUID() nativa de MariaDB)

## 🔧 Instalación

1. **Clonar el repositorio**

```bash
git clone https://github.com/matiasapl/INVENTARIO.git
cd Inventario
```

2. **Instalar dependencias de PHP**

```bash
composer install
```

3. **Configurar el entorno**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

   a. Crea una base de datos en tu servidor MariaDB:

```sql
CREATE DATABASE inventario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

b. Edita el archivo `.env` con tus credenciales de MariaDB:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventario
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

c. Ejecuta las migraciones:

```bash
php artisan migrate
```

5. **Instalar dependencias de Node.js**

```bash
npm install
```

6. **Compilar assets (para producción)**

```bash
npm run build
```

## 🏃 Desarrollo

Iniciar el servidor de desarrollo con hot reload:

```bash
composer run dev
```

Esto iniciará simultáneamente:

- Servidor de Laravel en `http://localhost:8000`
- Vite dev server para frontend
- Queue worker para procesos en segundo plano

## 📁 Estructura del Proyecto

```
Inventario/
├── app/
│   ├── Models/           # Modelos Eloquent (Product, Almacen, Lotes, etc.)
│   ├── Http/
│   │   ├── Controllers/  # Controladores
│   │   └── Requests/     # Validaciones
│   ├── Policies/         # Políticas de autorización
│   └── Actions/          # Acciones reutilizables
├── resources/
│   ├── js/
│   │   ├── pages/        # Páginas por módulo
│   │   ├── components/   # Componentes React
│   │   ├── layouts/      # Layouts principales
│   │   └── types/        # Tipos TypeScript
│   └── views/            # Vistas Blade
├── routes/
│   ├── web.php           # Rutas web principales
│   └── settings.php      # Rutas de configuración
└── database/
    └── migrations/       # Migraciones de base de datos
```

## 🗄️ Modelo de Datos

### Entidades Principales

| Entidad      | Descripción                                            |
| ------------ | ------------------------------------------------------ |
| **User**     | Usuarios del sistema con autenticación                 |
| **Product**  | Productos con precio unitario, descripción y estado    |
| **Almacen**  | Ubicaciones de almacenamiento con código UUID          |
| **Lotes**    | Lotes de productos con cantidad y ubicación específica |
| **Registro** | Registro de acciones y auditoría del sistema           |

## 🧪 Tests

El proyecto sigue estándares **TDD (Test Driven Development)** y **SDD (Specification Driven Development)** con documentación viva en los tests.

### Ejecutar Tests

```bash
# Ejecutar todos los tests
composer run test

# Ejecutar tests unitarios
composer run test:unit

# Ejecutar tests de características
composer run test:feature

# Ejecutar tests con reporte de cobertura
composer run test:coverage

# Analizar código con PHPStan
composer run analyse

# Formatear código con Laravel Pint
composer run format
```

### Estructura de Tests

```
tests/
├── Unit/                    # Tests unitarios
│   ├── Models/             # Tests para modelos
│   ├── Actions/            # Tests para lógica de negocio
│   └── Policies/           # Tests para políticas
├── Feature/                # Tests de características
│   ├── Http/              # Tests para controladores y requests
│   ├── Auth/              # Tests para autenticación
│   └── Settings/          # Tests para configuración
└── Concerns/              # Traits reutilizables para tests
```

### Cobertura de Tests

Los tests generan reportes de cobertura en:

- `coverage.xml` - Formato Clover para CI/CD
- `coverage-report/` - Reporte HTML interactivo

### Especificaciones en Tests

Cada test incluye documentación viva con:

- `@spec` - Especificación del comportamiento esperado
- `@audit` - Notas de auditoría y decisiones técnicas

Ejemplo:

```php
/**
 * @test
 * @spec "Un producto puede ser deshababilitado pero no eliminado permanentemente"
 * @audit "Requerimiento: Los productos deben mantenerse para auditoría"
 */
it('can disable a product but not permanently delete it', function () {
    // ...
});
```

### Base de Datos de Testing

Los tests utilizan una base de datos **MariaDB separada** (`u191434997_Inventario_test`) para no interferir con datos de producción. El trait `RefreshDatabase` limpia la BD después de cada test automáticamente.

## 🔄 CI/CD (Integración y Entrega Continua)

El proyecto cuenta con **GitHub Actions** para automatizar la calidad del código en cada push o pull request.

### Flujos Automatizados

```yaml
# .github/workflows/tests.yml
on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main, develop]
```

### Pasos del Pipeline

1. **Tests con Cobertura** - Ejecuta todos los tests y genera reporte de cobertura
2. **Análisis Estático** - PHPStan nivel 5 para detectar errores de tipo
3. **Code Style** - Laravel Pint para verificar formato de código
4. **Seguridad** - Escaneo de dependencias vulnerables
5. **Reporte** - Sube resultados como artifacts

### Comandos Locales Equivalentes

```bash
# Ejecutar todo el pipeline localmente
composer run test:coverage    # Tests con cobertura
composer run analyse          # PHPStan
composer run format           # Laravel Pint (format)
```

### Configuración de Cobertura

- **Mínimo requerido**: 80% de cobertura
- **Reportes**:
  - `coverage.xml` - Formato Clover para CI
  - `coverage-report/` - HTML interactivo local

## 📊 Métricas de Calidad

| Métrica                      | Estado | Detalle                     |
| ---------------------------- | ------ | --------------------------- |
| **Tests Unitarios**          | ✅     | 39 tests (Modelos)          |
| **Tests de Integración**     | ✅     | 66 tests (Controladores)    |
| **Tests de Características** | ✅     | 15 tests (Flujos completos) |
| **Total Tests**              | ✅     | ~120 tests                  |
| **Análisis Estático**        | ✅     | PHPStan nivel 5             |
| **Code Style**               | ✅     | Laravel Pint                |
| **CI/CD**                    | ✅     | GitHub Actions              |
| **Cobertura**                | 🎯     | Objetivo 80%+               |

## 🔒 Seguridad

- Eliminación lógica de registros (soft delete)
- Políticas de autorización por recurso
- Validación de datos en frontend y backend
- Protección CSRF automática
- Autenticación de dos factores opcional

## 📄 Licencia

MIT License

## 👤 Autor

Desarrollado por [matiasapl](https://github.com/matiasapl)

---

**Nota:** Este proyecto utiliza Laravel React Starter Kit como base.
