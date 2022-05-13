<?php
class Amino_Widget_Social extends WP_Widget { 
	function __construct() {
		$widget_ops = array( 'classname' => 'social_widget', 'description' => __('A widget displays social links with icon ', 'amino'), 'customize_selective_refresh' => true);
		$control_ops = array('id_base' => 'social_widget' );
		parent::__construct( 'social_widget', __('Amino Social icons', 'amino'), $widget_ops, $control_ops );
	}
	function widget($args, $instance) {
		$cache = wp_cache_get('social_widget', 'widget');
		if ( !is_array($cache) )
			$cache = array();
		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		ob_start();
		extract($args);
		echo $before_widget;
		if (!empty($instance['title']) ) echo $before_title . $instance['title'] . $after_title;
		$social_list = amino_social_list(); echo esc_attr($social_list);
		echo $after_widget;
		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('social_widget', $cache, 'widget');
	}
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$this->flush_widget_cache();
		return $instance;
	}
	function flush_widget_cache() {
		wp_cache_delete('social_widget', 'widget');
	}
	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'amino' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p class="wdg-des"><?php echo  __('The social list configuration in Customize > Social.', 'amino'); ?></p>
	<?php
	}
}
// register widget
if (!function_exists('amino_register_social_widget')) {
	function amino_register_social_widget() {
		register_widget('Amino_Widget_Social');
	}
	add_action('widgets_init', 'amino_register_social_widget');
}