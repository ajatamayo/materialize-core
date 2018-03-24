<?php
/**
 * Plugin Name: Materialize Core
 * Description: A separate plugin for http://next.materializecss.com assets
 * Plugin URI:  https://github.com/ajatamayo/materialize-core
 * Version:     1.0
 * Author:      AJ Tamayo
 * Author URI:  https://github.com/ajatamayo
 * License:     GPL
 * Text Domain: materialize-core
 * Domain Path: /languages
 *
 */

add_action( 'plugins_loaded', array( Materialize_Core::get_instance(), 'plugin_setup' ) );

class Materialize_Core {
    protected static $instance = NULL;
    public $plugin_url = '';
    public $plugin_path = '';

    /**
     *
     * @since 1.0
     */
    public function __construct() {}

    /**
     *
     * @since 1.0
     */
    public function load_language( $domain ) {
        load_plugin_textdomain(
            $domain,
            FALSE,
            $this->plugin_path . '/languages'
        );
    }

    /**
     *
     * @since 1.0
     */
    public static function get_instance() {
        NULL === self::$instance and self::$instance = new self;
        return self::$instance;
    }

    /**
     *
     * @since 1.0
     */
    public function plugin_setup() {
        $this->plugin_url    = plugins_url( '/', __FILE__ );
        $this->plugin_path   = plugin_dir_path( __FILE__ );
        $this->load_language( 'materialize-core' );

        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ), 10 );
    }

    /**
     *
     * @since 1.0
     */
    function enqueue_scripts() {;
        wp_register_script( 'materialize-cash', $this->plugin_url . "public/js/cash.js", array(), '1.0', true );
        wp_register_script( 'materialize-component', $this->plugin_url . "public/js/component.js", array( 'materialize-cash' ), '1.0', true );
        wp_register_script( 'materialize-global', $this->plugin_url . "public/js/global.js", array( 'materialize-component' ), '1.0', true );
        wp_register_script( 'materialize-anime', $this->plugin_url . "public/js/anime.min.js", array( 'materialize-global' ), '1.0', true );
        wp_register_script( 'materialize-materialbox', $this->plugin_url . "public/js/materialbox.js", array( 'materialize-anime' ), '1.0', true );
    }
}

?>
