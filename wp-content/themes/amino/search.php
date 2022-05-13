<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package amino
 */

get_header();
$disable_the_title =  false;
$disable_breadcrumb =  false;
$archive_post_layout = amino_get_option('blog_archive_layout', 'right-sidebar');
$class = 'main-content ';
if($archive_post_layout == 'right-sidebar' && is_active_sidebar('column-blog')){
	$class .= 'col-lg-9 col-12 ';
}elseif($archive_post_layout == 'left-sidebar' && is_active_sidebar('column-blog')){
	$class .= 'col-lg-9 col-12  order-lg-last';
}else{
	$class .= 'col-lg-12 col-12 col-md-12';
}
$page_title_design = amino_get_option('page_title_design' , '2');
$page_title_align = amino_get_option('page_title_align' , 'left');
$page_title_size = amino_get_option('page_title_size' , 'large');
$page_title_color = amino_get_option('page_title_color' , 'dark');

if(!$disable_the_title && $page_title_design == '1') : ?>
	<div class="page-title-section text-<?php echo esc_attr($page_title_align); ?> page-title-<?php echo esc_attr($page_title_size); ?> text-<?php echo esc_attr($page_title_color); ?>">
		<div class="container">
		<?php if ( ! is_front_page() ) :
			?>
			<header>
				<!-- <h1 class="page-title screen-reader-text"> -->
				<h1 class="page-title">
					<?php 
						if (is_archive()) {
							single_term_title();
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
			<main id="primary" class="site-main <?php echo esc_attr($class); ?>">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h1 class="page-title">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'amino' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
					</header><!-- .page-header -->

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/posts/content', 'search' );

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/posts/content', 'none' );

				endif;
				?>

			</main><!-- #main -->
			<?php
			if($archive_post_layout !== 'no-sidebar'){
				get_sidebar();
			}
			?>
		</div>
	</div>
</div>
<?php
get_footer();
