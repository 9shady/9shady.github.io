<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
$event_register_managent = fw()->extensions->get( 'event-register-management' );
$event_customer_post_type = $event_register_managent->get_post_type_name();
/*Register post type event-customer*/
$labels = array(
	'name'                => _x( 'HT Event Tickets', 'Post Type General Name', 'plan-up' ),
	'singular_name'       => _x( 'HT Event Ticket', 'Post Type Singular Name', 'plan-up' ),
	'menu_name'           => __( 'HT Event Ticket', 'plan-up' ),
	'name_admin_bar'      => __( 'HT Event Ticket', 'plan-up' ),
	'parent_item_colon'   => __( '', 'plan-up' ),
	'all_items'           => __( 'HT Event Tickets', 'plan-up' ),
	'add_new_item'        => __( 'New Customer', 'plan-up' ),
	'add_new'             => __( 'New Customer', 'plan-up' ),
	'new_item'            => __( 'New', 'plan-up' ),
	'edit_item'           => __( 'Edit', 'plan-up' ),
	'update_item'         => __( 'Update', 'plan-up' ),
	'view_item'           => __( 'View', 'plan-up' ),
	'search_items'        => __( 'Search', 'plan-up' ),
	'not_found'           => __( 'Not found', 'plan-up' ),
	'not_found_in_trash'  => __( 'Not found in Trash', 'plan-up' ),
);
$args = array(
	'label'               => __( 'event-customer', 'plan-up' ),
	'labels'              => $labels,
	'supports'            => array( 'title' ),
	'hierarchical'        => false,
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'menu_icon'           => 'dashicons-tickets-alt',
	'menu_position'       => 5,
	'show_in_admin_bar'   => false,
	'show_in_nav_menus'   => true,
	'can_export'          => true,
	'has_archive'         => true,
	'exclude_from_search' => true,
	'publicly_queryable'  => true,
	'capability_type'     => 'post',
	'capabilities' => array(
	    'create_posts' => 'do_not_allow',
	),
	'map_meta_cap' => true,
);
register_post_type( $event_customer_post_type, $args );

/*Registry post type speaker*/
/*ROOM POST TYPE*/
$labels2 = array(
	'name'                => _x( 'HT Speakers', 'Post Type General Name', 'plan-up' ),
	'singular_name'       => _x( 'HT Speaker', 'Post Type Singular Name', 'plan-up' ),
	'menu_name'           => __( 'HT Speaker', 'plan-up' ),
	'name_admin_bar'      => __( 'Speaker', 'plan-up' ),
	'parent_item_colon'   => __( '', 'plan-up' ),
	'all_items'           => __( 'Speakers', 'plan-up' ),
	'add_new_item'        => __( 'Add New', 'plan-up' ),
	'add_new'             => __( 'Add New', 'plan-up' ),
	'new_item'            => __( 'New', 'plan-up' ),
	'edit_item'           => __( 'Edit', 'plan-up' ),
	'update_item'         => __( 'Update', 'plan-up' ),
	'view_item'           => __( 'View', 'plan-up' ),
	'search_items'        => __( 'Search', 'plan-up' ),
	'not_found'           => __( 'Not found', 'plan-up' ),
	'not_found_in_trash'  => __( 'Not found in Trash', 'plan-up' ),
);
$args2 = array(
	'label'               => __( 'speaker', 'plan-up' ),
	'labels'              => $labels2,
	'supports'            => array( 'title', 'editor', 'thumbnail' ),
	'hierarchical'        => false,
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'menu_icon'           => 'dashicons-id-alt',
	'menu_position'       => 5,
	'rewrite'           => array(
		'slug' => 'speakers'
	),
	'show_in_admin_bar'   => true,
	'show_in_nav_menus'   => true,
	'can_export'          => true,
	'has_archive'         => true,
	'exclude_from_search' => true,
	'publicly_queryable'  => true,
	'capability_type'     => 'post',
);
register_post_type( 'speaker', $args2 );

add_action('admin_menu', 'plan_up_event_register_management_setting_sub_admin_menu');
function plan_up_event_register_management_setting_sub_admin_menu() {
	$event_register_managent = fw()->extensions->get( 'event-register-management' );
	$event_customer_post_type = $event_register_managent->get_post_type_name();
    add_submenu_page('edit.php?post_type='.$event_customer_post_type, 'Settings', 'Settings', 'manage_options', 'admin.php?page=fw-extensions&sub-page=extension&extension=event-register-management');
}