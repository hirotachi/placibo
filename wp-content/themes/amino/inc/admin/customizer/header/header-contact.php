<?php
Kirki::add_section( 'header_contact', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Contact', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [	
	'type'     => 'text',	
	'settings' => 'he_contact_text',	
	'label'    => esc_html__( 'Text', 'amino' ),
	'section'  => 'header_contact',
	'default'  => esc_html__( 'Call Us: +1 123 888 9999', 'amino' ),
	'transport' => 'postMessage'	
] );