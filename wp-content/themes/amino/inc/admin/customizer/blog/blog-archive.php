<?php
Kirki::add_section( 'blog_archive', array(
    'priority'    => 1,
    'title'       => esc_html__( 'Archive page', 'amino' ),
    'panel'       => 'blog',
) );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'blog_archive_layout_part',
	'section'     => 'blog_archive',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Layout', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'blog_archive_layout',
	'label'       => esc_html__( 'Layout', 'amino' ),
	'section'     => 'blog_archive',
	'default'     => 'right-sidebar',
	'choices'     => [
		'left-sidebar'   => get_template_directory_uri() . '/assets/images/customizer/layout-left-sidebar.png',
		'no-sidebar'  => get_template_directory_uri() . '/assets/images/customizer/layout-no-sidebar.png',
		'right-sidebar' => get_template_directory_uri() . '/assets/images/customizer/layout-right-sidebar.png',
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'blog_archive_design',
	'label'       => esc_html__( 'Design', 'amino' ),
	'section'     => 'blog_archive',
	'default'     => 'design-1',
	'multiple'    => 1,
	'choices'     => [
		'design-1' => esc_html__( 'Design 1', 'amino' ),
		'design-2' => esc_html__( 'Design 2', 'amino' ),
		'design-3' => esc_html__( 'Design 3', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'blog_archive_items',
	'label'       => esc_html__( 'Blog items columns', 'amino' ),
	'section'     => 'blog_archive',
	'default'     => '1',
	'choices'     => [
		'1'       => 1,
		'2'       => 2,
		'3'       => 3,
		'4'       => 4,
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'posts_navigation',
	'label'       => esc_html__( 'Navigation type', 'amino' ),
	'section'     => 'blog_archive',
	'default'     => 'default',
	'choices'     => [
		'default'   => esc_html__( 'Default', 'amino' ),
		'loadmore' => esc_html__( 'Load more', 'amino' ),
		'infinite'  => esc_html__( 'Infinite scroll', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'blog_archive_post_part',
	'section'     => 'blog_archive',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Blog post options', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-buttonset',
	'settings'    => 'blog_archive_excerpt',
	'label'       => esc_html__( 'Posts excerpt', 'amino' ),
	'section'     => 'blog_archive',
	'default'     => 'excerpt',
	'choices'     => [
		'full'   => esc_html__( 'Full content', 'amino' ),
		'excerpt' => esc_html__( 'Excerpt', 'amino' ),
	],
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'blog_archive_excerpt_length',
	'label'    => esc_html__( 'Excerpt length ( By word )', 'amino' ),
	'default'     => '18',
	'section'  => 'blog_archive',
] );
Kirki::add_field( 'option', [
	'type'     => 'text',
	'settings' => 'blog_archive_excerpt_suffix',
	'label'    => esc_html__( 'Excerpt more', 'amino' ),
	'description'    => esc_html__( 'Default [...]', 'amino' ),
	'section'  => 'blog_archive',
	'default'  => '...',
] );