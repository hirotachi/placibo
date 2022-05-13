<?php 
/**
 *
 * Layerd widget class
 *
 */
class Amino_Widget_Layered_Nav extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'amino_layered_nav', 'description' => __('A widget that displays attribute filter ', 'amino'), 'customize_selective_refresh' => true);
		$control_ops = array( 'id_base' => 'amino_layered_nav' );
		parent::__construct( 'amino_layered_nav', esc_html__('Amino Filter Products By Attribute', 'amino'), $widget_ops, $control_ops );
	}
	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$attribute    = isset( $instance['attribute'] ) ? absint( $instance['attribute'] ) : '';
		$query    = isset( $instance['query'] ) ? absint( $instance['query'] ) : 'and';
		$display    = isset( $instance['display'] ) ? absint( $instance['display'] ) : 'list';
        $attribute_array      = array();
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
			}
		}
		$query_array = array(
			'and' => esc_html__( 'AND', 'amino' ),
			'or'  => esc_html__( 'OR', 'amino' ),
		);
		$display_type_array = array(
			'list' => esc_html__( 'List', 'amino' ),
			'2columns' => esc_html__( '2 Columns', 'amino' ),
			'inline' => esc_html__( 'Inline', 'amino' ),
			'dropdown' => esc_html__( 'Dropdowm', 'amino' ),
			'color' => esc_html__( 'Color or texture', 'amino' ),
		);
		$switch_array = array(
			'on' => esc_html__( 'On', 'amino' ),
			'off'  => esc_html__( 'Off', 'amino' ),
		);
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'amino' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'attribute' )); ?>"><?php _e( 'Attribute:', 'amino' ); ?></label>
		<select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'attribute' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'attribute' )); ?>">
			<?php foreach ($attribute_array as $key => $value) {
	 		   echo '<option '.selected( $instance['attribute'], $key).' value="'.$key.'">'.$value.'</option>';
	 		} ?>
		</select></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'query' )); ?>"><?php _e( 'Query type', 'amino' ); ?></label>
		<select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'query' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'query' )); ?>">
			<?php foreach ($query_array as $key => $value) {
	 		   echo '<option '.selected( $instance['query'], $key).' value="'.$key.'">'.$value.'</option>';
	 		} ?>
		</select></p>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'display' )); ?>"><?php _e( 'Display type', 'amino' ); ?></label>
		<select class="widefat" name="<?php echo esc_attr($this->get_field_name( 'display' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'display' )); ?>">
			<?php foreach ($display_type_array as $key => $value) {
	 		   echo '<option '.selected( $instance['display'], $key).' value="'.$key.'">'.$value.'</option>';
	 		} ?>
		</select></p>
<?php
	}
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['attribute'] = ( ! empty( $new_instance['attribute'] ) ) ? strip_tags( $new_instance['attribute'] ) : '';
		$instance['query'] = ( ! empty( $new_instance['query'] ) ) ? strip_tags( $new_instance['query'] ) : '';
		$instance['display'] = ( ! empty( $new_instance['display'] ) ) ? strip_tags( $new_instance['display'] ) : '';
		$this->flush_widget_cache();
		return $instance;
	}
	function flush_widget_cache() {
		wp_cache_delete('amino_layered_nav', 'widget');
	}
	function widget($args, $instance) {
		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}
		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : '';
		$query_type         = isset( $instance['query'] ) ? $instance['query'] : 'and';
		$display_type	  		= isset( $instance['display'] ) ? $instance['display'] : 'list';;
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return;
		}
		$terms = get_terms( $taxonomy, array( 'hide_empty' => '1' ) );
		if ( 0 === count( $terms ) ) {
			return;
		}
		ob_start();
		echo $args['before_widget'];
		if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		if ( 'dropdown' === $display_type ) {
			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_style( 'select2' );
			$found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type );
		} else {
			$found = $this->layered_nav_list( $terms, $taxonomy, $query_type, $instance );
		}
		echo $args['after_widget'];
		// Force found when option is selected - do not force found on taxonomy attributes.
		if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
			$found = true;
		}
		if ( ! $found ) {
			ob_end_clean();
		} else {
			echo ob_get_clean(); // @codingStandardsIgnoreLine
		}
	}
	/**
	 * Get this widgets taxonomy.
	 *
	 * @param array $instance Array of instance options.
	 * @return string
	 */
	protected function get_instance_taxonomy( $instance ) {
		if ( isset( $instance['attribute'] ) ) {
			return wc_attribute_taxonomy_name( $instance['attribute'] );
		}
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( ! empty( $attribute_taxonomies ) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
					return wc_attribute_taxonomy_name( $tax->attribute_name );
				}
			}
		}
		return '';
	}
	protected function get_current_taxonomy() {
		return is_tax() ? get_queried_object()->taxonomy : '';
	}
	/**
	 * Return the currently viewed term ID.
	 *
	 * @return int
	 */
	protected function get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}
	/**
	 * Return the currently viewed term slug.
	 *
	 * @return int
	 */
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}
	/**
	 * Show dropdown layered nav.
	 *
	 * @param  array  $terms Terms.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return bool Will nav display?
	 */
	protected function layered_nav_dropdown( $terms, $taxonomy, $query_type ) {
		global $wp;
		$found = false;
		if ( $taxonomy !== $this->get_current_taxonomy() ) {
			$term_counts          = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
			$_chosen_attributes   = WC_Query::get_layered_nav_chosen_attributes();
			$taxonomy_filter_name = wc_attribute_taxonomy_slug( $taxonomy );
			$taxonomy_label       = wc_attribute_label( $taxonomy );
			/* translators: %s: taxonomy name */
			$any_label      = apply_filters( 'woocommerce_layered_nav_any_label', sprintf( __( 'Any %s', 'woocommerce' ), $taxonomy_label ), $taxonomy_label, $taxonomy );
			$multiple       = 'or' === $query_type;
			$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
			}
			echo '<form method="get" action="' . esc_url( $form_action ) . '" class="woocommerce-widget-layered-nav-dropdown">';
			echo '<select class="woocommerce-widget-layered-nav-dropdown dropdown_layered_nav_' . esc_attr( $taxonomy_filter_name ) . '"' . ( $multiple ? 'multiple="multiple"' : '' ) . '>';
			echo '<option value="">' . esc_html( $any_label ) . '</option>';
			foreach ( $terms as $term ) {
				// If on a term page, skip that term in widget list.
				if ( $term->term_id === $this->get_current_term_id() ) {
					continue;
				}
				// Get count based on current view.
				$option_is_set = in_array( $term->slug, $current_values, true );
				$count         = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;
				// Only show options with count > 0.
				if ( 0 < $count ) {
					$found = true;
				} elseif ( 0 === $count && ! $option_is_set ) {
					continue;
				}
				echo '<option value="' . esc_attr( urldecode( $term->slug ) ) . '" ' . selected( $option_is_set, true, false ) . '>' . esc_html( $term->name ) . '</option>';
			}
			echo '</select>';
			if ( $multiple ) {
				echo '<button class="woocommerce-widget-layered-nav-dropdown__submit" type="submit" value="' . esc_attr__( 'Apply', 'woocommerce' ) . '">' . esc_html__( 'Apply', 'woocommerce' ) . '</button>';
			}
			if ( 'or' === $query_type ) {
				echo '<input type="hidden" name="query_type_' . esc_attr( $taxonomy_filter_name ) . '" value="or" />';
			}
			echo '<input type="hidden" name="filter_' . esc_attr( $taxonomy_filter_name ) . '" value="' . esc_attr( implode( ',', $current_values ) ) . '" />';
			echo wc_query_string_form_fields( null, array( 'filter_' . $taxonomy_filter_name, 'query_type_' . $taxonomy_filter_name ), '', true ); // @codingStandardsIgnoreLine
			echo '</form>';
			wc_enqueue_js(
				"
				// Update value on change.
				jQuery( '.dropdown_layered_nav_" . esc_js( $taxonomy_filter_name ) . "' ).change( function() {
					var slug = jQuery( this ).val();
					jQuery( ':input[name=\"filter_" . esc_js( $taxonomy_filter_name ) . "\"]' ).val( slug );
					// Submit form on change if standard dropdown.
					if ( ! jQuery( this ).attr( 'multiple' ) ) {
						jQuery( this ).closest( 'form' ).submit();
					}
				});
				// Use Select2 enhancement if possible
				if ( jQuery().selectWoo ) {
					var wc_layered_nav_select = function() {
						jQuery( '.dropdown_layered_nav_" . esc_js( $taxonomy_filter_name ) . "' ).selectWoo( {
							placeholder: decodeURIComponent('" . rawurlencode( (string) wp_specialchars_decode( $any_label ) ) . "'),
							minimumResultsForSearch: 5,
							width: '100%',
							allowClear: " . ( $multiple ? 'false' : 'true' ) . ",
							language: {
								noResults: function() {
									return '" . esc_js( _x( 'No matches found', 'enhanced select', 'woocommerce' ) ) . "';
								}
							}
						} );
					};
					wc_layered_nav_select();
				}
			"
			);
		}
		return $found;
	}
	/**
	 * Get current page URL for layered nav items.
	 * @return string
	 */
	protected function get_current_page_url( $taxonomy ) {
		if ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif( is_product_category() ) {
			$link = get_term_link( get_query_var('product_cat'), 'product_cat' );
		} elseif( is_product_tag() ) {
			$link = get_term_link( get_query_var('product_tag'), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}
		// Min/Max
		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
		}
		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
		}
		// Orderby
		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
		}
		/**
		 * Search Arg.
		 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
		 */
		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
		}
		// Post Type Arg
		if ( isset( $_GET['post_type'] ) ) {
			$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
		}
		// Min Rating Arg
		if ( isset( $_GET['min_rating'] ) ) {
			$link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
		}
		// All current filters
		if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
			foreach ( $_chosen_attributes as $name => $data ) {
				if ( $name === $taxonomy ) {
					continue;
				}
				$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' == $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}
		// Start demo
		if ( isset( $_GET['sidebar'] ) ) {
			$link = add_query_arg( 'sidebar', wc_clean( $_GET['sidebar'] ), $link );
		}
		if ( isset( $_GET['filter'] ) ) {
			$link = add_query_arg( 'filter', wc_clean( $_GET['filter'] ), $link );
		}
		// End demo
		return $link;
	}
	/**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * This query allows counts to be generated based on the viewed products, not all products.
	 *
	 * @param  array  $term_ids Term IDs.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;
		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();
		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}
		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );
		// Generate query.
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];
		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'"
			. $tax_query_sql['where'] . $meta_query_sql['where'] .
			'AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')';
		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$query['where'] .= ' AND ' . $search;
		}
		$query['group_by'] = 'GROUP BY terms.term_id';
		$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query             = implode( ' ', $query );
		// We have a query - let's see if cached results of this query already exist.
		$query_hash = md5( $query );
		// Maybe store a transient of the count values.
		$cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
		if ( true === $cache ) {
			$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
		} else {
			$cached_counts = array();
		}
		if ( ! isset( $cached_counts[ $query_hash ] ) ) {
			$results                      = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine
			$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
			$cached_counts[ $query_hash ] = $counts;
			if ( true === $cache ) {
				set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
			}
		}
		return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
	}
	/**
	 * Show list based layered nav.
	 *
	 * @param  array  $terms Terms.
	 * @param  string $taxonomy Taxonomy.
	 * @param  string $query_type Query Type.
	 * @return bool   Will nav display?
	 */
	protected function layered_nav_list( $terms, $taxonomy, $query_type, $instance ) {
		// List display.
		$display	  		= isset( $instance['display'] ) ? $instance['display'] : 'list';
		$class = '';
		$class .= ' swatches-display-' . $display;
		// List display
		echo '<ul class="' . esc_attr( $class ) . '">';
		$term_counts        = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$found              = false;
		foreach ( $terms as $term ) {
			$current_values    = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
			$option_is_set     = in_array( $term->slug, $current_values );
			$count             = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;
			// skip the term for the current archive
			if ( $this->get_current_term_id() === $term->term_id ) {
				continue;
			}
			// Only show options with count > 0
			if ( 0 < $count ) {
				$found = true;
			} elseif ( 0 === $count && ! $option_is_set ) {
				continue;
			}
			$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
			$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
			$current_filter = array_map( 'sanitize_title', $current_filter );
			if ( ! in_array( $term->slug, $current_filter ) ) {
				$current_filter[] = $term->slug;
			}
			$link = $this->get_current_page_url( $taxonomy );
			if ( is_wp_error( $link ) ) $link = '';
			// Add current filters to URL.
			foreach ( $current_filter as $key => $value ) {
				// Exclude query arg for current term archive term
				if ( $value === $this->get_current_term_slug() ) {
					unset( $current_filter[ $key ] );
				}
				// Exclude self so filter can be unset on click.
				if ( $option_is_set && $value === $term->slug ) {
					unset( $current_filter[ $key ] );
				}
			}
			if ( ! empty( $current_filter ) ) {
				$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );
				// Add Query type Arg to URL
				if ( $query_type === 'or' && ! ( 1 === sizeof( $current_filter ) && $option_is_set ) ) {
					$link = add_query_arg( 'query_type_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) ), 'or', $link );
				}
			}
			// Add swatches block
			$swatch_div = $swatch_style = '';
			$swatch_color = get_term_meta( $term->term_id, 'term-color', true );
			$swatch_image = get_term_meta( $term->term_id, 'term-image', true );
			$class = $option_is_set ? 'chosen' : '';
			if( ! empty( $swatch_color ) ) {
				$class .= ' with-swatch-color';
				$swatch_style = 'background-color: ' . $swatch_color .';';
			}
			if( ! empty( $swatch_image ) ) {
				$class .= ' with-swatch-image';
				$swatch_style = 'background-image: url(' . $swatch_image .');';
			}
			if( ! empty( $swatch_style ) ) {
				$swatch_div = '<span style="' . $swatch_style. '">' . esc_html( $term->name ) . '</span>';
			}
			// END swatches customization
			echo '<li class="wc-layered-nav-term ' . esc_attr( $class ) . '"><div class="inner">';
			echo ( $count > 0 || $option_is_set ) ? '<a rel="nofollow" href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '" class="layered-nav-link">' : '<span>';
			echo '<span class="swatch-inner">';
			if ( $swatch_div ) {
				echo '<span class="filter-swatch">'.$swatch_div.'</span>';
			}
			if($display != 'color'){
				echo '<span class="layer-term-name" >' . esc_html( $term->name ) . '</span>';
			} else {
				echo '<span class="layer-term-name" ><span class="layer-term-name-color" style="' . $swatch_style. '"></span>'. esc_html( $term->name ) .'</span>';
			}
			echo '</span>';
			echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';
			if($display != 'color'){
				echo ' <span class="count">' . absint( $count ) . '</span>';
			}
			echo '</div></li>';
		}
		echo '</ul>';
		return $found;
	}
}	
// register widget
if (!function_exists('amino_register_layered_nav_widget')) {
	function amino_register_layered_nav_widget() {
		register_widget('Amino_Widget_Layered_Nav');
	}
	add_action('widgets_init', 'amino_register_layered_nav_widget');
}