<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.vsourz.com
 * @since      1.0.0
 *
 * @package    Advanced_Cf7_Db
 * @subpackage Advanced_Cf7_Db/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advanced_Cf7_Db
 * @subpackage Advanced_Cf7_Db/includes
 * @author     vsourz Digital <mehul@vsourz.com>
 */
class Advanced_Cf7_Db_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		create_table_cf7_vdata();
		create_table_cf7_vdata_entry();
	}

}

/**
 * Contact Form submitted table created from here
 */

function create_table_cf7_vdata(){
	
	global $wpdb;
	$table_name = VSZ_CF7_DATA_TABLE_NAME;
	$charset_collate = $wpdb->get_charset_collate();
	if( $wpdb->get_var( "show tables like '{$table_name}'" ) != $table_name ) {
        $sql = "CREATE TABLE " . $table_name . " (
             `id` int(11) NOT NULL AUTO_INCREMENT,
			 `created` timestamp NOT NULL,
			  UNIQUE KEY id (id)
		)$charset_collate;";
		
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}
/**
 * Contact Form entry table created from here
 */

function create_table_cf7_vdata_entry(){
	global $wpdb;
	$table_name = VSZ_CF7_DATA_ENTRY_TABLE_NAME;
	$charset_collate = $wpdb->get_charset_collate();
	if( $wpdb->get_var( "show tables like '{$table_name}'" ) != $table_name ) {
        $sql = "CREATE TABLE " . $table_name . " (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`cf7_id` int(11) NOT NULL,
				`data_id` int(11) NOT NULL,
				`name` varchar(250),
				`value` text,
				UNIQUE KEY id (id)
		)$charset_collate;";
		
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
}
