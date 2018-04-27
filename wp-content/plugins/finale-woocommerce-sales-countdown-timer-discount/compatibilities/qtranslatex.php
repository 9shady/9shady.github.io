<?php

/**
 * Created by PhpStorm.
 * User: amritansh
 * Date: 23/11/17
 * Time: 12:53 PM
 */
class WCCT_Compatibility_With_QtranslateX {


	public function __construct() {

		if ( function_exists( 'qtranxf_useCurrentLanguageIfNotFoundShowAvailable' ) ) {
			add_action( 'wcct_the_content', 'qtranxf_useCurrentLanguageIfNotFoundShowAvailable' );
			add_action( 'wcct_modify_sticky_footer_content', 'qtranxf_useCurrentLanguageIfNotFoundShowAvailable' );
			add_action( 'wcct_modify_sticky_header_content', 'qtranxf_useCurrentLanguageIfNotFoundShowAvailable' );

		}


	}
}

new WCCT_Compatibility_With_QtranslateX();