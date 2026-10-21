# Guía para agentes — INVENTARIO

## 1. Función y documentos relacionados

Este archivo define cómo trabajar en el proyecto. Antes de modificarlo, leer `CONSTITUTION.md`, este archivo y `MEMORY.md`.

- `CONSTITUTION.md`: propósito, principios y reglas duraderas del dominio.
- `AGENTS.md`: procedimientos, seguridad de ejecución y verificaciones.
- `MEMORY.md`: contexto técnico verificado, brechas conocidas y decisiones pendientes.
- Especificaciones: resultado y criterios de aceptación de cada cambio no trivial.

La prioridad normativa y la distinción entre requisitos y estado actual están en la constitución. No interpretar una brecha registrada en memoria como autorización para corregirla fuera de la tarea.

## 2. Alcance y autonomía

Trabajar en la tarea solicitada y realizar el cambio mínimo suficiente. Reutilizar herramientas y convenciones existentes antes de introducir dependencias, abstracciones o cambios de arquitectura.

Resolver con evidencia las diferencias cuyo resultado esperado ya esté definido por la solicitud o una especificación aprobada. Una prueba desactualizada o un incumplimiento conocido del código no obliga por sí solo a detener todo el trabajo.

Consultar cuando falte una decisión de negocio, existan instrucciones incompatibles o la solución requiera ampliar el alcance. Continuar las partes independientes mientras se aclara lo afectado. No inventar reglas ni corregir problemas ajenos a la tarea.

Una solicitud de cambio no autoriza por sí sola acceso a producción, uso de credenciales reales, merge, despliegue, acciones destructivas o migraciones sobre bases no aisladas. Esas acciones requieren autorización específica y las comprobaciones de seguridad correspondientes.

## 3. Inspección y protección del trabajo existente

1. Leer la solicitud y los documentos aplicables; inspeccionar código, configuración y pruebas pertinentes.
2. Antes de editar, revisar estado y diff de Git. Tratar los cambios ajenos como trabajo del usuario y revisar el diff de cada archivo ya modificado.
3. No sobrescribir, revertir, reformatear ni limpiar cambios ajenos. Si no es posible aislar una edición, explicar el conflicto antes de modificar ese fragmento.
4. No editar dependencias instaladas ni salidas generadas manualmente. Si una herramienta genera archivos, revisar que sean pertinentes y reportarlos.
5. Verificar el flujo completo: una policy, pantalla, migración o prueba aislada no demuestra que una funcionalidad esté implementada.

Las consultas de lectura y auditorías documentales no necesitan ramas, PR ni comprobaciones operativas ajenas al objetivo.

## 4. Especificación proporcional

Para cambios no triviales, definir antes de implementar: objetivo, alcance, criterios de aceptación, riesgos y verificación. No se requiere instalar herramientas SDD.

Cuando convenga conservar una especificación, usar `specs/<nombre-descriptivo>/` en la raíz del repositorio:

- `SPEC.md`: comportamiento esperado, límites, decisiones pendientes y criterios de aceptación.
- `PLAN.md`: enfoque, archivos afectados, riesgos y verificaciones.
- `TASKS.md`: tareas comprobables y su progreso.

Este es el convenio para nuevas especificaciones; no implica que ya existan. Los ajustes pequeños pueden describirse en la conversación. No modificar criterios aprobados para hacer coincidir una implementación defectuosa.

## 5. Implementación y entrega

1. Resumir el alcance y cómo se comprobará el resultado.
2. Para cambios de código, usar una rama de trabajo desde la base acordada o continuar una rama existente destinada a la misma tarea. No mezclar tareas independientes ni modificar la rama principal salvo instrucción explícita.
3. Para reglas de negocio, permisos y regresiones, aplicar TDD pragmático: prueba focalizada, fallo por el motivo esperado, cambio mínimo y comprobación posterior. Si el entorno impide ejecutar la prueba, comunicarlo sin afirmar que se completó el ciclo.
4. Para texto, documentación o presentación trivial, usar comprobaciones proporcionales; no crear pruebas artificiales.
5. Revisar el diff final, los riesgos de autorización, los secretos y las migraciones incompatibles.
6. Preparar un PR cuando la entrega acordada incluya publicación y exista acceso. Si se pidió una entrega local o publicar no es posible, entregar el cambio revisable e indicar lo pendiente; no afirmar que existe un PR.
7. Informar qué cambió, qué se comprobó y qué limitaciones quedan. No hacer merge ni desplegar sin autorización específica.

## 6. Seguridad de ejecución

- No mostrar, copiar a documentación, registrar en logs ni enviar a servicios externos credenciales, datos personales o secretos. Al inspeccionar configuración sensible, extraer solo metadatos necesarios y ocultar valores.
- Antes de ejecutar pruebas que accedan a datos, migraciones, seeders o limpieza, demostrar que la conexión efectiva apunta a una base local o efímera y aislada. Revisar configuración de pruebas, variables de entorno y caché de configuración aplicables, sin divulgar secretos.
- Un host local o un nombre terminado en `test` no demuestra aislamiento. Si no puede establecerse, no ejecutar esas operaciones y comunicar la limitación.
- Usar factories y datos sintéticos. No usar datos de producción.
- No ejecutar acciones destructivas ni alterar historial compartido sin autorización explícita.
- Revisar los scripts antes de ejecutarlos: una verificación puede reformatear archivos, limpiar cachés o generar artefactos.

## 7. Verificaciones

Ejecutar desde `inventario/`, adaptando el comando al entorno y al alcance:

| Comprobación | Comando | Condiciones |
| --- | --- | --- |
| Backend | `php artisan test` | Confirmar aislamiento; preferir primero pruebas focalizadas. |
| Análisis PHP | `composer run analyse` | Revisar el script y sus efectos auxiliares. |
| Estilo PHP | `vendor/bin/pint --test` | Comprobar sin reformatear. |
| Tipos frontend | `npm run types` | Comprobar contratos TypeScript. |
| Formato frontend | `npm run format:check` | Comprobar sin reformatear. |
| Build frontend | `npm run build` | Puede generar artefactos; revisar efectos. |

Para lint, comprobar primero el script. No usar una variante con corrección automática como si fuera de solo lectura; elegir el modo de comprobación de la herramienta instalada cuando corresponda.

Para permisos y relaciones, comprobar tanto el recurso solicitado como sus referencias. Para cambios visuales, revisar navegación, adaptación de pantalla y accesibilidad básica cuando corresponda.

Si una comprobación falla, determinar con evidencia si el problema fue introducido o era preexistente. Corregir los errores propios sin ampliar el alcance para resolver los ajenos. Si el origen es incierto, decirlo. No declarar exitosa una comprobación fallida, omitida o no ejecutable.

## 8. Criterios de entrega y mantenimiento documental

Una modificación está lista para revisión cuando cumple los criterios acordados, preserva cambios ajenos, incluye validación proporcional y explica riesgos, migraciones y limitaciones. No declarar terminada una funcionalidad con criterios pendientes; distinguir cambio entregado de verificación pendiente.

Actualizar `MEMORY.md` solo con contexto duradero y verificado. Mantenerlo compacto, sustituir información obsoleta y diferenciar estado actual, brechas y decisiones pendientes. No guardar secretos, un historial de tareas ni copias de las reglas de estos documentos.

Cambiar la constitución solo cuando la tarea autorice la modificación de sus principios o reglas. Mantener alineadas las referencias entre documentos.
