# Plan — correcciones de auditoría

## Enfoque

Implementar en fases pequeñas, con pruebas de comportamiento primero para cada regla. No pasar al build de producción hasta cerrar los ciclos TDD y las verificaciones no-build definidas en `SPEC.md`.

## Fases y archivos probables

1. **Preparar pruebas aisladas:** revisar `inventario/phpunit.xml`, `tests/Pest.php`, factories, `.env.example` y conexión MariaDB. Definir una configuración sintética exclusivamente local/efímera antes de ejecutar pruebas.
2. **Rutas y relaciones de lotes:** `routes/web.php`, `StoreLotesRequest`, `UpdateLotesRequest`, `LotesController`, pruebas de controladores de lotes y formularios/páginas React correspondientes.
3. **Mutaciones HTTP y lecturas:** rutas, controladores de productos/almacenes/lotes, páginas de detalle y botones/enlaces de estado, pruebas HTTP.
4. **Bloqueos por relaciones:** modelos y controladores de producto/almacén; pruebas para lotes activos, inactivos y eliminados lógicamente.
5. **Auditoría transaccional:** modelo `Registro`, migración aditiva para snapshots/UUID/actor estable, controladores o servicio compartido mínimo, pruebas de atomicidad, retención y ausencia de PII. Inspeccionar migraciones y restricciones existentes antes de diseñar el cambio.
6. **Docker:** `inventario/docker-compose.yml`, `Dockerfile`, `entrypoint.sh` y documentación pertinente. Separar build/instalación de dependencias del arranque; no ejecutar migraciones automáticamente salvo decisión explícita y segura.
7. **Dependencias npm:** revisar `package.json`, lockfile y salida de auditoría en entorno temporal. Identificar paquete directo/transitivo, severidad, ruta y cambio mínimo compatible; pedir autorización si requiere actualización mayor o incompatibilidad.
8. **Workflows/documentación:** retirar los YAML indicados en la raíz y bajo `inventario/`; corregir solo afirmaciones relacionadas del `README.md`.
9. **Verificar y build:** revisar diff completo; ejecutar pruebas focalizadas y suite en base aislada, análisis PHP y comprobaciones frontend disponibles. Solo al final ejecutar build y revisar artefactos, luego verificar flujos en Docker/Brave si el entorno es seguro.

## Riesgos

- Restricciones MariaDB/UUID y cascadas actuales pueden requerir una migración de datos cuidadosamente reversible.
- Las pruebas existentes contienen expectativas contradictorias con decisiones aprobadas; actualizar pruebas únicamente donde se demuestre que están desactualizadas.
- Una conexión de PHPUnit mal configurada puede alterar una base no aislada; no ejecutar hasta demostrar aislamiento efectivo.
- Cambios npm pueden ser incompatibles; evitar actualizaciones masivas y no aceptar corrección automática ciega.
- Docker actual ejecuta instalaciones y migraciones al inicio y usa nombres de contenedor fijos; comprobar conflictos y efectos antes de levantarlo.
- El estado de los YAML y README se revisará contra Git antes de editar para preservar trabajo existente.

## Verificaciones

- Por tarea de comportamiento: prueba focalizada falla por el comportamiento esperado, cambio mínimo, prueba pasa.
- Backend: primero pruebas focalizadas; suite completa solo tras confirmar configuración/base MariaDB efímera aislada.
- PHP: `composer run analyse` tras inspeccionar sus efectos; `vendor/bin/pint --test`.
- Frontend: `npm run types`, `npm run format:check`; revisar el script de lint antes de ejecutarlo porque contiene `--fix`.
- Docker: validar configuración Compose, build y arranque con base/volumen temporal; verificar persistencia con reinicio controlado.
- Dependencias: análisis de auditoría antes/después y revisión del diff del lockfile.
- Final: build frontend, revisión de diff, `git status`, secretos, migración y artefactos.
