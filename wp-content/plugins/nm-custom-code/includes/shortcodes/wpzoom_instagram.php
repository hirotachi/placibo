<?php

/*
 *  Shortcode: nm_wpzoom_instagram
 */
function nm_shortcode_wpzoom_instagram( $atts, $content = null ) {
    extract( shortcode_atts( array(
        //'widget_name' => false
    ), $atts ) );
    
    $instance = array(
        'title'                         => '',
        'button_text'                   => '',
        'image-limit'                   => 12,
        'show-view-on-instagram-button' => false,
        'show-counts-on-hover'          => false,
        'show-user-info'                => false,
        'show-user-bio'                 => false,
        'lazy-load-images'              => false,
        'disable-video-thumbs'          => false,
        'images-per-row'                => 5,
        'image-width'                   => 120,
        'image-spacing'                 => 10,
        'image-resolution'              => 'default_algorithm',
        'username'                      => '_nordicmade',
    );
    
    ob_start();
    the_widget( 'Wpzoom_Instagram_Widget', $instance, array(
        //'widget_id' => 'arbitrary-instance-' . $id,
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );
    $output = ob_get_clean();
    
    return $output;
}

if ( class_exists( 'Wpzoom_Instagram_Widget' ) ) { // Make sure the WPZOOM Instagram widget exists
    add_shortcode( 'nm_wpzoom_instagram', 'nm_shortcode_wpzoom_instagram' );
}