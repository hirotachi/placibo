<?php
Kirki::add_section( 'header_styles', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Header Styles', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_styles_general',
	'section'     => 'header_styles',
	'default'         => '<div class="customize-title-divider">' . __( 'General', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'header_sticky_active',
	'label'       => esc_html__( 'Active header sticky', 'amino' ),
	'section'     => 'header_styles',
	'default'     => '1',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_styles_main',
	'section'     => 'header_styles',
	'default'         => '<div class="customize-title-divider">' . __( 'Header main', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'background',
	'settings'    => 'header_main_background',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'header_styles',
	'default'     => [
		'background-color'      => '#ffffff',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'header_main_text',
	'label'       => esc_html__( 'Text color', 'amino' ),
	'section'     => 'header_styles',
	'default'     => 'dark',
	'choices'     => [
		'dark'   => get_template_directory_uri() . '/assets/images/customizer/text-dark.svg',
		'light' => get_template_directory_uri() . '/assets/images/customizer/text-light.svg',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'header_main_padding',
	'label'       => esc_html__( 'Padding top & bottom (px)', 'amino' ),
	'section'     => 'header_styles',
	'default'     => 18,
	'choices'     => [
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	],
	'transport'   => 'postMessage',
] );