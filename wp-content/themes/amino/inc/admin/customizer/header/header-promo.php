<?php
Kirki::add_section( 'header_promo', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Promo text', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'header_promo_active',
	'label'       => esc_html__( 'Active promo block', 'amino' ),
	'section'     => 'header_promo',
	'default'     => 'on',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'header_promo_type',
	'label'       => esc_html__( 'Select type', 'amino' ),
	'section'     => 'header_promo',
	'default'     => 'text',
	'choices'     => [
		'text'    => esc_html__( 'Text', 'amino' ),
		'image'   => esc_html__( 'Image', 'amino' ),
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'image',
	'settings'    => 'header_promo_image',
	'label'       => esc_html__( 'Upload your image', 'amino' ),
	'section'     => 'header_promo',
	'default'     => '',
	'active_callback' => [
		[
			'setting'  => 'header_promo_type',
			'operator' => '==',
			'value'    => 'image',
		]
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_promo_link',
	'label'    => esc_html__( 'Link', 'amino' ),
	'section'  => 'header_promo',
	'active_callback' => [
		[
			'setting'  => 'header_promo_type',
			'operator' => '==',
			'value'    => 'image',
		]
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'header_promo_text',
	'label'    => esc_html__( 'Add your text', 'amino' ),
	'description'    => esc_html__( 'Allow using HTML or shortcode', 'amino' ),
	'section'  => 'header_promo',
	'active_callback' => [
		[
			'setting'  => 'header_promo_type',
			'operator' => '==',
			'value'    => 'text',
		]
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'header_promo_close',
	'label'       => esc_html__( 'Show close button', 'amino' ),
	'section'     => 'header_promo',
	'default'     => 'on',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_promo_style',
	'section'     => 'header_promo',
	'default'         => '<div class="sub-divider">' . esc_html__( 'Promo Style', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'header_promo_height',
	'label'       => esc_html__( 'Height', 'amino' ),
	'section'     => 'header_promo',
	'default'     => 46,
	'choices'     => [
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	],
	'transport'   => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'header_promo_type',
			'operator' => '==',
			'value'    => 'text',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'header_promo_color',
	'label'       => esc_html__( 'Color', 'amino' ),
	'section'     => 'header_promo',
	'default'     => '#ffffff',
	'choices'     => [
		'alpha' => true,
	],
	'active_callback' => [
		[
			'setting'  => 'header_promo_type',
			'operator' => '==',
			'value'    => 'text',
		]
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'header_promo_bground',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'header_promo',
	'default'     => '#1d1d1d',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );