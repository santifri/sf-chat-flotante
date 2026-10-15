<?php
/**
 * Template para una fila de cuenta
 *
 * @package WhatsApp_Flotante
 * @since 1.0.0
 */

// Si este archivo es llamado directamente, abortar
if ( ! defined( 'WPINC' ) ) {
    die;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>

<div class="wf-account-row" data-index="<?php echo esc_attr( $sf_whatsapp_index ); ?>">
    <input type="hidden" name="accounts[<?php echo esc_attr( $sf_whatsapp_index ); ?>][id]" value="<?php echo esc_attr( isset( $sf_whatsapp_account['id'] ) ? $sf_whatsapp_account['id'] : '' ); ?>">
    
    <div class="wf-account-header">
        <div class="wf-account-toggle">
            <label class="wf-switch">
                <input type="checkbox" 
                       name="accounts[<?php echo esc_attr( $sf_whatsapp_index ); ?>][active]" 
                       value="1" 
                       <?php checked( isset( $sf_whatsapp_account['active'] ) ? $sf_whatsapp_account['active'] : true, true ); ?>>
                <span class="wf-slider"></span>
            </label>
        </div>

        <div class="wf-account-fields">
            <div class="wf-field">
                <label><?php esc_html_e( 'Etiqueta', 'sf-whatsapp-chat-wordpress' ); ?> *</label>
                <input type="text" 
                       name="accounts[<?php echo esc_attr( $sf_whatsapp_index ); ?>][label]" 
                       value="<?php echo esc_attr( isset( $sf_whatsapp_account['label'] ) ? $sf_whatsapp_account['label'] : '' ); ?>" 
                       placeholder="<?php esc_attr_e( 'Ej: Ventas', 'sf-whatsapp-chat-wordpress' ); ?>"
                       required>
            </div>

            <div class="wf-field">
                <label><?php esc_html_e( 'Teléfono', 'sf-whatsapp-chat-wordpress' ); ?> *</label>
                <input type="text" 
                       name="accounts[<?php echo esc_attr( $sf_whatsapp_index ); ?>][phone]" 
                       value="<?php echo esc_attr( isset( $sf_whatsapp_account['phone'] ) ? $sf_whatsapp_account['phone'] : '' ); ?>" 
                       placeholder="<?php esc_attr_e( 'Ej: +34612345678', 'sf-whatsapp-chat-wordpress' ); ?>"
                       required>
                <small class="wf-field-help"><?php esc_html_e( 'Formato internacional: +34 seguido del número (ej: +34612345678)', 'sf-whatsapp-chat-wordpress' ); ?></small>
            </div>

            <div class="wf-field wf-field-wide">
                <label><?php esc_html_e( 'Mensaje predeterminado', 'sf-whatsapp-chat-wordpress' ); ?></label>
                <input type="text" 
                       name="accounts[<?php echo esc_attr( $sf_whatsapp_index ); ?>][message]" 
                       value="<?php echo esc_attr( isset( $sf_whatsapp_account['message'] ) ? $sf_whatsapp_account['message'] : '' ); ?>" 
                       placeholder="<?php esc_attr_e( 'Ej: Hola, me gustaría obtener más información', 'sf-whatsapp-chat-wordpress' ); ?>">
            </div>

            <div class="wf-field wf-field-wide">
                <label><?php esc_html_e( 'Mensaje de estado', 'sf-whatsapp-chat-wordpress' ); ?></label>
                <input type="text" 
                       name="accounts[<?php echo esc_attr( $sf_whatsapp_index ); ?>][status_message]" 
                       value="<?php echo esc_attr( isset( $sf_whatsapp_account['status_message'] ) ? $sf_whatsapp_account['status_message'] : '' ); ?>" 
                       placeholder="<?php esc_attr_e( 'Ej: Solicitar cita previa en el taller', 'sf-whatsapp-chat-wordpress' ); ?>">
                <small class="wf-field-help"><?php esc_html_e( 'Este mensaje se mostrará en el modal bajo el nombre de la cuenta', 'sf-whatsapp-chat-wordpress' ); ?></small>
            </div>
        </div>

        <div class="wf-account-actions">
            <?php 
            $sf_whatsapp_stats = get_option( 'whatsapp_flotante_stats', array() );
            $sf_whatsapp_account_id = isset( $sf_whatsapp_account['id'] ) ? $sf_whatsapp_account['id'] : '';
            $sf_whatsapp_clicks = isset( $sf_whatsapp_stats[ $sf_whatsapp_account_id ] ) ? $sf_whatsapp_stats[ $sf_whatsapp_account_id ] : 0;
            ?>
            <span class="wf-stats-badge" title="<?php esc_attr_e( 'Clics totales', 'sf-whatsapp-chat-wordpress' ); ?>">
                <span class="dashicons dashicons-chart-bar"></span>
                <?php echo esc_html( $sf_whatsapp_clicks ); ?>
            </span>

            <button type="button" class="button button-link-delete wf-remove-account" title="<?php esc_attr_e( 'Eliminar cuenta', 'sf-whatsapp-chat-wordpress' ); ?>">
                <span class="dashicons dashicons-trash"></span>
            </button>
        </div>
    </div>

    <div class="wf-account-schedules">
        <h4><?php esc_html_e( 'Horarios de disponibilidad', 'sf-whatsapp-chat-wordpress' ); ?></h4>
        <p class="description">
            <?php esc_html_e( 'Si no configuras horarios, la cuenta estará disponible siempre. Puedes añadir múltiples rangos horarios.', 'sf-whatsapp-chat-wordpress' ); ?>
        </p>

        <div class="wf-schedules-container" data-account-index="<?php echo esc_attr( $sf_whatsapp_index ); ?>">
            <?php if ( ! empty( $sf_whatsapp_account['schedules'] ) ) : ?>
                <?php foreach ( $sf_whatsapp_account['schedules'] as $sf_whatsapp_schedule_index => $sf_whatsapp_schedule ) : ?>
                    <?php 
                    $sf_whatsapp_account_index = $sf_whatsapp_index;
                    include WHATSAPP_FLOTANTE_PLUGIN_DIR . 'admin/templates/schedule-row.php'; 
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary button-small wf-add-schedule" data-account-index="<?php echo esc_attr( $sf_whatsapp_index ); ?>">
            <span class="dashicons dashicons-plus-alt"></span>
            <?php esc_html_e( 'Añadir horario', 'sf-whatsapp-chat-wordpress' ); ?>
        </button>
    </div>
</div>
