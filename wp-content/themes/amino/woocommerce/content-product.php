<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 50.4.0
 */
defined( 'ABSPATH' ) || exit;
global $product, $woocommerce_loop;
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$classes = array();
if(!isset($woocommerce_loop['is_slider'])) {
	$woocommerce_loop['is_slider'] = true;
}
if(isset($woocommerce_loop['shopview'])) {
	$shopview = $woocommerce_loop['shopview'];
}else{
	$shopview = 'grid';
}
if(!$woocommerce_loop['is_slider']){
	if($shopview == 'grid') {
		$classes[] = '';
		if($woocommerce_loop['column_desktop'] == 5) {
			$classes[] .= 'col-xl-12-5';
		}else{
			$classes[] .= 'col-xl-'.(12/$woocommerce_loop['column_desktop']);
		}
		if($woocommerce_loop['column_tablet'] == 5) {
			$classes[] .= 'col-md-12-5';
		}else{
			$classes[] .= 'col-md-'.(12/$woocommerce_loop['column_tablet']);
		}
		if($woocommerce_loop['column_phone'] == 5) {
			$classes[] .= 'col-12-5';
		}else{
			$classes[] .= 'col-'.(12/$woocommerce_loop['column_phone']);
		}
	}else{
		$classes[] = 'col-12';
	}
}
$show_second_image = amino_get_option('catalog_product_hover', true);
if($show_second_image) {
	$classes[] = 'has_hover_image';
}
if(isset($woocommerce_loop['product_display']) && $woocommerce_loop['product_display'] == 'list') {
	$product_layout = 'small-image';
}else{
	$product_layout = amino_get_option('catalog_product_productstyle','5');
}

$classes[] = 'woocommerce product-layout-'.$product_layout;
?>
<div <?php wc_product_class( $classes, $product ); ?>>
	<?php
		do_action( 'woocommerce_before_shop_loop_item' );
		if($shopview == 'grid' ) {
			wc_get_template_part( 'product-layouts/product', 'layout-'.$product_layout );
		}else{
			wc_get_template_part( 'product-layouts/product', 'layout-list');
		}
		do_action( 'woocommerce_after_shop_loop_item' );
	?>
</div>