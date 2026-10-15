<?php
/**
 * Template para una fila de horario
 *
 * @package WhatsApp_Flotante
 * @since 1.0.0
 */

// Si este archivo es llamado directamente, abortar
if ( ! defined( 'WPINC' ) ) {
    die;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$sf_whatsapp_days_labels = array(
    0 => esc_html__( 'D', 'sf-whatsapp-chat-wordpress' ), // Domingo
    1 => esc_html__( 'L', 'sf-whatsapp-chat-wordpress' ), // Lunes
    2 => esc_html__( 'M', 'sf-whatsapp-chat-wordpress' ), // Martes
    3 => esc_html__( 'X', 'sf-whatsapp-chat-wordpress' ), // Miércoles
    4 => esc_html__( 'J', 'sf-whatsapp-chat-wordpress' ), // Jueves
    5 => esc_html__( 'V', 'sf-whatsapp-chat-wordpress' ), // Viernes
    6 => esc_html__( 'S', 'sf-whatsapp-chat-wordpress' ), // Sábado
);

$sf_whatsapp_selected_days = isset( $sf_whatsapp_schedule['days'] ) ? $sf_whatsapp_schedule['days'] : array();
?>

<div class="wf-schedule-row" data-schedule-index="<?php echo esc_attr( $sf_whatsapp_schedule_index ); ?>">
    <div class="wf-schedule-days">
        <label><?php esc_html_e( 'Días', 'sf-whatsapp-chat-wordpress' ); ?>:</label>
        <div class="wf-days-selector">
            <?php foreach ( $sf_whatsapp_days_labels as $sf_whatsapp_day_num => $sf_whatsapp_day_label ) : ?>
                <label class="wf-day-checkbox">
                    <input type="checkbox"
                        name="accounts[<?php echo esc_attr( $sf_whatsapp_account_index ); ?>][schedules][<?php echo esc_attr( $sf_whatsapp_schedule_index ); ?>][days][]"
                        value="<?php echo esc_attr( $sf_whatsapp_day_num ); ?>" <?php checked( in_array( $sf_whatsapp_day_num, $sf_whatsapp_selected_days, true ), true ); ?>>
                    <span><?php echo esc_html( $sf_whatsapp_day_label ); ?></span>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="wf-schedule-times">
        <div class="wf-time-field">
            <label><?php esc_html_e( 'Desde', 'sf-whatsapp-chat-wordpress' ); ?>:</label>
            <input type="time"
                name="accounts[<?php echo esc_attr( $sf_whatsapp_account_index ); ?>][schedules][<?php echo esc_attr( $sf_whatsapp_schedule_index ); ?>][start_time]"
                value="<?php echo esc_attr( isset( $sf_whatsapp_schedule['start_time'] ) ? $sf_whatsapp_schedule['start_time'] : '09:00' ); ?>"
                required>
        </div>

        <div class="wf-time-field">
            <label><?php esc_html_e( 'Hasta', 'sf-whatsapp-chat-wordpress' ); ?>:</label>
            <input type="time"
                name="accounts[<?php echo esc_attr( $sf_whatsapp_account_index ); ?>][schedules][<?php echo esc_attr( $sf_whatsapp_schedule_index ); ?>][end_time]"
                value="<?php echo esc_attr( isset( $sf_whatsapp_schedule['end_time'] ) ? $sf_whatsapp_schedule['end_time'] : '18:00' ); ?>"
                required>
        </div>
    </div>

    <div class="wf-schedule-actions">
        <button type="button" class="button button-link-delete wf-remove-schedule"
            title="<?php esc_attr_e( 'Eliminar horario', 'sf-whatsapp-chat-wordpress' ); ?>">
            <span class="dashicons dashicons-trash"></span>
        </button>
    </div>
</div>