# Constitución del proyecto — INVENTARIO

Versión: 1.0.0  
Fecha: 2026-10-15

## 1. Propósito y alcance

INVENTARIO es una aplicación multiusuario de gestión de inventario. Cada usuario debe consultar y modificar únicamente la información que le pertenece.

Esta constitución reúne los principios y requisitos del AGENTS.md original. Su existencia no certifica que el código ya los cumpla. Los incumplimientos observados y las ambigüedades están en `MEMORY.md`; los procedimientos están en `AGENTS.md`.

## 2. Autoridad y evidencia

Para instrucciones del proyecto, el orden es:

1. Instrucciones explícitas actuales del propietario.
2. `CONSTITUTION.md`.
3. Especificación aprobada para la tarea, dentro de los principios anteriores.
4. `AGENTS.md`.
5. Convenciones y decisiones verificables del repositorio.
6. `MEMORY.md`.
7. Suposiciones del agente.

El código, la configuración y las pruebas son evidencia del estado actual; no sustituyen por sí solos los requisitos aprobados. Una prueba puede estar desactualizada y una implementación existente puede contener un defecto.

Si el comportamiento requerido está claro, una diferencia con el código puede corregirse dentro de la tarea autorizada. Si falta una decisión de negocio o hay instrucciones incompatibles, consultar antes de cambiar el comportamiento afectado. Una excepción autorizada para una tarea no modifica automáticamente esta constitución.

## 3. Principios duraderos

### I. Propiedad y aislamiento de datos

- Cada usuario solo puede acceder y modificar sus propios productos, almacenes, lotes y registros.
- Validar en servidor la propiedad del recurso y de todas sus relaciones; no confiar en IDs del cliente ni en controles visuales.
- Un lote debe referenciar un producto y un almacén pertenecientes al mismo usuario que el lote.
- No añadir cuentas, planes, roles, administradores globales o multi-tenancy adicional sin una especificación autorizada. La posible evolución a SaaS freemium no justifica complejidad anticipada.

### II. Integridad del inventario

- Productos y almacenes pertenecen a un usuario.
- `habilitado` distingue uso normal y papelera; `eliminado` representa eliminación lógica. Los eliminados no deben aparecer en vistas normales ni en papelera.
- `estado` de productos y almacenes indica si pueden asociarse a un lote. Solo pueden asignarse recursos habilitados para uso y no eliminados.
- No deshabilitar ni eliminar productos o almacenes mientras exista un lote que los use. No inferir excepciones según el estado del lote sin una decisión explícita.
- Un lote representa unidades físicas de un producto ubicadas en un almacén.
- `estado` del lote representa disponibilidad o consumo/venta; esa transición es reversible.
- No permitir cantidades negativas. Esta prohibición no establece por sí sola si cero es válido.
- No realizar borrado físico sin una especificación y autorización explícitas.

Los valores concretos de los estados y los casos límite pendientes deben resolverse en la especificación que los afecte, sin deducir reglas nuevas de nombres de campos o comportamiento accidental.

### III. Trazabilidad y auditoría

- Toda operación iniciada por una persona que modifique la base de datos debe quedar auditada. El alcance de eventos y campos debe concretarse para cada flujo afectado, sin excluirlo por omisión.
- Registrar el estado anterior y el nuevo, vinculados a la misma operación y con orden inequívoco.
- Identificar actor, entidad afectada, acción y fecha; excluir contraseñas, tokens y otros secretos.
- El cambio de negocio y su auditoría deben ser atómicos: si falla la auditoría requerida, no debe persistir el cambio sin ella. Para efectos que no compartan transacción, especificar una estrategia que garantice esa obligación antes de implementar.
- No modificar silenciosamente registros de auditoría ni borrarlos en cascada sin una decisión explícita del propietario.
- Definir en la especificación cómo representar ausencia de estado anterior en creación, eliminación, retención y eventos de autenticación. No inventar esas convenciones.

### IV. Autenticación y seguridad de interacción

- El registro de usuarios permanece abierto.
- La verificación de correo y el segundo factor son opcionales; no convertirlos en requisitos obligatorios sin especificación y autorización.
- Las solicitudes GET deben ser de solo lectura y no modificar el estado del servidor.
- Las operaciones que cambian datos deben usar el método HTTP correspondiente y aplicar autenticación, autorización y protección CSRF donde corresponda.
- No incluir secretos ni datos personales sensibles en código compartido, documentación, memoria o logs.

### V. Cambios acotados y trabajo protegido

- Implementar el cambio mínimo suficiente y reutilizar herramientas y patrones presentes.
- Preservar el trabajo previo del propietario. No sobrescribir, revertir ni reformatear cambios ajenos como limpieza incidental.
- No ampliar reglas de negocio, dependencias o arquitectura fuera del alcance autorizado.
- No acceder a producción, hacer merge, desplegar o ejecutar operaciones destructivas sin autorización específica.

### VI. Verificación honesta

- Validar según el riesgo: permisos, relaciones, transiciones y auditoría requieren comprobaciones de comportamiento.
- Confirmar el aislamiento efectivo de los datos antes de ejecutar pruebas u operaciones que puedan alterarlos.
- No presentar configuración de pruebas, existencia de policies o compilación exitosa como prueba suficiente del cumplimiento funcional.
- Corregir los errores introducidos por el cambio y comunicar fallos preexistentes o de origen incierto sin ampliar el alcance automáticamente.
- No afirmar éxito de verificaciones no ejecutadas o fallidas.

## 4. Especificación y entrega

Los cambios no triviales deben definir objetivo, alcance, criterios observables y verificación antes de implementar. Los procedimientos y la organización de especificaciones están en `AGENTS.md`.

Las ambigüedades que afecten al resultado deben resolverse con el propietario; las partes independientes pueden continuar. La entrega debe ser revisable y expresar qué está implementado, qué fue comprobado y qué sigue pendiente.

## 5. Gobierno y mantenimiento

- El propietario decide cambios de propósito, principios, reglas de negocio y excepciones.
- No debilitar reglas para facilitar una implementación o hacer pasar una prueba.
- Toda enmienda debe explicar qué cambia, por qué y qué documentos o especificaciones requieren alineación.
- Actualizar versión y fecha: mayor para cambios incompatibles de principios, menor para adiciones y parche para aclaraciones sin alterar obligaciones.
- Mantener procedimientos en `AGENTS.md` y estado verificado en `MEMORY.md`. Evitar duplicar reglas que puedan divergir.
