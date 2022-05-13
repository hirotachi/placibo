<?php
	$header_main_text = amino_get_option('header_main_text', 'dark');
	extract( $args );
	$wishlist_class = 'has-wishlist';
	if(! class_exists( 'YITH_WCWL' )) { 
		$wishlist_class ='no-wishlist';
	}
?>
<div class="desktop-header header4 d-none d-lg-block">
	<?php amino_promo_block(); ?>
	<?php amino_header_topbar(); ?>
	<div class="main-header text-<?php echo esc_attr($header_main_text); ?> <?php echo amino_header_sticky(); ?>">
		<div class="container">
			<div class="main-header-content">
				<div class="row">
					<div class="col col-2 col-logo">
						<div id="_desktop_logo_">
							<?php amino_site_logo(); ?>
						</div>
					</div>
					<div class="col col-8 col-hoz text-center top-menu menu-background">
						<div class="main-menu">
							<div id="_desktop_menu_">
								<?php amino_main_menu(); ?>
							</div>
						</div>
					</div>
					<div class="col col-2 col-header-icon text-right">
						<?php amino_header_search(); ?>
						<?php amino_header_account(); ?>
						<div id="_desktop_wishlist_" class="<?php echo esc_attr($wishlist_class); ?>">
							<?php amino_wishlist(); ?>
						</div>
						<?php if(is_woocommerce_activated()) : ?>
							<?php amino_header_cart(); ?>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>