# Guía para agentes — INVENTARIO

## 1. Propósito y límites

INVENTARIO es una aplicación multiusuario de gestión de inventario. Cada usuario puede consultar y modificar únicamente la información que le pertenece.

Este archivo define el flujo general de trabajo de los agentes. No autoriza a:

- modificar el alcance o las reglas de negocio sin confirmación;
- acceder a producción, usar credenciales reales o desplegar;
- hacer merge de un Pull Request (PR);
- sobrescribir cambios existentes del usuario;
- ejecutar acciones destructivas o migraciones contra una base no aislada.

Trabaja solo en la tarea solicitada. **Ante cualquier inconsistencia entre la solicitud, una especificación, el código, las pruebas o la documentación, detente y consulta al usuario.** No resuelvas contradicciones por intuición ni inventes reglas.

## 2. Proyecto y tecnologías

- Backend: PHP 8.2+, Laravel 12, Eloquent, Fortify y Pest/PHPUnit.
- Frontend: React 19, TypeScript, Inertia.js, Vite y Tailwind CSS.
- Base de datos: MariaDB.
- Directorio de aplicación: `inventario/`.
- Rutas principales: `inventario/routes/`.
- Código backend: `inventario/app/`.
- Frontend: `inventario/resources/js/`.
- Migraciones y datos de prueba: `inventario/database/`.
- Pruebas: `inventario/tests/`.

Antes de cambiar archivos, inspecciona la estructura y convenciones actuales. No supongas que una funcionalidad está implementada porque exista una policy, pantalla, migración o prueba aislada: verifica el flujo completo.

## 3. Dominio y reglas confirmadas

### Usuarios y propiedad de datos

- No hay roles ni administradores globales actualmente.
- Cada usuario solo puede ver y modificar sus propios productos, almacenes, lotes y registros.
- No confíes en IDs enviados por el cliente: valida la propiedad en servidor para el recurso solicitado y para todas sus relaciones.
- Mantén el diseño razonablemente extensible a un futuro SaaS freemium, pero no implementes cuentas, planes, roles o multi-tenancy adicional sin una especificación y aprobación.

### Productos y almacenes

- Productos y almacenes pertenecen a un usuario.
- `habilitado` determina si están en uso normal o en papelera.
- `eliminado` representa soft delete. Los registros eliminados no deben aparecer en las vistas normales ni en la papelera; no realices borrado físico salvo que una especificación lo solicite y el usuario lo apruebe.
- `estado` indica si un producto o almacén puede usarse al asociarlo a un lote.
- No se puede deshabilitar ni eliminar un producto o almacén mientras exista un lote que lo use.
- Solo se pueden asignar a lotes productos y almacenes habilitados para uso.

### Lotes

- Un lote representa unidades físicas de un producto ubicadas en un almacén. Por ejemplo, 10 paquetes de un producto en una caja o estantería.
- Cada lote debe referenciar un producto y un almacén del mismo usuario.
- `estado` indica disponibilidad/consumo: disponible o consumido/vendido.
- La transición entre disponible y consumido es reversible.
- No permitas cantidades negativas ni relaciones con recursos ajenos.

### Registro de actividad / auditoría

- Toda operación iniciada por una persona que modifique la base de datos debe quedar auditada.
- Cada modificación debe registrar el estado anterior y el estado nuevo, vinculados a la misma operación y en ese orden.
- Los registros deben identificar al actor, la entidad afectada, la acción y la fecha. No guardes contraseñas, tokens ni otros secretos.
- Mantén el cambio de negocio y sus entradas de auditoría atómicos cuando sea posible: si una parte falla, no debe quedar una modificación sin auditar.
- Los registros de auditoría no deben modificarse silenciosamente ni borrarse en cascada sin una decisión de negocio explícita.
- El modelo actual `Registro` no contiene todavía snapshots anterior/nuevo ni un identificador de operación. No asumas que el requisito ya está cubierto: propone el cambio de esquema y pruebas cuando la tarea lo requiera.

### Autenticación

- El registro de usuarios permanece abierto.
- La verificación de correo y el segundo factor son opcionales.
- No los conviertas en requisitos obligatorios sin una especificación y aprobación.

## 4. Especificaciones y fuentes de verdad

En el futuro, cada especificación vivirá en su propia carpeta, nombrada según la spec, e incluirá:

- `SPEC.md`: comportamiento y criterios de aceptación;
- `PLAN.md`: planificación;
- `TASKS.md`: lista verificable de tareas cuyo progreso puede actualizar el agente.

La especificación y el código son fuentes de verdad. Si se contradicen, si una regla no está clara o si las pruebas/documentación señalan otra conducta, **detente y consulta al usuario**. No elijas una fuente sobre otra ni marques una tarea como terminada hasta resolver la inconsistencia.

## 5. Flujo de trabajo por tarea

1. **Entender:** leer la solicitud, la spec aplicable, el código y las pruebas relacionadas. Revisar `git status` y preservar cambios preexistentes.
2. **Planificar:** resumir alcance, archivos probables, riesgos y pruebas. Dividir trabajo por módulos solo si los contratos entre módulos están claros.
3. **Rama:** trabajar en una rama nueva por modificación, creada desde la rama base acordada. No trabajar directamente sobre la rama principal. No mezclar tareas independientes en una misma rama.
4. **TDD pragmático:** para reglas de negocio, permisos y regresiones:
   - escribir primero una prueba pequeña que exprese el comportamiento;
   - ejecutar esa prueba y comprobar que falla por el motivo esperado;
   - implementar el cambio mínimo;
   - ejecutar la prueba y comprobar que pasa;
   - refactorizar sin cambiar el comportamiento y volver a probar.

   Para cambios triviales de texto o presentación, usa criterio proporcional; no crees pruebas artificiales que no aporten protección.
5. **Verificar:** ejecutar las pruebas focalizadas y las verificaciones relevantes para los archivos modificados. Reportar exactamente qué se ejecutó y qué no.
6. **Revisar:** inspeccionar el diff completo, buscar secretos, cambios fuera de alcance, riesgos de autorización y migraciones incompatibles.
7. **Entregar:** preparar un PR para revisión humana, con resumen, motivo, pruebas/resultados, riesgos y decisiones pendientes. No hacer merge ni despliegue.

## 6. Seguridad de datos y ejecución de pruebas

- Nunca muestres, copies, incluyas en logs ni envíes a herramientas externas credenciales, datos personales o secretos.
- No ejecutes pruebas, migraciones, seeders ni comandos de limpieza hasta confirmar que apuntan a una base local/efímera y aislada.
- La configuración actual de PHPUnit debe inspeccionarse antes de ejecutar pruebas, porque podría apuntar a una base externa.
- No uses datos de producción. Usa factories y datos sintéticos.
- No ejecutes comandos destructivos o que alteren historial compartido sin autorización explícita.
- Toda autorización debe verificarse en el backend; ocultar botones en frontend no es un control de acceso.
- Las solicitudes `GET` deben ser de solo lectura y no modificar el estado del servidor.
- Para operaciones que cambian datos, utiliza el método HTTP que corresponda (`POST`, `PATCH`, `PUT` o `DELETE`) y aplica autenticación, autorización y protección CSRF donde corresponda.

## 7. Verificaciones

Adapta los comandos al entorno disponible y al cambio. No afirmes que una verificación pasó si no se ejecutó.

Comandos disponibles en el proyecto incluyen:

- Backend: `cd inventario && php artisan test`
- PHPStan: `cd inventario && composer run analyse`
- Estilo PHP sin modificar archivos: `cd inventario && vendor/bin/pint --test`
- Tipos TypeScript: `cd inventario && npm run types`
- Formato frontend sin modificar archivos: `cd inventario && npm run format:check`
- Build frontend: `cd inventario && npm run build`

Antes de ejecutar pruebas, confirma el aislamiento de la base. Evita `npm run lint` si no se ha confirmado su comportamiento: actualmente el script incluye `--fix` y puede modificar archivos.

## 8. Criterios de terminado

Una tarea está lista para revisión cuando:

- cumple la spec y los criterios de aceptación;
- respeta el aislamiento entre usuarios y las reglas del dominio;
- incluye pruebas proporcionadas al riesgo, especialmente para permisos y transiciones de estado;
- las verificaciones relevantes se ejecutaron y sus resultados están anotados;
- el diff no contiene secretos, artefactos ni cambios ajenos;
- cualquier migración, limitación o riesgo queda explicado en el PR;
- existe una rama de trabajo y un PR pendiente de aprobación humana.
