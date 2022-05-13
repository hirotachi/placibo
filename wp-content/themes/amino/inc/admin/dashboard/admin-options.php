<?php
add_action( 'cmb2_admin_init', 'amino_register_page_metabox' );
function amino_register_page_metabox() {
	$cmb_demo = new_cmb2_box( array(
		'id'            => 'amino_page_metabox',
		'title'         => esc_html__( 'Page Options' , 'amino' ),
		'object_types'  => array( 'page' ), // Post type
	) );
	$cmb_demo->add_field( array(
	    'name'             => esc_html__( 'Select header for this page' , 'amino' ),
	    'desc'             => esc_html__( 'Default: get header from themeoption' , 'amino' ),
	    'id'               => 'page_custom_header',
	    'type'             => 'select',
	    'default'          => 'default',
	    'options'          => array(
	        'default'     => esc_html__( 'Default', 'amino' ),
	        '1'           => esc_html__( 'Header 1', 'amino' ),
	        '2'           => esc_html__( 'Header 2', 'amino' ),
	        '3'           => esc_html__( 'Header 3', 'amino' ),
	        '4'           => esc_html__( 'Header 4', 'amino' ),
	    ),
	) );
	$cmb_demo->add_field( array(
	    'name' => esc_html__( 'Disable page title' , 'amino' ),
	    'desc' => esc_html__( 'Disable page title for this page' , 'amino' ),
	    'id'   => 'page_custom_title',
	    'type' => 'checkbox',
	) );
	$cmb_demo->add_field( array(
	    'name' => esc_html__( 'Disable breadcrumb' , 'amino' ),
	    'desc' => esc_html__( 'Disable breadcrumb for this page' , 'amino' ),
	    'id'   => 'page_custom_breadcrumb',
	    'type' => 'checkbox',
	) );
	$cmb_demo->add_field( array(
	    'name'    => esc_html__( 'Image for page title' , 'amino' ),
	    'desc'    => esc_html__( 'Upload an image.' , 'amino' ),
	    'id'      => 'page_custom_title_image',
	    'type'    => 'file',
	    // Optional:
	    'options' => array(
	        'url' => false, // Hide the text input for the url
	    ),
	    'text'    => array(
	        'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
	    ),
	    // query_args are passed to wp.media's library query.
	    'query_args' => array(
	        'type' => array(
	            'image/gif',
	            'image/jpeg',
	            'image/png',
	        ),
	    ),
	    'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );
}
add_action( 'cmb2_admin_init', 'amino_register_post_metabox' );
function amino_register_post_metabox() {
	$cmb_demo = new_cmb2_box( array(
		'id'            => 'rt_post_metabox',
		'title'         => esc_html__( 'Post Options', 'amino' ),
		'object_types'  => array( 'post' ), // Post type
	) );
	$cmb_demo->add_field( array(
	    'name'             => esc_html__( 'Select header for this page', 'amino' ),
	    'desc'             => esc_html__( 'Default: get header from themeoption', 'amino' ),
	    'id'               => 'page_custom_header',
	    'type'             => 'select',
	    'default'          => 'default',
	    'options'          => array(
	        'default'     => esc_html__( 'Default', 'amino' ),
	        '1'           => esc_html__( 'Header 1', 'amino' ),
	        '2'           => esc_html__( 'Header 2', 'amino' ),
	        '3'           => esc_html__( 'Header 3', 'amino' ),
	    ),
	) );
	$cmb_demo->add_field( array(
	    'name' => esc_html__( 'Hide the post title', 'amino' ),
	    'desc' => esc_html__( 'The post title will be hidden in single post page.', 'amino' ),
	    'id'   => 'post_hide_title',
	    'type' => 'checkbox',
	) );
	$cmb_demo->add_field( array(
	    'name' => esc_html__( 'Hide the featured image', 'amino' ),
	    'desc' => esc_html__( 'The post featured image will be hidden in single post page.', 'amino' ),
	    'id'   => 'post_hide_featured_image',
	    'type' => 'checkbox',
	) );
	$cmb_demo->add_field( array(
	    'name'    => esc_html__( 'Image for page title', 'amino' ),
	    'desc'    => esc_html__( 'Upload an image.', 'amino' ),
	    'id'      => 'page_custom_title_image',
	    'type'    => 'file',
	    // Optional:
	    'options' => array(
	        'url' => false, // Hide the text input for the url
	    ),
	    'text'    => array(
	        'add_upload_file_text' => esc_html__( 'Add File', 'amino' ) // Change upload button text. Default: "Add or Upload File"
	    ),
	    // query_args are passed to wp.media's library query.
	    'query_args' => array(
	        'type' => array(
	            'image/gif',
	            'image/jpeg',
	            'image/png',
	        ),
	    ),
	    'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );
}