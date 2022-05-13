<?php 
use Elementor\Widget_Base;

class Road_Nav_Widget extends Widget_Base {
	public function get_name() {
		return 'rt_nav';
	}

	public function get_title() {
		return __('RT Vertical menu', 'roadthemes');
	}

	public function get_icon() { 
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_nav',
			[
				'label' 		=> __('General', 'roadthemes'),
			]
		);
			$this->add_control(
				'important_note',
				[
					'label' => __( 'RT Verical menu', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => __( 'This widget show menu which has "Vertical Menu" location.<br> You can configure Vertical menu in Appearence > Menus', 'roadthemes' ),
				]
		);
		$this->end_controls_section();
	}

	/**
	 * Get list menu
	 */

	protected function get_menu_options(){
		$array = array();

		$menus = wp_get_nav_menus();
		foreach ( $menus as $menu ) {
			$array[$menu->slug] = $menu->name;
		} 
		return $array;
	}
	protected function render() {
		amino_vertical_menu();

	}
}