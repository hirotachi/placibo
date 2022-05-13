<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
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
	exit; // Exit if accessed directly
}
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>
<div id="_desktop_filters_" class="filter-column">
	<a href="#" class="side-close-icon d-lg-none" title="Close"><i class="icon-rt-close-outline"></i></a>
	<div id="shop-filters" class="widget-area-side">
		<?php dynamic_sidebar( 'shop-filter' ); ?>
	</div>
</div>
<?php dynamic_sidebar( 'column-shop' ); ?>