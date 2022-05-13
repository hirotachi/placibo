<?php 
// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
class Road_Banner_Widget extends Widget_Base {
	public function get_name() {
		return 'rt_banner';
	}
	public function get_title() {
		return __('RT Banner', 'roadthemes');
	}
	public function get_icon() { 
		return 'eicon-image-rollover';
	}
	public function get_categories() {
		return [ 'roadthemes-category' ];
	}
	protected function _register_controls() {
		$this->start_controls_section(
			'section_banner',
			[
				'label' 		=> __('Banner', 'roadthemes'),
			]
		);
		$this->add_control(
			'image',
			[
				'label'   		=> __('Image', 'roadthemes'),
				'type'    		=> Controls_Manager::MEDIA,
				'default' 		=> [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' 			=> 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'label' 		=> __('Image Size', 'roadthemes'),
				'default' 		=> 'large',
			]
		);
		$this->add_control(
			'title',
			[
				'label'   		=> __('Title', 'roadthemes'),
				'type'    		=> Controls_Manager::TEXT,
				'label_block' 	=> true,
			]
		);
		$this->add_control(
			'title2',
			[
				'label'   		=> __('Title 2', 'roadthemes'),
				'type'    		=> Controls_Manager::TEXT,
				'label_block' 	=> true,
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label'   		=> __('Subtitle', 'roadthemes'),
				'type'    		=> Controls_Manager::TEXTAREA,
			]
		);
		$this->add_control(
			'link',
			[
				'label'   		=> __('Link', 'roadthemes'),
				'type'    		=> Controls_Manager::URL,
				'placeholder' 	=> __('https://your-link.com', 'roadthemes'),
			]
		);
		$this->add_control(
			'button_link',
			[
				'label'   		=> __('Button text', 'roadthemes'),
				'type'    		=> Controls_Manager::TEXT,
				'label_block' 	=> true,
				'description'   => __('Leave it empty if you dont want to use button link.', 'roadthemes'),
			]
		);
		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'roadthemes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'layout1' => __( 'Default', 'roadthemes' ),
					'layout2' => __( 'Layout 2', 'roadthemes' ),
					'layout3' => __( 'Layout 3', 'roadthemes' ),
					'layout4' => __( 'Layout 4', 'roadthemes' ),
					'layout5' => __( 'Layout 5', 'roadthemes' ),
					'layout6' => __( 'Layout 6', 'roadthemes' ),
					'layout7' => __( 'Layout 7', 'roadthemes' ),
					'layout8' => __( 'Layout 8', 'roadthemes' ),
				],
				'default' => 'layout1',
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
					'default' => '',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .banner-content' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'hor_position',
				[
					'label' => __( 'Horizontal position', 'roadthemes' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .banner-content' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);	
			$this->add_responsive_control(
				'ver_position',
				[
					'label' => __( 'Vertical position', 'roadthemes' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .banner-content' => 'top: {{SIZE}}{{UNIT}};',
					],
				]
			);
        $this->end_controls_section();
		$this->start_controls_section(
			'section_title_style',
			[
				'label' 		=> esc_html__('Title 1', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'title_color',
				[
					'label' 		=> __('Color', 'roadthemes'),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .home-banner .banner-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'title_typo',
					'selector' 		=> '{{WRAPPER}} .home-banner .banner-title',
					'scheme' 		=> Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_responsive_control(
				'title_spacing',
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
						'{{WRAPPER}} .banner-content .banner-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_title2_style',
			[
				'label' 		=> esc_html__('Title 2', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'title2_color',
				[
					'label' 		=> __('Color', 'roadthemes'),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .home-banner .banner-title2' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'title2_typo',
					'selector' 		=> '{{WRAPPER}} .home-banner .banner-title2',
					'scheme' 		=> Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_responsive_control(
				'title2_spacing',
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
						'{{WRAPPER}} .banner-content .banner-title2' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
        $this->end_controls_section();
		$this->start_controls_section(
			'section_subtitle_style',
			[
				'label' 		=> esc_html__('Subtitle', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'subtitle_color',
				[
					'label' 		=> __('Color', 'roadthemes'),
					'type' 			=> Controls_Manager::COLOR,
					'selectors' 	=> [
						'{{WRAPPER}} .home-banner .banner-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'subtitle_typo',
					'selector' 		=> '{{WRAPPER}} .home-banner .banner-text',
					'scheme' 		=> Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_responsive_control(
				'subtitle_spacing',
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
						'{{WRAPPER}} .banner-content .banner-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
        $this->end_controls_section();
        $this->start_controls_section(
			'section_button',
			[
				'label' 		=> esc_html__('Button link', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 			=> 'button_typo',
					'selector' 		=> '{{WRAPPER}} .home-banner .banner-button',
					'scheme' 		=> Typography::TYPOGRAPHY_1,
				]
			);
			$this->add_responsive_control(
				'button_padding',
				[
					'label' 		=> __('Padding', 'roadthemes'),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .home-banner .banner-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'button_border_radius',
				[
					'label' 		=> __('Border Radius', 'roadthemes'),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .home-banner .banner-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 			=> 'button_border',
					'selector' 		=> '{{WRAPPER}} .home-banner .banner-button',
				]
			);
			$this->start_controls_tabs('tabs_banner_style');
				$this->start_controls_tab(
					'tab_button_normal',
					[
						'label' 		=> __('Normal', 'roadthemes'),
					]
				);
					$this->add_control(
						'button_color',
						[
							'label' 		=> __('Color', 'roadthemes'),
							'type' 			=> Controls_Manager::COLOR,
							'selectors' 	=> [
								'{{WRAPPER}} .home-banner .banner-button' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'button_background',
						[
							'label' 		=> __('Background color', 'roadthemes'),
							'type' 			=> Controls_Manager::COLOR,
							'selectors' 	=> [
								'{{WRAPPER}} .home-banner .banner-button' => 'background-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'tab_hover_normal',
					[
						'label' 		=> __('Hover', 'roadthemes'),
					]
				);
					$this->add_control(
						'button_hover_color',
						[
							'label' 		=> __('Color', 'roadthemes'),
							'type' 			=> Controls_Manager::COLOR,
							'selectors' 	=> [
								'{{WRAPPER}} .home-banner .banner-button:hover , {{WRAPPER}} .home-banner .banner-button:focus' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'button_hover_background',
						[
							'label' 		=> __('Background color', 'roadthemes'),
							'type' 			=> Controls_Manager::COLOR,
							'selectors' 	=> [
								'{{WRAPPER}} .home-banner .banner-button:hover, {{WRAPPER}} .home-banner .banner-button:focus' => 'background-color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'button_hover_border_color',
						[
							'label' 		=> __('Border color', 'roadthemes'),
							'type' 			=> Controls_Manager::COLOR,
							'selectors' 	=> [
								'{{WRAPPER}} .home-banner .banner-button:hover, {{WRAPPER}} .home-banner .banner-button:focus' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
			'section_hover',
			[
				'label' 		=> esc_html__('Hover', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'hover_opacity',
				[
					'label' 		=> __('Opacity', 'roadthemes'),
					'type' 			=> Controls_Manager::SLIDER,
					'range' 		=> [
						'px' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' 	=> [
						'body {{WRAPPER}} .home-banner img:hover' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_control(
				'hover_animation',
				[
					'label' => __( 'Hover animation', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'multiple' => false,
					'options' => [
						'animation1'  => __( 'Animation 1', 'roadthemes' ),
						'animation2' => __( 'Animation 2', 'roadthemes' ),
						'animation3' => __( 'Animation 3', 'roadthemes' ),
					],
					'default' =>  'animation1' ,
				]
			);
		$this->end_controls_section();
	}
	protected function render() {
		$settings 		= $this->get_settings_for_display();
		$title 			= $settings['title'];
		$title2 		= $settings['title2'];
		$subtitle 		= $settings['subtitle'];
        $link 			= $settings['link'];
        $button_link 	= $settings['button_link'];
        $layout 	    = $settings['layout'];
		$this->add_render_attribute('banner', 'class', ['home-banner', $layout, $settings['hover_animation']]);
		$this->add_render_attribute('content', 'class', 'banner-content');
		$this->add_render_attribute('title', 'class', 'banner-title');
		$this->add_render_attribute('title2', 'class', 'banner-title2');
		$this->add_render_attribute('subtitle', 'class', 'banner-text'); 
		ob_start();
		?>
		<figure <?php echo $this->get_render_attribute_string('banner'); ?>>
			<?php
			if(! empty(Group_Control_Image_Size::get_attachment_image_html($settings))) {
				if(! empty($link['url'])) {
					$this->add_render_attribute('link', 'class', 'rt-banner-link');
					$this->add_render_attribute('link', 'href', $link['url']);
					if($link['is_external']) {
						$this->add_render_attribute('link', 'target', '_blank');
					}
					if($link['nofollow']) {
						$this->add_render_attribute('link', 'rel', 'nofollow');
					}
					echo '<a ' . $this->get_render_attribute_string('link') . '>';
				} ?>
					<?php echo Group_Control_Image_Size::get_attachment_image_html($settings); ?>
				<?php if(! empty($link['url'])) : ?>
					</a>
				<?php endif; ?>
			<?php } ?>
				<figcaption>
					<div <?php echo $this->get_render_attribute_string('content'); ?>>
						<?php if(!empty($title)){ ?><p <?php echo $this->get_render_attribute_string('title'); ?>><?php echo $title; ?></p><?php } ?>
						<?php if(!empty($title2)){ ?><p <?php echo $this->get_render_attribute_string('title2'); ?>><?php echo $title2; ?></p><?php } ?>
						<?php if(!empty($subtitle)){ ?><div <?php echo $this->get_render_attribute_string('subtitle'); ?>><?php echo $subtitle; ?></div><?php } ?>
						<?php if(!empty($button_link) && !empty($link['url'])) : ?><a class="banner-button" href="<?php echo $link['url']; ?>"><?php echo esc_attr($button_link); ?></a><?php endif; ?>
					</div>
				</figcaption>
		</figure>
		<?php
		$content = ob_get_contents();
	    ob_end_clean();
	    echo $content;
	}
}