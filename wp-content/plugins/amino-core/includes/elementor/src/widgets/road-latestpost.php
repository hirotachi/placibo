<?php  
use Elementor\Core\Responsive\Responsive; 
class Road_Latestpost_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_latestpost';
	}

	public function get_title() {
		return __('RT Latest Posts', 'roadthemes');
	}

	public function get_icon() { 
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	public function get_script_depends() {
		return [ 'road-latestpost' ];
	}
 
	

	protected function _register_controls() { 
		
		//Elements
		$this->start_controls_section(
            'section_elements',
            [
                'label' => __('Elements', 'roadthemes')
            ]
		);

		$this->add_control(
			'image_size',
			[
				'label' 		=> __('Image Size', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> 'medium',
				'options' 		=> $this->get_img_sizes(),
			]
		);

		$this->add_control(
			'title',
			[
				'label' 		=> __('Title', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes', 
			]
		);

		$this->add_control(
			'meta',
			[
				'label' 		=> __('Meta', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes', 
			]
		);

		$this->add_control(
			'author',
			[
				'label' 		=> __('Author Meta', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes',
				'condition'		=>  [
					'meta' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'date',
			[
				'label' 		=> __('Date Meta', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes', 
				'condition'		=>  [
					'meta' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'cat',
			[
				'label' 		=> __('Categories Meta', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes', 
				'condition'		=>  [
					'meta' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'comments',
			[
				'label' 		=> __('Comments Meta', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes', 
				'condition'		=>  [
					'meta' 	=> 'yes',
				]
			]
		);

		$this->add_control(
			'excerpt',
			[
				'label' 		=> __('Excerpt', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SWITCHER,
				'default' 		=> 'yes', 
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' 		=> __('Excerpt Length', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> '150',
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label' 		=> __('Learn More Text', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> __('Learn More', 'roadthemes'),
				'label_block' 	=> true,
			]
		);

        $this->end_controls_section();
		
		//Query
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'roadthemes')
            ]
		);

		 

		$this->add_control(
			'count',
			[
				'label' 		=> __('Post Count', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'default' 		=> '6',
				'label_block' 	=> true,
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'order',
			[
				'label' 		=> __('Order', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					'' 			=> __('Default', 'roadthemes'),
					'DESC' 		=> __('DESC', 'roadthemes'),
					'ASC' 		=> __('ASC', 'roadthemes'),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' 		=> __('Order By', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					'' 				=> __('Default', 'roadthemes'),
					'date' 			=> __('Date', 'roadthemes'),
					'title' 		=> __('Title', 'roadthemes'),
					'name' 			=> __('Name', 'roadthemes'),
					'modified' 		=> __('Modified', 'roadthemes'),
					'author' 		=> __('Author', 'roadthemes'),
					'rand' 			=> __('Random', 'roadthemes'),
					'ID' 			=> __('ID', 'roadthemes'),
					'comment_count' => __('Comment Count', 'roadthemes'),
					'menu_order' 	=> __('Menu Order', 'roadthemes'),
				],
			]
		);

		$this->add_control(
			'include_categories',
			[
				'label' 		=> __('Include Categories', 'roadthemes'),
				'description' 	=> __('Enter the categories slugs seperated by a "comma"', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'label_block' 	=> true,
			]
		);

		$this->add_control(
			'exclude_categories',
			[
				'label' 		=> __('Exclude Categories', 'roadthemes'),
				'description' 	=> __('Enter the categories slugs seperated by a "comma"', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::TEXT,
				'label_block' 	=> true,
			]
		);

        $this->end_controls_section();
		
		//Slider Setting
		$this->start_controls_section(
			'setting_section',
			[
				'label' => __( 'Slider', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
			]
		);
			$this->add_control(
				'enable_slider',
				[
					'label' 		=> __('Enable Slider', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> 'yes', 
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
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
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
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
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
						'enable_slider' => 'yes',
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
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);

			$this->add_control(
				'dots',
				[
					'label' 		=> __('Dots', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
			$this->add_control(
				'autoplay',
				[
					'label' => __( 'Autoplay', 'roadthemes' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' => 'yes',  
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
			$this->add_control(
				'autoplay_speed',
				[
					'label'     	=> __('AutoPlay Transition Speed (ms)', 'roadthemes'),
					'type'      	=> \Elementor\Controls_Manager::NUMBER,
					'default'  	 	=> 3000,
					'condition'    	=> [
						'autoplay' => 'yes',
					],
				]
			);
			$this->add_control(
				'pause_on_hover',
				[
					'label' 		=> __('Pause on Hover', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
					'condition'    	=> [
						'autoplay' => 'yes',
					],
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'        	=> __('Infinite Loop', 'roadthemes'),
					'type'         	=> \Elementor\Controls_Manager::SWITCHER,
					'default'      	=> 'no',
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
			$this->add_control(
				'transition_speed',
				[
					'label'     	=> __('Transition Speed (ms)', 'roadthemes'),
					'type'      	=> \Elementor\Controls_Manager::NUMBER,
					'default'  	 	=> 500,
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
		
		$this->end_controls_section();
		
		//Item
		$this->start_controls_section(
			'item_section',
			[
				'label' => __( 'Item', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'item_padding',
				[
					'label' 		=> __('Padding', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .latestpost .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' 	=> 'before',
				]
			);
		$this->end_controls_section();
		
		//Arrows
		$this->start_controls_section(
			'section_arrows_style',
			[
				'label' 		=> __('Arrows', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition'    	=> [
					'arrows' => 'yes', 
				],
			]
		);
		$this->add_control(
			'arrows_background',
			[
				'label' 		=> __('Background', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .slick-slider .slick-arrow' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label' 		=> __('Background Hover', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .slick-slider .slick-arrow:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'arrows_color',
			[
				'label' 		=> __('Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .slick-slider .slick-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label' 		=> __('Color Hover', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .slick-slider .slick-arrow:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
		
		//Dots
		$this->start_controls_section(
			'section_dots_style',
			[
				'label' 		=> __('Dots', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition'    	=> [
					'dots' => 'yes', 
				],
			]
		);
		$this->add_control(
			'dots_background',
			[
				'label' 		=> __('Background', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .slick-dots li button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_hover_background',
			[
				'label' 		=> __('Background Hover', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .slick-dots li button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		 

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' 		=> __('Content', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' 		=> __('Padding', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .content-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_bg_',
			[
				'label' 		=> __('Background Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .content-details' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' 		=> __('Title', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' 		=> __('Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .entry-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' 		=> __('Color: Hover', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .entry-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 			=> 'title_typo',
				'selector' 		=> '{{WRAPPER}} .latestpost .entry-title',
				'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_meta',
			[
				'label' 		=> __('Meta', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' 		=> __('Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} ul.meta, {{WRAPPER}} ul.meta li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_links_hover_color',
			[
				'label' 		=> __('Links Color: Hover', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} ul.meta li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_icons_color',
			[
				'label' 		=> __('Icons Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .meta li i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 			=> 'meta_typo',
				'selector' 		=> '{{WRAPPER}} ul.meta',
				'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_excerpt',
			[
				'label' 		=> __('Excerpt', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' 		=> __('Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .entry-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 			=> 'excerpt_typo',
				'selector' 		=> '{{WRAPPER}} .latestpost .entry-excerpt',
				'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' 		=> __('Button', 'roadthemes'),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE, 
				'condition' 	=> [
					'readmore_text!' => '',
				],
				
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' 		=> __('Color', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .readmore-btn a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' 		=> __('Color: Hover', 'roadthemes'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .latestpost .readmore-btn a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' 			=> 'button_typo',
				'selector' 		=> '{{WRAPPER}} .latestpost .readmore-btn a',
				'scheme' 		=> \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
			]
		);

        $this->end_controls_section();

	}

	 

	public function get_img_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();
	    $get_intermediate_image_sizes = get_intermediate_image_sizes();
	 
	    // Create the full array with sizes and crop info
	    foreach($get_intermediate_image_sizes as $_size) {
	        if(in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
	            $sizes[ $_size ]['width'] 	= get_option($_size . '_size_w');
	            $sizes[ $_size ]['height'] 	= get_option($_size . '_size_h');
	            $sizes[ $_size ]['crop'] 	= (bool) get_option($_size . '_crop');
	        } elseif(isset($_wp_additional_image_sizes[ $_size ])) {
	            $sizes[ $_size ] = array(
	                'width' 	=> $_wp_additional_image_sizes[ $_size ]['width'],
	                'height' 	=> $_wp_additional_image_sizes[ $_size ]['height'],
	                'crop' 		=> $_wp_additional_image_sizes[ $_size ]['crop'],
	           );
	        }
	    }

	    $image_sizes = array();

		foreach($sizes as $size_key => $size_attributes) {
			$image_sizes[ $size_key ] = ucwords(str_replace('_', ' ', $size_key)) . sprintf(' - %d x %d', $size_attributes['width'], $size_attributes['height']);
		}

		$image_sizes['full'] 	= _x('Full', 'Image Size Control', 'woovina-portfolio');

	    return $image_sizes;
	}

	protected function render() {
		$settings = $this->get_settings();
 
		//Enable Slider 
		$enable_slider = $settings['enable_slider'];
		
		$args = array( 
	        'posts_per_page'    => $settings['count'],
	        'order'             => $settings['order'],
	        'orderby'           => $settings['orderby'],
			'no_found_rows' 	=> true,
			'tax_query' 		=> array(
				'relation' 		=> 'AND',
			),
	   );

	    // Include/Exclude categories
	    $include = $settings['include_categories'];
	    $exclude = $settings['exclude_categories'];

	    // Include category
		if(! empty($include)) {

			// Sanitize category and convert to array
			$include = str_replace(', ', ',', $include);
			$include = explode(',', $include);

			// Add to query arg
			$args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $include,
				'operator' => 'IN',
			);

		}

		// Exclude category
		if(! empty($exclude)) {

			// Sanitize category and convert to array
			$exclude = str_replace(', ', ',', $exclude);
			$exclude = explode(',', $exclude);

			// Add to query arg
			$args['tax_query'][] = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $exclude,
				'operator' => 'NOT IN',
			);

		}

	    // Build the WordPress query
	    $query = new \WP_Query($args);

		$counter = 0;

		//Output posts
		if($query->have_posts()) :

			// Vars
			$title   	= $settings['title'];
			$meta    	= $settings['meta'];
			$excerpt 	= $settings['excerpt'];
			$readmore 	= $settings['readmore_text'];

			// Image size
			$img_size 		= $settings['image_size'];
			$img_size 		= $img_size ? $img_size : 'medium';

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

        	if($enable_slider == 'yes') {
				$this->add_render_attribute(
					'data', 
					[
						'class' => ['latestpost', 'slick-slider-block'],
						'data-slick-options' => wp_json_encode($slick_options),
						'data-slick-responsive' => wp_json_encode($slick_responsive),
					]
					
				);
			} else {
				$this->add_render_attribute(
					'data', 
					[
						'class' => 'latestpost',
						 
					]
					
				);
			} ?>

			<div <?php echo $this->get_render_attribute_string('data'); ?>>
				<?php
				// Start loop
				while($query->have_posts()) : $query->the_post();

					// Create new post object.
					$post = new \stdClass();

					// Get post data
					$get_post = get_post();

					// Post Data
					$post->ID           = $get_post->ID;
					$post->permalink    = get_the_permalink($post->ID);
					$post->title        = $get_post->post_title;

					// Only display carousel item if there is content to show
					if(has_post_thumbnail()
						|| 'yes' == $title
						|| 'yes' == $meta
						|| 'yes' == $excerpt
					) { ?>

						<div class="item">
						
							<?php
							// Display thumbnail if enabled and defined
							if(has_post_thumbnail()) { ?>

								<div class="image-container">

									<a href="<?php echo $post->permalink; ?>" title="<?php the_title(); ?>" class="wew-carousel-entry-img">

										<?php
										// Display post thumbnail
										the_post_thumbnail($img_size, array(
											'alt'		=> get_the_title(),
										)); ?>

									</a>
									<?php
									// Display meta
									if('yes' == $meta) { ?>
										<ul class="meta">
											<?php if('yes' == $settings['cat']) { ?>
												<li class="meta-cat"><?php the_category('', get_the_ID()); ?></li>
											<?php } ?>
										</ul>
									<?php } ?>
								</div><!-- .wew-carousel-entry-media -->

							<?php } ?>

							<?php
							// Open details element if the title or excerpt are true
							if('yes' == $title
								|| 'yes' == $meta
								|| 'yes' == $excerpt
							) { ?>

								<div class="content-details">
									
									
									<?php
									// Display title if $title is yes and there is a post title
									if('yes' == $title) { ?>

										<h6 class="blog-title entry-title">
											<a href="<?php echo $post->permalink; ?>" title="<?php the_title(); ?>"><?php echo $post->title; ?></a>
										</h6>

									<?php } ?>

									<?php
									// Display excerpt if $excerpt is true
									if('yes' == $excerpt) { ?>

										<div class="entry-excerpt">
											<?php echo substr(the_excerpt(), 0 , $settings['excerpt_length'] ); ?>
										</div><!-- .entry-excerpt -->
										
									<?php } ?>

									<?php
									// Display read more
									if('' != $readmore) { ?>

										<div class="readmore-btn">
											<a href="<?php echo $post->permalink; ?>"><?php echo $readmore; ?></a>
										</div><!-- .readmore -->
										
									<?php } ?>
									<?php
									// Display meta
									
									if('yes' == $meta) { ?>
										<ul class="meta">
											<?php if('yes' == $settings['date']) { ?>
												<li class="meta-date"  ><i class="icon-clock"></i><a href="<?php echo $post->permalink; ?>"><?php echo get_the_date(); ?></a></li>
											<?php } ?>
											<?php if('yes' == $settings['author']) { ?>
												<li class="meta-author" ><i class="icon-user"></i><?php printf('by <span>%s</span>.', get_the_author(), 'roadthemes') ; ?></li>
											<?php } ?>
											<?php if('yes' == $settings['comments'] && comments_open() && ! post_password_required()) { ?>
												<li class="meta-comments"><i class="icon-bubble"></i><?php comments_popup_link(esc_html__('0 Comments', 'roadthemes'), esc_html__('1 Comment',  'roadthemes'), esc_html__('% Comments', 'roadthemes'), 'comments-link'); ?></li>
											<?php } ?>
										</ul>
									<?php } ?>
								</div><!-- .content-details -->

							<?php } ?>

						</div>

					<?php } ?>

					<?php $counter++; ?>

				<?php
				// End entry loop
				endwhile; ?>

			</div><!-- .latestpost -->

			<?php
			// Reset the post data to prevent conflicts with WP globals
			wp_reset_postdata(); ?>

		<?php
		// If no posts are found display message
		else : ?>

			<p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'roadthemes'); ?></p>

		<?php
		// End post check
		endif; ?>

	<?php
	}

}