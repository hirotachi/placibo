<?php
if (!function_exists('amino_posts_slider')){
    function amino_posts_slider($args = false, $atts){
        $slider_atts = array(
            'items' => 3,
            'items_small_desktop' => 3,
            'items_landscape_tablet' => 2,
            'items_portrait_tablet' => 2,
            'items_landscape_mobile' => 2,
            'items_portrait_mobile' => 2,
            'items_small_mobile' => 1,
            'autoplay' => false,
            'autoplay_speed' => 3000,
            'speed' => 1000,
            'nav' => true,
            'pag' => false,
            'loop' => false,
        );
        $parsed_atts = shortcode_atts($slider_atts, $atts);
        extract($parsed_atts);
        $slick_options = ['slidesToShow' => (int)$items, 'autoplay' => $autoplay, 'infinite' => $loop, 'arrows' => $nav, 'dots' => $pag, 'autoplaySpeed' => $autoplay_speed, 'speed' => $speed];
        $slick_responsive = ['items_small_desktop' => $items_small_desktop, 'items_landscape_tablet' => $items_landscape_tablet, 'items_portrait_tablet' => $items_portrait_tablet, 'items_landscape_mobile' => $items_landscape_mobile, 'items_portrait_mobile' => $items_portrait_mobile, 'items_small_mobile' => $items_small_mobile, ];
        $posts = new WP_Query($args);
        ob_start();
		?>
		<div class="posts-slider slick-slider-block"  data-slick-responsive='<?php echo json_encode($slick_responsive); ?>' data-slick-options='<?php echo json_encode($slick_options); ?>'>
			<?php
			if ($posts->have_posts()):
				while ($posts->have_posts()):
					$posts->the_post();
			?>
			<article id="post-<?php the_ID(); ?>">
				<div class="post-wrapper">  
					<div class="post-thumbnail">
						<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php amino_post_thumbnail(); ?></a>
						<?php amino_posted_date(); ?>
					</div>
					<div class="post-content">
						<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
							
							<div class="post-categories-parent">
								<?php
									echo get_the_category_list( esc_html__( ', ', 'amino' ) );
								?>
							</div>
							</div><!-- .entry-meta -->
						<?php endif; ?>	
						<?php the_title('<h5 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h5>'); ?>
						<div class="post-excerpt">
							<?php the_excerpt(); ?>
						</div>
						<div class="post-link">
							<?php do_action('archive_post_footer'); ?>
						</div>
					</div>
				</div>   
			</article>
			<?php
				endwhile;
			endif;
			wp_reset_postdata();
			?>            
		</div>
		<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
    }
    add_shortcode('amino_posts_slider_shortcode', 'amino_posts_slider');
}