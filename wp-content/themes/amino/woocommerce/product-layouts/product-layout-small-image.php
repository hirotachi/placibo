<?php
	global $product; 
	if ( !isset( $product ) ) {
		return;
	}
	$image_class = '';
	$product_label = get_post_meta($product->get_id() , 'product_label');
	$show_second_image = amino_get_option('catalog_product_hover', true);
	$show_quickview = amino_get_option('catalog_product_quickview', true);
	$show_category = amino_get_option('catalog_product_category', true);
	$show_rating = amino_get_option('catalog_product_rating', true);
?>
<div class="product-inner product-list-small">
	<div class="product-image">
		<?php if($product_label) { ?>
			<span class="product-label"><?php echo esc_attr($product_label[0]); ?></span>
		<?php } ?>
		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
			<?php
				if ( has_post_thumbnail( $product->get_id() ) ) {   
					echo  get_the_post_thumbnail( $product->get_id(), 'amino_small_default', array( 'class' => $image_class ) );
				} else {
					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="'.esc_attr_e( 'Placeholder', 'amino' ).'" />', wc_placeholder_img_src() ), $product->get_id() );
				}
				if($show_second_image){
					echo amino_product_thumbnail_hover($product , 'amino_small_default');
				}
			?>
		</a>
	</div>
	<div class="product-content">
		<?php if($show_category): ?>
		<div class="product-category">
			<?php echo get_top_category_name(); ?>
		</div>
		<?php endif; ?>
		<div class="product-title">
			<h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
		</div>
		<?php if($show_rating): ?>
			<div class="product-rating">
				<?php do_action( 'woocommerce_after_shop_loop_item_rating' ); ?>
			</div>
		<?php endif; ?>
		<div class="product-price">
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</div>
	</div>
</div>