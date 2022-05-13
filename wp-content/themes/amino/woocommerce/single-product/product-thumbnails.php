<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     50.4.0
 */
defined( 'ABSPATH' ) || exit;
// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}
global $product;
$attachment_ids = $product->get_gallery_image_ids();
$post_thumbnail_id = $product->get_image_id();
$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
$has_video = false;
$product_video_upload = get_post_meta( get_the_ID(), 'product_video_upload', [] );
$product_video_position = get_post_meta( get_the_ID(), 'product_video_position' , 'last' );
if($product_video_upload) {
	$has_video = true;
}
// Video first position
if($has_video && $product_video_position =='first'){
	echo '<div class="product-thumbnail-item"><div class="video-thumb"><i class="icon-rt-videocam-outline"></i></div></div>';
}
//Main image
if($attachment_ids){
	$image =  wp_get_attachment_image_src( $post_thumbnail_id, 'woocommerce_gallery_thumbnail');
	$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
	$html = '<div class="product-thumbnail-item"><img src="'.$image[0].'" alt="'.$image_alt.'" width="'.$gallery_thumbnail['width'].'" height="'.$gallery_thumbnail['height'].'"  class="attachment-woocommerce_thumbnail" /></div>';
	echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
}

// Video second position
if($has_video && $product_video_position =='second'){
	echo '<div class="product-thumbnail-item"><div class="video-thumb"><i class="icon-rt-videocam-outline"></i></div></div>';
}
//Gallery images
if ( $attachment_ids && $post_thumbnail_id ) {
	foreach ( $attachment_ids as $attachment_id ) {
		$image =  wp_get_attachment_image_src( $attachment_id, 'woocommerce_gallery_thumbnail');
	  	$image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		$html = '<div class="product-thumbnail-item"><img src="'.$image[0].'" alt="'.$image_alt.'" width="'.$gallery_thumbnail['width'].'" height="'.$gallery_thumbnail['height'].'"  class="attachment-woocommerce_thumbnail" /></div>';
        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}
}
// Video last position
if($has_video && $product_video_position =='last'){
	echo '<div class="product-thumbnail-item"><div class="video-thumb"><i class="icon-rt-videocam-outline"></i></div></div>';
}
//NeedToCheck : change size of small thumbnails