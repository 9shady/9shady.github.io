<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WCCT_Post_Table extends WP_List_Table {

	public $per_page = 40;
	public $data;
	public $meta_data;

	/**
	 * Constructor.
	 * @since  1.0.0
	 */
	public function __construct( $args = array() ) {
		global $status, $page;
		parent::__construct( array(
			'singular' => 'campaign', //singular name of the listed records
			'plural'   => 'campaigns', //plural name of the listed records
			'ajax'     => false        //does this table support ajax?
		) );
		$status     = 'all';
		$page       = $this->get_pagenum();
		$this->data = array();
		// Make sure this file is loaded, so we have access to plugins_api(), etc.
		require_once( ABSPATH . '/wp-admin/includes/plugin-install.php' );
		parent::__construct( $args );
	}

	/**
	 * Text to display if no items are present.
	 * @since  1.0.0
	 * @return  void
	 */
	public function no_items() {
		echo wpautop( __( 'No Campaign Available', 'finale-woocommerce-sales-countdown-timer-discount' ) );
	}

	/**
	 * The content of each column.
	 *
	 * @param  array $item The current item in the list.
	 * @param  string $column_name The key of the current column.
	 *
	 * @since  1.0.0
	 * @return string              Output for the current column.
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'check-column':
				return '&nbsp;';
			case 'status':
				return $item[ $column_name ];
				break;
		}
	}

	public function get_item_data( $item_id ) {
		global $wpdb;
		$data = array();

		if ( isset( $this->meta_data[ $item_id ] ) ) {
			$data = $this->meta_data[ $item_id ];
		} else {
			$this->meta_data[ $item_id ] = WCCT_Common::get_item_data( $item_id );
			$data                        = $this->meta_data[ $item_id ];
		}

		return $data;
	}

	public function column_campaign( $item ) {
		$output      = "";
		$data        = $this->get_item_data( (int) $item["id"] );
		$data_format = get_option( "date_format" ) . ' ' . get_option( "time_format" );
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
				$output .= __( sprintf( "<strong>Type</strong>: %s<br/>", $campaign_type ), 'finale-woocommerce-sales-countdown-timer-discount' );
			}
			$output .= __( sprintf( "<strong>Starts On</strong>: %s<br/>", $date1->format( $data_format ) ), 'finale-woocommerce-sales-countdown-timer-discount' );
			if ( $data["campaign_type"] == "fixed_date" ) {
				$end_date = $data["campaign_fixed_end_date"];
				$end_time = $data["campaign_fixed_end_time"];
				$date2    = new Datetime( $end_date . " " . $end_time );
				$output   .= '<strong>' . __( 'Expires On', 'finale-woocommerce-sales-countdown-timer-discount' ) . '</strong>: ' . sprintf( "%s<br/>", $date2->format( $data_format ) );
			}
		}

		return wpautop( $output );
	}

	public function column_deals( $item ) {
		$data   = $this->get_item_data( (int) $item["id"] );
		$output = "";
		if ( isset( $data["deal_enable_price_discount"] ) && $data["deal_enable_price_discount"] == "1" ) {
			$deal_amount      = (float) isset( $data["deal_amount"] ) ? $data["deal_amount"] : 0;
			$deal_amount_text = "";
			if ( $data["deal_type"] == "percentage" ) {
				$deal_amount_text = "{$deal_amount}%";
			} else {
				$currencySymbol   = get_woocommerce_currency_symbol();
				$deal_amount_text = "{$deal_amount}{$currencySymbol}";
			}
			$output .= __( sprintf( "<strong>Discount</strong>: %s<br/>", $deal_amount_text ), 'finale-woocommerce-sales-countdown-timer-discount' );
		}

		if ( isset( $data["deal_enable_goal"] ) && $data["deal_enable_goal"] == "1" ) {
			$deal_amount     = (float) $data["deal_amount"];
			$deal_stock_text = "";
			if ( $data["deal_units"] == "same" ) {
				$deal_stock_text = __( "Product Stock", 'finale-woocommerce-sales-countdown-timer-discount' );
			} else {
				$deal_stock_text = __( "Custom Stock" );
				if ( $data["deal_custom_units"] != "" ) {
					$goal_amt        = $data["deal_custom_units"];
					$deal_stock_text .= " ({$goal_amt})";
				}
			}
			$output .= __( sprintf( "<strong>Inventory</strong>: %s<br/>", $deal_stock_text ), 'finale-woocommerce-sales-countdown-timer-discount' );
		}

		return wpautop( $output );
	}

	public function column_appearance( $item ) {
		$data = $this->get_item_data( (int) $item["id"] );

		$output = array();
		if ( $data["location_timer_show_single"] == "1" ) {
			$output[] = __( sprintf( "Countdown Timer" ), 'finale-woocommerce-sales-countdown-timer-discount' );
		}
		if ( $data["location_bar_show_single"] == "1" ) {
			$output[] = __( sprintf( "Counter Bar" ), 'finale-woocommerce-sales-countdown-timer-discount' );
		}

		return wpautop( implode( "<br/>", $output ) );
	}

	/**
	 * Content for the "product_name" column.
	 *
	 * @param  array $item The current item.
	 *
	 * @since  1.0.0
	 * @return string       The content of this column.
	 */
	public function column_status( $item ) {
		$output = "";
		if ( $item['trigger_status'] == WCCT_SHORT_SLUG . 'disabled' ) {
			$output = __( 'Deactivated', 'finale-woocommerce-sales-countdown-timer-discount' );
		} else {
			$output = WCCT_Common::wcct_set_campaign_status( $item["id"] );
		}

		return wpautop( $output );
	}

	public function column_priority( $item ) {
		$data = $this->get_item_data( (int) $item["id"] );
		if ( isset( $data['campaign_menu_order'] ) ) {
			return $data['campaign_menu_order'];
		} else {
			update_post_meta( (int) $item["id"], '_wcct_campaign_menu_order', 0 );

			return 0;
		}

		return;
	}

	public function column_name( $item ) {
		$edit_link     = get_edit_post_link( $item['id'] );
		$column_string = '<strong>';
		if ( $item['trigger_status'] == "trash" ) {
			$column_string .= '' . _draft_or_post_title( $item['id'] ) . '' . _post_states( get_post( $item['id'] ) ) . '</strong>';
		} else {
			$column_string .= '<a href="' . $edit_link . '" class="row-title">' . _draft_or_post_title( $item['id'] ) . '</a>' . _post_states( get_post( $item['id'] ) ) . '</strong>';
		}
		$column_string .= '<div class=\'row-actions\'>';

		$column_string .= '<span class="">ID: ' . $item['id'] . '';
		$column_string .= "</span> | ";
		$count         = count( $item['row_actions'] );
		foreach ( $item['row_actions'] as $k => $action ) {
			$column_string .= '<span class="' . $action['action'] . '"><a href="' . $action['link'] . '" ' . $action['attrs'] . '>' . $action['text'] . '</a>';
			if ( $k < $count - 1 ) {
				$column_string .= " | ";
			}
			$column_string .= "</span>";
		}

		return wpautop( $column_string );
	}

	/**
	 * Retrieve an array of possible bulk actions.
	 * @since  1.0.0
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array();

		return $actions;
	}

	/**
	 * Prepare an array of items to be listed.
	 * @since  1.0.0
	 * @return array Prepared items.
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$total_items = count( $this->data );

		$this->set_pagination_args( array(
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $total_items //WE have to determine how many items to show on a page
		) );
		$this->items = $this->data;
	}

	/**
	 * Retrieve an array of columns for the list table.
	 * @since  1.0.0
	 * @return array Key => Value pairs.
	 */
	public function get_columns() {
		$columns = array(
			'check-column' => __( '&nbsp;', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'name'         => __( 'Title', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'campaign'     => __( 'Campaign', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'deals'        => __( 'Deal', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'appearance'   => __( 'Appearance', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'status'       => __( 'Status', 'finale-woocommerce-sales-countdown-timer-discount' ),
			'priority'     => __( 'Priority', 'finale-woocommerce-sales-countdown-timer-discount' ),
		);

		return $columns;
	}

	/**
	 * Retrieve an array of sortable columns.
	 * @since  1.0.0
	 * @return array
	 */
	public function get_sortable_columns() {
//        return array("Running","Finished","Schedule","Deactivated");
		return array(
			'running'     => array( 'Running', true ),
			'finished'    => array( 'Finished', true ),
			'schedule'    => array( 'Schedule', true ),
			'deactivated' => array( 'Deactivated', true ),
		);
	}

	public function get_table_classes() {
		$get_default_classes = parent::get_table_classes();
		array_push( $get_default_classes, 'wcct-instance-table' );

		return $get_default_classes;
	}

	public function single_row( $item ) {
		$tr_class = 'wcct_trigger_active';
		if ( $item['trigger_status'] == WCCT_SHORT_SLUG . 'disabled' ) {
			$tr_class = 'wcct_trigger_deactive';
		}
		echo '<tr class="' . $tr_class . '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	/**
	 * Print column headers, accounting for hidden and sortable columns.
	 *
	 * @since 3.1.0
	 * @access public
	 *
	 * @staticvar int $cb_counter
	 *
	 * @param bool $with_id Whether to set the id attribute or not
	 */
	public function print_column_headerssssssss( $with_id = true ) {
		echo "hdsfkjdbskgjjfdlkgjlk";
		list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();


		$sortable['status'] = array( 'status', 0 );
		$current_url        = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$current_url        = remove_query_arg( 'paged', $current_url );

		if ( isset( $_GET['orderby'] ) ) {
			$current_orderby = $_GET['orderby'];
		} else {
			$current_orderby = '';
		}

		if ( isset( $_GET['order'] ) && 'desc' === $_GET['order'] ) {
			$current_order = 'desc';
		} else {
			$current_order = 'asc';
		}

		if ( ! empty( $columns['cb'] ) ) {
			static $cb_counter = 1;
			$columns['cb'] = '<label class="screen-reader-text" for="cb-select-all-' . $cb_counter . '">' . __( 'Select All' ) . '</label>' . '<input id="cb-select-all-' . $cb_counter . '" type="checkbox" />';
			$cb_counter ++;
		}

		foreach ( $columns as $column_key => $column_display_name ) {
			$class = array( 'manage-column', "column-$column_key" );

			if ( in_array( $column_key, $hidden ) ) {
				$class[] = 'hidden';
			}

			if ( 'cb' === $column_key ) {
				$class[] = 'check-column';
			} elseif ( in_array( $column_key, array( 'posts', 'comments', 'links' ) ) ) {
				$class[] = 'num';
			}

			if ( $column_key === $primary ) {
				$class[] = 'column-primary';
			}

			if ( isset( $sortable[ $column_key ] ) ) {
				list( $orderby, $desc_first ) = $sortable[ $column_key ];

				if ( $current_orderby === $orderby ) {
					$order   = 'asc' === $current_order ? 'desc' : 'asc';
					$class[] = 'sorted';
					$class[] = $current_order;
				} else {
					$order   = $desc_first ? 'desc' : 'asc';
					$class[] = 'sortable';
					$class[] = $desc_first ? 'asc' : 'desc';
				}

				$column_display_name = '<a href="' . esc_url( add_query_arg( compact( 'orderby', 'order' ), $current_url ) ) . '"><span>' . $column_display_name . '</span><span class="sorting-indicator"></span></a>';
			}

			$tag   = ( 'cb' === $column_key ) ? 'td' : 'th';
			$scope = ( 'th' === $tag ) ? 'scope="col"' : '';
			$id    = $with_id ? "id='$column_key'" : '';

			if ( ! empty( $class ) ) {
				$class = "class='" . join( ' ', $class ) . "'";
			}

			echo "<$tag $scope $id $class>$column_display_name</$tag>";
		}
	}

}
