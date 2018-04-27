<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////
// Create Custom Post Type ///////////////////////////////////////////////////////////////////////////

defined('TEXT_DOMAIN_POST_TYPE') or define('TEXT_DOMAIN_POST_TYPE', 'imevent');

// Slideshow //////////////////////////////////////////
add_action( 'init', 'slideshow_init',0 );
function slideshow_init() { 
    
    $labels = array(
        'name'               => __( 'Slideshows', 'post type general name', TEXT_DOMAIN_POST_TYPE ),
        'singular_name'      => __( 'Slide', 'post type singular name', TEXT_DOMAIN_POST_TYPE ),
        'menu_name'          => __( 'Slideshows', 'admin menu', TEXT_DOMAIN_POST_TYPE ),
        'name_admin_bar'     => __( 'Slide', 'add new on admin bar', TEXT_DOMAIN_POST_TYPE ),
        'add_new'            => __( 'Add New slide', 'Slide', TEXT_DOMAIN_POST_TYPE ),
        'add_new_item'       => __( 'Add New Slide', TEXT_DOMAIN_POST_TYPE ),
        'new_item'           => __( 'New Slide', TEXT_DOMAIN_POST_TYPE ),
        'edit_item'          => __( 'Edit Slide', TEXT_DOMAIN_POST_TYPE ),
        'view_item'          => __( 'View Slide', TEXT_DOMAIN_POST_TYPE ),
        'all_items'          => __( 'All Slides', TEXT_DOMAIN_POST_TYPE ),
        'search_items'       => __( 'Search Slides', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon'  => __( 'Parent Slides:', TEXT_DOMAIN_POST_TYPE ),
        'not_found'          => __( 'No Slides found.', TEXT_DOMAIN_POST_TYPE ),
        'not_found_in_trash' => __( 'No Slides found in Trash.', TEXT_DOMAIN_POST_TYPE ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-format-gallery',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'slideshow' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail','comments'),
        'taxonomies'          => array('slidegroup'),
    );

    register_post_type( 'slideshow', $args );
}


add_action( 'init', 'create_slidegroup_taxonomies', 0 );
// create slidegroup taxonomy
function create_slidegroup_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => __( 'Group', 'taxonomy general name' , TEXT_DOMAIN_POST_TYPE),
        'singular_name'     => __( 'Group', 'taxonomy singular name' , TEXT_DOMAIN_POST_TYPE),
        'search_items'      => __( 'Search Group', TEXT_DOMAIN_POST_TYPE),
        'all_items'         => __( 'All Group', TEXT_DOMAIN_POST_TYPE ),
        'parent_item'       => __( 'Parent Group', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon' => __( 'Parent Group:' , TEXT_DOMAIN_POST_TYPE),
        'edit_item'         => __( 'Edit Group' , TEXT_DOMAIN_POST_TYPE),
        'update_item'       => __( 'Update Group' , TEXT_DOMAIN_POST_TYPE),
        'add_new_item'      => __( 'Add New Group' , TEXT_DOMAIN_POST_TYPE),
        'new_item_name'     => __( 'New Group Name' , TEXT_DOMAIN_POST_TYPE),
        'menu_name'         => __( 'Group' , TEXT_DOMAIN_POST_TYPE),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'slideshow' )
    );

    register_taxonomy( 'slidegroup', array('slideshow'), $args );
}



// Schedule /////////////////////////////////////////////////////////
add_action( 'init', 'schedule_post_type', 0 );
function schedule_post_type() {

    $labels = array(
        'name'                => __( 'Schedule', 'Post Type General Name', TEXT_DOMAIN_POST_TYPE ),
        'singular_name'       => __( 'Schedule', 'Post Type Singular Name', TEXT_DOMAIN_POST_TYPE ),
        'menu_name'           => __( 'Schedule', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon'   => __( 'Parent Schedule:', TEXT_DOMAIN_POST_TYPE ),
        'all_items'           => __( 'All Schedules', TEXT_DOMAIN_POST_TYPE ),
        'view_item'           => __( 'View Schedule', TEXT_DOMAIN_POST_TYPE ),
        'add_new_item'        => __( 'Add New Schedule', TEXT_DOMAIN_POST_TYPE ),
        'add_new'             => __( 'Add New Schedule', TEXT_DOMAIN_POST_TYPE ),
        'edit_item'           => __( 'Edit Schedule', TEXT_DOMAIN_POST_TYPE ),
        'update_item'         => __( 'Update Schedule', TEXT_DOMAIN_POST_TYPE ),
        'search_items'        => __( 'Search Schedules', TEXT_DOMAIN_POST_TYPE ),
        'not_found'           => __( 'No Schedules found', TEXT_DOMAIN_POST_TYPE ),
        'not_found_in_trash'  => __( 'No Schedules found in Trash', TEXT_DOMAIN_POST_TYPE ),
    );
    $args = array(
        'label'               => __( 'schedule', TEXT_DOMAIN_POST_TYPE ),
        'description'         => __( 'Schedule information pages', TEXT_DOMAIN_POST_TYPE ),
        'labels'              => $labels,
        'supports'            => array( 'thumbnail', 'editor', 'title', 'comments'),
        'taxonomies'          => array('categories'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'menu_icon'          => 'dashicons-calendar',
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => null,        
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'schedule', $args );
}

add_action( 'init', 'create_schedule_taxonomies', 0 );
// create categories taxonomy
function create_schedule_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => __( 'Categories', 'taxonomy general name' , TEXT_DOMAIN_POST_TYPE),
        'singular_name'     => __( 'Categories', 'taxonomy singular name' , TEXT_DOMAIN_POST_TYPE),
        'search_items'      => __( 'Search Categories', TEXT_DOMAIN_POST_TYPE),
        'all_items'         => __( 'All Categories', TEXT_DOMAIN_POST_TYPE ),
        'parent_item'       => __( 'Parent Category', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon' => __( 'Parent Category:' , TEXT_DOMAIN_POST_TYPE),
        'edit_item'         => __( 'Edit Category' , TEXT_DOMAIN_POST_TYPE),
        'update_item'       => __( 'Update Category' , TEXT_DOMAIN_POST_TYPE),
        'add_new_item'      => __( 'Add New Category' , TEXT_DOMAIN_POST_TYPE),
        'new_item_name'     => __( 'New Category Name' , TEXT_DOMAIN_POST_TYPE),
        'menu_name'         => __( 'Categories' , TEXT_DOMAIN_POST_TYPE),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'schedule' )        
    );

    register_taxonomy( 'categories', array('schedule'), $args );
}


// Speaker /////////////////////////////////////////////////////////
add_action( 'init', 'speaker_post_type', 0 );
function speaker_post_type() {

    $labels = array(
        'name'                => __( 'Speaker', 'Post Type General Name', TEXT_DOMAIN_POST_TYPE ),
        'singular_name'       => __( 'Speaker', 'Post Type Singular Name', TEXT_DOMAIN_POST_TYPE ),
        'menu_name'           => __( 'Speaker', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon'   => __( 'Parent Speaker:', TEXT_DOMAIN_POST_TYPE ),
        'all_items'           => __( 'All Speakers', TEXT_DOMAIN_POST_TYPE ),
        'view_item'           => __( 'View Speaker', TEXT_DOMAIN_POST_TYPE ),
        'add_new_item'        => __( 'Add New Speaker', TEXT_DOMAIN_POST_TYPE ),
        'add_new'             => __( 'Add New Speaker', TEXT_DOMAIN_POST_TYPE ),
        'edit_item'           => __( 'Edit Speaker', TEXT_DOMAIN_POST_TYPE ),
        'update_item'         => __( 'Update Speaker', TEXT_DOMAIN_POST_TYPE ),
        'search_items'        => __( 'Search Speakers', TEXT_DOMAIN_POST_TYPE ),
        'not_found'           => __( 'No Speakers found', TEXT_DOMAIN_POST_TYPE ),
        'not_found_in_trash'  => __( 'No Speakers found in Trash', TEXT_DOMAIN_POST_TYPE ),
    );
    $args = array(
        'label'               => __( 'speaker', TEXT_DOMAIN_POST_TYPE ),
        'description'         => __( 'speaker information pages', TEXT_DOMAIN_POST_TYPE ),
        'labels'              => $labels,
        'supports'            => array( 'thumbnail', 'editor', 'title', 'comments'),
        'taxonomies'          => array('group'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'menu_icon'          => 'dashicons-calendar',
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => null,        
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'speaker', $args );
}

add_action( 'init', 'create_speaker_taxonomies', 0 );
// create groupspeaker taxonomy
function create_speaker_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => __( 'Group', 'taxonomy general name' , TEXT_DOMAIN_POST_TYPE),
        'singular_name'     => __( 'Group', 'taxonomy singular name' , TEXT_DOMAIN_POST_TYPE),
        'search_items'      => __( 'Search Group', TEXT_DOMAIN_POST_TYPE),
        'all_items'         => __( 'All Group', TEXT_DOMAIN_POST_TYPE ),
        'parent_item'       => __( 'Parent Group', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon' => __( 'Parent Group:' , TEXT_DOMAIN_POST_TYPE),
        'edit_item'         => __( 'Edit Group' , TEXT_DOMAIN_POST_TYPE),
        'update_item'       => __( 'Update Group' , TEXT_DOMAIN_POST_TYPE),
        'add_new_item'      => __( 'Add New Group' , TEXT_DOMAIN_POST_TYPE),
        'new_item_name'     => __( 'New Group Name' , TEXT_DOMAIN_POST_TYPE),
        'menu_name'         => __( 'Group' , TEXT_DOMAIN_POST_TYPE),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'speaker' )        
    );

    register_taxonomy( 'group', array('speaker'), $args );
}




// Faq //////////////////////////////////////////////////////////
add_action( 'init', 'faq_init' );
function faq_init() { 
    
    $labels = array(
        'name'               => __( 'Faq', 'post type general name', TEXT_DOMAIN_POST_TYPE ),
        'singular_name'      => __( 'Faq', 'post type singular name', TEXT_DOMAIN_POST_TYPE ),
        'menu_name'          => __( 'Faq', 'admin menu', TEXT_DOMAIN_POST_TYPE ),
        'name_admin_bar'     => __( 'Faq', 'add new on admin bar', TEXT_DOMAIN_POST_TYPE ),
        'add_new'            => __( 'Add New Faq', 'Speaker', TEXT_DOMAIN_POST_TYPE ),
        'add_new_item'       => __( 'Add New Faq', TEXT_DOMAIN_POST_TYPE ),
        'new_item'           => __( 'New Faq', TEXT_DOMAIN_POST_TYPE ),
        'edit_item'          => __( 'Edit Faq', TEXT_DOMAIN_POST_TYPE ),
        'view_item'          => __( 'View Faq', TEXT_DOMAIN_POST_TYPE ),
        'all_items'          => __( 'All Faqs', TEXT_DOMAIN_POST_TYPE ),
        'search_items'       => __( 'Search Faqs', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon'  => __( 'Parent Faqs:', TEXT_DOMAIN_POST_TYPE ),
        'not_found'          => __( 'No Faq found.', TEXT_DOMAIN_POST_TYPE ),
        'not_found_in_trash' => __( 'No Faq found in Trash.', TEXT_DOMAIN_POST_TYPE ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-editor-help',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'faq' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail','comments'),
        'taxonomies'          => array('faqgroup'),

    );

    register_post_type( 'faq', $args );
}


add_action( 'init', 'create_faq_taxonomies', 0 );
// create faqgroup taxonomy
function create_faq_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => __( 'Group', 'taxonomy general name' , TEXT_DOMAIN_POST_TYPE),
        'singular_name'     => __( 'Group', 'taxonomy singular name' , TEXT_DOMAIN_POST_TYPE),
        'search_items'      => __( 'Search Group', TEXT_DOMAIN_POST_TYPE),
        'all_items'         => __( 'All Group', TEXT_DOMAIN_POST_TYPE ),
        'parent_item'       => __( 'Parent Group', TEXT_DOMAIN_POST_TYPE ),
        'parent_item_colon' => __( 'Parent Group:' , TEXT_DOMAIN_POST_TYPE),
        'edit_item'         => __( 'Edit Group' , TEXT_DOMAIN_POST_TYPE),
        'update_item'       => __( 'Update Group' , TEXT_DOMAIN_POST_TYPE),
        'add_new_item'      => __( 'Add New Group' , TEXT_DOMAIN_POST_TYPE),
        'new_item_name'     => __( 'New Group Name' , TEXT_DOMAIN_POST_TYPE),
        'menu_name'         => __( 'Group' , TEXT_DOMAIN_POST_TYPE),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'faq' )
    );

    register_taxonomy( 'faqgroup', array('faq'), $args );
}