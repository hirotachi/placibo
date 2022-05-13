<?php
$args = array(
    'post_type'=> 'rt_custom_block',
    'post_status' => 'publish',
    'order'    => 'ASC'
);              
$custom_blocks = array();
$custom_blocks[''] = '-----';
$the_query = new WP_Query( $args );
if($the_query->have_posts() ) : 
    while ( $the_query->have_posts() ) : 
       $the_query->the_post(); 
       $custom_blocks[get_the_ID()] = get_the_title();
    endwhile; 
    wp_reset_postdata(); 
endif;
Kirki::add_section( '404page', array(
    'priority'    => 60,
    'title'       => esc_html__( '404 page', 'amino' ),
) );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => '404page_custom1',
	'section'     => '404page',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Custom 404 page content', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'select',
	'settings'    => '404page_custom_content',
	'label'       => esc_html__( 'Custom content', 'amino' ),
	'description' => esc_html__( 'Replace 404 page content with a Custom Block that you can edit with Elementor page builder.', 'amino' ),
	'section'     => '404page',
	'default'     => '',
	'multiple'    => 1,
	'choices'     => $custom_blocks,
] );
Kirki::add_field( 'option', [
	'type'        => 'custom',
	'settings'    => '404page_custom2',
	'section'     => '404page',
	'default'         => '<div class="customize-title-divider">' . esc_html__( 'Default content', 'amino' ) . '</div>',
] );
Kirki::add_field( 'option', [
	'type'        => 'image',
	'settings'    => '404page_image',
	'label'       => esc_html__( '404 image', 'amino' ),
	'description' => esc_html__( 'If there no 404 image, the 404 text will be used.', 'amino' ),
	'section'     => '404page',
	'default'     => '',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => '404page_text1',
	'label'    => esc_html__( 'Text 1', 'amino' ),
	'section'  => '404page',
] );
Kirki::add_field( 'option', [
	'type'     => 'textarea',
	'settings' => '404page_text2',
	'label'    => esc_html__( 'Text 2', 'amino' ),
	'section'  => '404page',
] );