# Tareas — correcciones de auditoría

Estados: `Pendiente`, `En curso`, `Bloqueada`, `Hecha`.

## Especificación y seguridad de pruebas

- [x] Acordar alcance y reglas de negocio con el propietario.
- [x] Documentar criterios en `SPEC.md`, enfoque en `PLAN.md` y tareas en este archivo.
- [x] Revisar configuración de pruebas y demostrar aislamiento MariaDB antes de ejecutar pruebas con base.
- [x] Eliminar credencial literal de configuración de pruebas sin divulgar su valor.

## Comportamiento de inventario (TDD)

- [x] Lotes: validar existencia, propiedad, `estado=true`, habilitado y no eliminado al crear y actualizar; aceptar cantidad cero y rechazar negativas/relaciones inválidas.
- [x] HTTP: mover habilitar/deshabilitar fuera de GET; verificar que GET de detalle no escribe auditoría.
- [x] Producto/almacén: bloquear deshabilitación y eliminación con cualquier lote asociado, sin excepciones de estado.
- [x] Auditoría: guardar CRUD de inventario y evento en transacción; snapshots JSON anterior/nuevo, UUID de operación y actor estable sin PII.
- [x] Retención: conservar registros al borrar usuario, preservar historial preexistente y probar migración en MariaDB aislada.

## Entorno y documentación

- [x] Docker: alinear volumen con datadir MariaDB efectivo y quitar efectos de instalación/migración inesperados del arranque.
- [x] npm: identificar vulnerabilidades por paquete; aplicar solo cambios justificados y compatibles, o registrar limitación.
- [x] Retirar workflows YAML residuales aprobados para eliminación y corregir afirmaciones de CI/CD en README.

## Verificación final (antes del build)

- [x] Ejecutar pruebas focalizadas y suite backend en MariaDB aislada; registrar resultados reales.
- [x] Ejecutar Pint en modo comprobación y PHPStan; corregir incompatibilidades de ejecución y documentar hallazgos.
- [x] Ejecutar TypeScript, ESLint focalizado y formato global.
- [x] Verificar Docker Compose, persistencia MariaDB, migración explícita y respuesta HTTP con datos/credenciales sintéticos.
- [x] Revisar diff, migración, secretos, `git status` y artefactos generados.
- [x] Ejecutar build frontend como última verificación de código y revisar sus salidas ignoradas por Git.
- [ ] Preparar commit y publicar rama/PR; no hacer merge ni despliegue.

## Bloqueos y observaciones de ejecución

- Las suites focalizadas de inventario pasaron (93 pruebas/587 assertions) y la suite backend completa pasó (174 pruebas/792 assertions) sobre MariaDB efímera `mariadb:10.11`, en loopback, puerto no estándar, base con nombre único y opt-in explícito. PHP 8.5 muestra deprecaciones preexistentes de `PDO::MYSQL_ATTR_SSL_CA` en `config/database.php`.
- `vendor/bin/pint --test` y `npm run types` pasaron. Prettier focalizado en las seis páginas modificadas pasó. El `npm run format:check` global conserva fallos en tres archivos fuera de alcance; ESLint focalizado informa 11 usos preexistentes de `any` en páginas de inventario, sin aplicar autocorrección.
- PHPStan ahora ejecuta mediante `@php` en Composer; se corrigió su configuración incompatible (include inexistente y opciones retiradas). El análisis encuentra 877 errores, principalmente por tipos dinámicos de Laravel/Pest y configuración previa; requiere una decisión/paquete de extensión y resolución de hallazgos, por lo que no se declara pasado.
- Compose construyó la imagen web, arrancó Apache y MariaDB, completó migraciones explícitas y respondió HTTP 200. También se verificó que el volumen MariaDB conserva un marcador sintético tras reiniciar; los recursos efímeros de estas pruebas se retiraron.
- La migración se probó desde el esquema previo con un registro histórico sintético: asignó UUID de operación y conservó el registro después de borrar al actor. En una MariaDB aislada no existía la FK que declaraba la migración inicial, así que detecta y elimina la FK de forma condicional para ser compatible con ambos estados previos.
- Tras actualizar dependencias dentro de los rangos mayores declarados y ejecutar `npm audit fix` sin `--force`, la auditoría npm pasó de 30 (2 críticas, 11 altas, 15 moderadas y 2 bajas) a 13 vulnerabilidades moderadas. Las restantes requieren saltos mayores de ESLint/TypeScript ESLint; no se aplicaron.
- El build final `npm run build` pasó con Vite 7.3.7. Sus salidas bajo `public/build/` y código Wayfinder generado están ignorados por Git.
- Verificación de cierre local: Pint, TypeScript, ESLint focalizado, Prettier global, `composer validate`, sintaxis PHP de configuración y `npm audit --omit=dev` (cero vulnerabilidades) pasaron. La suite backend previamente pasó con 174 pruebas/792 assertions sobre MariaDB efímera; no se repitió en este cierre porque no había contenedor Docker activo.
