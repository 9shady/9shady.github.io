<?php

/**
 * @link              https://wordpress.org/plugins/advanced-cf7-db/
 * @since             1.1.0
 * @package           Advanced_CF7_DB
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced CF7 DB
 * Plugin URI:        https://wordpress.org/plugins/advanced-cf7-db/
 * Description:       Save all contact form 7 submitted data to the database, View, Export, ordering, Change field labels, Import data using CSV very easily.
 * Version:           1.3.0
 * Author:            Vsourz Digital
 * Author URI:        https://www.vsourz.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-cf7-db
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Defining all the table names and setting their prefix here
 */ 
global $wpdb;
define('VSZ_CF7_DATA_TABLE_NAME',$wpdb->prefix . 'cf7_vdata');
define('VSZ_CF7_DATA_ENTRY_TABLE_NAME',$wpdb->prefix . 'cf7_vdata_entry');
define('VSZ_CF7_UPLOAD_FOLDER','advanced-cf7-upload');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-cf7-db-activator.php
 */
function activate_advanced_cf7_db() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-cf7-db-activator.php';
	Advanced_Cf7_Db_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-cf7-db-deactivator.php
 */
function deactivate_advanced_cf7_db() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-cf7-db-deactivator.php';
	Advanced_Cf7_Db_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advanced_cf7_db' );
register_deactivation_hook( __FILE__, 'deactivate_advanced_cf7_db' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-cf7-db.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advanced_cf7_db() {

	$plugin = new Advanced_Cf7_Db();
	$plugin->run();

}
run_advanced_cf7_db();