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
/**
 * Class Amino Core.
 * Main class.
 */
final class Amino_Core {
	/**
	 * Constructor function.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		$is_elementor_callable = ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) ? true : false;

		if ( ( ! $is_elementor_callable ) ) {
			$this->elementor_not_available();
		}
		$this->define_constants();
		$this->includes();
		$this->init();
	}
	/**
	 * Defines constants
	 */
	public function define_constants() {
		define( 'AMINO_CORE_DIR', plugin_dir_path( __FILE__ ) );
		define( 'AMINO_CORE_URL', plugin_dir_url( __FILE__ ) );
		define( 'AMINO_CORE_VERSION', '1.0.0' );
	}
	/**
	 * Load files
	 */
	public function includes() {
		include_once  AMINO_CORE_DIR . 'includes/elementor/road-elementor.php';
		include_once  AMINO_CORE_DIR . 'includes/widgets/widget-layered-nav.php';
		include_once  AMINO_CORE_DIR . 'includes/widgets/widget-blocks.php';
		include_once  AMINO_CORE_DIR . 'includes/widgets/widget-social.php';
		include_once  AMINO_CORE_DIR . 'includes/custom-post-types/post-type-custom-blocks.php';
		include_once  AMINO_CORE_DIR . 'includes/shortcodes/posts-slider.php';
		include_once  AMINO_CORE_DIR . 'includes/shortcodes/product-categories.php';
		include_once  AMINO_CORE_DIR . 'includes/shortcodes/products.php';
		if(!( class_exists( 'PR_CMB2_Image_Select_Field' ) ) ) {
		    require_once( AMINO_CORE_DIR . 'includes/cmb2/cmb2-image-select-field-type.php' );
		}
	}
	public function init() { 
	}
	public function i18n() {
		load_plugin_textdomain( 'roadthemes' );
	}

	public function elementor_not_available() {

		if ( ( ! did_action( 'elementor/loaded' ) ) ) {
			add_action( 'admin_notices', [ $this, 'elementor_not_installed_activated' ] );
			add_action( 'network_admin_notices', [ $this, 'elementor_not_installed_activated' ] );
			return;
		}
	}

	/**
	 * Prints the admin notics when Elementor is not installed or activated.
	 */
	public function elementor_not_installed_activated() {

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		if ( ! did_action( 'elementor/loaded' ) ) {
			// Check user capability.
			if ( ! ( current_user_can( 'activate_plugins' ) && current_user_can( 'install_plugins' ) ) ) {
				return;
			}

			/* TO DO */
			$class = 'notice notice-error';
			/* translators: %s: html tags */
			$message = sprintf( __( 'The %1$sArmino%2$s plugin requires %1$sElementor%2$s plugin installed & activated.', 'aheader-footer-elementor' ), '<strong>', '</strong>' );

			$plugin = 'elementor/elementor.php';

			if ( _is_elementor_installed() ) {

				$action_url   = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
				$button_label = __( 'Activate Elementor', 'aheader-footer-elementor' );

			} else {

				$action_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
				$button_label = __( 'Install Elementor', 'aheader-footer-elementor' );
			}

			$button = '<p><a href="' . esc_url( $action_url ) . '" class="button-primary">' . esc_html( $button_label ) . '</a></p><p></p>';

			printf( '<div class="%1$s"><p>%2$s</p>%3$s</div>', esc_attr( $class ), wp_kses_post( $message ), wp_kses_post( $button ) );
		}
	}
}
new Amino_Core();