<?php

/**

 * Clase principal del plugin WhatsApp Flotante

 *

 * @package WhatsApp_Flotante

 * @since 1.0.0

 */



// Si este archivo es llamado directamente, abortar

if (!defined('WPINC')) {

    die;

}



/**

 * Clase principal que orquesta todos los componentes del plugin

 */

class WhatsApp_Flotante

{



    /**

     * Instancia de la clase Settings

     *

     * @var WhatsApp_Settings

     */

    protected $settings;



    /**

     * Instancia de la clase Admin

     *

     * @var WhatsApp_Admin

     */

    protected $admin;



    /**

     * Instancia de la clase Frontend

     *

     * @var WhatsApp_Frontend

    /**

     * Registrar todos los hooks relacionados con el frontend

     */

    private function define_frontend_hooks()

    {

        // Los hooks se registran dentro de la clase Frontend

    }



    /**

     * Ejecutar el plugin

     */

    public function run()

    {

        // El plugin ya está configurado en el constructor

        // Este método existe para mantener la consistencia con el patrón de diseño

    }

}

