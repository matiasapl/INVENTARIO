# Landing de portafolio — plataforma de inventario

## Objetivo

Reemplazar la página de bienvenida actual por una landing pública, en español, que presente la plataforma de gestión de inventarios como una demo funcional de portafolio. Debe ayudar a entender el producto y llevar a visitantes nuevos al registro individual. No es un sitio comercial ni una promesa de servicio listo para producción.

La landing corresponde a la plataforma INVENTARIO. El portafolio del autor es un sitio aparte (`https://mapl.dev/`) y se enlaza como tal.

## Audiencia y resultado esperado

- Visitantes del portafolio o del repositorio que quieran entender y probar la plataforma.
- Usuarios nuevos que puedan crear una cuenta individual, con sus propios datos separados de los demás usuarios.
- Usuarios existentes que necesiten iniciar sesión.

En pocos segundos el visitante debe entender qué gestiona la aplicación y encontrar cómo explorarla.

## Contenido y comportamiento

1. **Navegación:** identidad INVENTARIO; anclas a recorrido y funciones; CTA principal “Probar demo”; acceso “Iniciar sesión”. Si la persona ya está autenticada, los CTA de acceso llevan al dashboard en lugar de registro/login.
2. **Hero:** propuesta principal “Todo tu inventario, bajo control”, texto breve que nombre productos, almacenes, lotes y seguimiento de actividad, CTA “Probar demo” y una vista real de la aplicación. El CTA lleva al registro individual.
3. **Carrusel de capturas:** una galería accesible con capturas reales de la aplicación, mostrando contenido sintético de, como mínimo, estas cinco áreas: dashboard, productos, almacenes, lotes y actividad. Cada diapositiva incluye título, descripción breve y texto alternativo que identifique la vista sin repetir decoración. Las capturas se obtienen con Brave DevTools, sin cuentas ni información personal reales.
4. **Funciones:** describir únicamente capacidades comprobadas: gestionar productos, almacenes, lotes/cantidades y consultar el registro de actividad. No anunciar alertas, reportes, exportaciones, escaneo u otras funciones no verificadas.
5. **Recorrido:** explicar el flujo de exploración como producto → almacén → lote → consulta de actividad, sin presentarlo como requisito ni ocultar pantallas útiles.
6. **Acceso individual:** explicar que cada persona se registra y que su información de inventario no se comparte con otros usuarios. El CTA principal usa la ruta de registro existente; el acceso secundario usa login.
7. **Transparencia:** indicar de forma visible que se trata de una demo de portafolio con datos ficticios y que no debe usarse para administrar inventario real. Evitar garantías comerciales, métricas inventadas, testimonios ficticios o afirmaciones de disponibilidad/seguridad certificada.
8. **Tecnologías y autoría:** mostrar el stack real (Laravel, React, Inertia) y enlaces separados al repositorio `https://github.com/matiasapl/INVENTARIO` y al portafolio `https://mapl.dev/`.
9. **Cierre y pie:** repetir el CTA de demo y contener los enlaces de proyecto/autoría y la nota de uso demostrativo.

## Dirección visual propuesta

La dirección se inspira en señalética de almacén, etiquetas de ubicación y pasillos de estanterías, no en una plantilla SaaS genérica. El protagonismo visual es el carrusel con capturas auténticas de la interfaz; los elementos gráficos evocan líneas de ubicación y marcadores de inventario solo cuando aporten orientación.

Propuesta inicial de tokens para desarrollar y revisar durante la implementación:

- **Luz de almacén `#EAF0F2`:** fondo frío claro.
- **Papel de etiqueta `#FCFCFA`:** superficies de lectura.
- **Tinta azul petróleo `#173B4A`:** títulos y navegación de alto contraste.
- **Azul de ubicación `#39758A`:** enlaces/acciones secundarias.
- **Amarillo señal `#E8B23F`:** acento puntual para foco y orientación.
- **Acero `#AAB9BE`:** reglas, marcos y elementos de soporte.

Usar la paleta como una propuesta de diseño, comprobar contraste antes de cerrar y mantener consistencia con la interfaz existente. Tipografía: conservar Instrument Sans para lectura/interfaz y evaluar Barlow Semi Condensed solo para títulos de exhibición, con alternativas locales y carga razonable. Evitar fondos degradados, tarjetas clonadas, datos inventados y ornamentación sin función.

## Límites

- Alcance de implementación: landing pública y sus recursos visuales/interacciones.
- No rediseñar el dashboard ni los módulos de inventario.
- No alterar reglas de inventario, permisos, multiusuario, auditoría ni autenticación.
- No habilitar cuentas compartidas ni modificar el flujo individual de registro.
- No instalar dependencias de UI salvo que la inspección demuestre que no se puede cumplir el requisito con lo ya disponible; cualquier ampliación se consulta antes.
- No desplegar ni publicar cambios como parte de esta especificación.
- Las capturas deben usar exclusivamente datos sintéticos, sin emails, secretos o información personal.

## Accesibilidad y adaptación

- Usar estructura semántica con un `h1`, jerarquía de encabezados coherente, regiones `header`, `nav`, `main` y `footer` y enlaces/botones con nombres comprensibles.
- El carrusel no avanza automáticamente. Debe ofrecer controles anterior/siguiente, indicadores seleccionables, foco visible, uso por teclado y navegación táctil; anunciar el cambio de diapositiva a tecnologías de asistencia sin interrumpir innecesariamente.
- Respetar `prefers-reduced-motion`; no depender del movimiento para entender el contenido.
- Texto alternativo para capturas, contraste legible, navegación por teclado y diseño sin desbordamiento horizontal en móvil.

## Criterios de aceptación

- [ ] `/` presenta una landing en español cuyo propósito y condición de demo quedan claros.
- [ ] “Probar demo” conduce a registro individual; “Iniciar sesión” conduce al login; usuarios autenticados pueden continuar al dashboard.
- [ ] La landing explica solo funciones disponibles y enlaza correctamente el repositorio y `mapl.dev` como destinos distintos.
- [ ] Se incluyen al menos cinco capturas reales: dashboard, productos, almacenes, lotes y actividad, realizadas con Brave DevTools y datos sintéticos.
- [ ] El carrusel permite recorrer todas las capturas con botones, indicadores, teclado y tacto; no usa autoplay; tiene nombres accesibles y texto alternativo.
- [ ] La landing y el carrusel se entienden y funcionan en escritorio, tablet y móvil, sin scroll horizontal involuntario.
- [ ] No se exponen datos personales, secretos ni registros ajenos en texto, capturas o metadatos de imagen.
- [ ] Se verifica el flujo de CTA de registro/login y se confirma que los registros de usuarios continúan separados, sin cambiar reglas de negocio.
- [ ] Se comprueba accesibilidad básica, formato, tipos y build frontend; se revisa el resultado final en Brave DevTools con capturas de escritorio y móvil.

## Decisiones

- Registro por persona; no hay cuenta compartida.
- CTA principal: “Probar demo”.
- Los usuarios no comparten datos de inventario.
- El repositorio se enlaza desde la landing junto al portafolio separado.
- La landing debe mostrar las áreas relevantes de la aplicación en un carrusel.
- La demo no se representa como producto comercial ni como sistema apto para datos reales.
