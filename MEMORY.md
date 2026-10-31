# Memoria del proyecto — INVENTARIO

Última revisión selectiva: 2026-10-31.

Este documento resume contexto técnico contrastado en código y configuración. No es una auditoría exhaustiva ni certifica seguridad o cobertura funcional. Distinguir los requisitos de `CONSTITUTION.md` del comportamiento implementado; las decisiones pendientes no autorizan cambios por sí solas.

## Organización y stack

- El repositorio contiene la aplicación en `inventario/`, documentación en la raíz y especificaciones en `specs/`.
- `inventario/composer.json` declara PHP `^8.2`, Laravel `^12.0`, Fortify e Inertia Laravel. `inventario/package-lock.json` fija Vite 7.3.7, que requiere Node `^20.19.0` o `>=22.12.0`; el Dockerfile usa Node 20 y PHP 8.4.
- La aplicación usa React 19, TypeScript, Inertia React y Tailwind CSS 4. MariaDB es el motor previsto; Compose usa MariaDB 10.11.
- `inventario/docker-compose.yml` debe ejecutarse desde `inventario/`. Publica la app en 8000, phpMyAdmin en 8081 y MariaDB en 3307. La base se conserva en el volumen `db_data`; `docker compose down -v` la elimina.
- El entrypoint prepara permisos y directorios. No instala dependencias, genera `APP_KEY` ni ejecuta migraciones al arrancar; estos pasos son explícitos.
- No hay workflows de CI versionados actualmente. `composer run test` y `composer run analyse` ejecutan `artisan config:clear`; `composer run format` y `npm run lint` modifican archivos. `npm run types`, `npm run format:check` y `npm run build` son las comprobaciones frontend declaradas.

## Comportamiento observado

- Productos, almacenes, lotes y registros pertenecen a usuarios. Los controladores principales comprueban propiedad; las requests de creación/actualización de lotes validan que producto y almacén pertenezcan al usuario y estén disponibles.
- Las operaciones de inventario sobre productos, almacenes y lotes se canalizan por `App\Services\InventoryAudit`, que agrupa mutación y registro en una transacción e incluye `operacion_id` y snapshots anterior/nuevo. Esta cobertura no implica que los eventos de registro, perfil, contraseña o segundo factor también estén auditados.
- Las migraciones actuales permiten conservar registros de auditoría al eliminar un usuario; la relación actor no mantiene una FK en cascada.
- Los cambios de estado usan métodos POST/DELETE y las vistas de detalle consultan sin crear registros de auditoría.
- El registro permanece individual y habilitado; el segundo factor es opcional. Las rutas usan middleware `verified`, pero `User` no implementa `MustVerifyEmail`; revisar el comportamiento efectivo antes de cambiar requisitos de verificación.
- `RefreshDatabase` se aplica a pruebas Feature y Unit en `inventario/tests/Pest.php`. Las pruebas deben apuntar a una MariaDB local o efímera aislada; el host configurado por sí solo no demuestra aislamiento.
- `inventario/phpunit.xml` contiene una contraseña de prueba no vacía. No copiar su valor ni asumir que es válida o segura para reutilizar. Usar configuración aislada al probar.

## Decisiones aún pendientes

- Precisar el significado de `estado` por entidad y las condiciones de disponibilidad para asociar productos y almacenes a lotes.
- La implementación y pruebas aceptan cantidad cero y rechazan negativos; la constitución deja pendiente si cero debe ser válido y si se admiten fracciones. No confundir comportamiento actual con decisión de negocio aprobada.
- Definir el alcance de auditoría para eventos de cuenta, perfil, contraseña y segundo factor, sin registrar secretos.
- Las policies existen, pero su presencia no demuestra cobertura de autorización en todos los flujos. Verificar rutas, controladores, relaciones y pruebas al trabajar en permisos.

## Límites de la revisión

La inspección fue selectiva. No asumir que las propiedades de un módulo, las policies declaradas o las observaciones de esta memoria prueban por sí solas el funcionamiento de toda la aplicación; contrastar la ruta completa y pruebas relevantes antes de cambiar o certificar un flujo.
