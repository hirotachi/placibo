<?php  
use Elementor\Core\Responsive\Responsive; 
class Road_Brandlogo_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_brandlogo';
	}

	public function get_title() {
		return __( 'RT Brand Logo', 'roadthemes' );
	}
	
	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}
	public function get_script_depends() {
		return [ 'road-brandlogo'];
	} 
	public function get_style_depends() {
		return [ 'road-brandlogo' ];
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
			$repeater->add_control (
				'brand_title',
				[
					'label' => __('Title','roadthemes'),
					'type' => \Elementor\Controls_Manager::TEXT, 
					'placeholder' => __( 'New Item', 'roadthemes' ),
					'default' => __('New Item', 'roadthemes'),
				] 
			);
			$repeater->add_control(
				'brand_image',
				[
					'label' => __( 'Choose Image', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
				]
			);
			$repeater->add_control(
				'brand_link',
				[
					'label' => __( 'Link', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'roadthemes' ), 
					'default' => [
						'url' => '', 
					],
				]
			);
			$this->add_control(
				'brand_list',
				[
					'label' => __( 'Brand Logo Items', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'brand_title' => __( 'New Item', 'roadthemes' ), 
						], 
					],
					'title_field' => '{{{ brand_title }}}',
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
		
		//Item
		$this->start_controls_section(
			'item_section',
			[
				'label' => __( 'Item', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
			]
		);
			$this->add_responsive_control(
				'item_padding',
				[
					'label' 		=> __('Padding', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .brand-logo .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' 	=> 'before',
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
			'brandlogo', 
			[
				'class' => ['brand-logo', 'slick-slider-block', 'column-desktop-'. $responsive['xl'],'column-tablet-'. $responsive['md'],'column-mobile-'. $responsive['xs']],
				'data-slick-responsive' => wp_json_encode($slick_responsive),
				'data-slick-options' => wp_json_encode($slick_options),
			]
			
		);
		ob_start();
		$this->add_render_attribute('class-item', 'class', 'item');
		if ( $settings['brand_list'] ) {
			echo '<div '.$this->get_render_attribute_string('brandlogo').'>';
			foreach (  $settings['brand_list'] as $item ) {
				echo '<div '.$this->get_render_attribute_string('class-item').'>';
					if(isset($item['brand_link']['url']) && $item['brand_link']['url'] != '') { 
						echo '<a href="'.$item['brand_link']['url'].'">';
					};
						if(isset($item['brand_image']) && $item['brand_image'] != '') {
							echo '<img src="' . $item['brand_image']['url'] . '" alt="'.$item['brand_title'].'" title="'.$item['brand_title'].'"/>';
						}; 
					if(isset($item['brand_link']['url']) && $item['brand_link']['url'] != '') {
						echo '</a>';
					};
					
					
				echo '</div>'; 
			}
			wp_reset_postdata();
			echo '</div>';
		}  
		
		$content = ob_get_contents();
	    ob_end_clean();
	    echo $content;
	} 
}