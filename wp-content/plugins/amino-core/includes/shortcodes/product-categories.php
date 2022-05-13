<?php
if ( ! function_exists( 'amino_product_categories' ) ) {
	function amino_product_categories( $atts ) {
		if ( isset( $atts['number'] ) ) {
			$atts['limit'] = $atts['number'];
		}
		$atts = shortcode_atts(
			array(
				'limit'      => '-1',
				'orderby'    => 'name',
				'order'      => 'ASC',
				'columns'    => '4',
				'hide_empty' => 1,
				'parent'     => '',
				'ids'        => '',
			),
			$atts,
			'product_categories'
		);
		$ids        = array_filter( array_map( 'trim', explode( ',', $atts['ids'] ) ) );
		$hide_empty = ( true === $atts['hide_empty'] || 'true' === $atts['hide_empty'] || 1 === $atts['hide_empty'] || '1' === $atts['hide_empty'] ) ? 1 : 0;
		// Get terms and workaround WP bug with parents/pad counts.
		$args = array(
			'orderby'    => $atts['orderby'],
			'order'      => $atts['order'],
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $atts['parent'],
		);
		$product_categories = apply_filters(
			'woocommerce_product_categories',
			get_terms( 'product_cat', $args )
		);
		if ( '' !== $atts['parent'] ) {
			$product_categories = wp_list_filter(
				$product_categories,
				array(
					'parent' => $atts['parent'],
				)
			);
		}
		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( 0 === $category->count ) {
					unset( $product_categories[ $key ] );
				}
			}
		}
		$atts['limit'] = '-1' === $atts['limit'] ? null : intval( $atts['limit'] );
		if ( $atts['limit'] ) {
			$product_categories = array_slice( $product_categories, 0, $atts['limit'] );
		}
		$columns = absint( $atts['columns'] );
		wc_set_loop_prop( 'columns', $columns );
		wc_set_loop_prop( 'is_shortcode', true );
		ob_start();
		if ( $product_categories ) {
			foreach ( $product_categories as $category ) {
				wc_get_template(
					'content-product_cat.php',
					array(
						'category' => $category,
					)
				);
			}
		}
		return ob_get_clean() ;
	}
	add_shortcode( 'rt_product_categories_shortcode', 'amino_product_categories' );
}
if( ! function_exists( 'amino_default_product_categories_shortcode_atts' ) ) {
	function amino_default_product_categories_shortcode_atts() {
		return array(
			//Source
            'product_type'         => 'all',
            'selected_products'    => '',
            'category'             => '',
            'orderby'              => 'title',
            'order'                => 'ASC',
            'limit'                => '8',
            //Layout
			'product_display'      => 'grid',
			'columns'              => '4',
			//Slider config
            'items'                => '4',
            'responsive'           => 'default',
            'items_small_desktop'=> 3,
            'items_landscape_tablet'       => 2,
            'items_portrait_tablet'       => 2,
            'items_landscape_mobile'       => 2,
            'items_portrait_mobile'       => 2,
            'items_small_mobile' => 1,
            'enable_slider'        => 'no',
            'autoplay'             => 'yes',
            'autoplay_speed'       => '3000',
            'autoplay_speed'       => '1000',
            'nav'                  => '',
            'pag'                  => '',
            'loop'                 => '',
	    );
	}
}