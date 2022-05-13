<?php
	global $product; 
	if ( !isset( $product ) ) {
		return;
	}
	$image_class = '';
	if(get_post_meta($product->get_id(),'rtproduct_hover_image', 'default') == 'yes'){
		$show_second_image = true;
	}else if(get_post_meta($product->get_id(),'rtproduct_hover_image', 'default') == 'no'){
		$show_second_image = false;
	}else{
		$show_second_image = amino_get_option('catalog_product_hover', true);
	}
	$show_quickview = amino_get_option('catalog_product_quickview', true);
	$show_category = amino_get_option('catalog_product_category', true);
	$show_rating = amino_get_option('catalog_product_rating', true);
	$show_countdown = amino_get_option('catalog_product_countdown', true);
?>
<div class="product-inner product-grid">
	<div class="product-image">
		<div class="product-labels">
			<?php do_action('amino_product_labels'); ?>
		</div>
		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
			<?php
				if ( has_post_thumbnail( $product->get_id() ) ) {   
					echo  get_the_post_thumbnail( $product->get_id(), 'shop_catalog', array( 'class' => $image_class ) );
				} else {
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="'.esc_attr_e( 'Placeholder', 'amino' ).'" />', wc_placeholder_img_src() ), $product->get_id() );
				}
				if($show_second_image){
					echo amino_product_thumbnail_hover($product);
				}
			?>
		</a>
		<div class="action-links">
			<ul>
				<?php if(!AMINO_CATALOG_MODE): ?>
				<li class="product-cart">
					<?php woocommerce_template_loop_add_to_cart(); ?>
				</li>
				<?php endif; ?>
				<?php if ( class_exists( 'YITH_WCWL' ) ) : ?>
					<li class="add-to-wishlist"> 
						<?php echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]')); ?>
					</li>
				<?php endif; ?>
				<?php if( class_exists( 'YITH_Woocompare' ) ) : ?>
					<?php amino_product_compare(); ?>
				<?php endif; ?>
				<?php if($show_quickview): ?>
				<li class="button-quickview">
					<?php echo amino_product_quickview(); ?>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<?php if($show_countdown) {
			amino_product_onsale_countdown();
		} ?>
	</div>
	<div class="product-content">
		
		<div class="product-title">
			<h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
		</div>
		<?php if($show_category): ?>
			<div class="product-category">
				<?php echo get_top_category_name(); ?>
			</div>
		<?php endif; ?>
		<?php if($show_rating): ?>
			<div class="product-rating">
				<?php do_action( 'woocommerce_after_shop_loop_item_rating' ); ?>
			</div>
		<?php endif; ?>
		<?php if(AMINO_SHOW_PRICE): ?>
			<div class="product-price">
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>