# Flujo de trabajo de especificaciones

Esta carpeta contiene especificaciones que el proyecto decidió conservar y el seguimiento de
algunos cambios no triviales. Una especificación define el resultado esperado; el plan describe
cómo abordarlo; las tareas permiten verificar el avance. Ninguno de estos documentos autoriza
por sí solo cambios fuera del alcance acordado.

## Estructura

Cuando convenga conservar una especificación, crear una carpeta
`specs/<nombre-descriptivo>/` con:

- `SPEC.md`: objetivo, comportamiento esperado, alcance, límites, decisiones pendientes y
  criterios de aceptación observables.
- `PLAN.md`: enfoque técnico, archivos o módulos afectados, riesgos y verificaciones previstas.
- `TASKS.md`: lista de tareas pequeñas y comprobables, con su estado actualizado.

Mantener estos nombres en mayúsculas para seguir la convención de `AGENTS.md`.

## Secuencia de trabajo

1. **Inspeccionar:** leer `CONSTITUTION.md`, `AGENTS.md`, `MEMORY.md`, el estado de Git y el
   código y las pruebas pertinentes. Preservar cambios existentes.
2. **Definir el cambio:** para cambios no triviales, concretar objetivo, alcance, criterios
   observables y verificación antes de implementar. Resolver ambigüedades de negocio con el
   propietario. Si conviene conservar la especificación, usar la estructura indicada arriba.
3. **Planificar:** cuando se conserve la especificación, documentar el enfoque, riesgos y
   verificaciones; dividir el trabajo en tareas comprobables si aporta claridad.
4. **Implementar:** para reglas de negocio, permisos y regresiones, aplicar TDD pragmático:
   prueba focalizada, fallo por el motivo esperado, cambio mínimo y comprobación posterior. Si el
   entorno impide ejecutar la prueba, comunicarlo sin afirmar que se completó el ciclo.
5. **Comprobar y entregar:** ejecutar verificaciones proporcionales al riesgo, revisar sus efectos
   y el diff, y actualizar el estado de las tareas documentadas. Resumir qué se implementó, qué
   se verificó, qué falló o no se pudo ejecutar y qué queda pendiente.

## Reglas de verificación

- Probar comportamiento, no solo la existencia de una pantalla, policy, migración o prueba.
- Antes de ejecutar pruebas, migraciones o seeders que accedan a datos, verificar el aislamiento
  efectivo de la base. Usar datos sintéticos.
- No cambiar criterios de aceptación para hacer coincidir una implementación defectuosa.
- Si una prueba no puede ejecutarse, documentar la limitación; no afirmar que pasó.
- Para cambios solo documentales o de presentación trivial, aplicar verificación proporcional;
  no crear pruebas artificiales.
- Revisar si el build genera o modifica artefactos y reportarlos.
- No corregir problemas ajenos al alcance sin autorización.
