<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package amino
 */

get_header();

$archive_post_layout = amino_get_option('blog_archive_layout', 'right-sidebar');

$class = 'main-content ';
if($archive_post_layout == 'right-sidebar' && is_active_sidebar('column-blog')){
	$class .= 'col-lg-9 col-12 ';
}elseif($archive_post_layout == 'left-sidebar' && is_active_sidebar('column-blog')){
	$class .= 'col-lg-9 col-12  order-lg-last';
}else{
	$class .= 'col-lg-12 col-12 col-md-12';
}
if(is_archive()) {
	$disable_the_title =  get_post_meta( $post->ID, 'page_custom_title', false );
	$disable_breadcrumb =  get_post_meta( $post->ID, 'page_custom_breadcrumb', false );
}else{
	$pageID = get_option('page_for_posts');
	$disable_the_title =  get_post_meta( $pageID, 'page_custom_title', false );
	$disable_breadcrumb =  get_post_meta( $pageID, 'page_custom_breadcrumb', false );
}

$page_title_design = amino_get_option('page_title_design' , '2');
$page_title_align = amino_get_option('page_title_align' , 'left');
$page_title_size = amino_get_option('page_title_size' , 'large');
$page_title_color = amino_get_option('page_title_color' , 'dark');

if(!$disable_the_title && $page_title_design == '1') : ?>
	<div class="page-title-section  text-<?php echo esc_attr($page_title_align); ?> page-title-<?php echo esc_attr($page_title_size); ?> text-<?php echo esc_attr($page_title_color); ?>">
		<div class="container">
		<?php if ( ! is_front_page() ) :
			?>
			<header>
				<!-- <h1 class="page-title screen-reader-text"> -->
				<h1 class="page-title">
					<?php 
						if (is_archive()) {
							if(is_category()){
								single_term_title();
							}else{
								the_archive_title();
							}
						} else {
							single_post_title();
						}
					?>
				</h1>
			</header>
			<?php
			if( !$disable_breadcrumb ) echo amino_breadcrumb();
		endif; ?>
		</div>
	</div>
<?php endif;
if($page_title_design == '2' && !$disable_breadcrumb) : ?>
	
		<?php echo amino_breadcrumb(); ?>
	
<?php endif;
?>
<div id="content">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr($class); ?>">	
				<?php if(!$disable_the_title && $page_title_design == '2') { ?>
					<?php if ( ! is_front_page() ) : ?>
					<header>
						<!-- <h1 class="page-title screen-reader-text"> -->
						<h1 class="page-title ">
							<?php 
								if (is_archive()) {
									if(is_category()){
										single_term_title();
									}else{
										the_archive_title();
									}
								} else {
									single_post_title();
								}
							?>
						</h1>
					</header>
				<?php endif; } ?>
				<div class="row archive-posts">
					<?php
					if ( have_posts() ) :
						
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/posts/content', get_post_type() );

						endwhile;


					else :

						get_template_part( 'template-parts/posts/content', 'none' );

					endif;
					?>
				</div>
				<?php amino_posts_navigation(); ?>
			</div>
			<?php
				if($archive_post_layout != 'no-sidebar' && is_active_sidebar('column-blog')){
					get_sidebar();
				}
			?>
		</div>
	</div>
</div>
<?php
get_footer();
