<?php
Kirki::add_section( 'header_html', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - HTML', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'header_txt_notice',
	'label'    => esc_html__( 'Text notification', 'amino' ),
	'description'    => esc_html__( 'You can use HTML or shortcode', 'amino' ),
	'default'  => 'Additional <span class="diff-color2">20% Off</span> Sale Items – <a href="#">Please See Details</a>',
	'section'  => 'header_html',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'header_language_content',
	'label'    => esc_html__( 'Language dropdown content', 'amino' ),
	'description'    => esc_html__( 'You can use HTML or shortcode', 'amino' ),
	'default'  => '<ul><li class="active"><a href="#">English</a><li><li><a href="#">Germany</a><li></ul>',
	'section'  => 'header_html',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'header_currency_content',
	'label'    => esc_html__( 'Currency dropdown content', 'amino' ),
	'description'    => esc_html__( 'You can use HTML or shortcode', 'amino' ),
	'default'  => '<ul><li class="active"><a href="#">USD</a><li><li><a href="#">Euro</a><li></ul>',
	'section'  => 'header_html',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_link_text1',
	'label'    => esc_html__( 'Header link 1', 'amino' ),
	'description'    => esc_html__( 'This will be the label for your link', 'amino' ),
	'section'  => 'header_html',
	'default'  => esc_html__( 'Store Locator', 'amino' ),
] );
Kirki::add_field( 'option', [
	'type'     => 'link',
	'settings' => 'header_link_url1',
	'description'    => esc_html__( 'This will be the link URL', 'amino' ),
	'section'  => 'header_html',
	'default'  => 'https://192.168.1.25/wp/amino/contact-us/',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_link_text2',
	'label'    => esc_html__( 'Header link 2', 'amino' ),
	'description'    => esc_html__( 'This will be the label for your link', 'amino' ),
	'section'  => 'header_html',
	'default'  => esc_html__( 'Track Your Order', 'amino' ),
] );
Kirki::add_field( 'option', [
	'type'     => 'link',
	'settings' => 'header_link_url2',
	'description'    => esc_html__( 'This will be the link URL', 'amino' ),
	'section'  => 'header_html',
	'default'  => 'https://192.168.1.25/wp/amino/my-account/orders/',
	
] );