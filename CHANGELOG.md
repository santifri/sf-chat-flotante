# Changelog

## [Sin publicar] — 1.1.0

- Revertido el nombre de fichero y carpeta a `sf-whatsapp-chat-wordpress`, que es
  el que tienen las instalaciones en producción. El renombrado a
  `sf-chat-flotante` de la 1.0.5 convertía cada actualización en una
  desinstalación y reinstalación manual. El nombre visible sigue siendo
  **SF Chat Flotante**.
- Text domain alineado con el slug: `sf-whatsapp-chat-wordpress`. Estaba
  desajustado desde la 1.0.1, donde la cabecera declaraba un dominio y el código
  pedía otro.

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
