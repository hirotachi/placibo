<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_thumbnail_id = $product->get_image_id();

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
    "slidesToShow": 4, 
    "slidesToScroll": 1,
    "arrows": true,
    "infinite": false,
    "focusOnSelect": false
}';

$has_video = false;
$product_video_upload = get_post_meta( get_the_ID(), 'product_video_upload', [] );
$product_video_position = get_post_meta( get_the_ID(), 'product_video_position' , 'last' );
if($product_video_upload) {
    $has_video = true;
    $image_class = ' has-video';
}

?>
<div id="product-<?php the_ID(); ?>" class="woocommerce product product-quickview pr mfp-with-anim">
    <div class="row  wc-single-product">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-left">
            <figure class="product-gallery__wrapper">
                <div class="product-images has-thumbnails  <?php echo esc_attr($image_class); ?>" data-slick = '<?php echo esc_attr($slick_options); ?>'>
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
                        foreach ( $attachment_ids as $attachment_id ) {
                            $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                            

                            $attributes = array(
                                'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html .= '<div class="product-image-item">';
                                $html .= '<a href="' . esc_url( $full_size_image[0] ).'" data-rel="prettyPhoto[product-gallery]">';
                                    $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                                $html .= '</a>';
                            $html .= '</div>';

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
                <div class="product-thumbnails" data-slick = '<?php echo esc_attr($thumbnails_slick_options); ?>'>
                    <?php
                    do_action( 'woocommerce_product_thumbnails' );
                    ?>
                </div>
            </figure>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-right">
            <div class="summary entry-summary">

                <?php
                    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
                    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                    do_action( 'woocommerce_single_product_summary' );
                ?>

            </div><!-- .summary -->
        </div>
    </div>
</div>
<!-- .product-quickview -->
