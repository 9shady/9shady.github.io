<?php

class WCCT_Compatibility_With_WC_Deposits {

	public $is_cart_content = false;

	public function __construct() {

		if ( class_exists( 'WC_Deposits' ) ) {
			add_action( 'woocommerce_cart_loaded_from_session', array( $this, 'setup_cart_prices' ), 2 );

			add_filter( 'wcct_skip_discounts', array( $this, 'maybe_skip_for_deposits' ), 999, 3 );
			add_filter( 'woocommerce_before_mini_cart_contents', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_mini_cart_contents', array( $this, 'unflag_cart' ) );
			add_filter( 'woocommerce_before_cart_contents', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_after_cart_contents', array( $this, 'unflag_cart' ) );
			add_filter( 'woocommerce_review_order_before_cart_contents', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_review_order_after_cart_contents', array( $this, 'unflag_cart' ) );

			add_action( 'woocommerce_before_cart_totals', array( $this, 'flag_cart' ) );
			add_filter( 'woocommerce_after_cart_totals', array( $this, 'unflag_cart' ) );
		}
	}

	public function maybe_skip_for_deposits( $bool, $price, $product ) {

		if ( ( true === WCCT_Core()->discount->is_wc_calculating || true === $this->is_cart_content ) ) {
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

	public function setup_cart_prices( $cart ) {
		$get_cart = $cart->cart_contents;
		if ( $get_cart && is_array( $get_cart ) && count( $get_cart ) > 0 ) {
			foreach ( $get_cart as $key => $cartitem ) {
				$cart->cart_contents[ $key ]['data']->set_price( $cartitem['data']->get_price() );
				WC()->cart->cart_contents[ $key ]['data']->set_price( $cartitem['data']->get_price() );
			}
		}
	}
}

new WCCT_Compatibility_With_WC_Deposits();
