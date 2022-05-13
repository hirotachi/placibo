<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package amino
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<div class="post-wrapper">
			<?php if (has_post_thumbnail()) { ?>	
				<div class="post-thumbnail">

					<?php amino_post_thumbnail(); ?>

				</div>
			<?php } ?>
			<div class="post-content">
				<div class="post-categories-parent">
					<?php
					echo get_the_category_list( esc_html__( ', ', 'amino' ) );
					?>
				</div>	
				
				<?php
					
				the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
				
				?>
				
				<div class="post-excerpt">
					<?php the_excerpt(); ?>
				</div>
				<div class="post-link">
					<?php do_action('archive_post_footer'); ?>
				</div>
			</div><!-- .entry-content -->
		</div>

		
	</article><!-- #post-<?php the_ID(); ?> -->
