<?php
$topbar_content = array(
	'none' => esc_html__( '-----', 'amino' ),
	'social' => esc_html__( 'Social list', 'amino' ),
	'language' => esc_html__( 'Language switcher', 'amino' ),
	'currency' => esc_html__( 'Currency switcher', 'amino' ),
	'notice' => esc_html__( 'Text Notification', 'amino' ),
	'link1' => esc_html__( 'Link 1', 'amino' ),
	'link2' => esc_html__( 'Link 2', 'amino' ),
);
Kirki::add_section( 'header_topbar', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Header Topbar', 'amino' ),
    'panel'       => 'header',
) );

Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_topbar_custom1',
	'section'     => 'header_topbar',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'General', 'amino' ) . '</div>',
] );

Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'header_topbar_active',
	'label'       => esc_html__( 'Active topbar', 'amino' ),
	'section'     => 'header_topbar',
	'default'     => 'off',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'amino' ),
		'off' => esc_html__( 'Disable', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'header_topbar_background',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'header_topbar',
	'default'     => '#1d1d1d',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'header_topbar_text',
	'label'       => esc_html__( 'Text color', 'amino' ),
	'section'     => 'header_topbar',
	'default'     => 'light',
	'choices'     => [
		'dark'   => get_template_directory_uri() . '/assets/images/customizer/text-dark.svg',
		'light' => get_template_directory_uri() . '/assets/images/customizer/text-light.svg',
	],
] );

Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'header_topbar_font',
	'label'       => esc_html__( 'Text font size (px)', 'amino' ),
	'section'     => 'header_topbar',
	'default'     => 13,
	'choices'     => [
		'min'  => 0,
		'max'  => 30,
		'step' => 1,
	],
	'transport'   => 'postMessage',
] );

Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_topbar_custom2',
	'section'     => 'header_topbar',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Layout', 'amino' ) . '</div>',
] );

Kirki::add_field( 'option', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Left position', 'amino' ),
	'section'     => 'header_topbar',
	'row_label' => [
		'type'  => 'field',
		'value' => esc_html__( 'Block: ', 'amino' ),
		'field' => 'block',
	],
	'button_label' => esc_html__('Add a block', 'amino' ),
	'settings'     => 'topbar_left',
	'default'      => [
	],
	'fields' => [
		'block' => [
			'type'        => 'select',
			'label'       => esc_html__( 'Select block', 'amino' ),
			'default'     => '',
			'choices'     => $topbar_content,
		],
	]
] );

Kirki::add_field( 'option', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Center position', 'amino' ),
	'section'     => 'header_topbar',
	'row_label' => [
		'type'  => 'field',
		'value' => esc_html__( 'Block: ', 'amino' ),
		'field' => 'block',
	],
	'button_label' => esc_html__('Add a block', 'amino' ),
	'settings'     => 'topbar_center',
	'default'      => [
	],
	'fields' => [
		'block' => [
			'type'        => 'select',
			'label'       => esc_html__( 'Select block', 'amino' ),
			'default'     => '',
			'choices'     => $topbar_content,
		],
	]
] );
Kirki::add_field( 'option', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Right position', 'amino' ),
	'section'     => 'header_topbar',
	'row_label' => [
		'type'  => 'field',
		'value' => esc_html__( 'Block: ', 'amino' ),
		'field' => 'block',
	],
	'button_label' => esc_html__('Add a block', 'amino' ),
	'settings'     => 'topbar_right',
	'default'      => [
	],
	'fields' => [
		'block' => [
			'type'        => 'select',
			'label'       => esc_html__( 'Select block', 'amino' ),
			'default'     => '',
			'choices'     => $topbar_content,
		],
	]
] );