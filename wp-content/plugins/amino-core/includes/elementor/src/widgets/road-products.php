<?php  
use Elementor\Core\Responsive\Responsive; 
class Road_Products_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_products';
	}

	public function get_title() {
		return __('RT Products', 'roadthemes');
	}

	public function get_icon() { 
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'roadthemes-category' ];
	}
	

	protected function _register_controls() { 
		 
		// Resource
		$this->start_controls_section(
			'products_section',
			[
				'label' => __( 'Resource', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'product_type',
				[
					'label' => __( 'Product Types', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SELECT,
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
			
			$this->add_control(
				'category',
				[
					'label' 		=> __('Category', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SELECT,
					'default' 		=> __('Please select a category', 'roadthemes'),
					'options' 		=> $this->rt_get_categories(),
					'label_block' => true,
					'condition'		=> [
						'product_type' => 'category_products',
					],
				]
			); 
			$this->add_control(
				'selected_products',
				[
					'label' 		=> __('Select the products', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SELECT2,
					'options' 		=> $this->rt_get_list_products(),
					'multiple'      => true,
					'label_block'   => true,
					'condition'		=> [
						'product_type' => 'select_products',
					],
					'select2options' => [
						'placeholder' => __('Type and search the products', 'roadthemes')
					],
				]
			); 
			$this->add_control(
				'limit',
				[
					'label' 		=> __('Limit', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::NUMBER,
					'default' 		=> 6,
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
					'condition'    	=> [
						'product_type!' => 'select_products',
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
						'id' 			=> __('ID', 'roadthemes'),
						'title' 		=> __('Title', 'roadthemes'),
						'rating' 		=> __('Rating', 'roadthemes'), 
						'rand' 			=> __('Random', 'roadthemes'),  
						'menu_order' 	=> __('Menu Order', 'roadthemes'),
						'popularity'	=> __('Popularity', 'roadthemes'),
					],
					'condition'    	=> [
						'product_type!' => 'select_products',
					],
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
				'enable_slider',
				[
					'label' 		=> __('Enable Slider', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> 'yes', 
				]
			);
		
			$this->add_control(
				'columns',
				[
					'label' => __( 'Columns', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
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
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition'    	=> [
					'enable_slider' => 'yes',
				],
			]
		);
			
			$items = array('' => __('Default' , 'roadthemes'), '1' => 1,'2' => 2,'3' => 3,'4' => 4,'5' => 5,'6' => 6);
			
			$this->add_control(
				'rows',
				[
					'label' => __( 'Rows', 'roadthemes' ),
					'description' => __( 'Multi rows for slider', 'roadthemes' ),
					'type'      	=> \Elementor\Controls_Manager::NUMBER,
					'default'  	 	=> 1,
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
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
			$this->add_control(
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
						'enable_slider' => 'yes',
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
					'default'  	 	=> 1000,
					'condition'    	=> [
						'enable_slider' => 'yes',
					],
				]
			);
		
		$this->end_controls_section();


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
	public function rt_get_products() {
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
			'product_type'         => $settings['product_type'],
            'selected_products'    => $settings['selected_products'],
            'category'             => $settings['category'],
            'orderby'              => $settings['orderby'],
            'order'                => $settings['order'],
            'limit'                => $settings['limit'] ? (int) $settings['limit'] : 8,
            //Layout
			'product_display'      => $settings['product_display'],
			'columns'              => (int) $settings['columns']['size'],
			//Slider config
            'enable_slider'        => ($settings['enable_slider'] == 'yes') ? true : false,
            'items'                => (int) $settings['items'],
            'items_laptop'          => (int) $responsive['xl'],
            'items_landscape_tablet'=> (int) $responsive['lg'],
            'items_portrait_tablet' => (int) $responsive['md'],
            'items_landscape_mobile'=> (int) $responsive['sm'],
            'items_portrait_mobile' => (int) $responsive['xs'],
            'items_small_mobile'    => (int) $responsive['xxs'],
            'autoplay'             => ($settings['autoplay'] == 'yes') ? true : false,
            'autoplay_speed'       => $settings['autoplay_speed'] ? (int) $settings['autoplay_speed'] : 3000,
            'transition_speed'     => $settings['transition_speed'] ? (int) $settings['transition_speed'] : 1000,
            'nav'                  => ($settings['arrows'] == 'yes') ? true : false,
            'pag'                  => ($settings['dots'] == 'yes') ? true : false,
            'loop'                 => ($settings['infinite'] == 'yes') ? true : false,
            'rows'                 => $settings['rows'] ? (int) $settings['rows'] : 1, 
			
		); 

		$products = amino_products($atts);


		return $products;  
	}  
	protected function render() {

		echo $this->rt_get_products();  

		// Reset the post data to prevent conflicts with WP globals
		wp_reset_postdata(); ?> 

	<?php
	}

}