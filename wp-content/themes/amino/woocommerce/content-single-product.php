<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
global $product;
$specific_product_layout = get_post_meta(get_the_ID(), 'product_custom_layout', 'default');
$product_layout = amino_get_option('single_product_layout', 'simple');
if($specific_product_layout && $specific_product_layout != 'default') {
	$layout = $specific_product_layout;
}else{
	$layout = $product_layout;
}
$product_class = 'product-layout-'.$layout;
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( $product_class, $product ); ?>>
	<?php
		wc_get_template_part( 'single-product/layouts/product', $layout );
	?>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>