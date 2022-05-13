<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package amino
 */

$blog_archive_items = amino_get_option('blog_archive_items', 1);
$class = 'col-xl-'.(12/$blog_archive_items).' col-12';
$post_content = amino_get_option('blog_archive_excerpt', 'excerpt');
$post_archive_design = amino_get_option('blog_archive_design', 'design-1');

$class .= ' post-'.$post_archive_design;
?>

<?php if($post_archive_design == 'design-1') : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
		
		<div class="post-wrapper">
			<?php if (has_post_thumbnail()) { ?>	
				<div class="post-thumbnail">

					<?php amino_post_thumbnail(); ?>
					<?php amino_posted_date(); ?>
					
				</div>
			<?php } ?>
			
			
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
				
				<?php
					
				the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
				
				?>
				
				<div class="post-excerpt">
					<?php 
					if($post_content == 'excerpt') {
						echo do_shortcode(get_the_excerpt()); 
					}else{
						the_content(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'amino' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							)
						);
					}		

					
					?>
				</div>
				<div class="post-link">
					<?php do_action('archive_post_footer'); ?>
				</div>
			</div><!-- .entry-content -->
		</div>

		
	</article><!-- #post-<?php the_ID(); ?> -->
<?php elseif($post_archive_design == 'design-2') : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
		<div class="post-wrapper">
			<div class="row">
				<?php if (has_post_thumbnail()) { ?>
					<div class="col-4">
						<div class="post-thumbnail">
							<?php amino_post_thumbnail(); ?>
							<?php amino_posted_date(); ?>
						</div>

					</div>
				<?php } ?>
				<?php if (has_post_thumbnail()) { ?>
					<div class="col-8">
				<?php }else{ ?>
					<div class="col-12">
				<?php } ?>
					<div class="post-content">
						<div class="inner">
							<?php if ( 'post' === get_post_type() ) : ?>
								<div class="entry-meta">
								
								<div class="post-categories-parent">
									<?php
										echo get_the_category_list( esc_html__( ', ', 'amino' ) );
									?>
								</div>
								</div><!-- .entry-meta -->
							<?php endif; ?>		
							
							<?php
								
							the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );

							?>	
							
							<div class="post-excerpt">
								<?php 
								if($post_content == 'excerpt') {
									echo do_shortcode(get_the_excerpt()); 
								}else{
									the_content(
										sprintf(
											wp_kses(
												/* translators: %s: Name of current post. Only visible to screen readers */
												__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'amino' ),
												array(
													'span' => array(
														'class' => array(),
													),
												)
											),
											get_the_title()
										)
									);
								}		

								
								?>
							</div>
							<div class="post-link">
								<?php do_action('archive_post_footer'); ?>
							</div>
						</div>
						
						
					</div>
					
					<!-- .entry-content -->
				</div>
			</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php else : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
		<div class="post-wrapper">
			<?php if (has_post_thumbnail()) { ?>	
				<div class="post-thumbnail">

					<?php amino_post_thumbnail(); ?>
					<?php amino_posted_date(); ?>
				</div>
			<?php } ?>
			<div class="post-content">
				<div class="inner">
					<?php if ( 'post' === get_post_type() ) : ?>
						<div class="entry-meta">
						
						<div class="post-categories-parent">
							<?php
								echo get_the_category_list( esc_html__( ', ', 'amino' ) );
							?>
						</div>
						</div><!-- .entry-meta -->
					<?php endif; ?>	
					
					<?php
						the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
					?>	
					
					<div class="post-link">
						<?php do_action('archive_post_footer'); ?>
					</div>
				</div>
			</div><!-- .entry-content -->
		</div>
		
	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>