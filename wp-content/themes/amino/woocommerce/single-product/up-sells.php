<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$upsell_status = amino_get_option('single_product_upsell', true);
$upsell_title = amino_get_option('single_product_upsell_title', esc_html__('Up-Sells Products','amino'));
$upsell_items = amino_get_option('single_product_upsell_item', 5);
$slick_responsive = [
	'items_small_desktop' => 4,
	'items_landscape_tablet' => 3,
	'items_portrait_tablet' => 3,
	'items_landscape_mobile' => 2,
	'items_portrait_mobile' => 2,
	'items_small_mobile' => 2,
];
$slick_options = [
	'slidesToShow' => (int)$upsell_items ? (int)$upsell_items : 4 ,
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
if ( $upsells && $upsell_status ) : ?>
	<section class="up-sells upsells products <?php echo esc_attr($class_wrapper_products); ?>">
		<?php
		if($upsell_title){
			$heading = apply_filters( 'woocommerce_product_upsells_products_heading', $upsell_title );
		}else{
			$heading = apply_filters( 'woocommerce_product_upsells_products_heading', esc_html__( 'You may also like&hellip;', 'amino' ) );
		}
		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<div class="products-wrapper upsell-slider slick-slider-block" data-slick-responsive='<?php echo json_encode( $slick_responsive );?>'  
					data-slick-options='<?php echo json_encode( $slick_options ); ?>'>
				<?php foreach ( $upsells as $product ) : ?>
					<?php
					$post_object = get_post( $product->get_id() );
					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
					?>
					<div class="product-wrapper product-carousel">
						<?php
						wc_get_template_part( 'content', 'product' );				
						?>
					</div>
				<?php endforeach; ?>
		</div>
	</section>
	<?php
endif;
wp_reset_postdata();