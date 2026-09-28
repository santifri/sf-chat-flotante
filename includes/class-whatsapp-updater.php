<?php
/**
 * Actualizaciones desde los releases de GitHub.
 *
 * Existe porque hasta ahora actualizar significaba subir el plugin a mano, web
 * por web, y en la practica eso se traducia en no actualizar: las instalaciones
 * llegaron a acumular siete meses de retraso respecto al repositorio.
 *
 * El repositorio es publico, asi que no hace falta ningun token. Si algun dia
 * pasa a privado, habra que anadir autenticacion aqui.
 *
 * @package WhatsApp_Flotante
 * @since 1.1.0
 */

// Si este archivo es llamado directamente, abortar
if (!defined('WPINC')) {
    die;
}

/**
 * Comprueba y sirve actualizaciones publicadas como releases de GitHub.
 */
class WhatsApp_Updater
{
    /**
     * Transient donde se guarda la respuesta de la API.
     */
    const TRANSIENT = 'whatsapp_flotante_ultimo_release';

    /**
     * Horas que se cachea la consulta. La API de GitHub sin autenticar permite
     * 60 peticiones por hora e IP, y en un hosting compartido esa IP se comparte
     * con muchos sitios: conviene no gastarlas.
     */
    const CACHE_HORAS = 12;

    /**
     * Ruta del plugin relativa al directorio de plugins.
     *
     * @var string
     */
    private $basename;

    /**
     * Carpeta del plugin.
     *
     * @var string
     */
    private $slug;

    /**
     * Version instalada.
     *
     * @var string
     */
    private $version;

    /**
     * Repositorio en formato usuario/nombre.
     *
     * @var string
     */
    private $repo;

    /**
     * Constructor.
     *
     * @param string $basename Ruta relativa del fichero principal.
     * @param string $version  Version instalada.
     * @param string $repo     Repositorio usuario/nombre.
     */
    public function __construct($basename, $version, $repo)
    {
        $this->basename = $basename;
        $this->slug     = dirname($basename);
        $this->version  = $version;
        $this->repo     = $repo;

        add_filter('pre_set_site_transient_update_plugins', array($this, 'anunciar_actualizacion'));
        add_filter('plugins_api', array($this, 'detalles_del_plugin'), 10, 3);
        add_filter('upgrader_source_selection', array($this, 'corregir_carpeta'), 10, 4);
        add_action('upgrader_process_complete', array($this, 'olvidar_cache'), 10, 2);
    }

    /**
     * Anadir la actualizacion al listado que consulta WordPress.
     *
     * @param object $transient Transient de actualizaciones.
     * @return object
     */
    public function anunciar_actualizacion($transient)
    {
        if (!is_object($transient)) {
            return $transient;
        }

        $release = $this->ultimo_release();

        if (!$release || version_compare($release['version'], $this->version, '<=')) {
            return $transient;
        }

        $info = (object) array(
            'id'          => $this->basename,
            'slug'        => $this->slug,
            'plugin'      => $this->basename,
            'new_version' => $release['version'],
            'url'         => $release['url'],
            'package'     => $release['paquete'],
            'tested'      => get_bloginfo('version'),
        );

        if (!isset($transient->response) || !is_array($transient->response)) {
            $transient->response = array();
        }

        $transient->response[$this->basename] = $info;

        return $transient;
    }

    /**
     * Rellenar la ficha que se abre al pulsar "Ver detalles".
     *
     * @param mixed  $resultado Resultado previo.
     * @param string $accion    Accion solicitada.
     * @param object $args      Argumentos.
     * @return mixed
     */
    public function detalles_del_plugin($resultado, $accion, $args)
    {
        if ('plugin_information' !== $accion || empty($args->slug) || $args->slug !== $this->slug) {
            return $resultado;
        }

        $release = $this->ultimo_release();

        if (!$release) {
            return $resultado;
        }

        return (object) array(
            'name'          => 'SF Chat Flotante',
            'slug'          => $this->slug,
            'version'       => $release['version'],
            'author'        => '<a href="https://santifrias.com">Santi Frias</a>',
            'homepage'      => $release['url'],
            'download_link' => $release['paquete'],
            'tested'        => get_bloginfo('version'),
            'sections'      => array(
                'changelog' => wpautop(wp_kses_post($release['notas'])),
            ),
        );
    }

    /**
     * Dejar la carpeta descomprimida con el nombre que espera WordPress.
     *
     * El ZIP que publica el workflow ya trae dentro la carpeta correcta, pero si
     * alguna vez se instala desde el zipball automatico de GitHub, este llega
     * como "repositorio-tag" y sin renombrarlo WordPress instalaria el plugin en
     * una carpeta distinta, duplicandolo en vez de actualizarlo.
     *
     * @param string $source        Carpeta descomprimida.
     * @param string $remote_source Carpeta temporal.
     * @param object $upgrader      Instancia del actualizador.
     * @param array  $extra         Datos del hook.
     * @return string
     */
    public function corregir_carpeta($source, $remote_source, $upgrader, $extra = array())
    {
        if (empty($extra['plugin']) || $extra['plugin'] !== $this->basename) {
            return $source;
        }

        $destino = trailingslashit($remote_source) . $this->slug;

        if (untrailingslashit($source) === untrailingslashit($destino)) {
            return $source;
        }

        global $wp_filesystem;

        if (!$wp_filesystem || !$wp_filesystem->move(untrailingslashit($source), $destino)) {
            return $source;
        }

        return trailingslashit($destino);
    }

    /**
     * Olvidar la cache despues de actualizar, para no seguir anunciando una
     * version que ya esta instalada.
     *
     * @param object $upgrader Instancia del actualizador.
     * @param array  $datos    Datos del proceso.
     */
    public function olvidar_cache($upgrader, $datos)
    {
        if (isset($datos['type']) && 'plugin' === $datos['type']) {
            delete_transient(self::TRANSIENT);
        }
    }

    /**
     * Consultar el ultimo release, con cache.
     *
     * @return array|false
     */
    private function ultimo_release()
    {
        $cache = get_transient(self::TRANSIENT);

        if (is_array($cache)) {
            return $cache;
        }

        if ('error' === $cache) {
            return false;
        }

        $respuesta = wp_remote_get(
            'https://api.github.com/repos/' . $this->repo . '/releases/latest',
            array(
                'timeout' => 10,
                'headers' => array(
                    'Accept'     => 'application/vnd.github+json',
                    'User-Agent' => 'sf-whatsapp-chat-wordpress',
                ),
            )
        );

        if (is_wp_error($respuesta) || 200 !== wp_remote_retrieve_response_code($respuesta)) {
            // Se cachea el fallo un rato para no reintentar en cada carga del
            // escritorio si GitHub no responde o se agota el limite de la API.
            set_transient(self::TRANSIENT, 'error', HOUR_IN_SECONDS);

            return false;
        }

        $datos = json_decode(wp_remote_retrieve_body($respuesta), true);

        if (empty($datos['tag_name'])) {
            set_transient(self::TRANSIENT, 'error', HOUR_IN_SECONDS);

            return false;
        }

        $release = array(
            'version' => ltrim($datos['tag_name'], 'v'),
            'url'     => isset($datos['html_url']) ? $datos['html_url'] : '',
            'notas'   => isset($datos['body']) ? $datos['body'] : '',
            'paquete' => $this->paquete($datos),
        );

        set_transient(self::TRANSIENT, $release, self::CACHE_HORAS * HOUR_IN_SECONDS);

        return $release;
    }

    /**
     * URL del ZIP a instalar.
     *
     * Se prefiere el adjunto que publica el workflow, porque ya trae dentro la
     * carpeta con el nombre correcto. El zipball queda como respaldo.
     *
     * @param array $datos Respuesta de la API.
     * @return string
     */
    private function paquete($datos)
    {
        if (!empty($datos['assets']) && is_array($datos['assets'])) {
            foreach ($datos['assets'] as $asset) {
                if (!empty($asset['browser_download_url']) && '.zip' === substr($asset['browser_download_url'], -4)) {
                    return $asset['browser_download_url'];
                }
            }
        }

        return isset($datos['zipball_url']) ? $datos['zipball_url'] : '';
    }
}
