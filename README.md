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

Ejecutar la suite de tests:

```bash
composer run test
```

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
