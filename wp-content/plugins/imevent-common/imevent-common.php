<?php
/**
 
* Plugin Name: imevent-common
 
* Plugin URI: ovatheme.com
 
* Description: A plugin to create custom post type, metabox, paypal, shortcode...
 
* Version:  3.2
 
* Author: Ovatheme
 
* Author URI: ovatheme.com
 
* License:  GPL2
 
*/

if(defined('TEXT_DOMAIN_SHORTCODE') == false) define('TEXT_DOMAIN_SHORTCODE', 'imevent');


include dirname( __FILE__ ) . '/custom-post-type/post-type.php';
include dirname( __FILE__ ) . '/custom-metaboxes/metabox-functions.php';
include dirname( __FILE__ ) . '/shortcode/shortcode.php';
include dirname( __FILE__ ) . '/shortcode/vc-shortcode.php';

include dirname( __FILE__ ) . '/paypal/payment_list.php';
include dirname( __FILE__ ) . '/paypal/pagination.class.php';

return true;