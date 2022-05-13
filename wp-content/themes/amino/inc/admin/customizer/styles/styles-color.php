<?php 
Kirki::add_section( 'styles_color', array(
    'title'       => esc_html__( 'Color', 'amino' ),
    'panel'       => 'styles',
) );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'primary_color',
	'label'       => esc_html__( 'Primary color', 'amino' ),
	'section'     => 'styles_color',
	'default'     => '#83bc2e',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'link_color',
	'label'       => esc_html__( 'Links color', 'amino' ),
	'section'     => 'styles_color',
	'default'     => '#1d1d1d',
] );