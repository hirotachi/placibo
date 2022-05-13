<?php
	$header_main_text = amino_get_option('header_main_text', 'dark');
	extract( $args );
	$wishlist_class = 'has-wishlist';
	if(! class_exists( 'YITH_WCWL' )) { 
		$wishlist_class ='no-wishlist';
	}
?>
<div class="desktop-header header2 has-btn-extra d-none d-lg-block">	
	<?php amino_promo_block(); ?>
	<?php amino_header_topbar(); ?>
	<div class="main-header text-<?php echo esc_attr($header_main_text); ?> <?php echo amino_header_sticky(); ?>">
		<div class="container">
			<div class="main-header-content">
				<div class="row">
					<div class="col col-xl-2 col-lg-3 col-logo">
						
						<div class="menu-dropdown-style">
							<a class="menu-dropdown-btn"><i class="icon-rt-bars-solid"></i></a>
							<div id="menu-dropdown-side" class="menu-dropdown-side">
								<a class="side-close-icon"><i class="icon-rt-close-outline"></i></a>
								<div class="inner">
									
									<div class="rt-tabs-wrapper">
										<ul class="tabs rt-tabs menu-tabs-title" role="tablist">
										  <li class="active">
											<a href="#hozmenu_dropdown"><?php echo esc_html__('Menu', 'amino'); ?></a>
										  </li>
										  <?php if($vertical_menu): ?>
										  <li class="">
											<a href="#vmenu_dropdown"><?php echo esc_html__('Categories', 'amino'); ?></a>
										  </li>
										  <?php endif; ?>
										</ul>
										<div class="rt-tab-panel" id="hozmenu_dropdown">
											<div class="menu-dropdown"><?php amino_main_menu(); ?></div>
										</div>
										<?php if($vertical_menu): ?>
										<div class="rt-tab-panel" id="vmenu_dropdown">
											<div class="menu-dropdown"><?php amino_vertical_menu(); ?></div>
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div id="_desktop_logo_">
							<?php amino_site_logo(); ?>
						</div>
					</div>
					<div class="col col-xl-6 col-lg-5 col-menu text-left top-menu menu-background">
						
						<div class="col col-search ">
							<?php amino_header_search(); ?>
						</div>
							
					</div>
					<div class="col col-4 col-header-icon text-right">
						<?php amino_currency_switcher(); ?>
						<?php amino_language_switcher(); ?>
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
		<div class="extra-menu">
			<div class="inner">
				<div class="main-menu">
					<div id="_desktop_menu_">
						<?php amino_main_menu(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	window.addEventListener("load", () => {
    const menuDropdownSide = document.querySelector("#menu-dropdown-side")
    menuDropdownSide.querySelector("#_desktop_vmenu_").setAttribute("id", "_vmenu_dropdown_")
    menuDropdownSide.querySelector(".vmenu-title").remove()
    
})
</script>