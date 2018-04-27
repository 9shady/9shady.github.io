<?php

class WCCT_Compatibility_With_tmpo {

	public $is_cart_content = false;
	public $excluded_prices = array();

	public function __construct() {
		if ( defined( 'TM_EPO_PLUGIN_SLUG' ) ) {
			add_filter( 'wcct_skip_discounts', array( $this, 'maybe_skip_for_tmpo' ), 999, 3 );
			add_filter( 'woocommerce_before_mini_cart_contents', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_mini_cart_contents', array( $this, 'unflag_cart' ) );
			add_filter( 'woocommerce_before_cart_contents', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_after_cart_contents', array( $this, 'unflag_cart' ) );
			add_filter( 'woocommerce_review_order_before_cart_contents', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_review_order_after_cart_contents', array( $this, 'unflag_cart' ) );
			/**
			 * Setting up prices for the items in the cart so that all the functionlity for the TMPO picks that price and continue.
			 */
			add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'setup_cart_data_prices' ), 100 );

		}
	}

	public function maybe_skip_for_tmpo( $bool, $price, $product ) {


		if ( ( true === WCCT_Core()->discount->is_wc_calculating || true === $this->is_cart_content ) && ( $product instanceof WC_Product ) && in_array( $product->get_id(), WCCT_Core()->discount->excluded ) ) {

			return true;
		}

		return $bool;
	}

	public function flag_cart() {
		$this->is_cart_content = true;
	}

	public function unflag_cart() {
		$this->is_cart_content = false;
	}


	/**
	 * Setting price in the cart item object (WC_Product) & mark the product to exclude further calls for price
	 *
	 */
	public function setup_cart_data_prices( $cart_item ) {

		if ( WCCT_Common::$is_executing_rule ) {
			return $cart_item;
		}

		$price = $cart_item['data']->get_price();
		$cart_item['data']->set_price( $price );
		array_push( WCCT_Core()->discount->excluded, $cart_item['data']->get_id() );

		return $cart_item;
	}


}

new WCCT_Compatibility_With_tmpo();
