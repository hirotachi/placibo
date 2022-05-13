<?php

Kirki::add_section( 'configurations', array(
    'title'       => esc_html__( 'Configurations', 'amino' ),
    'panel'       => 'general'
) );

Kirki::add_field( 'option', [
	'type'        => 'toggle',
	'settings'    => 'lazyload_active',
	'label'       => esc_html__( 'Active lazy loading', 'amino' ),
	'section'     => 'configurations',
	'description'=> esc_html__( 'Active theme lazy loading. Disable when you use plugin for lazy loading images.', 'amino' ),
	'default'     => '1',
] );