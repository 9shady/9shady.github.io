<?php
/**
 * Add new columns to the fw-coupon table
 *
 * @param Array $columns - Current columns on the list post
 */
$event_register_managent = fw()->extensions->get( 'event-register-management' );
$event_customer_post_type = $event_register_managent->get_post_type_name();
/**
 * Add new columns to the fw-booking table
 *
 * @param Array $columns - Current columns on the list post
 */
//1.Add new columns
add_filter('manage_'.$event_customer_post_type.'_posts_columns' , 'add_fw_booking_columns');
function add_fw_booking_columns($coupon_columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = _x('Name - Email', 'column name');
    $new_columns['check'] = _x('Checked', 'plan-up');
    $new_columns['ticket'] = _x('Ticket', 'plan-up');
    $new_columns['quantity'] = _x('Quantity', 'plan-up');
    $new_columns['total'] = _x('Total value', 'plan-up');
    $new_columns['payment_status'] = _x('Payment Status', 'plan-up');
    $new_columns['news_register'] = _x('News register', 'plan-up');
    $new_columns['date'] = _x('Date Created', 'column name');
    return $new_columns;
}
//2.Render data
add_action( 'manage_'.$event_customer_post_type.'_posts_custom_column' , 'custom_fw_booking_column', 10, 2 );
function custom_fw_booking_column( $column, $id ) {
    global $wpdb;
    switch ( $column ) {
        case 'check':
            $check = '';
            if( fw_get_db_post_option($id,'checked','') == true ){
                $check = 'checked';
            }
            echo '<input '.$check.' type="checkbox" class="mark-checked" data-id='.$id.'>';
            break;
        case 'ticket':
            echo fw_get_db_post_option($id,'ticket',0);
            break;
        case 'quantity':
            echo fw_get_db_post_option($id,'quantity',0);
            break;
        case 'total':
            echo fw_get_db_post_option($id,'total',0)." ".fw_get_db_post_option($id,'currency',0);
            break;
        case 'payment_status':
            echo fw_get_db_post_option($id,'payment_status',esc_html__('Not paid yet','plan-up'));
            break;
        case 'news_register':
            echo fw_get_db_post_option($id,'news_register',esc_html__('No','plan-up'));
            break;
    }
}
//3.Register the column as sortable
add_filter( 'manage_edit-'.$event_customer_post_type.'_sortable_columns', 'register_sortable_fw_booking_columns' );
function register_sortable_fw_booking_columns( $columns ) {
    $columns['check'] = 'check';
    $columns['total'] = 'total';
    $columns['news_register'] = 'news_register';
    $columns['ticket'] = 'ticket';
    $columns['quantity'] = 'quantity';
    $columns['payment_status'] = 'payment_status';
    return $columns;
}

//Check and uncheck the booking in the custom post type table
//View handle in ajax.php
add_action( 'admin_footer', 'my_action_javascript' );
function my_action_javascript() {
    $event_register_managent = fw()->extensions->get( 'event-register-management' );
    $event_customer_post_type = $event_register_managent->get_post_type_name();
?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
        $('.mark-checked').on('change', function(event) {
            event.preventDefault();
            var check;
            if($(this).is(':checked')){
                check = 'checked';
            }else{
                check = 'unchecked';
            }
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
                data: ({
                    action: 'do_maker',
                    step: 'admin-mark-check',
                    id: $(this).data('id'),
                    check: check
                }),
                success: function(res) {
                    // console.log(res);
                }
            });
            return false;
        });
    });
    </script> <?php
}

?>