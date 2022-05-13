<?php
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_catalog_product_layout',
	'section'     => 'woocommerce_product_catalog',
	'default'     => '<div class="customize-title-divider">' . esc_html__( 'Catalog layout', 'amino' ) . '</div>',
	'priority'    => 1,
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'catalog_product_layout',
	'label'       => esc_html__( 'Catalog layout', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'left-sidebar',
	'choices'     => [
		'no-sidebar'   => get_template_directory_uri() . '/assets/images/customizer/layout-no-sidebar.png',
		'left-sidebar' => get_template_directory_uri() . '/assets/images/customizer/layout-left-sidebar.png',
		'right-sidebar'  => get_template_directory_uri() . '/assets/images/customizer/layout-right-sidebar.png',
	],
	'priority'    => 1,
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'shop_sidebar_width',
	'label'       => esc_html__( 'Sidebar width (%)', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 25,
	'choices'     => [
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	],
	'priority'    => 1,
	'transport' => 'postMessage',
	'active_callback' => [
		[
			'setting'  => 'catalog_product_layout',
			'operator' => '!=',
			'value'    => 'no-sidebar',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'catalog_product_per_page',
	'label'    => esc_html__( 'Products per page', 'amino' ),
	'section'  => 'woocommerce_product_catalog',
	'default'  => '12',
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'catalog_product_items_desktop',
	'label'       => esc_html__( 'Items per row - Desktop', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 3,
	'choices'     => [
		'min'  => 2,
		'max'  => 6,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'catalog_product_items_tablet',
	'label'       => esc_html__( 'Items per row - Tablet', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 3,
	'choices'     => [
		'min'  => 2,
		'max'  => 4,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'catalog_product_items_phone',
	'label'       => esc_html__( 'Items per row - Phone', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 2,
	'choices'     => [
		'min'  => 1,
		'max'  => 3,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'catalog_product_pagination',
	'label'       => esc_html__( 'Pagination type', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'default',
	'choices'     => [
		'default'   => esc_html__( 'Default', 'amino' ),
		'loadmore' => esc_html__( 'Load more', 'amino' ),
		'infinite'  => esc_html__( 'Infinite scroll', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_catalog_product_cate',
	'section'     => 'woocommerce_product_catalog',
	'default'     => '<div class="customize-title-divider">' . esc_html__( 'Category description & thumbnail', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'catalog_product_category_desc',
	'label'       => esc_html__( 'Category description', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'part',
	'choices'     => [
		'hide'   => esc_html__( 'Hide', 'amino' ),
		'full' => esc_html__( 'Show full', 'amino' ),
		'part'  => esc_html__( 'Show a part', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'catalog_product_desc_position',
	'label'       => esc_html__( 'Description position', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'top',
	'choices'     => [
		'top'   => esc_html__( 'Top', 'amino' ),
		'bottom' => esc_html__( 'Bottom', 'amino' ),
	],
	'description' => esc_html__( 'Bottom: description show under product list', 'amino' ),
	'active_callback' => [
		[
			'setting'  => 'catalog_product_category_desc',
			'operator' => '!=',
			'value'    => 'hide',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'catalog_product_category_thumb',
	'label'       => esc_html__( 'Category thumbnail', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'show',
	'choices'     => [
		'hide'   => esc_html__( 'Hide', 'amino' ),
		'show' => esc_html__( 'Show', 'amino' ),
	],
	
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_catalog_product_subcategories',
	'section'     => 'woocommerce_product_catalog',
	'default'     => '<div class="customize-title-divider">' . esc_html__( 'Subcategories', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'checkbox',
	'settings'    => 'catalog_product_subcategories',
	'label'       => esc_html__( 'Show subcategories', 'amino' ),
	'description' => esc_html__( 'Show/hide subcategories slider in shop/category page.', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => false,
	'priority' => 10,
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'catalog_product_sub_items',
	'label'       => esc_html__( 'Number subcategories on screen', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 6,
	'choices'     => [
		'min'  => 2,
		'max'  => 12,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'catalog_product_sub_design',
	'label'       => esc_html__( 'Subcategories design', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'design1',
	'choices'     => [
		'design1'   => get_template_directory_uri() . '/assets/images/customizer/sub1.png',
		'design2' => get_template_directory_uri() . '/assets/images/customizer/sub2.png',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_catalog_product_filter',
	'section'     => 'woocommerce_product_catalog',
	'default'     => '<div class="customize-title-divider">' . esc_html__( 'Filters', 'amino' ) . '</div>',
	'active_callback' => [
		[
			'setting'  => 'catalog_product_layout',
			'operator' => '==',
			'value'    => 'no-sidebar',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'catalog_product_filter_posistion',
	'label'       => esc_html__( 'Filters position', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'side',
	'choices'     => [
		'top' => get_template_directory_uri() . '/assets/images/customizer/layout-left-sidebar.png',
		'side'  => get_template_directory_uri() . '/assets/images/customizer/layout-left-sidebar.png',
	],
	'active_callback' => [
		[
			'setting'  => 'catalog_product_layout',
			'operator' => '==',
			'value'    => 'no-sidebar',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_catalog_product_product',
	'section'     => 'woocommerce_product_catalog',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Product style', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'catalog_product_productstyle',
	'label'       => esc_html__( 'Product grid style', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => '5',
	'multiple'    => 1,
	'choices'     => [
		'1' => esc_html__( 'Style 1', 'amino' ),
		'2' => esc_html__( 'Style 2', 'amino' ),
		'3' => esc_html__( 'Style 3', 'amino' ),
		'4' => esc_html__( 'Style 4', 'amino' ),
		'5' => esc_html__( 'Style 5', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'checkbox',
	'settings'    => 'catalog_product_hover',
	'label'       => esc_html__( 'Active hover image', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => true,
] );
Kirki::add_field( 'option', [
	'type'        => 'checkbox',
	'settings'    => 'catalog_product_quickview',
	'label'       => esc_html__( 'Show quickview', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => true,
] );
Kirki::add_field( 'option', [
	'type'        => 'checkbox',
	'settings'    => 'catalog_product_category',
	'label'       => esc_html__( 'Show category', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => true,
] );
Kirki::add_field( 'option', [
	'type'        => 'checkbox',
	'settings'    => 'catalog_product_rating',
	'label'       => esc_html__( 'Show rating', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => false,
] );
Kirki::add_field( 'option', [
	'type'        => 'checkbox',
	'settings'    => 'catalog_product_countdown',
	'label'       => esc_html__( 'Show countdown', 'amino' ),
	'description' => esc_html__( 'Show countdown when product has sale price', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => true,
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'catalog_product_sale',
	'label'       => esc_html__( 'Sale label', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'text',
	'choices'     => [
		'text'   => esc_html__( 'Text', 'amino' ),
		'percent' => esc_html__( 'Percent discount', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'catalog_product_sale_design',
	'label'       => esc_html__( 'Sale label design', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => 'circle',
	'choices'     => [
		'circle'   => get_template_directory_uri() . '/assets/images/customizer/label-1.jpg',
        'rectangle' => get_template_directory_uri().'/assets/images/customizer/label-2.jpg',
        'elip' => get_template_directory_uri().'/assets/images/customizer/label-3.jpg',
        'trapezium' => get_template_directory_uri().'/assets/images/customizer/label-4.jpg',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'catalog_product_sale_bground',
	'label'       => esc_html__( 'Sale label background', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => '#ffffff',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'catalog_product_sale_color',
	'label'       => esc_html__( 'Sale label color', 'amino' ),
	'section'     => 'woocommerce_product_catalog',
	'default'     => '#e74343',
	'choices'     => [
		'alpha' => true,
	],
	'transport'   => 'postMessage',
] );