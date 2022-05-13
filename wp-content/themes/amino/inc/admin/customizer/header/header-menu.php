<?php
Kirki::add_section( 'header_menu', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Menu', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_horizonal_menu',
	'section'     => 'header_menu',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Horizontal menu', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'hmenu_background',
	'label'       => esc_html__( 'Menu background', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 'rgba(255,255,255,0)',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'hmenu_main_items',
	'section'     => 'header_menu',
	'default'         => '<div class="sub-divider">' . esc_html__( 'Main items', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'hmenu_item_align',
	'label'       => esc_html__( 'Item align', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 'center',
	'choices'     => [
		'left'   => esc_html__( 'Left', 'amino' ),
		'center' => esc_html__( 'Center', 'amino' ),
		'right'  => esc_html__( 'Right', 'amino' ),
	],
	'transport' => 'postMessage'
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'hmenu_item_color',
	'label'       => esc_html__( 'Color', 'amino' ),
	'section'     => 'header_menu',
	'default'     => '#1d1d1d',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'hmenu_item_color_active',
	'label'       => esc_html__( 'Active color', 'amino' ),
	'section'     => 'header_menu',
	'default'     => '#83bc2e',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'hmenu_item_background_color',
	'label'       => esc_html__( 'Background color', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 'rgba(255,255,255,0)',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'hmenu_item_background_color_active',
	'label'       => esc_html__( 'Active background color', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 'rgba(255,255,255,0)',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'hmenu_item_font',
	'label'       => esc_html__( 'Font size', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 14,
	'choices'     => [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	],
	'transport'  => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'hmenu_item_space',
	'label'       => esc_html__( 'Space between items', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 20,
	'choices'     => [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	],
	'transport'  => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'hmenu_submenu',
	'section'     => 'header_menu',
	'default'         => '<div class="sub-divider">' . esc_html__( 'Submenu', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_vertical_menu',
	'section'     => 'header_menu',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Vertical menu', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'toggle',
	'settings'    => 'vertical_menu_active',
	'label'       => esc_html__( 'Active vertical menu', 'amino' ),
	'section'     => 'header_menu',
	'default'     => '0',
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'vmenu_title_section',
	'section'     => 'header_menu',
	'default'         => '<div class="sub-divider">' . esc_html__( 'The title', 'amino' ) . '</div>',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'vmenu_title',
	'label'    => esc_html__( 'Title', 'amino' ),
	'section'  => 'header_menu',
	'default'  => esc_html__( 'Shop By Categories', 'amino' ),
	'transport'  => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'vmenu_title_size',
	'label'       => esc_html__( 'Title size', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 14,
	'choices'     => [
		'min'  => 0,
		'max'  => 50,
		'step' => 1,
	],
	'transport'  => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'vmenu_title_width',
	'label'       => esc_html__( 'Title width', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 330,
	'choices'     => [
		'min'  => 0,
		'max'  => 500,
		'step' => 1,
	],
	'transport'  => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'vmenu_title_bground',
	'label'       => esc_html__( 'Title background', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 'rgba(255,255,255,0)',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'vmenu_title_color',
	'label'       => esc_html__( 'Title color', 'amino' ),
	'section'     => 'header_menu',
	'default'     => '#b6b6b6',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'vmenu_items_section',
	'section'     => 'header_menu',
	'default'         => '<div class="sub-divider">' . esc_html__( 'Menu items', 'amino' ) . '</div>',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'vmenu_action',
	'label'       => esc_html__( 'Show menu items by', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 'click',
	'choices'     => [
		'click'   => esc_html__( 'Click', 'amino' ),
		'hover' => esc_html__( 'Hover', 'amino' ),
	],
	'transport' => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'vmenu_items_width',
	'label'       => esc_html__( 'Items width', 'amino' ),
	'section'     => 'header_menu',
	'default'     => 330,
	'choices'     => [
		'min'  => 0,
		'max'  => 500,
		'step' => 1,
	],
	'transport'  => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'vertical_menu_active',
			'operator' => '==',
			'value'    => true,
		]
	],
] );