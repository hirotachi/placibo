<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
defined( 'ABSPATH' ) || exit;
$specific_product_layout = get_post_meta(get_the_ID(), 'product_custom_layout', 'default');
$product_layout = amino_get_option('single_product_layout', 'simple');
if($specific_product_layout && $specific_product_layout != 'default') {
	if($specific_product_layout == 'fulltop') {
		wc_get_template_part( 'single-product/product-image-top');
		return;
	}
	if($specific_product_layout == 'fullleft') {
		wc_get_template_part( 'single-product/product-image-wide');
		return;
	}
	if($specific_product_layout == 'vertical') {
		wc_get_template_part( 'single-product/product-image-vertical');
		return;
	}
	if($specific_product_layout == 'grid') {
		wc_get_template_part( 'single-product/product-image-grid');
		return;
	}
}else{
	if($product_layout == 'fulltop') {
		wc_get_template_part( 'single-product/product-image-top');
		return;
	}
	if($product_layout == 'fullleft') {
		wc_get_template_part( 'single-product/product-image-wide');
		return;
	}
	if($product_layout == 'vertical') {
		wc_get_template_part( 'single-product/product-image-vertical');
		return;
	}
	if($product_layout == 'grid') {
		wc_get_template_part( 'single-product/product-image-grid');
		return;
	}
}
global $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
		'layout-thumnail-bottom'
	)
);
$image_class = '';
$zoom_active = amino_get_option('zoom_active', true);
if($zoom_active) $image_class .= 'image-zoom';
$slick_options = '{
	"slidesToShow": 1, 
	"slidesToScroll": 1,
	"arrows": true,
 	"fade": false,
 	"infinite": false,
	"useTransform": true,
 	"speed": 400
}';
$thumbnails_slick_options = '{
	"slidesToShow": 6, 
	"slidesToScroll": 1,
	"arrows": true,
 	"infinite": false,
 	"focusOnSelect": false,
	"responsive": 
		[{"breakpoint":767,"settings":{"slidesToShow": 4}}]
}';
$has_video = false;
$product_video_upload = get_post_meta( get_the_ID(), 'product_video_upload', [] );
$product_video_position = get_post_meta( get_the_ID(), 'product_video_position' , 'last' );
if($product_video_upload) {
	$has_video = true;
	$image_class .= ' has-video';
}
$image_class .= ' column-desktop-1 column-tablet-1 column-mobile-1';
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" <?php echo esc_attr('style=opacity:0;transition-property:opacity;transition-delay:0.25s;transition-timing-function:ease-in-out;'); ?> >
	<figure class="product-gallery__wrapper">
		<div class="image-wrapper">
			<div class="product-labels">
				<?php do_action('amino_product_labels'); ?>
			</div>
			<div class="product-images slider-layout has-thumbnails <?php echo esc_attr($image_class); ?>" data-video-position="<?php echo esc_attr($product_video_position); ?>" data-slick = '<?php echo esc_attr($slick_options); ?>'>
				<?php
				$html_video = '';
				if($has_video && $product_video_position == 'first') {
					$html_video .= '<div class="product-video-item">';
					$html_video .= amino_product_video(get_the_ID());
					$html_video .= '</div>';
				}
				if ( $product->get_image_id() ) {
					$html = amino_get_gallery_image_html( $post_thumbnail_id, true );
				} else {
					$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
					$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'amino' ) );
					$html .= '</div>';
				}
				if($has_video && $product_video_position == 'second') {
					$html .= '<div class="product-video-item">';
					$html .= amino_product_video(get_the_ID());
					$html .= '</div>';
				}
				$attachment_ids = $product->get_gallery_image_ids();
				if ( $attachment_ids ) {
					$index = 1;
					foreach ( $attachment_ids as $attachment_id ) {
						$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
						
						$attributes = array(
							'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
							'data-src'                => $full_size_image[0],
							'data-large_image'        => $full_size_image[0],
							'data-large_image_width'  => $full_size_image[1],
							'data-large_image_height' => $full_size_image[2],
						);
						$html .= '<div class="product-image-item" data-index="'.$index.'">';
							$html .= '<a href="' . esc_url( $full_size_image[0] ).'" data-rel="prettyPhoto[product-gallery]">';
								$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
							$html .= '</a>';
						$html .= '</div>';
						$index ++;
					}
				}
				if($has_video && $product_video_position == 'last') {
					$html .= '<div class="product-video-item">';
					$html .= amino_product_video(get_the_ID());
					$html .= '</div>';
				}
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html_video . $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
				?>
			</div>
			<div class="product-image-buttons">
				<?php do_action('amino_button_on_image'); ?>
			</div>
		</div>
		<div class="product-thumbnails column-desktop-6 column-tablet-6 column-mobile-4" data-slick = '<?php echo esc_attr($thumbnails_slick_options); ?>'>
			<?php
			do_action( 'woocommerce_product_thumbnails' );
			?>
		</div>
	</figure>
</div>