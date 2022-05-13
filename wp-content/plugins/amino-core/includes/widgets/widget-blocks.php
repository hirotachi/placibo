<?php
class Amino_Widget_Blocks extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'block_widget', 'description' => __('A widget that displays a Block ', 'amino'), 'customize_selective_refresh' => true);
		$control_ops = array('id_base' => 'block_widget' );
		parent::__construct( 'block_widget', __('Amino Custom Blocks', 'amino'), $widget_ops, $control_ops );
	}
	function widget($args, $instance) {
		$cache = wp_cache_get('block_widget', 'widget');
		if ( !is_array($cache) )
			$cache = array();
		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo esc_attr($cache[ $args['widget_id'] ]);
			return;
		}
		ob_start();
		extract($args);
		echo $before_widget;
		if (!empty($instance['title']) ) echo $before_title . $instance['title'] . $after_title;
		if(!empty($instance['block'])) echo do_shortcode('[custom_block  id="'.$instance['block'].'"]');
		echo $after_widget;
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('block_widget', $cache, 'widget');
	}
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['block'] = ( ! empty( $new_instance['block'] ) ) ? strip_tags( $new_instance['block'] ) : '';
		$this->flush_widget_cache();
		return $instance;
	}
	function flush_widget_cache() {
		wp_cache_delete('block_widget', 'widget');
	}
	function form( $instance ) {
		$blocks = array(false => '-- None --');
		$jscomposer_templates_args = array(
		    'orderby'          => 'title',
		    'order'            => 'ASC',
		    'post_type'        => 'rt_custom_block',
		    'post_status'      => 'publish',
		    'posts_per_page'   => 30,
		);
		$jscomposer_templates = get_posts( $jscomposer_templates_args );
		if(count($jscomposer_templates) > 0) {
		    foreach($jscomposer_templates as $jscomposer_template){
		        $blocks[$jscomposer_template->ID] = $jscomposer_template->post_title;
		    }
		}
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$instance['block'] = isset( $instance['block'] ) ? esc_attr( $instance['block'] ) : '';
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'amino' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'block' )); ?>"><?php _e( 'Block:', 'amino' ); ?></label>
		<select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'block' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'block' )); ?>">
		<?php foreach ($blocks as $key => $value) {
 		   echo '<option '.selected( $instance['block'], $key).' value="'.$key.'">'.$value.'</option>';
 		} ?>
		</select></p>
		<?php
	}
}
// register widget
if (!function_exists('amino_register_custom_blocks_widget')) {
	function amino_register_custom_blocks_widget() {
		register_widget('Amino_Widget_Blocks');
	}
	add_action('widgets_init', 'amino_register_custom_blocks_widget');
}