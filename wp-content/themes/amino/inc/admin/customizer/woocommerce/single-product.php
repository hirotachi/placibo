<?php
Kirki::add_section( 'single_product', array(
    'title'       => esc_html__( 'Product page', 'amino' ),
    'panel'       => 'woocommerce',
) );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'single_product_layout',
	'label'       => esc_html__( 'Select product page layout', 'amino' ),
	'section'     => 'single_product',
	'default'     => 'simple',
	'choices'     => [
		'simple' => get_template_directory_uri() . '/assets/images/customizer/single-product1.jpg',
		'fulltop' => get_template_directory_uri() . '/assets/images/customizer/single-product2.jpg',
		'fullleft' => get_template_directory_uri() . '/assets/images/customizer/single-product3.jpg',
		'vertical' => get_template_directory_uri() . '/assets/images/customizer/single-product4.jpg',
		'grid' => get_template_directory_uri() . '/assets/images/customizer/single-product5.jpg',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'single_product_image',
	'label'       => esc_html__( 'Image block width', 'amino' ),
	'section'     => 'single_product',
	'default'     => 'default',
	'choices'     => [
		'smaller' => esc_html__( 'Smaller', 'amino' ),
		'default' => esc_html__( 'Default', 'amino' ),
		'larger'  => esc_html__( 'Larger', 'amino' ),
	],
	'active_callback'  => [
		[
			'setting'  => 'single_product_layout',
			'operator' => '!==',
			'value'    => 'fulltop',
		],
	]
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'fulltop_item',
	'label'       => esc_html__( 'Number of images on screen', 'amino' ),
	'section'     => 'single_product',
	'default'     => 3,
	'choices'     => [
		'min'  => 1,
		'max'  => 6,
		'step' => 1,
	],
	'active_callback'  => [
		[
			'setting'  => 'single_product_layout',
			'operator' => '==',
			'value'    => 'fulltop',
		],
	]
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'grid_p_item',
	'label'       => esc_html__( 'Number of column on screen', 'amino' ),
	'section'     => 'single_product',
	'default'     => 2,
	'choices'     => [
		'min'  => 1,
		'max'  => 2,
		'step' => 1,
	],
	'active_callback'  => [
		[
			'setting'  => 'single_product_layout',
			'operator' => '==',
			'value'    => 'grid',
		],
	]
] );

Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'single_product_sizechart',
	'section'     => 'single_product',
	'default'         => '<div class="sub-divider">' . esc_html__( 'Size Chart', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'single_product_sizechart_title',
	'label'    => esc_html__( 'Size chart title', 'amino' ),
	'section'  => 'single_product',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'single_product_sizechart_content',
	'label'    => esc_html__( 'Size chart content', 'amino' ),
	'section'  => 'single_product',
	'description'  => esc_html__( 'Allow using HTML, shortcode', 'amino' ),
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'single_product_sub',
	'section'     => 'single_product',
	'default'         => '<div class="sub-divider">' . esc_html__( 'Options', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'toggle',
	'settings'    => 'zoom_active',
	'label'       => esc_html__( 'Active zoom', 'amino' ),
	'section'     => 'single_product',
	'default'     => '1',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'single_product_tab',
	'label'       => esc_html__( 'Tab design', 'amino' ),
	'section'     => 'single_product',
	'default'     => 'default',
	'multiple'    => 1,
	'choices'     => [
		'default' => esc_html__( 'Default', 'amino' ),
		'horizontal' => esc_html__( 'Horizontal', 'amino' ),
		'vertical' => esc_html__( 'Vertical', 'amino' ),
		'accordion' => esc_html__( 'Accordion', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'single_product_tab_title',
	'label'    => esc_html__( 'Additional tab title', 'amino' ),
	'section'  => 'single_product',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'single_product_tab_content',
	'label'    => esc_html__( 'Additional tab content', 'amino' ),
	'section'  => 'single_product',
	'description'  => esc_html__( 'Allow using HTML, shortcode', 'amino' ),
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_single_product_upsell_title',
	'section'     => 'single_product',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Upsell products block', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'single_product_upsell',
	'label'       => esc_html__( 'Status', 'amino' ),
	'section'     => 'single_product',
	'default'     => '1',
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'amino' ),
		'off' => esc_html__( 'Disable', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'single_product_upsell_title',
	'label'    => esc_html__( 'Title', 'amino' ),
	'section'  => 'single_product',
	'default'  => esc_html__( 'Upsell products', 'amino' ),
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'single_product_upsell_item',
	'label'       => esc_html__( 'Product on screen', 'amino' ),
	'section'     => 'single_product',
	'default'     => 4,
	'choices'     => [
		'min'  => 3,
		'max'  => 6,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'custom_single_product_related_title',
	'section'     => 'single_product',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Related products block', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'single_product_related',
	'label'       => esc_html__( 'Status', 'amino' ),
	'section'     => 'single_product',
	'default'     => '1',
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'amino' ),
		'off' => esc_html__( 'Disable', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'single_product_related_title',
	'label'    => esc_html__( 'Title', 'amino' ),
	'section'  => 'single_product',
	'default'  => esc_html__( 'Related products', 'amino' ),
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'single_product_related_item',
	'label'       => esc_html__( 'Product on screen', 'amino' ),
	'section'     => 'single_product',
	'default'     => 4,
	'choices'     => [
		'min'  => 3,
		'max'  => 6,
		'step' => 1,
	],
] );