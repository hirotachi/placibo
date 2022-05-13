<?php
Kirki::add_section( 'header_link', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Link', 'amino' ),
    'panel'       => 'header',
) );	
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_link_text1',
	'label'    => esc_html__( 'Header link 1', 'amino' ),
	'description'    => esc_html__( 'This will be the label for your link', 'amino' ),
	'section'  => 'header_link',
	'default'  => esc_html__( 'Store Locator', 'amino' ),
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'link',
	'settings' => 'header_link_url1',
	'description'    => esc_html__( 'This will be the link URL', 'amino' ),
	'section'  => 'header_link',
	'default'  => 'https://192.168.1.25/wp/amino/contact-us/',
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_link_text2',
	'label'    => esc_html__( 'Header link 2', 'amino' ),
	'description'    => esc_html__( 'This will be the label for your link', 'amino' ),
	'section'  => 'header_link',
	'default'  => esc_html__( 'Track Your Order', 'amino' ),
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'link',
	'settings' => 'header_link_url2',
	'description'    => esc_html__( 'This will be the link URL', 'amino' ),
	'section'  => 'header_link',
	'default'  => 'https://192.168.1.25/wp/amino/my-account/orders/',
	'transport'   => 'postMessage',
] );