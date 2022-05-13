<?php
Kirki::add_panel( 'header', array(
    'priority'    => 50,
    'title'       => esc_html__( 'Header', 'amino' ),
) );
require_once dirname( __FILE__ ).'/header-layout.php';
require_once dirname( __FILE__ ).'/header-styles.php';
require_once dirname( __FILE__ ).'/header-mobile.php';
require_once dirname( __FILE__ ).'/header-topbar.php';
require_once dirname( __FILE__ ).'/header-logo.php';
require_once dirname( __FILE__ ).'/header-search.php';
require_once dirname( __FILE__ ).'/header-cart.php';
require_once dirname( __FILE__ ).'/header-menu.php';
require_once dirname( __FILE__ ).'/header-account.php';
require_once dirname( __FILE__ ).'/header-contact.php';
require_once dirname( __FILE__ ).'/header-promo.php';
require_once dirname( __FILE__ ).'/header-html.php';
function amino_refresh_header_partials( WP_Customize_Manager $wp_customize ) {
	if ( ! isset( $wp_customize->selective_refresh ) ) {
	      return;
	}
	$wp_customize->selective_refresh->add_partial( 'header-cart', array(
	    'selector' => (amino_get_option('header_elements_cart_minicart') == 'dropdown') ? '.cart-block' : '#_desktop_cart_',
	    'settings' => array('header_elements_cart_icon','header_elements_cart_minicart'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_header_cart',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-contact', array(	
	    'selector' => '.header-contact',		
	    'settings' => array('he_contact_text'),	
	    'container_inclusive' => true,
	    'render_callback' => 'amino_header_contact',	
	) );
	$wp_customize->selective_refresh->add_partial( 'header-account', array(	
	    'selector' => '.header-account-block',		
	    'settings' => array('he_account_design','he_account_popup'),
	    'container_inclusive' => true,	
	    'render_callback' => 'amino_header_account',	
	) );
	$wp_customize->selective_refresh->add_partial( 'header-promo', array(	
	    'selector' => '.promo-block',	
	    'settings' => array('header_promo_active','header_promo_type','header_promo_image','header_promo_link','header_promo_text','header_promo_close' ),		
	    'container_inclusive' => true,
	    'render_callback' => 'amino_promo_block',	
	) );
	$wp_customize->selective_refresh->add_partial( 'header-search', array(	
	    'selector' => '.search-simple',	
	    'settings' => array('header_search_layout','header_search_categories','header_search_categories_depth','header_search_keywords'),	
	    'container_inclusive' => true,
	    'render_callback' => 'amino_header_search',	
	) );
	$wp_customize->selective_refresh->add_partial( 'header-search-icon', array(	
	    'selector' => '.search-sidebar',	
	    'settings' => array('header_search_categories','header_search_categories_depth','header_search_keywords'),
	    'container_inclusive' => true,	
	    'render_callback' => 'amino_header_search_icon',	
	) );
	$wp_customize->selective_refresh->add_partial( 'header-hmenu', array(
	    'selector' => '.primary-menu-wrapper',
	    'settings' => array('hmenu_item_align'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_main_menu',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-vmenu', array(
	    'selector' => '.vertical-menu-wrapper',
	    'settings' => array('vmenu_action'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_vertical_menu',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-topbar', array(
	    'selector' => '.header-topbar',
	    'settings' => array('header_topbar_text'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_header_topbar',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-language', array(
	    'selector' => '.amino-language-switcher',
	    'settings' => array('header_language_content'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_language_switcher',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-txtnotice', array(
	    'selector' => '#_desktop_txt_notice_',
	    'settings' => array('header_txt_notice'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_txt_notice',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-currency', array(
	    'selector' => '.amino-currency-switcher',
	    'settings' => array('header_currency_content'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_currency_switcher',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-link1', array(
	    'selector' => '.header-link1',
	    'settings' => array('header_link_text1', 'header_link_url1'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_custom_link1',
	) );
	$wp_customize->selective_refresh->add_partial( 'header-link2', array(
	    'selector' => '.header-link2',
	    'settings' => array('header_link_text2', 'header_link_url2'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_custom_link2',
	) );
}
add_action( 'customize_register', 'amino_refresh_header_partials' );