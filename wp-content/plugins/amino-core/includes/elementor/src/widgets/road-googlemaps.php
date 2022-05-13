<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;

class Road_Googlemaps_Widget extends Widget_Base {

	public function get_name() {
		return 'rt_googlemaps';
	}

	public function get_title() {
		return __( 'RT Google Maps', 'roadthemes' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	public function get_keywords() {
		return [ 'google', 'maps' ];
	}

	public function get_script_depends() {
		return [ 'rt-google-map', 'rt-google-map-api'];
	} 
	
	protected function _register_controls() {
		$this->start_controls_section(
			'section_general',
			[
				'label' => __( 'General', 'roadthemes' ),
			]
		);
			$this->add_control(
				'latitude',
				[
					'label' 		=> __('Latitude', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::TEXT,
					'default' 		=> '',
					'label_block' 	=> true,
				]
			);
			$this->add_control(
				'longitude',
				[
					'label' 		=> __('Longitude', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::TEXT,
					'default' 		=> '',
					'label_block' 	=> true,
				]
			);
			$this->add_control(
				'zoom',
				[
					'label' => __( 'Map zoom', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 12,
					],
				]
			);
			$this->add_responsive_control(
				'height',
				[
					'label' => __( 'Map height', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 300,
					],
					'selectors' => [
						'{{WRAPPER}} .rt-gmap' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'map_style',
				[
					'label' => __( 'Map style', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'standard'  => __( 'Standard', 'roadthemes' ),
						'silver' => __( 'Silver', 'roadthemes' ),
						'retro' => __( 'Retro', 'roadthemes' ),
						'rark' => __( 'Dark', 'roadthemes' ),
						'night' => __( 'Night', 'roadthemes' ),
						'aubergine' => __( 'Aubergine', 'roadthemes' ),
						'custom' => __( 'Custom', 'roadthemes' ),
					],
					'frontend_available' => true,
					'default' => 'standard'
				]
			);
			$this->add_control(
				'custom_style',
				[
					'label' => __( 'Custom style', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'rows' => 10,
					'default' => __( 'Add style from <a href="https://mapstyle.withgoogle.com/" target="_blank">Google Map Styling Wizard</a> or <a href="https://snazzymaps.com/explore" target="_blank">Snazzy Maps</a>. Copy and paste the style in the textarea.', 'roadthemes' ),
					'condition'    	=> [
						'map_style' => 'custom',
					],
				]
			);
			$this->add_control(
				'marker_options',
				[
					'label' => __( 'Markers', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'marker_action',
				[
					'label' => __( 'Marker action to show content', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'click'  => __( 'Click', 'roadthemes' ),
						'hover' => __( 'Hover', 'roadthemes' )
					],
					'frontend_available' => true,
					'default' => 'click'
				]
			);
			$this->add_control(
				'marker_icon',
				[
					'label' => __( 'Marker icon', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'default'  => __( 'Default', 'roadthemes' ),
						'custom' => __( 'Custom', 'roadthemes' )
					],
					'frontend_available' => true,
					'default' => 'default'
				]
			);
			$this->add_control(
				'marker_custom',
				[
					'label' => __( 'Choose Image', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'condition'    	=> [
						'marker_icon' => 'custom',
					],
				]
			);
		
		$this->end_controls_section();
		$this->start_controls_section(
			'section_marker',
			[
				'label' => __( 'Map markers', 'roadthemes' ),
			]
		);
			$repeater = new \Elementor\Repeater();
			$repeater->add_control(
				'marker_title', [
					'label' => __( 'Title', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Title' , 'roadthemes' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'latitude', [
					'label' => __( 'Latitude', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'longitude', [
					'label' => __( 'Longitude', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => '',
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'marker_content', [
					'label' => __( 'Content', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => __( 'Content' , 'roadthemes' ),
					'show_label' => false,
				]
			);
			$this->add_control(
				'add_marker',
				[
					'label' => __( 'Add a marker', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'title_field' => '{{{ marker_title }}}',
				]
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$markers = json_encode($settings['add_marker']);
		$id_int = $this->get_id();
		?>
		<div id="gmap-<?php echo $id_int; ?>" class="rt-gmap" data-lat="<?php echo $settings['latitude']; ?>" data-lng="<?php echo $settings['longitude']; ?>" data-zoom="<?php echo $settings['zoom']['size']; ?>" data-map-style="<?php echo $settings['map_style']; ?>" data-add-marker='<?php echo $markers; ?>' data-marker-action="<?php echo $settings['marker_action']; ?>" data-marker-icon="<?php echo $settings['marker_icon']; ?>" data-marker-custom="<?php echo $settings['marker_custom']['url']; ?>"></div>
		<?php
	}

}
