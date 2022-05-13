<?php
function amino_blog_excerpt_length(){
	return amino_get_option('blog_archive_excerpt_length', '55');
}
add_filter( 'excerpt_length', 'amino_blog_excerpt_length' );
function amino_blog_excerpt_suffix(){
	return amino_get_option('blog_archive_excerpt_suffix', '[...]');
}
add_filter( 'excerpt_more', 'amino_blog_excerpt_suffix' );
if ( ! function_exists( 'amino_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function amino_posted_on() {
		global $post;
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		$archive_year  = get_the_time('Y', $post->ID);
		$archive_month = get_the_time('m', $post->ID);
		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'amino' ),
			'<a href="' . esc_url(get_month_link( $archive_year, $archive_month )) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;
if ( ! function_exists( 'amino_posted_date' ) ) :
	function amino_posted_date() {
		?>
			<div class="post-date">
				<span class="post-date-day">
					<?php echo get_the_time('d') ?>
				</span>
				<span class="post-date-month">
					<?php echo get_the_time('M') ?>
				</span>
			</div>
		<?php
	}
endif;
if ( ! function_exists( 'amino_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function amino_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '%s', 'post author', 'amino' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		echo '<div class="byline"> ' . $byline . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;
if ( ! function_exists( 'amino_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function amino_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->
		<?php else : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>
			<?php
		endif; // End is_singular().
	}
endif;
/**
 * Return related posts args array
 */
if( ! function_exists( 'amino_check_related_posts' ) ) :
	function amino_check_related_posts( $postId = false ) {
		global $post;

		if(!class_exists('Amino_Core')) return;

        if(!$postId) {
            $postId = $post->ID;
        }
        
        $args = array();
       
        $categories = get_the_category($postId);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

            $args = array(
                'category__in' => $category_ids,
                'post__not_in' => array($postId),
                'showposts'=> 5,
            );
        }

        $related_cats_post = new WP_Query( $args );
        if($related_cats_post->have_posts()){
        	return true;
        }else{
        	return false;
        }
	}
endif;
if( ! function_exists( 'amino_get_related_posts' ) ) :
	function amino_get_related_posts( $postId = false, $limit = 5, $column = 3 ) {
		global $post;
		if(!class_exists('Amino_Core')) return;
        if(!$postId) {
            $postId = $post->ID;
        }
        $atts = array(
            'items'              => $column,
            'items_small_desktop'=> 3,
            'items_landscape_tablet'       => 2,
            'items_portrait_tablet'       => 2,
            'items_landscape_mobile'       => 2,
            'items_portrait_mobile'       => 2,
            'items_small_mobile' => 1,
            'autoplay'           => false,
            'slider_speed'       => false,
            'nav'                => true,
        );
        $args = array();
        $categories = get_the_category($postId);
        if ($categories) {
            $category_ids = array();
            foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
            $args = array(
                'category__in' => $category_ids,
                'post__not_in' => array($postId),
                'showposts'=> $limit, // Number of related posts that will be shown.
                'ignore_sticky_posts'   => 1
            );
        }
        return amino_posts_slider( $args, $atts );
	}
endif;
/**
 * Separate archive posts
 */
if ( ! function_exists( 'amino_single_post_footer' ) ) :
	function amino_single_post_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'amino' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'amino' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'amino' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
	add_action('single_post_footer', 'amino_single_post_footer',5);
endif;
if ( ! function_exists( 'amino_archive_post_footer' ) ) :
	function amino_archive_post_footer() {
		echo '<a href="' . esc_url( get_permalink() ) . '">';
		echo esc_html__( 'Read more', 'amino' );
		echo '</a>';
	}
	add_action('archive_post_footer', 'amino_archive_post_footer',5);
endif;
/*
 * Archive post pagination
 */
function amino_posts_navigation(){
	global $wp_query;
	$navigation_type = amino_get_option('posts_navigation','default');
	
	$total          = $wp_query->max_num_pages;
    $current_page = max( 1, get_query_var( 'paged' ) );
    $base          = 999999;
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }
    if($navigation_type == 'default') {
	    ?>
	    <nav class="amino-pagination">
	        <?php
	            echo paginate_links(
	                array(
	                    'base'      => str_replace( $base, '%#%', esc_url( get_pagenum_link( $base ) ) ),
	                    'format'    => '?paged=%#%',
	                    'current'   => $current_page,
	                    'total'     => $total,
	                    'type'      => 'list',
	                    'prev_text' => '&larr;',
						'next_text' => '&rarr;',
						'type'      => 'list',
						'end_size'  => 3,
						'mid_size'  => 3,
	                )
	            );
	        ?>
	    </nav><!-- .page-nav -->
    <?php }else{ ?>
	    	<div class="amino-ajax-loadmore button-ajax-loadmore tc" data-load-more='{"page":"<?php echo esc_attr($total); ?>","container":"archive-posts","layout":"<?php echo esc_attr( $navigation_type ); ?>"}'>
			<?php echo next_posts_link( esc_html__( 'Load More', 'amino' ) ); ?>
		</div>
	<?php
	}  
}