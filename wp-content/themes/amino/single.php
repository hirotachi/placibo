<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package amino
 */
get_header();
$single_post_layout = amino_get_option('blog_single_layout', 'right-sidebar');

if($single_post_layout == 'right-sidebar' && is_active_sidebar('column-blog')){
	$class = 'col-lg-9 col-12 ';
}elseif($single_post_layout == 'left-sidebar' && is_active_sidebar('column-blog')){
	$class = 'col-lg-9 col-12  order-lg-last';
}else{
	$class = 'col-lg-12 col-12 col-md-12';
}
$single_post_design = amino_get_option('blog_single_design', '1');
$title_background = amino_get_option('blog_single_bgtitle', '');
$custom_page_title_bground = get_post_meta( $post->ID, 'page_custom_title_image', true );
if ($custom_page_title_bground ) {
	$title_background = $custom_page_title_bground;
}
$title_class = '';
$title_align = amino_get_option('blog_single_title_align', 'left');

$title_color = amino_get_option('blog_single_title', 'dark');
$title_class .= 'text-'.$title_align;
$title_class .= ' text-'.$title_color;
$related_active = amino_get_option( 'blog_single_related' , '1');
$related_limit = amino_get_option('blog_single_related_limit', '4');
$related_column = amino_get_option('blog_single_related_column', '3');
?>
<?php echo amino_breadcrumb(); ?>
<?php if($single_post_design == '2') : ?>
	<header class="entry-header title-background <?php echo esc_attr($title_class); ?>" 
		<?php if($title_background): ?> style= "background-image: url('<?php echo esc_url($title_background); ?>');background-size: cover; " <?php endif; ?>>
		<div class="container">
			
			<?php if ( 'post' === get_post_type() ) : ?>
				
				<div class="post-categories-parent">
					<?php
					echo get_the_category_list( esc_html__( ', ', 'amino' ) );
					?>
				</div>
			<?php endif; ?>
			<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					the_post();
					amino_posted_on();
					amino_posted_by();
					/*
	                 * Since we called the_post() above, we need to
	                 * rewind the loop back to the beginning that way
	                 * we can run the loop properly, in full.
	                 */
	                rewind_posts();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->
<?php endif; ?>
<div id="content">
	<div class="container">
		<div class="row">
			<div class="main-content <?php echo esc_attr($class); ?>">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/posts/content', 'single' );
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous', 'amino' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next', 'amino' ) . '</span> <span class="nav-title">%title</span>',
						)
					);
					if ( $related_active == '1' &&  class_exists('Amino_Core') && amino_check_related_posts($post->ID)) : ?>
					<div class="related_posts nav-style-2">
						<h2 class="title-block"><?php echo esc_html__( 'Related posts', 'amino' ) ?></h2>
					    <?php echo amino_get_related_posts($post->ID, $related_limit , $related_column); ?>
					</div>
					<?php endif;
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
				?>
			</div>
			<?php
			if($single_post_layout != 'no-sidebar' && is_active_sidebar('column-blog')){
				get_sidebar();
			}
			?>
		</div>
	</div>
</div>
<?php 
get_footer();