# Memoria del proyecto — INVENTARIO

Última revisión: 2026-10-15.

Esta memoria recoge contexto de una revisión estática del repositorio. No se ejecutaron pruebas, migraciones ni la aplicación; no constituye una certificación de funcionamiento o seguridad. El código y la configuración actuales prevalecen sobre observaciones desactualizadas. Las brechas no autorizan cambios fuera de la tarea.

## 1. Organización documental

- `CONSTITUTION.md` conserva principios y reglas requeridas, sin afirmar que estén implementadas.
- `AGENTS.md` define procedimientos, aislamiento de pruebas, verificación y entrega proporcional.
- `MEMORY.md` conserva contexto verificado, brechas y decisiones pendientes. No es un registro cronológico.
- `specs/<nombre-descriptivo>/` es el convenio establecido para nuevas especificaciones persistentes; no se verificó la existencia de especificaciones previas en esa ubicación.

## 2. Arquitectura y herramientas verificadas

- La aplicación está bajo `inventario/`; la raíz contiene documentación y `.github/`.
- `inventario/composer.json` declara PHP `^8.2`, Laravel `^12.0`, Fortify e Inertia Laravel; incluye Pest, Pint y PHPStan entre las dependencias de desarrollo. Son restricciones declaradas, no versiones de ejecución comprobadas.
- `inventario/package.json` declara React 19, TypeScript, Inertia React, Vite y Tailwind CSS.
- Backend y validación están en `inventario/app/`; rutas en `inventario/routes/`; interfaz en `inventario/resources/js/`; migraciones y factories en `inventario/database/`; pruebas en `inventario/tests/`.
- MariaDB es la base descrita por el proyecto y la conexión declarada en `inventario/phpunit.xml`. El README menciona dependencia de UUID nativo de MariaDB; no asumir compatibilidad de pruebas con SQLite sin verificar migraciones.
- Los modelos principales revisados son `Product`, `Almacen`, `Lotes`, `Registro` y `User`. También existen archivos `Enterprice` y `RegistroProductos`; su presencia no prueba que sus flujos estén activos.
- `habilitado`, `eliminado` y `estado` son booleanos en los modelos de producto, almacén y lote. La eliminación lógica revisada usa un booleano propio, no el trait `SoftDeletes` de Laravel.
- Los controladores principales filtran listados por `usuario` y verifican propiedad del recurso mediante métodos propios. Eso no cubre automáticamente relaciones recibidas por formulario.
- `config/fortify.php` activa registro, recuperación de contraseña, verificación de correo y segundo factor. `User` no implementa `MustVerifyEmail`, aunque las rutas principales declaran middleware `verified`; comprobar ambos antes de cambiar obligatoriedad.
- `tests/Pest.php` aplica `RefreshDatabase` a pruebas configuradas allí. La ejecución puede alterar datos y requiere aislamiento efectivo.
- Los scripts frontend incluyen `types`, `format:check` y `build`. `lint` incluye `--fix`; `format` escribe archivos.
- `composer run analyse` ejecuta `artisan config:clear` antes de PHPStan; no describirlo como una operación sin efectos auxiliares.
- Hay workflows tanto en `.github/workflows/` de la raíz como bajo `inventario/.github/workflows/`. Inspeccionar la configuración efectiva antes de afirmar cobertura de CI.

## 3. Brechas observadas — pendientes de corrección autorizada

- **Relaciones de lotes:** `StoreLotesRequest` y `UpdateLotesRequest` aceptan IDs numéricos sin comprobar propiedad y disponibilidad del producto o almacén. `LotesController::store/update` usa esos datos sin una validación adicional observada de relaciones. Filtrar las opciones del formulario no resuelve el control en servidor.
- **Métodos HTTP:** `routes/web.php` define habilitar y deshabilitar productos, almacenes y lotes mediante GET, contrario al requisito de solo lectura.
- **Consultas con escritura:** los métodos `view` de los controladores principales crean entradas `Registro` al consultar recursos mediante GET.
- **Recursos asociados:** los métodos revisados para deshabilitar y eliminar productos y almacenes guardan booleanos sin comprobar lotes asociados.
- **Auditoría incompleta:** `Registro` y las migraciones revisadas no contienen snapshots anterior/nuevo ni identificador de operación. Los controladores revisados guardan cambio y registro por separado, sin transacción observada que los agrupe.
- **Retención de auditoría:** la migración de creación de `registros` declara borrado en cascada al eliminar el usuario. No se verificó una decisión de negocio que autorice esa retención.
- **Pruebas desalineadas:** `tests/Feature/Http/Controllers/LotesControllerTest.php` envía POST a acciones configuradas como GET, considera cero inválido mientras el request acepta `min:0`, y espera la propiedad `lotes` donde el controlador entrega `Lotes`. Son diferencias estáticas, no resultados de ejecución.
- **Restricción inesperada:** `UpdateLotesRequest` aplica `max:30` a `almacen_id` numérico; puede rechazar almacenes por su ID. No se verificó una regla de negocio que justifique ese límite.
- **Configuración sensible de pruebas:** `phpunit.xml` contiene una contraseña literal no vacía. No copiar su valor. No se comprobó validez, exposición ni seguimiento en Git. Revisar externalización y, si una credencial válida estuvo expuesta, su cambio mediante una tarea autorizada.
- **Aislamiento sin demostrar:** el host de PHPUnit es loopback, pero no se comprobó la conexión efectiva ni que la base sea exclusiva y desechable. No ejecutar pruebas basándose solo en ese dato.

## 4. Decisiones de negocio pendientes

- Precisar el significado de true/false en `estado` de cada entidad y la combinación exacta que permite asignar producto y almacén a un lote.
- Aclarar si cantidades cero son válidas y si se admiten fracciones; la regla existente solo prohíbe negativos y las pruebas revisadas discrepan sobre cero.
- Precisar si lotes consumidos, deshabilitados o eliminados lógicamente siguen bloqueando deshabilitación y eliminación de recursos asociados. Hasta una decisión explícita, no inventar excepciones a la regla general.
- Concretar eventos y campos auditables para registro de cuenta, perfil, contraseña y segundo factor sin incluir secretos.
- Definir representación de estados ausentes en creación/eliminación, estructura de snapshots, orden e identificador de operación, y retención al eliminar cuentas.
- Aclarar el tratamiento de auditoría de consultas para cumplir el requisito de GET de solo lectura; no conservar la contradicción por conveniencia.

## 5. Límites de la revisión

- Se contrastaron documentos, configuración y partes relevantes del código; no se hizo una auditoría exhaustiva de todos los flujos.
- No se ejecutaron pruebas, análisis estático, compilación ni comprobaciones de interfaz.
- La inspección de seguimiento mediante Git no estuvo disponible por una restricción de acceso. No se confirmó historial ni exposición de configuración sensible.
- La reorganización documental no corrige las brechas de la aplicación ni decide las reglas pendientes.
