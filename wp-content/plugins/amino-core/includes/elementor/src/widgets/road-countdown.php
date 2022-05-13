<?php  

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;

class Road_Countdown_Widget extends Widget_Base { 
	public function get_name() {
		return 'rt_countdown';
	}

	public function get_title() {
		return __('RT Countdown', 'roadthemes');
	}

	public function get_icon() { 
		return 'eicon-counter-circle';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	protected function _register_controls() { 
		
		//Elements
		$this->start_controls_section(
            'section_elements',
            [
                'label' => __('Content', 'roadthemes')
            ]
		);

		$this->add_control(
			'end_date',
			[
				'label' => __( 'Select End Date', 'plugin-domain' ),
				'type' => Controls_Manager::DATE_TIME,
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_style',
			[
				'label' 		=> esc_html__('General', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
			'countdown_display',
				[
					'label' => __( 'Display', 'roadthemes' ),
					'type' => 'amino-choose',
					'options' => [
						'block' => [
							'title' => __( 'Block', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/countdown1.png',
							'class' => 'width-50'
						],
						'inline' => [
							'title' => __( 'Inline', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/countdown2.png',
							'class' => 'width-50'
						],
					],
					'default' => 'block',
					'show_label' => false,
				]
			);
			$this->add_control(
				'countdown_background',
				[
					'label' 		=> __('Element background', 'roadthemes'),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .block-countdown .countdown-inner > span' => 'background: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'hr1',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 			=> 'countdown_border',
					'selector' 		=> '{{WRAPPER}} .block-countdown .countdown-inner > span',
				]
			);
			$this->add_control(
				'hr2',
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);
			$this->add_responsive_control(
				'countdown_border_radius',
				[
					'label' 		=> __('Border Radius', 'roadthemes'),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .block-countdown .countdown-inner > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'countdown_padding',
				[
					'label' 		=> __('Padding', 'roadthemes'),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .block-countdown .countdown-inner > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'countdown_spacing',
				[
					'label' => __( 'Spacing', 'roadthemes' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .block-countdown .countdown-inner > span' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_date_style',
			[
				'label' 		=> esc_html__('Date style', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'countdown_date_color',
				[
					'label' 		=> __('Color', 'roadthemes'),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .block-countdown .countdown-inner > span > strong' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'countdown_date_typo',
					'selector' 		=> '{{WRAPPER}} .block-countdown .countdown-inner > span > strong',
					'scheme' 		=> Typography::TYPOGRAPHY_1,
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' 		=> esc_html__('Text style', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'countdown_text_color',
				[
					'label' 		=> __('Color', 'roadthemes'),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .block-countdown .countdown-inner > span > span' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'countdown_text_typo',
					'selector' 		=> '{{WRAPPER}} .block-countdown .countdown-inner > span > span',
					'scheme' 		=> Typography::TYPOGRAPHY_1,
				]
			);
		$this->end_controls_section();
	
	}

	protected function render() {
		$settings = $this->get_settings();
 		?>
 		<div class="rt-elementor-countdown block-countdown d-count-<?php echo $settings['countdown_display']; ?>" data-end-date="<?php echo $settings['end_date']; ?>"></div>
 		<?php
	}

}