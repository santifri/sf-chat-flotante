<?php
/**
 * Template del botón flotante
 *
 * @package sf-chat-flotante
 * @since 1.0.0
 */

// Si este archivo es llamado directamente, abortar
if (!defined('WPINC')) {
    die;
}
?>

<div id="whatsapp-flotante-btn" class="wf-floating-button <?php echo esc_attr($position_class); ?>" role="button"
    aria-label="<?php esc_attr_e('Abrir WhatsApp', 'sf-chat-flotante'); ?>" tabindex="0">
    <img src="<?php echo esc_url($icon_url); ?>" alt="<?php esc_attr_e('WhatsApp', 'sf-chat-flotante'); ?>" class="wf-icon">
    <span class="wf-pulse"></span>
</div>