<?php 
Kirki::add_section( 'layout', array(
    'title'       => esc_html__( 'Layout', 'amino' ),
    'panel'       => 'general'
) );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'layout_mode',
	'label'       => esc_html__( 'Layout mode', 'amino' ),
	'section'     => 'layout',
	'default'     => 'fullwidth',
	'choices'     => [
		'fullwidth'   => esc_html__( 'Full width', 'amino' ),
		'boxed' => esc_html__( 'Boxed', 'amino' ),
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'site_width',
	'label'    => esc_html__( 'Site content width (px,%,rem,em..)', 'amino' ),
	'section'  => 'layout',
	'description'  => esc_html__( 'Set the default width of content containers.', 'amino' ),
	'transport'   => 'postMessage',
	'default'   => '1470px',
] );
Kirki::add_field( 'option', [
	'type'        => 'background',
	'settings'    => 'layout_background',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'layout',
	'default'     => [
		'background-color'      => '#ffffff',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'body',
		],
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'layout_boxed',
	'section'     => 'layout',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Boxed layout', 'amino' ) . '</div>',
	'active_callback' => [
		[
			'setting'  => 'layout_mode',
			'operator' => '==',
			'value'    => 'boxed',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'boxed_width',
	'label'    => esc_html__( 'Boxed width (px,%,rem,em..)', 'amino' ),
	'section'  => 'layout',
	'description'  => esc_html__( 'Use for boxed layout mode', 'amino' ),
	'transport'   => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'layout_mode',
			'operator' => '==',
			'value'    => 'boxed',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'background',
	'settings'    => 'layout_boxed_background',
	'label'       => esc_html__( 'Boxed background', 'amino' ),
	'section'     => 'layout',
	'default'     => [
		'background-color'      => '#ffffff',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => '#page',
		],
	],
	'active_callback' => [
		[
			'setting'  => 'layout_mode',
			'operator' => '==',
			'value'    => 'boxed',
		]
	],
] );