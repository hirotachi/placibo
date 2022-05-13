<?php  

use Elementor\Core\Responsive\Responsive; 
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Road_Testimonials_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_testimonials';
	}

	public function get_title() {
		return __( 'RT Testimonials', 'roadthemes' );
	}
	
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	protected function _register_controls() {
		
		//Tab Content
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Testimonials list', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$repeater = new \Elementor\Repeater(); 
			$repeater->add_control (
				'tes_name',
				[
					'label' => __('Name','roadthemes'),
					'type' => \Elementor\Controls_Manager::TEXT, 
					'placeholder' => '',
				] 
			);
			$repeater->add_control (
				'tes_title',
				[
					'label' => __('Title','roadthemes'),
					'type' => \Elementor\Controls_Manager::TEXT, 
					'placeholder' => '',
				] 
			);
			$repeater->add_control(
				'tes_image',
				[
					'label' => __( 'Choose Image', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
			$repeater->add_control(
				'tes_content',
				[
					'label' => __( 'Content', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'rows' => 10,
				]
			);
			$this->add_control(
				'tes_list',
				[
					'label' => __( 'Testimonial Items', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'title_field' => '{{{ tes_name }}}',
				]
			);
			 

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section',
			[
				'label' => __( 'Layout', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'design',
				[
					'label' => __( 'Select a design', 'roadthemes' ),
					'type' => 'amino-choose',
					'options' => [
						'1' => [
							'title' => __( 'Design 1', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/grid.jpg',
							'class' => 'width-50'
						],
						'2' => [
							'title' => __( 'Design 2', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/list.jpg',
							'class' => 'width-50'
						],
						
					],
					'default' => '1',
					'show_label' => false,
				]
			);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'setting_section',
			[
				'label' => __( 'Slider configuration', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$items = array('' => __('Default' , 'roadthemes'), '1' => 1,'2' => 2,'3' => 3,'4' => 4,'5' => 5,'6' => 6);
			
			$this->add_control(
				'items',
				[
					'label' => __( 'Slides to Show', 'roadthemes' ),
					'description' => __( 'Desktop screen', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'default' => '4'
				]
			);
			$this->add_control(
				'responsive',
				[
					'label' => __( 'Responsive', 'roadthemes' ),
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
				'items_laptop',
				[
					'label' => __( 'Items on Laptop', 'roadthemes' ),
					'description' => __( 'Responsive screen: 1200px to 1535px', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_control(
				'items_landscape_tablet',
				[
					'label' => __( 'Items on Landscape Tablet', 'roadthemes' ),
					'description' => __( 'Responsive screen: 992px to 1199px', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_control(
				'items_portrait_tablet',
				[
					'label' => __( 'Items on Portrait Tablet', 'roadthemes' ),
					'description' => __( 'Responsive screen: 768px to 991px', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_control(
				'items_landscape_mobile',
				[
					'label' => __( 'Items on Landscape Phone', 'roadthemes' ),
					'description' => __( 'Responsive screen: 568px to 767px', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_control(
				'items_portrait_mobile',
				[
					'label' => __( 'Items on Portrait Phone', 'roadthemes' ),
					'description' => __( 'Responsive screen: 360px to 567px', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_control(
				'items_small_mobile',
				[
					'label' => __( 'Items on Small Phone', 'roadthemes' ),
					'description' => __( 'Responsive screen: <359px', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_responsive_control(
				'slides_to_scroll',
				[
					'label' => __( 'Slides to Scroll', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'description' => __( 'Set how many slides are scrolled per swipe.', 'roadthemes' ),
					'options' => [
						'' => __( 'Default', 'roadthemes' ),
					] + $items,
					'condition' => [
						'items!' => '1',
					],
					'frontend_available' => true,
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
		
		$this->start_controls_section(
			'section_style_testimonial_content',
			[
				'label' => __( 'Content', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_content_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default' => '',
				'selectors' => [
					'.rt-testimonial .tes-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '.rt-testimonial .tes-content',
			]
		);

		$this->end_controls_section();

		// Image.
		$this->start_controls_section(
			'section_style_testimonial_image',
			[
				'label' => __( 'Image', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],
				],
				'selectors' => [
					'.rt-testimonial .tes-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '.rt-testimonial .tes-image img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.rt-testimonial .tes-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Name.
		$this->start_controls_section(
			'section_style_testimonial_name',
			[
				'label' => __( 'Name', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default' => '',
				'selectors' => [
					'.rt-testimonial .testimonial-item .tes-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.rt-testimonial .testimonial-item .tes-name',
			]
		);

		$this->end_controls_section();

		// Job.
		$this->start_controls_section(
			'section_style_testimonial_job',
			[
				'label' => __( 'Title', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'job_text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'default' => '',
				'selectors' => [
					'.rt-testimonial .testimonial-item .tes-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'job_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '.rt-testimonial .testimonial-item .tes-title',
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
			'slidesToShow'   => ($settings['items']) ? absint($settings['items']) : 4,
			'slidesToScroll' => ($settings['slides_to_scroll']) ? absint($settings['slides_to_scroll']) : 1,
			'autoplay'       => ($settings['autoplay'] == 'yes') ? true : false,
			'autoplaySpeed'  => ($settings['autoplay_speed']) ? absint($settings['autoplay_speed']) : 5000,
			'infinite'       => ($settings['infinite'] == 'yes') ? true : false,
			'pauseOnHover'   => ($settings['pause_on_hover'] == 'yes') ? true : false,
			'speed'          => ($settings['transition_speed']) ? absint($settings['transition_speed']) : 500,
			'arrows'         => ($settings['arrows'] == 'yes') ? true : false,
			'dots'           => ($settings['dots'] == 'yes') ? true : false, 
		]; 

		$responsive = array();
		if($settings['responsive'] == 'default') {
			$responsive = amino_default_responsive((int)$settings['items']);
		}else{
			$default_responsive = amino_default_responsive((int)$settings['items']);
			$responsive = array(
				'xl' => $settings['items_laptop'] ? (int)$settings['items_laptop'] : $default_responsive['xl'],
				'lg' => $settings['items_landscape_tablet'] ? (int)$settings['items_landscape_tablet'] : $default_responsive['lg'],
				'md' => $settings['items_portrait_tablet'] ? (int)$settings['items_portrait_tablet'] : $default_responsive['md'],
				'sm' => $settings['items_landscape_mobile'] ? (int)$settings['items_landscape_mobile'] : $default_responsive['sm'],
				'xs' => $settings['items_portrait_mobile'] ? (int)$settings['items_portrait_mobile'] : $default_responsive['xs'],
				'xxs' => $settings['items_small_mobile'] ? (int)$settings['items_small_mobile'] : $default_responsive['xxs'],
			);
		}
		$slick_responsive = [
			'items_laptop'            => $responsive['xl'],
            'items_landscape_tablet'  => $responsive['lg'],
            'items_portrait_tablet'   => $responsive['md'],
            'items_landscape_mobile'  => $responsive['sm'],
            'items_portrait_mobile'   => $responsive['xs'],
            'items_small_mobile'      => $responsive['xxs'],
		];
		 
		$this->add_render_attribute(
			'testimonial', 
			[
				'class' => ['rt-testimonial', 'slick-slider-block', 'layout-'.$settings['design'],'column-desktop-'. $responsive['xl'],'column-tablet-'. $responsive['md'],'column-mobile-'. $responsive['xs']],
				'data-slick-responsive' => wp_json_encode($slick_responsive),
				'data-slick-options' => wp_json_encode($slick_options),
			]
			
		);

		if ( $settings['tes_list'] ) :
		ob_start();
		?>
			<div <?php echo $this->get_render_attribute_string('testimonial'); ?>>
				<?php foreach ( $settings['tes_list'] as $item ) : 
					$has_content = ! ! $item['tes_content'];
					$has_image = ! ! $item['tes_image']['url'];
					$has_name = ! ! $item['tes_name'];
					$has_title = ! ! $item['tes_title'];
					?>
					<?php if($settings['design'] == '1') : ?>
						<div class="testimonial-item">
							<?php if($has_image) : ?>
									<div class="tes-image"><img src="<?php echo $item['tes_image']['url']; ?>" alt=""/></div>
							<?php endif; ?>
							<?php if($has_title) : ?>
									<p class="tes-title"><?php echo $item['tes_title']; ?></p>
							<?php endif; ?>
							<?php if($has_content) : ?>
									<p class="tes-content"><?php echo $item['tes_content']; ?></p>
							<?php endif; ?>
							<?php if($has_name) : ?>
									<p class="tes-name"><?php echo $item['tes_name']; ?></p>
							<?php endif; ?>
						</div>
					
					<?php else : ?>	
						<div class="testimonial-item design-2">
							<div class="testimonial-box">
								<?php if($has_image) : ?>
									<div class="tes-image"><img src="<?php echo $item['tes_image']['url']; ?>" alt=""/></div>
								<?php endif; ?>
								<div class="testimonial-content">
									<div class="woocommerce">
										<div class="woocommerce-product-rating">
											<div class="star-rating"><span><?php esc_html_e( 'Rating', 'amino' ); ?></span></div>								
										</div>
									</div>
									<?php if($has_title) : ?>
											<p class="tes-title"><?php echo $item['tes_title']; ?></p>
									<?php endif; ?>
									
									<?php if($has_content) : ?>
											<p class="tes-content"><?php echo $item['tes_content']; ?></p>
									<?php endif; ?>
									<?php if($has_name) : ?>
											<p class="tes-name"><?php echo $item['tes_name']; ?></p>
									<?php endif; ?>
								</div>
							</div>				
						</div>
					<?php endif; ?>	
				<?php endforeach;
				wp_reset_postdata(); ?>
			</div>
		
		<?php 
		$content = ob_get_contents();
	    ob_end_clean();
	    echo $content;

		endif;
	} 
}