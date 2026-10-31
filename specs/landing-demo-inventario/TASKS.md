# Tareas — landing de demo de inventario

Estados: `Pendiente`, `En curso`, `Hecha`, `Bloqueada`.

## Preparación

- [x] Revisar la skill `frontend-design` instalada y aplicar sus instrucciones de plan visual/crítica.
- [x] Verificar rutas y experiencia actual de visitante, registro individual, login y dashboard.
- [x] Confirmar un entorno Docker/MariaDB aislado para crear datos sintéticos y ejecutar pruebas.

## Capturas y contenido

- [x] Crear usuario y datos sintéticos suficientes para poblar las áreas que aparecerán en capturas.
- [x] Capturar con Brave DevTools dashboard, productos, almacenes, lotes y actividad.
- [x] Revisar que las capturas no expongan datos personales, credenciales, tokens ni ruido de navegador.
- [x] Optimizar y guardar las capturas finales en `inventario/public/images/landing/`.
- [x] Implementar el copy acordado, la nota de demo, los CTA de registro/login y los enlaces a portafolio/repositorio.

## Implementación y comportamiento

- [x] Escribir/ejecutar prueba focalizada de landing y destinos CTA; demostrar aislamiento de base antes de pruebas con BD.
- [x] Implementar la composición visual distintiva y responsive de landing.
- [x] Implementar carrusel manual accesible con cinco áreas, flechas, indicadores, teclado y tacto; sin autoplay.
- [x] Añadir texto alternativo, estados de foco, movimiento reducido y metadatos básicos.
- [x] Confirmar que usuarios autenticados van al dashboard y que la landing no altera autenticación, inventario ni aislamiento de datos.

## Verificación y cierre

- [x] Ejecutar suite PHP en MariaDB efímera aislada, verificaciones de TypeScript/formato y Pint focalizado.
- [x] Ejecutar build frontend y revisar que los archivos de build estén ignorados; no añadir artefactos generados.
- [x] Revisar en Brave DevTools escritorio/tablet/móvil el carrusel, CTAs, teclado, tacto y overflow; precargar las cinco capturas para evitar flashes al cambiar.
- [x] Revisar visualmente contraste y legibilidad; corregir defectos propios.
- [x] Revisar diff, secretos y activos; documentar resultados reales y actualizar el estado de tareas.
- [x] No desplegar, publicar, hacer merge ni modificar ramas compartidas dentro de esta tarea.
