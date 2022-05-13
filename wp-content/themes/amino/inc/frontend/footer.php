<?php
function amino_before_footer(){
	$footer_before = amino_get_option('footer_before_content', '');
	if($footer_before) {
		?>
		<div class="footer-before">
			<div class="container">
				<?php echo do_shortcode($footer_before); ?>
			</div>
		</div>
		<?php
	}
}
add_action('amino_footer', 'amino_before_footer', 5);

function amino_main_footer(){

	if(!is_active_sidebar('sidebar-footer-column-1') && !is_active_sidebar('sidebar-footer-column-2') && !is_active_sidebar('sidebar-footer-column-3') && !is_active_sidebar('sidebar-footer-column-4')) return;
	$footer_layout = amino_get_option('footer_layout','layout-5');
	$classes = array();
	$footer_text = amino_get_option('footer_text', 'light');
	$classes[] = 'text-'.$footer_text;
	$classes[] = $footer_layout;
	$footer_config = amino_get_footer_config($footer_layout);
	?>
	<div class="footer-main <?php echo esc_attr(implode(' ', $classes)); ?>">
		
		<div class="footer-main-inner">
			<div class="container">
				<div class="row">
					<?php foreach( $footer_config['cols'] as $key => $column ) : 
						$index = $key + 1;
						?>
						<div class="footer-column footer-column-<?php echo esc_attr( $index ); ?> <?php echo esc_attr( $column ); ?>">
							<?php dynamic_sidebar( 'footer-column-'. $index); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php	
}
add_action('amino_footer', 'amino_main_footer', 10);
function amino_get_footer_config($layout){
	$configs = apply_filters( 'amino_footer_configs_array', array(
			'layout-1' => array(
				'cols' => array(
					'col-12'
				),
			),
			'layout-2' => array(
				'cols' => array(
					'col-12 col-md-6',
					'col-12 col-md-6',
				),
			),
			'layout-3' => array(
				'cols' => array(
					'col-12 col-md-4',
					'col-12 col-md-4',
					'col-12 col-md-4',
				),
			),
			'layout-4' => array(
				'cols' => array(
					'col-12 col-md-6 col-lg-3',
					'col-12 col-md-6 col-lg-3',
					'col-12 col-md-6 col-lg-3',
					'col-12 col-md-6 col-lg-3',
				),
			),
			'layout-5' => array(
				'cols' => array(
					'col-12 col-md-12  col-lg-4',
					'col-12 col-md-4  col-lg-3 offset-lg-1',
					'col-12 col-md-4  col-lg-2',
					'col-12 col-md-4  col-lg-2',
				),
			),
			'layout-6' => array(
				'cols' => array(
					'col-12 col-md-6  col-lg-4',
					'col-12 col-md-6  col-lg-2',
					'col-12 col-md-6  col-lg-2',
					'col-12 col-md-6  col-lg-4',
				),
			),
			'layout-7' => array(
				'cols' => array(
					'col-12 col-md-12  col-lg-4 has-logo',
					'col-12 col-md-6  col-lg-2',
					'col-12 col-md-6  col-lg-2',
					'col-12 col-md-6  col-lg-2',
					'col-12 col-md-6  col-lg-2',
				),
			)
		) );
	return $configs[$layout];
}
function amino_bottom_footer(){
	$footer_bottom_active = amino_get_option('footer_bottom_active', true );
	if( !$footer_bottom_active ) return;
	$footer_bottom_left = amino_get_option('footer_bottom_left', 'copyright');
	$footer_bottom_center = amino_get_option('footer_bottom_center' , 'none');
	$footer_bottom_right = amino_get_option('footer_bottom_right', 'none');
	$footer_text_color = amino_get_option('footer_bottom_text','light');
	?>
	<div class="footer-bottom text-<?php echo esc_attr($footer_text_color); ?>">
		<div class="container">
			<div class="row">
				<?php if ($footer_bottom_left !== 'none') { ?>
					<div class="col-12 col-sm-6 col-lg-3 footer-bottom-left">
						<?php echo amino_footer_bottom_content($footer_bottom_left); ?>
					</div>
				<?php } ?>
				<?php if ($footer_bottom_center !== 'none') { ?>
					<div class="col-12 col-sm-12 col-lg-6 footer-bottom-center text-right">
						<?php echo amino_footer_bottom_content($footer_bottom_center); ?>
					</div>
				<?php } ?>
				<?php if ($footer_bottom_right !== 'none') { ?>
					<div class="col-12 col-sm-6 col-lg-3 footer-bottom-right text-right">
						<?php echo amino_footer_bottom_content($footer_bottom_right); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php	
}
add_action('amino_footer', 'amino_bottom_footer', 15);
function amino_footer_bottom_content($param){
	$copyright = amino_get_option('footer_bottom_copyright',esc_html__('Copyright by Plazathemes. All Rights Reserved','amino'));
	$payment = amino_get_option('footer_bottom_payment', '');
	if($param == 'copyright') {
		?>
			<p class='copyright'><?php echo esc_attr($copyright); ?></p>
		<?php
	}else if ($param == 'payment') {
		?>
			<img src="<?php echo esc_url($payment); ?>" alt="<?php echo esc_attr_e('payments','amino');?>" />
		<?php
	}else if ($param == 'footer-menu') {
		if ( has_nav_menu( 'footer' ) ) {
			wp_nav_menu(
				array(
					'container'  => '',
					'items_wrap' => '%3$s',
					'theme_location' => 'footer',
				)
			);
		}
	}else if ($param == 'social') {
		amino_social_list();
	}else {
		return;
	}
}