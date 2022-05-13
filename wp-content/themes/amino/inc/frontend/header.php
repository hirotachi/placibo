<?php	
/*
 *  Header
 */
function amino_header(){	
    $header_layout = amino_get_option('header_layout', '1');
    $header_mobile_layout = amino_get_option('header_mobile_layout', '1'); 
    $page_header_layout = get_post_meta( get_the_ID(), 'page_custom_header', '1' );
    $args = array(
        'vertical_menu' => amino_get_option('vertical_menu_active', false)
    );
    if(isset($page_header_layout) && $page_header_layout && $page_header_layout != 'default'){	
        get_template_part( 'template-parts/header/header',$page_header_layout , $args);  
    }else {	
        get_template_part( 'template-parts/header/header',$header_layout, $args);	
    }	
    get_template_part( 'template-parts/header/header-mobile', $header_mobile_layout, $args);  
    if(true == amino_get_option('quick_links_active', true)) 
        get_template_part( 'template-parts/header/mobile-quick-links');  
}	
/*
 *  Logo
 */
function amino_site_logo( $args = array(), $echo = true ) {
    $logo       = get_custom_logo();
    $site_title = get_bloginfo( 'name' );
	$header_class = 'site-title';
    if(has_custom_logo()) {
        echo amino_the_custom_logo();
    }else{
        if ( is_front_page() && ! is_paged() ) : ?>
            <h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $site_title ); ?></h1>
        <?php elseif ( is_front_page() || is_home() ) : ?>
            <h1 class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $site_title ); ?></a></h1>
        <?php else : ?>
            <p class="<?php echo esc_attr( $header_class ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $site_title ); ?></a></p>
        <?php endif;
    }
}
function amino_the_custom_logo( $blog_id = 0 ) {
    echo amino_get_custom_logo( $blog_id );
}
function amino_get_custom_logo( $blog_id = 0 ) {
    $html          = '';
    $switched_blog = false;
    if ( is_multisite() && ! empty( $blog_id ) && get_current_blog_id() !== (int) $blog_id ) {
        switch_to_blog( $blog_id );
        $switched_blog = true;
    }
    $custom_logo_id = amino_get_option( 'custom_logo' );
    // We have a logo. Logo is go.
    if ( $custom_logo_id ) {
        $custom_logo_attr = array(
            'class'   => 'custom-logo',
            'loading' => false,
        );
        $unlink_homepage_logo = (bool) get_theme_support( 'custom-logo', 'unlink-homepage-logo' );
        if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
            /*
             * If on the home page, set the logo alt attribute to an empty string,
             * as the image is decorative and doesn't need its purpose to be described.
             */
            $custom_logo_attr['alt'] = '';
        } else {
            /*
             * If the logo alt attribute is empty, get the site title and explicitly pass it
             * to the attributes used by wp_get_attachment_image().
             */
            $image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $image_alt ) ) {
                $custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }
        }
        /**
         * Filters the list of custom logo image attributes.
         *
         * @since 5.5.0
         *
         * @param array $custom_logo_attr Custom logo image attributes.
         * @param int   $custom_logo_id   Custom logo attachment ID.
         * @param int   $blog_id          ID of the blog to get the custom logo for.
         */
        $custom_logo_attr = apply_filters( 'get_custom_logo_image_attributes', $custom_logo_attr, $custom_logo_id, $blog_id );
        /*
         * If the alt attribute is not empty, there's no need to explicitly pass it
         * because wp_get_attachment_image() already adds the alt attribute.
         */
        $image = wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
        if ( $unlink_homepage_logo && is_front_page() && ! is_paged() ) {
            // If on the home page, don't link the logo to home.
            $html = sprintf(
                '<span class="custom-logo-link">%1$s</span>',
                $image
            );
        } else {
            $aria_current = is_front_page() && ! is_paged() ? ' aria-current="page"' : '';
            $html = sprintf(
                '<a href="%1$s" class="custom-logo-link" rel="home"%2$s>%3$s</a>',
                esc_url( home_url( '/' ) ),
                $aria_current,
                $image
            );
        }
    } elseif ( is_customize_preview() ) {
        // If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
        $html = sprintf(
            '<a href="%1$s" class="custom-logo-link" style="display:none;"><img class="custom-logo" alt="'.get_bloginfo( 'name', 'display' ).'" /></a>',
            esc_url( home_url( '/' ) )
        );
    }
    if ( $switched_blog ) {
        restore_current_blog();
    }
    /**
     * Filters the custom logo output.
     *
     * @since 4.5.0
     * @since 4.6.0 Added the `$blog_id` parameter.
     *
     * @param string $html    Custom logo HTML output.
     * @param int    $blog_id ID of the blog to get the custom logo for.
     */
    return apply_filters( 'get_custom_logo', $html, $blog_id );
}
/*
 *  Logo mobile
 */
function amino_the_custom_logo_mobile() {
    echo amino_get_custom_logo_mobile();
}
function amino_get_custom_logo_mobile() {
    $html = '';
    $custom_logo_mobile = amino_get_option('custom_logo_mobile', '');
    if( $custom_logo_mobile ) {
        $custom_logo_attr = array(
            'class'   => 'custom-logo',
            'loading' => false,
            'alt'     => get_post_meta( $custom_logo_mobile, '_wp_attachment_image_alt', true )
        );
        $image = wp_get_attachment_image( $custom_logo_mobile, 'full', false, $custom_logo_attr );
        $html .= '<div class="custom-logo-mobile">';
        $html .= '<a href="'. esc_url( home_url( '/' ) ) .'">';
        $html .= $image;
        $html .= '</a></div>';
    }else{
        $html .= '<div id="_mobile_logo_"></div>';
    }
    return $html;
}
/*
 *  Header sticky
 */
function amino_header_sticky(){	
    $class = '';
    $header_sticky = amino_get_option('header_sticky', true);
    if($header_sticky == '1'){	
        $class = 'has-sticky';
    }	
    return $class;
}	
/*
 *  Main menu
 */	
function amino_main_menu(){	
    $menu_item_align = amino_get_option('hmenu_item_align' ,'left');
    ?>	
    <?php 
    if(is_page('home-page-033333')): ?>
        <?php   
            $menu = array(  
                'theme_location'  => 'secondary', 
                'container_class' => 'primary-menu-wrapper menu-wrapper',   
                'menu_class'      => 'amino-menu primary-menu menu-align-'.$menu_item_align,    
                'walker'          => new Amino_Megamenu_Walker,    
            );  
            wp_nav_menu( $menu );   
        ?>  
    <?php else : ?>
        <?php if ( has_nav_menu('primary') ) : ?>	
            <?php	
                if ( class_exists('Amino_Megamenu_Walker') ) {	
                    $menu = array(	
                        'theme_location'  => 'primary',	
                        'container_class' => 'primary-menu-wrapper menu-wrapper',	
                        'menu_class'      => 'amino-menu primary-menu menu-align-'.$menu_item_align,	
                        'walker'          => new Amino_Megamenu_Walker,	
                    );	
                } else {	
                    $menu = array(	
                        'theme_location'  => 'primary',	
                        'container_class' => 'primary-menu-wrapper',	
                        'menu_class'      => 'amino-menu primary-menu',	
                    );	
                }	
                wp_nav_menu( $menu );	
            ?>	
        <?php else : ?>	
            <div class="primary-menu-wrapper menu-wrapper">	
                <ul class="amino-menu primary-menu menu-<?php echo esc_attr($menu_item_align); ?>">	
                    <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'amino' ) ?></a></li>	
                </ul>	
            </div>	
        <?php endif;
    endif; 
}	
/*
 *  Vertical menu
 */	
function amino_vertical_menu(){	
    $vmenu_title = amino_get_option('vmenu_title' , 'Categories');
    $vmenu_action = amino_get_option('vmenu_action', 'click'); 
    if ( has_nav_menu('vertical') ) :
		if ( class_exists('Amino_Megamenu_Walker') ) {	
			$menu = array(	
				'theme_location'  => 'vertical',	
				'container_class' => 'vermenu-wrapper menu-wrapper',	
				'menu_class'      => 'amino-menu vertical-menu',	
				'walker'          => new Amino_Megamenu_Walker,	
			);
		} else {	
			$menu = array(	
				'theme_location'  => 'vertical',	
				'container_class' => 'vertical-menu-wrapper',	
				'menu_class'      => 'amino-menu vertical-menu',	
			);
		}	
	?>
        <div class="vertical-menu-wrapper <?php echo esc_attr($vmenu_action); ?>-action">	
            <div class="vmenu-title">	
				<span><?php echo esc_attr($vmenu_title); ?></span>	
			</div>	
			<div id="_desktop_vmenu_" class="menu-wrapper">	
				<?php wp_nav_menu( $menu ); ?>	
			</div>	
        </div>
    <?php else: ?>
        <div class="vertical-menu-wrapper">	
            <ul class="amino-menu vertical-menu ">	
                <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'amino' ) ?></a></li>	
            </ul>	
        </div>	
    <?php endif;
}	
/*
 *  Topbar
 */
function amino_header_topbar(){
    $topbar_text = amino_get_option('header_topbar_text', 'dark');
    $topbar_active = amino_get_option('header_topbar_active', '1');
    $left_position = amino_get_option('topbar_left','');
    $center_position = amino_get_option('topbar_center','');
    $right_position = amino_get_option('topbar_right','');
    if(!$topbar_active) return;
    ?>
    <div class="topbar-header text-<?php echo esc_attr($topbar_text); ?>">
        <div class="container">
            <div class="row">
				<?php if ( $left_position ) { ?>
						<div class="col topbar-left-position">
							<?php amino_topbar_position_content($left_position); ?>
						</div>
				<?php } if ( $center_position ) { ?>
					<div class="col topbar-center-position">
						<?php amino_topbar_position_content($center_position); ?>
					</div>
				<?php } if ( $right_position ) { ?>
					<div class="col topbar-right-position">
						<?php amino_topbar_position_content($right_position); ?>
					</div>
				<?php } ?>
            </div>
        </div>
    </div>
    <?php
}
function amino_topbar_position_content($position){
    foreach($position as $item) {
        switch ($item['block']) {
			case 'social':
                amino_social_list();
                break;
			case 'notice':
                amino_txt_notice();
                break;
            case 'language':
                amino_language_switcher();
                break;
            case 'currency':
                amino_currency_switcher();
                break;
			case 'link1':
                amino_custom_link1();
                break;
			case 'link2':
                amino_custom_link2();
                break;
        }
    }
}
/*
 *  Topbar menu
 */
function amino_topbar_menu(){
	?>
	<div id="_desktop_topbar_menu_">
	<?php
		$class = 'topbar-menu-container';
		if ( has_nav_menu('topbar') ) {	
				$menu = array(	
					'theme_location'  => 'topbar',	
					'container_class' => $class,	
					'menu_class'      => 'topbar-menu',	
				);
				wp_nav_menu( $menu );
		}
	?>
	</div>
	<?php
}
/*
 *  Promo block element
 */
function amino_promo_block(){
    $promo_active = amino_get_option('header_promo_active', true);
    $promo_type = amino_get_option('header_promo_type', 'text');
    $promo_image = amino_get_option('header_promo_image', '');
    $promo_link = amino_get_option('header_promo_link', '');
    $promo_close_button = amino_get_option('header_promo_close', true);
    if(isset($_COOKIE['promo-block']) && $_COOKIE['promo-block']) return;
    if( !$promo_active || ($promo_type == 'text' && !amino_get_option('header_promo_text', '')) || ($promo_type == 'image' && !$promo_image) ) return;
    ?>
    <div class="promo-block">
        <?php if($promo_type == 'text' ) { ?>
        <div class="container">
			<?php echo do_shortcode(amino_get_option('header_promo_text', '')); ?>     
        </div>
        <?php }else{ ?>
            <a href="<?php echo esc_url($promo_link); ?>"><img src="<?php echo esc_url($promo_image); ?>" alt="<?php echo esc_attr( 'promotion image', 'amino' ); ?>" /></a>
        <?php } ?>
        <?php if($promo_close_button) { ?>
            <a href="#" class="promo_close"><i class="icon-rt-close-circle-outline"></i></a>
        <?php } ?>
    </div>
    <?php
}
/*
 * Header: Account Element
 */ 	
function amino_header_account(){	
    ?>
	<div id="_desktop_header_account_">
	<?php
	if( !is_woocommerce_activated() ) {	
        return;
    };
    $header_account_design = amino_get_option('he_account_design', 'only-icon');
    $myaccount_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
	$name = wp_get_current_user()->display_name;
	$active_login_popup = amino_get_option('he_account_popup', '1');
	$url_account = '';
	$active_popup = '';
	// Not allow popup in account/checkout page
	if( $active_login_popup && !is_checkout() && !is_account_page() ){
		$url_account = '#login-form-popup';
		$active_popup = 'login-popup-form';
	} else{
		$url_account = $myaccount_url;
	}
    if ( is_user_logged_in() ) { ?>
        <div class="header-block rt-dropdown-block header-account-block account-<?php echo esc_attr($header_account_design); ?>">	
            <a href="<?php echo esc_url( $myaccount_url ); ?>" class="rt-dropdown-title et-menu-account-btn icon">
				<i class="icon-rt-user" aria-hidden="true"></i>
				<p class="icon-text"><?php printf( '%1$s <strong>%2$s</strong>', esc_html__('Hello','amino'), $name ); ?></p>
			</a>
            <ul class="rt-dropdown-content account-menu">	
            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>	
                <li class="account-link--<?php echo esc_attr( $endpoint ); ?> menu-item">	
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>	
                </li>	
            <?php endforeach; ?>	
            </ul>	
        </div>	
    <?php } else { ?>
		<div class="header-block header-account-block account-<?php echo esc_attr($header_account_design); ?>"> 
			<a href="<?php echo esc_url( $url_account ); ?>" class="et-menu-account-btn icon <?php echo esc_attr($active_popup); ?>">
				<i class="icon-rt-user" aria-hidden="true"></i> 
				<div class="icon-text">
					<p><?php esc_html_e( 'Register', 'amino' ) ?></p>
					<p><?php esc_html_e( 'Or Sign In', 'amino' ) ?></p>
				</div>
			</a> 
		</div>
	<?php } ?>
	</div>
	<?php	
}	
/*
 * Header: Search element	
 */
function amino_header_search(){
	$header_search_layout = amino_get_option('header_search_layout', 'search-sidebar');
	$search_type = '';
	$add_btn_sicon = '';
	$add_btn_sicon2 = '<a href="#" class="side-close-icon" title="Close"><i class="icon-rt-close-outline"></i></a>';
	switch($header_search_layout){
		// search sidebar - only icon
		case 'search-sidebar':
			$search_type = 'search-sidebar';
			$add_btn_sicon = '<button><i class="icon-rt-loupe" aria-hidden="true"></i></button>';
			break;
		// search-simple but with style2
		case 'search-simple2':
			$search_type = 'search-simple style2';
			break;
		// search-simple			
		default:
			$search_type = 'search-simple';
	}
    ?>	
    <div id="search_block" class="header-block search-block <?php echo esc_attr($search_type) ?>">
		<?php echo wp_kses_post($add_btn_sicon) ?>
        <div class="search-wrapper" id="_desktop_search_block_">
			<?php echo wp_kses_post($add_btn_sicon2) ?>
            <?php get_template_part('template-parts/header/search'); ?>	
        </div>	
    </div> 	
<?php	
}
/*
 *  Wishlist
 */	
if( ! function_exists('amino_wishlist')  ):	
    function amino_wishlist() { 	
        if ( ! function_exists( 'YITH_WCWL' ) ) {	
            return '';
        }	
        $html = '';
        $html .= sprintf(	
            '<a href="%s" class="wishlist-link icon-element">	
                <span class="box-icons">
					<i class="icon-rt-heart2"></i>		
					<span class="wishlist-count">%s</span>
				</span>
				<span class="wishlist-text">%s</span>	
            </a>',	
            esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))),	
            YITH_WCWL()->count_products(),
			esc_html('Wishlist','amino')
        );
        echo ''.$html;
    } 	
endif;
if ( defined( 'YITH_WCWL' ) && ! function_exists( 'amino_yith_wcwl_ajax_update_count' ) ) {	
  function amino_yith_wcwl_ajax_update_count() {	
    wp_send_json( array(	
      'count' => yith_wcwl_count_all_products()	
    ) );
  }	
  add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'amino_yith_wcwl_ajax_update_count' );
  add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'amino_yith_wcwl_ajax_update_count' );
}	
if ( defined( 'YITH_WCWL' ) && ! function_exists( 'amino_yith_wcwl_enqueue_custom_script' ) ) {	
  function amino_yith_wcwl_enqueue_custom_script() {	
    wp_add_inline_script(	
      'jquery-yith-wcwl',	
      "	
        jQuery( function( $ ) {	
          $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {	
            $.get( yith_wcwl_l10n.ajax_url, {	
              action: 'yith_wcwl_update_wishlist_count'	
            }, function( data ) {	
              $('.wishlist-count').html( data.count );
            } );
          } );
        } );
      "	
    );
  }	
  add_action( 'wp_enqueue_scripts', 'amino_yith_wcwl_enqueue_custom_script', 20 );
}	
/*
 *  Contact element
 */
function amino_header_contact(){
    $text = amino_get_option('he_contact_text', '');
    echo '<div class="header-contact"><div class="inner"><div class="icon"></div><div class="content"><p>' . $text .'</p></div></div></div>';
}
/*
 *  Text Notification
 */
function amino_txt_notice(){
    $txt_notice = amino_get_option('header_txt_notice', '');
	echo '<div id="_desktop_txt_notice_"><div class="amino-txt-notice">'. $txt_notice .'</div></div>';
}
/*
 *  Languages elememnt
 */
function amino_language_switcher(){
    $language_content = amino_get_option('header_language_content', '');
	echo '<div id="_desktop_language_switcher_">';
		echo '<div class="amino-language-switcher rt-dropdown-block">';
			echo '<div class="rt-dropdown-title">'. esc_html__( 'Lang', 'amino' ) .' <i class="icon-rt-arrow-down"></i></div>';
			echo '<div class="rt-dropdown-content">'. $language_content .'</div>';
		echo '</div>';
	echo '</div>';
}
/*
 *  Currencies element
 */
function amino_currency_switcher(){
    $currency_content = amino_get_option('header_currency_content', '');
    echo '<div id="_desktop_currency_switcher_">';
        echo '<div class="amino-currency-switcher rt-dropdown-block">';
            echo '<div class="rt-dropdown-title">'. esc_html__( 'Curr', 'amino' ) .' <i class="icon-rt-arrow-down"></i></div>';
            echo '<div class="rt-dropdown-content">'. $currency_content .'</div>';
        echo '</div>';
    echo '</div>';
}
/*
 *  Header link 1
 */	
function amino_custom_link1(){	
	$link_text = amino_get_option('header_link_text1','');
	$link_url = amino_get_option('header_link_url1','');
    if($link_text && $link_url) :
		echo '<div id="_desktop_header_link1_">';
			echo '<a class="header-link1" href="'. esc_url( $link_url ) .'">'. esc_html( $link_text ) .'</a>';
		echo '</div>';
    endif;
}
/*
 *  Header link 2
 */	
function amino_custom_link2(){	
	$link_text = amino_get_option('header_link_text2','');
	$link_url = amino_get_option('header_link_url2','');
    if($link_text && $link_url) :
		echo '<div id="_desktop_header_link2_">';
			echo '<a class="header-link2" href="'. esc_url( $link_url ) .'">'. esc_html( $link_text ) .'</a>';
		echo '</div>';
    endif;
}