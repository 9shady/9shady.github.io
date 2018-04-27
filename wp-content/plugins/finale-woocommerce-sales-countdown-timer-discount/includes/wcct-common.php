<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class WCCT_Common
 * Handles Common Functions For Admin as well as front end interface
 * @package Finale-Lite
 * @author XlPlugins
 */
class WCCT_Common {

	public static $wcct_post;
	public static $wcct_query;
	public static $is_front_page = false;
	public static $is_executing_rule = false;
	public static $is_force_debug = false;
	public static $info_generated = false;
	protected static $default;

	public static function init() {

		add_action( 'init', array( __CLASS__, 'register_post_status' ), 5 );

		/** Necessary Hooks For Rules functionality */
		add_action( 'init', array( __CLASS__, 'register_countdown_post_type' ) );
		add_action( 'init', array( __CLASS__, 'load_rules_classes' ) );


		add_filter( 'wcct_wcct_rule_get_rule_types', array( __CLASS__, 'default_rule_types' ), 1 );

		add_action( 'wp_ajax_wcct_change_rule_type', array( __CLASS__, 'ajax_render_rule_choice' ) );

		add_action( 'save_post', array( __CLASS__, 'save_data' ), 10, 2 );
		/**
		 * Checking query params
		 */
		add_action( 'init', array( __CLASS__, 'check_query_params' ), 1 );

		/**
		 * Loading XL core
		 */
		add_action( 'init', array( __CLASS__, 'wcct_xl_init' ), 8 );

		/**
		 * Containing current Page State using wp hook
		 * using priority 0 to make sure it is not changed by that moment
		 */
		add_action( 'wp', array( __CLASS__, 'wcct_contain_current_query' ), 1 );

		// ajax
		add_action( 'wp_ajax_wcct_close_sticky_bar', array( __CLASS__, 'wcct_close_sticky_bar' ) );
		add_action( 'wp_ajax_nopriv_wcct_close_sticky_bar', array( __CLASS__, 'wcct_close_sticky_bar' ) );

		add_action( 'wp_ajax_wcct_quick_view_html', array( __CLASS__, 'wcct_quick_view_html' ) );

		add_action( 'wcct_data_setup_done', array( __CLASS__, 'init_header_logs' ), 999 );

		add_action( 'admin_bar_menu', array( __CLASS__, 'toolbar_link_to_xlplugins' ), 999 );

		add_filter( 'wcct_localize_js_data', array( __CLASS__, 'add_license_info' ) );

		add_action( 'wcct_schedule_reset_state', array( __CLASS__, 'process_reset_state' ), 10, 1 );

		add_action( 'wp_ajax_wcct_refreshed_times', array( __CLASS__, 'reset_timer_time' ) );
		add_action( 'wp_ajax_nopriv_wcct_refreshed_times', array( __CLASS__, 'reset_timer_time' ) );

		add_action( 'wcct_goaldeal_sold_backup', array( __CLASS__, 'wcct_goaldeal_sold_backup_callback' ), 10 );
	}

	public static function wcct_get_date_format() {
		$date_format = get_option( 'date_format', true );
		$date_format = $date_format ? $date_format : 'M d, Y';

		return $date_format;
	}

	public static function array_flatten( $array ) {
		if ( ! is_array( $array ) ) {
			return false;
		}
		$result = iterator_to_array( new RecursiveIteratorIterator( new RecursiveArrayIterator( $array ) ), false );

		return $result;
	}

	public static function array_flat_mysql_results( $results, $expected_key, $expected_value_key ) {
		$array = array();
		foreach ( $results as $result ) {
			$array[ $result[ $expected_key ] ] = (int) $result[ $expected_value_key ];
		}

		return $array;
	}

	public static function get_date_modified( $mod, $format ) {
		$date_object = new DateTime();
		$date_object->setTimestamp( current_time( 'timestamp' ) );

		return $date_object->modify( $mod )->format( ( $format ) );
	}

	public static function get_current_date( $format ) {
		$date_object = new DateTime();
		$date_object->setTimestamp( current_time( 'timestamp' ) );

		return $date_object->format( $format );
	}

	public static function register_countdown_post_type() {
		$menu_name = _x( WCCT_FULL_NAME, 'Admin menu name', 'finale-woocommerce-sales-countdown-timer-discount' );

		register_post_type( self::get_campaign_post_type_slug(), apply_filters( 'wcct_post_type_args', array(
			'labels'               => array(
				'name'               => __( 'Countdown Timer', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'singular_name'      => __( 'Countdown Timer', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'add_new'            => __( 'Add Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'add_new_item'       => __( 'Add New Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'edit'               => __( 'Edit', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'edit_item'          => __( 'Edit Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'new_item'           => __( 'New Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'view'               => __( 'View Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'view_item'          => __( 'View Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'search_items'       => __( 'Search Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'not_found'          => __( 'No Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'not_found_in_trash' => __( 'No Campaign found in trash', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'parent'             => __( 'Parent Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'menu_name'          => $menu_name
			),
			'public'               => true,
			'show_ui'              => true,
			'capability_type'      => 'product',
			'map_meta_cap'         => true,
			'publicly_queryable'   => false,
			'exclude_from_search'  => true,
			'show_in_menu'         => false,
			'hierarchical'         => false,
			'show_in_nav_menus'    => false,
			'rewrite'              => false,
			'query_var'            => true,
			'supports'             => array( 'title' ),
			'has_archive'          => false,
			'register_meta_box_cb' => array( 'WCCT_Admin', 'add_metaboxes' )
		) ) );
	}

	public static function get_campaign_post_type_slug() {
		return 'wcct_countdown';
	}

	public static function load_rules_classes() {
		//Include the compatibility class
		include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/class-wcct-compatibility.php';

		//Include our default rule classes
		include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/rules/base.php';
		include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/rules/general.php';

		include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/rules/products.php';


		if ( is_admin() || defined( 'DOING_AJAX' ) ) {
			//Include the admin interface builder
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/class-wcct-input-builder.php';
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/inputs/html-always.php';
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/inputs/text.php';
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/inputs/select.php';
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/inputs/product-select.php';
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/inputs/chosen-select.php';
			include plugin_dir_path( WCCT_PLUGIN_FILE ) . '/rules/inputs/html-general-front.php';
		}
	}

	/**
	 * Creates an instance of an input object
	 * @global type $woocommerce_wcct_rule_inputs
	 *
	 * @param type $input_type The slug of the input type to load
	 *
	 * @return type An instance of an WCCT_Input object type
	 */
	public static function woocommerce_wcct_rule_get_input_object( $input_type ) {
		global $woocommerce_wcct_rule_inputs;

		if ( isset( $woocommerce_wcct_rule_inputs[ $input_type ] ) ) {
			return $woocommerce_wcct_rule_inputs[ $input_type ];
		}

		$class = 'WCCT_Input_' . str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $input_type ) ) );

		if ( class_exists( $class ) ) {
			$woocommerce_wcct_rule_inputs[ $input_type ] = new $class;
		} else {
			$woocommerce_wcct_rule_inputs[ $input_type ] = apply_filters( 'woocommerce_wcct_rule_get_input_object', $input_type );
		}

		return $woocommerce_wcct_rule_inputs[ $input_type ];
	}

	/**
	 * Ajax and PHP Rendering Functions for Options.
	 *
	 * Renders the correct Operator and Values controls.
	 */
	public static function ajax_render_rule_choice( $options ) {
		// defaults
		$defaults = array(
			'group_id'  => 0,
			'rule_id'   => 0,
			'rule_type' => null,
			'condition' => null,
			'operator'  => null,
		);

		$is_ajax = false;

		if ( isset( $_POST['action'] ) && $_POST['action'] == 'wcct_change_rule_type' ) {
			$is_ajax = true;
		}

		if ( $is_ajax ) {
			if ( ! check_ajax_referer( 'wcctaction-admin', 'security' ) ) {
				die();
			}
			$options = array_merge( $defaults, $_POST );
		} else {
			$options = array_merge( $defaults, $options );
		}

		$rule_object = self::woocommerce_wcct_rule_get_rule_object( $options['rule_type'] );

		if ( ! empty( $rule_object ) ) {
			$values               = $rule_object->get_possibile_rule_values();
			$operators            = $rule_object->get_possible_rule_operators();
			$condition_input_type = $rule_object->get_condition_input_type();
			// create operators field
			$operator_args = array(
				'input'   => 'select',
				'name'    => 'wcct_rule[' . $options['group_id'] . '][' . $options['rule_id'] . '][operator]',
				'choices' => $operators,
			);

			echo '<td class="operator">';
			if ( ! empty( $operators ) ) {
				WCCT_Input_Builder::create_input_field( $operator_args, $options['operator'] );
			} else {
				echo '<input type="hidden" name="' . $operator_args['name'] . '" value="==" />';
			}
			echo '</td>';

			// create values field
			$value_args = array(
				'input'   => $condition_input_type,
				'name'    => 'wcct_rule[' . $options['group_id'] . '][' . $options['rule_id'] . '][condition]',
				'choices' => $values,
			);

			echo '<td class="condition">';
			WCCT_Input_Builder::create_input_field( $value_args, $options['condition'] );
			echo '</td>';
		}

		// ajax?
		if ( $is_ajax ) {
			die();
		}
	}

	/**
	 * Creates an instance of a rule object
	 * @global array $woocommerce_wcct_rule_rules
	 *
	 * @param type $rule_type The slug of the rule type to load.
	 *
	 * @return WCCT_Rule_Base or superclass of WCCT_Rule_Base
	 */
	public static function woocommerce_wcct_rule_get_rule_object( $rule_type ) {
		global $woocommerce_wcct_rule_rules;

		if ( isset( $woocommerce_wcct_rule_rules[ $rule_type ] ) ) {
			return $woocommerce_wcct_rule_rules[ $rule_type ];
		}

		$class = 'WCCT_Rule_' . $rule_type;
		if ( class_exists( $class ) ) {
			$woocommerce_wcct_rule_rules[ $rule_type ] = new $class;

			return $woocommerce_wcct_rule_rules[ $rule_type ];
		} else {
			return null;
		}
	}

	/**
	 * Called from the metabox_settings.php screen.  Renders the template for a rule group that has already been saved.
	 *
	 * @param array $options The group config options to render the template with.
	 */
	public static function render_rule_choice_template( $options ) {
		// defaults
		$defaults = array(
			'group_id'  => 0,
			'rule_id'   => 0,
			'rule_type' => null,
			'condition' => null,
			'operator'  => null,
		);


		$options     = array_merge( $defaults, $options );
		$rule_object = self::woocommerce_wcct_rule_get_rule_object( $options['rule_type'] );

		$values               = $rule_object->get_possibile_rule_values();
		$operators            = $rule_object->get_possible_rule_operators();
		$condition_input_type = $rule_object->get_condition_input_type();

		// create operators field
		$operator_args = array(
			'input'   => 'select',
			'name'    => 'wcct_rule[<%= groupId %>][<%= ruleId %>][operator]',
			'choices' => $operators,
		);

		echo '<td class="operator">';
		if ( ! empty( $operators ) ) {
			WCCT_Input_Builder::create_input_field( $operator_args, $options['operator'] );
		} else {
			echo '<input type="hidden" name="' . $operator_args['name'] . '" value="==" />';
		}
		echo '</td>';

		// create values field
		$value_args = array(
			'input'   => $condition_input_type,
			'name'    => 'wcct_rule[<%= groupId %>][<%= ruleId %>][condition]',
			'choices' => $values,
		);

		echo '<td class="condition">';
		WCCT_Input_Builder::create_input_field( $value_args, $options['condition'] );
		echo '</td>';
	}

	public static function get_campaign_status_select() {
		$triggers            = self::get_campaign_statuses();
		$create_select_array = array();
		if ( $triggers && is_array( $triggers ) && count( $triggers ) > 0 ) {
			foreach ( $triggers as $triggerlist ) {
				$create_select_array[ $triggerlist['name'] ] = array();

				foreach ( $triggerlist['triggers'] as $triggers_main ) {
					$create_select_array[ $triggerlist['name'] ][ $triggers_main["slug"] ] = $triggers_main['title'];
				}
			}
		}

		return $create_select_array;
	}

	/**
	 * Getting list of declared triggers in hierarchical order
	 * @return array array of triggers
	 */
	public static function get_campaign_statuses() {
		return array(
			'running'     => array(
				'name'     => __( 'Running', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'slug'     => 'running',
				'position' => 5
			),
			'schedule'    => array(
				'name'     => __( 'Scheduled', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'slug'     => 'schedule',
				'position' => 7
			),
			'finished'    => array(
				'name'     => __( 'Finished', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'slug'     => 'finished',
				'position' => 8
			),
			'deactivated' => array(
				'name'     => __( 'Deactivated', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'slug'     => 'deactivated',
				'position' => 9
			),
		);
	}

	public static function match_groups( $content_id, $productID = 0 ) {

		$display = false;

		$xl_cache_obj = XL_Cache::get_instance();

		if ( $productID ) {
			$cache_key = "wcct_countdown_match_groups_" . $content_id . "_" . $productID;
		} else {
			$cache_key = "wcct_countdown_match_groups_" . $content_id;
		}

		$cache_data = $xl_cache_obj->get_cache( $cache_key, 'finale' );
		if ( false !== $cache_data ) {
			$display = ( $cache_data == "yes" ) ? true : false;
		} else {
			do_action( 'wcct_before_apply_rules', $content_id, $productID );
			self::$is_executing_rule = true;

			//allowing rules to get manipulated using external logic
			$external_rules = apply_filters( 'wcct_modify_rules', true, $content_id, $productID );
			if ( ! $external_rules ) {
				$xl_cache_obj->set_cache( $cache_key, "no", 'finale' );
				self::$is_executing_rule = false;

				return false;
			}

			$groups = get_post_meta( $content_id, 'wcct_rule', true );

			if ( $groups && is_array( $groups ) && count( $groups ) ) {
				foreach ( $groups as $group_id => $group ) {
					$result = null;

					foreach ( $group as $rule_id => $rule ) {
						$rule_object = self::woocommerce_wcct_rule_get_rule_object( $rule['rule_type'] );
						if ( is_object( $rule_object ) ) {
							$match = $rule_object->is_match( $rule, $productID );
							if ( false === $match) {
								$result = false;
								break;
							}
							$result = ( $result !== null ? ( $result & $match ) : $match );
						}
					}

					if ( $result ) {
						$display = true;
						break;
					}
				}
			} else {
				$display = true; //Always display the content if no rules have been configured.
			}

			$xl_cache_obj->set_cache( $cache_key, ( $display ) ? "yes" : "no", 'finale' );
			do_action( 'wcct_after_apply_rules', $content_id, $productID );
		}
		self::$is_executing_rule = false;

		return $display;
	}


	/**
	 * Hooked into wcct_get_rule_types to get the default list of rule types.
	 *
	 * @param array $types Current list, if any, of rule types.
	 *
	 * @return array the list of rule types.
	 */
	public static function default_rule_types( $types ) {

		$types = array(
			__( 'General', 'finale-woocommerce-sales-countdown-timer-discount' )                                                       => array(
				'general_always' => __( 'Always', 'finale-woocommerce-sales-countdown-timer-discount' ),
			),
			__( 'Product (suitable when campaign has discounts, inventory etc)', 'finale-woocommerce-sales-countdown-timer-discount' ) => array(
				'general_all_products' => __( 'All Products', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'product_select'       => __( 'Products', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'product_type'         => __( 'Product Type', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'product_category'     => __( 'Product Category', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'product_tags'         => __( 'Product Tags', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'product_price'        => __( 'Product Price', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'sale_status'          => __( 'Sale Status', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'stock_status'         => __( 'Stock Status', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'stock_level'          => __( 'Stock Quantity', 'finale-woocommerce-sales-countdown-timer-discount' ),
			),
			__( 'Page', 'finale-woocommerce-sales-countdown-timer-discount' )                                                          => array(
				'general_all_pages'        => __( 'All Pages', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'single_page'              => __( 'Specific Page(s)', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'general_front_page'       => __( 'Home Page (Front Page)', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'general_all_product_cats' => __( 'All Product Category Pages', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'single_product_cat_tax'   => __( 'Specific Product Category Page(s)', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'general_all_product_tags' => __( 'All Product Tags Pages', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'single_product_tags_tax'  => __( 'Specific Product Tags Page(s)', 'finale-woocommerce-sales-countdown-timer-discount' ),
			),
			__( 'Geography', 'finale-woocommerce-sales-countdown-timer-discount' )                                                     => array(
				'geo_country_code' => __( 'Country', 'finale-woocommerce-sales-countdown-timer-discount' ),
			),
			__( 'Date/Time', 'finale-woocommerce-sales-countdown-timer-discount' )                                                     => array(
				'day'  => __( 'Day', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'date' => __( 'Date', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'time' => __( 'Time', 'finale-woocommerce-sales-countdown-timer-discount' ),
			),
			__( 'Membership', 'finale-woocommerce-sales-countdown-timer-discount' )                                                    => array(
				'users_user' => __( 'User', 'finale-woocommerce-sales-countdown-timer-discount' ),
				'users_role' => __( 'Role', 'finale-woocommerce-sales-countdown-timer-discount' ),

			),
		);

		return apply_filters( 'wcct_rules_options', $types );

	}

	/**
	 * Saves the data for the wcct post type.
	 *
	 * @param int $post_id Post ID
	 * @param WP_Post Post Object
	 *
	 * @return null
	 */
	public static function save_data( $post_id, $post ) {
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( is_int( wp_is_post_revision( $post ) ) ) {
			return;
		}
		if ( is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}
		if ( $post->post_type != self::get_campaign_post_type_slug() ) {
			return;
		}


		$key = "WCCT_INSTANCES";
		if ( defined( 'ICL_LANGUAGE_CODE' ) && ICL_LANGUAGE_CODE !== "" ) {
			$key .= "_" . ICL_LANGUAGE_CODE;
		}

		delete_transient( $key );
		if ( isset( $_POST['wcct_settings_location'] ) ) {
			$location = explode( ':', $_POST['wcct_settings_location'] );
			$settings = array( 'location' => $location[0], 'hook' => $location[1] );

			if ( $settings['hook'] == 'custom' ) {
				$settings['custom_hook']     = $_POST['wcct_settings_location_custom_hook'];
				$settings['custom_priority'] = $_POST['wcct_settings_location_custom_priority'];
			} else {
				$settings['custom_hook']     = '';
				$settings['custom_priority'] = '';
			}

			$settings['type'] = $_POST['wcct_settings_type'];

			update_post_meta( $post_id, '_wcct_settings', $settings );
		}

		if ( isset( $_POST['wcct_rule'] ) ) {
			update_post_meta( $post_id, 'wcct_rule', $_POST['wcct_rule'] );
		} else {
			//  delete_post_meta($post_id, 'wcct_rule');
		}
	}

	public static function get_post_table_data( $trigger = 'all' ) {
		if ( $trigger == "all" ) {
			$args = array(
				'post_type'        => self::get_campaign_post_type_slug(),
				'post_status'      => array( 'publish', WCCT_SHORT_SLUG . 'disabled' ),
				'nopaging'         => true,
				'suppress_filters' => false, //WPML Compatibility
				'meta_key'         => '_wcct_campaign_menu_order',
				'orderby'          => 'meta_value_num',
				'order'            => 'ASC',

			);
		} else {
			$meta_q      = array();
			$post_status = "";
			if ( $trigger == "deactivated" ) {
				$post_status = WCCT_SHORT_SLUG . "disabled";
			} else {
				$meta_q[] = array(
					'key'     => '_wcct_current_status_timing',
					'value'   => $trigger,
					'compare' => '=',
				);
			}
			$args = array(
				'post_type'        => self::get_campaign_post_type_slug(),
				'post_status'      => array( 'publish', WCCT_SHORT_SLUG . 'disabled' ),
				'nopaging'         => true,
				'suppress_filters' => false,   //WPML Compatibility
				'meta_key'         => '_wcct_campaign_menu_order',
				'orderby'          => 'meta_value_num',
				'order'            => 'ASC',
			);
			if ( $post_status != "" ) {
				$args["post_status"] = $post_status;
			} else {
				$args["post_status"] = "publish";
			}
			if ( is_array( $meta_q ) && count( $meta_q ) > 0 ) {
				$args["meta_query"] = $meta_q;
			}
		}

		$q = new WP_Query( $args );

		$found_posts = array();
		if ( $q->have_posts() ) {

			while ( $q->have_posts() ) {
				$q->the_post();
				$status      = get_post_status( get_the_ID() );
				$row_actions = array();

				$deactivation_url = wp_nonce_url( add_query_arg( 'page', 'wc-settings', add_query_arg( 'tab', self::get_wc_settings_tab_slug(), add_query_arg( 'action', 'wcct-post-deactivate', add_query_arg( 'postid', get_the_ID(), add_query_arg( 'trigger', $trigger ) ), network_admin_url( 'admin.php' ) ) ) ), 'wcct-post-deactivate' );

				if ( $status == WCCT_SHORT_SLUG . 'disabled' ) {

					$text = __( 'Activate', 'finale-woocommerce-sales-countdown-timer-discount' );
					$link = get_post_permalink( get_the_ID() );

					$activation_url = wp_nonce_url( add_query_arg( 'page', 'wc-settings', add_query_arg( 'tab', self::get_wc_settings_tab_slug(), add_query_arg( 'action', 'wcct-post-activate', add_query_arg( 'postid', get_the_ID(), add_query_arg( 'trigger', $trigger ) ), network_admin_url( 'admin.php' ) ) ) ), 'wcct-post-activate' );

					$row_actions[] = array(
						'action' => 'activate',
						'text'   => __( 'Activate', 'finale-woocommerce-sales-countdown-timer-discount' ),
						'link'   => $activation_url,
						'attrs'  => '',
					);
				} else {
					$row_actions[] = array(
						'action' => 'edit',
						'text'   => __( 'Edit', 'finale-woocommerce-sales-countdown-timer-discount' ),
						'link'   => get_edit_post_link( get_the_ID() ),
						'attrs'  => '',
					);

					$row_actions[] = array(
						'action' => 'deactivate',
						'text'   => __( 'Deactivate', 'finale-woocommerce-sales-countdown-timer-discount' ),
						'link'   => $deactivation_url,
						'attrs'  => '',
					);
				}
				$row_actions[] = array(
					'action' => 'wcct_duplicate',
					'text'   => __( 'Duplicate Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
					'link'   => wp_nonce_url( add_query_arg( 'page', 'wc-settings', add_query_arg( 'tab', self::get_wc_settings_tab_slug(), add_query_arg( 'action', 'wcct-duplicate', add_query_arg( 'postid', get_the_ID(), add_query_arg( 'trigger', $trigger ) ), network_admin_url( 'admin.php' ) ) ) ), 'wcct-duplicate' ),
					'attrs'  => '',
				);
				$row_actions[] = array(
					'action' => 'delete',
					'text'   => __( 'Delete Permanently', 'finale-woocommerce-sales-countdown-timer-discount' ),
					'link'   => get_delete_post_link( get_the_ID(), '', true ),
					'attrs'  => '',
				);


				array_push( $found_posts, array(
					'id'             => get_the_ID(),
					'trigger_status' => $status,
					'row_actions'    => $row_actions
				) );
			}
		}

		return $found_posts;
	}

	public static function get_wc_settings_tab_slug() {
		return 'xl-countdown-timer';
	}

	public static function pr( $arr ) {
		echo '<pre>';
		print_r( $arr );
		echo '</pre>';
	}

	/*
	 *  register_post_status
	 *
	 *  This function will register custom post statuses
	 *
	 *  @type	function
	 *  @date	22/10/2015
	 *  @since	5.3.2
	 *
	 *  @param	$post_id (int)
	 *  @return	$post_id (int)
	 */

	public static function register_post_status() {

		// acf-disabled
		register_post_status( WCCT_SHORT_SLUG . 'disabled', array(
			'label'                     => __( 'Disabled', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Disabled <span class="count">(%s)</span>', 'Disabled <span class="count">(%s)</span>', 'finale-woocommerce-sales-countdown-timer-discount' ),
		) );
	}

	public static function get_parent_slug( $slug ) {

		foreach ( self::get_campaign_statuses() as $key => $trigger_list ) {

			if ( isset( $trigger_list['triggers'] ) && is_array( $trigger_list['triggers'] ) && count( $trigger_list['triggers'] ) > 0 ) {
				foreach ( $trigger_list['triggers'] as $trigger ) {

					if ( $trigger['slug'] == $slug ) {
						return $key;
					}
				}
			}
		}
	}

	public static function wcct_get_between( $content, $start, $end ) {
		$r = explode( $start, $content );
		if ( isset( $r[1] ) ) {
			$r = explode( $end, $r[1] );

			return $r[0];
		}

		return '';
	}

	public static function wcct_xl_init() {
		XL_Common::include_xl_core();
	}

	public static function wcct_contain_current_query() {
		global $post, $wp_query;

		self::$wcct_post  = $post;
		self::$wcct_query = $wp_query;

		if ( is_front_page() && is_home() ) {
			self::$is_front_page = true;
		} elseif ( is_front_page() ) {
			self::$is_front_page = true;
		}
	}

	public static function get_timezone_difference() {
		$date_obj_utc = new DateTime( "now", new DateTimeZone( 'UTC' ) );
		$diff         = timezone_offset_get( timezone_open( self::wc_timezone_string() ), $date_obj_utc );

		return $diff;
	}

	/**
	 * Function to get timezone string by checking wordpress timezone settings
	 * @return mixed|string|void
	 */
	public static function wc_timezone_string() {

		// if site timezone string exists, return it
		if ( $timezone = get_option( 'timezone_string' ) ) {
			return $timezone;
		}

		// get UTC offset, if it isn't set then return UTC
		if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) ) {
			return 'UTC';
		}

		// get timezone using offset manual
		return WCCT_Common::get_timezone_by_offset( $utc_offset );
	}

	/**
	 * Function to get timezone string based on specified offset
	 * @see WCCT_Common::wc_timezone_string()
	 *
	 * @param $offset
	 *
	 * @return string
	 */
	public static function get_timezone_by_offset( $offset ) {
		switch ( $offset ) {
			case '-12':
				return 'GMT-12';
				break;
			case '-11.5':
				return 'Pacific/Niue'; // 30 mins wrong
				break;
			case '-11':
				return 'Pacific/Niue';
				break;
			case '-10.5':
				return 'Pacific/Honolulu'; // 30 mins wrong
				break;
			case '-10':
				return 'Pacific/Tahiti';
				break;
			case '-9.5':
				return 'Pacific/Marquesas';
				break;
			case '-9':
				return 'Pacific/Gambier';
				break;
			case '-8.5':
				return 'Pacific/Pitcairn'; // 30 mins wrong
				break;
			case '-8':
				return 'Pacific/Pitcairn';
				break;
			case '-7.5':
				return 'America/Hermosillo'; // 30 mins wrong
				break;
			case '-7':
				return 'America/Hermosillo';
				break;
			case '-6.5':
				return 'America/Belize'; // 30 mins wrong
				break;
			case '-6':
				return 'America/Belize';
				break;
			case '-5.5':
				return 'America/Belize'; // 30 mins wrong
				break;
			case '-5':
				return 'America/Panama';
				break;
			case '-4.5':
				return 'America/Lower_Princes'; // 30 mins wrong
				break;
			case '-4':
				return 'America/Curacao';
				break;
			case '-3.5':
				return 'America/Paramaribo'; // 30 mins wrong
				break;
			case '-3':
				return 'America/Recife';
				break;
			case '-2.5':
				return 'America/St_Johns';
				break;
			case '-2':
				return 'America/Noronha';
				break;
			case '-1.5':
				return 'Atlantic/Cape_Verde'; // 30 mins wrong
				break;
			case '-1':
				return 'Atlantic/Cape_Verde';
				break;
			case '+1':
				return 'Africa/Luanda';
				break;
			case '+1.5':
				return 'Africa/Mbabane'; // 30 mins wrong
				break;
			case '+2':
				return 'Africa/Harare';
				break;
			case '+2.5':
				return 'Indian/Comoro'; // 30 mins wrong
				break;
			case '+3':
				return 'Asia/Baghdad';
				break;
			case '+3.5':
				return 'Indian/Mauritius'; // 30 mins wrong
				break;
			case '+4':
				return 'Indian/Mauritius';
				break;
			case '+4.5':
				return 'Asia/Kabul';
				break;
			case '+5':
				return 'Indian/Maldives';
				break;
			case '+5.5':
				return 'Asia/Kolkata';
				break;
			case '+5.75':
				return 'Asia/Kathmandu';
				break;
			case '+6':
				return 'Asia/Urumqi';
				break;
			case '+6.5':
				return 'Asia/Yangon';
				break;
			case '+7':
				return 'Antarctica/Davis';
				break;
			case '+7.5':
				return 'Asia/Jakarta'; // 30 mins wrong
				break;
			case '+8':
				return 'Asia/Manila';
				break;
			case '+8.5':
				return 'Asia/Pyongyang';
				break;
			case '+8.75':
				return 'Australia/Eucla';
				break;
			case '+9':
				return 'Asia/Tokyo';
				break;
			case '+9.5':
				return 'Australia/Darwin';
				break;
			case '+10':
				return 'Australia/Brisbane';
				break;
			case '+10.5':
				return 'Australia/Lord_Howe';
				break;
			case '+11':
				return 'Antarctica/Casey';
				break;
			case '+11.5':
				return 'Pacific/Auckland'; // 30 mins wrong
				break;
			case '+12':
				return 'Pacific/Wallis';
				break;
			case '+12.75':
				return 'Pacific/Chatham';
				break;
			case '+13':
				return 'Pacific/Fakaofo';
				break;
			case '+13.75':
				return 'Pacific/Chatham'; // 1 hr wrong
				break;
			case '+14':
				return 'Pacific/Kiritimati';
				break;
			default:
				return 'UTC';
				break;
		}
	}

	/**
	 * Function to get timezone string by checking wp settings
	 * @deprecated
	 * @return false|mixed|string|void
	 */
	public static function wc_timezone_string_old() {

		// if site timezone string exists, return it
		if ( $timezone = get_option( 'timezone_string' ) ) {
			return $timezone;
		}

		// get UTC offset, if it isn't set then return UTC
		if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) ) {
			return 'UTC';
		}

		// adjust UTC offset from hours to seconds
		$utc_offset *= 3600;

		// attempt to guess the timezone string from the UTC offset
		$timezone = timezone_name_from_abbr( '', $utc_offset, 0 );

		// last try, guess timezone string manually
		if ( false === $timezone ) {
			$is_dst = date( 'I' );

			foreach ( timezone_abbreviations_list() as $abbr ) {
				foreach ( $abbr as $city ) {
					if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset ) {
						return $city['timezone_id'];
					}
				}
			}

			// fallback to UTC
			return 'UTC';
		}

		return $timezone;
	}

	public static function get_total_stock( $product ) {
		$total_stock = 0;
		$child_stock = 0;

		$WCCT_Campaign = WCCT_Campaign::get_instance();
		if ( $product->get_type() == "variation" ) {
			$product = wc_get_product( $WCCT_Campaign->wcct_get_product_parent_id( $product ) );
		}

		$parent_stock = max( 0, $product->get_stock_quantity() );
		if ( sizeof( $product->get_children() ) > 0 ) {
			foreach ( $product->get_children() as $child_id ) {
				$stock_status = get_post_meta( $child_id, "_stock_status", true );
				if ( $stock_status == "instock" ) {
					if ( 'yes' === get_post_meta( $child_id, '_manage_stock', true ) ) {
						$stock       = get_post_meta( $child_id, '_stock', true );
						$total_stock += max( 0, wc_stock_amount( $stock ) );
					} else {
						$child_stock ++;
					}
				}
			}
			if ( $child_stock > 0 ) {
				$total_stock += $parent_stock;
			}
		} else {
			$total_stock = $parent_stock;
		}

		return wc_stock_amount( $total_stock );
	}

	public static function get_sale_compatible_league_product_types() {
		return array(
			'simple',
			'subscription',
			'variation',
			'external',
			'bundle',
			'subscription_variation',
			'course',
		);
	}

	public static function get_simple_league_product_types() {
		return array(
			'simple',
			'subscription',
			'course',
		);
	}

	public static function get_variable_league_product_types() {
		return array(
			'variable',
			'variable-subscription',
		);
	}

	public static function get_loop_count( $start_date_timestamp, $todayDate, $total_gap ) {
		$incre = 0;
		if ( $total_gap > 0 ) {
			$incre = ( ( $todayDate - $start_date_timestamp ) / ( $total_gap * 3600 ) );
			$incre = ceil( $incre ) + 1;
		}

		return (int) $incre;
	}

	public static function array_recursive( $aArray1, $aArray2 ) {
		$aReturn = array();

		if ( $aArray1 && count( $aArray1 ) > 0 ) {
			foreach ( $aArray1 as $mKey => $mValue ) {
				if ( array_key_exists( $mKey, $aArray2 ) ) {
					if ( is_array( $mValue ) ) {
						$aRecursiveDiff = self::array_recursive( $mValue, $aArray2[ $mKey ] );
						if ( count( $aRecursiveDiff ) ) {
							$aReturn[ $mKey ] = $aRecursiveDiff;
						}
					} else {
						if ( $mValue != $aArray2[ $mKey ] ) {
							$aReturn[ $mKey ] = $mValue;
						}
					}
				} else {
					$aReturn[ $mKey ] = $mValue;
				}
			}
		}

		return $aReturn;
	}

	public static function check_query_params() {

		$force_debug = filter_input( INPUT_GET, 'wcct_force_debug' );

		if ( $force_debug === "yes" ) {
			self::$is_force_debug = true;
		}
	}

	public static function wcct_valid_admin_pages() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && ( ( $screen->base == 'woocommerce_page_wc-settings' && isset( $_GET['tab'] ) && $_GET['tab'] == 'xl-countdown-timer' ) || ( $screen->base == 'post' && $screen->post_type == WCCT_Common::get_campaign_post_type_slug() ) ) ) {
			return true;
		}

		return false;
	}

	public static function wcct_quick_view_html() {

		$data        = self::get_item_data( $_POST['ID'] );
		$camp_data   = get_post( $_POST['ID'] );
		$is_disabled = false;
		if ( is_object( $camp_data ) && isset( $camp_data->post_status ) && ( WCCT_SHORT_SLUG . 'disabled' == $camp_data->post_status ) ) {
			$is_disabled = true;
		}

		$data_format = get_option( "date_format" );

		if ( isset( $data["campaign_fixed_recurring_start_date"] ) && $data["campaign_fixed_recurring_start_date"] != "" ) {
			$start_date    = $data["campaign_fixed_recurring_start_date"];
			$start_time    = $data["campaign_fixed_recurring_start_time"];
			$date1         = new Datetime( $start_date . " " . $start_time );
			$campaign_type = "";
			if ( $data["campaign_type"] == "fixed_date" ) {
				$campaign_type = __( "Fixed Date", 'finale-woocommerce-sales-countdown-timer-discount' );
			}
			$output = "";


			if ( ! empty( $campaign_type ) ) {
				$output .= '' . __( 'Type', 'finale-woocommerce-sales-countdown-timer-discount' ) . ': ' . $campaign_type . '<br/>';
			}
			$starts = sprintf( "%s %s<br/>", $date1->format( $data_format ), $start_time );
			$output .= $starts;
			if ( $data["campaign_type"] == "fixed_date" ) {
				$end_date      = $data["campaign_fixed_end_date"];
				$end_time      = $data["campaign_fixed_end_time"];
				$date2         = new Datetime( $end_date . " " . $end_time );
				$interval      = $date2->diff( $date1 );
				$days          = $interval->format( "%a" );
				$hrs           = $interval->format( "%H" );
				$min           = $interval->format( "%I" );
				$duration_only = sprintf( "%s %s %s", ( $days > '1' ) ? $days . ' days' : $days . ' day', ( $hrs > '1' ) ? $hrs . ' hrs' : $hrs . ' hr', ( $min > '1' ) ? $min . ' mins' : $min . ' min' );
				$output        .= '' . __( 'Duration', 'finale-woocommerce-sales-countdown-timer-discount' ) . ': ' . $duration_only;
			} else if ( $data["campaign_type"] == "recurring" ) {
				$durations_day = $data["campaign_recurring_duration_days"];
				$durations_hrs = $data["campaign_recurring_duration_hrs"];
				$duration_only = sprintf( "%s %s 0 min", ( $durations_day > '1' ) ? $durations_day . ' days' : $durations_day . ' day', ( $durations_hrs > '1' ) ? $durations_hrs . ' hrs' : $durations_hrs . ' hr' );

				$output .= '' . __( 'Duration', 'finale-woocommerce-sales-countdown-timer-discount' ) . ': ' . $duration_only;
			}
		}


		$timezone_format = _x( 'Y-m-d H:i:s', 'timezone date format' );

		$state = self::wcct_get_campaign_status( $_POST['ID'] );


		$ticks    = array();
		$discount = "Off";

		if ( isset( $data['deal_enable_price_discount'] ) && $data['deal_enable_price_discount'] == '1' ) {
			$discount = "On";

			array_push( $ticks, 'discount' );
		}


		$inventory = "Off";

		if ( isset( $data['deal_enable_goal'] ) && $data['deal_enable_goal'] == '1' ) {
			$inventory = "On";
			array_push( $ticks, 'inventory' );


			$inventory .= " (";
			if ( $data['deal_units'] == "custom" ) {


				$inventory .= __( "Custom Stock", 'finale-woocommerce-sales-countdown-timer-discount' );
			}
			if ( $data['deal_units'] == "same" ) {
				$inventory .= __( "Product Stock", 'finale-woocommerce-sales-countdown-timer-discount' );
			}
			$inventory .= ")";
		}

		$countdown_timer = "Off";
		if ( isset( $data['location_timer_show_single'] ) && $data['location_timer_show_single'] == '1' ) {
			$countdown_timer = "On";
			array_push( $ticks, 'countdown_timer' );
		}

		$counter_bar = "Off";
		if ( isset( $data['location_bar_show_single'] ) && $data['location_bar_show_single'] == '1' ) {
			$counter_bar = "On";
			array_push( $ticks, 'counter_bar' );
		}

		if ( $state == "Paused" ) {
			$icon_class_state = "s-p";
		}elseif ( $state == "Scheduled" ) {
			$icon_class_state = "s-s";
		}elseif ( $state == "Running" ) {
			$icon_class_state = "s-r";
		}elseif( $state == "Finished" ) {
			$icon_class_state = "s-f";
		}else{
			$icon_class_state = '';
        }

		// changing status if campaign disabled
		if ( true === $is_disabled ) {
			$state            = 'Deactivated';
			$icon_class_state = 's-f';
		}
		?>
        <ul class="wcct_quick_view">
        <li><i class="flicon flicon-clock-circular-outline"></i>Campaign Type: <u><?php echo $campaign_type; ?></u></li>
        <li><i class="flicon flicon-weekly-calendar <?php echo $icon_class_state ?>"></i>Campaign State :
            <u><?php echo $state; ?></u></li>
        <li>
            <i class="flicon <?php echo ( in_array( 'discount', $ticks ) ) ? 'flicon-checkmark-for-verification' : 'flicon-cross-remove-sign'; ?>"></i>Discount
            : <?php echo $discount; ?></li>
        <li>
            <i class="flicon <?php echo ( in_array( 'inventory', $ticks ) ) ? 'flicon-checkmark-for-verification' : 'flicon-cross-remove-sign'; ?>"></i>Inventory
            : <?php echo $inventory; ?></li>
        <li>
            <i class="flicon <?php echo ( in_array( 'countdown_timer', $ticks ) ) ? 'flicon-checkmark-for-verification' : 'flicon-cross-remove-sign'; ?>"></i>Countdown
            Timer: <?php echo $countdown_timer; ?></li>
        <li>
            <i class="flicon <?php echo ( in_array( 'counter_bar', $ticks ) ) ? 'flicon-checkmark-for-verification' : 'flicon-cross-remove-sign'; ?>"></i>Counter
            Bar : <?php echo $counter_bar; ?></li>
		<?php
		exit;
	}

	public static function get_item_data( $item_id ) {
		global $wpdb;

		$xl_cache_obj     = XL_Cache::get_instance();
		$xl_transient_obj = XL_Transient::get_instance();

		$meta_query = apply_filters( 'wcct_product_meta_query', $wpdb->prepare( "SELECT meta_key,meta_value  FROM $wpdb->postmeta WHERE post_id = %d AND meta_key LIKE %s", $item_id, "%_wcct_%" ) );
		$cache_key  = "wcct_countdown_meta_" . $item_id;

		/**
		 * Setting xl cache and transient for Finale single campaign meta
		 */
		$cache_data = $xl_cache_obj->get_cache( $cache_key, 'finale' );
		if ( false !== $cache_data ) {
			$parseObj = $cache_data;
		} else {
			$transient_data = $xl_transient_obj->get_transient( $cache_key, 'finale' );

			if ( false !== $transient_data ) {
				$parseObj = $transient_data;
			} else {
				$product_meta                  = $wpdb->get_results( $meta_query, ARRAY_A );
				$product_meta                  = self::get_parsed_query_results_meta( $product_meta );
				$get_product_wcct_meta_default = self::parse_default_args_by_trigger( $product_meta );
				$parseObj                      = wp_parse_args( $product_meta, $get_product_wcct_meta_default );
				$xl_transient_obj->set_transient( $cache_key, $parseObj, 7200, 'finale' );
			}
			$xl_cache_obj->set_cache( $cache_key, $parseObj, 'finale' );
		}

		$fields = array();
		if ( $parseObj && is_array( $parseObj ) && count( $parseObj ) > 0 ) {
			foreach ( $parseObj as $key => $val ) {
				$newKey = $key;
				if ( strpos( $key, '_wcct_' ) !== false ) {
					$newKey = str_replace( '_wcct_', "", $key );
				}
				$fields[ $newKey ] = $val;
			}
		}

		return $fields;
	}

	public static function get_parsed_query_results_meta( $results ) {
		$parsed_results = array();

		if ( is_array( $results ) && count( $results ) > 0 ) {
			foreach ( $results as $key => $result ) {
				if ( is_array( $result ) && isset( $result['meta_key'] ) ) {
					$parsed_results[ $result['meta_key'] ] = $result['meta_value'];
				} else {
					$parsed_results[ $key ] = $result;
				}
			}
		}

		return $parsed_results;
	}

	public static function parse_default_args_by_trigger( $data ) {
		$field_option_data = self::get_default_settings();
		foreach ( $field_option_data as $slug => $value ) {
			if ( strpos( $slug, '_wcct_' ) !== false ) {
				$data[ $slug ] = $value;
			}
		}

		return $data;
	}

	public static function get_default_settings() {
		self::$default = array(
			'_wcct_location_timer_show_grid'                => '0',
			'_wcct_location_timer_show_cart'                => '0',
			'_wcct_location_bar_show_grid'                  => '0',
			'_wcct_campaign_type'                           => "fixed_date",
			'_wcct_campaign_fixed_recurring_start_date'     => date( 'Y-m-d' ),
			'_wcct_campaign_fixed_recurring_start_time'     => '12:00 AM',
			'_wcct_campaign_fixed_end_date'                 => date( 'Y-m-d', strtotime( "+5 days", time() ) ),
			'_wcct_campaign_fixed_end_time'                 => '12:00 AM',
			'_wcct_deal_enable_price_discount'              => '0',
			'_wcct_deal_amount'                             => '5',
			'_wcct_deal_type'                               => 'percentage',
			'_wcct_deal_enable_goal'                        => '0',
			'_wcct_deal_units'                              => 'custom',
			'_wcct_deal_custom_units'                       => '8',
			'_wcct_deal_threshold_units'                    => '0',
			'_wcct_deal_end_campaign'                       => 'no',
			'_wcct_deal_inventory_goal_for'                 => 'recurrence',
			'_wcct_deal_custom_units_allow_backorder'       => "no",
			'_wcct_location_timer_show_single'              => '0',
			'_wcct_location_timer_single_location'          => '4',
			'_wcct_appearance_timer_single_skin'            => 'round_fill',
			'_wcct_appearance_timer_single_bg_color'        => '#444444',
			'_wcct_appearance_timer_single_text_color'      => '#ffffff',
			'_wcct_appearance_timer_single_font_size_timer' => '22',
			'_wcct_appearance_timer_single_font_size'       => '13',
			'_wcct_appearance_timer_single_label_days'      => 'days',
			'_wcct_appearance_timer_single_label_hrs'       => 'hrs',
			'_wcct_appearance_timer_single_label_mins'      => 'mins',
			'_wcct_appearance_timer_single_label_secs'      => 'secs',
			'_wcct_appearance_timer_single_display'         => "{{countdown_timer}}\nPrices go up when the timer hits zero",
			'_wcct_appearance_timer_single_border_style'    => 'none',
			'_wcct_appearance_timer_single_border_width'    => '1',
			'_wcct_appearance_timer_single_border_color'    => '#444444',
			'_wcct_appearance_timer_mobile_reduction'       => '90',
			'_wcct_location_bar_show_single'                => '0',
			'_wcct_location_bar_single_location'            => '4',
			'_wcct_appearance_bar_single_skin'              => 'stripe',
			'_wcct_appearance_bar_single_edges'             => 'rounded',
			'_wcct_appearance_bar_single_orientation'       => 'rtl',
			'_wcct_appearance_bar_single_bg_color'          => '#dddddd',
			'_wcct_appearance_bar_single_active_color'      => '#ee303c',
			'_wcct_appearance_bar_single_height'            => '16',
			'_wcct_appearance_bar_single_display'           => "{{counter_bar}} {{sold_units}} units sold out of {{total_units}}",
			'_wcct_appearance_bar_single_border_style'      => 'none',
			'_wcct_appearance_bar_single_border_width'      => '0',
			'_wcct_appearance_bar_single_border_color'      => '#444444',
		);


		return self::$default;
	}

	public static function wcct_get_campaign_status( $item_id ) {
		$output = "";

		$data = self::get_item_data( $item_id );

		$timings = WCCT_Common::start_end_timestamp( $data );
		extract( $timings );
		$slug_timing = "deactivated";
		if ( $end_date_timestamp > 0 ) {
			if ( $todayDate >= $start_date_timestamp && $todayDate < $end_date_timestamp ) {
				$output      = __( 'Running', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "running";
			} elseif ( $first_occur && $todayDate <= $rec_intial_end_time ) {
				$output      = __( 'Paused', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "paused";
			} else if ( $todayDate > $end_date_timestamp ) {
				$output      = __( 'Finished', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "finished";
			} else if ( $start_date_timestamp > $todayDate ) {
				$output      = __( 'Scheduled', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "schedule";
			}
		}

		return $output;
	}

	public static function start_end_timestamp( $data ) {
		$start_date_timestamp = $end_date_timestamp = 0;
		$todayDate            = time();
		$first_occur          = false;
		$rec_intial_end_time  = 0;

		if ( isset( $data["campaign_fixed_recurring_start_date"] ) && $data["campaign_fixed_recurring_start_date"] != "" ) {
			$is_scheduled = false;
			$start_date   = $data["campaign_fixed_recurring_start_date"];
			$start_time   = $data["campaign_fixed_recurring_start_time"];

			$start_date_timestamp = self::wcct_get_timestamp_wc_native( $start_date . " " . $start_time );
			$is_paused            = false;
			$first_occur          = false;
			$rec_intial_end_time  = 0;


			if ( $data["campaign_type"] == "fixed_date" ) {
				$end_date = $data["campaign_fixed_end_date"];
				$end_time = $data["campaign_fixed_end_time"];

				$end_date_timestamp = self::wcct_get_timestamp_wc_native( $end_date . " " . $end_time );
			}
		}

		return array(
			"todayDate"            => (int) $todayDate,
			"start_date_timestamp" => (int) $start_date_timestamp,
			"end_date_timestamp"   => (int) $end_date_timestamp,
			"first_occur"          => $first_occur,
			"rec_intial_end_time"  => $rec_intial_end_time
		);
	}

	public static function wcct_get_timestamp_wc_native( $dt ) {
		$timezone      = self::wc_timezone_string();
		$date          = new DateTime( $dt, new DateTimeZone( $timezone ) );
		$ret_timestamp = $date->getTimestamp();

		return $ret_timestamp;
	}

	/**
	 * Hooked in `wp`
	 * Prepares & Registers header info blocks to show in admin bar
	 * Process all the data we fetched for a single product and extract info to show to admin.
	 * @since 1.1
	 */
	public static function init_header_logs() {

		if ( is_admin() ) {
			return;
		}


		if ( ! self::$info_generated && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && is_object( self::$wcct_post ) && self::$wcct_post->post_type == "product" ) {
			wcct_force_log( "Initializing header info function  Product : " . self::$wcct_post->ID );
			$getdata = WCCT_Core()->public->get_single_campaign_pro_data( self::$wcct_post->ID );


			WCCT_Core()->appearance->add_header_info( sprintf( __( 'Product #%d %s', 'finale-woocommerce-sales-countdown-timer-discount' ), self::$wcct_post->ID, self::$wcct_post->post_title ) );


			if ( isset( $getdata['running'] ) && ! empty( $getdata['running'] ) ) {

				$timers = array();
				foreach ( $getdata['running'] as $key => $camp ) {
					array_push( $timers, sprintf( '<a href="%s" target="_blank" title="%s">%s</a>', get_edit_post_link( $camp ), get_the_title( $camp ), $camp ) );
				}
				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Running Campaigns:  %s', 'finale-woocommerce-sales-countdown-timer-discount' ), implode( ',', $timers ) ) );
			} else {
				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Running Campaigns:  None', 'finale-woocommerce-sales-countdown-timer-discount' ) ) );
			}

			if ( isset( $getdata['expired'] ) && ! empty( $getdata['expired'] ) ) {

				$timers = array();
				foreach ( $getdata['expired'] as $key => $camp ) {
					array_push( $timers, sprintf( '<a href="%s" target="_blank" title="%s">%s</a>', get_edit_post_link( $camp ), get_the_title( $camp ), $camp ) );
				}
				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Non-running Campaigns:  %s', 'finale-woocommerce-sales-countdown-timer-discount' ), implode( ',', $timers ) ) );
			} else {
				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Non-running Campaigns:  None', 'finale-woocommerce-sales-countdown-timer-discount' ) ) );
			}

			if ( isset( $getdata['deals'] ) && ! empty( $getdata['deals'] ) ) {

				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Discounts: Yes (%s)', 'finale-woocommerce-sales-countdown-timer-discount' ), sprintf( '<a href="%s" title="%s">%s</a>', get_edit_post_link( $getdata['deals']['campaign_id'] ), get_the_title( $getdata['deals']['campaign_id'] ), $getdata['deals']['campaign_id'] ) ) );
			} else {
				WCCT_Core()->appearance->add_header_info( __( 'Discounts: No', 'finale-woocommerce-sales-countdown-timer-discount' ) );
			}


			if ( isset( $getdata['goals'] ) && ! empty( $getdata['goals'] ) ) {

				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Inventory: Yes (%s)', 'finale-woocommerce-sales-countdown-timer-discount' ), sprintf( '<a href="%s" title="%s">%s</a>', get_edit_post_link( $getdata['goals']['campaign_id'] ), get_the_title( $getdata['goals']['campaign_id'] ), $getdata['goals']['campaign_id'] ) ) );
			} else {
				WCCT_Core()->appearance->add_header_info( __( 'Inventory: No', 'finale-woocommerce-sales-countdown-timer-discount' ) );
			}


			if ( isset( $getdata['single_timer'] ) && ! empty( $getdata['single_timer'] ) ) {

				$timers = array();
				foreach ( $getdata['single_timer'] as $key => $timer ) {
					array_push( $timers, sprintf( '<a href="%s" target="_blank" title="%s">%s</a>', get_edit_post_link( $key ), get_the_title( $key ), $key ) );
				}

				WCCT_Core()->appearance->add_header_info( sprintf( __( 'CountDown Timer: Yes (%s)', 'finale-woocommerce-sales-countdown-timer-discount' ), implode( ',', $timers ) ) );
			} else {
				WCCT_Core()->appearance->add_header_info( __( 'CountDown Timer: No', 'finale-woocommerce-sales-countdown-timer-discount' ) );
			}

			if ( isset( $getdata['single_bar'] ) && ! empty( $getdata['single_bar'] ) && isset( $getdata['goals'] ) && ! empty( $getdata['goals'] ) ) {


				$timers = array();
				foreach ( $getdata['single_bar'] as $key => $timer ) {

					if ( $key !== $getdata['goals']['campaign_id'] ) {
						continue;
					}
					array_push( $timers, sprintf( '<a href="%s" target="_blank" title="%s">%s</a>', get_edit_post_link( $key ), get_the_title( $key ), $key ) );
				}
				WCCT_Core()->appearance->add_header_info( sprintf( __( 'Counter Bar: Yes (%s)', 'finale-woocommerce-sales-countdown-timer-discount' ), implode( ',', $timers ) ) );
			} else {
				WCCT_Core()->appearance->add_header_info( __( 'Counter Bar: No', 'finale-woocommerce-sales-countdown-timer-discount' ) );
			}


			self::$info_generated = true;
		}
	}

	public static function toolbar_link_to_xlplugins( $wp_admin_bar ) {

		if ( is_admin() ) {
			return;
		}


		$upload_dir = wp_upload_dir();

		$base_url = $upload_dir['baseurl'] . '/' . 'finale-woocommerce-sales-countdown-timer-discount';

		$args = array(
			'id'    => 'wcct_admin_page_node',
			'title' => 'XL Finale',
			'href'  => admin_url( 'admin.php?page=wc-settings&tab=' . WCCT_Common::get_wc_settings_tab_slug() ),
			'meta'  => array( 'class' => 'wcct_admin_page_node' )
		);
		$wp_admin_bar->add_node( $args );


		if ( is_singular( 'product' ) ) {
			$args = array(
				'id'     => 'wcct_admin_page_node_1',
				'title'  => 'See Log',
				'href'   => $base_url . "/force.txt",
				'parent' => 'wcct_admin_page_node',
			);


			$wp_admin_bar->add_node( $args );
		}
	}

	public static function add_license_info( $localized_data ) {


		$localized_data['l'] = "NA";

		return $localized_data;
	}

	public static function process_reset_state( $id ) {
		self::wcct_set_campaign_status( $id );
	}

	public static function wcct_set_campaign_status( $item_id ) {
		$output = "";

		$data = WCCT_Common::get_item_data( $item_id );

		$timings = WCCT_Common::start_end_timestamp( $data );
		extract( $timings );
		$slug_timing = "deactivated";
		if ( $end_date_timestamp > 0 ) {
			if ( $todayDate >= $start_date_timestamp && $todayDate < $end_date_timestamp ) {
				$output      = __( 'Running', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "running";
			} elseif ( $first_occur && $todayDate <= $rec_intial_end_time ) {
				$output      = __( 'Paused', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "paused";
			} else if ( $todayDate > $end_date_timestamp ) {
				$output      = __( 'Finished', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "finished";
			} else if ( $start_date_timestamp > $todayDate ) {
				$output      = __( 'Scheduled', 'finale-woocommerce-sales-countdown-timer-discount' );
				$slug_timing = "schedule";
			}
			update_post_meta( $item_id, "_wcct_current_status_timing", $slug_timing );
		}

		return $output;
	}

	public static function reset_timer_time() {


		if ( filter_input( INPUT_POST, 'endDate' ) === null ) {
			wp_send_json( array() );
		}
		/**
		 * Comparing end timestamp with the current timestamp
		 * and getting difference
		 */
		$date_obj            = new DateTime();
		$current_Date_object = clone $date_obj;
		$date_obj->setTimestamp( $_POST['endDate'] );

		$interval = $current_Date_object->diff( $date_obj );
		$x        = $interval->format( '%R' );

		$is_left = $x;
		if ( $is_left == "+" ) {
			$total_seconds_left = 0;
			$total_seconds_left = $total_seconds_left + ( YEAR_IN_SECONDS * $interval->y );
			$total_seconds_left = $total_seconds_left + ( MONTH_IN_SECONDS * $interval->m );
			$total_seconds_left = $total_seconds_left + ( DAY_IN_SECONDS * $interval->d );
			$total_seconds_left = $total_seconds_left + ( HOUR_IN_SECONDS * $interval->h );
			$total_seconds_left = $total_seconds_left + ( MINUTE_IN_SECONDS * $interval->i );
			$total_seconds_left = $total_seconds_left + $interval->s;
		} else {
			$total_seconds_left = 0;
		}


		//wrap this code in schedule hook to get compatible with wp-rocket

		/** $referer = wp_get_referer();
		 *
		 * if ( 0 !== strpos( $referer, 'http' ) ) {
		 * list( $host, $path, $scheme, $query ) = get_rocket_parse_url( untrailingslashit( home_url() ) );
		 * $referer = $scheme . '://' . $host . $referer;
		 * }
		 *
		 * if ( home_url( '/' ) === $referer ) {
		 * rocket_clean_home();
		 * } else {
		 * rocket_clean_files( $referer );
		 * } **/
		wp_send_json( array( 'diff' => $total_seconds_left, 'id' => filter_input( INPUT_POST, 'campID' ) ) );

	}


	/**
	 * Reversing Finale inventory when order status: pending, failed or cancelled
	 *
	 * @param WC_Order $order_id
	 */
	public static function wcct_goaldeal_sold_backup_callback( $order_id ) {
		if ( empty( $order_id ) ) {
			return;
		}

		$order        = wc_get_order( $order_id );
		$order_status = $order->get_status();

		if ( in_array( $order_status, apply_filters( 'wcct_update_finale_inventory_order_status', array( 'pending', 'cancelled', 'failed' ) ) ) ) {
			$order_backup_data = get_post_meta( $order_id, '_wcct_goaldeal_sold_backup', true );
			if ( is_array( $order_backup_data ) && count( $order_backup_data ) > 0 ) {
				foreach ( $order_backup_data as $product_id => $product_data ) {
					if ( is_array( $product_data ) && count( $product_data ) > 0 ) {
						foreach ( $product_data as $meta_key => $value ) {
							$current = get_post_meta( (int) $product_id, $meta_key, true );
							$mod     = (int) $current - (int) $value;
							if ( 0 === $mod ) {
								delete_post_meta( (int) $product_id, $meta_key );
							} else {
								update_post_meta( (int) $product_id, $meta_key, $mod );
								wcct_force_log( "backup: key => {
			$meta_key} , product id => {
			$product_id} and updated value " . $mod, "force1.txt" );
							}
							unset( $current );
							unset( $mod );
						}
					}
				}
			}
			delete_post_meta( $order_id, '_wcct_goaldeal_sold_backup' );
		}

		return;
	}

}
    