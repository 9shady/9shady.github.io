<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/**
 * Class WCCT_Appearance
 * @package Finale-Lite
 * @author XlPlugins
 */
class WCCT_Appearance {

	public static $_instance = null;
	public $header_info = array();

	public function __construct() {

		$this->wcct_url = untrailingslashit( plugin_dir_url( WCCT_PLUGIN_FILE ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wcct_wp_enqueue_scripts' ) );

		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_above_title' ), 2.3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_below_title' ), 9.3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_below_review' ), 11.3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_below_price' ), 17.3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_below_short_desc' ), 21.3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_below_add_cart' ), 39.3 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'wcct_position_below_meta' ), 41.3 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'wcct_position_above_tab_area' ), 9.9 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'wcct_position_below_related_products' ), 21.3 );

		add_filter( 'woocommerce_cart_item_name', array( $this, 'wcct_show_on_cart' ), 10, 3 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'wcct_bar_timer_show_on_grid' ), 9 );

		add_action( 'wp_footer', array( $this, 'wcct_render_inline_style' ) );

		add_filter( 'wcct_localize_js_data', array( $this, 'add_info_localized' ) );
		add_action( 'wp_footer', array( $this, 'wcct_print_html_header_info' ), 50 );

		add_action( 'wp_footer', array( $this, 'maybe_add_info_footer' ) );

		/* wcct_the_content is the replacement of the_content */
		add_filter( 'wcct_the_content', 'wptexturize' );
		add_filter( 'wcct_the_content', 'convert_smilies', 20 );
		add_filter( 'wcct_the_content', 'wpautop' );
		add_filter( 'wcct_the_content', 'shortcode_unautop' );
		add_filter( 'wcct_the_content', 'prepend_attachment' );
		add_filter( 'wcct_the_content', 'wp_make_content_images_responsive' );
		add_filter( 'wcct_the_content', 'do_shortcode', 11 );
	}


	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	public function wcct_wp_enqueue_scripts() {

		$upload_dir = wp_upload_dir();

		$base_url = $upload_dir['baseurl'] . '/' . 'finale-woocommerce-sales-countdown-timer-discount';

		$min = '.min';
		if ( true === SCRIPT_DEBUG ) {
			$min = '';
		}
		wp_enqueue_style( 'wcct_public_css', $this->wcct_url . '/assets/css/wcct_combined' . $min . '.css', array(), WCCT_VERSION );
		wp_enqueue_script( 'wcct_public_js', $this->wcct_url . '/assets/js/wcct_combined.min.js', array( 'jquery' ), WCCT_VERSION, true );

		// store currency
		$wcct_currency                   = get_woocommerce_currency_symbol();
		$localize_arr['wcct_version']    = WCCT_VERSION;
		$localize_arr['currency']        = $wcct_currency;
		$localize_arr['admin_ajax']      = admin_url( 'admin-ajax.php' );
		$localize_arr['log_file']        = $base_url . '/force.txt';
		$localize_arr['refresh_timings'] = 'yes';
		wp_localize_script( 'wcct_public_js', 'wcct_data', apply_filters( 'wcct_localize_js_data', $localize_arr ) );
	}

	/**
	 * Get sticky bar button classes
	 *
	 * @param type $value
	 *
	 * @return string
	 */
	public function wcct_button_skin_class( $value ) {
		switch ( $value ) {
			case 'button_2':
				return 'wcct_rounded_button';
				break;
			case 'button_3':
				return 'wcct_ghost_button';
				break;
			case 'button_4':
				return 'wcct_shadow_button';
				break;
			case 'button_5':
				return 'wcct_default_style_2';
				break;
			case 'button_6':
				return 'wcct_arrow_button';
				break;
			default:
				return 'wcct_default_style';
				break;
		}
	}

	public function wcct_show_on_cart( $hyper_link_name, $cart_item, $cart_item_key ) {

		if ( WCCT_Core()->cart->is_mini_cart ) {
			return $hyper_link_name;
		}
		$get_item_id = $cart_item['product_id'];
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $get_item_id );
		$cp_data     = array( 'campaign' => $single_data );
		wcct_force_log( "product id => {wcct_show_on_cart} \n function wcct_show_on_cart_grid_bar " );
		$this->current_cart_item = $cart_item;
		ob_start();
		$this->wcct_triggers( $cp_data, 0, 'cart' );
		$html = ob_get_clean();

		return $hyper_link_name . $html;
	}

	public function wcct_triggers( $campaign_data, $position = 0, $type = 'single' ) {

		if ( ! is_checkout() ) {
			if ( is_user_logged_in() && current_user_can( 'administrator' ) && isset( $_GET['wcct_positions'] ) && $_GET['wcct_positions'] == 'yes' && $position != '0' ) {
				WCCT_Common::pr( $position );
			}
			global $expiry_text;
			$data  = $campaign_data['campaign'];
			$goals = isset( $data['goals'] ) ? $data['goals'] : array();

			global $product;
			if ( ! $product instanceof WC_Product ) {
				return;
			}
			if ( in_array( $type, array( 'single', 'grid' ) ) ) {
				$goals_meta = WCCT_Core()->public->wcct_get_goal_object( $goals, WCCT_Core()->public->wcct_get_product_parent_id( $product ) );
			}

			if ( $type == 'single' && is_singular( 'product' ) ) {
				if ( isset( $data['single_bar'] ) && is_array( $data['single_bar'] ) && count( $data['single_bar'] ) > 0 ) {
					$manage_stock_check = true;
					if ( in_array( $product->get_type(), WCCT_Common::get_simple_league_product_types() ) ) {
						$manage_stock_check = $product->managing_stock();
					}
					// in some cases manage stock returns blank, that's why below handling
					$manage_stock_check = ( $manage_stock_check ) ? true : false;
					$show_bar           = true;

					/*
					 * Final Check to show the counter bar on the products that are not in stock
					*/
					if ( ! $product->is_in_stock() ) {
						$show_bar = false;
					}

					if ( $goals['type'] == 'same' && ! $manage_stock_check ) {
						$show_bar = false;
					}
					if ( $show_bar && $goals['type'] == 'same' && in_array( $product->get_type(), WCCT_Common::get_variable_league_product_types() ) && WCCT_Common::get_total_stock( $product ) <= 0 ) {
						// use <= for sometimes stock quantity goes to in negative
						$show_bar = false;
					}
					if ( WCCT_Core()->public->wcct_restrict_for_booking_oth( $product->get_id() ) == false ) {
						$campaign_id = key( $data['single_bar'] );
						$single_bar  = current( $data['single_bar'] );

						if ( $position === (int) $single_bar['position'] && $show_bar ) {
							$this->wcct_trigger_counter_bar( $campaign_id, $single_bar, $goals_meta, 'single' );
						}
					}
				}

				if ( isset( $data['single_timer'] ) && is_array( $data['single_timer'] ) && count( $data['single_timer'] ) > 0 ) {
					foreach ( $data['single_timer'] as $campaign_id => $single_timer ) {
						if ( $position === (int) $single_timer['position'] ) {
							$this->wcct_trigger_countdown_timer( $campaign_id, $single_timer, 'single' );
						}
					}
				}

				if ( is_array( $expiry_text ) && count( $expiry_text ) > 0 ) {
					foreach ( $expiry_text as $campaign_id => $exp_text ) {
						if ( $position === (int) $exp_text['position'] ) {
							$this->wcct_trigger_countdown_timer_expiry( $campaign_id, $exp_text );
						}
					}
				}
			}
			if ( $type == 'grid' ) {

				if ( isset( $data['grid_bar'] ) && is_array( $data['grid_bar'] ) && count( $data['grid_bar'] ) > 0 ) {
					$manage_stock_check = true;
					if ( in_array( $product->get_type(), WCCT_Common::get_simple_league_product_types() ) ) {
						$manage_stock_check = $product->managing_stock();
					}
					// in some cases manage stock returns blank, that's why below handling
					$manage_stock_check = ( $manage_stock_check ) ? true : false;
					$show_bar           = true;
					if ( $goals['type'] == 'same' && ! $manage_stock_check ) {
						$show_bar = false;
					}
					if ( $show_bar && $goals['type'] == 'same' && in_array( $product->get_type(), WCCT_Common::get_variable_league_product_types() ) && WCCT_Common::get_total_stock( $product ) <= 0 ) {
						// use <= for sometimes stock quantity goes to in negaitive
						$show_bar = false;
					}
					if ( WCCT_Core()->public->wcct_restrict_for_booking_oth( $product->get_id() ) == false && $show_bar ) {
						foreach ( $data['grid_bar'] as $campaign_id => $grid_bar ) {
							$this->wcct_trigger_counter_bar( $campaign_id, $grid_bar, $goals_meta, 'grid' );
							break;
						}
					}
				}
				if ( isset( $data['grid_timer'] ) && is_array( $data['grid_timer'] ) && count( $data['grid_timer'] ) > 0 ) {

					foreach ( $data['grid_timer'] as $campaign_id => $grid_timer ) {

						$this->wcct_trigger_countdown_timer( $campaign_id, $grid_timer, 'grid' );
					}
				}
			}
			if ( $type == 'cart' ) {
				if ( isset( $data['show_on_cart'] ) && is_array( $data['show_on_cart'] ) && count( $data['show_on_cart'] ) > 0 ) {
					foreach ( $data['show_on_cart'] as $campaign_id => $show_on_cart ) {
						$this->wcct_trigger_countdown_timer( $campaign_id, $show_on_cart, 'cart' );
					}
				}
			}
		}
	}

	public function wcct_trigger_counter_bar( $key, $data, $goal_data, $call_type = 'single' ) {

		global $product, $wcct_style;

		if ( ! $product instanceof WC_Product ) {
			return '';
		}
		if ( $product->is_in_stock() === false ) {
			return '';
		}
		if ( is_object( $product ) && in_array( $product->get_type(), array( 'grouped' ) ) ) {
			return '';
		}

		if ( false == is_array( $goal_data ) ) {
			return '';
		}
		if ( count( $goal_data ) == 0 ) {
			return '';

		}
		if ( $goal_data['sold_out'] >= $goal_data['quantity'] ) {
			return '';
		}
		$prCampaignId = 0;
		if ( $product && is_object( $product ) ) {
			$prCampaignId = $product->get_id();
		}
		$campaign_id = $key;
		$new_key     = $campaign_id . '_' . $prCampaignId;

		$timers_class = 'wcct_cbsh_id_';
		if ( $call_type == 'single' ) {
			$timers_class = 'wcct_cbs_id_';
		} elseif ( $call_type == 'grid' ) {
			$timers_class = 'wcct_cbg_id_';
		} elseif ( $call_type == 'cart' ) {
			$timers_class = 'wcct_cbc_id_';
		}

		$wcct_orientation_classes = ' wcct_bar_orientation_ltr';
		if ( isset( $data['orientation'] ) && $data['orientation'] == 'rtl' ) {
			$wcct_orientation_classes = ' wcct_bar_orientation_rtl';
		}

		$wcct_aria_classes = ' wcct_bar_stripe';
		if ( isset( $data['skin'] ) && $data['skin'] == 'fill' ) {
			$wcct_aria_classes = ' wcct_bar_fill';
		} elseif ( isset( $data['skin'] ) && $data['skin'] == 'stripe_animate' ) {
			$wcct_aria_classes = ' wcct_bar_stripe wcct_bar_stripe_animate';
		}
		$wcct_progress_classes = '';
		if ( isset( $data['edge'] ) && $data['edge'] == 'smooth' ) {
			$wcct_progress_classes .= ' wcct_bar_edge_smooth';
			$wcct_aria_classes     .= ' wcct_bar_edge_smooth';
		}
		$new_height = 12;
		if ( isset( $data['height'] ) && $data['height'] != '' ) {
			$new_height = (int) $data['height'];
		}
		ob_start();
		if ( isset( $data['border_style'] ) && $data['border_style'] != 'none' ) {
			echo '.' . $timers_class . $new_key . ' { border-style: ' . $data['border_style'] . '; border-color: ' . ( isset( $data['border_color'] ) ? $data['border_color'] : '#ffffff' ) . '; border-width: ' . ( isset( $data['border_width'] ) ? $data['border_width'] . 'px' : '1px' ) . '; padding: 10px; }';
		}
		echo '.' . $timers_class . $new_key . ' .wcct_progress_aria { ' . ( isset( $data['bg_color'] ) ? ( 'background: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ' height: ' . $new_height . 'px; }';
		if ( isset( $data['edge'] ) && $data['edge'] == 'rounded' ) {
			echo '.' . $timers_class . $new_key . ' .wcct_progress_aria { border-radius: ' . ( $new_height / 2 ) . 'px; -moz-border-radius: ' . ( $new_height / 2 ) . 'px; -webkit-border-radius: ' . ( $new_height / 2 ) . 'px; }';
		}
		echo '.' . $timers_class . $new_key . ' .wcct_progress_aria .wcct_progress_bar { ' . ( isset( $data['active_color'] ) ? ( 'background-color: ' . $data['active_color'] . '; ' ) : '' ) . '; }';
		echo '.' . $timers_class . $new_key . ' p span { ' . ( isset( $data['active_color'] ) ? ( 'color: ' . $data['active_color'] . '; ' ) : '' ) . '; }';
		$wcct_bar_css = ob_get_clean();
		$wcct_style   .= $wcct_bar_css;
		if ( ( isset( $data['display'] ) && $data['display'] != '' ) || $call_type == 'grid' ) {
			$sold_percentage = 0;
			if ( is_array( $goal_data ) && isset( $goal_data['sold_out'] ) && $goal_data['sold_out'] > 0 ) {
				$sold_per = (float) ( $goal_data['sold_out'] / $goal_data['quantity'] ) * 100;
				if ( is_float( $sold_per ) ) {
					$sold_percentage = number_format( $sold_per, 2 );
				} else {
					$sold_percentage = $sold_per;
				}
			}
			$remaining_percentage = $sold_percentage;
			if ( isset( $data['orientation'] ) && $data['orientation'] == 'rtl' ) {
				$remaining_percentage = ( 100 - $sold_percentage );
			}

			$is_counter_bar_display = apply_filters( 'wcct_trigger_counter_bar', true, (int) ( isset( $goal_data['sold_out'] ) ? $goal_data['sold_out'] : 0 ) );
			if ( $is_counter_bar_display ) {
				?>
                <div class="wcct_counter_bar <?php echo $timers_class . $new_key; ?>"
                     data-type="<?php echo $call_type; ?>" data-campaign-id="<?php echo $campaign_id; ?>">
					<?php ob_start(); ?>
                    <div class="wcct_progress_aria <?php echo $wcct_aria_classes; ?>">
                        <div class="wcct_progress_bar <?php echo $wcct_progress_classes . $wcct_orientation_classes; ?>"
                             data-id="<?php echo $timers_class . $new_key; ?>" role="progressbar"
                             aria-valuenow="<?php echo $remaining_percentage; ?>" aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
					<?php
					$display = ob_get_clean();
					$output  = isset( $data['display'] ) ? $data['display'] : '';
					$output  = str_replace( '{{counter_bar}}', $display, $output );
					$output  = str_replace( '{{sold_units}}', $this->wcct_merge_tags( $data, $goal_data, 'sold_units' ), $output );
					$output  = str_replace( '{{remaining_units}}', $this->wcct_merge_tags( $data, $goal_data, 'remaining_units' ), $output );
					$output  = str_replace( '{{total_units}}', $this->wcct_merge_tags( $data, $goal_data, 'total_units' ), $output );
					$output  = str_replace( '{{sold_percentage}}', $this->wcct_merge_tags( $data, $goal_data, 'sold_percentage' ), $output );
					$output  = str_replace( '{{remaining_percentage}}', $this->wcct_merge_tags( $data, $goal_data, 'remaining_percentage' ), $output );
					$output  = str_replace( '{{sold_units_price}}', $this->wcct_merge_tags( $data, $goal_data, 'sold_units_price' ), $output );
					$output  = str_replace( '{{total_units_price}}', $this->wcct_merge_tags( $data, $goal_data, 'total_units_price' ), $output );
					$output  = $this->wcct_maybe_decode_campaign_time_merge_tags( $output, $data );
					$output  = apply_filters( 'wcct_the_content', $output );
					echo $output;
					?>
                </div>
				<?php
			}
		}
	}

	/**
	 * Generate Output of Merge tags like {{Sold_out}}
	 * @global type $product
	 *
	 * @param type $data
	 * @param type $goal_data
	 * @param type $merge_tags
	 *
	 * @return type
	 */
	public function wcct_merge_tags( $data, $goal_data, $merge_tags = 'sold_units' ) {
		global $product;

		$output        = array();
		$goal_price    = 0;
		$goal_quantity = isset( $goal_data['quantity'] ) ? (int) $goal_data['quantity'] : 0;
		$goal_sold_out = isset( $goal_data['sold_out'] ) ? (int) $goal_data['sold_out'] : 0;

		if ( $product && is_object( $product ) && $product instanceof WC_Product ) {
			if ( in_array( $product->get_type(), WCCT_Common::get_variable_league_product_types() ) ) {
				$children = $product->get_children();

				if ( $children && is_array( $children ) && count( $children ) > 0 ) {
					$child         = $children[0];
					$child_product = wc_get_product( $child );
					$goal_price    = (float) $child_product->get_price();
				} else {
					$goal_price = (float) $product->get_price();
				}
			} else {

				$goal_price = (float) $product->get_price();

			}
		}
		if ( $merge_tags == 'sold_units' ) {
			if ( $goal_sold_out === 0 ) {
				$output['sold_units'] = '0';
			} else {
				$output['sold_units'] = $goal_sold_out;
			}
		} elseif ( $merge_tags == 'total_units' ) {
			$total_units           = (int) $goal_quantity;
			$output['total_units'] = $total_units;
		} elseif ( $merge_tags == 'remaining_units' ) {
			$sold_units  = ( $goal_sold_out === 0 ) ? '0' : $goal_sold_out;
			$total_units = ( $goal_quantity ) ? (int) $goal_quantity : '0';
			if ( $total_units > 0 ) {
				if ( ( $total_units - $sold_units ) >= '0' ) {
					$output['remaining_units'] = $total_units - $sold_units;
				} else {
					$output['remaining_units'] = '0';
				}
			}
		} elseif ( $merge_tags == 'sold_percentage' ) {
			if ( $goal_sold_out === 0 ) {
				$output['sold_percentage'] = '0%';
			} else {
				$sold_per = (float) ( $goal_sold_out / $goal_quantity ) * 100;
				if ( is_float( $sold_per ) ) {
					$output['sold_percentage'] = number_format( $sold_per, 2 ) . '%';
				} else {
					$output['sold_percentage'] = $sold_per . '%';
				}
			}
		} elseif ( $merge_tags == 'remaining_percentage' ) {
			if ( $goal_sold_out === 0 ) {
				$output['remaining_percentage'] = '100%';
			} else {
				$sold_per   = (float) ( $goal_sold_out / $goal_quantity ) * 100;
				$remain_per = 100 - $sold_per;
				if ( is_float( $remain_per ) ) {
					$output['remaining_percentage'] = number_format( $remain_per, 2 ) . '%';
				} else {
					$output['remaining_percentage'] = $remain_per . '%';
				}
			}
		} elseif ( $merge_tags == 'sold_units_price' ) {
			if ( $goal_sold_out === 0 ) {
				$output['sold_units_price'] = wc_price( 0 );
			} else {
				$sold_price                 = (float) ( $goal_price * $goal_sold_out );
				$output['sold_units_price'] = wc_price( $sold_price );
			}
		} elseif ( $merge_tags == 'total_units_price' ) {
			$total_units_price           = (float) ( $goal_price * $goal_quantity );
			$output['total_units_price'] = wc_price( $total_units_price );
		}

		return ( isset( $output[ $merge_tags ] ) && $output[ $merge_tags ] != '' ) ? $output[ $merge_tags ] : '';
	}

	/**
	 * Print Countdown Timer For Grid and Single
	 * @global type $product
	 * @global type $wcct_style
	 *
	 * @param type $key
	 * @param type $data
	 * @param type $call_type
	 *
	 * @return type
	 */
	public function wcct_trigger_countdown_timer( $key, $data, $call_type = 'single' ) {

		global $product, $wcct_style;
		$campaign_id   = $key;
		$prCampaing_id = 0;
		if ( $product && is_object( $product ) && $product instanceof WC_Product ) {
			$prCampaing_id = $product->get_id();
		}
		$reduce_font_size_mobile = 0;
		if ( true == WCCT_Core()->is_mobile ) {

			$reduce_font_size_mobile = isset( $data['timer_mobile'] ) ? $data['timer_mobile'] : 0;
		}
		$new_key = $campaign_id . '_' . $prCampaing_id;

		$timers_class = 'wcct_ctsh_id_';
		if ( $call_type == 'single' ) {
			$timers_class = 'wcct_cts_id_';
		} elseif ( $call_type == 'grid' ) {
			$timers_class = 'wcct_ctg_id_';
		} elseif ( $call_type == 'cart' ) {
			$timers_class = 'wcct_ctc_id_';
		}


		$labels['d'] = isset( $data['label_days'] ) ? $data['label_days'] : 'days';
		$labels['h'] = isset( $data['label_hrs'] ) ? $data['label_hrs'] : 'hrs';
		$labels['m'] = isset( $data['label_mins'] ) ? $data['label_mins'] : 'mins';
		$labels['s'] = isset( $data['label_secs'] ) ? $data['label_secs'] : 'secs';

		$new_height = 8;
		$new_height += ( isset( $data['timer_font'] ) ? round( $data['timer_font'] * 1.2 ) : 0 );
		$new_height += ( isset( $data['label_font'] ) ? round( $data['label_font'] * 1.5 ) : 0 );
		$new_height += 8;


		// reducing defined pixels for mobile
		if ( $reduce_font_size_mobile > 0 ) {
			$new_height         = round( $new_height * ( $reduce_font_size_mobile / 100 ), 1 );
			$data['timer_font'] = round( $data['timer_font'] * ( $reduce_font_size_mobile / 100 ), 1 );
			$data['label_font'] = round( $data['label_font'] * ( $reduce_font_size_mobile / 100 ), 1 );
		}
		ob_start();
		if ( $data['skin'] == 'round_fill' ) {
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap { ' . ( isset( $data['bg_color'] ) ? ( 'background: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ' height: ' . $new_height . 'px; width: ' . $new_height . 'px; }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap .wcct_wrap_border { ' . ( isset( $data['bg_color'] ) ? ( 'border-color: ' . $data['bg_color'] . '; ' ) : '' ) . '}';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap span { ' . ( isset( $data['timer_font'] ) ? ( 'font-size: ' . $data['timer_font'] . 'px; ' ) : '' ) . ' }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap .wcct_table_cell { ' . ( isset( $data['label_font'] ) ? ( 'font-size: ' . $data['label_font'] . 'px; ' ) : '' ) . ' }';
		} elseif ( $data['skin'] == 'square_fill' ) {
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap { ' . ( isset( $data['bg_color'] ) ? ( 'background: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ' height: ' . $new_height . 'px; width: ' . $new_height . 'px; }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap .wcct_wrap_border { ' . ( isset( $data['bg_color'] ) ? ( 'border-color: ' . $data['bg_color'] . '; ' ) : '' ) . '}';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap span { ' . ( isset( $data['timer_font'] ) ? ( 'font-size: ' . $data['timer_font'] . 'px; ' ) : '' ) . ' }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap .wcct_table_cell { ' . ( isset( $data['label_font'] ) ? ( 'font-size: ' . $data['label_font'] . 'px; ' ) : '' ) . ' }';
		} elseif ( $data['skin'] == 'round_ghost' ) {
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap { ' . ( isset( $data['bg_color'] ) ? ( 'border-color: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ' height: ' . $new_height . 'px; width: ' . $new_height . 'px; }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap .wcct_wrap_border { ' . ( isset( $data['bg_color'] ) ? ( 'border-color: ' . $data['bg_color'] . '; ' ) : '' ) . '}';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap span { ' . ( isset( $data['timer_font'] ) ? ( 'font-size: ' . $data['timer_font'] . 'px; ' ) : '' ) . ' }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_round_wrap .wcct_table_cell { ' . ( isset( $data['label_font'] ) ? ( 'font-size: ' . $data['label_font'] . 'px; ' ) : '' ) . ' }';
		} elseif ( $data['skin'] == 'square_ghost' ) {
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap { ' . ( isset( $data['bg_color'] ) ? ( 'border-color: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ' height: ' . $new_height . 'px; width: ' . $new_height . 'px; }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap .wcct_wrap_border { ' . ( isset( $data['bg_color'] ) ? ( 'border-color: ' . $data['bg_color'] . '; ' ) : '' ) . '}';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap span { ' . ( isset( $data['timer_font'] ) ? ( 'font-size: ' . $data['timer_font'] . 'px; ' ) : '' ) . ' }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_square_wrap .wcct_table_cell { ' . ( isset( $data['label_font'] ) ? ( 'font-size: ' . $data['label_font'] . 'px; ' ) : '' ) . ' }';
		} elseif ( $data['skin'] == 'highlight_1' ) {
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_highlight_1_wrap { ' . ( isset( $data['bg_color'] ) ? ( 'background: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ( isset( $data['label_font'] ) ? ( 'font-size: ' . $data['label_font'] . 'px; ' ) : '' ) . ' }';
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap .wcct_highlight_1_wrap span { ' . ( isset( $data['timer_font'] ) ? ( 'font-size: ' . $data['timer_font'] . 'px; ' ) : '' ) . ' }';
		} else {
			echo '.' . $timers_class . $new_key . '.wcct_countdown_' . $data['skin'] . ' .wcct_timer_wrap { ' . ( isset( $data['bg_color'] ) ? ( 'background: ' . $data['bg_color'] . '; ' ) : '' ) . ( isset( $data['label_color'] ) ? 'color: ' . $data['label_color'] . '; ' : '' ) . ( isset( $data['timer_font'] ) ? ( 'font-size: ' . $data['timer_font'] . 'px; ' ) : '' ) . ' }';
		}
		if ( isset( $data['border_style'] ) && $data['border_style'] != 'none' && isset( $data['border_color'] ) && $data['border_color'] != '' ) {
			echo '.' . $timers_class . $new_key . ' { padding: 10px; border: ' . ( ( isset( $data['border_width'] ) && $data['border_width'] != '' ) ? $data['border_width'] : '1' ) . 'px ' . $data['border_style'] . ' ' . $data['border_color'] . ' }';
		}
		$wcct_timer_css = ob_get_clean();
		$wcct_style     .= $wcct_timer_css;

		$is_show_days = apply_filters( 'wcct_always_show_days_on_timers', true );
		$is_show_days = apply_filters( "wcct_always_show_days_on_timers_{$campaign_id}", $is_show_days );

		if ( isset( $data['display'] ) && $data['display'] != '' ) {
			?>
            <div
                    class="wcct_countdown_timer <?php echo $timers_class . $new_key; ?> wcct_timer wcct_countdown_<?php echo $data['skin']; ?>"
                    data-days="<?php echo $labels['d']; ?>" data-hrs="<?php echo $labels['h']; ?>"
                    data-mins="<?php echo $labels['m']; ?>" data-secs="<?php echo $labels['s']; ?>"
                    data-campaign-id="<?php echo $campaign_id; ?>" data-type="<?php echo $call_type; ?>"
                    data-is_days="<?php echo ( $is_show_days ) ? 'yes' : 'no'; ?>">
				<?php

				/**
				 * Trying and getting difference left still in te countdown
				 * Comparing end timestamp with the current timestamp
				 */
				$date_obj = new DateTime();

				$current_Date_object = clone $date_obj;

				$date_obj->setTimestamp( $data['end_timestamp'] );

				$interval = $current_Date_object->diff( $date_obj );

				$x = $interval->format( '%R' );

				$is_left = $x;

				if ( $is_left == '+' ) {

					$total_seconds_left = 0;

					$total_seconds_left = $total_seconds_left + ( YEAR_IN_SECONDS * $interval->y );
					$total_seconds_left = $total_seconds_left + ( MONTH_IN_SECONDS * $interval->m );

					$total_seconds_left = $total_seconds_left + ( DAY_IN_SECONDS * $interval->d );

					$total_seconds_left = $total_seconds_left + ( HOUR_IN_SECONDS * $interval->h );
					$total_seconds_left = $total_seconds_left + ( MINUTE_IN_SECONDS * $interval->i );
					$total_seconds_left = $total_seconds_left + $interval->s;

					$display = '<div class="wcct_timer_wrap" data-date="' . $data['end_timestamp'] . '" data-left="' . $total_seconds_left . '" data-timer-skin="' . $data['skin'] . '"></div>';
					$output  = str_replace( '{{countdown_timer}}', $display, $data['display'] );

					$output = apply_filters( 'wcct_the_content', $output );
					$output = $this->wcct_maybe_decode_campaign_time_merge_tags( $output, $data );

					echo $output;

				}

				?>
            </div>
			<?php
		}
	}

	/**
	 * Display Expiry text when Campaign is expire
	 *
	 * @param type $campaign_id
	 * @param type $data
	 */
	public function wcct_trigger_countdown_timer_expiry( $campaign_id, $data ) {
		?>
        <div class="wcct_counter_timer_expiry" data-expiry="<?Php echo wp_json_encode( $data ); ?>">
			<?php echo isset( $data['text'] ) ? apply_filters( 'wcct_the_content', $data['text'] ) : ''; ?>
        </div>
		<?php
	}

	public function wcct_position_above_title() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 1 );
	}

	public function wcct_position_below_title() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 2 );
	}

	public function wcct_position_below_review() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 3 );
	}

	public function wcct_position_below_price() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 4 );
	}

	public function wcct_position_below_short_desc() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 5 );
	}

	public function wcct_position_below_add_cart() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 6 );
	}

	public function wcct_position_below_meta() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 7 );
	}

	public function wcct_position_above_tab_area() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		echo '<div class="wcct_clear"></div>';
		$this->wcct_triggers( $cp_data, 8 );
	}

	public function wcct_position_below_related_products() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 11 );
	}

	public function wcct_bar_timer_show_on_grid() {
		global $post;
		$single_data = WCCT_Core()->public->get_single_campaign_pro_data( $post->ID );

		$cp_data = array( 'campaign' => $single_data );
		$this->wcct_triggers( $cp_data, 0, 'grid' );
	}

	/**
	 * Print css contained by global variable
	 * @global $wcct_style string inline styles
	 */
	public function wcct_render_inline_style() {
		global $wcct_style;
		if ( $wcct_style != '' ) {
			echo "<style>{$wcct_style}</style>";
		}

	}

	public function add_header_info( $content ) {
		array_push( $this->header_info, $content );
	}

	public function wcct_print_html_header_info() {

		ob_start();
		if ( $this->header_info && count( $this->header_info ) > 0 ) {
			foreach ( $this->header_info as $key => $info_row ) {
				?>
                <li id="wp-admin-bar-wcct_admin_page_node_<?php echo $key; ?>">
					<span class="ab-item">
						<?php echo $info_row; ?>
					</span>
                </li>
				<?php
			}
		}

		echo "<!--googleoff: all--><div class='wcct_header_passed' style='display: none;'>" . ob_get_clean() . '</div><!--googleon: all-->';
	}

	public function add_info_localized( $localized_data ) {
		if ( $this->header_info && count( $this->header_info ) > 0 ) {
			$localized_data['info'] = $this->header_info;
		}

		return $localized_data;
	}


	/**
	 * Adding Script data to help in debug what campaign is ON for that product.
	 * Using WordPress way to localize a script
	 * @see WP_Scripts::localize()
	 */
	public function maybe_add_info_footer() {
		$l10n = array();
		if ( $this->header_info && count( $this->header_info ) > 0 ) {

			foreach ( (array) $this->header_info as $key => $value ) {
				if ( ! is_scalar( $value ) ) {
					continue;
				}

				$l10n[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );
			}
		}
		$script = 'var wcct_info = ' . wp_json_encode( $l10n ) . ';';
		?>
        <script type="text/javascript">
			<?php echo $script; ?>
        </script>
		<?php

	}

	public function wcct_maybe_decode_campaign_time_merge_tags( $content, $campaign_data ) {

		$date_format = apply_filters( 'wcct_global_date_time_format', 'M j', $campaign_data );
		if ( strpos( $content, '{{campaign_start_date}}' ) !== false ) {

			$get_start_timestamp = ( isset( $campaign_data['start_timestamp'] ) ? $campaign_data['start_timestamp'] : null );

			if ( $get_start_timestamp !== null ) {

				$date_starttime = new DateTime();

				$date_starttime->setTimezone( new DateTimeZone( WCCT_Common::wc_timezone_string() ) );
				$date_starttime->setTimestamp( $get_start_timestamp );

				$realTimeStamp = ( $date_starttime->getTimestamp() + $date_starttime->getOffset() );

				$content = str_replace( '{{campaign_start_date}}', date_i18n( $date_format, $realTimeStamp, true ), $content );

			}
		}

		if ( strpos( $content, '{{campaign_end_date}}' ) !== false ) {

			$get_start_timestamp = ( isset( $campaign_data['end_timestamp'] ) ? $campaign_data['end_timestamp'] : null );

			if ( $get_start_timestamp !== null ) {
				$date_starttime = new DateTime();

				$date_starttime->setTimezone( new DateTimeZone( WCCT_Common::wc_timezone_string() ) );
				$date_starttime->setTimestamp( $get_start_timestamp );

				$realTimeStamp = ( $date_starttime->getTimestamp() + $date_starttime->getOffset() );

				$content = str_replace( '{{campaign_end_date}}', date_i18n( $date_format, $realTimeStamp, true ), $content );

			}
		}

		return $content;
	}

}

if ( class_exists( 'WCCT_Appearance' ) ) {
	WCCT_Core::register( 'appearance', 'WCCT_Appearance' );
}
