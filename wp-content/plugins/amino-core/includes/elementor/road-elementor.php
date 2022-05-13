<?php 
/**
 * Plugin Name: Amino Core
 * Plugin URI: http://roadthemes.com/
 * Description: The helper plugin for Amino themes.
 * Version: 1.0.0
 * Author: RoadThemes
 * Author URI: http://roadthemes.com/
 * Text Domain: roadthemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once( __DIR__ . '/src/class-road-widgets.php' ); 
require_once( __DIR__ . '/src/class-road-categories.php' );

class Road_Elementor_Extension {

	private $google_map_api = NULL;

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}
	public function init() { 
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_editor_styles' ) );
        add_action( 'elementor/frontend/after_register_scripts', array( $this, 'enqueue_scripts' ) );
	}
	public function enqueue_editor_styles() {

        if ( function_exists( 'of_get_option' ) && of_get_option( 'google_map_api', '' ) ) {
            $this->google_map_api = of_get_option( 'google_map_api', '' );
        }

        if( $this->google_map_api != '' ) {
            $url = 'https://maps.googleapis.com/maps/api/js?key='. $this->google_map_api .'&language='.get_locale();
        } else {
            $url = 'https://maps.googleapis.com/maps/api/js?language='.get_locale();
        }
        wp_enqueue_script( 
            'rt-google-map-admin-api', 
            $url, 
            ['elementor-editor'], 
            AMINO_CORE_VERSION, 
            true  
        );
    }

    public function enqueue_scripts() {

        if ( function_exists( 'of_get_option' ) && of_get_option( 'google_map_api', '' ) ) {
            $this->google_map_api = of_get_option( 'google_map_api', '' );
        }

        if( $this->google_map_api != '' ) {
            $url = 'https://maps.googleapis.com/maps/api/js?key='. $this->google_map_api .'&language='.get_locale();
        } else {
            $url = 'https://maps.googleapis.com/maps/api/js?language='.get_locale();
        }
        wp_register_script( 
            'rt-google-map', 
            AMINO_CORE_URL.'includes/elementor/assets/js/google-map.js', 
            array(), 
            AMINO_CORE_VERSION, 
            true  
        );
        wp_register_script( 
            'rt-google-map-api', 
            $url, 
            array(), 
            AMINO_CORE_VERSION, 
            true  
        );
        
    }
	
}
new Road_Elementor_Extension();
 
?>
