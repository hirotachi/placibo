<?php
Kirki::add_section( 'blog_single', array(
    'priority'    => 2,
    'title'       => esc_html__( 'Single page', 'amino' ),
    'panel'       => 'blog',
) );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'blog_single_layout',
	'label'       => esc_html__( 'Layout', 'amino' ),
	'section'     => 'blog_single',
	'default'     => 'no-sidebar',
	'choices'     => [
		'left-sidebar'   => get_template_directory_uri() . '/assets/images/customizer/layout-left-sidebar.png',
		'no-sidebar'  => get_template_directory_uri() . '/assets/images/customizer/layout-no-sidebar.png',
		'right-sidebar' => get_template_directory_uri() . '/assets/images/customizer/layout-right-sidebar.png',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'blog_single_design',
	'label'       => esc_html__( 'Design', 'amino' ),
	'section'     => 'blog_single',
	'default'     => '1',
	'multiple'    => 1,
	'choices'     => [
		'1' => esc_html__( 'Design 1', 'amino' ),
		'2' => esc_html__( 'Design 2', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'blog_single_fdimage',
	'label'       => esc_html__( 'Hide featured image', 'amino' ),
	'section'     => 'blog_single',
	'default'     => '0',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'blog_single_title_align',
	'label'       => esc_html__( 'Title align', 'amino' ),
	'section'     => 'blog_single',
	'default'     => 'left',
	'priority'    => 10,
	'choices'     => [
		'left'   => esc_html__( 'Left', 'amino' ),
		'center' => esc_html__( 'Center', 'amino' ),
		'right'  => esc_html__( 'Right', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'blog_single_title',
	'label'       => esc_html__( 'Title color', 'amino' ),
	'section'     => 'blog_single',
	'default'     => 'dark',
	'choices'     => [
		'dark'   => get_template_directory_uri() . '/assets/images/customizer/text-dark.svg',
		'light' => get_template_directory_uri() . '/assets/images/customizer/text-light.svg',
	],
	'active_callback' => [
		[
			'setting'  => 'blog_single_design',
			'operator' => '==',
			'value'    => '2',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'image',
	'settings'    => 'blog_single_bgtitle',
	'label'       => esc_html__( 'Image for post title', 'amino' ),
	'description' => esc_html__( 'Image use for all post. You can change it for each post when edit a post.', 'amino' ),
	'section'     => 'blog_single',
	'default'     => '',
	'active_callback' => [
		[
			'setting'  => 'blog_single_design',
			'operator' => '==',
			'value'    => '2',
		]
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'blog_single_pdtitle',
	'label'       => esc_html__( 'Padding top & bottom (px)', 'amino' ),
	'section'     => 'blog_single',
	'default'     => 30,
	'choices'     => [
		'min'  => 0,
		'max'  => 500,
		'step' => 1,
	],
	'active_callback' => [
		[
			'setting'  => 'blog_single_design',
			'operator' => '==',
			'value'    => '2',
		]
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'blog_single_related_part',
	'section'     => 'blog_single',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Related posts', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'blog_single_related',
	'label'       => esc_html__( 'Show related posts', 'amino' ),
	'section'     => 'blog_single',
	'default'     => '1',
	'choices'     => [
		'on'  => esc_html__( 'Yes', 'amino' ),
		'off' => esc_html__( 'No', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'blog_single_related_limit',
	'label'       => esc_html__( 'Limit', 'amino' ),
	'description' => esc_html__( 'Number of related post can be shown.', 'amino' ),
	'section'     => 'blog_single',
	'default'     => 4,
	'choices'     => [
		'min'  => 1,
		'max'  => 20,
		'step' => 1,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'slider',
	'settings'    => 'blog_single_related_column',
	'label'       => esc_html__( 'Columns', 'amino' ),
	'section'     => 'blog_single',
	'default'     => 3,
	'choices'     => [
		'min'  => 1,
		'max'  => 6,
		'step' => 1,
	],
] );