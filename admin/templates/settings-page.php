<?php
/**
 * Template de la página de configuración del admin
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

<div class="wrap whatsapp-flotante-admin">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <?php 
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( isset( $_GET['updated'] ) && sanitize_text_field( wp_unslash( $_GET['updated'] ) ) === 'true' ) : 
    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e( 'Configuración guardada correctamente.', 'sf-whatsapp-chat-wordpress' ); ?></p>
        </div>
    <?php endif; ?>

    <?php 
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( isset( $_GET['breakpoint_adjusted'] ) && sanitize_text_field( wp_unslash( $_GET['breakpoint_adjusted'] ) ) === 'true' ) : 
    ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php esc_html_e( 'Nota: Los breakpoints fueron ajustados automáticamente. El breakpoint de Tablet debe ser mayor que el de Móvil. Se han establecido valores estándar: Tablet 1024px, Móvil ≤768px.', 'sf-whatsapp-chat-wordpress' ); ?></p>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="whatsapp-flotante-form">
        <?php wp_nonce_field( 'whatsapp_flotante_save', 'whatsapp_flotante_nonce' ); ?>
        <input type="hidden" name="action" value="whatsapp_flotante_save">

        <!-- Botón de guardar superior -->
        <div class="wf-header-actions">
            <?php submit_button( esc_html__( 'Guardar configuración', 'sf-whatsapp-chat-wordpress' ), 'primary', 'submit', false ); ?>
        </div>

        <!-- Sección de icono y posición (2 columnas) -->
        <div class="wf-section">
            <h2><?php esc_html_e( 'Apariencia del botón', 'sf-whatsapp-chat-wordpress' ); ?></h2>
            <p class="description">
                <?php esc_html_e( 'Personaliza el icono y la posición del botón flotante.', 'sf-whatsapp-chat-wordpress' ); ?>
            </p>

            <div class="wf-appearance-grid">
                <!-- Columna Izquierda: Icono -->
                <div class="wf-column">
                    <h3><?php esc_html_e( 'Icono', 'sf-whatsapp-chat-wordpress' ); ?></h3>
                    <p class="description-small"><?php esc_html_e( 'Selecciona una imagen personalizada.', 'sf-whatsapp-chat-wordpress' ); ?></p>
                    
                    <div class="wf-icon-selector">
                        <input type="hidden" name="custom_icon" id="custom_icon"
                            value="<?php echo esc_attr( $custom_icon_id ); ?>">

                        <div class="wf-icon-preview" id="icon-preview">
                            <?php if ( $custom_icon_url ) : ?>
                                <img src="<?php echo esc_url( $custom_icon_url ); ?>"
                                    alt="<?php esc_attr_e( 'Icono personalizado', 'sf-whatsapp-chat-wordpress' ); ?>">
                            <?php else : ?>
                                <div class="wf-no-icon">
                                    <span class="dashicons dashicons-format-image"></span>
                                    <p><?php esc_html_e( 'Sin icono personalizado', 'sf-whatsapp-chat-wordpress' ); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="wf-icon-buttons">
                            <button type="button" class="button" id="select-icon-btn">
                                <?php esc_html_e( 'Seleccionar imagen', 'sf-whatsapp-chat-wordpress' ); ?>
                            </button>
                            <button type="button" class="button" id="remove-icon-btn" <?php echo $custom_icon_url ? '' : 'style="display:none;"'; ?>>
                                <?php esc_html_e( 'Eliminar imagen', 'sf-whatsapp-chat-wordpress' ); ?>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Posición -->
                <div class="wf-column">
                    <h3><?php esc_html_e( 'Ubicación', 'sf-whatsapp-chat-wordpress' ); ?></h3>
                    <p class="description-small"><?php esc_html_e( 'Elige dónde mostrar el botón.', 'sf-whatsapp-chat-wordpress' ); ?></p>

                    <div class="wf-position-selector-compact">
                        <?php
                        $sf_whatsapp_positions = array(
                            'bottom-right' => esc_html__( 'Inferior Derecha', 'sf-whatsapp-chat-wordpress' ),
                            'bottom-left'  => esc_html__( 'Inferior Izquierda', 'sf-whatsapp-chat-wordpress' ),
                        );

                        foreach ( $sf_whatsapp_positions as $sf_whatsapp_value => $sf_whatsapp_label ) :
                        ?>
                            <label class="wf-position-option-compact">
                                <input type="radio" name="icon_position" value="<?php echo esc_attr( $sf_whatsapp_value ); ?>"
                                    <?php checked( $icon_position, $sf_whatsapp_value ); ?>>
                                <span class="wf-position-label"><?php echo esc_html( $sf_whatsapp_label ); ?></span>
                                <div class="wf-mini-preview wf-mini-<?php echo esc_attr( $sf_whatsapp_value ); ?>"></div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="wf-margins-settings">
                        <h4><?php esc_html_e( 'Ajuste de posición (Márgenes)', 'sf-whatsapp-chat-wordpress' ); ?></h4>
                        
                        <!-- Pestañas -->
                        <div class="wf-tabs-nav">
                            <a href="#" class="wf-tab-link active" data-tab="tab-desktop"><?php esc_html_e( 'Escritorio', 'sf-whatsapp-chat-wordpress' ); ?></a>
                            <a href="#" class="wf-tab-link" data-tab="tab-tablet"><?php esc_html_e( 'Tablet', 'sf-whatsapp-chat-wordpress' ); ?></a>
                            <a href="#" class="wf-tab-link" data-tab="tab-mobile"><?php esc_html_e( 'Móvil', 'sf-whatsapp-chat-wordpress' ); ?></a>
                        </div>

                        <!-- Contenido Desktop -->
                        <div id="tab-desktop" class="wf-tab-content active">
                            <div class="wf-margins-row">
                                <div class="wf-field-inline">
                                    <label for="margin_bottom"><?php esc_html_e( 'Inferior', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <div class="wf-input-group">
                                        <input type="number" name="margin_bottom" id="margin_bottom" 
                                            value="<?php echo esc_attr( $margin_bottom ); ?>" min="0" step="1" class="small-text">
                                        <select name="margin_bottom_unit" class="wf-unit-selector">
                                            <option value="px" <?php selected( $margin_bottom_unit, 'px' ); ?>>px</option>
                                            <option value="%" <?php selected( $margin_bottom_unit, '%' ); ?>>%</option>
                                            <option value="rem" <?php selected( $margin_bottom_unit, 'rem' ); ?>>rem</option>
                                            <option value="em" <?php selected( $margin_bottom_unit, 'em' ); ?>>em</option>
                                        </select>
                                    </div>
                                    <span class="wf-saved-value">
                                        <?php 
                                        /* translators: 1: value, 2: unit */
                                        printf( esc_html__( 'Actual: %1$s%2$s', 'sf-whatsapp-chat-wordpress' ), esc_html( $margin_bottom ), esc_html( $margin_bottom_unit ) ); 
                                        ?>
                                    </span>
                                </div>

                                <div class="wf-field-inline">
                                    <label for="margin_side"><?php esc_html_e( 'Lateral', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <div class="wf-input-group">
                                        <input type="number" name="margin_side" id="margin_side" 
                                            value="<?php echo esc_attr( $margin_side ); ?>" min="0" step="1" class="small-text">
                                        <select name="margin_side_unit" class="wf-unit-selector">
                                            <option value="px" <?php selected( $margin_side_unit, 'px' ); ?>>px</option>
                                            <option value="%" <?php selected( $margin_side_unit, '%' ); ?>>%</option>
                                            <option value="rem" <?php selected( $margin_side_unit, 'rem' ); ?>>rem</option>
                                            <option value="em" <?php selected( $margin_side_unit, 'em' ); ?>>em</option>
                                        </select>
                                    </div>
                                    <span class="wf-saved-value">
                                        <?php 
                                        /* translators: 1: value, 2: unit */
                                        printf( esc_html__( 'Actual: %1$s%2$s', 'sf-whatsapp-chat-wordpress' ), esc_html( $margin_side ), esc_html( $margin_side_unit ) ); 
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido Tablet -->
                        <div id="tab-tablet" class="wf-tab-content">
                            <div class="wf-margins-row">
                                <div class="wf-field-inline">
                                    <label for="margin_bottom_tablet"><?php esc_html_e( 'Inferior', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <div class="wf-input-group">
                                        <input type="number" name="margin_bottom_tablet" id="margin_bottom_tablet" 
                                            value="<?php echo esc_attr( $margin_bottom_tablet ); ?>" min="0" step="1" class="small-text">
                                        <select name="margin_bottom_unit_tablet" class="wf-unit-selector">
                                            <option value="px" <?php selected( $margin_bottom_unit_tablet, 'px' ); ?>>px</option>
                                            <option value="%" <?php selected( $margin_bottom_unit_tablet, '%' ); ?>>%</option>
                                            <option value="rem" <?php selected( $margin_bottom_unit_tablet, 'rem' ); ?>>rem</option>
                                            <option value="em" <?php selected( $margin_bottom_unit_tablet, 'em' ); ?>>em</option>
                                        </select>
                                    </div>
                                    <span class="wf-saved-value">
                                        <?php 
                                        /* translators: 1: value, 2: unit */
                                        printf( esc_html__( 'Actual: %1$s%2$s', 'sf-whatsapp-chat-wordpress' ), esc_html( $margin_bottom_tablet ), esc_html( $margin_bottom_unit_tablet ) ); 
                                        ?>
                                    </span>
                                </div>

                                <div class="wf-field-inline">
                                    <label for="margin_side_tablet"><?php esc_html_e( 'Lateral', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <div class="wf-input-group">
                                        <input type="number" name="margin_side_tablet" id="margin_side_tablet" 
                                            value="<?php echo esc_attr( $margin_side_tablet ); ?>" min="0" step="1" class="small-text">
                                        <select name="margin_side_unit_tablet" class="wf-unit-selector">
                                            <option value="px" <?php selected( $margin_side_unit_tablet, 'px' ); ?>>px</option>
                                            <option value="%" <?php selected( $margin_side_unit_tablet, '%' ); ?>>%</option>
                                            <option value="rem" <?php selected( $margin_side_unit_tablet, 'rem' ); ?>>rem</option>
                                            <option value="em" <?php selected( $margin_side_unit_tablet, 'em' ); ?>>em</option>
                                        </select>
                                    </div>
                                    <span class="wf-saved-value">
                                        <?php 
                                        /* translators: 1: value, 2: unit */
                                        printf( esc_html__( 'Actual: %1$s%2$s', 'sf-whatsapp-chat-wordpress' ), esc_html( $margin_side_tablet ), esc_html( $margin_side_unit_tablet ) ); 
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido Mobile -->
                        <div id="tab-mobile" class="wf-tab-content">
                            <div class="wf-margins-row">
                                <div class="wf-field-inline">
                                    <label for="margin_bottom_mobile"><?php esc_html_e( 'Inferior', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <div class="wf-input-group">
                                        <input type="number" name="margin_bottom_mobile" id="margin_bottom_mobile" 
                                            value="<?php echo esc_attr( $margin_bottom_mobile ); ?>" min="0" step="1" class="small-text">
                                        <select name="margin_bottom_unit_mobile" class="wf-unit-selector">
                                            <option value="px" <?php selected( $margin_bottom_unit_mobile, 'px' ); ?>>px</option>
                                            <option value="%" <?php selected( $margin_bottom_unit_mobile, '%' ); ?>>%</option>
                                            <option value="rem" <?php selected( $margin_bottom_unit_mobile, 'rem' ); ?>>rem</option>
                                            <option value="em" <?php selected( $margin_bottom_unit_mobile, 'em' ); ?>>em</option>
                                        </select>
                                    </div>
                                    <span class="wf-saved-value">
                                        <?php 
                                        /* translators: 1: value, 2: unit */
                                        printf( esc_html__( 'Actual: %1$s%2$s', 'sf-whatsapp-chat-wordpress' ), esc_html( $margin_bottom_mobile ), esc_html( $margin_bottom_unit_mobile ) ); 
                                        ?>
                                    </span>
                                </div>

                                <div class="wf-field-inline">
                                    <label for="margin_side_mobile"><?php esc_html_e( 'Lateral', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <div class="wf-input-group">
                                        <input type="number" name="margin_side_mobile" id="margin_side_mobile" 
                                            value="<?php echo esc_attr( $margin_side_mobile ); ?>" min="0" step="1" class="small-text">
                                        <select name="margin_side_unit_mobile" class="wf-unit-selector">
                                            <option value="px" <?php selected( $margin_side_unit_mobile, 'px' ); ?>>px</option>
                                            <option value="%" <?php selected( $margin_side_unit_mobile, '%' ); ?>>%</option>
                                            <option value="rem" <?php selected( $margin_side_unit_mobile, 'rem' ); ?>>rem</option>
                                            <option value="em" <?php selected( $margin_side_unit_mobile, 'em' ); ?>>em</option>
                                        </select>
                                    </div>
                                    <span class="wf-saved-value">
                                        <?php 
                                        /* translators: 1: value, 2: unit */
                                        printf( esc_html__( 'Actual: %1$s%2$s', 'sf-whatsapp-chat-wordpress' ), esc_html( $margin_side_mobile ), esc_html( $margin_side_unit_mobile ) ); 
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Configuración de Breakpoints -->
                        <div class="wf-breakpoints-section">
                            <h4><?php esc_html_e( 'Puntos de ruptura (Breakpoints)', 'sf-whatsapp-chat-wordpress' ); ?></h4>
                            <p class="description-small"><?php esc_html_e( 'Define el ancho máximo de pantalla para cada dispositivo.', 'sf-whatsapp-chat-wordpress' ); ?></p>
                            
                            <div class="wf-breakpoints-grid">
                                <div class="wf-field">
                                    <label for="breakpoint_tablet"><?php esc_html_e( 'Tablet (max-width)', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <input type="number" name="breakpoint_tablet" id="breakpoint_tablet" 
                                        value="<?php echo esc_attr( $breakpoint_tablet ); ?>" min="0" step="1" class="regular-text wf-breakpoint-input">
                                    <p class="wf-field-help"><?php esc_html_e( 'Ancho máximo para considerar dispositivo Tablet (ej. 1024px)', 'sf-whatsapp-chat-wordpress' ); ?></p>
                                </div>

                                <div class="wf-field">
                                    <label for="breakpoint_mobile"><?php esc_html_e( 'Móvil (max-width)', 'sf-whatsapp-chat-wordpress' ); ?></label>
                                    <input type="number" name="breakpoint_mobile" id="breakpoint_mobile" 
                                        value="<?php echo esc_attr( $breakpoint_mobile ); ?>" min="0" step="1" class="regular-text wf-breakpoint-input">
                                    <p class="wf-field-help"><?php esc_html_e( 'Ancho máximo para considerar dispositivo Móvil (ej. 768px)', 'sf-whatsapp-chat-wordpress' ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de cuentas -->
        <div class="wf-section">
            <h2><?php esc_html_e( 'Cuentas de WhatsApp', 'sf-whatsapp-chat-wordpress' ); ?></h2>
            <p class="description">
                <?php esc_html_e( 'Configura las cuentas de WhatsApp que se mostrarán en el botón flotante. Puedes añadir múltiples horarios para cada cuenta.', 'sf-whatsapp-chat-wordpress' ); ?>
            </p>

            <div id="accounts-container">
                <?php if ( ! empty( $accounts ) ) : ?>
                    <?php foreach ( $accounts as $sf_whatsapp_index => $sf_whatsapp_account ) : ?>
                        <?php include WHATSAPP_FLOTANTE_PLUGIN_DIR . 'admin/templates/account-row.php'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" class="button button-secondary" id="add-account-btn">
                <span class="dashicons dashicons-plus-alt"></span>
                <?php esc_html_e( 'Añadir cuenta', 'sf-whatsapp-chat-wordpress' ); ?>
            </button>
        </div>

        <!-- Sección de textos del modal y disclaimer -->
        <div class="wf-section">
            <h2><?php esc_html_e( 'Textos del Modal', 'sf-whatsapp-chat-wordpress' ); ?></h2>
            <p class="description">
                <?php esc_html_e( 'Personaliza los textos que se muestran en el modal de WhatsApp.', 'sf-whatsapp-chat-wordpress' ); ?>
            </p>

            <div class="wf-field">
                <label for="modal_title"><?php esc_html_e( 'Título del modal', 'sf-whatsapp-chat-wordpress' ); ?></label>
                <input type="text" name="modal_title" id="modal_title" value="<?php echo esc_attr( $modal_title ); ?>" class="large-text">
                <p class="description"><?php esc_html_e( 'Texto que aparece como título en el encabezado del modal.', 'sf-whatsapp-chat-wordpress' ); ?></p>
            </div>

            <div class="wf-field">
                <label for="modal_subtitle"><?php esc_html_e( 'Subtítulo del modal', 'sf-whatsapp-chat-wordpress' ); ?></label>
                <input type="text" name="modal_subtitle" id="modal_subtitle" value="<?php echo esc_attr( $modal_subtitle ); ?>" class="large-text">
                <p class="description"><?php esc_html_e( 'Texto instructivo que aparece encima de la lista de contactos.', 'sf-whatsapp-chat-wordpress' ); ?></p>
            </div>

            <div class="wf-field">
                <label for="disclaimer"><?php esc_html_e( 'Aviso legal / Disclaimer', 'sf-whatsapp-chat-wordpress' ); ?></label>
                <textarea name="disclaimer" id="disclaimer" rows="4"
                    class="large-text"><?php echo esc_textarea( $disclaimer ); ?></textarea>
                <p class="description"><?php esc_html_e( 'Texto opcional que se mostrará en el modal de WhatsApp (por ejemplo, información sobre protección de datos).', 'sf-whatsapp-chat-wordpress' ); ?></p>
            </div>

            <div class="wf-field">
                <label>
                    <input type="checkbox" name="client_side" value="1" <?php checked( $client_side ); ?>>
                    <?php esc_html_e( 'Decidir el horario en el navegador (compatible con caché)', 'sf-whatsapp-chat-wordpress' ); ?>
                </label>
                <p class="description"><?php esc_html_e( 'Actívalo si la web usa caché de página. Sin esto, el horario se calcula al generar la página y queda congelado en la copia guardada, de modo que el botón puede aparecer fuera de horario o faltar dentro de él.', 'sf-whatsapp-chat-wordpress' ); ?></p>
            </div>

            <div class="wf-field">
                <label for="holidays"><?php esc_html_e( 'Días de cierre', 'sf-whatsapp-chat-wordpress' ); ?></label>
                <textarea name="holidays" id="holidays" rows="5" class="large-text"
                    placeholder="2026-12-25"><?php echo esc_textarea( $holidays ); ?></textarea>
                <p class="description"><?php esc_html_e( 'Una fecha por línea, en formato AAAA-MM-DD. Esos días ninguna cuenta estará disponible, aunque tenga horario configurado.', 'sf-whatsapp-chat-wordpress' ); ?></p>
            </div>
        </div>

        <?php submit_button( esc_html__( 'Guardar configuración', 'sf-whatsapp-chat-wordpress' ) ); ?>
    </form>
</div>

<!-- Template para nueva cuenta (oculto) -->
<script type="text/template" id="account-row-template">
    <?php
    $sf_whatsapp_index = '{{INDEX}}';
    $sf_whatsapp_account = array(
        'label' => '',
        'phone' => '',
        'message' => '',
        'active' => true,
        'schedules' => array(),
    );
    include WHATSAPP_FLOTANTE_PLUGIN_DIR . 'admin/templates/account-row.php';
    ?>
</script>

<!-- Template para nuevo horario (oculto) -->
<script type="text/template" id="schedule-row-template">
    <?php
    $sf_whatsapp_account_index = '{{ACCOUNT_INDEX}}';
    $sf_whatsapp_schedule_index = '{{SCHEDULE_INDEX}}';
    $sf_whatsapp_schedule = array(
        'days' => array(),
        'start_time' => '09:00',
        'end_time' => '18:00',
    );
    include WHATSAPP_FLOTANTE_PLUGIN_DIR . 'admin/templates/schedule-row.php';
    ?>
</script>