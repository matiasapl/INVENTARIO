# Plan — landing de demo de inventario

## Enfoque

Aplicar la skill `frontend-design` instalada en `.agents/skills/frontend-design`. Antes de implementar, definir una dirección visual específica de inventario y revisar que no caiga en los patrones genéricos que la skill desaconseja. Mantener el cambio pequeño: página pública, capturas preparadas con datos sintéticos, contenido preciso y navegación accesible.

### Concepto visual y composición

**Una idea memorable:** un “pasillo digital” construido con encuadres de producto y señales de ubicación, donde las capturas reales sean el material protagonista. No simular almacenes con ilustraciones genéricas ni maquillar la interfaz con métricas falsas.

**Tokens iniciales (sujetos a comprobación de contraste):** luz de almacén `#EAF0F2`, papel `#FCFCFA`, tinta azul petróleo `#173B4A`, azul de ubicación `#39758A`, amarillo señal `#E8B23F`, acero `#AAB9BE`.

**Tipografía:** Instrument Sans para cuerpo y controles, ya presente en el proyecto; evaluar Barlow Semi Condensed para títulos, con fallback local. Evitar añadir paquete de tipografías; revisar licencia/disponibilidad y coste de carga antes de elegir fuente externa.

**Alineación:** contenido mayormente alineado a la izquierda para lectura y escaneo; una composición asimétrica en el hero equilibra mensaje/CTA con una captura real. Contenedor centrado con ancho legible. El carrusel ocupa una franja prominente, con controles asociados visualmente a la imagen.

**Wireframe principal:**

```text
┌ INVENTARIO ───── Funciones  Recorrido  Tecnologías ───── Iniciar sesión ┐
│                                                                        │
│ Todo tu inventario,                   ┌────────────────────────────┐   │
│ bajo control.                         │ captura real del dashboard │   │
│ Productos, almacenes y lotes          │                             │   │
│ en una demo para explorar.            └────────────────────────────┘   │
│ [Probar demo]                                                         │
├────────────────────────────────────────────────────────────────────────┤
│ Explora la plataforma  [captura activa: dashboard/productos/...]       │
│ [anterior]             [etiqueta y descripción]       [siguiente]      │
│                    ● ○ ○ ○ ○                                           │
├────────────────────────────────────────────────────────────────────────┤
│ Funciones reales → recorrido de uso → aviso de demo → stack/autoría    │
└────────────────────────────────────────────────────────────────────────┘
```

En móvil, la navegación se compacta sin ocultar acceso; el hero se apila, la captura conserva un tamaño útil y el carrusel se controla con botones grandes y gestos táctiles, sin desplazar el viewport horizontalmente.

**Principios:** mostrar el producto real; tono directo y español natural; datos sintéticos; una jerarquía clara; movimiento solo como respuesta a interacción; contraste, foco visible y movimiento reducido; texto breve y verificable.

**Autocrítica antes del código:** si la propuesta se reduce a un hero centrado, degradado, estadísticas inventadas y tarjetas idénticas, volver al material concreto de inventario. El recurso protagonista debe ser la secuencia de capturas reales y su recorrido por las áreas del producto.

## Archivos y módulos probables

- `inventario/resources/js/pages/welcome.tsx`: composición y copy de la landing.
- `inventario/resources/css/app.css` o CSS acotado de la página: tokens y layout, evitando afectar módulos autenticados.
- `inventario/tests/Feature/` prueba de landing/CTA: respuesta pública, destinos de enlaces y props de autenticación/registro.
- `inventario/public/images/landing/`: capturas optimizadas de dashboard, productos, almacenes, lotes y actividad.
- `inventario/routes/web.php`: solo si la inspección confirma que los destinos actuales no satisfacen el flujo definido; no cambiar rutas de negocio por conveniencia visual.
- `inventario/resources/js/components/`: componente de carrusel solo si mejora claridad/reutilización; preferir implementación local y sin dependencia nueva.

## Fases

1. Verificar skill disponible, estado del branch, rutas de registro/login/dashboard, acceso por usuario y stack CSS/React actual.
2. Confirmar localización de registros, carga real del dashboard y método seguro de crear registros sintéticos en el entorno Docker aislado.
3. Escribir prueba focalizada para `/` y CTA; ejecutar en una MariaDB aislada y confirmar fallo esperado antes del cambio.
4. Capturar en Brave DevTools las cinco vistas usando una cuenta/fixtures sintéticos. Revisar y optimizar imágenes; excluir datos personales.
5. Implementar estructura semántica, contenido, layout y carrusel accesible con controles manuales, indicadores, teclado y tacto.
6. Añadir/ajustar prueba de comportamiento y destinos; completar responsive, metadatos y enlaces.
7. Ejecutar pruebas pertinentes, comprobación TypeScript/formato y build según los scripts reales; revisar artefactos.
8. Revisar con Brave DevTools en escritorio/tablet/móvil: composición, recortes de capturas, flujo de enlaces, controles del carrusel, foco, consola y ausencia de overflow.
9. Revisar diff/secretos/activos y actualizar tareas; no desplegar ni publicar.

## Riesgos y mitigaciones

- **Prueba sobre base con datos:** usar la barrera opt-in existente y una MariaDB efímera/claramente aislada; no ejecutar pruebas contra la base persistente del demo.
- **Capturas con datos reales o incompletos:** crear usuario y registros sintéticos en entorno aislado, inspeccionar cada imagen y retirar cualquier dato identificable.
- **Promesas no implementadas:** limitar copy a funciones observadas y a los criterios de esta spec.
- **Carrusel inaccesible o difícil de descubrir:** sin autoplay; controles visibles y etiquetados, teclado, tacto, indicadores, foco, `aria-live` discreto y prueba de movimiento reducido.
- **Dependencia externa de fuentes:** fallback local y coste aceptable; no sumar dependencia JS para carrusel salvo autorización.
- **Cambios visuales globales:** encapsular estilos de landing para no alterar dashboard/módulos existentes.
- **Build genera artefactos:** identificar y revisar archivos generados; no incluir salidas locales irrelevantes.

## Verificación prevista

- Test HTTP focalizado de landing/CTA en base de prueba aislada.
- Validar navegación por registro/login y acceso con cuenta autenticada; confirmar el aislamiento existente por usuario en pruebas pertinentes, sin ampliar lógica de negocio.
- `npm run types`; formato focalizado o `npm run format:check` previa revisión de sus resultados y del estado conocido; `npm run build` como verificación final del frontend.
- Si se usa PHP test suite, demostrar conexión efectiva a MariaDB única, efímera y no persistente antes de ejecutarla.
- Revisión visual con Brave DevTools a 1440×900, 768×1024 y 390×844; verificar todas las diapositivas, enlaces, teclado, tacto, foco, contraste, texto alternativo, `prefers-reduced-motion`, errores de consola y ancho del documento.
- Revisar `git diff`, `git status`, assets, datos sintéticos y ausencia de secretos.
