<?php
Kirki::add_section( 'header_cart', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Cart', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'header_elements_cart_icon',
	'label'       => esc_html__( 'Select cart icon', 'amino' ),
	'section'     => 'header_cart',
	'default'     => 'bag2',
	'choices'     => [
		'cart-outline'   => get_template_directory_uri() . '/assets/images/customizer/cart-1.jpg',	
		'bag-outline' => get_template_directory_uri() . '/assets/images/customizer/cart-2.jpg',	
		'handbag'  => get_template_directory_uri() . '/assets/images/customizer/cart-3.jpg',	
		'shopping-basket-solid'  => get_template_directory_uri() . '/assets/images/customizer/cart-4.jpg',
		'bag'  => get_template_directory_uri() . '/assets/images/customizer/cart-5.jpg',
		'bag2'  => get_template_directory_uri() . '/assets/images/customizer/cart-6.jpg',
	],
	'transport' => 'postMessage'
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'header_elements_cart_minicart',
	'label'       => esc_html__( 'Mini cart', 'amino' ),
	'section'     => 'header_cart',
	'default'     => 'off-canvas',
	'choices'     => [
		'none'    => esc_html__( 'None', 'amino' ),
		'dropdown'   => esc_html__( 'Dropdown', 'amino' ),
		'off-canvas' => esc_html__( 'Off-canvas sidebar', 'amino' ),
	],
	'transport'   => 'postMessage',
] );