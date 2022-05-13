<?php  
use Elementor\Core\Responsive\Responsive; 
class Road_Sale_Products_Widget extends \Elementor\Widget_Base { 
	public function get_name() {
		return 'rt_sale_products';
	}
	public function get_title() {
		return __('RT Sale Products', 'roadthemes');
	}
	public function get_icon() { 
		return 'eicon-product-price';
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
					'description' => __( 'Select resource', 'roadthemes' ),
					'options' => [
						'onsale_products' => __( 'All sale Products', 'roadthemes' ),
						'select_products' => __( 'Select sale Products', 'roadthemes' ), 
					] ,
					'default' => 'onsale_products',
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
					'condition'    	=> [
						'product_type!' => 'select_products',
					],
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
						'design1' => [
							'title' => __( 'Grid', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/sale_product_1.jpg',
							'class' => 'width-50'
						],
						'design2' => [
							'title' => __( 'CentLister', 'roadthemes' ),
							'image' => get_template_directory_uri() . '/assets/images/elementor/sale_product_2.jpg',
							'class' => 'width-50'
						],
					],
					'default' => 'design1',
					'show_label' => false,
				]
			);
			$this->add_control(
				'show_stock',
				[
					'label' => __( 'Show product Stock', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'roadthemes' ),
					'label_off' => __( 'Hide', 'roadthemes' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);
			$this->add_control(
				'show_des',
				[
					'label' => __( 'Show description', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'roadthemes' ),
					'label_off' => __( 'Hide', 'roadthemes' ),
					'return_value' => 'yes',
					'default' => 'yes',
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
	public function rt_get_list_products() { 
		$options = array();
		$loop    = new WP_Query(array(
			'post_type'      => 'product',
			'posts_per_page' => 99,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => '_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				),
				array(
					'key'     => '_sale_price_dates_from',
					'value'   => strtotime( date( 'Y-m-d H:i:s' ) ),
					'compare' => '<',
					'type'    => 'numeric'
				),
				array(
					'key'     => '_sale_price_dates_to',
					'value'   => strtotime( date( 'Y-m-d H:i:s' ) ),
					'compare' => '>',
					'type'    => 'numeric'
				),
			)
		) ); 
		while ($loop->have_posts()) : $loop->the_post();
			global $product;
			$options[$product->get_id()] = array(
				$product->get_name().' (#'.$product->get_id().')'
			);
		endwhile;
		return $options; 
	}
	public function rt_get_all_onsale_products() {
		$options = array();
		$loop    = new WP_Query(array(
			'post_type'      => 'product',
			'posts_per_page' => 99,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => '_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				),
				array(
					'key'     => '_sale_price_dates_from',
					'value'   => strtotime( date( 'Y-m-d H:i:s' ) ),
					'compare' => '<',
					'type'    => 'numeric'
				),
				array(
					'key'     => '_sale_price_dates_to',
					'value'   => strtotime( date( 'Y-m-d H:i:s' ) ),
					'compare' => '>',
					'type'    => 'numeric'
				),
			)
		) ); 
		while ($loop->have_posts()) : $loop->the_post();
			global $product;
			$options[] = $product->get_id();
		endwhile;
		return $options; 
	}
	public function rt_get_sale_products() {
		$settings = $this->get_settings(); 
		// Global Query
		$args = array(
			'post_type'            => 'product',
			'post_status' 		   => 'publish',
			'ignore_sticky_posts'  => 1,
			'orderby'              => $settings['orderby'],
			'order'                => $settings['order'],
			'posts_per_page'       => $settings['limit'],
			'meta_query'           => WC()->query->get_meta_query(),
			'tax_query'            => WC()->query->get_tax_query()
		);
		//sale products
		if( isset($settings['product_type']) && $settings['product_type'] == 'onsale_products' ) {
			$args['post__in'] = $this->rt_get_all_onsale_products();
		}
		//product select
		if( $settings['product_type'] == 'select_products' && $settings['selected_products']) {
			$args['post__in'] = $settings['selected_products'];          
		}
		$products = new WP_Query( $args );
		return $products;  
	}  
	protected function render() {
		$settings = $this->get_settings(); 
		//Enable Slider 
		$enable_slider = $settings['enable_slider'];
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
    	if($enable_slider == 'yes') {
			$this->add_render_attribute(
				'data', 
				[
					'class' => ['sale-products-container', 'slick-slider-block','woocommerce' , 'column-desktop-'. $responsive['xl'],'column-tablet-'. $responsive['md'],'column-mobile-'. $responsive['xs']],
					'data-slick-options' => wp_json_encode($slick_options),
					'data-slick-responsive' => wp_json_encode($slick_responsive),
				]
			);
		} else {
			$this->add_render_attribute(
				'data', 
				[
					'class' => ['sale-products-container'], 
				]
			);
		} 
		$products = $this->rt_get_sale_products();
		?>
		<div class="product-widget sale-products">
			<div <?php echo $this->get_render_attribute_string('data'); ?>>
				<?php if ( $products->have_posts() ) :
					while ( $products->have_posts() ) :
						$products->the_post(); 
						$id = get_the_ID();
						$product = wc_get_product( $id );
						$image_class = '';
						$product_label = get_post_meta($product->get_id() , 'product_label');
						$show_second_image = get_theme_mod('catalog_product_hover', true);
						$show_quickview = get_theme_mod('catalog_product_quickview', true);
						$show_category = get_theme_mod('catalog_product_category', true);
						$show_rating = get_theme_mod('catalog_product_rating', true);
						$show_des = $settings['show_des'];
						$show_stock = $settings['show_stock'];
						$short_description = $product->get_short_description();
						if($settings['product_display'] == 'design1'): ?>
							<div class="design-1">
								<div class="product-inner">
									<div class="product-image">
										<?php if(isset($product_label) && $product_label) { ?>
											<span class="product-label"><?php echo $product_label[0]; ?></span>
										<?php } ?>
										<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
											<?php
												if ( has_post_thumbnail( $product->get_id() ) ) {   
													echo  get_the_post_thumbnail( $product->get_id(), 'shop_catalog', array( 'class' => $image_class ) );
												} else {
													echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $product->get_id() );
												}
												if($show_second_image){
													echo amino_product_thumbnail_hover($product);
												}
											?>
										</a>
										<?php if($show_quickview): ?>
										<div class="product-quickview">
											<?php echo amino_product_quickview(); ?>
										</div>
										<?php endif; ?>
									</div>
									<div class="product-content">
										<div class="product-rating">
											<?php do_action( 'woocommerce_after_shop_loop_item_rating' ); ?>
										</div>
										<?php if($show_category): ?>
										<div class="product-category">
											<?php echo get_top_category_name(); ?>
										</div>
										<?php endif; ?>
										<div class="product-title">
											<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
										</div>
										<?php 
											if($show_des && $short_description) : ?>
												<div class="product-short-description">
													<?php echo $short_description; // WPCS: XSS ok. ?>
												</div>
											<?php endif;
											if($show_stock) {
												echo amino_product_stock($product); 
											}
										?>
										<?php if(AMINO_SHOW_PRICE): ?>
										<div class="product-price">
											<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
										</div>
										<?php endif; ?>
										<?php amino_product_onsale_countdown(); ?>
										<div class="action-links">
											<ul>
												<?php if(!AMINO_CATALOG_MODE): ?>
												<li class="product-cart">
													<?php woocommerce_template_loop_add_to_cart(); ?>
												</li>
												<?php endif; ?>
												<?php if ( class_exists( 'YITH_WCWL' ) ) : ?>
													<li class="add-to-wishlist"> 
														<?php echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]')); ?>
													</li>
												<?php endif; ?>
												<?php if( class_exists( 'YITH_Woocompare' ) ) : ?>
													<li class="add-to-compare">
														<?php echo do_shortcode('[yith_compare_button product="product"]'); ?>
													</li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						<?php else : ?>
							<div class="design-2">
								<div class="product-inner">
									<div class="product-image">
										<?php if(isset($product_label) && $product_label) { ?>
											<span class="product-label"><?php echo $product_label[0]; ?></span>
										<?php } ?>
										<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
											<?php
												if ( has_post_thumbnail( $product->get_id() ) ) {   
													echo  get_the_post_thumbnail( $product->get_id(), 'shop_catalog', array( 'class' => $image_class ) );
												} else {
													echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $product->get_id() );
												}
												if($show_second_image){
													echo amino_product_thumbnail_hover($product);
												}
											?>
										</a>
										<?php if($show_quickview): ?>
										<div class="product-quickview">
											<?php echo amino_product_quickview(); ?>
										</div>
										<?php endif; ?>
										<?php  amino_product_onsale_countdown(); ?>
									</div>
									<div class="product-content">
										<?php if($show_category): ?>
										<div class="product-category">
											<?php echo get_top_category_name(); ?>
										</div>
										<?php endif; ?>
										<div class="product-title">
											<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
										</div>
										<div class="product-rating">
											<?php do_action( 'woocommerce_after_shop_loop_item_rating' ); ?>
										</div>
										<?php if(AMINO_SHOW_PRICE): ?>
										<div class="product-price">
											<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
										</div>
										<?php endif; ?>
										<?php 
											if($show_des && $short_description) : ?>
												<div class="product-short-description">
													<?php echo $short_description; // WPCS: XSS ok. ?>
												</div>
											<?php endif;
											if($show_stock) {
												echo amino_product_stock($product); 
											}
										?>
										<div class="action-links">
											<ul>
												<?php if(!AMINO_CATALOG_MODE): ?>
												<li class="product-cart">
													<?php woocommerce_template_loop_add_to_cart(); ?>
												</li>
												<?php endif; ?>
												<?php if ( class_exists( 'YITH_WCWL' ) ) : ?>
													<li class="add-to-wishlist"> 
														<?php echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]')); ?>
													</li>
												<?php endif; ?>
												<?php if( class_exists( 'YITH_Woocompare' ) ) : ?>
													<li class="add-to-compare">
														<?php echo do_shortcode('[yith_compare_button product="product"]'); ?>
													</li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php
		// Reset the post data to prevent conflicts with WP globals
		wp_reset_postdata(); ?> 
	<?php
	}
}