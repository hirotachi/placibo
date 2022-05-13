<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     50.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : ?>
<div class="product-page-accordion">
	<div class="accordion-wrapper" id="product-accordion">
		<?php foreach ( $tabs as $key => $tab ) : ?>
		<div class="accordion-item">
			<a class="accordion-title collapsed" href="#accordion-<?php echo esc_attr($key); ?>" data-toggle="collapse" data-target="#accordion-<?php echo esc_attr($key); ?>">
				<button class="toggle"><i class="icon-rt-arrow-down"></i></button>
				<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
			</a>
			<div class="accordion-inner collapse" id="accordion-<?php echo esc_attr($key); ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>