<?php
class Road_Title_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_title';
	}
	public function get_title() {
		return __( 'RT Title', 'roadthemes' );
	}
	public function get_icon() {
		return 'eicon-archive-title';
	}
	public function get_categories() {
		return [ 'roadthemes-category' ];
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Title', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXT, 
					'placeholder' => __( 'Road Title', 'roadthemes' ),
					'default' => __('Road Title', 'roadthemes'),
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'title_html_tag',
				[
					'label' => __( 'Title HTML Tag', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
						'div' => 'div',
					],
					'default' => 'h3',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'description',
				[
					'label' => __( 'Description', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA, 
					'placeholder' => __( 'Enter description here', 'roadthemes' ),
					'default' => __('Enter description here', 'roadthemes'),
				]
			);
			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'roadthemes' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'roadthemes' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'roadthemes' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'roadthemes' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'style',
				[
					'label' => __( 'Style', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'style1' => __( 'Default', 'roadthemes' ),
						'style2' => __( 'Style 2', 'roadthemes' ),
						'style3' => __( 'Style 3', 'roadthemes' ),
					],
					'default' => 'style1',
				]
			);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		); 
			$this->add_control(
				'title_color',
				[ 
					'label' => __('Title Color', 'roadthemes'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .title' => 'color: {{VALUE}};',
					],
					'scheme' => [
						'type' => \Elementor\Core\Schemes\Color::get_type(),
						'value' => \Elementor\Core\Schemes\Color::COLOR_1,
					],  
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .title',
				]
			);
			$this->add_control(
				'description_color',
				[ 
					'label' => __('Description Color', 'roadthemes'),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .description' => 'color: {{VALUE}};',
					],
					'scheme' => [
						'type' => \Elementor\Core\Schemes\Color::get_type(),
						'value' => \Elementor\Core\Schemes\Color::COLOR_1,
					],  
				]
			);
		$this->end_controls_section();
	}
	/**
	 * Render widget output on the frontend. 
	 */
	protected function render() {
		$settings = $this->get_settings_for_display(); 
		$this->add_render_attribute( 'title', 'class', 'title' );
		$this->add_render_attribute( 'description', 'class', 'description' );
		$this->add_inline_editing_attributes( 'title', 'basic' ); 
		$this->add_inline_editing_attributes( 'description', 'advanced' );
		$title = $settings['title'];
		$style = $settings['style'];
		$description = $settings['description'];
		if($description) {
			$title_html = sprintf( '<div class="title-container %6$s"><p %4$s>%5$s</p><%1$s %2$s><span>%3$s</span></%1$s></div>', $settings['title_html_tag'], $this->get_render_attribute_string( 'title' ), $title, $this->get_render_attribute_string( 'description' ), $description, $style ); 
		}else{
			$title_html = sprintf( '<div class="title-container %4$s"><%1$s %2$s><span>%3$s</span></%1$s></div>', $settings['title_html_tag'], $this->get_render_attribute_string( 'title' ), $title, $style ); 
		}
		echo wp_kses_post($title_html);
	} 
}