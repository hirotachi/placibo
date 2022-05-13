<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
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
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';
if ( $total <= 1 ) {
	return;
}
$pagination_type = amino_get_option('catalog_product_pagination', 'default');
if(isset($_GET['pag']) && $_GET['pag'] != '') {
   $pagination_type = $_GET['pag'];
}
?>
<?php if($pagination_type == 'default'){ ?>
<nav class="woocommerce-pagination">
	<?php
	echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
	?>
</nav>
<?php } else { ?>
	<div class="amino-ajax-loadmore button-ajax-loadmore tc" data-load-more='{"page":"<?php echo esc_attr($total); ?>","container":"wc-product-pagination_type","layout":"<?php echo esc_attr( $pagination_type ); ?>"}'>
		<?php echo next_posts_link( esc_html__( 'Load More', 'amino' ) ); ?>
	</div>
<?php } ?>