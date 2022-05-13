<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package amino
 */
get_header();
$disable_the_title =  get_post_meta( get_queried_object_id(), 'page_custom_title', false );
$disable_breadcrumb =  get_post_meta( get_queried_object_id(), 'page_custom_breadcrumb', false );
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
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>
			<?php
			if( !$disable_breadcrumb ) echo amino_breadcrumb();
		endif; ?>
		</div>
	</div>
<?php endif;
if( $page_title_design == '2' && !$disable_breadcrumb ): ?>
	<?php echo amino_breadcrumb(); ?>
<?php endif;
?>
<div id="content" class="<?php if(is_page('home-page-02')) echo 'home-page-02'; ?>">
	<div class="container">
		<?php
		if (is_page('home-page-02')){
		?>
		<div class="row">
		<aside class="customfor-homepage2 widget-area widget-area-side col d-none d-xl-block">
			<div class="inner">
				
					<div class="show-vmenu-wrapper">
						<?php amino_vertical_menu(); ?>
					</div>
					<?php
						amino_social_list();
					?>
				
			</div>
		</aside>
		<div class="main-content col">
		<?php
		}
		?>
			<?php
				if ( is_woocommerce_activated() && (is_cart() || is_checkout()) ){
			?>
				<div class="process-box">
					<?php
						amino_checkout_process();
					?>
				</div>
			<?php
				} 
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/posts/content', 'page' );
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; // End of the loop.
			?>
		<?php
		if (is_page('home-page-02')){
		?>
		</div>
		</div>
		<?php
		}
		?>
	</div>
</div>
<?php
get_footer();