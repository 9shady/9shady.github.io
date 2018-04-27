<?php

class WCCT_Input_Html_General_Front {

	public function __construct() {
		// vars
		$this->type = 'Html_General_Front';

		$this->defaults = array(
			'default_value' => '',
			'class'         => '',
			'placeholder'   => ''
		);
	}

	public function render( $field, $value = null ) {
		$go_pro_link = add_query_arg( array(
			'utm_source'   => 'finale-lite',
			'utm_medium'   => 'text-click',
			'utm_campaign' => 'rule-builder',
			'utm_term'     => 'go-pro',
		), 'https://xlplugins.com/lite-to-pro-upgrade-page/' );
		_e( 'We\'re sorry, This rule is not available on your plan. <a target="_blank" href=\'' . $go_pro_link . '\',
                >Upgrade to PRO</a> to unlock this rule.', 'finale-woocommerce-sales-countdown-timer-discount' );
	}

}
