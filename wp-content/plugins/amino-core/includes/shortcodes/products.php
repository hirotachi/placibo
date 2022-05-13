<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'amino_products' ) ) {	
	function amino_products( $atts, $content = null ) {
		global $product, $woocommerce_loop;
		$slider_atts = array(
			//Source
            'product_type'         => 'all',
            'selected_products'    => '',
            'category'             => '',
            'orderby'              => 'title',
            'order'                => 'ASC',
            'limit'                => 8,
            //Layout
			'product_display'      => 'grid',
			'columns'              => 4,
			//Slider config
            'items'                => 4,
            'items_laptop'          => 3,
            'items_landscape_tablet'=> 2,
            'items_portrait_tablet' => 2,
            'items_landscape_mobile'=> 2,
            'items_portrait_mobile' => 2,
            'items_small_mobile'    => 1,
            'enable_slider'        => true,
            'autoplay'             => true,
            'autoplay_speed'       => 3000,
            'transition_speed'     => 1000,
            'nav'                  => true,
            'pag'                  => false,
            'loop'                 => false,
            'rows'                 => 1,
			//others
			'countdown' 	 	   => true,
			'action'               => '',
	    );
		$parsed_atts = shortcode_atts( $slider_atts, $atts );
		extract( $parsed_atts );
        $slider_id = rand(10, 99999);
		$classes = array('block-product');
		if ( isset($product_view) ) {
			$classes[] = 'product-'.$product_view.'-view';
		}
		if($action == 'ajax') {
			if($enable_slider == 'yes') $enable_slider = true; else $enable_slider = false;
		}
		if($enable_slider) {
			$woocommerce_loop['is_slider'] = true;
			$classes[] = 'slick-slider-block';
			$classes[] = 'column-desktop-'. $items .' column-tablet-'. $items_landscape_tablet . ' column-mobile-' . $items_small_mobile;
			$product_classes[] = 'product-carousel';
			//carousel data
			if($action == 'ajax') {
				$slick_options = [
					'slidesToShow' => (int)$items ,
					'autoplay'     => ('yes' == $autoplay) ? true : false,
					'infinite'     => ('yes' == $loop) ? true : false,
					'arrows'       => ('yes' == $nav) ? true : false,
					'dots'         => ('yes' == $pag) ? true : false,
					'rows'         => (int)$rows,
					'autoplay_speed' => (int)$autoplay_speed,
					'speed'=> (int)$transition_speed,
				];
			}else{
				$slick_options = [
					'slidesToShow' => (int)$items ,
					'autoplay'     => $autoplay,
					'infinite'     => $loop,
					'arrows'       => $nav,
					'dots'         => $pag,
					'rows'         => (int)$rows,
					'autoplay_speed' => (int)$autoplay_speed,
					'speed'=> (int)$transition_speed,
				];
			}
			$slick_responsive = [
				'items_laptop'           => (int)$items_laptop,
				'items_landscape_tablet' => (int)$items_landscape_tablet,
				'items_portrait_tablet'  => (int)$items_portrait_tablet,
				'items_landscape_mobile' => (int)$items_landscape_mobile,
				'items_portrait_mobile'  => (int)$items_portrait_mobile,
				'items_small_mobile'     => (int)$items_small_mobile,
			];
		}else{
			$woocommerce_loop['is_slider'] = false;
			$woocommerce_loop['column_desktop'] = (int)$columns;
			$woocommerce_loop['column_tablet'] =  3;
			$woocommerce_loop['column_phone'] =  2;
			$woocommerce_loop['column_small_phone'] = 1;
			$product_classes[] = 'product-grid';		
		}
		$woocommerce_loop['product_display'] = $product_display;
        // Global Query
        $args = array(
			'post_type'            => 'product',
            'post_status' 		   => 'publish',
			'ignore_sticky_posts'  => 1,
			'orderby'              => $orderby,
			'order'                => $order,
			'posts_per_page'       => $limit,
			'meta_query'           => WC()->query->get_meta_query(),
			'tax_query'            => WC()->query->get_tax_query()
		);
        //recent products
        if( isset($product_type) && $product_type == 'new_products' ) {
			$args['orderby'] = 'date';
			$args['order']   = 'desc';
        }
        //featured products
		if( isset($product_type) && $product_type == 'featured_products' ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
		}
		//best selling
		if( isset($product_type) && $product_type == 'best_selling_products' ) {
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'total_sales';
		}
		//sale products
		if( isset($product_type) && $product_type == 'onsale_products' ) {
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		}
        //product select
        if( $product_type == 'select_products' && $parsed_atts['selected_products']) {
            $args['post__in'] = $parsed_atts['selected_products'];          
        }
        //product by categories
        if( $product_type == 'category_products' && $category) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
            );
        }
        $products = new WP_Query( $args );
		if(isset($woocommerce_loop['product_display']) && $woocommerce_loop['product_display'] == 'list') {
			$product_layout = 'small-image';
		}else{
			$product_layout = amino_get_option('catalog_product_productstyle','1');
		}
		
		$class_wrapper_products = 'wrapper-layout-'.$product_layout;
        ob_start();
        	?>
        	<div class="product-widget amino-widget <?php echo esc_attr($class_wrapper_products); ?>">
	        	<?php if($enable_slider) { ?>
	        		<div class="products-wrapper row <?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-slick-responsive='<?php echo json_encode( $slick_responsive );?>'  
					data-slick-options='<?php echo json_encode( $slick_options ); ?>'>
	        	<?php } else { ?>
	        		<div class="products-wrapper row <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	        	<?php } ?>
						<?php
						if ( $products->have_posts() ) :
							while ( $products->have_posts() ) :
								$products->the_post();
								$id = get_the_ID();
								$product = wc_get_product( $id );
								?>
									<?php
									wc_get_template_part( 'content','product' ); 	
									?>
							<?php
							endwhile;
						endif;
						wp_reset_postdata();
						?>
					</div>
		 	</div>
		<?php
		$output = ob_get_contents();
		ob_get_clean();
	    return $output;
	}
	add_shortcode( 'rt_products_shortcode', 'amino_products' );
}