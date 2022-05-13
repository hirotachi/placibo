<?php
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
add_action( 'cmb2_admin_init', 'amino_register_taxonomy_product' );
function amino_register_taxonomy_product() {
	$cmb_term = new_cmb2_box( array(
		'id'               => 'amino_product_general',
		'title'            => esc_html__( 'Product options', 'amino' ),
		'object_types'     => array( 'product' ), 
		'priority'    	   => 'low',
	) );
	$cmb_term->add_field( array(
	    'name' => esc_html__( 'PRODUCT LABEL', 'amino' ),
	    'desc' => '',
	    'type' => 'title',
	    'id'   => 'rtproduct_title1'
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Label', 'amino' ),
		'desc' => esc_html__( 'Add specific label for this product. It makes this product highlight', 'amino' ),
		'id'   => 'product_label',
		'type' => 'text_medium'
	) );
	$cmb_term->add_field( array(
	    'name'    => esc_html__( 'Label position', 'amino' ),
	    'id'      => 'product_label_position',
	    'type'    => 'radio_inline',
	    'options' => array(
	        'left' => esc_html__( 'Left', 'amino' ),
	        'right'   => esc_html__( 'Right', 'amino' ),
	    ),
	    'default' => 'left',
	) );
	$cmb_term->add_field( array(
	    'name'    => esc_html__( 'Label background', 'amino' ),
	    'id'      => 'product_label_bground',
	    'type'    => 'colorpicker',
	) );
	$cmb_term->add_field(array(	
	    'name' => esc_html__('Product label design', 'amino'),
	    'desc' => esc_html__('Select your design', 'amino'),
	    'id'      => 'product_label_design',
	    'type' => 'image_select',
	    'options' => array(
	        'circle' => array('title' => 'Circle', 'alt' => 'circle', 'img' => get_template_directory_uri().'/assets/images/customizer/label-1.jpg'),
	        'rectangle' => array('title' => 'Rectangle', 'alt' => 'rectangle', 'img' => get_template_directory_uri().'/assets/images/customizer/label-2.jpg'),
	        'elip' => array('title' => 'Elip', 'alt' => 'elip', 'img' => get_template_directory_uri().'/assets/images/customizer/label-3.jpg'),
	        'trapezium' => array('title' => 'Trapezium', 'alt' => 'trapezium', 'img' => get_template_directory_uri().'/assets/images/customizer/label-4.jpg'),
	    ),
	    'default' => 'circle',    
	) );
	$cmb_term->add_field( array(
	    'name'    => esc_html__( 'Image label', 'amino' ),
	    'desc'    => 'Upload your image label. Then label text will shown when hover on label image.',
	    'id'      => 'product_label_image',
	    'type'    => 'file',
	    // Optional:
	    'options' => array(
	        'url' => false, // Hide the text input for the url
	    ),
	    'preview_size' => 'small', // Image size to use when previewing in the admin.
	) );
	$cmb_term->add_field( array(
	    'name' => esc_html__( 'VARIATION SWATCHES', 'amino' ),
	    'desc' => '',
	    'type' => 'title',
	    'id'   => 'rtproduct_title2'
	) );
	$cmb_term->add_field( array(
	    'name'             => esc_html__( 'Replace main attribute by image', 'amino' ),
	    'id'               => 'rtproduct_replace_image',
	    'type'             => 'radio',
	    'desc' => esc_html__('Default: use Customize settings ( Customize > Woocommerce > Variant Swatches )', 'amino'),
	    'default' => 'default',    
	    'options'          => array(
	        'default' => esc_html__( 'Default', 'amino' ),
	        'yes'   => esc_html__( 'Yes', 'amino' ),
	        'no'     => esc_html__( 'No', 'amino' ),
	    ),
	) );
	$cmb_term->add_field( array(
	    'name' => esc_html__( 'HOVER SECOND IMAGE', 'amino' ),
	    'desc' => '',
	    'type' => 'title',
	    'id'   => 'rtproduct_title3'
	) );
	$cmb_term->add_field( array(
	    'name'             => esc_html__( 'Active second image when hover for this product', 'amino' ),
	    'id'               => 'rtproduct_hover_image',
	    'type'             => 'radio',
	    'desc' => esc_html__('Default: get setting in Customize > Woocommerce > Catalog > Active hover image', 'amino'),
	    'default' => 'default',    
	    'options'          => array(
	        'default' => esc_html__( 'Default', 'amino' ),
	        'yes'   => esc_html__( 'Yes', 'amino' ),
	        'no'     => esc_html__( 'No', 'amino' ),
	    ),
	) );
	$cmb_term = new_cmb2_box( array(
		'id'               => 'amino_product_page',
		'title'            => esc_html__( 'Product Page', 'amino' ),
		'object_types'     => array( 'product' ), 
		'priority'    	   => 'low',
	) );
	$cmb_term->add_field(array(	
	    'name' => esc_html__('Product page layout', 'amino'),
	    'desc' => esc_html__('Using different layout for this product', 'amino'),
	    'id'      => 'product_custom_layout',
	    'type' => 'image_select',
	    'options' => array(
	        'default' => array('title' => 'Default', 'alt' => 'default', 'img' => get_template_directory_uri().'/assets/images/customizer/single-product1.jpg'),
	        'simple' => array('title' => 'Simple', 'alt' => 'simple', 'img' => get_template_directory_uri().'/assets/images/customizer/single-product1.jpg'),
	        'fulltop' => array('title' => 'Images top', 'alt' => 'images-top', 'img' => get_template_directory_uri().'/assets/images/customizer/single-product2.jpg'),
	        'fullleft' => array('title' => 'Full width', 'alt' => 'full-width', 'img' => get_template_directory_uri().'/assets/images/customizer/single-product3.jpg'),
	        'vertical' => array('title' => 'Vertical Thumbnails', 'alt' => 'vertical-thumbnails', 'img' => get_template_directory_uri().'/assets/images/customizer/single-product4.jpg'),
	        'grid' => array('title' => 'Grid Images', 'alt' => 'grid-images', 'img' => get_template_directory_uri().'/assets/images/customizer/single-product5.jpg'),
	    ),
	    'default' => 'default',    
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Additional tab title', 'amino' ),
		'desc' => esc_html__( 'Add specific tab in product page', 'amino' ),
		'id'   => 'product_tab_title',
		'type' => 'text_medium'
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Additional tab content', 'amino' ),
		'desc' => esc_html__( 'Add specific tab in product page. Allow using HTML and shortcode', 'amino' ),
		'id'   => 'product_tab_content',
		'type' => 'textarea'
	) );
}
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
add_action( 'cmb2_admin_init', 'amino_register_video_product' );
function amino_register_video_product() {
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => 'amino_product_video',
		'title'            => esc_html__( 'Product video', 'amino' ),
		'object_types'     => array( 'product' ), 
		'priority'    	   => 'low',
		'context'          => 'side',
	) );
	$cmb_term->add_field( array(
		'name'    => esc_html__('Upload your video', 'amino' ),
		'desc'    => esc_html__('Allow mp4 , OGG and WEBM format. The video will be inline to product images', 'amino' ),
		'id'      => 'product_video_upload',
		'type'    => 'file',
		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => esc_html__('Add File', 'amino' )// Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		'query_args' => array(
			'type' => 'video', // Make library only display PDFs.
		),
		'preview_size' => 'large', // Image size to use when previewing in the admin.
	) );
	$cmb_term->add_field( array(
		'name' => '',
		'desc' => esc_html__('Autoplay video when display', 'amino' ),
		'id'   => 'product_video_autoplay',
		'type' => 'checkbox',
	) );
	$cmb_term->add_field( array(
	    'name'             => esc_html__('Video position', 'amino' ),
	    'id'               => 'product_video_position',
	    'type'             => 'select',
	    'default'          => 'last',
	    'options'          => array(
	        'first' => esc_html__( 'First - Before all images', 'amino' ),
	        'second'   => esc_html__( 'Second - After main image', 'amino' ),
	        'last'     => esc_html__( 'Last - After all images', 'amino' ),
	    ),
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__('Video URL', 'amino' ),
		'desc' => esc_html__('Add youtube/Vimeo video URL. You have to click video button to show it in product page.', 'amino' ),
		'default' => '',
		'id' => 'product_video',
		'type' => 'textarea_small',
		'sanitization_cb' => false,
	) );
}
/**
 * Add new types for attributes
 */
add_filter( 'product_attributes_type_selector', 'amino_add_new_attribute_types');
function amino_add_new_attribute_types(){
	$types = array(
		'select' => esc_html__( 'Select', 'amino' ),
		'color' => esc_html__( 'Color or texture', 'amino' ),
		'label' => esc_html__( 'Label', 'amino' ),
	);
	return $types;
}
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
add_action( 'cmb2_admin_init', 'amino_register_taxonomy_attribute' );
function amino_register_taxonomy_attribute() {
	if(isset($_REQUEST['taxonomy']) && $_REQUEST['taxonomy'] == 'pa_color') {
		$attribute = get_tax_attribute($_REQUEST['taxonomy']);
		/**
		 * Metabox to add fields to categories and tags
		 */
		if($attribute->attribute_type == 'color'){
			$cmb_term = new_cmb2_box(
 array(
				'id'               => 'amino_attribute_edit',
				'title'            => esc_html__( 'Category Metabox', 'amino' ),
				'object_types'     => array( 'term' ), 
				'taxonomies'       => array( $_REQUEST['taxonomy'] ), 
			) );
			$cmb_term->add_field( array(
				'name'    => esc_html__( 'Color', 'amino' ),
				'id'      => 'term-color',
				'type'    => 'colorpicker',
				'default' => '',
			) );
			$cmb_term->add_field( array(
				'name'    => esc_html__( 'Image', 'amino' ),
				'desc'    => esc_html__( 'The image will override the color. Recommended image size: 30x30 pixels', 'amino' ),
				'id'      => 'term-image',
				'type'    => 'file',
				'options' => array(
					'url' => true, 
				),
				'text'    => array(
					'add_upload_file_text' => esc_html__( 'Add File', 'amino' ) ,
				),
				'query_args' => array(
					'type' => array(
						'image/gif',
						'image/jpeg',
						'image/png',
					),
				),
				'preview_size' => 'small',
			) );
		}
	}
}
/**
 * Get attribute's properties
 *
 * @param string $taxonomy
 *
 * @return object
 */
function get_tax_attribute( $taxonomy ) {
	global $wpdb;
	$attr = substr( $taxonomy, 3 );
	$attr = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '%s'", $attr));
	return $attr;
}
add_action( 'woocommerce_product_option_terms', 'product_option_terms', 10, 2 );
function product_option_terms( $taxonomy, $index ) {
	if ($taxonomy->attribute_type == 'select' ) {
		return;
	}
	$taxonomy_name = wc_attribute_taxonomy_name( $taxonomy->attribute_name );
	global $thepostid;
	$product_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : $thepostid;
	?>
	<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'amino' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr($index); ?>][]">
		<?php
		$all_terms = get_terms( $taxonomy_name, apply_filters( 'woocommerce_product_attribute_terms', array( 'orderby' => 'name', 'hide_empty' => false ) ) );
		if ( $all_terms ) {
			foreach ( $all_terms as $term ) {
				echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy_name, $product_id ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
			}
		}
		?>
	</select>
	<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'amino' ); ?></button>
	<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'amino' ); ?></button>
	<button class="button fr plus tawcvs_add_new_attribute" data-type="<?php echo esc_attr($taxonomy->attribute_type) ?>"><?php esc_html_e( 'Add new', 'amino' ); ?></button>
	<?php
}
add_action( 'cmb2_admin_init', 'amino_register_taxonomy_woo_category' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function amino_register_taxonomy_woo_category() {
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => 'amino_woo_category',
		'title'            => esc_html__( 'Category Metabox', 'amino' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'product_cat'), // Tells CMB2 which taxonomies should have these fields
		'new_term_section' => true, // Will display in the "Add New Category" section
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Image for category heading', 'amino' ),
		'desc' => esc_html__( 'field description (optional)', 'amino' ),
		'id'   => 'woo_category_image_heading',
		'type' => 'file',
	) );
	$cmb_term->add_field( array(
		'name' => esc_html__( 'Image for categories navigation on the shop page', 'amino' ),
		'desc' => esc_html__( 'Use for subcategories slider in shop/category page.', 'amino' ),
		'id'   => 'woo_category_image_nav',
		'type' => 'file',
	) );
	$cmb_term->add_field( array(
	    'name'             => esc_html__( 'Show subcategories', 'amino' ),
	    'id'               => 'woo_category_sub',
	    'type'             => 'radio',
	    'desc' => esc_html__('Default: use Customize settings ( Customize > Woocommerce > Catalog product )', 'amino'),
	    'default' => 'default',    
	    'options'          => array(
	        'default' => esc_html__( 'Default', 'amino' ),
	        'yes'   => esc_html__( 'Yes', 'amino' ),
	        'no'     => esc_html__( 'No', 'amino' ),
	    ),
	) );
}