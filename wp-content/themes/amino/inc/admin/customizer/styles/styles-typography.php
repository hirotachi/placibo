<?php 
Kirki::add_section( 'typography', array(
    'title'       => esc_html__( 'Typography', 'amino' ),
    'panel'       => 'styles',
) );
Kirki::add_field( 'option', [
	'type'        => 'typography',
	'settings'    => 'primary_font',
	'label'       => esc_html__( 'Primary font', 'amino' ),
	'section'     => 'typography',
	'default'     => [
		'font-family'    => 'Popins',
		'font-size'      => '1.4rem',
		'line-height'    => '1.5',
		'color'          => '#626262',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'body',
		],
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'typography',
	'settings'    => 'secondary_font',
	'label'       => esc_html__( 'Secondary font', 'amino' ),
	'section'     => 'typography',
	'default'     => [
		'font-family'    => 'Popins',
		'variant'        => '700',
		'font-size'      => '1.4rem',
		'line-height'    => '1.5',
		'text-transform' => 'none',
		'color'          => '#1d1d1d',
	]
] );
Kirki::add_field( 'option', [
	'type'        => 'typography',
	'settings'    => 'third_font',
	'label'       => esc_html__( 'Third font', 'amino' ),
	'section'     => 'typography',
	'default'     => [
		'font-family'    => 'Great Vibes',
		'variant'        => '400',
		'font-size'      => '3.6rem',
		'line-height'    => '1',
		'text-transform' => 'none',
		'color'          => '#83bc2e',
	]
] );