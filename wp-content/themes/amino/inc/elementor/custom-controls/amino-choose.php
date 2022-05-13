<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Amino_choose extends \Elementor\Base_Data_Control {
	public function get_type() {
		return 'amino-choose';
	}
	public function get_default_settings() {
		return [
			'options' => [],
			'toggle' => false,
			'show_label' => false
		];
	}
	public function enqueue() {
		// Styles
		wp_register_style( 'amino-choose', get_template_directory_uri() . '/assets/css/admin/elementor/amino-choose.css' );
		wp_enqueue_style( 'amino-choose' );
		// Scripts
		wp_register_script( 'amino-choose', get_template_directory_uri() . '/assets/js/admin/elementor/amino-choose.js' );
		wp_enqueue_script( 'amino-choose' );
	}
	public function content_template() {
		$control_uid = $this->get_control_uid('{{value}}');
		?>
		<div class="rt-control-field">
			<label class="rt-control-title">{{{ data.label }}}</label>
			<div class="rt-control-input-wrapper">
				<div class="rt-choices">
					<# _.each( data.options, function( options, value ) { #>
					<input id="<?php echo esc_attr($control_uid); ?>" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ value }}">
					<label class="rt-choices-label rt-control-unit-1 {{ options.class }}" for="<?php echo esc_attr($control_uid); ?>" title="{{ options.title }}">
						<img src="{{ options.image }}" alt="{{ options.title }}"/>
						<# if( data.show_label ) { #>
						<span class="rt-screen-only">{{{ options.title }}}</span>
						<# } #>
					</label>
					<# } ); #>
				</div>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}