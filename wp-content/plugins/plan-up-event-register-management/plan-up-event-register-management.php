<?php
/**
 * Plugin Name: HT Event Tickets
 * Plugin URI: https://bitbucket.org/maurisvn/booking-extension/get/e40ea031688f.zip
 * Description: This extension provides management system for event registration
 * Version: 1.2.0
 * Author: haintheme
 * Author URI: http://haintheme.com
 * Text Domain: plan-up
 * License: A short license name. Example: GPL2
 */

function _fw_filter_plan_up_event_register_management($locations) {
    $locations[dirname(__FILE__) . '/extensions']
    =
    plugin_dir_url( __FILE__ ) . 'extensions';

    return $locations;
}
add_filter('fw_extensions_locations', '_fw_filter_plan_up_event_register_management');

add_action( 'plugins_loaded', 'plan_up_event_register_management_load_textdomain' );
function plan_up_event_register_management_load_textdomain() {
  load_plugin_textdomain( 'plan-up', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

?>