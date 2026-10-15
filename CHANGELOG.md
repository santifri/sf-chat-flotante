# Changelog

## [Sin publicar]

### Correcciones

- Las actualizaciones automáticas toman del tag del release solo el número de
  versión. Antes solo se quitaba la `v` inicial, así que un tag con una errata
  (`version 1.2.0`) hacía que la actualización no se ofreciera nunca, y uno con
  basura detrás (`v1.2.0,`) se mostraba tal cual en el escritorio. Un tag sin
  ningún número se trata como un fallo de la consulta.

## [1.1.0] - 2026-09-28

### Modo compatible con caché

- Opción nueva **«Decidir el horario en el navegador (compatible con caché)»**,
  **desactivada por defecto**. Con ella apagada el comportamiento es idéntico al
  de la 1.0.6, comprobado comparando el HTML generado byte a byte.
- Con la opción activada, el botón se imprime siempre y oculto, cada cuenta lleva
  sus horarios en `data-wf-horarios`, y un script decide qué se ve. La hora se
  calcula en la zona del sitio con `Intl`, nunca con la del visitante.
- Evento `whatsappFlotante:estado` en `document` y variable global
  `window.whatsappFlotanteEstado`, con `{ abierto, cuentas, modo }`. Se publican
  en los dos modos.

### Actualizaciones automáticas

- El plugin se actualiza desde los releases de GitHub, como cualquier otro:
  WordPress avisa y se instala desde el escritorio. Hasta ahora había que subir
  el ZIP a mano web por web, que es la razón de que las instalaciones llegaran a
  acumular siete meses de retraso.
- La consulta se cachea 12 horas, y los fallos 1 hora, para no gastar el límite
  de la API de GitHub ni ralentizar el escritorio si no responde.
- Solo se consulta desde el escritorio, nunca en las visitas del frontend.

### Correcciones

- La hora de cierre ya no cuenta como disponible: un horario que termina a las
  20:00 deja de mostrarse a las 20:00:00, no a las 20:00:59.
- Deshecho el doble espaciado de `class-whatsapp-frontend.php`, que se colaba en
  el HTML generado.

### Novedades

- **Días de cierre**: lista de fechas `AAAA-MM-DD` en los ajustes. Esos días
  ninguna cuenta está disponible, en los dos modos.
- **Puntos de extensión** para adaptar el plugin desde el código de cada web sin
  tocarlo: filtros `whatsapp_flotante_is_open`, `whatsapp_flotante_holidays` y
  `whatsapp_flotante_available_accounts`.

### Cambios de nombre

- Vuelta al slug `sf-whatsapp-chat-wordpress`, que es el que tienen las
  instalaciones: permite actualizar en sitio en vez de reinstalar a mano. El
  nombre visible sigue siendo **SF Chat Flotante**.
- Text domain alineado con el slug. Estaba descuadrado desde la 1.0.1.


## [1.0.6] - 2026-08-06
- **Corregido**: el plugin no arrancaba. La clase principal había perdido su
  constructor y el método que carga e instancia el resto de clases, así que ni
  se mostraba la página de ajustes ni el botón en el frontend. No daba ningún
  error de PHP, simplemente no hacía nada.
- Corregido el text domain, que apuntaba a `whatsapp-flotante` en vez de
  `sf-chat-flotante`, impidiendo cargar las traducciones.
- Renombrado `languages/whatsapp-flotante.pot` a `sf-chat-flotante.pot` para
  que case con el text domain.
- Recuperados `.gitattributes`, `.gitignore` y el workflow de release, y
  actualizado en este el slug del ZIP.
- Normalizados a LF los finales de línea de los ficheros CSS y JS.

## [1.0.5] - 2026-07-11
- Renombrado del plugin a **SF Chat Flotante** (`sf-chat-flotante.php`, text domain `sf-chat-flotante`).
- Título y subtítulo del modal personalizables desde ajustes.
- Adaptación a los WordPress Coding Standards.
- Mejoras de seguridad: saneado y escapado más estrictos.
- Corregidos avisos de formato y de convenciones de nombres.

## [1.0.4]
- Corregidas discrepancias de text domain en las clases de administración.
- Añadido saneado que faltaba en los formularios del panel.

## [1.0.3] - 2026-02-04
- Revisión de seguridad: validación y saneado de entradas, nonces CSRF, escapado de salida.
- Normalización de finales de línea mediante `.gitattributes`.

## [1.0.1] - 2026-02-03
- Primera versión pública.
- Botón flotante de WhatsApp con múltiples cuentas.
- Horarios configurables y personalización básica.

## [1.0.0] - 2026-02-03
- Versión inicial (interno).
