<?php

add_action( 'wp', 'wcct_theme_helper_oceanwp', 99 );
if ( ! function_exists( 'wcct_theme_helper_oceanwp' ) ) {

	function wcct_theme_helper_oceanwp() {
		$wcct_core = WCCT_Core()->appearance;

		// removing wcct action hooks on theme
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_above_title' ), 2.2 );
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_below_title' ), 9.2 );
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_below_review' ), 11 );
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_below_price' ), 17.2 );
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_below_short_desc' ), 21.2 );
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_below_add_cart' ), 39.2 );
		remove_action( 'woocommerce_single_product_summary', array( $wcct_core, 'wcct_position_below_meta' ), 41.2 );

		remove_action( 'woocommerce_after_single_product_summary', array( $wcct_core, 'wcct_position_above_tab_area' ), 9.8 );
		remove_action( 'woocommerce_after_single_product_summary', array( $wcct_core, 'wcct_position_below_related_products' ), 21.2 );
	}

}

add_action( 'woocommerce_before_template_part', 'wcct_theme_helper_oceanwp_before_template_part', 99 );

if ( ! function_exists( 'wcct_theme_helper_oceanwp_before_template_part' ) ) {
	function wcct_theme_helper_oceanwp_before_template_part( $template_name = '', $template_path = '', $located = '', $args = array() ) {
		$wcct_core = WCCT_Core()->appearance;
		if ( empty( $template_name ) ) {
			return '';
		}
		if ( $template_name == 'single-product/title.php' ) {
			echo $wcct_core->wcct_position_above_title();
		} elseif ( $template_name == 'single-product/tabs/tabs.php' ) {
			echo $wcct_core->wcct_position_above_tab_area();
		}
	}
}

add_action( 'woocommerce_after_template_part', 'wcct_theme_helper_oceanwp_after_template_part', 99 );

if ( ! function_exists( 'wcct_theme_helper_oceanwp_after_template_part' ) ) {
	function wcct_theme_helper_oceanwp_after_template_part( $template_name = '', $template_path = '', $located = '', $args = array() ) {

		$wcct_core = WCCT_Core()->appearance;
		if ( empty( $template_name ) ) {
			return '';
		}
		if ( $template_name == 'single-product/title.php' ) {
			echo $wcct_core->wcct_position_below_title();
		} elseif ( $template_name == 'single-product/short-description.php' ) {
			echo $wcct_core->wcct_position_below_short_desc();
		} elseif ( $template_name == 'single-product/rating.php' ) {
			echo $wcct_core->wcct_position_below_review();
		} elseif ( $template_name == 'single-product/price.php' ) {
			echo $wcct_core->wcct_position_below_price();
		} elseif ( $template_name == 'single-product/meta.php' ) {
			echo $wcct_core->wcct_position_below_meta();
		} elseif ( $template_name == 'single-product/related.php' ) {
			echo $wcct_core->wcct_position_below_related_products();
		}
	}
}

/**
 * Handling for below add to cart position Starts here
 */
add_action( 'woocommerce_after_add_to_cart_form', 'wcct_theme_helper_oceanwp_after_add_to_cart_template' );
if ( ! function_exists( 'wcct_theme_helper_oceanwp_after_add_to_cart_template' ) ) {
	function wcct_theme_helper_oceanwp_after_add_to_cart_template() {

		$wcct_core = WCCT_Core()->appearance;
		$output    = "";
		ob_start();
		echo $wcct_core->wcct_position_below_add_cart();
		$output = ob_get_clean();
		if ( $output !== "" ) {
			echo '<div class="wcct_clear" style="height: 15px;"></div>';
		}
		echo $output;
	}
}