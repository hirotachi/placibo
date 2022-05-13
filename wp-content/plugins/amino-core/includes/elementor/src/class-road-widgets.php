<?php
 
class Road_Widget {
	private static $_instance = null;
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} 
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/road-title.php' );
		require_once( __DIR__ . '/widgets/road-brandlogo.php' );
		require_once( __DIR__ . '/widgets/road-latestpost.php' );
		require_once( __DIR__ . '/widgets/road-banner.php' );
		require_once( __DIR__ . '/widgets/road-products.php' );
		require_once( __DIR__ . '/widgets/road-categories.php' );
		require_once( __DIR__ . '/widgets/road-tab-products.php' );
		require_once( __DIR__ . '/widgets/road-testimonials.php' );
		require_once( __DIR__ . '/widgets/road-countdown.php' );
		require_once( __DIR__ . '/widgets/road-sale-products.php' );
		require_once( __DIR__ . '/widgets/road-slideshow.php' );
		require_once( __DIR__ . '/widgets/road-instagram.php' );
		require_once( __DIR__ . '/widgets/road-googlemaps.php' );
		require_once( __DIR__ . '/widgets/road-nav.php' );
	}
	public function register_widgets() {
		
		$this -> include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Title_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Brandlogo_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Latestpost_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Banner_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Products_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Tab_Products_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Categories_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Testimonials_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Countdown_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Sale_Products_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Instagram_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Googlemaps_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Slideshow_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Road_Nav_Widget() );
	}
	 
	 
	public function __construct() {  
	
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ], 10 );
		
		add_action('elementor/frontend/after_register_scripts', [$this, 'enqueue_site_scripts']);
		add_action('elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ]);  
	}  
	public function enqueue_site_scripts() { 

	}
 
	public function enqueue_styles() { 
		// wp_enqueue_style( 'road-styles', AMINO_CORE_URL . '/assets/css/styles.css', array() );
	}

}  
Road_Widget::instance();
 