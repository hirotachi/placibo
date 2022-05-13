<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 50.4.0
 */
defined( 'ABSPATH' ) || exit;
$slick_responsive = [
	'items_small_desktop'=> 3,
	'items_landscape_tablet'       => 2,
	'items_portrait_tablet'       => 2,
	'items_landscape_mobile'       => 2,
	'items_portrait_mobile'       => 2,
	'items_small_mobile' => 1,
];
$slick_options = [
	'slidesToShow' => 4 ,
	'autoplay' => false,
	'infinite' => false,
	'arrows' => true,
	'dots' => false,
];
if(isset($woocommerce_loop['product_display']) && $woocommerce_loop['product_display'] == 'list') {
	$product_layout = 'small-image';
}else{
	$product_layout = amino_get_option('catalog_product_productstyle','4');
}

$class_wrapper_products = 'wrapper-layout-'.$product_layout;
if ( $cross_sells ) : ?>
	<div class="cross-sells products <?php echo esc_attr($class_wrapper_products); ?>">
		<?php
		$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', esc_html__( 'You may be interested in&hellip;', 'amino' ) );
		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<div class="products-wrapper cross-sells-slider slick-slider-block" data-slick-responsive='<?php echo json_encode( $slick_responsive );?>'  
					data-slick-options='<?php echo json_encode( $slick_options ); ?>'>
			<?php foreach ( $cross_sells as $cross_sell ) : ?>
				<?php
					$post_object = get_post( $cross_sell->get_id() );
					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
					?>
					<div class="product-wrapper product-carousel">
						<?php wc_get_template_part( 'content', 'product' ); ?>
					</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
endif;
wp_reset_postdata();