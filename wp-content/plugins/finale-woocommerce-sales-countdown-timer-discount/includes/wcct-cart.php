<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Class WCCT_cart
 * @package Finale-Lite
 * @author XlPlugins
 */
class WCCT_cart {

	public static $_instance = null;
	public $is_mini_cart = false;
	public $add_to_cart_action = false;
	public $cart_product_id = 0;
	public $cart_product_qty = array();

	public function __construct() {

		/**
		 * Removing action related to wooCommerce cart validations to prevent validations of products whose stock getting managed by our campaigns
		 */
		add_action( 'wp_loaded', array( $this, 'remove_actions' ), 11 );

		/**
		 * Sets up cart data in woocommerce session
		 * Maintain it when cart state got changed
		 * Update it to product meta with the sold qty in the respective campaign
		 */
		add_action( 'woocommerce_add_to_cart', array( $this, 'wcct_add_cart_data' ), 20, 6 );
		add_action( 'woocommerce_cart_item_removed', array( $this, 'wcct_remove_cart_data' ), 19, 2 );
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'wcct_wc_checkout_update_order_meta' ), 10, 2 );

		/**
		 * Detects mini cart
		 * Sets up data for the mini cart
		 * Set flags when mini cart ends
		 */
		add_action( 'woocommerce_before_mini_cart', array( $this, 'detect_mini_cart_start' ) );
		add_action( 'woocommerce_after_mini_cart', array( $this, 'detect_mini_cart_ends' ) );


		/**
		 * Sets up data for all the products in the cart to let mini cart functions work well
		 */
		add_action( 'woocommerce_add_to_cart', array( $this, 'wcct_push_discount_price_to_cart' ), 19 );

		/**
		 * Sets up data for the product before validation so that we can ensure out data sets up before woocommerce checks for products property
		 */
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'wcct_setup_data_when_cart' ), 10, 3 );

		/**
		 * Sets up data for the products in cart when cart is going to load using session (additional handling for the cart loads from session)
		 */
		add_action( 'woocommerce_cart_loaded_from_session', array( $this, 'setup_cart_data_session' ), 1 );
		add_filter( 'woocommerce_add_cart_item', array( $this, 'maybe_setup_data' ), 99, 1 );
		add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'maybe_setup_data' ), 99, 2 );


	}

	/**
	 * @return WCCT_cart
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	public function remove_actions() {
		remove_action( "woocommerce_check_cart_items", array( WC()->cart, 'check_cart_items' ), 1 );
		add_action( "woocommerce_check_cart_items", array( $this, 'wcct_check_cart_items' ), 1 );
	}

	/**
	 * Hooked over `woocommerce_after_mini_cart`
	 * Checking into mini cart ends
	 */
	public function detect_mini_cart_ends() {
		$this->is_mini_cart = false;
	}

	/**
	 * Hooked over `woocommerce_before_mini_cart`
	 * Checking into mini cart starts
	 */
	public function detect_mini_cart_start() {

		if ( WCCT_Common::$is_executing_rule ) {
			return;
		}

		$this->is_mini_cart = true;
		$get_cart           = WC()->cart->get_cart();
		if ( $get_cart && count( $get_cart ) > 0 ) {
			foreach ( $get_cart as $cartitem ) {

				$get_item_id = $cartitem['product_id'];
				WCCT_Core()->public->wcct_get_product_obj( $get_item_id );
				WCCT_Core()->public->get_single_campaign_pro_data( $cartitem['product_id'], true );
			}
		}
	}

	public function wcct_check_cart_items() {

		$return = true;
		$result = WC()->cart->check_cart_item_validity();
		if ( is_wp_error( $result ) ) {
			wc_add_notice( $result->get_error_message(), 'error' );
			$return = false;
		}
		$result = $this->check_cart_item_stock();
		if ( is_wp_error( $result ) ) {
			wc_add_notice( $result->get_error_message(), 'error' );
			$return = false;
		}

		return $return;
	}

	/**
	 * Checking cart item stock, Iterating each item in the cart validating its attributes
	 * @see WCCT_Cart::wcct_check_cart_items()
	 * @return bool|WP_Error
	 */
	public function check_cart_item_stock() {
		global $wpdb, $woocommerce;

		$error               = new WP_Error();
		$product_qty_in_cart = WC()->cart->get_cart_item_quantities();


		foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];

			$this->cart_product_id = $_product->get_id();


			if ( $values["variation_id"] > 0 ) {
				$this->cart_product_id = (int) $values["product_id"];
			}
			if ( ! $_product->is_in_stock() ) {
				$error->add( 'out-of-stock', sprintf( __( 'Sorry, "%s" is not in stock. Please edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title() ) );

				return $error;
			}


			$check_qty = 0;
			if ( $_product->is_type( 'variation' ) ) {

				if ( true === $_product->managing_stock() ) {
					$check_qty = $product_qty_in_cart[ $values['variation_id'] ];
				}
			} else {
				if ( $product_qty_in_cart[ $values['product_id'] ] ) {
					$check_qty = $product_qty_in_cart[ $values['product_id'] ];
				}
			}

			/**
			 * Checking WC version and allowing check for manage_stock if version >= 3.0
			 */

			if ( version_compare( $woocommerce->version, 3.0, ">=" ) ) {

				if ( ! $_product->managing_stock() ) {
					continue;
				}

				if ( ! $_product->has_enough_stock( $check_qty ) ) {
					$error->add( 'out-of-stock', sprintf( __( 'Sorry, we do not have enough "%s" in stock to fulfill your order (%s in stock). Please edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title(), $_product->get_stock_quantity() ) );

					return $error;
				}

			} else {
				//custom manage stock check on cart , that checks for the goals and then validate cart qty for the product just by avoiding manage_stock check
				if ( ! $this->has_product_stock( $check_qty, $_product ) ) {
					$error->add( 'out-of-stock', sprintf( __( 'Sorry, we do not have enough "%s" in stock to fulfill your order (%s in stock). Please edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title(), $_product->get_stock_quantity() ) );

					return $error;
				}
			}


			//again performing check for manage stock on.
			//allowing hold stock check for every case
			//WC native does not let this check happening while product is not managing stock
			if ( ! $_product->managing_stock() ) {
				continue;
			}
			$allow_wc_hold_stock = apply_filters( 'wcct_wc_hold_stock_units', false );
			if ( get_option( 'woocommerce_hold_stock_minutes' ) > 0 && ! $_product->backorders_allowed() && $allow_wc_hold_stock ) {
				$order_id   = isset( WC()->session->order_awaiting_payment ) ? absint( WC()->session->order_awaiting_payment ) : 0;
				$held_stock = $wpdb->get_var( $wpdb->prepare( "
							SELECT SUM( order_item_meta.meta_value ) AS held_qty
							FROM {$wpdb->posts} AS posts
							LEFT JOIN {$wpdb->prefix}woocommerce_order_items as order_items ON posts.ID = order_items.order_id
							LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
							LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta2 ON order_items.order_item_id = order_item_meta2.order_item_id
							WHERE 	order_item_meta.meta_key   = '_qty'
							AND 	order_item_meta2.meta_key  = %s AND order_item_meta2.meta_value  = %d
							AND 	posts.post_type            IN ( '" . implode( "','", wc_get_order_types() ) . "' )
							AND 	posts.post_status          = 'wc-pending'
							AND		posts.ID                   != %d;", $_product->is_type( 'variation' ) && true === $_product->managing_stock() ? '_variation_id' : '_product_id', $_product->is_type( 'variation' ) && true === $_product->managing_stock() ? $values['variation_id'] : $values['product_id'], $order_id ) );


				$not_enough_stock = false;

				if ( $_product->is_type( 'variation' ) && 'parent' === $_product->managing_stock() && $_product->parent->get_stock_quantity() < ( $held_stock + $check_qty ) ) {
					$not_enough_stock = true;
				} elseif ( $_product->get_stock_quantity() < ( $held_stock + $check_qty ) ) {
					$not_enough_stock = true;
				}
				if ( $not_enough_stock ) {
					$error->add( 'out-of-stock', sprintf( __( 'Sorry, we do not have enough "%s" in stock to fulfill your order right now. Please try again in %d minutes or edit your cart and try again. We apologise for any inconvenience caused.', 'woocommerce' ), $_product->get_title(), get_option( 'woocommerce_hold_stock_minutes' ) ) );

					return $error;
				}


				/**
				 * WC 3.0.0 Source Code
				 */
//                if ( $_product->get_stock_quantity() < ( $held_stock + $product_qty_in_cart[ $_product->get_stock_managed_by_id() ] ) ) {
//                    /* translators: 1: product name 2: minutes */
//                    $error->add( 'out-of-stock', sprintf( __( 'Sorry, we do not have enough "%1$s" in stock to fulfill your order right now. Please try again in %2$d minutes or edit your cart and try again. We apologize for any inconvenience caused.', 'woocommerce' ), $_product->get_name(), get_option( 'woocommerce_hold_stock_minutes' ) ) );
//                    return $error;
//                }


			}


		}

		return true;
	}

	/**
	 * Checking product stock on the cart, first checking a running campaign and then checking product stock attributes
	 * We forked WC native has_product_stock function to make it work
	 *
	 * @param $qty Qty added to the cart
	 * @param WC_Product $product
	 *
	 * @return bool True on success| False otherwise
	 */
	public function has_product_stock( $qty, $product ) {
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( WCCT_Core()->public->wcct_get_product_parent_id( $product ) );


		if ( empty( $single_data ) ) {
			return $product->has_enough_stock( $qty );
		}

		$get_goal_object = WCCT_Core()->public->wcct_get_goal_object( $single_data['goals'], WCCT_Core()->public->wcct_get_product_parent_id( $product ) );

		if ( ! empty( $get_goal_object ) ) {
			return ( $product->backorders_allowed() || $product->get_stock_quantity() >= $qty ) ? true : false;

		} else {

			return $product->has_enough_stock( $qty );
		}
	}

	/**
	 * Update Sold Out Quantity against product and campaign id for current occurence and all occurence
	 * @global WooCommerce $woocommerce
	 *
	 * @param Integer $order_id
	 * @param array $posted
	 *
	 * @return boolean
	 */
	public function wcct_wc_checkout_update_order_meta( $order_id, $posted ) {

		global $woocommerce;
		if ( empty( $order_id ) ) {
			return false;
		}
		$items                  = $woocommerce->cart->get_cart();
		$get_session            = WC()->session->get( "_wcct_cart_data_" );
		$get_prev_session_camps = WC()->session->get( "_wcct_cart_running_camp_data_" );

		$all_camps_data = array();
		if ( is_array( $items ) && count( $items ) > 0 && is_array( $get_session ) && count( $get_session ) > 0 ) {

			foreach ( $items as $key => $val ) {

				$val_data = $val;
				$val      = isset( $get_session[ $key ] ) ? $get_session[ $key ] : array();
				$pro_id   = $val_data['product_id'];

				$finale_inventory_reduced_handle = array();

				if ( isset( $val['from_timestamp'] ) && ( '' != $val['from_timestamp'] ) ) {

					$start_time          = $val['from_timestamp'];
					$campaign_id         = $val['campaign_id'];
					$end_time            = isset( $val['to_timestamp'] ) ? $val['to_timestamp'] : '0';
					$wcct_sold_out_key   = "_wcct_goaldeal_sold_{$campaign_id}_{$start_time}_{$end_time}";
					$wcct_sold_total_out = "_wcct_goaldeal_sold_{$campaign_id}";

					$sold_unit       = get_post_meta( $pro_id, $wcct_sold_out_key, true );
					$total_sold_unit = get_post_meta( $pro_id, $wcct_sold_total_out, true );

					$sold_unit_mod       = (int) ( ( '' != $sold_unit ) ? $sold_unit : 0 );
					$sold_unit_mod       = $sold_unit_mod + (int) $val_data['quantity'];
					$total_sold_unit_mod = (int) $total_sold_unit + (int) $val_data['quantity'];

					$finale_inventory_reduced_handle[ $pro_id ][ $wcct_sold_out_key ]   = $sold_unit_mod - $sold_unit;
					$finale_inventory_reduced_handle[ $pro_id ][ $wcct_sold_total_out ] = $total_sold_unit_mod - $total_sold_unit;

					$resp       = update_post_meta( (int) $pro_id, $wcct_sold_out_key, $sold_unit_mod );
					$resp_total = update_post_meta( (int) $pro_id, $wcct_sold_total_out, $total_sold_unit_mod );

					wcct_force_log( "update product sold in meta  with key {$wcct_sold_out_key} \n product id => {$pro_id} \n function wcct_wc_checkout_update_order_meta  update_quantity == {$sold_unit_mod}\n\r" . print_r( $resp, true ) );
				}

				$resp_backup = update_post_meta( (int) $order_id, '_wcct_goaldeal_sold_backup', $finale_inventory_reduced_handle );
				wp_schedule_single_event( time() + ( apply_filters( 'wcct_sold_stock_backup_time', 2 ) * MINUTE_IN_SECONDS ), 'wcct_goaldeal_sold_backup', array( $order_id ) );
				wcct_force_log( "backup units product meta with key _wcct_goaldeal_sold_backup \n\r" . print_r( $resp_backup, true ) );

				$running_camps = isset( $get_prev_session_camps[ $key ] ) ? $get_prev_session_camps[ $key ] : array();

				if ( ! empty( $running_camps ) ) {
					$all_camps_data[ $key ] = array(
						'product_id' => $pro_id,
						'campaigns'  => $running_camps,
					);

				}
				unset( $pro_id );
				unset( $pro_variation_id );
				unset( $start_time );
				unset( $end_time );
				unset( $wcct_sold_out_key );
				unset( $sold_unit );
				unset( $resp_total );
			}

			if ( ! empty( $all_camps_data ) ) {

				update_post_meta( $order_id, '_wcct_running_camps_', $all_camps_data );
			}

		}
	}


	/**
	 * @hooked to `woocommerce_add_to_cart`
	 * DATA SET UP CALLBACK
	 * Iterate over the cart and setup data before woocommerce calculated cart prices.
	 * Favor: Themes and customizations
	 */
	public function wcct_push_discount_price_to_cart() {

		$this->add_to_cart_action = true;

		if ( WCCT_Common::$is_executing_rule ) {
			return;
		}
		$get_cart = WC()->cart->get_cart();
		if ( $get_cart && count( $get_cart ) > 0 ) {
			foreach ( $get_cart as $cartitem ) {
				WCCT_Core()->public->wcct_get_product_obj( $cartitem['product_id'] );


				$data = WCCT_Core()->public->get_single_campaign_pro_data( $cartitem['product_id'], true );

			}
		}
	}

	/**
	 * @hooked over `woocommerce_cart_item_removed`
	 * Maintains
	 *
	 * @param string $cart_item_key unique key for an item in cart
	 * @param WC_Cart $cart cart object
	 */
	public function wcct_remove_cart_data( $cart_item_key, $cart ) {
		$get_prev_session = WC()->session->get( "_wcct_cart_data_" );

		if ( is_array( $get_prev_session ) && isset( $get_prev_session[ $cart_item_key ] ) ) {
			unset( $get_prev_session[ $cart_item_key ] );
			WC()->session->set( "_wcct_cart_data_", $get_prev_session );
		}

		$get_camp_session = WC()->session->get( "_wcct_cart_running_camp_data_" );

		if ( is_array( $get_camp_session ) && isset( $get_camp_session[ $cart_item_key ] ) ) {
			unset( $get_camp_session[ $cart_item_key ] );
			WC()->session->set( "_wcct_cart_running_camp_data_", $get_camp_session );
		}
	}

	/**
	 * @hooked over `woocommerce_add_to_cart` - 19
	 * Executes just after product added to cart, sets up data
	 * Add session variable in case of inventory goal exists for the product just added in cart
	 */
	public function wcct_add_cart_data( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
		global $woocommerce;
		$sale_price_from = '';
		$get_item_id     = $product_id;


		if ( WCCT_Common::$is_executing_rule ) {
			return;
		}

		$cart_data = array();


		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $get_item_id, true );

		$running_camps = array();
		$Camp_meta     = array();
		if ( isset( $single_data['running'] ) && ! empty( $single_data['running'] ) ) {
			$running_camps = $single_data['running'];
		}
		if ( isset( $single_data['campaign_meta'] ) && ! empty( $single_data['campaign_meta'] ) ) {
			$Camp_meta = $single_data['campaign_meta'];
		}
		if ( isset( $single_data["goals"] ) && is_array( $single_data["goals"] ) && count( $single_data["goals"] ) > 0 ) {
			$goals = $single_data["goals"];
			$goals["start_timestamp"];
			$cart_data['from_timestamp'] = $goals["start_timestamp"];
			$cart_data['to_timestamp']   = $goals["end_timestamp"];
			$cart_data['campaign_id']    = $goals["campaign_id"];
			wcct_force_log( "wcct_wc_add_cart_item_data  \n setting goal timsetamp in session \n\r" . print_r( $goals, true ) );
		}


		if ( ! empty( $cart_data ) ) {

			$get_prev_session = WC()->session->get( "_wcct_cart_data_" );

			if ( ! is_array( $get_prev_session ) ) {
				$get_prev_session = array();
			}

			$get_prev_session[ $cart_item_key ] = $cart_data;
			WC()->session->set( "_wcct_cart_data_", $get_prev_session );
		}

		if ( count( $running_camps ) > 0 ) {
			$get_prev_session_camps = WC()->session->get( "_wcct_cart_running_camp_data_" );
			if ( ! is_array( $get_prev_session_camps ) ) {
				$get_prev_session_camps = array();
			}
			$get_prev_session_camps[ $cart_item_key ] = array(
				'running' => $running_camps,
				'meta'    => $Camp_meta
			);

			WC()->session->set( "_wcct_cart_running_camp_data_", $get_prev_session_camps );
		}

	}


	/**
	 * @hooked over `woocommerce_add_to_cart_validation`
	 * Sets up data before the validation happens when products is adding to cart
	 *
	 * @param boolean $bool validation state variable
	 * @param int $productID Product ID
	 * @param int $qty Quantity
	 *
	 * @return boolean result of validation
	 */
	public function wcct_setup_data_when_cart( $bool, $productID, $qty ) {

		if ( WCCT_Common::$is_executing_rule ) {
			return $bool;
		}
		$this->cart_product_qty[ $productID ] = $qty;


		WCCT_Core()->public->wcct_get_product_obj( $productID );


		$data = WCCT_Core()->public->get_single_campaign_pro_data( $productID, true );
		if ( isset( $data['goals'] ) && is_array( $data['goals'] ) && count( $data['goals'] ) > 0 ) {

			$goal_object = WCCT_Core()->public->wcct_get_goal_object( $data['goals'], $productID );
		}


		return $bool;
	}

	public function setup_cart_data_session( $cart ) {

		if ( WCCT_Common::$is_executing_rule ) {
			return $cart;
		}

		$get_cart = $cart->cart_contents;
		if ( $get_cart && count( $get_cart ) > 0 ) {
			foreach ( $get_cart as $cartitem ) {

				WCCT_Core()->public->wcct_get_product_obj( $cartitem['product_id'] );
				WCCT_Core()->public->get_single_campaign_pro_data( $cartitem['product_id'], true );

			}

		}
	}

	public function maybe_setup_data( $cart_item = array(), $values = array() ) {
		if ( WCCT_Common::$is_executing_rule ) {
			return $cart_item;
		}


		$parentId = WCCT_Core()->public->wcct_get_product_parent_id( $cart_item['data'] );

		WCCT_Core()->public->wcct_get_product_obj( $parentId );
		WCCT_Core()->public->get_single_campaign_pro_data( $parentId, true );

		return $cart_item;
	}


}

if ( class_exists( "WCCT_cart" ) ) {
	WCCT_Core::register( "cart", "WCCT_cart" );
}
