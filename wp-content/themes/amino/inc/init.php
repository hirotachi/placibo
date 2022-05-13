<?php
//Integrations
require_once AMINO_THEME_DIR . '/inc/admin/themepanel/vendor/merlin/autoload.php';
include_once AMINO_THEME_DIR . '/inc/admin/themepanel/themepanel.php';
require_once AMINO_THEME_DIR . '/inc/integrations/amino_megamenu/megamenu.php';
// Backoffice
if(is_customize_preview()){
	require_once AMINO_THEME_DIR . '/inc/admin/customizer/customizer.php';
}
require_once AMINO_THEME_DIR . '/inc/admin/dashboard/dashboard.php';
//Helpers
require_once AMINO_THEME_DIR . '/inc/helpers/theme-configs.php';
include_once AMINO_THEME_DIR . '/inc/helpers/ajax-search.php';
include_once AMINO_THEME_DIR . '/inc/helpers/conditionals.php';
include_once AMINO_THEME_DIR . '/inc/helpers/global.php';
include_once AMINO_THEME_DIR . '/inc/helpers/woocommerce.php';
//Frontend
include_once AMINO_THEME_DIR . '/inc/frontend/header.php';
include_once AMINO_THEME_DIR . '/inc/frontend/global.php';
include_once AMINO_THEME_DIR . '/inc/frontend/css-generator.php';
include_once AMINO_THEME_DIR . '/inc/frontend/footer.php';
include_once AMINO_THEME_DIR . '/inc/frontend/posts.php';
if ( is_woocommerce_activated() ) {
include_once AMINO_THEME_DIR . '/inc/frontend/woocommerce/wc-global.php';
include_once AMINO_THEME_DIR . '/inc/frontend/woocommerce/wc-single-product.php';
include_once AMINO_THEME_DIR . '/inc/frontend/woocommerce/wc-catalog-product.php';
include_once AMINO_THEME_DIR . '/inc/frontend/woocommerce/swatches-variant.php';
include_once AMINO_THEME_DIR . '/inc/frontend/woocommerce/variant-gallery.php';
};
if( ! function_exists( 'amino_enqueue_styles' ) ) {
    function amino_enqueue_styles() {
    	wp_enqueue_style( 'amino-style', get_stylesheet_uri(), array(), AMINO_VERSION );
		wp_style_add_data( 'amino-style', 'rtl', 'replace' );
        wp_enqueue_style( 'amino-bootstrap-rt', AMINO_THEME_URI . '/assets/css/bootstrap-rt.css', array(), '4.0.1');
        wp_enqueue_style( 'slick', AMINO_THEME_URI . '/assets/css/slick.css', array(), '1.5.9' );
        wp_enqueue_style( 'magnific-popup', AMINO_THEME_URI . '/assets/css/magnific-popup.css', array(), '1.1.0' );
        wp_enqueue_style( 'amino-theme', AMINO_THEME_URI . '/assets/css/theme.css', array(), AMINO_VERSION);
		wp_enqueue_style( 'amino-roadthemes-icon', AMINO_THEME_URI . '/assets/css/roadthemes-icon.css', array(), AMINO_VERSION );
    }
    add_action( 'wp_enqueue_scripts', 'amino_enqueue_styles', 10 );
}
if( ! function_exists( 'amino_enqueue_scripts' ) ) {
    function amino_enqueue_scripts() {
        // Load required scripts.
        wp_enqueue_script( 'slick', AMINO_THEME_URI . '/assets/js/vendor/slick.min.js' , array(), '1.5.9', true);
        wp_enqueue_script( 'amino-jquery-countdown', AMINO_THEME_URI . '/assets/js/vendor/jquery.countdown.min.js' , array(), '2.2.0', true);
        wp_enqueue_script( 'jquery-magnific-popup', AMINO_THEME_URI . '/assets/js/vendor/jquery.magnific-popup.min.js', array(), '1.1.0', true);
        if(amino_get_option('lazyload_active', 1)){
        	wp_enqueue_script( 'lazysizes', AMINO_THEME_URI . '/assets/js/vendor/lazysizes.js' , array(), '4.0.0', true);
		}
        wp_enqueue_script( 'amino-theme', AMINO_THEME_URI . '/assets/js/theme.js' , array( 'jquery','imagesloaded' ), AMINO_VERSION, true);
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		if ( is_singular( 'product' ) ) {
	        wp_enqueue_script( 'zoom' );
	        wp_enqueue_script( 'photoswipe' );
	        wp_enqueue_script( 'photoswipe-ui-default' );
	    }
		wp_enqueue_script( 'wc-add-to-cart-variation' );
        wp_localize_script( 'amino-theme', 'aminoVars', array( 
        	'ajax_url'       => admin_url('admin-ajax.php'), 
        	'time_out'       => 1000,
        	'cartConfig'     => amino_get_option('header_elements_cart_minicart' ,'off-canvas'),
        	'productLayout'  => amino_get_option('single_product_layout' ,'simple'),
        	'load_more'      => esc_html__( 'Load more', 'amino' ),
            'loading'        => esc_html__( 'Loading...', 'amino' ),
            'no_more_item'   => esc_html__( 'All items loaded', 'amino' ),
            'text_day'       => esc_html__( 'day', 'amino' ),
            'text_day_plu'   => esc_html__( 'days', 'amino' ),
            'text_hour'      => esc_html__( 'hour', 'amino' ),
            'text_hour_plu'  => esc_html__( 'hours', 'amino' ),
            'text_min'       => esc_html__( 'min', 'amino' ),
            'text_min_plu'   => esc_html__( 'mins', 'amino' ),
            'text_sec'       => esc_html__( 'sec', 'amino' ),
            'text_sec_plu'   => esc_html__( 'secs', 'amino' ),
            'required_message' => esc_html__('Please fill all required fields.','amino'), 
            'valid_email' => esc_html__('Please provide a valid email address.','amino'), 
        	)
    	);
    }    
}
add_action( 'wp_enqueue_scripts', 'amino_enqueue_scripts', 100 );
function amino_admin_scripts() {
	wp_enqueue_script( 'amino-admin', AMINO_THEME_URI . '/assets/js/admin/admin.js', array(), array(), true );
}
add_action('admin_init','amino_admin_scripts', 100);
/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function amino_menus() {
	$locations = array(
		'primary'  => esc_html__( 'Primary Menu', 'amino' ),
		
		'secondary'  => esc_html__( 'Secondary Menu', 'amino' ),
		
		'vertical' => esc_html__( 'Vertical Menu', 'amino' ),
	);
	register_nav_menus( $locations );
}
add_action( 'init', 'amino_menus' );
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function amino_widget_areas_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'amino' ),
			'id'            => 'column-blog',
			'description'   => esc_html__( 'Add widgets here.', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'amino' ),
			'id'            => 'column-shop',
			'description'   => esc_html__( 'Always show filters from Shop Filter.', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop filter', 'amino' ),
			'id'            => 'shop-filter',
			'description'   => esc_html__( 'Widget area shows filters in sidebar or above products', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 1', 'amino' ),
			'id'            => 'sidebar-footer-column-1',
			'description'   => esc_html__( 'Footer column 1', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 2', 'amino' ),
			'id'            => 'sidebar-footer-column-2',
			'description'   => esc_html__( 'Footer column 2', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 3', 'amino' ),
			'id'            => 'sidebar-footer-column-3',
			'description'   => esc_html__( 'Footer column 3', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 4', 'amino' ),
			'id'            => 'sidebar-footer-column-4',
			'description'   => esc_html__( 'Footer column 4', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer column 5', 'amino' ),
			'id'            => 'sidebar-footer-column-5',
			'description'   => esc_html__( 'Footer column 5', 'amino' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);
}
add_action( 'widgets_init', 'amino_widget_areas_init' );
/**
 * Load custom control for elementor.
 */
// NeedToCheck : check elementor used
add_action( 'elementor/controls/controls_registered', 'init_controls');
function init_controls() {
  // Include Control files
  require_once( AMINO_THEME_DIR . '/inc/elementor/custom-controls/amino-choose.php' );
  // Register control
  \Elementor\Plugin::$instance->controls_manager->register_control( 'amino-choose', new Amino_Choose());
}
