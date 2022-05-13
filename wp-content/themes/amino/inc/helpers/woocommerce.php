<?php 
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
	return array(
	'width' => 150,
	'height' => 150,
	'crop' => 0,
	);
} );
/*
 * Add to cart ajax
 */
if( ! function_exists( 'amino_ajax_add_to_cart' ) ) {
	function amino_ajax_add_to_cart() {

		// Get messages
		ob_start();

		wc_print_notices();

		$notices = ob_get_clean();


		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}
	add_action( 'wp_ajax_amino_ajax_add_to_cart', 'amino_ajax_add_to_cart' );
	add_action( 'wp_ajax_nopriv_amino_ajax_add_to_cart', 'amino_ajax_add_to_cart' );
}

/*
 * Add sale date to data for a variation
 */
add_filter('woocommerce_available_variation', 'amino_woo_available_variation');
function amino_woo_available_variation($variation){
    
    if (!isset($variation['sale_time'])) {
        $time_from = get_post_meta($variation['variation_id'], '_sale_price_dates_from', true);
        $time_to = get_post_meta($variation['variation_id'], '_sale_price_dates_to', true);

        $arrayTime = array();
        if ($time_to) {
            $arrayTime['to'] = $time_to * 1000;
        }
        
        if ($time_from) {
            $arrayTime['from'] = $time_from * 1000;
        }
        
        $variation['sale_time'] = $arrayTime ? $arrayTime : false;
    }

    return $variation;
}

/*
 * Popup login/register ajax
 */

add_action( 'wp_ajax_nopriv_ajaxlogin', 'amino_ajax_login' );
add_action( 'wp_ajax_ajaxlogin', 'amino_ajax_login' );
function amino_ajax_login(){
	
	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'woocommerce-login', 'woocommerce-login-nonce' );

	
	if ( ! empty( $_POST['username'] ) && ! empty( $_POST['password'] ) ) {
		// Nonce is checked, get the POST data and sign user on
		$info = array();
		$info['user_login'] = wc_clean($_POST['username']);
		$info['user_password'] = $_POST['password'];
		$info['remember'] = false;
		if( isset($_POST['rememberme'])){
			$info['remember'] = true;
		}						
		
		$user_signon = wp_signon( $info, false );			
		if ( is_wp_error($user_signon) ){
			
			$invalid_username = $user_signon->errors['invalid_username'];
			$incorrect_password = $user_signon->errors['incorrect_password'];
			if($invalid_username || $incorrect_password){
				$error = true;
			}
			echo json_encode(array(
							'loggedin'=>false, 
							'message'=>__('Your email/password is incorrect. Please try again.','amino'),
							'error'=> $error,
							));
		} else {
			// hook after successfull login
			do_action( "rt_after_login", $user_signon );
			$args = array(
				'loggedin'	=> true,
				'message'	=> esc_html__( 'Login successful, redirecting...', 'amino' ),
				'redirect'	=> apply_filters( "rt_login_redirect", false)
			);	
				
			echo json_encode( $args );
		}
		die();
	} else{
		echo json_encode(array('loggedin'=>false, 'message'=>__('Please fill all required fields.','amino')));
		die();
	}
}

add_action( 'wp_ajax_nopriv_ajaxregister', 'amino_ajax_register' );
add_action( 'wp_ajax_ajaxregister', 'amino_ajax_register' );
function amino_ajax_register(){
	$redirect = amino_get_option('he_account_reg_redirect','');
	if($redirect) {
		$reg_redirect = get_page_link(amino_get_option('he_account_reg_redirect',''));
	}else{
		$reg_redirect = false;
	}
	
	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'woocommerce-register', 'woocommerce-register-nonce' );
	
	
	$generate_password = get_option( 'woocommerce_registration_generate_password' );
	//echo $generate_password;exit;
	if ( ! empty( $_POST['email'] ) && ! empty( $_POST['password'] ) ) {
		$username = 'no' === get_option( 'woocommerce_registration_generate_username' ) ? $_POST['username'] : '';
		$password = 'no' === get_option( 'woocommerce_registration_generate_password' ) ? $_POST['password'] : '';
		$email    = $_POST['email'];
	
		$validation_error = new WP_Error();
		$validation_error = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );
	
		if ( $validation_error->get_error_code() ) {
			//throw new Exception( $validation_error->get_error_message() );
			$error_array = array(
				'code' => $validation_error->get_error_code(),
				'message' => $validation_error->get_error_message()
			);
		} else {
			$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );
			if ( is_wp_error( $new_customer ) ) {
				$error_array = array(
					'code' => $new_customer->get_error_code(),
					'message' => $new_customer->get_error_message()
				);
			} else {
				if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
					wc_set_customer_auth_cookie( $new_customer );
				}
				
				$args = array(
					'code'		=> 200,
					'message'	=>__( 'Account created successfully. redirecting...', 'amino' ),
					'redirect'	=> apply_filters( "rt_register_redirect", $reg_redirect )
				);
				apply_filters( "rt_register_user_successful", false );
				echo json_encode( $args );die();
			}
		}
	} 
	elseif($generate_password == 'yes'){
		if ( empty( $_POST['email']) ){
			$error_array = array(
				'code' => 'error',
				'message' => esc_html__('Please fill all required fields.','amino')
			);
		} else{
			$username = 'no' === get_option( 'woocommerce_registration_generate_username' ) ? $_POST['username'] : '';				
			$email    = $_POST['email'];					
			$validation_error = new WP_Error();
			$validation_error = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );
	
			if ( $validation_error->get_error_code() ) {
				//throw new Exception( $validation_error->get_error_message() );
				$error_array = array(
					'code' => $validation_error->get_error_code(),
					'message' => $validation_error->get_error_message()
				);
			} else {
				$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ));
				if ( is_wp_error( $new_customer ) ) {
					$error_array = array(
						'code' => $new_customer->get_error_code(),
						'message' => $new_customer->get_error_message()
					);
				} else {
					if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
						wc_set_customer_auth_cookie( $new_customer );
					}
					
					$args = array(
						'code'		=> 200,
						'message'	=> esc_html__( 'Account created successfully. redirecting...', 'amino' ),
						'redirect'	=> apply_filters( "rt_register_redirect", false )
					);
					echo json_encode( $args );die();
				}
			}
		}
	}	
	else {
		$error_array = array(
			'code' => 'error',
			'message' => esc_html__('Please fill all required fields.','amino')
		);
	}
	echo json_encode($error_array);
	die();
}

/*
 * Elementor : Ajax product tabs
 */

add_action( 'wp_ajax_amino_ajax_tab_content', 'amino_ajax_tab_content');
add_action( 'wp_ajax_nopriv_amino_ajax_tab_content', 'amino_ajax_tab_content');
function amino_ajax_tab_content(){
	check_ajax_referer( 'ajax-tab-nonce', 'ajaxtab_nonce' );
	if( ! empty( $_POST['attr'] ) ) {
		$data = '<div id="rt-tab-content-'. $_POST['id_tab'] .'" class="rt-tab-panel opened">';
		$data .= amino_products($_POST['attr']);
		$data .= '</div>';
		echo json_encode($data);
		die();
	}
	
}