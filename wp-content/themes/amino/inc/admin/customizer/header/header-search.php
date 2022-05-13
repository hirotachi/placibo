<?php
Kirki::add_section( 'header_search', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Element - Search', 'amino' ),
    'panel'       => 'header',
) );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_search_custom2',
	'section'     => 'header_search',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Layout search', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'header_search_layout',
	'label'       => esc_html__( 'Select search layout', 'amino' ),
	'section'     => 'header_search',
	'default'     => 'search-sidebar',
	'multiple'    => 1,
	'choices'     => [
		'search-simple'   => esc_html__( 'Default', 'amino' ),
		'search-simple2' => esc_html__( 'Search Style 2', 'amino' ),
		'search-sidebar'  => esc_html__( 'Search Style 3 (Only icon)', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_search_custom3',
	'section'     => 'header_search',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Search element', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio',
	'settings'    => 'header_search_submit',
	'label'    => esc_html__( 'Use text/icon for submit', 'amino' ),
	'section'     => 'header_search',
	'default'     => 'icon',
	'choices'     => [
		'text'   => esc_html__( 'Text', 'amino' ),
		'icon' => esc_html__( 'Icon', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_search_textsubmit',
	'label'    => esc_html__( 'Enter text for submit button', 'amino' ),
	'section'  => 'header_search',
	'default'  => esc_html__( 'Search', 'amino' ),
	'transport'   => 'postMessage',
	'active_callback'  => [
		[
			'setting'  => 'header_search_submit',
			'operator' => '==',
			'value'    => 'text',
		],
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'header_search_placeholder',
	'label'    => esc_html__( 'Placeholder text', 'amino' ),
	'section'  => 'header_search',
	'default'  => esc_html__( 'Search products here...', 'amino' ),
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'header_search_categories',
	'label'       => esc_html__( 'Active categories', 'amino' ),
	'section'     => 'header_search',
	'default'     => 'off',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'number',
	'settings'    => 'header_search_categories_depth',
	'label'       => esc_html__( 'Categories depth', 'amino' ),
	'section'     => 'header_search',
	'default'     => 1,
	'choices'     => [
		'min'  => 1,
		'max'  => 10,
		'step' => 1,
	],
	'active_callback'  => [
		[
			'setting'  => 'header_search_categories',
			'operator' => '===',
			'value'    => true,
		],
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Keyword list', 'amino' ),
	'section'     => 'header_search',
	'priority'    => 10,
	'row_label' => [
		'type'  => 'field',
		'value' => esc_html__( 'Keyword', 'amino' ),
		'field' => 'keyword',
	],
	'button_label' => esc_html__('Add keyword', 'amino' ),
	'settings'     => 'header_search_keywords',
	'default'      => [],
	'fields' => [
		'keyword' => [
			'type'        => 'text',
			'label'       => esc_html__( 'Keyword', 'amino' ),
			'default'     => '',
		],
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'header_search_custom',
	'section'     => 'header_search',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Results search', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'header_search_resource',
	'label'       => esc_html__( 'Search resource', 'amino' ),
	'description' => esc_html__( 'Show search result from :', 'amino' ),
	'section'     => 'header_search',
	'default'     => 'product-post',
	'multiple'    => 1,
	'choices'     => [
		'product-post' => esc_html__( 'Products & Posts', 'amino' ),
		'product' => esc_html__( 'Products', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'header_search_limit',
	'label'       => esc_html__( 'Number items show when searching', 'amino' ),
	'section'     => 'header_search',
	'default'     => 10,
	'choices'     => [
		'min'  => 1,
		'max'  => 100,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'toggle',
	'settings'    => 'header_search_price',
	'label'       => esc_html__( 'Show price for product results', 'amino' ),
	'section'     => 'header_search',
	'default'     => '1',
] );