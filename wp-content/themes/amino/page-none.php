<?php
/**
 * Template Name: Page no header no footer
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage Amino
 * @since Amino 1.0
 */
?>
<!DOCTYPE html>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action('amino_before_page' ); ?>
<?php do_action('amino_after_header'); ?>
<div id="wrapper">
	<div id="main" class="">
		<div class="container">	
			<?php
				if ( is_woocommerce_activated() && (is_cart() || is_checkout()) ){
					?>
					<div class="process-box">
					<?php
					the_custom_logo();
					amino_checkout_process();
					?>
					</div>
					<?php
				} 
			?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<?php do_action( 'amino_after_page' ); ?>
<?php wp_footer(); ?>
</body>
</html>