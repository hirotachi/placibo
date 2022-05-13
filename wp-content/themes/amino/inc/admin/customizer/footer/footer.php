<?php
$bottom_footer_content = array(
	'none' => esc_html__( 'None', 'amino' ),
	'copyright' => esc_html__( 'Copyright', 'amino' ),
	'footer-menu' => esc_html__( 'Footer menu', 'amino' ),
	'social' => esc_html__( 'Social list', 'amino' ),
	'payment' => esc_html__( 'Payment icon', 'amino' ),
);
Kirki::add_section( 'footer', array(
    'priority'    => 58,
    'title'       => esc_html__( 'Footer', 'amino' ),
) );
// footer_before
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'footer_before',
	'section'     => 'footer',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Before Footer', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'footer_before_content',
	'label'    => esc_html__( 'Custom content', 'amino' ),
	'description'    => esc_html__( 'Use HTML or shortcode', 'amino' ),
	'section'  => 'footer',
	'default'  => '',
] );

// footer_main
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'footer_main',
	'section'     => 'footer',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Main Footer', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'footer_layout',
	'label'       => esc_html__( 'Footer main layout', 'amino' ),
	'section'     => 'footer',
	'default'     => 'layout-5',
	'choices'     => [
		'layout-1' => get_template_directory_uri() . '/assets/images/customizer/footer-1.png',
		'layout-2' => get_template_directory_uri() . '/assets/images/customizer/footer-2.png',
		'layout-3' => get_template_directory_uri() . '/assets/images/customizer/footer-3.png',
		'layout-4' => get_template_directory_uri() . '/assets/images/customizer/footer-4.png',
		'layout-5' => get_template_directory_uri() . '/assets/images/customizer/footer-5.png',
		'layout-6' => get_template_directory_uri() . '/assets/images/customizer/footer-6.png',
		'layout-7' => get_template_directory_uri() . '/assets/images/customizer/footer-7.png',
	],
	'transport'   => 'postMessage',
] );

Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'footer_text',
	'label'       => esc_html__( 'Text footer', 'amino' ),
	'section'     => 'footer',
	'default'     => 'light',
	'choices'     => [
		'dark'   => get_template_directory_uri() . '/assets/images/customizer/text-dark.svg',
		'light' => get_template_directory_uri() . '/assets/images/customizer/text-light.svg',
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'background',
	'settings'    => 'footer_main_background',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'footer',
	'default'     => [
		'background-color'      => '#1d1d1d',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'postMessage',
] );
// footer_bottom
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => 'footer_bottom',
	'section'     => 'footer',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Bottom footer', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'switch',
	'settings'    => 'footer_bottom_active',
	'label'       => esc_html__( 'Active Bottom Footer', 'amino' ),
	'section'     => 'footer',
	'default'     => 'on',
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'footer_bottom_left',
	'label'       => esc_html__( 'Left content', 'amino' ),
	'section'     => 'footer',
	'default'     => 'social',
	'multiple'    => 1,
	'choices'     => $bottom_footer_content,
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'footer_bottom_center',
	'label'       => esc_html__( 'Center Content', 'amino' ),
	'section'     => 'footer',
	'default'     => 'copyright',
	'multiple'    => 1,
	'choices'     => $bottom_footer_content,
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => 'footer_bottom_right',
	'label'       => esc_html__( 'Right content', 'amino' ),
	'section'     => 'footer',
	'default'     => 'payment',
	'multiple'    => 1,
	'choices'     => $bottom_footer_content,
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'radio-image',
	'settings'    => 'footer_bottom_text',
	'label'       => esc_html__( 'Text color', 'amino' ),
	'section'     => 'footer',
	'default'     => 'light',
	'choices'     => [
		'dark'   => get_template_directory_uri() . '/assets/images/customizer/text-dark.svg',
		'light' => get_template_directory_uri() . '/assets/images/customizer/text-light.svg',
	],
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'color',
	'settings'    => 'footer_bottom_background',
	'label'       => esc_html__( 'Background', 'amino' ),
	'section'     => 'footer',
	'choices'     => [
		'alpha' => true,
	],
	'default'     => '#1d1d1d',
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => 'footer_bottom_copyright',
	'label'    => esc_html__( 'Copyright', 'amino' ),
	'section'  => 'footer',
	'default'  => esc_html__( 'Copyright by Roadthemes. All Rights Reserved.', 'amino' ),
	'transport'   => 'postMessage',
] );
Kirki::add_field( 'option', [
	'type'        => 'image',
	'settings'    => 'footer_bottom_payment',
	'label'       => esc_html__( 'Payment icon', 'amino' ),
	'section'     => 'footer',
	'default'     => '',
	'transport'   => 'postMessage',
] );
function amino_refresh_footer_partials( WP_Customize_Manager $wp_customize ) {
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}
	$wp_customize->selective_refresh->add_partial( 'footer-top', array(
	    'selector' => '.footer-top',
	    'settings' => array('footer_top_active', 'footer_top_color','footer_top_newsletter','footer_top_imgapp'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_top_footer',
	) );
	$wp_customize->selective_refresh->add_partial( 'footer-main', array(
	    'selector' => '.footer-main',
	    'settings' => array('footer_main','footer_layout','footer_text','footer_policy','footer_policy_active'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_main_footer',
	) );
	$wp_customize->selective_refresh->add_partial( 'footer-botom', array(
	    'selector' => '.footer-bottom',
	    'settings' => array('footer_bottom_active','footer_bottom_left','footer_bottom_center','footer_bottom_right','footer_bottom_text','footer_bottom_copyright', 'footer_bottom_payment'),
	    'container_inclusive' => true,
	    'render_callback' => 'amino_bottom_footer',
	) );
}
add_action( 'customize_register', 'amino_refresh_footer_partials' );