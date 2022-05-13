<?php
/*
 * Prepare product image
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');
add_action( 'amino_after_single_product_summary', 'woocommerce_output_product_data_tabs');
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
/*
 * Product image
 */
function amino_get_gallery_image_html( $attachment_id, $main_image = false , $class = '' ) {
	$flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
	$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
	$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
	$image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
	$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
	$thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
	$full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
	$alt_text          = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
	$image             = wp_get_attachment_image(
		$attachment_id,
		$image_size,
		false,
		apply_filters(
			'woocommerce_gallery_image_html_attachment_image_params',
			array(
				'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
				'data-src'                => esc_url( $full_src[0] ),
				'data-large_image'        => esc_url( $full_src[0] ),
				'data-large_image_width'  => esc_attr( $full_src[1] ),
				'data-large_image_height' => esc_attr( $full_src[2] ),
				'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
			),
			$attachment_id,
			$image_size,
			$main_image
		)
	);
	return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" data-thumb-alt="' . esc_attr( $alt_text ) . '" class="product-image-item '.$class.'" data-index= "0"><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
}
/*
 * Size guide
 */
add_action( 'woocommerce_single_product_summary' ,'amino_size_guide',  25);
if( ! function_exists( 'amino_size_guide' ) ) {
	function amino_size_guide() {
		$title   = amino_get_option( 'single_product_sizechart_title','' );
		$content = amino_get_option( 'single_product_sizechart_content','' );
		if(!$title || !$content) return;
		?>
		<div class="amino-size-guide">
			<a class="amino-size-guide__title" href="#amino-size-guide">
				<?php echo esc_attr($title); ?>
			</a>
			<div id="amino-size-guide" class="amino-size-guide__content mfp-hide">
				<div class='inner'>
					<?php echo do_shortcode($content); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
/*
 * Additional tab for all products
 */
add_filter( 'woocommerce_product_tabs', 'amino_additional_product_tabs' );
if( ! function_exists( 'amino_additional_product_tabs' ) ) {
	function amino_additional_product_tabs( $tabs ) {
		$additional_tab_title = amino_get_option('single_product_tab_title', '');;
		if ( $additional_tab_title ) {
			$tabs['amino_additional_tab'] = array(
				'title' 	=> $additional_tab_title,
				'priority' 	=> 50,
				'callback' 	=> 'amino_additional_product_tab_content'
			);
		}
		return $tabs;
	}
}
if( ! function_exists( 'amino_additional_product_tab_content' ) ) {
	function amino_additional_product_tab_content() {
		// The new tab content
		$tab_content = amino_get_option( 'single_product_tab_content','' );
		echo do_shortcode( $tab_content );
	}
}
/*
 * Additional tab for each product
 */
add_filter( 'woocommerce_product_tabs', 'amino_extra_tab_product' );
if( ! function_exists( 'amino_extra_tab_product' ) ) {
	function amino_extra_tab_product($tabs) {
		global $product;
		$extra_tab_title = get_post_meta($product->get_id(), 'product_tab_title');
		if ( $extra_tab_title ) {
			$tabs['amino_extra_tab'] = array(
				'title' 	=> $extra_tab_title[0],
				'priority' 	=> 60,
				'callback' 	=> 'amino_extra_tab_product_content'
			);
		}
		return $tabs;
	}
}
if( ! function_exists( 'amino_extra_tab_product_content' ) ) {
	function amino_extra_tab_product_content( ) {
		// The new tab content
		global $product;
		$extra_tab_content = get_post_meta( $product->get_id(), 'product_tab_content' );
		echo do_shortcode($extra_tab_content[0]);
	}
}
/*
 * Product video
 */
function amino_product_video_url(){
	global $product;
	$video_url = get_post_meta($product->get_id(), 'product_video');
	?>
	<?php if($video_url) { ?>
		<a href="<?php echo esc_url($video_url[0]); ?>" class="product-page-video"><span><?php esc_html_e('Watch video','amino'); ?></span></a>
	<?php } ?>
	<?php
}
add_action('amino_button_on_image', 'amino_product_video_url');
function amino_product_video($id){
	$product_video_upload = get_post_meta( $id, 'product_video_upload', [] );
	$product_video_autoplay = get_post_meta( $id, 'product_video_autoplay', true );
	$autoplay = '';
	if($product_video_autoplay) {
		$autoplay = 'autoplay';
	}
	if($product_video_upload ) {
		$output = '<video controls '. $autoplay .' muted >';
		  $output .= '<source src="'.$product_video_upload[0].'" type="video/mp4">';
		$output .= '</video>';
	} 
	return $output; 
}
/*
 * Product single countdown
 */
add_action('woocommerce_single_product_summary', 'amino_product_single_countdown', 10);
function amino_product_single_countdown(){
	global $product;
	if ( $product->is_type('variable') ) {
		$flag = false;
		$variations = $product->get_available_variations();
		for ($j = 0; $j < count($variations); $j++) {
		  $variation = wc_get_product($variations[$j]['variation_id']);
		  if ($variation->is_on_sale()) {
		    $sale_date_start = get_post_meta( $variation->get_id(), '_sale_price_dates_from', true );
			$sale_date_end = get_post_meta( $variation->get_id(), '_sale_price_dates_to', true );
			$curent_date = strtotime( date( 'Y-m-d H:i:s' ) );
			if ( $sale_date_end >= $curent_date && $curent_date >= $sale_date_start ) {
				$flag = true;
				break;
			}
		  }
		}
		if($flag) echo '<div class="amino-product-single-countdown"></div>';
	}
	if( $product->is_type('simple') ) {
		$sale_date_start = get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
		$sale_date_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		$curent_date = strtotime( date( 'Y-m-d H:i:s' ) );
		if ( $sale_date_end < $curent_date || $curent_date < $sale_date_start ) return;
		echo '<div class="amino-product-countdown block-countdown" data-end-date="' . esc_attr( date( 'Y-m-d H:i:s', $sale_date_end ) ) . '"></div>';
	}
}