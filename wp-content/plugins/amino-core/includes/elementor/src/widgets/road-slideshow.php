<?php  
use Elementor\Core\Responsive\Responsive; 
class Road_Slideshow_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_slideshow';
	}

	public function get_title() {
		return __( 'RT Slideshow', 'roadthemes' );
	}
	
	public function get_icon() {
		return 'eicon-slideshow';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}
	
	protected function _register_controls() {
		
		//Tab Content
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			
			$repeater = new \Elementor\Repeater(); 
			$repeater->start_controls_tabs( 'slideshow_content' );
			$repeater->start_controls_tab( 'Content',
				[
					'label' => __( 'Normal', 'elementor' ),
				]
			);
				$repeater->add_control(
					'slideshow_image',
					[
						'label' => __( 'Choose Image', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
					]
				);
				$repeater->add_control (
					'slideshow_title1',
					[
						'label' => __('Title 1','roadthemes'),
						'type' => \Elementor\Controls_Manager::TEXT, 
					] 
				);
				$repeater->add_control (
					'slideshow_title2',
					[
						'label' => __('Title 2','roadthemes'),
						'type' => \Elementor\Controls_Manager::TEXT, 
					] 
				);
				$repeater->add_control (
					'slideshow_subtitle',
					[
						'label' => __('Subtitle','roadthemes'),
						'type' => \Elementor\Controls_Manager::TEXTAREA, 
					] 
				);
				$repeater->add_control(
					'slideshow_link',
					[
						'label' => __( 'Link', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::URL,
						'placeholder' => __( 'https://your-link.com', 'roadthemes' ), 
						'default' => [
							'url' => '', 
						],
					]
				);
				$repeater->add_control(
					'slideshow_button',
					[
						'label'   		=> __('Button text', 'roadthemes'),
						'type'    		=> \Elementor\Controls_Manager::TEXT,
						'label_block' 	=> true,
						'description'   => __('Leave it empty if you dont want to use button link.', 'roadthemes'),
					]
				);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab( 'style',
				[
					'label' => __( 'Style', 'roadthemes' ),
				]
			);
				$repeater->add_control(
					'general',
					[
						'label' => __( 'General', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$repeater->add_control(
					'content_align',
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
						],
						'default' => 'center',
						'toggle' => true,
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content' => 'text-align: {{VALUE}};',
						],
					]
				);
				$repeater->add_responsive_control(
					'hor_position',
					[
						'label' => __( 'Horizontal position', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ '%' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'default' => [
							'unit' => '%',
							'size' => 50,
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content' => 'left: {{SIZE}}{{UNIT}};',
						],
					]
				);	
				$repeater->add_responsive_control(
					'ver_position',
					[
						'label' => __( 'Vertical position', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ '%' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'default' => [
							'unit' => '%',
							'size' => 50,
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content' => 'top: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$repeater->add_control(
					'title1-heading',
					[
						'label' => __( 'Title1', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$repeater->add_control(
					'title1_color',
					[
						'label' 		=> __('Color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .title1' => 'color: {{VALUE}};',
						],
					]
				);

				$repeater->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 			=> 'title1_typo',
						'selector' 		=> '{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .title1',
						'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
					]
				);
				$repeater->add_responsive_control(
					'title1_spacing',
					[
						'label' => __( 'Spacing', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 15,
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .title1' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$repeater->add_control(
					'title2-heading',
					[
						'label' => __( 'Title2', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$repeater->add_control(
					'title2_color',
					[
						'label' 		=> __('Color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .title2' => 'color: {{VALUE}};',
						],
					]
				);

				$repeater->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 			=> 'title2_typo',
						'selector' 		=> '{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .title2',
						'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
					]
				);
				$repeater->add_responsive_control(
					'title2_spacing',
					[
						'label' => __( 'Spacing', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 15,
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .title2' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$repeater->add_control(
					'subtitle-heading',
					[
						'label' => __( 'Subtitle', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$repeater->add_control(
					'subtitle_color',
					[
						'label' 		=> __('Color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .subtitle' => 'color: {{VALUE}};',
						],
					]
				);

				$repeater->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 			=> 'subtitle_typo',
						'selector' 		=> '{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .subtitle',
						'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
					]
				);
				$repeater->add_responsive_control(
					'subtitle_spacing',
					[
						'label' => __( 'Spacing', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px' ],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 15,
						],
						'selectors' => [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$repeater->add_control(
					'button-heading',
					[
						'label' => __( 'Button', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$repeater->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' 			=> 'button_typo',
						'selector' 		=> '{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button',
						'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
					]
				);
				$repeater->add_responsive_control(
					'button_padding',
					[
						'label' 		=> __('Padding', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' 	=> [ 'px', '%' ],
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$repeater->add_responsive_control(
					'button_border_radius',
					[
						'label' 		=> __('Border Radius', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' 	=> [ 'px', '%' ],
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$repeater->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' 			=> 'button_border',
						'selector' 		=> '{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button',
					]
				);
				
				$repeater->add_control(
					'button_color',
					[
						'label' 		=> __('Color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button' => 'color: {{VALUE}};',
						],
					]
				);

				$repeater->add_control(
					'button_background',
					[
						'label' 		=> __('Background color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button' => 'background-color: {{VALUE}};',
						],
					]
				);
						
				$repeater->add_control(
					'button-hover-heading',
					[
						'label' => __( 'Button Hover', 'roadthemes' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$repeater->add_control(
					'button_hover_color',
					[
						'label' 		=> __('Color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button:hover , {{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button:focus' => 'color: {{VALUE}};',
						],
					]
				);
				$repeater->add_control(
					'button_hover_background',
					[
						'label' 		=> __('Background color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button:hover, {{WRAPPER}}  {{CURRENT_ITEM}} .slideshow-content a.slideshow-button:focus' => 'background-color: {{VALUE}};',
						],
					]
				);
				$repeater->add_control(
					'button_hover_border_color',
					[
						'label' 		=> __('Border color', 'roadthemes'),
						'type' 			=> \Elementor\Controls_Manager::COLOR,
						'selectors' 	=> [
							'{{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button:hover, {{WRAPPER}} {{CURRENT_ITEM}} .slideshow-content a.slideshow-button:focus' => 'border-color: {{VALUE}};',
						],
					]
				);
						
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'slideshow_list',
				[
					'label' => __( 'Slideshow', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'slideshow_title1' => __( 'New Item', 'roadthemes' ), 
						], 
					],
					'title_field' => '{{{ slideshow_title1 }}}',
				]
			);
			 

		$this->end_controls_section();
		
		//Tab Setting
		$this->start_controls_section(
			'setting_section',
			[
				'label' => __( 'Slider', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
			]
		);
			$this->add_control(
				'arrows',
				[
					'label' 		=> __('Arrows', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'dots',
				[
					'label' 		=> __('Dots', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' 		=> 'no',
				]
			);
			$this->add_control(
				'autoplay',
				[
					'label' => __( 'Autoplay', 'roadthemes' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',  
				]
			);
			$this->add_control(
				'autoplay_speed',
				[
					'label'     	=> __('AutoPlay Transition Speed (ms)', 'roadthemes'),
					'type'      	=> \Elementor\Controls_Manager::NUMBER,
					'default'  	 	=> 3000,
				]
			);
			$this->add_control(
				'pause_on_hover',
				[
					'label' 		=> __('Pause on Hover', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'        	=> __('Infinite Loop', 'roadthemes'),
					'type'         	=> \Elementor\Controls_Manager::SWITCHER,
					'default'      	=> 'no',
				]
			);
			$this->add_control(
				'transition_speed',
				[
					'label'     	=> __('Transition Speed (ms)', 'roadthemes'),
					'type'      	=> \Elementor\Controls_Manager::NUMBER,
					'default'  	 	=> 500,
				]
			);
		
		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend. 
  
	 */
	 
	protected function render() {

		$settings = $this->get_settings(); 

		// Data settings
        $slick_options = [
			'slidesToShow'   => 1,
			'slidesToScroll' => 1,
			'autoplay'       => ($settings['autoplay'] == 'yes') ? true : false,
			'autoplaySpeed'  => ($settings['autoplay_speed']) ? absint($settings['autoplay_speed']) : 5000,
			'infinite'       => ($settings['infinite'] == 'yes') ? true : false,
			'pauseOnHover'   => ($settings['pause_on_hover'] == 'yes') ? true : false,
			'speed'          => ($settings['transition_speed']) ? absint($settings['transition_speed']) : 500,
			'arrows'         => ($settings['arrows'] == 'yes') ? true : false,
			'dots'           => ($settings['dots'] == 'yes') ? true : false, 
		]; 
		
		$responsive = amino_default_responsive(1);
		
		$slick_responsive = [
			'items_laptop'            => $responsive['xl'],
            'items_landscape_tablet'  => $responsive['lg'],
            'items_portrait_tablet'   => $responsive['md'],
            'items_landscape_mobile'  => $responsive['sm'],
            'items_portrait_mobile'   => $responsive['xs'],
            'items_small_mobile'      => $responsive['xxs'],
		];
	 
		
		$this->add_render_attribute(
			'slideshow', 
			[
				'class' => ['rt-slideshow', 'slick-slider-block'],
				'data-slick-responsive' => wp_json_encode($slick_responsive),
				'data-slick-options' => wp_json_encode($slick_options),
			]
			
		);

		if ( $settings['slideshow_list'] ) {
			echo '<div class="rt-slideshow-wrapper">';
				echo '<div class="preloader-slideshow"></div>';
				echo '<div '.$this->get_render_attribute_string('slideshow').'>';
				foreach (  $settings['slideshow_list'] as $item ) {
					$image = wp_get_attachment_image_src($item['slideshow_image']['id'] , 'full');

					$this->add_render_attribute('class-item', 'class', ['slideshow-item','elementor-repeater-item-' . $item['_id']]);
					echo '<div '.$this->get_render_attribute_string('class-item').'>';
						if(isset($item['slideshow_link']['url']) && $item['slideshow_link']['url'] != '') { 
							echo '<a href="'.$item['slideshow_link']['url'].'">';
						};
							if(isset($item['slideshow_image']) && $item['slideshow_image'] != '') {
								echo '<img src="' . $item['slideshow_image']['url'] . '" width="'. $image[1] .'" height="'. $image[2] .'" alt="'.$item['slideshow_title1'].'" class="skip-lazy"/>';
							}; 
						if(isset($item['slideshow_link']['url']) && $item['slideshow_link']['url'] != '') {
							echo '</a>';
						};
						echo '<div class="container"><div class="inner"><div class="slideshow-content">';
							if(isset($item['slideshow_title1']) && $item['slideshow_title1'] != '') {
								echo '<div class="title1">';
									echo $item['slideshow_title1'];
								echo '</div>';
							};
							if(isset($item['slideshow_title2']) && $item['slideshow_title2'] != '') {
								echo '<div class="title2">';
									echo $item['slideshow_title2'];
								echo '</div>';
							};
							if(isset($item['slideshow_subtitle']) && $item['slideshow_subtitle'] != '') {
								echo '<div class="subtitle">';
									echo $item['slideshow_subtitle'];
								echo '</div>';
							};
							if(isset($item['slideshow_link']['url']) && $item['slideshow_link']['url'] != '' && $item['slideshow_button'] != '') {
								echo '<a class="slideshow-button" href="'.$item['slideshow_link']['url'].'">';
									echo $item['slideshow_button'];
								echo '</a>';
							};
						echo '</div></div></div>'; 
						
					echo '</div>';  
				}
				wp_reset_postdata();
				echo '</div>';
			echo '</div>';
		}  
		

	} 
}