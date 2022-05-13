<?php
/**
 * Template Name: Page landing
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
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action('amino_before_page' ); ?>
<?php do_action('amino_after_header'); ?>
<div id="wrapper">
	<div id="main" class="">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
	</div>
</div>
<?php do_action( 'amino_after_page' ); ?>
<?php wp_footer(); ?>
</body>
</html>