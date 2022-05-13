<?php
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function amino_body_classes( $classes ) {
    // Change Body Layouts.
    if (amino_get_option( 'layout_mode' ))  $classes[] = amino_get_option( 'layout_mode' );
    // Add the selected page template classes if Default Template is selected.
    $page_template    = get_post_meta( get_the_ID(), '_wp_page_template', true );
    if(empty($page_template)) $page_template = 'default';
    $classes[] = 'page-template-' . $page_template;
    if(true == amino_get_option('quick_links_active', false)) $classes[] = 'quick-links-active';
    return $classes;
}
add_filter( 'body_class', 'amino_body_classes' );
/* 
 *  Site preload
 */
function amino_preloader(){
	if ( amino_get_option('preloader_gif', '') ) {
		$preloader_img = amino_get_option('preloader_gif', '');
	}
	else {
		$preloader_img = AMINO_THEME_URI.'/assets/images/rt-preloader.gif';
	}
	if ( amino_get_option('preloader_bg','#ffffff') ) {
		$preloader_background = amino_get_option('preloader_bg','#ffffff');
	}
	else {
		$preloader_background = '#0e1e2f';
	}
	echo '<div id="preloader" style="background-image:url(' . esc_url( $preloader_img ) . '); background-color:'. $preloader_background  . ';"></div>';
}
if ( amino_get_option('preloader_active' , false) ) add_action( 'wp_body_open', 'amino_preloader' );
/* 
 *  Google font
 */
function amino_get_google_fonts_link() {
	$primary_font    = amino_get_option( 'primary_font', array( 'font-family' => 'Poppins', 'variant' => '400' ) );
	$secondary_font  = amino_get_option( 'secondary_font', array( 'font-family' => 'Poppins', 'variant' => '700' ) );
	$third_font  = amino_get_option( 'third_font', array( 'font-family' => 'Great Vibes', 'variant' => '400' ) );
	$fonts     = array( $primary_font, $secondary_font, $third_font );
	$font_list = array();
	$subsets   = array();
	// Insert fonts.
	foreach ( $fonts as $font ) {
		if ( isset( $font['font-family'] ) ) {
			if ( ! isset( $font['variant'] ) ) {
				$font['variant'] = 'default';
			}
			$font_list[ $font['font-family'] ]= $font['font-family'];
		}
	}
	$link_fonts = array();
	foreach ( $font_list as $font ) {
		$link_font = str_replace( ' ', '+', $font );
		$link_font .= ':300,400,500,600,700';
		$link_fonts[] = $link_font;
	}
	$link  = '//fonts.googleapis.com/css?family=';
	$link .= implode( '|', $link_fonts );
	$link .= '&display=swap';
	return $link;
}
function amino_google_fonts() {
	wp_enqueue_style( 'amino-googlefonts', amino_get_google_fonts_link(), array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'amino_google_fonts', 9999 );
/* 
 *  Social sharing : product & post single
 */
add_action('woocommerce_single_product_summary', 'amino_social_share_links', 70);
add_action('single_post_footer', 'amino_social_share_links', 10);
function amino_social_share_links() {
	$id = get_the_ID();
	$permalink = esc_url(get_permalink($id));
	$title = the_title_attribute(array('echo' => 0, 'post' => $id) );
	$image_id = get_post_thumbnail_id($id);
	$image = wp_get_attachment_image_src($image_id,'full');
	$social_sharing = amino_get_option( 'social_sharing', array() );
	if ( !empty($social_sharing) ) {
		echo '<div class="social-sharing">';
		echo '<span>'. esc_html__( 'Share', 'amino' ) .'</span>';
		echo '<ul class="social-icons">';
		foreach ( $social_sharing as $social ) {
			$href = '';
			$parameters = '';
			$social_class = '';
			$social_color = '#4267B2';
			switch ($social) {
				case 'facebook':
					$href = 'http://www.facebook.com/sharer.php?u=' . urlencode( $permalink );
					$social_class ='icon-rt-4-facebook-f';
					$social_color = '#4267B2';
					break;
				case 'twitter':
					$href = 'https://twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode( $permalink );
					$social_class =' icon-rt-logo-twitter';
					$social_color = '#1DA1F2';
					break;
				case 'pinterest':
					$href = 'http://pinterest.com/pin/create/link/?url=' . $permalink . '&amp;media=' . ( ! empty( $image[0] ) ? esc_url($image[0]) : '' );
					$social_class =' icon-rt-logo-pinterest';
					$social_color = '#E60023';
					break;
				case 'vk':
					$href = 'http://vkontakte.ru/share.php?url=' . $permalink;
					$social_class =' icon-rt-logo-vk';
					$social_color = '#5181b8';
					break;
				case 'linkedin':
					$href = 'https://www.linkedin.com/cws/share?url=' . $permalink;
					$social_class =' icon-rt-logo-linkedin';
					$social_color = '#0e76a8';
					break;
				 case 'whatsapp':
					 $href = 'whatsapp://send';
					 $parameters = 'data-text="' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8').'" data-href="' . esc_url( $permalink ) .'" data-action="share/whatsapp/share"';
					 $social_class =' icon-rt-logo-whatsapp';
					 $social_color = '#4FCE5D';
					 break;
				case 'email':
					$href = 'mailto:?subject='. htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&body=' . urlencode( $permalink ) . '&title=' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
					$social_class =' icon-rt-mail-outline';
					$social_color = '#BB001B';
					break;
				 case 'telegram':
					 $href = 'https://t.me/share/url?url='. esc_url( $permalink ) .'&text=.'. htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
					 $social_class =' icon-rt-logo-telegram';
					 $social_color = '#0088CC';
					 break;
				default:
					$social_class ='';
					$social_color = '#4267B2';
					break;
			} ?>
			<li><a <?php echo esc_attr('style=color:'.$social_color.';'); ?> href="<?php echo esc_attr( $href ); ?>" <?php echo esc_attr( $parameters ); ?> target="_blank" class="<?php echo esc_attr( $social_class ); ?> social"></a></li>
		<?php }
		echo '</ul>';
		echo '</div>';
	}
}
/* 
 *  Breadcrumb
 */
function amino_breadcrumb() {
    global $post, $wp_query;
    // Get post category
    $category = get_the_category();
    // Get product category
    $product_cat = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    if ( $product_cat ) {
        $tax_title = $product_cat->name;
    }
    $output = '';
    // Do not display on the homepage
    if ( ! is_front_page() ) {
        if ( ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product' ) && is_product() ) || function_exists( 'is_product_category' ) && is_product_category() || function_exists( 'is_product_tag' ) && is_product_tag() ) {
            do_action('amino_woocommerce_breadcrumb');
        }else{
        	$output .= '<nav class="breadcrumb"><div class="container">';
   			$output .= '<ul itemscope itemtype="http://schema.org/BreadcrumbList">';
   			$output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	        $output .= '<a itemprop="item" href="' . esc_url( get_home_url() ) . '"><span itemprop="name">' . esc_html__( 'Home', 'amino' ) . '</span></a>';
	        $output .= '<meta itemprop="position" content="1">';
	        $output .= '</li>';
        	if ( is_home() ) {
	            $output .= '<li><span>'. esc_html__( 'Blog', 'amino' ) .'</span></li>';
	        } elseif ( is_post_type_archive() ) {
	            $post_type = get_post_type_object( get_post_type() );
	            $output .= '<li><span>'. $post_type->labels->singular_name .'</span></li>';
	        } elseif ( is_tax() ) {
	            $term = $GLOBALS['wp_query']->get_queried_object();
	            $output .= '<li><span>'. $term->name .'</span></li>';
	        } elseif ( is_single() ) {
	            // Single post (Only display the first category)
	            if ( ! empty( $category ) ) {
	            	$output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	                $output .= '<a itemprop="item" href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '"><span itemprop="name">' . $category[0]->cat_name . '</span></a>';
	                $output .= '<meta itemprop="position" content="2">';
	                $output .= '</li>';
	            }
	            $output .= '<li><span>'. get_the_title() .'</span></li>';
	        } elseif ( is_category() ) {
	            $thisCat = get_category( get_query_var( 'cat' ), false );
	            if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' ' );
	            // Category page
	            $output .= '<li><span>'. single_cat_title( '', false ) .'</span></li>';
	        } elseif ( is_page() ) {
	            // Standard page
	            if ( $post->post_parent ) {
	                // If child page, get parents
	                $anc = get_post_ancestors( $post->ID );
	                // Get parents in the right order
	                $anc = array_reverse($anc);
	                // Parent page loop
	                $index = 2; 
	                foreach ( $anc as $ancestor ) {
	                	$parents = '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	                    $parents .= '<a itemprop="item" href="' . esc_url( get_permalink( $ancestor ) ) . '"><span itemprop="name">' . get_the_title( $ancestor ) . '</span></a>';
	                    $parents .= '<meta itemprop="position" content="'. $index .'">';
	                    $parents .= '</li>';
	                    $index ++; 
	                }
	                // Display parent pages
	                $output .= $parents;
	                // Current page
	                $output .= '<li><span>'. get_the_title() .'</span></li>';
	            } else {
	                // Just display current page if not parents
	                $output .= '<li><span>'. get_the_title() .'</span></li>';
	            }
	        } elseif ( is_tag() ) {
	            // Get tag information
	            $term_id  = get_query_var( 'tag_id' );
	            $taxonomy = 'post_tag';
	            $args     = 'include=' . $term_id;
	            $terms    = get_terms( $taxonomy, $args );
	            // Display the tag name
	            $output .= '<li><span>'. $terms[0]->name .'</span></li>';
	        } elseif ( is_day() ) {
	            // Year link
	            $output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	            $output .= '<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '"><span itemprop="name">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'amino' ) . '</span></a>';
	            $output .= '<meta itemprop="position" content="2">';
	            $output .= '</li>';
	            // Month link
	            $output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	            $output .= '<a itemprop="item" href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time( 'm' ) ) ) . '"><span itemprop="name">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'amino' ) . '</span></a';
	            $output .= '<meta itemprop="position" content="3">';
	            $output .= '</li>';
	            // Day display
	            $output .= '<li><span>'. get_the_time('jS') . ' ' . get_the_time('M') . esc_html__( ' Archives', 'amino' ) .'</span></li>';
	        } elseif ( is_month() ) {
	            // Year link
	            $output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
	            $output .= '<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '"><span itemprop="name">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'amino' ) . '</span></a>';
	            $output .= '<meta itemprop="position" content="2">';
	            $output .= '</li>';
	            // Month display
	            $output .= '<li><span>'. get_the_time( 'M' ) . esc_html__( ' Archives', 'amino' ) .'</span></li>';
	        } elseif ( is_year() ) {
	            // Display year archive
	            $output .= '<li><span>'. get_the_time('Y') . esc_html__( 'Archives', 'amino' ) .'</span></li>';
	        } elseif ( is_author() ) {
	            // Get the author information
	            global $author;
	            $userdata = get_userdata( $author );
	            // Display author name
	            $output .='<li><span>'.  esc_html__( 'Author: ', 'amino' ) . $userdata->display_name .'</span></li>';
	        } elseif ( get_query_var('paged') ) {
	            // Paginated archives
	            $output .= '<li><span>'. esc_html__( 'Page', 'amino' ) . ' ' . get_query_var( 'paged' ) .'</span></li>';
	        } elseif ( is_search() ) {
	            // Search results page
	            $output .= '<li><span>'. esc_html__( 'Search results for: ' . get_search_query(), 'amino' ) .'</span></li>';
	        } elseif ( is_404() ) {
	            // 404 page
	            $output .= '<li><span>'. esc_html__( 'Error 404', 'amino' ) .'</span></li>';
	        }
	        $output .= '</ul>';
    		$output .= '</div></nav>';
        }
    } 
    return apply_filters( 'amino_breadcrumb', $output );
}
/*
 *	Social media
 */
function amino_social_list(){
	$social_list = amino_get_option('social_list', '');
	if($social_list) {
	?>
		<div class="social-block">
			<h3 class="social-title"><?php echo esc_html__('Follow Us','amino'); ?></h3>
			<ul class="social-list">
				<?php foreach($social_list as $social) { ?>
					<li>
						<a href="<?php echo esc_url($social['url']); ?>" class="<?php echo esc_attr($social['name']); ?>"><?php echo esc_attr($social['name']); ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php
	}
}
/*
 *	Back to top
 */
add_action('amino_float_right_position', 'amino_back_to_top');
function amino_back_to_top(){
	echo '<div id="back-to-top" class="back-to-top"><a href="#"><i class="icon-rt-arrow-up" aria-hidden="true"></i></a></div>';
}