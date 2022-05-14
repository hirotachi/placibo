<?php
/*
	Plugin Name: Savoy Theme - Content Elements
	Plugin URI: http://themeforest.net/item/savoy-minimalist-ajax-woocommerce-theme/12537825
	Description: Adds page elements, widgets and custom code fields.
	Version: 1.3
	Author: NordicMade
	Author URI: http://www.nordicmade.com
	Text Domain: nm-content-elements
	Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NM_Content_Elements {
	
    /* Init */
	function init() {
        // Constants
        define( 'NM_CE_INC_DIR', plugin_dir_path( __FILE__ ) . 'includes' );
        
        // Include: Custom code fields
        include( NM_CE_INC_DIR . '/custom-code.php' );
        
        // Include: Post - Social share
        include( NM_CE_INC_DIR . '/post-social-share.php' );
        
        // Include: Shortcodes
        include( NM_CE_INC_DIR . '/shortcodes.php' );
        
        // Include: Visual Composer - Elements
        include( NM_CE_INC_DIR . '/visual-composer.php' );
        // Include: Visual Composer - Shortcode functions
        include( NM_CE_INC_DIR . '/visual-composer/vc-shortcode-functions.php' );
        
        // Include: Widgets
        include( NM_CE_INC_DIR . '/widgets.php' );
    }
	
}

$NM_Content_Elements = new NM_Content_Elements();
$NM_Content_Elements->init();
