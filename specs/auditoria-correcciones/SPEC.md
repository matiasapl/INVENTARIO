# Correcciones de auditoría del inventario

## Objetivo

Corregir las brechas de autorización, integridad y trazabilidad señaladas en la auditoría del proyecto, y dejar coherentes la configuración de pruebas, Docker y documentación residual de CI/CD.

## Alcance

- CRUD de productos, almacenes y lotes, incluida habilitación/deshabilitación y eliminación lógica.
- Validación de relaciones y propiedad en servidor.
- Auditoría de mutaciones del inventario.
- Configuración de pruebas, Docker, revisión de dependencias npm, workflows YAML residuales y afirmaciones de CI/CD en README.
- Pruebas de comportamiento con datos sintéticos y verificaciones de frontend/build.

Quedan fuera de esta ronda los eventos de perfil y autenticación, despliegue, publicación, PR, push y merge. No se creará CI/CD.

## Comportamiento esperado

1. Las operaciones que cambian datos no se ejecutan mediante GET. Las consultas de detalle GET no escriben ni crean registros de auditoría.
2. Un lote solo puede referenciar un producto y un almacén que pertenezcan al usuario autenticado, tengan `estado=true`, estén habilitados y no estén eliminados. La regla rige tanto al crear como al actualizar.
3. La cantidad del lote admite cero y rechaza valores negativos o fuera de los límites acordados que ya existan; no se introduce soporte para fracciones sin evidencia de que el esquema lo permita.
4. No se permite deshabilitar ni eliminar lógica o físicamente un producto o almacén si existe cualquier lote asociado, independientemente del estado, habilitación o eliminación lógica del lote.
5. Cada mutación CRUD de producto, almacén o lote genera un evento de auditoría con UUID de operación, tipo/acción, identificador estable del actor sin PII y snapshots JSON anterior/nuevo de campos de negocio. En una creación, el anterior es nulo; en una eliminación lógica, el posterior refleja los valores resultantes. Cambios y auditoría se confirman o revierten juntos.
6. El historial de auditoría sobrevive al borrado de una cuenta. La referencia del actor no depende de una FK en cascada y no conserva nombre, email ni secretos. La migración debe preservar registros existentes y probarse en una base aislada.
7. Docker persiste MariaDB en el directorio de datos efectivo y permite un flujo de desarrollo reproducible sin instalaciones o migraciones destructivas implícitas no documentadas. No cambiar credenciales reales ni exponer secretos.
8. Las vulnerabilidades npm se investigan por paquete y cadena de dependencia. Solo se actualizan versiones justificadas y compatibles; no se ejecuta `npm audit fix` a ciegas.
9. Se retiran los YAML residuales de workflows aprobados para eliminación y se corrigen las afirmaciones del README para no representar CI/CD inexistente.
10. La configuración de pruebas no contiene una credencial literal y su destino de base queda inequívocamente aislado antes de ejecutar pruebas que muten datos.

## Criterios de aceptación

- Pruebas HTTP demuestran propiedad, disponibilidad y límites de cada relación de lote al crear y actualizar, incluido cantidad cero.
- GET de detalle no cambia tablas de auditoría; las rutas de cambio de estado no aceptan GET y sí usan métodos de mutación con protección CSRF/middleware existente.
- Las operaciones de producto/almacén con lotes asociados se rechazan y no modifican recurso ni auditoría; se cubren lotes en todos sus estados.
- Pruebas demuestran snapshots, UUID, actor sin PII, atomicidad ante fallo y retención al eliminar usuario.
- La migración aplica sobre el esquema previo y preserva historial en MariaDB aislada; se revisa reversibilidad y compatibilidad antes de ejecutar.
- Docker Compose apunta el volumen al datadir efectivo; el arranque no instala dependencias ni ejecuta migraciones inesperadas en cada inicio.
- Se documentan resultados del análisis npm y cualquier riesgo que no pueda corregirse de forma segura.
- No quedan workflows YAML residuales dentro del alcance aprobado ni afirmaciones falsas de CI/CD en el README.
- Pruebas focalizadas, verificaciones disponibles de PHP/TypeScript/formato y flujos funcionales terminan antes del build final. El build y sus artefactos se revisan.
- No se hace push, PR, merge ni despliegue.

## Límites y seguridad

- Usar solo datos sintéticos y una base local/efímera cuya conexión efectiva se haya demostrado aislada.
- No usar credenciales reales, datos de producción ni revelar valores sensibles.
- No borrar datos, volúmenes o archivos del usuario. La limpieza solo alcanza recursos efímeros creados para esta tarea y previamente identificados.
- No ampliar auditoría a perfil/autenticación ni corregir brechas no relacionadas.

## Decisiones aprobadas

- `estado=true` habilita la asociación de producto/almacén a lote.
- Cero es una cantidad válida.
- Todos los lotes asociados bloquean deshabilitación/eliminación de producto/almacén.
- Retener auditoría tras eliminar usuario usando ID estable sin PII.
- Snapshots completos JSON anterior/nuevo y UUID de operación.
- Retirar YAML residuales y corregir README; no crear pipeline.
