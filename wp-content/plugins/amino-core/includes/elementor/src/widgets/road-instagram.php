<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;

class Road_Instagram_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve image widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rt_instagram';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve image widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'RT Instagram', 'roadthemes' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the image widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'roadthemes-category' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'instagram', 'social' ];
	}

	/**
	 * Register image widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_general',
			[
				'label' => __( 'General', 'elementor' ),
			]
		);
		$this->add_control(
			'limit',
			[
				'label' => __( 'Number of picture', 'roadthemes' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 10,
			]
		);
		$this->add_control(
			'image_type',
			[
				'label' => __( 'Image type', 'roadthemes' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'square',
				'options' => [
					'square'  => __( 'Square', 'roadthemes' ),
					'origin' => __( 'Origin size', 'roadthemes' ),
				],
			]
		);

		$this->end_controls_section();
		//Slider Setting
		$this->start_controls_section(
			'slider_section',
			[
				'label' => __( 'Slider configurations', 'roadthemes' ),
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
						'items!' => '1',
					],
					'frontend_available' => true,
				]
			); 
			$this->add_responsive_control(
				'space',
				[
					'label' => __( 'Space between items', 'roadthemes' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 5,
					],
					'selectors' => [
						'{{WRAPPER}} .slick-list .slick-slide' => 'padding: 0 {{SIZE}}{{UNIT}};',
					],
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
					'default' 		=> 'yes',
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

	protected function render() {
		$settings = $this->get_settings_for_display();
		$instagram_infos = $this->rt_get_instagram_info();

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
			'data', 
			[
				'class' => ['rt-instagram-feed', 'slick-slider-block', 'column-desktop-'. $responsive['xl'],'column-tablet-'. $responsive['md'],'column-mobile-'. $responsive['xs']],
				'data-slick-options' => wp_json_encode($slick_options),
				'data-slick-responsive' => wp_json_encode($slick_responsive),
			]
			
		);
		$user_name = $this->get_instagram_user_name();
		?>
		<div class="instagram-block">
			<?php
			if(!isset($instagram_infos['error'])) :
				if(!empty($instagram_infos)) :
				?>
					<div <?php echo $this->get_render_attribute_string('data'); ?>>
						<?php foreach($instagram_infos as $info): ?>
							<?php if($info['media_type'] == 'IMAGE') : ?>
								<div>
									<?php if($settings['image_type'] == 'origin'): ?>
										<a href="<?php echo $info['permalink']; ?>" target="_blank"><img src="<?php echo $info['media_url']; ?>" /></a>
									<?php else :
										$style = 'background-image: url(' . esc_url($info['media_url']) . '); background-size: cover; background-position: center center; background-repeat: no-repeat; width:100%;height: 100%;display:block;padding-top:100%;';
										?>
										<a href="<?php echo $info['permalink']; ?>" target="_blank" style="<?php echo $style; ?>">
											<img src="<?php echo $info['media_url']; ?>" /></a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="button-follow">
						<a href="https://www.instagram.com/<?php echo $user_name; ?>/" target="_blank"><?php echo __('Follow on Instagram', 'roadthemes') ?></a>
					</div>
				<?php else : ?>
					<p class="note-error"><?php echo __('There is no image.', 'roadthemes') ?></p>
				<?php endif; ?>
			<?php else : ?>
				<p class="note-error"><?php echo __('Wrong Instagram data.', 'roadthemes') ?></p>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function get_remote_data_from_instagram_in_json($url){
        $content = wp_remote_get( $url );
        if(isset($content->errors)){
            $content = json_encode(array('meta'=>array('error_message'=>$content->errors['http_request_failed']['0'])));
            $content = json_decode($content, true);
            return $content;
        }else{
            $response = wp_remote_retrieve_body( $content );
            $json = json_decode( $response, true );
            return $json;
        }
    }
    protected function rt_get_instagram_info(){
    	$user_id = of_get_option('instagram_user_id', '');
    	$access_token = of_get_option('instagram_access_token', '');
		$url = 'https://graph.instagram.com/'.$user_id.'/media?fields=id,media_type,comments_count,like_count,media_url,permalink&access_token='.$access_token;
		$instagram = $this->get_remote_data_from_instagram_in_json($url);

		if(isset($instagram['error'])) return $instagram;

		$instagram = $instagram['data'];
		
		return $instagram;
	}
	protected function get_instagram_user_name(){
		$user_id = of_get_option('instagram_user_id', '');
		$access_token = of_get_option('instagram_access_token', '');
		$url = 'https://graph.instagram.com/'.$user_id.'/media?fields=username&access_token='.$access_token;
		$instagram = $this->get_remote_data_from_instagram_in_json($url);

		if($instagram['data']) return $instagram['data'][0]['username'];

		return;
	}
}
