<?php


Kirki::add_section( 'header_sticky', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Header Sticky', 'amino' ),
    'panel'       => 'header',
) );

Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'header_sticky_active',
	'label'       => esc_html__( 'Active header sticky', 'amino' ),
	'section'     => 'header_sticky',
	'default'     => '1',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
] );
