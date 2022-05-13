<?php  
use Elementor\Core\Responsive\Responsive; 
class Road_Categories_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_categories';
	}
	public function get_title() {
		return __('RT Categories', 'roadthemes');
	}
	public function get_icon() { 
		return 'eicon-product-categories';
	}
	public function get_categories() {
		return [ 'roadthemes-category' ];
	}
	public function get_script_depends() {
		return [ 'road-categories' ];
	}
	protected function _register_controls() { 
		// Product
		$this->start_controls_section(
			'categories_section',
			[
				'label' => __( 'Categories', 'roadthemes' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'categories',
				[
					'label' 		=> __('Select categories', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SELECT2,
					'default' 		=> '',
					'label_block'   => true,
					'options' 		=> [
						'0' => __( 'All Categories', 'roadthemes' ),
					]+ $this->road_get_list_categories(), 
					'multiple' => true,
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
							'class' => 'width-30'
						],
						'2' => [
							'title' => __( 'Design 2', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/list.jpg',
							'class' => 'width-30'
						],
						'3' => [
							'title' => __( 'Design 2', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/list-simple.jpg',
							'class' => 'width-30'
						],
					],
					'default' => '1',
					'show_label' => false,
				]
			);
			$this->add_control(
				'show_count',
				[
					'label' 		=> __('Show Count Products', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> '', 
				]
			);
			$this->add_control(
				'show_subcategories',
				[
					'label' 		=> __('Show Subcategories', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> '', 
				]
			);
			$this->add_control(
				'limit_subcategories',
				[
					'label' => __( 'Limit subcategories', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 10,
					'step' => 1,
					'default' => 3,
					'condition'    	=> [
						'show_subcategories' => 'yes',
					],
				]
			);
			$this->add_control(
				'hide_empty',
				[
					'label' 		=> __('Hide Empty Subcategories', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> '', 
					'condition'    	=> [
						'show_subcategories' => 'yes',
					],
				]
			);
			$this->add_control(
				'show_link',
				[
					'label' 		=> __('Show Link View', 'roadthemes'),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> '', 
				]
			);
		$this->end_controls_section(); 
		//Slider Setting
		$this->start_controls_section(
			'setting_section',
			[
				'label' => __( 'Slider configurations', 'roadthemes' ),
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
					'default' => 'no',  
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
					'default'  	 	=> 1000,
				]
			);
		$this->end_controls_section();
	}
	public function road_get_list_categories() { 
		$options = array(); 
		$terms    = get_terms(array( 'taxonomy' => 'product_cat' )); 
		foreach ($terms as $term) {  
			$options[$term->term_id] = array($term->name);
		}    		
		return $options; 
	} 
	protected function render() {
		$settings = $this->get_settings(); 
		// Data settings
		$slick_options = [
			'slidesToShow'   => ($settings['items']) ? absint($settings['items']) : 4,
			'slidesToScroll' => ($settings['slides_to_scroll']) ? absint($settings['slides_to_scroll']) : 1,
			'autoplay'       => ($settings['autoplay'] == 'yes') ? true : false,
			'autoplaySpeed'  => ($settings['autoplay_speed']) ? absint($settings['autoplay_speed']) : 5000,
			'infinite'       => ($settings['infinite'] == 'yes') ? true : false,
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
			'data', 
			[
				'class' => ['categories-container', 'layout'.$settings['design'], 'slick-slider-block', 'column-desktop-'. $responsive['xl'],'column-tablet-'. $responsive['md'],'column-mobile-'. $responsive['xs']],
				'data-slick-options' => wp_json_encode($slick_options),
				'data-slick-responsive' => wp_json_encode($slick_responsive),
			]
		);
		if(empty($settings['categories'])) return;
		?>
		<div <?php echo $this->get_render_attribute_string('data'); ?>>
			<?php   
				foreach($settings['categories'] as $id_category) {
					$category = get_term($id_category , 'product_cat');
					if( !$category ) continue;
					$category_thumb_id = get_term_meta( $id_category ,'woo_category_image_nav_id', true);
					$category_thumb = wp_get_attachment_image_src($category_thumb_id , 'full');
					$category_link = get_term_link( (int) $id_category, 'product_cat' );
					?>
					<div class="category-item">
						<div class="category-item-inner">
							<?php if($settings['design']=='1' || $settings['design']=='2'){ ?>
							<div class="category-image">
								<?php if(!empty($category_thumb)): ?>
								<a href="<?php echo $category_link; ?>"><img src="<?php echo $category_thumb[0]; ?>" width="<?php echo $category_thumb[1]; ?>" height="<?php echo $category_thumb[2]; ?>" alt=""/></a>
								<?php endif; ?>
							</div>
							<?php } ?>
							<div class="category-content">
								<a class="name" href="<?php echo $category_link; ?>"><?php echo $category->name; ?></a>	
								<?php if($settings['show_count']) { ?>
									<p class="count"><?php esc_html_e( 'Products: ','roadthemes' ) ?><?php echo $category->count; ?></p>
								<?php } ?>
								<?php if($settings['show_subcategories']) { 
									$hide_empty = false;
								if($settings['hide_empty']) {
									$hide_empty = true;
								}
								if(!$settings['limit_subcategories']) {
									$settings['limit_subcategories'] = 3;
								}
								echo $this->rt_get_subcategories($id_category, $hide_empty , $settings['limit_subcategories']);
								}
								if($settings['show_link']) { ?>
									<a class="link" href="<?php echo $category_link; ?>"><?php esc_html_e( 'View all','roadthemes' ) ?></a>
								<?php } ?>
							</div>
						</div>	
					</div>
					<?php
				}
			?> 
		</div> 
		<?php
		// Reset the post data to prevent conflicts with WP globals
		wp_reset_postdata(); ?> 
	<?php
	}
	public function rt_get_subcategories($id_category , $hide_empty , $limit) {
		$subcategories = 
			get_terms([
		        'taxonomy'    => 'product_cat',
		        'hide_empty'  => $hide_empty,
		        'parent'      => $id_category,
		        'number'      => $limit
		    ]);
		if(count($subcategories) > 0) {
			$html = '<ul>';
			foreach($subcategories as $subcategory) { 
				$html .= '<li>';
				$html .= '<a href="'. get_term_link($subcategory->term_id, 'product_cat').'">'.$subcategory->name.'</a>';
				$html .= '</li>';	
			}
			$html .= '</ul>';
			return $html;
		}else{
			return '';
		}
	}
}