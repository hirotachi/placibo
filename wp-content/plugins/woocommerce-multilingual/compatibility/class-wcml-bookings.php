<?php

use WPML\FP\Maybe;
use function WPML\FP\invoke;
use function WPML\FP\pipe;

/**
 * Class WCML_Bookings.
 */
class WCML_Bookings {

	const DOMAIN = 'woocommerce-bookings';

	/**
	 * @var WPML_Element_Translation_Package
	 */
	private $tp;

	/**
	 * @var SitePress
	 */
	private $sitepress;

	/**
	 * @var woocommerce_wpml
	 */
	private $woocommerce_wpml;

	/**
	 * @var woocommerce
	 */
	private $woocommerce;

	/**
	 * @var WPML_Post_Translation
	 */
	private $wpml_post_translations;

	/**
	 * @var wpdb
	 */
	private $wpdb;

	/**
	 * WCML_Bookings constructor.
	 *
	 * @param SitePress                        $sitepress
	 * @param woocommerce_wpml                 $woocommerce_wpml
	 * @param woocommerce                      $woocommerce
	 * @param wpdb                             $wpdb
	 * @param WPML_Element_Translation_Package $tp
	 * @param WPML_Post_Translation            $wpml_post_translations
	 */
	public function __construct( SitePress $sitepress, woocommerce_wpml $woocommerce_wpml, woocommerce $woocommerce, wpdb $wpdb, WPML_Element_Translation_Package $tp, WPML_Post_Translation $wpml_post_translations ) {
		$this->sitepress              = $sitepress;
		$this->woocommerce_wpml       = $woocommerce_wpml;
		$this->woocommerce            = $woocommerce;
		$this->wpdb                   = $wpdb;
		$this->tp                     = $tp;
		$this->wpml_post_translations = $wpml_post_translations;
	}

	/**
	 * Adds hooks.
	 */
	public function add_hooks() {

		// Translate emails.
		add_filter( 'get_post_metadata', [ $this, 'get_order_language' ], 10, 4 );

		add_filter( 'woocommerce_booking_confirmed_notification', [ $this, 'translate_notification' ], 9 );
		add_action( 'wc-booking-reminder', [ $this, 'translate_notification' ], 9 );

		// @todo: Verify if 'woocommerce_booking_reminder_notification' and
		// 'woocommerce_booking_cancelled_notification' are still needed.
		add_filter( 'woocommerce_booking_reminder_notification', [ $this, 'translate_notification' ], 9 );
		add_filter( 'woocommerce_booking_cancelled_notification', [ $this, 'translate_notification' ], 9 );

		add_action(
			'woocommerce_bookings_after_booking_base_cost',
			[
				$this,
				'wcml_price_field_after_booking_base_cost',
			]
		);
		add_action(
			'woocommerce_bookings_after_booking_block_cost',
			[
				$this,
				'wcml_price_field_after_booking_block_cost',
			]
		);
		add_action( 'woocommerce_bookings_after_display_cost', [ $this, 'wcml_price_field_after_display_cost' ] );
		add_action(
			'woocommerce_bookings_after_booking_pricing_base_cost',
			[
				$this,
				'wcml_price_field_after_booking_pricing_base_cost',
			],
			10,
			2
		);
		add_action(
			'woocommerce_bookings_after_booking_pricing_cost',
			[
				$this,
				'wcml_price_field_after_booking_pricing_cost',
			],
			10,
			2
		);
		add_action( 'woocommerce_bookings_after_person_cost', [ $this, 'wcml_price_field_after_person_cost' ] );
		add_action(
			'woocommerce_bookings_after_person_block_cost',
			[
				$this,
				'wcml_price_field_after_person_block_cost',
			]
		);
		add_action(
			'woocommerce_bookings_after_resource_cost',
			[
				$this,
				'wcml_price_field_after_resource_cost',
			],
			10,
			2
		);
		add_action(
			'woocommerce_bookings_after_resource_block_cost',
			[
				$this,
				'wcml_price_field_after_resource_block_cost',
			],
			10,
			2
		);
		add_action( 'woocommerce_bookings_after_bookings_pricing', [ $this, 'after_bookings_pricing' ] );

		add_action( 'init', [ $this, 'load_assets' ] );

		add_action( 'save_post', [ $this, 'save_booking_action_handler' ], 110 );

		add_action( 'wcml_before_sync_product_data', [ $this, 'sync_bookings' ], 10, 3 );
		add_action( 'wcml_before_sync_product', [ $this, 'sync_booking_data' ], 10, 2 );

		add_filter(
			'woocommerce_bookings_process_cost_rules_cost',
			[
				$this,
				'wc_bookings_process_cost_rules_cost',
			],
			10,
			3
		);
		add_filter(
			'woocommerce_bookings_process_cost_rules_base_cost',
			[
				$this,
				'wc_bookings_process_cost_rules_base_cost',
			],
			10,
			3
		);
		add_filter(
			'woocommerce_bookings_process_cost_rules_override_block',
			[
				$this,
				'wc_bookings_process_cost_rules_override_block_cost',
			],
			10,
			3
		);

		add_filter( 'wcml_multi_currency_ajax_actions', [ $this, 'wcml_multi_currency_is_ajax' ] );

		add_filter(
			'wcml_cart_contents_not_changed',
			[
				$this,
				'filter_bundled_product_in_cart_contents',
			],
			10,
			3
		);

		add_action( 'woocommerce_bookings_after_create_booking_page', [ $this, 'booking_currency_dropdown' ] );
		add_action( 'init', [ $this, 'set_booking_currency' ] );

		add_action( 'wp_ajax_wcml_booking_set_currency', [ $this, 'set_booking_currency_ajax' ] );
		add_action(
			'woocommerce_bookings_create_booking_page_add_order_item',
			[
				$this,
				'set_order_currency_on_create_booking_page',
			]
		);
		add_filter( 'woocommerce_currency_symbol', [ $this, 'filter_booking_currency_symbol' ] );
		add_filter( 'get_booking_products_args', [ $this, 'filter_get_booking_products_args' ] );
		add_filter( 'wcml_filter_currency_position', [ $this, 'create_booking_page_client_currency' ] );

		add_filter( 'wcml_client_currency', [ $this, 'create_booking_page_client_currency' ] );

		add_action( 'wcml_gui_additional_box_html', [ $this, 'custom_box_html' ], 10, 3 );
		add_filter( 'wcml_gui_additional_box_data', [ $this, 'custom_box_html_data' ], 10, 4 );
		add_filter( 'wcml_check_is_single', [ $this, 'show_custom_blocks_for_resources_and_persons' ], 10, 3 );
		add_filter( 'wcml_do_not_display_custom_fields_for_product', [ $this, 'replace_tm_editor_custom_fields_with_own_sections' ] );
		add_filter(
			'wcml_not_display_single_fields_to_translate',
			[
				$this,
				'remove_single_custom_fields_to_translate',
			]
		);
		add_filter( 'wcml_product_content_label', [ $this, 'product_content_resource_label' ], 10, 2 );
		add_action( 'wcml_update_extra_fields', [ $this, 'wcml_products_tab_sync_resources_and_persons' ], 10, 4 );

		add_action( 'woocommerce_new_booking', [ $this, 'duplicate_booking_for_translations' ] );

		$bookings_statuses = [
			'unpaid',
			'pending-confirmation',
			'confirmed',
			'paid',
			'cancelled',
			'complete',
			'in-cart',
			'was-in-cart',
		];
		foreach ( $bookings_statuses as $status ) {
			add_action( 'woocommerce_booking_' . $status, [ $this, 'update_status_for_translations' ] );
		}

		add_filter( 'parse_query', [ $this, 'booking_filters_query' ] );
		add_filter( 'woocommerce_bookings_in_date_range_query', [ $this, 'bookings_in_date_range_query' ] );
		add_action( 'before_delete_post', [ $this, 'delete_bookings' ] );
		add_action( 'wp_trash_post', [ $this, 'trash_bookings' ] );
		add_action( 'wpml_translation_job_saved', [ $this, 'save_booking_data_to_translation' ], 10, 3 );

		if ( is_admin() ) {

			add_filter(
				'wpml_tm_translation_job_data',
				[
					$this,
					'append_persons_to_translation_package',
				],
				10,
				2
			);

			add_filter(
				'wpml_tm_translation_job_data',
				[
					$this,
					'append_resources_to_translation_package',
				],
				10,
				2
			);

			// lock fields on translations pages.
			add_filter( 'wcml_js_lock_fields_ids', [ $this, 'wcml_js_lock_fields_ids' ] );
			add_filter( 'wcml_after_load_lock_fields_js', [ $this, 'localize_lock_fields_js' ] );

			// allow filtering resources by language.
			add_filter( 'get_booking_resources_args', [ $this, 'filter_get_booking_resources_args' ] );

			add_filter( 'get_translatable_documents_all', [ $this, 'filter_translatable_documents' ] );

			add_filter( 'pre_wpml_is_translated_post_type', [ $this, 'filter_is_translated_post_type' ] );

			add_action( 'woocommerce_product_data_panels', [ $this, 'show_pointer_info' ] );

			add_action( 'save_post', [ $this, 'sync_booking_status' ], 10, 3 );

			add_filter( 'wcml_emails_options_to_translate', [ $this, 'emails_options_to_translate' ] );

			add_filter( 'wcml_emails_text_keys_to_translate', [ $this, 'emails_text_keys_to_translate' ] );

			add_filter( 'woocommerce_email_get_option', [ $this, 'translate_emails_text_strings' ], 10, 4 );

			add_action( 'woocommerce_booking_confirmed_notification', [ $this, 'translate_booking_confirmed_email_texts' ], 9 );
			add_action( 'woocommerce_booking_pending-confirmation_to_cancelled_notification', [ $this, 'translate_booking_cancelled_email_texts' ], 9 );
			add_action( 'woocommerce_booking_confirmed_to_cancelled_notification', [ $this, 'translate_booking_cancelled_email_texts' ], 9 );
			add_action( 'woocommerce_booking_paid_to_cancelled_notification', [ $this, 'translate_booking_cancelled_email_texts' ], 9 );

			// @todo: Verify 'wc-booking-reminder' because it happens in wp cron and we are in admin here.
			add_action( 'wc-booking-reminder', [ $this, 'translate_booking_reminder_email_texts' ], 9 );
			add_action( 'woocommerce_admin_new_booking_notification', [ $this, 'translate_new_booking_email_texts' ], 9 );

			add_action( 'woocommerce_booking_pending-confirmation_to_cancelled_notification', [ $this, 'translate_booking_cancelled_admin_email_texts' ], 9 );
			add_action( 'woocommerce_booking_confirmed_to_cancelled_notification', [ $this, 'translate_booking_cancelled_admin_email_texts' ], 9 );
			add_action( 'woocommerce_booking_paid_to_cancelled_notification', [ $this, 'translate_booking_cancelled_admin_email_texts' ], 9 );

			add_filter( 'wcml_email_language', [ $this, 'booking_email_language' ] );

			if ( $this->is_bookings_listing_page() ) {
				$this->remove_language_switcher();
				add_filter( 'wp_count_posts', [ $this, 'count_bookings_by_current_language' ], 10, 2 );
				add_filter( 'views_edit-wc_booking', [ $this, 'unset_mine_from_bookings_views' ] );
			}
		}

		if ( ! is_admin() || isset( $_POST['action'] ) && 'wc_bookings_calculate_costs' === $_POST['action'] ) {
			add_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10, 4 );
		}

		add_filter( 'wpml_language_filter_extra_conditions_snippet', [ $this, 'extra_conditions_to_filter_bookings' ] );

		$this->clear_transient_fields();

		add_filter( 'wpml_tm_dashboard_translatable_types', [ $this, 'hide_bookings_type_on_tm_dashboard' ] );

		add_filter( 'wcml_add_to_cart_sold_individually', [ $this, 'add_to_cart_sold_individually' ], 10, 4 );

		add_filter( 'woocommerce_bookings_account_tables', [ $this, 'filter_my_account_bookings_tables_by_current_language' ] );

		add_filter( 'schedule_event', [ $this, 'prevent_events_on_duplicates' ] );
	}

	/**
	 * When sending a booking notification to the customer get the language from the order.
	 *
	 * @param string  $check     Dummy argument.
	 * @param integer $object_id The Post ID to query.
	 * @param string  $meta_key  The meta key to query.
	 * @param bool    $single    Wether we want a single value or an array.
	 * @return string
	 */
	public function get_order_language( $check, $object_id, $meta_key, $single ) {

		if ( 'wpml_language' === $meta_key && 'wc_booking' === get_post_type( $object_id ) ) {
			// Get the order_item_id which might be in the original booking.
			$order_item_id = get_post_meta( $object_id, '_booking_order_item_id', true );
			if ( empty( $order_item_id ) ) {
				$original_booking_id = get_post_meta( $object_id, '_booking_duplicate_of', true );
				$order_item_id       = get_post_meta( $original_booking_id, '_booking_order_item_id', true );
			}

			// From here we can grab the order_id and return its language.
			$order_id = $this->wpdb->get_var(
				$this->wpdb->prepare(
					"SELECT order_id FROM {$this->wpdb->prefix}woocommerce_order_items WHERE order_item_id = %d",
					$order_item_id
				)
			); // WPCS: unprepared SQL OK.
			remove_filter( 'get_post_metadata', [ $this, 'get_order_language' ], 10 );
			$check = get_post_meta( $order_id, 'wpml_language', $single );
			add_filter( 'get_post_metadata', [ $this, 'get_order_language' ], 10, 4 );
		}

		return $check;
	}

	/**
	 * Translate strings of notifications.
	 *
	 * If $order_id is a booking ID, the language will be
	 * fetched from the parent order because we have a
	 * filter on the post meta `wpml_language` for bookings.
	 *
	 * @param integer $order_id Order ID.
	 */
	public function translate_notification( $order_id ) {
		$this->woocommerce_wpml->emails->refresh_email_lang( $order_id );
	}

	public function save_booking_action_handler( $booking_id ) {

		$this->maybe_set_booking_language( $booking_id );

		$this->save_custom_costs( $booking_id );

		$this->maybe_sync_updated_booking_meta( $booking_id );
	}

	public function wcml_price_field_after_booking_base_cost( $post_id ) {

		$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_cost' );

	}

	public function wcml_price_field_after_booking_block_cost( $post_id ) {
		if ( $this->sitepress->get_wp_api()->version_compare( $this->sitepress->get_wp_api()->constant( 'WC_BOOKINGS_VERSION' ), '1.10.9', '<' ) ) {
			$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_base_cost' );
		} else {
			$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_block_cost' );
		}
	}

	public function wcml_price_field_after_display_cost( $post_id ) {

		$this->echo_wcml_price_field( $post_id, 'wcml_wc_display_cost' );

	}

	public function wcml_price_field_after_booking_pricing_base_cost( $pricing, $post_id ) {

		$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_pricing_base_cost', $pricing );

	}

	public function wcml_price_field_after_booking_pricing_cost( $pricing, $post_id ) {

		$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_pricing_cost', $pricing );

	}

	public function wcml_price_field_after_person_cost( $person_type_id ) {

		$this->echo_wcml_price_field( $person_type_id, 'wcml_wc_booking_person_cost', false, false );

	}

	public function wcml_price_field_after_person_block_cost( $person_type_id ) {

		$this->echo_wcml_price_field( $person_type_id, 'wcml_wc_booking_person_block_cost', false, false );

	}

	public function wcml_price_field_after_resource_cost( $resource_id, $post_id ) {

		$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_resource_cost', false, true, $resource_id );

	}

	public function wcml_price_field_after_resource_block_cost( $resource_id, $post_id ) {

		$this->echo_wcml_price_field( $post_id, 'wcml_wc_booking_resource_block_cost', false, true, $resource_id );

	}

	public function echo_wcml_price_field( $post_id, $field, $pricing = false, $check = true, $resource_id = false ) {

		if ( ( ! $check || $this->woocommerce_wpml->products->is_original_product( $post_id ) ) && $this->woocommerce_wpml->settings['enable_multi_currency'] == WCML_MULTI_CURRENCIES_INDEPENDENT ) {

			$currencies = $this->woocommerce_wpml->multi_currency->get_currencies();

			$wc_currencies = get_woocommerce_currencies();

			if ( ! function_exists( 'woocommerce_wp_text_input' ) ) {
				include_once dirname( WC_PLUGIN_FILE ) . '/includes/admin/wc-meta-box-functions.php';
			}

			echo '<div class="wcml_custom_cost_field" >';

			foreach ( $currencies as $currency_code => $currency ) {

				switch ( $field ) {
					case 'wcml_wc_booking_cost':
						woocommerce_wp_text_input(
							[
								'id'                => 'wcml_wc_booking_cost',
								'class'             => 'wcml_bookings_custom_price',
								'name'              => 'wcml_wc_booking_cost[' . $currency_code . ']',
								'label'             => get_woocommerce_currency_symbol( $currency_code ),
								'description'       => __( 'One-off cost for the booking as a whole.', 'woocommerce-bookings' ),
								'value'             => get_post_meta( $post_id, '_wc_booking_cost_' . $currency_code, true ),
								'type'              => 'number',
								'desc_tip'          => true,
								'custom_attributes' => [
									'min'  => '',
									'step' => '0.01',
								],
							]
						);
						break;
					case 'wcml_wc_booking_block_cost':
					case 'wcml_wc_booking_base_cost':
						$block_cost_key = '_wc_booking_base_cost_';
						if ( $field === 'wcml_wc_booking_block_cost' ) {
							$block_cost_key = '_wc_booking_block_cost_';
						}
						$block_cost_key .= $currency_code;
						woocommerce_wp_text_input(
							[
								'id'                => $field,
								'class'             => 'wcml_bookings_custom_price',
								'name'              => $field . '[' . $currency_code . ']',
								'label'             => get_woocommerce_currency_symbol( $currency_code ),
								'description'       => __( 'This is the cost per block booked. All other costs (for resources and persons) are added to this.', 'woocommerce-bookings' ),
								'value'             => get_post_meta( $post_id, $block_cost_key, true ),
								'type'              => 'number',
								'desc_tip'          => true,
								'custom_attributes' => [
									'min'  => '',
									'step' => '0.01',
								],
							]
						);
						break;
					case 'wcml_wc_display_cost':
						woocommerce_wp_text_input(
							[
								'id'                => 'wcml_wc_display_cost',
								'class'             => 'wcml_bookings_custom_price',
								'name'              => 'wcml_wc_display_cost[' . $currency_code . ']',
								'label'             => get_woocommerce_currency_symbol( $currency_code ),
								'description'       => __( 'The cost is displayed to the user on the frontend. Leave blank to have it calculated for you. If a booking has varying costs, this will be prefixed with the word "from:".', 'woocommerce-bookings' ),
								'value'             => get_post_meta( $post_id, '_wc_display_cost_' . $currency_code, true ),
								'type'              => 'number',
								'desc_tip'          => true,
								'custom_attributes' => [
									'min'  => '',
									'step' => '0.01',
								],
							]
						);
						break;

					case 'wcml_wc_booking_pricing_base_cost':
						if ( isset( $pricing[ 'base_cost_' . $currency_code ] ) ) {
							$value = $pricing[ 'base_cost_' . $currency_code ];
						} else {
							$value = '';
						}

						echo '<div class="wcml_bookings_range_block" >';
						echo '<label>' . wp_kses_post( get_woocommerce_currency_symbol( $currency_code ) ) . '</label>';
						echo '<input type="number" step="0.01" name="wcml_wc_booking_pricing_base_cost[' . esc_html( $currency_code ) . '][]" class="wcml_bookings_custom_price" value="' . esc_html( $value ) . '" placeholder="0" />';
						echo '</div>';
						break;

					case 'wcml_wc_booking_pricing_cost':
						if ( isset( $pricing[ 'cost_' . $currency_code ] ) ) {
							$value = $pricing[ 'cost_' . $currency_code ];
						} else {
							$value = '';
						}

						echo '<div class="wcml_bookings_range_block" >';
						echo '<label>' . wp_kses_post( get_woocommerce_currency_symbol( $currency_code ) ) . '</label>';
						echo '<input type="number" step="0.01" name="wcml_wc_booking_pricing_cost[' . esc_html( $currency_code ) . '][]" class="wcml_bookings_custom_price" value="' . esc_html( $value ) . '" placeholder="0" />';
						echo '</div>';
						break;

					case 'wcml_wc_booking_person_cost':
						$value = get_post_meta( $post_id, 'cost_' . $currency_code, true );

						echo '<div class="wcml_bookings_person_block" >';
						echo '<label>' . wp_kses_post( get_woocommerce_currency_symbol( $currency_code ) ) . '</label>';
						echo '<input type="number" step="0.01" name="wcml_wc_booking_person_cost[' . intval( $post_id ) . '][' . esc_html( $currency_code ) . ']" class="wcml_bookings_custom_price" value="' . esc_html( $value ) . '" placeholder="0" />';
						echo '</div>';
						break;

					case 'wcml_wc_booking_person_block_cost':
						$value = get_post_meta( $post_id, 'block_cost_' . $currency_code, true );

						echo '<div class="wcml_bookings_person_block" >';
						echo '<label>' . wp_kses_post( get_woocommerce_currency_symbol( $currency_code ) ) . '</label>';
						echo '<input type="number" step="0.01" name="wcml_wc_booking_person_block_cost[' . intval( $post_id ) . '][' . esc_html( $currency_code ) . ']" class="wcml_bookings_custom_price" value="' . esc_html( $value ) . '" placeholder="0" />';
						echo '</div>';
						break;

					case 'wcml_wc_booking_resource_cost':
						$resource_base_costs = maybe_unserialize( get_post_meta( $post_id, '_resource_base_costs', true ) );

						if ( isset( $resource_base_costs['custom_costs'][ $currency_code ][ $resource_id ] ) ) {
							$value = $resource_base_costs['custom_costs'][ $currency_code ][ $resource_id ];
						} else {
							$value = '';
						}

						echo '<div class="wcml_bookings_resource_block" >';
						echo '<label>' . wp_kses_post( get_woocommerce_currency_symbol( $currency_code ) ) . '</label>';
						echo '<input type="number" step="0.01" name="wcml_wc_booking_resource_cost[' . esc_html( $resource_id ) . '][' . esc_html( $currency_code ) . ']" class="wcml_bookings_custom_price" value="' . esc_html( $value ) . '" placeholder="0" />';
						echo '</div>';
						break;

					case 'wcml_wc_booking_resource_block_cost':
						$resource_block_costs = maybe_unserialize( get_post_meta( $post_id, '_resource_block_costs', true ) );

						if ( isset( $resource_block_costs['custom_costs'][ $currency_code ][ $resource_id ] ) ) {
							$value = $resource_block_costs['custom_costs'][ $currency_code ][ $resource_id ];
						} else {
							$value = '';
						}

						echo '<div class="wcml_bookings_resource_block" >';
						echo '<label>' . wp_kses_post( get_woocommerce_currency_symbol( $currency_code ) ) . '</label>';
						echo '<input type="number" step="0.01" name="wcml_wc_booking_resource_block_cost[' . esc_html( $resource_id ) . '][' . esc_html( $currency_code ) . ']" class="wcml_bookings_custom_price" value="' . esc_html( $value ) . '" placeholder="0" />';
						echo '</div>';
						break;

					default:
						break;

				}
			}

			echo '</div>';

		}
	}

	public function after_bookings_pricing( $post_id ) {

		if ( in_array( 'booking', wp_get_post_terms( $post_id, 'product_type', [ 'fields' => 'names' ] ) ) && $this->woocommerce_wpml->products->is_original_product( $post_id ) && $this->woocommerce_wpml->settings['enable_multi_currency'] == WCML_MULTI_CURRENCIES_INDEPENDENT ) {

			$custom_costs_status = get_post_meta( $post_id, '_wcml_custom_costs_status', true );

			$checked = ! $custom_costs_status ? 'checked="checked"' : ' ';

			echo '<div class="wcml_custom_costs">';

			echo '<input type="radio" name="_wcml_custom_costs" id="wcml_custom_costs_auto" value="0" class="wcml_custom_costs_input" ' . esc_html( $checked ) . ' />';
			echo '<label for="wcml_custom_costs_auto">' . esc_html__( 'Calculate costs in other currencies automatically', 'woocommerce-multilingual' ) . '</label>';

			$checked = 1 === (int) $custom_costs_status ? 'checked="checked"' : ' ';

			echo '<input type="radio" name="_wcml_custom_costs" value="1" id="wcml_custom_costs_manually" class="wcml_custom_costs_input" ' . esc_html( $checked ) . ' />';
			echo '<label for="wcml_custom_costs_manually">' . esc_html__( 'Set costs in other currencies manually', 'woocommerce-multilingual' ) . '</label>';

			wp_nonce_field( 'wcml_save_custom_costs', '_wcml_custom_costs_nonce' );

			echo '</div>';
		}

	}

	public function save_custom_costs( $post_id ) {
		$nonce = filter_var( isset( $_POST['_wcml_custom_costs_nonce'] ) ? $_POST['_wcml_custom_costs_nonce'] : '', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		if ( isset( $_POST['_wcml_custom_costs'] ) && isset( $nonce ) && wp_verify_nonce( $nonce, 'wcml_save_custom_costs' ) ) {

			update_post_meta( $post_id, '_wcml_custom_costs_status', $_POST['_wcml_custom_costs'] );

			if ( 1 === (int) $_POST['_wcml_custom_costs'] ) {

				$currencies = $this->woocommerce_wpml->multi_currency->get_currencies();
				if ( empty( $currencies ) || 0 === $post_id ) {
					return false;
				}

				$this->update_booking_costs( $currencies, $post_id );
				$this->update_booking_pricing( $currencies, $post_id );

				if ( isset( $_POST['wcml_wc_booking_person_cost'] ) && is_array( $_POST['wcml_wc_booking_person_cost'] ) ) {
					$this->update_booking_person_cost( $currencies, $_POST['wcml_wc_booking_person_cost'] );
				}

				if ( isset( $_POST['wcml_wc_booking_person_block_cost'] ) && is_array( $_POST['wcml_wc_booking_person_block_cost'] ) ) {
					$this->update_booking_person_block_cost( $currencies, $_POST['wcml_wc_booking_person_block_cost'] );
				}

				if ( isset( $_POST['wcml_wc_booking_resource_cost'] ) && is_array( $_POST['wcml_wc_booking_resource_cost'] ) ) {
					$this->update_booking_resource_cost( $currencies, $post_id, $_POST['wcml_wc_booking_resource_cost'] );
				}

				if ( isset( $_POST['wcml_wc_booking_resource_block_cost'] ) && is_array( $_POST['wcml_wc_booking_resource_block_cost'] ) ) {
					$this->update_booking_resource_block_cost( $currencies, $post_id, $_POST['wcml_wc_booking_resource_block_cost'] );
				}

				update_post_meta( $post_id, '_price', '' );
			} else {
				return false;
			}
		}

	}

	// sync existing product bookings for translations.
	public function sync_bookings( $original_product_id, $product_id, $language ) {
		$all_bookings_for_product = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT post_id as id FROM {$this->wpdb->postmeta} WHERE meta_key = '_booking_product_id' AND meta_value = %d", $original_product_id ) );

		foreach ( $all_bookings_for_product as $booking ) {

			if ( $language === $this->wpml_post_translations->get_source_lang_code( $booking->id ) ) {
				continue;
			}

			$booking_translations = $this->get_translated_bookings( $booking->id );

			if ( ! isset( $booking_translations[ $language ] ) ) {
				$this->duplicate_booking_for_translations( $booking->id, $language );
			} elseif ( ! get_post_meta( $booking_translations[ $language ], '_booking_product_id', true ) ) {
				$this->update_translated_booking_meta( $booking_translations[ $language ], $booking->id, $language );
			}
		}
	}

	/**
	 * @param int    $translated_booking_id
	 * @param int    $original_booking_id
	 * @param string $language
	 */
	private function update_translated_booking_meta( $translated_booking_id, $original_booking_id, $language ) {
		update_post_meta( $translated_booking_id, '_booking_product_id', $this->get_translated_booking_product_id( $original_booking_id, $language ) );
		update_post_meta( $translated_booking_id, '_booking_resource_id', $this->get_translated_booking_resource_id( $original_booking_id, $language ) );
		update_post_meta( $translated_booking_id, '_booking_persons', $this->get_translated_booking_persons_ids( $original_booking_id, $language ) );
	}

	public function sync_booking_data( $original_product_id, $current_product_id ) {

		if ( has_term( 'booking', 'product_type', $original_product_id ) ) {
			$translations = $this->wpml_post_translations->get_element_translations( $original_product_id, false, true );
			foreach ( $translations as $translation ) {
				$language = $this->wpml_post_translations->get_element_lang_code( $translation );

				// sync_resources.
				$this->sync_resources( $original_product_id, $translation, $language );

				// sync_persons.
				$this->sync_persons( $original_product_id, $translation, $language );
			}
		}
	}

	public function sync_resources( $original_product_id, $translated_product_id, $lang_code, $duplicate = true ) {

		$original_resources = $this->wpdb->get_results(
			$this->wpdb->prepare(
				"SELECT resource_id, sort_order FROM {$this->wpdb->prefix}wc_booking_relationships WHERE product_id = %d",
				$original_product_id
			)
		);

		$translated_resources = $this->wpdb->get_col(
			$this->wpdb->prepare(
				"SELECT resource_id FROM {$this->wpdb->prefix}wc_booking_relationships WHERE product_id = %d",
				$translated_product_id
			)
		);

		$used_translated_resources = [];

		foreach ( $original_resources as $resource ) {

			$translated_resource_id = apply_filters( 'translate_object_id', $resource->resource_id, 'bookable_resource', false, $lang_code );
			if ( ! is_null( $translated_resource_id ) ) {

				if ( in_array( $translated_resource_id, $translated_resources ) ) {
					$this->update_product_resource( $translated_product_id, $translated_resource_id, $resource );
				} else {
					$this->add_product_resource( $translated_product_id, $translated_resource_id, $resource );
				}
				$used_translated_resources[] = $translated_resource_id;
			} else {
				if ( $duplicate ) {
					$this->duplicate_resource( $translated_product_id, $resource, $lang_code );
				}
			}
		}

		$removed_translated_resources_id = array_diff( $translated_resources, $used_translated_resources );
		foreach ( $removed_translated_resources_id as $resource_id ) {
			$this->remove_resource_from_product( $translated_product_id, $resource_id );
		}

		$this->sync_resource_costs( $original_product_id, $translated_product_id, '_resource_base_costs', $lang_code );
		$this->sync_resource_costs( $original_product_id, $translated_product_id, '_resource_block_costs', $lang_code );

	}

	public function duplicate_resource( $tr_product_id, $resource, $lang_code ) {
		global $iclTranslationManagement;

		if ( method_exists( $this->sitepress, 'make_duplicate' ) ) {

			$trns_resource_id = $this->sitepress->make_duplicate( $resource->resource_id, $lang_code );

		} else {

			if ( ! isset( $iclTranslationManagement ) ) {
				$iclTranslationManagement = new TranslationManagement();
			}

			$trns_resource_id = $iclTranslationManagement->make_duplicate( $resource->resource_id, $lang_code );

		}

		$this->wpdb->insert(
			$this->wpdb->prefix . 'wc_booking_relationships',
			[
				'product_id'  => $tr_product_id,
				'resource_id' => $trns_resource_id,
				'sort_order'  => $resource->sort_order,
			]
		);

		delete_post_meta( $trns_resource_id, '_icl_lang_duplicate_of' );

		return $trns_resource_id;
	}

	public function add_product_resource( $product_id, $resource_id, $resource_data ) {

		$this->wpdb->insert(
			$this->wpdb->prefix . 'wc_booking_relationships',
			[
				'sort_order'  => $resource_data->sort_order,
				'product_id'  => $product_id,
				'resource_id' => $resource_id,
			]
		);

		update_post_meta( $resource_id, 'qty', get_post_meta( $resource_data->resource_id, 'qty', true ) );
		update_post_meta( $resource_id, '_wc_booking_availability', get_post_meta( $resource_data->resource_id, '_wc_booking_availability', true ) );

	}

	public function remove_resource_from_product( $product_id, $resource_id ) {

		$this->wpdb->delete(
			$this->wpdb->prefix . 'wc_booking_relationships',
			[
				'product_id'  => $product_id,
				'resource_id' => $resource_id,
			]
		);

	}

	public function update_product_resource( $product_id, $resource_id, $resource_data ) {

		$this->wpdb->update(
			$this->wpdb->prefix . 'wc_booking_relationships',
			[
				'sort_order' => $resource_data->sort_order,
			],
			[
				'product_id'  => $product_id,
				'resource_id' => $resource_id,
			]
		);

		update_post_meta( $resource_id, 'qty', get_post_meta( $resource_data->resource_id, 'qty', true ) );
		update_post_meta( $resource_id, '_wc_booking_availability', get_post_meta( $resource_data->resource_id, '_wc_booking_availability', true ) );

	}

	public function sync_persons( $original_product_id, $tr_product_id, $lang_code, $duplicate = true ) {
		$orig_persons = $this->wpdb->get_col( $this->wpdb->prepare( "SELECT ID FROM {$this->wpdb->posts} WHERE post_parent = %d AND post_type = 'bookable_person'", $original_product_id ) );

		$trnsl_persons = $this->wpdb->get_col( $this->wpdb->prepare( "SELECT ID FROM {$this->wpdb->posts} WHERE post_parent = %d AND post_type = 'bookable_person'", $tr_product_id ) );

		foreach ( $orig_persons as $person ) {

			$trnsl_person_id = apply_filters( 'translate_object_id', $person, 'bookable_person', false, $lang_code );

			if ( ! is_null( $trnsl_person_id ) && in_array( $trnsl_person_id, $trnsl_persons ) ) {

				if ( ( $key = array_search( $trnsl_person_id, $trnsl_persons ) ) !== false ) {

					unset( $trnsl_persons[ $key ] );

					update_post_meta( $trnsl_person_id, 'block_cost', get_post_meta( $person, 'block_cost', true ) );
					update_post_meta( $trnsl_person_id, 'cost', get_post_meta( $person, 'cost', true ) );
					update_post_meta( $trnsl_person_id, 'max', get_post_meta( $person, 'max', true ) );
					update_post_meta( $trnsl_person_id, 'min', get_post_meta( $person, 'min', true ) );

					if ( get_post_meta( $person, '_wcml_custom_costs_status', true ) && $this->woocommerce_wpml->settings['enable_multi_currency'] == WCML_MULTI_CURRENCIES_INDEPENDENT ) {
						$currencies = $this->woocommerce_wpml->multi_currency->get_currencies();

						foreach ( $currencies as $code => $currency ) {

							update_post_meta( $trnsl_person_id, 'block_cost_' . $code, get_post_meta( $person, 'block_cost_' . $code, true ) );
							update_post_meta( $trnsl_person_id, 'cost_' . $code, get_post_meta( $person, 'cost_' . $code, true ) );

						}
					}
				}
			} else {

				if ( $duplicate ) {

					$this->duplicate_person( $tr_product_id, $person, $lang_code );

				} else {

					continue;

				}
			}
		}

		foreach ( $trnsl_persons as $trnsl_person ) {

			wp_delete_post( $trnsl_person );

		}

	}

	public function duplicate_person( $tr_product_id, $person_id, $lang_code ) {
		global $iclTranslationManagement;

		if ( method_exists( $this->sitepress, 'make_duplicate' ) ) {

			$new_person_id = $this->sitepress->make_duplicate( $person_id, $lang_code );

		} else {

			if ( ! isset( $iclTranslationManagement ) ) {
				$iclTranslationManagement = new TranslationManagement();
			}

			$new_person_id = $iclTranslationManagement->make_duplicate( $person_id, $lang_code );

		}

		$this->wpdb->update(
			$this->wpdb->posts,
			[
				'post_parent' => $tr_product_id,
			],
			[
				'ID' => $new_person_id,
			]
		);

		delete_post_meta( $new_person_id, '_icl_lang_duplicate_of' );

		return $new_person_id;
	}

	public function filter_wc_booking_cost( $check, $object_id, $meta_key, $single ) {

		if ( in_array(
			$meta_key,
			[
				'_wc_booking_cost',
				'_wc_booking_base_cost',
				'_wc_display_cost',
				'_wc_booking_pricing',
				'cost',
				'_wc_booking_block_cost',
				'block_cost',
				'_resource_base_costs',
				'_resource_block_costs',
			]
		) ) {

			if ( WCML_MULTI_CURRENCIES_INDEPENDENT === $this->woocommerce_wpml->settings['enable_multi_currency'] ) {

				$original_id = $this->woocommerce_wpml->products->get_original_product_id( $object_id );

				$cost_status = get_post_meta( $original_id, '_wcml_custom_costs_status', true );

				$currency = $this->woocommerce_wpml->multi_currency->get_client_currency();

				if ( $currency === wcml_get_woocommerce_currency_option() ) {
					return $check;
				}

				if ( in_array( $meta_key, [ 'cost', 'block_cost' ] ) ) {

					if ( get_post_type( $object_id ) == 'bookable_person' ) {

						$original_id = apply_filters( 'translate_object_id', wp_get_post_parent_id( $object_id ), 'product', true, $this->woocommerce_wpml->products->get_original_product_language( wp_get_post_parent_id( $object_id ) ) );
						$cost_status = get_post_meta( $original_id, '_wcml_custom_costs_status', true );

						$value = get_post_meta( $object_id, $meta_key . '_' . $currency, true );

						if ( $cost_status && $value ) {

							return $value;

						} else {

							remove_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10 );

							$cost = get_post_meta( $object_id, $meta_key, true );

							add_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10, 4 );

							return $this->woocommerce_wpml->multi_currency->prices->convert_price_amount( $cost, $currency );
						}
					} else {

						return $check;

					}
				}

				if ( in_array(
					$meta_key,
					[
						'_wc_booking_pricing',
						'_resource_base_costs',
						'_resource_block_costs',
					]
				) ) {

					remove_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10 );

					if ( $meta_key == '_wc_booking_pricing' ) {

						if ( $original_id != $object_id ) {
							$value = get_post_meta( $original_id, $meta_key );
						} else {
							$value = $check;
						}
					} else {

						$costs = maybe_unserialize( get_post_meta( $object_id, $meta_key, true ) );

						if ( ! $costs ) {
							$value = $check;
						} elseif ( $cost_status && isset( $costs['custom_costs'][ $currency ] ) ) {

							$res_costs = [];
							foreach ( $costs['custom_costs'][ $currency ] as $resource_id => $cost ) {
								$trns_resource_id               = apply_filters( 'translate_object_id', $resource_id, 'bookable_resource', true, $this->sitepress->get_current_language() );
								$res_costs[ $trns_resource_id ] = $cost;
							}
							$value = [ 0 => $res_costs ];
						} elseif ( $cost_status && isset( $costs[0]['custom_costs'][ $currency ] ) ) {
							$value = [ 0 => $costs[0]['custom_costs'][ $currency ] ];
						} else {

							$converted_values = [];

							foreach ( $costs as $resource_id => $cost ) {
								$converted_values[0][ $resource_id ] = $this->woocommerce_wpml->multi_currency->prices->convert_price_amount( $cost, $currency );
							}

							$value = $converted_values;
						}
					}

					add_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10, 4 );

					return $value;

				}

				$value = get_post_meta( $original_id, $meta_key . '_' . $currency, true );

				if ( $cost_status && ( ! empty( $value ) || ( empty( $value ) && $meta_key == '_wc_display_cost' ) ) ) {

					return $value;

				} else {

					remove_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10 );

					$value = get_post_meta( $original_id, $meta_key, true );

					$value = $this->woocommerce_wpml->multi_currency->prices->convert_price_amount( $value, $currency );

					add_filter( 'get_post_metadata', [ $this, 'filter_wc_booking_cost' ], 10, 4 );

					return $value;

				}
			}
		}

		return $check;
	}

	public function sync_resource_costs_with_translations( $object_id, $meta_key, $check = false ) {

		$original_product_id = $this->woocommerce_wpml->products->get_original_product_id( $object_id );

		if ( $object_id == $original_product_id ) {

			$translations = $this->wpml_post_translations->get_element_translations( $object_id, false, true );

			foreach ( $translations as $translation ) {
				$this->sync_resource_costs(
					$original_product_id,
					$translation,
					$meta_key,
					$this->wpml_post_translations->get_element_lang_code( $translation )
				);
			}

			return $check;
		} else {
			$this->sync_resource_costs(
				$original_product_id,
				$object_id,
				$meta_key,
				$this->wpml_post_translations->get_element_lang_code( $object_id )
			);
			return true;
		}

	}

	public function sync_resource_costs( $original_product_id, $object_id, $meta_key, $language_code ) {

		$original_costs = maybe_unserialize( get_post_meta( $original_product_id, $meta_key, true ) );

		$wc_booking_resource_costs = [];
		if ( ! empty( $original_costs ) ) {
			foreach ( $original_costs as $resource_id => $costs ) {

				if ( $resource_id == 'custom_costs' && isset( $costs['custom_costs'] ) ) {

					foreach ( $costs['custom_costs'] as $code => $currencies ) {

						foreach ( $currencies as $custom_costs_resource_id => $custom_cost ) {

							$trns_resource_id = apply_filters( 'translate_object_id', $custom_costs_resource_id, 'bookable_resource', true, $language_code );

							$wc_booking_resource_costs['custom_costs'][ $code ][ $trns_resource_id ] = $custom_cost;

						}
					}
				} else {

					$trns_resource_id = apply_filters( 'translate_object_id', $resource_id, 'bookable_resource', true, $language_code );

					$wc_booking_resource_costs[ $trns_resource_id ] = $costs;

				}
			}
		}

		update_post_meta( $object_id, $meta_key, $wc_booking_resource_costs );

	}

	public function wc_bookings_process_cost_rules_cost( $cost, $fields, $key ) {
		return $this->filter_pricing_cost( $cost, $fields, 'cost_', $key );
	}

	public function wc_bookings_process_cost_rules_base_cost( $base_cost, $fields, $key ) {
		return $this->filter_pricing_cost( $base_cost, $fields, 'base_cost_', $key );
	}

	public function wc_bookings_process_cost_rules_override_block_cost( $override_cost, $fields, $key ) {
		return $this->filter_pricing_cost( $override_cost, $fields, 'override_block_', $key );
	}

	public function filter_pricing_cost( $cost, $fields, $name, $key ) {
		global $product;

		if ( $this->woocommerce_wpml->settings['enable_multi_currency'] == WCML_MULTI_CURRENCIES_INDEPENDENT ) {

			$currency = $this->woocommerce_wpml->multi_currency->get_client_currency();

			if ( $currency === wcml_get_woocommerce_currency_option() ) {
				return $cost;
			}

			if ( isset( $_POST['form'] ) ) {
				parse_str( $_POST['form'], $posted );

				$booking_id = $posted['add-to-cart'];

			} elseif ( isset( $_POST['add-to-cart'] ) ) {

				$booking_id = $_POST['add-to-cart'];

			}

			if ( isset( $booking_id ) ) {
				$original_id = $this->woocommerce_wpml->products->get_original_product_id( $booking_id );

				if ( $booking_id != $original_id ) {
					$fields = maybe_unserialize( get_post_meta( $original_id, '_wc_booking_pricing', true ) );
					$fields = $fields[ $key ];
				}
			}

			$needs_filter_pricing_cost = $this->needs_filter_pricing_cost( $name, $fields );

			if ( $needs_filter_pricing_cost ) {
				if ( isset( $fields[ $name . $currency ] ) ) {
					return $fields[ $name . $currency ];
				} else {
					return $this->woocommerce_wpml->multi_currency->prices->convert_price_amount( $cost, $currency );
				}
			}
		}

		return $cost;

	}

	public function needs_filter_pricing_cost( $name, $fields ) {

		$modifier_skip_values = [ 'divide', 'times' ];

		if (
			'override_block_' === $name ||
			( 'cost_' === $name && ! in_array( $fields['modifier'], $modifier_skip_values ) ) ||
			( 'base_cost_' === $name && ! in_array( $fields['base_modifier'], $modifier_skip_values ) )
		) {
			return true;
		} else {
			return false;
		}
	}

	public function load_assets( $external_product_type = false ) {
		global $pagenow;

		$product_id = $pagenow == 'post.php' && isset( $_GET['post'] ) ? (int) $_GET['post'] : false;

		if ( $product_id && get_post_type( $product_id ) === 'product' ) {
			$product      = wc_get_product( $product_id );
			$product_type = $product->get_type();

			if ( ( $this->is_booking( $product ) || $product_type === $external_product_type ) || $pagenow == 'post-new.php' ) {

				wp_register_style( 'wcml-bookings-css', WCML_PLUGIN_URL . '/compatibility/res/css/wcml-bookings.css', [], WCML_VERSION );
				wp_enqueue_style( 'wcml-bookings-css' );

				wp_register_script( 'wcml-bookings-js', WCML_PLUGIN_URL . '/compatibility/res/js/wcml-bookings.js', [ 'jquery' ], WCML_VERSION, true );
				wp_enqueue_script( 'wcml-bookings-js' );

			}
		}

	}

	public function localize_lock_fields_js() {
		wp_localize_script( 'wcml-bookings-js', 'lock_settings', [ 'lock_fields' => 1 ] );
	}

	public function wcml_multi_currency_is_ajax( $actions ) {

		$actions[] = 'wc_bookings_calculate_costs';

		return $actions;
	}

	public function filter_bundled_product_in_cart_contents( $cart_item, $key, $current_language ) {

		if ( $cart_item['data'] instanceof WC_Product_Booking && isset( $cart_item['booking'] ) ) {

			$current_id      = apply_filters( 'translate_object_id', $cart_item['product_id'], 'product', true, $current_language );
			$cart_product_id = $cart_item['product_id'];

			if ( $current_id != $cart_product_id ) {

				$cart_item['data'] = new WC_Product_Booking( $current_id );

			}

			if ( $this->woocommerce_wpml->settings['enable_multi_currency'] == WCML_MULTI_CURRENCIES_INDEPENDENT || $current_id != $cart_product_id ) {

				$booking_info = [
					'wc_bookings_field_start_date_year'  => $cart_item['booking']['_year'],
					'wc_bookings_field_start_date_month' => $cart_item['booking']['_month'],
					'wc_bookings_field_start_date_day'   => $cart_item['booking']['_day'],
					'add-to-cart'                        => $current_id,
				];

				if ( isset( $cart_item['booking']['_persons'] ) ) {
					foreach ( $cart_item['booking']['_persons'] as $person_id => $value ) {
						$booking_info[ 'wc_bookings_field_persons_' . apply_filters( 'translate_object_id', $person_id, 'bookable_person', false, $current_language ) ] = $value;
					}
				}

				if ( isset( $cart_item['booking']['_resource_id'] ) ) {
					$booking_info['wc_bookings_field_resource'] = apply_filters( 'translate_object_id', $cart_item['booking']['_resource_id'], 'bookable_resource', false, $current_language );
				}

				if ( isset( $cart_item['booking']['_duration'] ) ) {
					$booking_info['wc_bookings_field_duration'] = $cart_item['booking']['_duration'];
				}

				if ( isset( $cart_item['booking']['_time'] ) ) {
					$booking_info['wc_bookings_field_start_date_time'] = $cart_item['booking']['_time'];
				}

				$current_product = wc_get_product( $current_id );

				$cost = $this->get_booking_cost( $booking_info, $current_product );

				if ( ! is_wp_error( $cost ) ) {
					$cart_item['data']->set_price( $cost );
				}
			}
		}

		return $cart_item;
	}

	private function get_booking_cost( $booking_info, $current_product ) {
		if ( class_exists( 'WC_Bookings_Cost_Calculation' ) ) {
			$cost = WC_Bookings_Cost_Calculation::calculate_booking_cost( wc_bookings_get_posted_data( $booking_info, $current_product ), $current_product );
		} else {
			$booking_form = new WC_Booking_Form( $current_product );
			$cost         = $booking_form->calculate_booking_cost( $booking_info );
		}

		return $cost;
	}

	public function booking_currency_dropdown() {

		if ( $this->woocommerce_wpml->settings['enable_multi_currency'] == WCML_MULTI_CURRENCIES_INDEPENDENT ) {
			$current_booking_currency = $this->get_cookie_booking_currency();

			$wc_currencies = get_woocommerce_currencies();
			$currencies    = $this->woocommerce_wpml->multi_currency->get_currencies( $include_default = true );
			?>
			<tr valign="top">
				<th scope="row"><?php _e( 'Booking currency', 'woocommerce-multilingual' ); ?></th>
				<td>
					<select id="dropdown_booking_currency">
						<?php foreach ( $currencies as $currency => $count ) : ?>
							<option
									value="<?php echo esc_html( $currency ); ?>" <?php echo $current_booking_currency == $currency ? 'selected="selected"' : ''; ?>><?php echo esc_html( $wc_currencies[ $currency ] ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>

			<?php

			$wcml_booking_set_currency_nonce = wp_create_nonce( 'booking_set_currency' );

			wc_enqueue_js(
				"

            jQuery(document).on('change', '#dropdown_booking_currency', function(){
               jQuery.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'wcml_booking_set_currency',
                        currency: jQuery('#dropdown_booking_currency').val(),
                        wcml_nonce: '" . $wcml_booking_set_currency_nonce . "'
                    },
                    success: function( response ){
                        if(typeof response.error !== 'undefined'){
                            alert(response.error);
                        }else{
                           window.location = window.location.href;
                        }
                    }
                })
            });
        "
			);

		}

	}

	public function set_booking_currency_ajax() {

		$nonce = filter_input( INPUT_POST, 'wcml_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'booking_set_currency' ) ) {
			echo json_encode( [ 'error' => __( 'Invalid nonce', 'woocommerce-multilingual' ) ] );
			die();
		}

		$this->set_booking_currency( filter_input( INPUT_POST, 'currency', FILTER_SANITIZE_FULL_SPECIAL_CHARS ) );

		die();
	}

	public function set_booking_currency( $currency_code = false ) {
		$cookie_name = '_wcml_booking_currency';

		if ( ! isset( $_COOKIE[ $cookie_name ] ) && ! headers_sent() ) {
			$currency_code = wcml_get_woocommerce_currency_option();

			if ( WCML_MULTI_CURRENCIES_INDEPENDENT === $this->woocommerce_wpml->settings['enable_multi_currency'] ) {
				$currency_code = $this->woocommerce_wpml->multi_currency->get_currency_code();
			}
		}

		if ( $currency_code ) {
			// @todo uncomment or delete when #wpmlcore-5796 is resolved
			// do_action( 'wpsc_add_cookie', $cookie_name );
			setcookie( $cookie_name, $currency_code, time() + 86400, COOKIEPATH, COOKIE_DOMAIN );
		}
	}

	public function get_cookie_booking_currency() {

		if ( isset( $_COOKIE ['_wcml_booking_currency'] ) ) {
			$currency = $_COOKIE['_wcml_booking_currency'];
		} else {
			$currency = wcml_get_woocommerce_currency_option();
		}

		return $currency;
	}

	public function filter_booking_currency_symbol( $currency ) {
		global $pagenow;

		remove_filter( 'woocommerce_currency_symbol', [ $this, 'filter_booking_currency_symbol' ] );
		if ( isset( $_COOKIE ['_wcml_booking_currency'] ) && $pagenow == 'edit.php' && isset( $_GET['page'] ) && $_GET['page'] == 'create_booking' ) {
			$currency = get_woocommerce_currency_symbol( $_COOKIE ['_wcml_booking_currency'] );
		}
		add_filter( 'woocommerce_currency_symbol', [ $this, 'filter_booking_currency_symbol' ] );

		return $currency;
	}

	public function create_booking_page_client_currency( $currency ) {
		global $pagenow;

		if ( wpml_is_ajax() && isset( $_POST['form'] ) ) {
			parse_str( $_POST['form'], $posted );
		}

		if ( ( $pagenow == 'edit.php' && isset( $_GET['page'] ) && $_GET['page'] == 'create_booking' ) || ( isset( $posted['_wp_http_referer'] ) && strpos( $posted['_wp_http_referer'], 'page=create_booking' ) !== false ) ) {
			$currency = $this->get_cookie_booking_currency();
		}

		return $currency;
	}

	public function set_order_currency_on_create_booking_page( $order_id ) {
		update_post_meta( $order_id, '_order_currency', $this->get_cookie_booking_currency() );

		update_post_meta( $order_id, 'wpml_language', $this->sitepress->get_current_language() );

	}

	public function filter_get_booking_products_args( $args ) {
		if ( isset( $args['suppress_filters'] ) ) {
			$args['suppress_filters'] = false;
		}

		return $args;
	}

	public function custom_box_html( $obj, $product_id, $data ) {

		if ( ! $this->is_booking( $product_id ) ) {
			return;
		}

		$bookings_section = new WPML_Editor_UI_Field_Section( __( 'Bookings', 'woocommerce-multilingual' ) );

		if ( get_post_meta( $product_id, '_wc_booking_has_resources', true ) == 'yes' ) {
			$group         = new WPML_Editor_UI_Field_Group( '', true );
			$booking_field = new WPML_Editor_UI_Single_Line_Field( '_wc_booking_resouce_label', __( 'Resources Label', 'woocommerce-multilingual' ), $data, true );
			$group->add_field( $booking_field );
			$bookings_section->add_field( $group );
		}

		$orig_resources = maybe_unserialize( get_post_meta( $product_id, '_resource_base_costs', true ) );

		if ( $orig_resources ) {
			$group       = new WPML_Editor_UI_Field_Group( __( 'Resources', 'woocommerce-multilingual' ) );
			$group_title = __( 'Resources', 'woocommerce-multilingual' );
			foreach ( $orig_resources as $resource_id => $cost ) {

				if ( $resource_id == 'custom_costs' ) {
					continue;
				}

				$group       = new WPML_Editor_UI_Field_Group( $group_title );
				$group_title = '';

				$resource_field = new WPML_Editor_UI_Single_Line_Field( 'bookings-resource_' . $resource_id . '_title', __( 'Title', 'woocommerce-multilingual' ), $data, true );
				$group->add_field( $resource_field );
				$bookings_section->add_field( $group );
			}
		}

		$original_persons = $this->get_original_persons( $product_id );
		end( $original_persons );
		$last_key    = key( $original_persons );
		$divider     = true;
		$group_title = __( 'Person Types', 'woocommerce-multilingual' );
		foreach ( $original_persons as $person_id ) {
			if ( $person_id == $last_key ) {
				$divider = false;
			}
			$group       = new WPML_Editor_UI_Field_Group( $group_title, $divider );
			$group_title = '';

			$person_field = new WPML_Editor_UI_Single_Line_Field( 'bookings-person_' . $person_id . '_title', __( 'Person Type Name', 'woocommerce-multilingual' ), $data, false );
			$group->add_field( $person_field );
			$person_field = new WPML_Editor_UI_Single_Line_Field( 'bookings-person_' . $person_id . '_description', __( 'Description', 'woocommerce-multilingual' ), $data, false );
			$group->add_field( $person_field );
			$bookings_section->add_field( $group );

		}

		if ( $orig_resources || $original_persons ) {
			$obj->add_field( $bookings_section );
		}

	}


	public function custom_box_html_data( $data, $product_id, $translation, $lang ) {

		if ( ! $this->is_booking( $product_id ) ) {
			return $data;
		}

		if ( get_post_meta( $product_id, '_wc_booking_has_resources', true ) == 'yes' ) {

			$data['_wc_booking_resouce_label']                = [ 'original' => get_post_meta( $product_id, '_wc_booking_resouce_label', true ) ];
			$data['_wc_booking_resouce_label']['translation'] = $translation ? get_post_meta( $translation->ID, '_wc_booking_resouce_label', true ) : '';
		}

		$orig_resources = $this->get_original_resources( $product_id );

		if ( $orig_resources && is_array( $orig_resources ) ) {

			foreach ( $orig_resources as $resource_id => $cost ) {

				if ( 'custom_costs' === $resource_id ) {
					continue;
				}
				$data[ 'bookings-resource_' . $resource_id . '_title' ] = [ 'original' => get_the_title( $resource_id ) ];
				global $sitepress;
				$trns_resource_id = apply_filters( 'translate_object_id', $resource_id, 'bookable_resource', false, $lang );
				$data[ 'bookings-resource_' . $resource_id . '_title' ]['translation'] = $trns_resource_id ? get_the_title( $trns_resource_id ) : '';
			}
		}

		$original_persons = $this->get_original_persons( $product_id );

		foreach ( $original_persons as $person_id ) {

			$data[ 'bookings-person_' . $person_id . '_title' ]       = [ 'original' => get_the_title( $person_id ) ];
			$data[ 'bookings-person_' . $person_id . '_description' ] = [ 'original' => get_post( $person_id )->post_excerpt ];

			$trnsl_person_id = apply_filters( 'translate_object_id', $person_id, 'bookable_person', false, $lang );
			$data[ 'bookings-person_' . $person_id . '_title' ]['translation']       = $trnsl_person_id ? get_the_title( $trnsl_person_id ) : '';
			$data[ 'bookings-person_' . $person_id . '_description' ]['translation'] = $trnsl_person_id ? get_post( $trnsl_person_id )->post_excerpt : '';

		}

		return $data;
	}


	public function get_original_resources( $product_id ) {
		$orig_resources = maybe_unserialize( get_post_meta( $product_id, '_resource_base_costs', true ) );

		return $orig_resources;
	}

	public function get_original_persons( $product_id ) {
		$original_persons = $this->wpdb->get_col( $this->wpdb->prepare( "SELECT ID FROM {$this->wpdb->posts} WHERE post_parent = %d AND post_type = 'bookable_person' AND post_status = 'publish'", $product_id ) );

		return $original_persons;
	}

	public function show_custom_blocks_for_resources_and_persons( $check, $product_id, $product_content ) {
		if ( in_array( $product_content, [ 'wc_booking_resources', 'wc_booking_persons' ] ) ) {
			return false;
		}

		return $check;
	}

	public function replace_tm_editor_custom_fields_with_own_sections( $fields ) {
		$fields[] = '_resource_base_costs';
		$fields[] = '_resource_block_costs';

		return $fields;
	}

	public function remove_single_custom_fields_to_translate( $fields ) {
		$fields[] = '_wc_booking_resouce_label';

		return $fields;
	}

	public function product_content_resource_label( $meta_key, $product_id ) {
		if ( $meta_key == '_wc_booking_resouce_label' ) {
			return __( 'Resources label', 'woocommerce-multilingual' );
		}

		return $meta_key;
	}

	public function wcml_products_tab_sync_resources_and_persons( $original_product_id, $tr_product_id, $data, $language ) {
		global $wpml_post_translations;

		remove_action( 'save_post', [ $wpml_post_translations, 'save_post_actions' ], 100 );

		$orig_resources = $orig_resources = $this->get_original_resources( $original_product_id );

		if ( $orig_resources ) {

			foreach ( $orig_resources as $orig_resource_id => $cost ) {

				$resource_id   = apply_filters( 'translate_object_id', $orig_resource_id, 'bookable_resource', false, $language );
				$orig_resource = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT resource_id, sort_order FROM {$this->wpdb->prefix}wc_booking_relationships WHERE resource_id = %d AND product_id = %d", $orig_resource_id, $original_product_id ), OBJECT );

				if ( is_null( $resource_id ) ) {

					if ( $orig_resource ) {
						$resource_id = $this->duplicate_resource( $tr_product_id, $orig_resource, $language );
					} else {
						continue;
					}
				} else {
					// update_relationship
					$exist = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT ID FROM {$this->wpdb->prefix}wc_booking_relationships WHERE resource_id = %d AND product_id = %d", $resource_id, $tr_product_id ) );

					if ( ! $exist ) {

						$this->wpdb->insert(
							$this->wpdb->prefix . 'wc_booking_relationships',
							[
								'product_id'  => $tr_product_id,
								'resource_id' => $resource_id,
								'sort_order'  => $orig_resource->sort_order,
							]
						);

					}
				}

				$this->wpdb->update(
					$this->wpdb->posts,
					[
						'post_title' => $data[ md5( 'bookings-resource_' . $orig_resource_id . '_title' ) ],
					],
					[
						'ID' => $resource_id,
					]
				);

				update_post_meta( $resource_id, 'wcml_is_translated', true );

			}

			// sync resources data
			$this->sync_resources( $original_product_id, $tr_product_id, $language, false );

		}

		$original_persons = $this->get_original_persons( $original_product_id );

		// sync persons
		if ( $original_persons ) {

			foreach ( $original_persons as $original_person_id ) {

				$person_id = apply_filters( 'translate_object_id', $original_person_id, 'bookable_person', false, $language );

				if ( is_null( $person_id ) ) {

					$person_id = $this->duplicate_person( $tr_product_id, $original_person_id, $language );

				} else {

					$this->wpdb->update(
						$this->wpdb->posts,
						[
							'post_parent' => $tr_product_id,
						],
						[
							'ID' => $person_id,
						]
					);

				}

				$this->wpdb->update(
					$this->wpdb->posts,
					[
						'post_title'   => $data[ md5( 'bookings-person_' . $original_person_id . '_title' ) ],
						'post_excerpt' => $data[ md5( 'bookings-person_' . $original_person_id . '_description' ) ],
					],
					[
						'ID' => $person_id,
					]
				);

				update_post_meta( $person_id, 'wcml_is_translated', true );

			}

			// sync persons data
			$this->sync_persons( $original_product_id, $tr_product_id, $language, false );

		}

		add_action( 'save_post', [ $wpml_post_translations, 'save_post_actions' ], 100, 2 );

	}

	public function duplicate_booking_for_translations( $booking_id, $lang = false ) {
		$booking_object = get_post( $booking_id );

		$booking_data = [
			'post_type'   => 'wc_booking',
			'post_title'  => $booking_object->post_title,
			'post_status' => $booking_object->post_status,
			'ping_status' => 'closed',
		];

		if ( $booking_object->post_parent && $lang ) {
			$translated_parent = apply_filters( 'translate_object_id', $booking_object->post_parent, get_post_type( $booking_object->post_parent ), false, $lang );
			if ( $translated_parent ) {
				$booking_data['post_parent'] = $translated_parent;
			}
		}

		$active_languages = $this->sitepress->get_active_languages();

		foreach ( $active_languages as $language ) {

			$booking_product_id = get_post_meta( $booking_id, '_booking_product_id', true );

			if ( ! $lang ) {
				$booking_language = $this->sitepress->get_element_language_details( $booking_product_id, 'post_product' );
				if ( $booking_language->language_code == $language['code'] ) {
					continue;
				}
			} elseif ( $lang != $language['code'] ) {
				continue;
			}

			$booking_persons       = maybe_unserialize( get_post_meta( $booking_id, '_booking_persons', true ) );
			$trnsl_booking_persons = [];

			if ( is_array( $booking_persons ) && ! empty( $booking_persons ) ) {
				foreach ( $booking_persons as $person_id => $person_count ) {

					$trnsl_person_id = apply_filters( 'translate_object_id', $person_id, 'bookable_person', false, $language['code'] );

					if ( is_null( $trnsl_person_id ) ) {
						$trnsl_booking_persons[] = $person_count;
					} else {
						$trnsl_booking_persons[ $trnsl_person_id ] = $person_count;
					}
				}
			}

			$trnsl_booking_id = wp_insert_post( $booking_data );
			$trid             = $this->sitepress->get_element_trid( $booking_id );
			$this->sitepress->set_element_language_details( $trnsl_booking_id, 'post_wc_booking', $trid, $language['code'] );

			$meta_args = [
				'_booking_order_item_id' => 0,
				'_booking_product_id'    => $this->get_translated_booking_product_id( $booking_id, $language['code'] ),
				'_booking_resource_id'   => $this->get_translated_booking_resource_id( $booking_id, $language['code'] ),
				'_booking_persons'       => $this->get_translated_booking_persons_ids( $booking_id, $language['code'] ),
				'_booking_cost'          => get_post_meta( $booking_id, '_booking_cost', true ),
				'_booking_start'         => get_post_meta( $booking_id, '_booking_start', true ),
				'_booking_end'           => get_post_meta( $booking_id, '_booking_end', true ),
				'_booking_all_day'       => intval( get_post_meta( $booking_id, '_booking_all_day', true ) ),
				'_booking_parent_id'     => get_post_meta( $booking_id, '_booking_parent_id', true ),
				'_booking_customer_id'   => get_post_meta( $booking_id, '_booking_customer_id', true ),
				'_booking_duplicate_of'  => $booking_id,
				'_language_code'         => $language['code'],
			];

			foreach ( $meta_args as $key => $value ) {
				update_post_meta( $trnsl_booking_id, $key, $value );
			}

			WC_Cache_Helper::get_transient_version( 'bookings', true );

		}

	}

	public function get_translated_booking_product_id( $booking_id, $language ) {

		$booking_product_id       = get_post_meta( $booking_id, '_booking_product_id', true );
		$trnsl_booking_product_id = '';

		if ( $booking_product_id ) {
			$trnsl_booking_product_id = apply_filters( 'translate_object_id', $booking_product_id, 'product', false, $language );
			if ( is_null( $trnsl_booking_product_id ) ) {
				$trnsl_booking_product_id = '';
			}
		}

		return $trnsl_booking_product_id;

	}

	public function get_translated_booking_resource_id( $booking_id, $language ) {

		$booking_resource_id       = get_post_meta( $booking_id, '_booking_resource_id', true );
		$trnsl_booking_resource_id = '';

		if ( $booking_resource_id ) {
			$trnsl_booking_resource_id = apply_filters( 'translate_object_id', $booking_resource_id, 'bookable_resource', false, $language );

			if ( is_null( $trnsl_booking_resource_id ) ) {
				$trnsl_booking_resource_id = '';
			}
		}

		return $trnsl_booking_resource_id;
	}

	public function get_translated_booking_persons_ids( $booking_id, $language ) {

		$booking_persons       = maybe_unserialize( get_post_meta( $booking_id, '_booking_persons', true ) );
		$trnsl_booking_persons = [];

		if ( is_array( $booking_persons ) && ! empty( $booking_persons ) ) {
			foreach ( $booking_persons as $person_id => $person_count ) {

				$trnsl_person_id = apply_filters( 'translate_object_id', $person_id, 'bookable_person', false, $language );

				if ( is_null( $trnsl_person_id ) ) {
					$trnsl_booking_persons[] = $person_count;
				} else {
					$trnsl_booking_persons[ $trnsl_person_id ] = $person_count;
				}
			}
		}

		return $trnsl_booking_persons;

	}

	public function update_status_for_translations( $booking_id ) {

		foreach ( $this->get_translated_bookings( $booking_id ) as $translated_booking_id ) {

			$status   = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT post_status FROM {$this->wpdb->posts} WHERE ID = %d", $booking_id ) ); // get_post_status( $booking_id );
			$language = get_post_meta( $translated_booking_id, '_language_code', true );

			$this->wpdb->update(
				$this->wpdb->posts,
				[
					'post_status' => $status,
					'post_parent' => wp_get_post_parent_id( $booking_id ),
				],
				[
					'ID' => $translated_booking_id,
				]
			);

			$this->update_translated_booking_meta( $translated_booking_id, $booking_id, $language );
		}

	}

	public function get_translated_bookings( $booking_id, $actual_translations_only = true ) {

		return $this->wpml_post_translations->get_element_translations( $booking_id, false, $actual_translations_only );
	}

	public function booking_filters_query( $query ) {
		global $typenow;

		if ( ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'wc_booking' ) ) {

			$current_lang = $this->sitepress->get_current_language();

			$product_ids = $this->wpdb->get_col(
				$this->wpdb->prepare(
					"SELECT element_id
					FROM {$this->wpdb->prefix}icl_translations
					WHERE language_code = %s AND element_type = 'post_product'",
					$current_lang
				)
			);

			$product_ids = array_diff( $product_ids, [ null ] );

			if ( ( ! isset( $_GET['lang'] ) || ( isset( $_GET['lang'] ) && $_GET['lang'] != 'all' ) ) ) {
				$query->query_vars['meta_query'][] = [
					'relation' => 'OR',
					[
						'key'      => '_language_code',
						'value'    => $current_lang,
						'compare ' => '=',
					],
					[
						'key'      => '_booking_product_id',
						'value'    => $product_ids,
						'compare ' => 'IN',
					],
				];
			}
		}

		return $query;
	}

	public function bookings_in_date_range_query( $booking_ids ) {
		foreach ( $booking_ids as $key => $booking_id ) {

			$language_code    = $this->sitepress->get_language_for_element( get_post_meta( $booking_id, '_booking_product_id', true ), 'post_product' );
			$current_language = $this->sitepress->get_current_language();

			if ( $language_code != $current_language ) {
				unset( $booking_ids[ $key ] );
			}
		}

		return $booking_ids;

	}

	public function clear_transient_fields() {

		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wc_booking' && isset( $_GET['page'] ) && $_GET['page'] == 'booking_calendar' ) {

			// delete transient fields
			$this->wpdb->query(
				"
                DELETE FROM {$this->wpdb->options}
		        WHERE option_name LIKE '%book_dr_%'
		    "
			);

		}

	}

	public function delete_bookings( $booking_id ) {

		if (
			! $this->is_delete_all_action()
			&& $booking_id
			&& get_post_type( $booking_id ) == 'wc_booking'
		) {
			remove_action( 'before_delete_post', [ $this, 'delete_bookings' ] );

			foreach ( $this->get_translated_bookings( $booking_id ) as $translated_booking_id ) {
				$this->wpdb->update(
					$this->wpdb->posts,
					[
						'post_parent' => 0,
					],
					[
						'ID' => $translated_booking_id,
					]
				);

				wp_delete_post( $translated_booking_id );

			}

			add_action( 'before_delete_post', [ $this, 'delete_bookings' ] );
		}
	}

	private function is_delete_all_action() {
		return array_key_exists( 'delete_all', $_GET ) && $_GET['delete_all'];
	}

	public function trash_bookings( $booking_id ) {

		if ( $booking_id > 0 && get_post_type( $booking_id ) == 'wc_booking' ) {

			foreach ( $this->get_translated_bookings( $booking_id ) as $translated_booking_id ) {

				$this->wpdb->update(
					$this->wpdb->posts,
					[
						'post_status' => 'trash',
					],
					[
						'ID' => $translated_booking_id,
					]
				);

			}
		}

	}

	public function append_persons_to_translation_package( $package, $post ) {
		if ( 'product' === $post->post_type ) {
			if ( $this->is_booking( $post->ID ) ) {

				$bookable_product = new WC_Product_Booking( $post->ID );

				$person_types = $bookable_product->get_person_types();

				foreach ( $person_types as $person_type ) {

					$bookable_person = get_post( $person_type->ID );

					$package['contents'][ 'wc_bookings:person:' . $bookable_person->ID . ':name' ] = [
						'translate' => 1,
						'data'      => $this->tp->encode_field_data( $bookable_person->post_title, 'base64' ),
						'format'    => 'base64',
					];

					$package['contents'][ 'wc_bookings:person:' . $bookable_person->ID . ':description' ] = [
						'translate' => 1,
						'data'      => $this->tp->encode_field_data( $bookable_person->post_excerpt, 'base64' ),
						'format'    => 'base64',
					];

				}
			}
		}

		return $package;
	}

	private function save_person_translation( $post_id, $data, $job ) {
		$person_translations = [];

		if ( $this->is_booking( $post_id ) ) {

			foreach ( $data as $value ) {

				if ( $value['finished'] && strpos( $value['field_type'], 'wc_bookings:person:' ) === 0 ) {

					$exp = explode( ':', $value['field_type'] );

					$person_id = $exp[2];
					$field     = $exp[3];

					$person_translations[ $person_id ][ $field ] = $value['data'];

				}
			}

			if ( $person_translations ) {

				foreach ( $person_translations as $person_id => $pt ) {

					$person_trid = $this->sitepress->get_element_trid( $person_id, 'post_bookable_person' );

					$person_id_translated = apply_filters( 'translate_object_id', $person_id, 'bookable_person', false, $job->language_code );

					if ( empty( $person_id_translated ) ) {

						$person_post = [

							'post_type'    => 'bookable_person',
							'post_status'  => 'publish',
							'post_title'   => $pt['name'],
							'post_parent'  => $post_id,
							'post_excerpt' => isset( $pt['description'] ) ? $pt['description'] : '',

						];

						$person_id_translated = wp_insert_post( $person_post );

						$this->sitepress->set_element_language_details( $person_id_translated, 'post_bookable_person', $person_trid, $job->language_code );

					} else {

						$person_post = [
							'ID'           => $person_id_translated,
							'post_title'   => $pt['name'],
							'post_excerpt' => isset( $pt['description'] ) ? $pt['description'] : '',
						];

						wp_update_post( $person_post );

					}
				}
			}
		}

	}

	public function append_resources_to_translation_package( $package, $post ) {

		if ( $post->post_type == 'product' ) {
			$product = wc_get_product( $post->ID );
			if ( $this->is_booking( $product ) && $product->has_resources() ) {

				$resources = $product->get_resources();

				foreach ( $resources as $resource ) {

					$package['contents'][ 'wc_bookings:resource:' . $resource->ID . ':name' ] = [
						'translate' => 1,
						'data'      => $this->tp->encode_field_data( $resource->post_title, 'base64' ),
						'format'    => 'base64',
					];

				}
			}
		}

		return $package;

	}

	private function save_resource_translation( $post_id, $data, $job ) {
		$resource_translations = [];

		if ( $this->is_booking( $post_id ) ) {

			foreach ( $data as $value ) {

				if ( $value['finished'] && strpos( $value['field_type'], 'wc_bookings:resource:' ) === 0 ) {

					$exp = explode( ':', $value['field_type'] );

					$resource_id = $exp[2];
					$field       = $exp[3];

					$resource_translations[ $resource_id ][ $field ] = $value['data'];

				}
			}

			if ( $resource_translations ) {

				foreach ( $resource_translations as $resource_id => $rt ) {

					$resource_trid = $this->sitepress->get_element_trid( $resource_id, 'post_bookable_resource' );

					$resource_id_translated = apply_filters( 'translate_object_id', $resource_id, 'bookable_resource', false, $job->language_code );

					if ( empty( $resource_id_translated ) ) {

						$resource_post = [

							'post_type'   => 'bookable_resource',
							'post_status' => 'publish',
							'post_title'  => $rt['name'],
							'post_parent' => $post_id,
						];

						$resource_id_translated = wp_insert_post( $resource_post );

						$this->sitepress->set_element_language_details( $resource_id_translated, 'post_bookable_resource', $resource_trid, $job->language_code );

						$sort_order   = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT sort_order FROM {$this->wpdb->prefix}wc_booking_relationships WHERE resource_id=%d", $resource_id ) );
						$relationship = [
							'product_id'  => $post_id,
							'resource_id' => $resource_id_translated,
							'sort_order'  => $sort_order,
						];
						$this->wpdb->insert( $this->wpdb->prefix . 'wc_booking_relationships', $relationship );

					} else {

						$resource_post = [
							'ID'         => $resource_id_translated,
							'post_title' => $rt['name'],
						];

						wp_update_post( $resource_post );

						$sort_order = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT sort_order FROM {$this->wpdb->prefix}wc_booking_relationships WHERE resource_id=%d", $resource_id ) );
						$this->wpdb->update(
							$this->wpdb->prefix . 'wc_booking_relationships',
							[ 'sort_order' => $sort_order ],
							[
								'product_id'  => $post_id,
								'resource_id' => $resource_id_translated,
							]
						);

					}
				}
			}
		}

	}

	public function wcml_js_lock_fields_ids( $ids ) {
		$ids = array_merge(
			$ids,
			[
				'_wc_booking_has_resources',
				'_wc_booking_has_persons',
				'_wc_booking_duration_type',
				'_wc_booking_duration',
				'_wc_booking_duration_unit',
				'_wc_booking_calendar_display_mode',
				'_wc_booking_requires_confirmation',
				'_wc_booking_user_can_cancel',
				'_wc_accommodation_booking_min_duration',
				'_wc_accommodation_booking_max_duration',
				'_wc_accommodation_booking_max_duration',
				'_wc_accommodation_booking_calendar_display_mode',
				'_wc_accommodation_booking_requires_confirmation',
				'_wc_accommodation_booking_user_can_cancel',
				'_wc_accommodation_booking_cancel_limit',
				'_wc_accommodation_booking_cancel_limit_unit',
				'_wc_accommodation_booking_qty',
				'_wc_accommodation_booking_min_date',
				'_wc_accommodation_booking_min_date_unit',
				'_wc_accommodation_booking_max_date',
				'_wc_accommodation_booking_max_date_unit',
				'bookings_pricing select',
				'bookings_resources select',
				'bookings_availability select',
				'bookings_persons input[type="checkbox"]',
			]
		);

		return $ids;
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	public function filter_get_booking_resources_args( $args ) {

		$screen = get_current_screen();
		if ( $screen->id == 'product' ) {
			$args['suppress_filters'] = false;
		}

		return $args;

	}

	/**
	 * @param array $currencies
	 * @param int   $post_id
	 *
	 * @return bool
	 */
	private function update_booking_costs( $currencies = [], $post_id = 0 ) {
		$booking_options = [
			'wcml_wc_booking_cost'       => '_wc_booking_cost_',
			'wcml_wc_booking_block_cost' => '_wc_booking_block_cost_',
			'wcml_wc_display_cost'       => '_wc_display_cost_',
		];

		if ( $this->sitepress->get_wp_api()->version_compare( $this->sitepress->get_wp_api()->constant( 'WC_BOOKINGS_VERSION' ), '1.10.9', '<' ) ) {
			unset( $booking_options['wcml_wc_booking_block_cost'] );
			$booking_options['wcml_wc_booking_base_cost'] = '_wc_booking_base_cost_';
		}

		foreach ( $currencies as $code => $currency ) {
			foreach ( $booking_options as $booking_options_post_key => $booking_options_meta_key_prefix ) {
				if ( isset( $_POST[ $booking_options_post_key ][ $code ] ) ) {
					update_post_meta( $post_id, $booking_options_meta_key_prefix . $code, sanitize_text_field( $_POST[ $booking_options_post_key ][ $code ] ) );
				}
			}
		}

		return true;
	}

	/**
	 * @param array $currencies
	 * @param int   $post_id
	 *
	 * @return bool
	 */
	private function update_booking_pricing( $currencies = [], $post_id = 0 ) {
		$updated_meta    = [];
		$booking_pricing = get_post_meta( $post_id, '_wc_booking_pricing', true );
		if ( empty( $booking_pricing ) ) {
			return false;
		}

		foreach ( $booking_pricing as $key => $prices ) {
			$updated_meta[ $key ] = $prices;
			foreach ( $currencies as $code => $currency ) {
				if ( isset( $_POST['wcml_wc_booking_pricing_base_cost'][ $code ][ $key ] ) ) {
					$updated_meta[ $key ][ 'base_cost_' . $code ] = sanitize_text_field( $_POST['wcml_wc_booking_pricing_base_cost'][ $code ][ $key ] );
				}
				if ( isset( $_POST['wcml_wc_booking_pricing_cost'][ $code ][ $key ] ) ) {
					$updated_meta[ $key ][ 'cost_' . $code ] = sanitize_text_field( $_POST['wcml_wc_booking_pricing_cost'][ $code ][ $key ] );
				}
			}
		}

		update_post_meta( $post_id, '_wc_booking_pricing', $updated_meta );

		return true;
	}

	/**
	 * @param array $currencies
	 * @param array $person_costs
	 *
	 * @return bool
	 */
	private function update_booking_person_cost( $currencies = [], $person_costs = [] ) {
		if ( empty( $person_costs ) ) {
			return false;
		}

		foreach ( $person_costs as $person_id => $costs ) {
			foreach ( $currencies as $code => $currency ) {
				if ( isset( $costs[ $code ] ) ) {
					update_post_meta( $person_id, 'cost_' . $code, sanitize_text_field( $costs[ $code ] ) );
				}
			}
		}

		return true;
	}

	/**
	 * @param array $currencies
	 * @param array $block_costs
	 *
	 * @return bool
	 */
	private function update_booking_person_block_cost( $currencies = [], $block_costs = [] ) {
		if ( empty( $block_costs ) ) {
			return false;
		}

		foreach ( $block_costs as $person_id => $costs ) {
			foreach ( $currencies as $code => $currency ) {
				if ( isset( $costs[ $code ] ) ) {
					update_post_meta( $person_id, 'block_cost_' . $code, sanitize_text_field( $costs[ $code ] ) );
				}
			}
		}

		return true;
	}

	/**
	 * @param array $currencies
	 * @param int   $post_id
	 * @param array $resource_cost
	 *
	 * @return bool
	 */
	private function update_booking_resource_cost( $currencies = [], $post_id = 0, $resource_cost = [] ) {
		if ( empty( $resource_cost ) ) {
			return false;
		}

		$updated_meta = get_post_meta( $post_id, '_resource_base_costs', true );
		if ( ! is_array( $updated_meta ) ) {
			$updated_meta = [];
		}

		$wc_booking_resource_costs = [];

		foreach ( $resource_cost as $resource_id => $costs ) {

			foreach ( $currencies as $code => $currency ) {

				if ( isset( $costs[ $code ] ) ) {
					$wc_booking_resource_costs[ $code ][ $resource_id ] = sanitize_text_field( $costs[ $code ] );
				}
			}
		}

		$updated_meta['custom_costs'] = $wc_booking_resource_costs;

		update_post_meta( $post_id, '_resource_base_costs', $updated_meta );

		$this->sync_resource_costs_with_translations( $post_id, '_resource_base_costs' );

		return true;
	}

	/**
	 * @param array $currencies
	 * @param int   $post_id
	 *
	 * @return bool
	 */
	private function update_booking_resource_block_cost( $currencies = [], $post_id = 0, $resource_block_cost = [] ) {
		if ( empty( $resource_block_cost ) ) {
			return false;
		}

		$updated_meta = get_post_meta( $post_id, '_resource_block_costs', true );

		$wc_booking_resource_block_costs = [];

		foreach ( $resource_block_cost as $resource_id => $costs ) {

			foreach ( $currencies as $code => $currency ) {

				if ( isset( $costs[ $code ] ) ) {
					$wc_booking_resource_block_costs[ $code ][ $resource_id ] = sanitize_text_field( $costs[ $code ] );
				}
			}
		}

		$updated_meta['custom_costs'] = $wc_booking_resource_block_costs;

		update_post_meta( $post_id, '_resource_block_costs', $updated_meta );

		$this->sync_resource_costs_with_translations( $post_id, '_resource_block_costs' );

		return true;
	}

	public function extra_conditions_to_filter_bookings( $extra_conditions ) {

		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'wc_booking' && ! isset( $_GET['post_status'] ) ) {
			$extra_conditions = str_replace( 'GROUP BY', " AND post_status = 'confirmed' GROUP BY", $extra_conditions );
		}

		return $extra_conditions;
	}

	public function hide_bookings_type_on_tm_dashboard( $types ) {
		unset( $types['wc_booking'] );
		return $types;
	}

	public function show_pointer_info() {

		$pointer_ui = new WCML_Pointer_UI(
			sprintf( __( 'You can translate the titles of your custom Resources on the %1$sWooCommerce product translation page%2$s', 'woocommerce-multilingual' ), '<a href="' . admin_url( 'admin.php?page=wpml-wcml' ) . '">', '</a>' ),
			WCML_Tracking_Link::getWcmlBookingsDoc(),
			'bookings_resources .woocommerce_bookable_resources #message'
		);

		$pointer_ui->show();

		$pointer_ui = new WCML_Pointer_UI(
			sprintf( __( 'You can translate the Person Type Name and Description on the  %1$sWooCommerce product translation page%2$s', 'woocommerce-multilingual' ), '<a href="' . admin_url( 'admin.php?page=wpml-wcml' ) . '">', '</a>' ),
			WCML_Tracking_Link::getWcmlBookingsDoc(),
			'bookings_persons #persons-types>div.toolbar'
		);

		$pointer_ui->show();

	}

	public function add_to_cart_sold_individually( $sold_indiv, $cart_item_data, $product_id, $quantity ) {

		if ( isset( $cart_item_data['booking'] ) ) {
			$sold_indiv = false;
			foreach ( WC()->cart->cart_contents as $cart_item ) {
				if (
					isset( $cart_item['booking'] ) && isset( $cart_item['booking']['_booking_id'] ) &&
					$cart_item['booking']['_start_date'] == $cart_item_data['booking']['_start_date'] &&
					$cart_item['booking']['_end_date'] == $cart_item_data['booking']['_end_date'] &&
					$cart_item['booking']['_booking_id'] == $cart_item_data['booking']['_booking_id']
				) {
					$sold_indiv = true;
				}
			}
		}

		return $sold_indiv;
	}

	// unset "bookings" from translatable documents to hide WPML languages section from booking edit page
	public function filter_translatable_documents( $icl_post_types ) {

		if (
			( isset( $_GET['post_type'] ) && 'wc_booking' === $_GET['post_type'] ) ||
			( isset( $_GET['post'] ) && 'wc_booking' === get_post_type( $_GET['post'] ) )
		) {
			unset( $icl_post_types['wc_booking'] );
		}

		return $icl_post_types;
	}

	// hide WPML languages links section from bookings list page
	public function filter_is_translated_post_type( $type ) {

		$getData = wpml_collect( $_GET );

		if( 'wc_booking' === $getData->get('post_type') && 'create_booking' !== $getData->get( 'page' ) ){
			return false;
		}

		return $type;
	}

	/**
	 * @param int     $post_id
	 * @param WP_Post $post
	 * @param bool    $update
	 */
	public function sync_booking_status( $post_id, $post, $update ) {

		if ( $post->post_type === 'wc_booking' && $update ) {

			foreach ( $this->get_translated_bookings( $post_id ) as $translated_booking_id ) {
				$this->wpdb->update(
					$this->wpdb->posts,
					[ 'post_status' => $post->post_status ],
					[ 'ID' => $translated_booking_id ]
				);
			}
		}

	}

	public function filter_my_account_bookings_tables_by_current_language( $tables ) {

		$current_language = $this->sitepress->get_current_language();

		foreach ( $tables as $table_key => $table ) {

			if ( isset( $table['bookings'] ) ) {

				foreach ( $table['bookings'] as $key => $booking ) {
					$language_code = get_post_meta( $booking->get_id(), '_language_code', true );

					if ( ! $language_code ) {
						$language_code = $this->sitepress->get_language_for_element( $booking->get_product_id(), 'post_product' );
					}

					if ( $language_code !== $current_language ) {
						unset( $tables[ $table_key ]['bookings'][ $key ] );
					}
				}
			}

			$tables[ $table_key ]['bookings'] = array_values( $tables[ $table_key ]['bookings'] );
		}

		return $tables;
	}

	public function emails_options_to_translate( $emails_options ) {
		$emails_options[] = 'woocommerce_new_booking_settings';
		$emails_options[] = 'woocommerce_booking_reminder_settings';
		$emails_options[] = 'woocommerce_booking_confirmed_settings';
		$emails_options[] = 'woocommerce_booking_cancelled_settings';
		$emails_options[] = 'woocommerce_admin_booking_cancelled_settings';

		return $emails_options;
	}

	public function emails_text_keys_to_translate( $text_keys ) {
		$text_keys[] = 'subject_confirmation';
		$text_keys[] = 'heading_confirmation';

		return $text_keys;
	}

	/**
	 * @param string   $value
	 * @param WC_Email $object
	 * @param string   $old_value
	 * @param string   $key
	 *
	 * @return string
	 */
	public function translate_emails_text_strings( $value, $object, $old_value, $key ) {
		$translated_value = false;

		$emails_ids = wpml_collect( [
			// true if it's an admin email.
			'admin_booking_cancelled' => true,
			'new_booking'             => true,
			'booking_cancelled'       => false,
			'booking_confirmed'       => false,
			'booking_reminder'        => false,
		] );

		$keys = [
			'subject',
			'subject_confirmation',
			'heading',
			'heading_confirmation',
		];

		if ( in_array( $key, $keys ) && $emails_ids->has( $object->id ) ) {
			$is_admin_email   = $emails_ids->get( $object->id, false );
			$translated_value = $this->woocommerce_wpml->emails->get_email_translated_string( $key, $object, $is_admin_email, $value, self::DOMAIN );
		}

		return $translated_value ?: $value;
	}

    public function translate_booking_confirmed_email_texts( $booking_id ) {
        $this->translate_email_strings( 'WC_Email_Booking_Confirmed', 'woocommerce_booking_confirmed_settings', self::getLanguage( $booking_id ) );
    }

    public function translate_booking_cancelled_email_texts( $booking_id ) {
        $this->translate_email_strings( 'WC_Email_Booking_Cancelled', 'woocommerce_booking_cancelled_settings', self::getLanguage( $booking_id ) );
    }

    public function translate_booking_reminder_email_texts( $booking_id ) {
        $this->translate_email_strings( 'WC_Email_Booking_Reminder', 'woocommerce_booking_reminder_settings', self::getLanguage( $booking_id ) );
    }

    public function translate_new_booking_email_texts( $booking_id ) {
        $user_lang = $this->get_admin_user_email_language( 'WC_Email_New_Booking' ) ?: self::getLanguage( $booking_id );
        $this->translate_email_strings( 'WC_Email_New_Booking', 'woocommerce_new_booking_settings', $user_lang, [ 'heading_confirmation', 'subject_confirmation' ] );
    }

    public function translate_booking_cancelled_admin_email_texts( $booking_id ) {
        $user_lang = $this->get_admin_user_email_language( 'WC_Email_Admin_Booking_Cancelled' ) ?: self::getLanguage( $booking_id );
        $this->translate_email_strings( 'WC_Email_Admin_Booking_Cancelled', 'woocommerce_admin_booking_cancelled_settings', $user_lang );
    }

	/**
	 * @param string $email_class
	 *
	 * @return bool
	 */
	private function email_class_exists( $email_class ) {
		return class_exists( $email_class ) && isset( $this->woocommerce->mailer()->emails[ $email_class ] );
	}

	/**
	 * @param string $email_class
	 *
	 * @return bool|mixed|null|string
	 */
	private function get_admin_user_email_language( $email_class ) {

		$user = get_user_by( 'email', $this->getEmailObject( $email_class )->recipient );
		if ( $user ) {
			return $this->sitepress->get_user_admin_language( $user->ID, true );
		}

		return null;
	}

	/**
	 * @param string $current_language
	 *
	 * @return string
	 */
	public function booking_email_language( $current_language ) {

		if ( isset( $_POST['post_type'] ) && 'wc_booking' === $_POST['post_type'] && isset( $_POST['_booking_order_id'] ) ) {
			$order_language = get_post_meta( $_POST['_booking_order_id'], 'wpml_language', true );
			if ( $order_language ) {
				$current_language = $order_language;
			}
		}

		return $current_language;
	}

	/**
	 * @param string      $email_class
	 * @param string      $setting_slug
	 * @param string|null $user_lang
	 * @param array       $extra_fields
	 */
	private function translate_email_strings( $email_class, $setting_slug, $user_lang, $extra_fields = [] ) {
        if ( $this->email_class_exists( $email_class ) && $user_lang ) {
            $getTranslation = function( $key ) use ( $email_class, $user_lang, $setting_slug ) {
                return $this->woocommerce_wpml->emails->getStringTranslation(
                    'admin_texts_' . $setting_slug,
                    '[' . $setting_slug . ']' . $key,
                    $user_lang,
                    $this->getEmailObject( $email_class )->{$key},
                    self::DOMAIN
                );
            };

            foreach ( array_merge( [ 'heading', 'subject' ], $extra_fields ) as $field ) {
                $this->getEmailObject( $email_class )->{$field} = $getTranslation( $field );
            }
        }
	}

    /**
     * @param int $bookingId
     *
     * @return string|null
     */
    private static function getLanguage( $bookingId ) {
        // @see https://onthegosystems.myjetbrains.com/youtrack/issue/wcml-2827
        $getOrder = pipe( 'get_wc_booking', invoke( 'get_order' ) );

        return Maybe::of( $bookingId )
                    ->map( $getOrder )
                    ->map( invoke( 'get_id' ) )
                    ->map( WCML_Orders::getLanguage() )
                    ->getOrElse( null );
    }

	public function maybe_set_booking_language( $booking_id ) {

		if ( 'wc_booking' === get_post_type( $booking_id ) ) {
			$language_details = $this->sitepress->get_element_language_details( $booking_id, 'post_wc_booking' );
			if ( ! $language_details ) {
				$current_language = $this->sitepress->get_current_language();
				$this->sitepress->set_element_language_details( $booking_id, 'post_wc_booking', false, $current_language );
			}
		}

	}

	/**
	 * @param WC_Product|int|string $product
	 *
	 * @return bool
	 */
	private function is_booking( $product ) {
		if ( ! $product instanceof WC_Product ) {
			$product = wc_get_product( $product );
		}

		return $product ? $product->get_type() === 'booking' : false;
	}

	/**
	 * @param string $counts
	 * @param string $type
	 *
	 * @return object
	 */
	public function count_bookings_by_current_language( $counts, $type ) {

		$query = "SELECT p.post_status, COUNT( * ) AS num_posts FROM {$this->wpdb->posts} as p
                  LEFT JOIN {$this->wpdb->prefix}icl_translations as icl ON p.ID = icl.element_id
                  WHERE p.post_type = %s AND icl.language_code = %s AND icl.element_type = %s GROUP BY p.post_status";

		$results = $this->wpdb->get_results( $this->wpdb->prepare( $query, $type, $this->sitepress->get_current_language(), 'post_wc_booking' ), ARRAY_A );
		$counts  = array_fill_keys( get_post_stati(), 0 );

		foreach ( $results as $row ) {
			$counts[ $row['post_status'] ] = $row['num_posts'];
		}

		$counts = (object) $counts;

		return $counts;
	}

	/**
	 * @param array $views
	 *
	 * @return array
	 */
	public function unset_mine_from_bookings_views( $views ) {
		unset( $views['mine'] );

		return $views;
	}

	public function remove_language_switcher() {
		remove_action( 'wp_before_admin_bar_render', [ $this->sitepress, 'admin_language_switcher' ] );
	}

	/**
	 * @return bool
	 */
	private function is_bookings_listing_page() {
		return isset( $_GET['post_type'] ) && 'wc_booking' === $_GET['post_type'];
	}

	public function save_booking_data_to_translation( $post_id, $data, $job ){
	    $this->save_person_translation( $post_id, $data, $job );
	    $this->save_resource_translation( $post_id, $data, $job );
    }

	/**
	 * @param stdClass|false $event
	 *
	 * @return stdClass|false
	 */
    public function prevent_events_on_duplicates( $event ) {
        if (
            isset( $event->hook, $event->args[0] )
            && in_array( $event->hook, [ 'wc-booking-reminder', 'wc-booking-complete' ], true )
            && get_post_meta( $event->args[0], '_booking_duplicate_of', true )
        ) {
            return false;
        }

        return $event;
    }

    /**
     * @param string $class
     *
     * @return WC_Email
     */
    private function getEmailObject( $class ) {
        return $this->woocommerce->mailer()->emails[ $class ];
    }

	/**
	 * Sync updated booking meta.
	 *
	 * @param int $booking_id
	 */
	private function maybe_sync_updated_booking_meta( $booking_id ) {
		if ( 'wc_booking' === get_post_type( $booking_id ) ) {

			$booking_translations = $this->get_translated_bookings( $booking_id, false );

			$base_meta_args = [
				'_booking_cost'          => get_post_meta( $booking_id, '_booking_cost', true ),
				'_booking_start'         => get_post_meta( $booking_id, '_booking_start', true ),
				'_booking_end'           => get_post_meta( $booking_id, '_booking_end', true ),
				'_booking_all_day'       => intval( get_post_meta( $booking_id, '_booking_all_day', true ) ),
				'_booking_parent_id'     => get_post_meta( $booking_id, '_booking_parent_id', true ),
				'_booking_customer_id'   => get_post_meta( $booking_id, '_booking_customer_id', true ),
			];

			foreach ( $booking_translations as $language_code => $translated_booking_id ) {
				if ( $translated_booking_id == $booking_id ) {
					continue;
				}
				$meta_args = array_merge(
					$base_meta_args,
					[
						'_booking_product_id'  => $this->get_translated_booking_product_id( $booking_id, $language_code ),
						'_booking_resource_id' => $this->get_translated_booking_resource_id( $booking_id, $language_code ),
						'_booking_persons'     => $this->get_translated_booking_persons_ids( $booking_id, $language_code ),
					]
				);

				foreach ( $meta_args as $key => $value ) {
					update_post_meta( $translated_booking_id, $key, $value );
				}
			}
		}
	}
}
