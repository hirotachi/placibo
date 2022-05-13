<?php
Kirki::add_section( 'page_title', array(
    'priority'    => 52,
    'title'       => esc_html__( 'Page title', 'amino' ),
) );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'page_title_design',
	'label'       => esc_html__( 'Page title design', 'amino' ),
	'section'     => 'page_title',
	'default'     => '1',
	'choices'     => [
		'1'   => get_template_directory_uri() . '/assets/images/customizer/page-title-1.jpg',
		'2' => get_template_directory_uri() . '/assets/images/customizer/page-title-2.jpg',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'page_title_align',
	'label'       => esc_html__( 'Align', 'amino' ),
	'section'     => 'page_title',
	'default'     => 'center',
	'choices'     => [
		'left'   => esc_html__( 'Left', 'amino' ),
		'center' => esc_html__( 'Center', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'page_title_size',
	'label'       => esc_html__( 'Size', 'amino' ),
	'section'     => 'page_title',
	'default'     => 'small',
	'choices'     => [
		'small'   => esc_html__( 'Small', 'amino' ),
		'medium' => esc_html__( 'Medium', 'amino' ),
		'large'  => esc_html__( 'Large', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'page_title_color',
	'label'       => esc_html__( 'Text color', 'amino' ),
	'section'     => 'page_title',
	'default'     => 'dark',
	'choices'     => [
		'dark'   => get_template_directory_uri() . '/assets/images/customizer/text-dark.svg',
		'light' => get_template_directory_uri() . '/assets/images/customizer/text-light.svg',
	],
	'active_callback'  => [
		[
			'setting'  => 'page_title_design',
			'operator' => '===',
			'value'    => '1',
		],
	]
] );
Kirki::add_field( 'option', [
	'type'        => 'background',
	'settings'    => 'page_title_background',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'page_title',
	'default'     => [
		'background-color'      => '#dddddd',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => '.page-title-section',
		],
	],
	'active_callback'  => [
		[
			'setting'  => 'page_title_design',
			'operator' => '===',
			'value'    => '1',
		],
	]
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'page_title_padding',
	'label'       => esc_html__( 'Padding top & bottom (px)', 'amino' ),
	'section'     => 'page_title',
	'default'     => 89,
	'choices'     => [
		'min'  => 0,
		'max'  => 500,
		'step' => 1,
	],
	'active_callback' => [
		[
			'setting'  => 'page_title_design',
			'operator' => '==',
			'value'    => '1',
		]
	],
	'transport'   => 'postMessage',
] );