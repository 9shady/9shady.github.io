<?php

add_action( 'wp', 'wcct_theme_helper_enfold', 99 );
if ( ! function_exists( 'wcct_theme_helper_enfold' ) ) {

	function wcct_theme_helper_enfold() {
		$wcct_core = WCCT_Core()->appearance;

		// removing wcct action hooks on theme
		remove_action( 'woocommerce_after_single_product_summary', array( $wcct_core, 'wcct_position_above_tab_area' ), 9.9 );
		remove_action( 'woocommerce_after_single_product_summary', array( $wcct_core, 'wcct_position_below_related_products' ), 21.3 );
	}

}

add_action( 'woocommerce_before_template_part', 'wcct_theme_helper_enfold_before_template_part', 99 );

if ( ! function_exists( 'wcct_theme_helper_enfold_before_template_part' ) ) {
	function wcct_theme_helper_enfold_before_template_part( $template_name = '', $template_path = '', $located = '', $args = array() ) {
		$wcct_core = WCCT_Core()->appearance;
		if ( empty( $template_name ) ) {
			return '';
		}
		if ( $template_name == 'single-product/tabs/tabs.php' ) {
			echo $wcct_core->wcct_position_above_tab_area();
		}
	}
}

add_action( 'woocommerce_after_template_part', 'wcct_theme_helper_enfold_after_template_part', 99 );

if ( ! function_exists( 'wcct_theme_helper_enfold_after_template_part' ) ) {
	function wcct_theme_helper_enfold_after_template_part( $template_name = '', $template_path = '', $located = '', $args = array() ) {

		$wcct_core = WCCT_Core()->appearance;
		if ( empty( $template_name ) ) {
			return '';
		}
		if ( $template_name == 'single-product/related.php' ) {
			echo $wcct_core->wcct_position_below_related_products();
		}
	}
}