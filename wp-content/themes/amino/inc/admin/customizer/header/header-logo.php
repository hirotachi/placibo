<?php
Kirki::add_section( 'header_logo', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Logo', 'amino' ),
    'panel'       => 'header',	
) );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'header_logo_maxwidth',
	'label'       => esc_html__( 'Max width (px)', 'amino' ),
	'section'     => 'header_logo',
	'default'     => 137,
	'choices'     => [
		'min'  => 0,
		'max'  => 242,
		'step' => 1,
	],
	'transport'   => 'postMessage',
] );