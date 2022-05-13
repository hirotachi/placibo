<?php  

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Widget_Base;



class Road_Tab_Products_Widget extends Widget_Base { 
	public function get_name() {
		return 'rt_tab_products';
	}

	public function get_title() {
		return __('RT Tab Products', 'roadthemes');
	}

	public function get_icon() { 
		return 'eicon-product-tabs';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	public function get_script_depends() {
		return [ 'road-products'];
	}
 
	protected function _register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'roadthemes' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tab_type',
			[
				'label' => __( 'Product tab type', 'roadthemes' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'normal' => __( 'Normal tabs', 'roadthemes' ),
					'ajax' => __( 'Ajax tabs', 'roadthemes' ),
				] ,
				'default' => 'ajax',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'tab_products_section',
			[
				'label' => __( 'Content', 'roadthemes' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'tab_title', [
				'label' => __( 'Title', 'roadthemes' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Tab Title' , 'roadthemes' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'product_type',
			[
				'label' => __( 'Product Types', 'roadthemes' ),
				'type' => Controls_Manager::SELECT,
				'description' => __( 'Select product types', 'roadthemes' ),
				'options' => [
					'new_products' => __( 'New Products', 'roadthemes' ),
					'featured_products' => __( 'Featured Products', 'roadthemes' ),
					'onsale_products' => __( 'Sale Products', 'roadthemes' ),
					'best_selling_products' => __( 'Best Selling Products', 'roadthemes' ),
					'top_rated_products' => __( 'Top Rated Products', 'roadthemes' ),
					'category_products' => __( 'Category Products', 'roadthemes' ), 
					'select_products' => __( 'Select Products', 'roadthemes' ), 
				] ,
				'default' => 'new_products',
			]
		);
		
		$repeater->add_control(
			'category',
			[
				'label' 		=> __('Category', 'roadthemes'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> __('Please select a category', 'roadthemes'),
				'options' 		=> $this->rt_get_categories(),
				'label_block' => true,
				'condition'		=> [
					'product_type' => 'category_products',
				],
			]
		); 
		$repeater->add_control(
			'selected_products',
			[
				'label' 		=> __('Select the products', 'roadthemes'),
				'type' 			=> Controls_Manager::SELECT2,
				'options' 		=> $this->rt_get_list_products(),
				'multiple' => true,
				'label_block' => true,
				'condition'		=> [
					'product_type' => 'select_products',
				],
				'select2options' => [
					'placeholder' => __('Type and search the products', 'roadthemes')
				],
			]
		);		
		$repeater->add_control(
			'limit',
			[
				'label' 		=> __('Number Products', 'roadthemes'),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> '6',
				'label_block' 	=> true,
				'separator' 	=> 'before',
			]
		);

		$repeater->add_control(
			'order',
			[
				'label' 		=> __('Order', 'roadthemes'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					'' 			=> __('Default', 'roadthemes'),
					'DESC' 		=> __('DESC', 'roadthemes'),
					'ASC' 		=> __('ASC', 'roadthemes'),
				],
			]
		); 
		

		$repeater->add_control(
			'orderby',
			[
				'label' 		=> __('Order By', 'roadthemes'),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '',
				'options' 		=> [
					'' 				=> __('Default', 'roadthemes'),
					'date' 			=> __('Date', 'roadthemes'),
					'id' 			=> __('ID', 'roadthemes'),
					'title' 		=> __('Title', 'roadthemes'),
					'rating' 		=> __('Rating', 'roadthemes'), 
					'rand' 			=> __('Random', 'roadthemes'),  
					'menu_order' 	=> __('Menu Order', 'roadthemes'),
					'popularity'	=> __('Popularity', 'roadthemes'),
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Tab products List', 'roadthemes' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ tab_title }}}',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section',
			[
				'label' => __( 'Layout', 'roadthemes' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			
			$this->add_control(
				'enable_slider',
				[
					'label' 		=> __('Enable Slider', 'roadthemes'),
					'type' 			=> Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> 'yes', 
				]
			);
			$this->add_control(
				'columns',
				[
					'label' => __( 'Columns', 'roadthemes' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['item'],
					'range' => [
						'item' => [
							'min' => 1,
							'max' => 6,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'item',
						'size' => 4,
					],
					'condition' 	=> [
						'enable_slider!' => 'yes',
					],
				]
			);
			$this->add_control(
			'product_display',
				[
					'label' => __( 'Product display', 'roadthemes' ),
					'type' => 'amino-choose',
					'options' => [
						'grid' => [
							'title' => __( 'Grid', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/grid.jpg',
							'class' => 'width-50'
						],
						'list' => [
							'title' => __( 'CentLister', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/list.jpg',
							'class' => 'width-50'
						],
					],
					'default' => 'grid',
					'show_label' => false,
				]
			);

		$this->end_controls_section();

		//Slider Setting
		$this->start_controls_section(
			'slider_section',
			[
				'label' => __( 'Slider configurations', 'roadthemes' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
			
			$this->add_control(
				'rows',
				[
					'label' => __( 'Rows', 'roadthemes' ),
					'description' => __( 'Multi rows for slider', 'roadthemes' ),
					'type'      	=> Controls_Manager::NUMBER,
					'default'  	 	=> 1,
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
			$items = array('' => __('Default' , 'roadthemes'), '1' => 1,'2' => 2,'3' => 3,'4' => 4,'5' => 5,'6' => 6);
			
			$this->add_control(
				'items',
				[
					'label' => __( 'Slides to Show', 'roadthemes' ),
					'description' => __( 'Desktop screen', 'roadthemes' ),
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
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
					'type' => Controls_Manager::SELECT,
					'options' => $items,
					'frontend_available' => true,
					'condition'    	=> [
						'responsive' => 'custom',
					],
					'default' => ''
				]
			);
			$this->add_control(
				'slides_to_scroll',
				[
					'label' => __( 'Slides to Scroll', 'roadthemes' ),
					'type' => Controls_Manager::SELECT,
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
					'type' 			=> Controls_Manager::SWITCHER,
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
					'type' 			=> Controls_Manager::SWITCHER,
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
					'type' 			=> Controls_Manager::SWITCHER,
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
					'type'      	=> Controls_Manager::NUMBER,
					'default'  	 	=> 3000,
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'        	=> __('Infinite Loop', 'roadthemes'),
					'type'         	=> Controls_Manager::SWITCHER,
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
					'type'      	=> Controls_Manager::NUMBER,
					'default'  	 	=> 1000,
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
		
		$this->end_controls_section();
		$this->start_controls_section(
			'section_tp_style',
			[
				'label' 		=> esc_html__('Title Style', 'roadthemes'),
				'tab' 			=> Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'title_type',
				[
					'label' => __( 'Title type', 'plugin-domain' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'normal',
					'options' => [
						'normal'  => __( 'Normal', 'roadthemes' ),
						'absolute' => __( 'Absolute', 'roadthemes' ),
					],
				]
			);
			$this->add_responsive_control(
				'title_absolute',
				[
					'label' => __( 'Title absolute', 'roadthemes' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => -20,
					],
					'selectors' => [
						'{{WRAPPER}} .rt-tabs' => 'top: {{SIZE}}{{UNIT}};',
					],
					'condition'    	=> [
						'title_type' => 'absolute',
					],
				]
			);
			$this->add_control(
				'title_align',
				[
					'label' => __( 'Title alignment', 'roadthemes' ),
					'type' => Controls_Manager::CHOOSE,
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
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} .rt-tabs' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'title_size',
				[
					'label' => __( 'Title size', 'roadthemes' ),
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
						'size' => 15,
					],
					'selectors' => [
						'{{WRAPPER}} .rt-tabs li a' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'title_padding',
				[
					'label' => __( 'Padding', 'elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .rt-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs('tabs_title_style');
				$this->start_controls_tab(
					'title_normal',
					[
						'label' => __( 'Normal', 'roadthemes' ),
					]
				);
					$this->add_control(
						'title_color',
						[
							'label' => __( 'Text Color', 'roadthemes' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .rt-tabs li a' => 'fill: {{VALUE}}; color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'bg_color',
						[
							'label' => __( 'Background color', 'roadthemes' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .rt-tabs li a' => 'background-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'title_active',
					[
						'label' => __( 'Active', 'roadthemes' ),
					]
				);
					$this->add_control(
						'title_active_color',
						[
							'label' => __( 'Color', 'roadthemes' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .rt-tabs li.active a, {{WRAPPER}} .rt-tabs li:hover a' => 'fill: {{VALUE}}; color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'bg_active_color',
						[
							'label' => __( 'Background color', 'roadthemes' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .rt-tabs li.active a, {{WRAPPER}} .rt-tabs li:hover a' => 'background-color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'border_active_color',
						[
							'label' => __( 'Border color', 'roadthemes' ),
							'type' => Controls_Manager::COLOR,
							'default' => '',
							'selectors' => [
								'{{WRAPPER}} .rt-tabs li.active a, {{WRAPPER}} .rt-tabs li:hover a' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'selector' => '{{WRAPPER}} .rt-tabs li a',
					'separator' => 'before',
				]
			);

			$this->add_control(
				'border_radius',
				[
					'label' => __( 'Border Radius', 'elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .rt-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'button_box_shadow',
					'selector' => '{{WRAPPER}} .rt-tabs li',
				]
			);
			
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		//echo '<pre>'; print_r($settings); echo '</pre>'; die('x_x');
		$id_int = substr( $this->get_id_int(), 0, 4 );
		?>
		<div class="rt-tab-products rt-tabs-wrapper <?php if($settings['tab_type'] == 'ajax') echo 'rt-ajax-tabs'; ?> <?php if($settings['title_type'] == 'absolute') echo 'title-absolute'; ?>" role="tablist">
			<ul class="tabs rt-tabs align-<?php echo $settings['title_align']; ?>">
				<?php
				foreach ( $settings['list'] as $index => $tab ) :
					$tab_count = $index + 1;

					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
					if($settings['tab_type'] == 'normal'){
						$this->add_render_attribute( $tab_title_setting_key, [
							'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title'],
							'data-toggle' => 'tab',
							'href' => '#rt-tab-content-' . $id_int . $tab_count,
						] );
					}else{
						$responsive = array();
						if($settings['responsive'] == 'default') {
							$responsive = amino_default_responsive((int)$settings['items']);
						}else{
							$default_responsive = amino_default_responsive((int)$settings['items']);
							$responsive = array(
								'xl' => $settings['items_laptop'] ? $settings['items_laptop'] : $default_responsive['xl'],
								'lg' => $settings['items_landscape_tablet'] ? $settings['items_landscape_tablet'] : $default_responsive['lg'],
								'md' => $settings['items_portrait_tablet'] ? $settings['items_portrait_tablet'] : $default_responsive['md'],
								'sm' => $settings['items_landscape_mobile'] ? $settings['items_landscape_mobile'] : $default_responsive['sm'],
								'xs' => $settings['items_portrait_mobile'] ? $settings['items_portrait_mobile'] : $default_responsive['xs'],
								'xxs' => $settings['items_small_mobile'] ? $settings['items_small_mobile'] : $default_responsive['xxs'],
							);
						};
						$data_attr = array(
							'product_type' => $tab['product_type'],
							'category' => $tab['category'],
							'selected_products' => $tab['selected_products'],
							'limit' => $tab['limit'],
							'order' => $tab['order'],
							'orderby' => $tab['orderby'],
							'product_display'      => $settings['product_display'],
							'columns'              => (int) $settings['columns']['size'],
							//Slider config
				            'enable_slider'        => $settings['enable_slider'],
				            'items'                => (int) $settings['items'],
				            'items_laptop'          => (int)$responsive['xl'],
				            'items_landscape_tablet'=> (int)$responsive['lg'],
				            'items_portrait_tablet' => (int)$responsive['md'],
				            'items_landscape_mobile'=> (int)$responsive['sm'],
				            'items_portrait_mobile' => (int)$responsive['xs'],
				            'items_small_mobile'    => (int)$responsive['xxs'],
				            'autoplay'             => $settings['autoplay'],
				            'autoplay_speed'       => $settings['autoplay_speed'] ? (int) $settings['autoplay_speed'] : 3000,
				            'transition_speed'     => $settings['transition_speed'] ? (int) $settings['transition_speed'] : 1000,
				            'nav'                  => $settings['arrows'],
				            'pag'                  => $settings['dots'],
				            'loop'                 => $settings['infinite'],
				            'rows'                 => $settings['rows'] ? (int) $settings['rows'] : 1,
				            'action' => 'ajax',
						);
						$this->add_render_attribute( $tab_title_setting_key, [
							'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title' , 'rt-ajax-tab'],
							'data-id' => $id_int . $tab_count,
							'data-atts' => wp_json_encode($data_attr),
							'href' => '#rt-tab-content-' . $id_int . $tab_count,
							'data-nonce' => wp_create_nonce('ajax-tab-nonce'),
						] );
					}
					
					?>
					<li class="<?php if($index == 0) echo 'active'; ?>"><a <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>><?php echo $tab['tab_title']; ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php
			if($settings['tab_type'] == 'normal') {
				foreach ( $settings['list'] as $index => $tab ) :
					$tab_count = $index + 1;
					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );
					$this->add_render_attribute( $tab_content_setting_key, [
						'id' => 'rt-tab-content-' . $id_int . $tab_count,
						'class' => [ 'rt-tab-panel' , ($index == 0) ? 'opened' : ''],
					] );
					
					
					?>
					
					<div <?php echo $this->get_render_attribute_string($tab_content_setting_key); ?>>
						<?php echo $this->rt_get_products($tab); ?>
					</div>
					<?php 
						if($settings['tab_type'] == 'ajax') break; 
					?>
				<?php endforeach; 
			}else{
				$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', 1 );
				$this->add_render_attribute( $tab_content_setting_key, [
					'id' => 'rt-tab-content-' . $id_int . '1',
					'class' => [ 'rt-tab-panel opened' ],
				] );
				
				?>
				<div <?php echo $this->get_render_attribute_string($tab_content_setting_key); ?>>
					<?php echo $this->rt_get_products($settings['list'][0]); ?>
				</div>
			<?php
			}
			?>
		</div>
		<?php
	}

	public function rt_get_categories() { 
		$options = array();
		
		$terms    = get_terms(array( 'taxonomy' => 'product_cat' )); 
		foreach ($terms as $term) {  
			$options[$term->slug] = array(
				$term->name, 
			);
		}    	
		return $options; 
	} 
	public function rt_get_list_products() { 
		$options = array();
		
		$loop = new WP_Query(array(
			'post_type'   => 'product',
			'posts_per_page' => 9999
		) );  
		while ($loop->have_posts()) : $loop->the_post();
			global $product;
			$options[$product->get_id()] = array(
				$product->get_name().' (#'.$product->get_id().')'
			);
		endwhile;
		 	
		return $options; 
	} 
	public function rt_get_products($cofig) {
		$settings = $this->get_settings(); 

		$responsive = array();
		if($settings['responsive'] == 'default') {
			$responsive = amino_default_responsive((int)$settings['items']);
		}else{
			$default_responsive = amino_default_responsive((int)$settings['items']);
			$responsive = array(
				'xl' => $settings['items_laptop'] ? $settings['items_laptop'] : $default_responsive['xl'],
				'lg' => $settings['items_landscape_tablet'] ? $settings['items_landscape_tablet'] : $default_responsive['lg'],
				'md' => $settings['items_portrait_tablet'] ? $settings['items_portrait_tablet'] : $default_responsive['md'],
				'sm' => $settings['items_landscape_mobile'] ? $settings['items_landscape_mobile'] : $default_responsive['sm'],
				'xs' => $settings['items_portrait_mobile'] ? $settings['items_portrait_mobile'] : $default_responsive['xs'],
				'xxs' => $settings['items_small_mobile'] ? $settings['items_small_mobile'] : $default_responsive['xxs'],
			);
		};
		
		$atts = array(
			'product_type'         => $cofig['product_type'],
            'selected_products'    => $cofig['selected_products'],
            'category'             => $cofig['category'],
            'orderby'              => $cofig['orderby'],
            'order'                => $cofig['order'],
            'limit'                => (int) $cofig['limit'],
            //Layout
			'product_display'      => $settings['product_display'],
			'columns'              => (int) $settings['columns']['size'],
			//Slider config
            'enable_slider'        => ($settings['enable_slider'] == 'yes') ? true : false,
            'items'                => (int) $settings['items'],
            'items_laptop'          => (int)$responsive['xl'],
            'items_landscape_tablet'=> (int)$responsive['lg'],
            'items_portrait_tablet' => (int)$responsive['md'],
            'items_landscape_mobile'=> (int)$responsive['sm'],
            'items_portrait_mobile' => (int)$responsive['xs'],
            'items_small_mobile'    => (int)$responsive['xxs'],
            'autoplay'             => ($settings['autoplay'] == 'yes') ? true : false,
            'autoplay_speed'       => $settings['autoplay_speed'] ? (int) $settings['autoplay_speed'] : 3000,
            'transition_speed'     => $settings['transition_speed'] ?(int) $settings['transition_speed'] : 1000,
            'nav'                  => ($settings['arrows'] == 'yes') ? true : false,
            'pag'                  => ($settings['dots'] == 'yes') ? true : false,
            'loop'                 => ($settings['infinite'] == 'yes') ? true : false,
            'rows'                 => $settings['rows'] ? (int) $settings['rows'] : 1, 
			
		); 

		$products = amino_products($atts);

		return $products;  
	} 

}