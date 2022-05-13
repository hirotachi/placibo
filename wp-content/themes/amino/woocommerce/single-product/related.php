<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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
$related_status = amino_get_option('single_product_related', true);
$related_title = amino_get_option('single_product_related_title', esc_html__('Related Products','amino'));
$related_items = amino_get_option('single_product_related_item', 5);
$slick_responsive = [
	'items_small_desktop'=> 4,
	'items_landscape_tablet' => 3,
	'items_portrait_tablet' => 3,
	'items_landscape_mobile' => 2,
	'items_portrait_mobile' => 2,
	'items_small_mobile' => 2,
];
$slick_options = [
	'slidesToShow' => (int)$related_items ? (int)$related_items : 4 ,
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
if ( $related_products && $related_status ) : ?>
	<section class="related products <?php echo esc_attr($class_wrapper_products); ?>">
		<?php
		if($related_title) {
			$heading = apply_filters( 'woocommerce_product_related_products_heading', $related_title );
		}else{
			$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'amino' ) );
		}
		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<div class="products-wrapper related-slider slick-slider-block" data-slick-responsive='<?php echo json_encode( $slick_responsive );?>'  
					data-slick-options='<?php echo json_encode( $slick_options ); ?>'>		
			<?php foreach ( $related_products as $product ) : ?>
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