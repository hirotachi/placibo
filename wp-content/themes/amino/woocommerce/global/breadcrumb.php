<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
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
 * @see         woocommerce_breadcrumb()
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! empty( $breadcrumb ) ) {
	echo '<div class="breadcrumb">';
	echo '<div class="container">';
	echo '<ul itemscope itemtype="http://schema.org/BreadcrumbList">';
	$index = 1;
	foreach ( $breadcrumb as $key => $crumb ) {
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
			echo '<a itemprop="item" href="' . esc_url( $crumb[1] ) . '"><span itemprop="name">' . esc_html( $crumb[0] ) . '</span></a>';
			echo '<meta itemprop="position" content="'. $index .'">';
			echo '</li>';
		} else {
			echo '<li><span>'. esc_html( $crumb[0] ). '</span></li>';
		}
		$index ++ ;
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';
}