<?php
defined('TEXT_DOMAIN_PAPAL_LIST') or define('TEXT_DOMAIN_PAPAL_LIST', 'imevent');


add_action( 'admin_print_styles', 'load_custom_admin_css' );
 function load_custom_admin_css()
{
 wp_enqueue_style( 'style_export_paypal', get_template_directory_uri().'/assets/css/listpaypal-style.css');
/*wp_enqueue_style('my_style', ABSPATH . '/themes/custom_admin.css');*/
}


if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Free_List_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'registration',     //singular name of the listed records
            'plural'    => 'registrations',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
        switch($column_name){
            case 'id':
            case 'status':
            case 'order_id':
            case 'buyer_info':
            case 'created':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_id($item){
        
        //Build row actions
        $actions = array(
            'delete'    => sprintf('<a href="?page=%s&action=%s&registration=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );
        
        //Return the title contents
        return sprintf('<span>%1$s</span>%2$s',
            $item['id'],
            $this->row_actions($actions)
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }

    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'id'     => 'Id',
            'status'     => 'Status',
            'order_id'    => 'Order ID',
            'buyer_info'  => 'Client information',
            'created'  => 'Created'
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'id'    => array('id',true),
            'status'     => array('status',false),  //true means it's already sorted
            'order_id'    => array('order_id',false),         
            'buyer_info'  => array('buyer_info',false),
            'created'  => array('created',false)
        );
        return $sortable_columns;
    }


    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        global $wpdb;
        //Detect when a bulk action is being triggered...
        if(isset($_REQUEST['registration'])){
            if(is_array($_REQUEST['registration'])){
                $ids = implode(',',$_REQUEST['registration']);  
            }else{
                $ids = $_REQUEST['registration'];
            }
        }        
        
        //var_dump($ids);exit();
        if( 'delete'===$this->current_action() ) {          
            $wpdb->query("DELETE FROM imevent_payments WHERE id IN (".$ids.")");            
            _e('The Items deleted!', 'imevent');
        }
        
    }

    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = get_option('posts_per_page ');
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        $this->process_bulk_action();

        $data = array();
        $result = $wpdb->get_results( "SELECT * FROM imevent_payments where status = 'free' ORDER BY id DESC ");
        foreach($result as $r) {
            $data[] = array(
                'id'            => $r->id,
                'status'        => $r->status,
                'order_id'      => $r->order_id,
                'buyer_info'    => html_entity_decode($r->buyer_info),
                'created'       => date(get_option('date_format'), $r->created)
            );
        }

       $sortable = $this->get_sortable_columns();
       function get_sortable_columns() {
          $sortable_columns = array(
            'id'  => array('id',false),
            'created' => array('created',false)
          );
          return $sortable_columns;
        }


        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        //usort($data, 'usort_reorder');

        
        $current_page = $this->get_pagenum();
        
        $total_items = count($data);
        
       
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
       
        $this->items = $data;
        
       
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }

}

class Paypal_List_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'registration',     //singular name of the listed records
            'plural'    => 'registrations',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
        switch($column_name){
            case 'id':
            case 'buyer_email':
            case 'price':
            case 'currency':
            case 'status':            
            case 'order_id':
            case 'transaction_id':            
            case 'buyer_info':
            case 'created':
                return $item[$column_name];
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_id($item){
        
        //Build row actions
        $actions = array(            
            'delete'    => sprintf('<a href="?page=%s&action=%s&registration=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );
        
        //Return the title contents
        return sprintf('<span>%1$s</span>%2$s',
            $item['id'],
            $this->row_actions($actions)
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }

    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'id'   => 'ID',
            'buyer_email'   => 'Buyer email',
            'price'         => 'Price',
            'currency'      => 'Currency',
            'status'        => 'Status',            
            'order_id'      => 'Order id',
            'transaction_id'=> 'Transaction id',            
            'buyer_info'    =>'Buyer info',
            'created'       =>'Created',
        );
        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'id'     => array('id',true),
            'buyer_email'     => array('buyer_email',false),     //true means it's already sorted
            'price'    => array('price',false),
            'currency'  => array('currency',false),
            'status'  => array('status',false),            
            'order_id'  => array('order_id',false),
            'transaction_id'  => array('transaction_id',false),            
            'buyer_info'  => array('buyer_info',false),
            'created'  => array('created',false),
        );
        return $sortable_columns;
    }


    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        global $wpdb;
        //Detect when a bulk action is being triggered...
        if(isset($_REQUEST['registration'])){
            if(is_array($_REQUEST['registration'])){
                $ids = implode(',',$_REQUEST['registration']);  
            }else{
                $ids = $_REQUEST['registration'];
            }
        }        
        
        //var_dump($ids);exit();
        if( 'delete'===$this->current_action() ) {          
            $wpdb->query("DELETE FROM imevent_payments WHERE id IN (".$ids.")");            
            _e('The Items deleted!', 'imevent');
        }
        
    }

    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = get_option('posts_per_page ');
        
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        $this->process_bulk_action();

        $data = array();
        $result = $wpdb->get_results( "SELECT * FROM imevent_payments where status = 'Completed' ORDER BY id ASC ");        
        foreach($result as $r) {
            $data[] = array(
                'id'            => $r->id,
                'buyer_email'        => $r->buyer_email,
                'price'      => $r->price,
                'currency'      => $r->currency,
                'status'      => $r->status,                
                'order_id'      => $r->order_id,
                'transaction_id'      => $r->transaction_id,                
                'buyer_info'    => html_entity_decode($r->buyer_info),
                'created'       => date(get_option('date_format'), $r->created)
            );
        }

       

       
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        
        $current_page = $this->get_pagenum();
        
        $total_items = count($data);
        
        
       
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
       
        $this->items = $data;
        
       
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }

}





/** ************************ REGISTER THE TEST PAGE ****************************
 *******************************************************************************
 * Now we just need to define an admin page. For this example, we'll add a top-level
 * menu item to the bottom of the admin menus.
 */
function tt_add_menu_items(){
    //add_menu_page('Example Plugin List Table', 'List Table Example', 'activate_plugins', 'tt_list_test', 'tt_render_list_page');
    add_theme_page( __( 'Free Register List', TEXT_DOMAIN_PAPAL_LIST ), __( 'Free Register List', TEXT_DOMAIN_PAPAL_LIST ), 'manage_options', 'free_register', 'tt_render_list_page_free');
    add_theme_page( __( 'Paypal Register List', TEXT_DOMAIN_PAPAL_LIST ), __( 'Paypal Register List', TEXT_DOMAIN_PAPAL_LIST ), 'manage_options', 'paypal_register', 'tt_render_list_page_paypal');
} 
add_action('admin_menu', 'tt_add_menu_items');





/** *************************** RENDER TEST PAGE ********************************
 *******************************************************************************/

function tt_render_list_page_free(){
    
    //Create an instance of our package class...
    $testListTable = new Free_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $testListTable->prepare_items();
    
    ?>
    <div class="wrap">        
        <div id="icon-users" class="icon32"><br/></div>
        <h2><?php _e('Free Register List', TEXT_DOMAIN_PAPAL_LIST) ?></h2>

        <!-- Update in version 2.6 -->
        <div class="export_paypal">
            <form action= "<?php echo home_url()?>/wp-content/plugins/imevent-common/paypal/export_csv_free.php" method="post">
                <div class="metabox-prefs">
                    <h3>Choose fields that you want to export to CSV file </h3>
                    
                        <label for="id"><input  name="check_list[]"  value="id"  type="checkbox"><?php _e('ID', TEXT_DOMAIN_PAPAL_LIST); ?></label>
                        <label for="statusaa"><input  name="check_list[]"  value="status"  type="checkbox">Status</label>
                        <label for="orderaaa"><input  name="check_list[]"  value="order_id"  type="checkbox">Order ID</label>
                        <label for="createaa"><input  name="check_list[]"  value="created"  type="checkbox">Created</label><br>
                        <label for="createaa">Insert Key. For example: email,number,price</label><input  name="extra_field_export"  value=""  type="text" size="50"><br/>
                        You can find Key here: <a href="http://demo.ovatheme.com/Documentation/wordpress/imevent/key_export.png" target="_blank">http://demo.ovatheme.com/Documentation/wordpress/imevent/key_export.png</a>
                        <br>Note syntax: your-key,your-key,your-key
                        <br class="clear">
                </div>
                <br>
            <input id="button" class="button action exportcsv" name ="submit"value="Export to CSV" type="submit" style="background-color:#555; color: #fff; border-color: #555; box-shadow: none;">
            </form>
            <br><br>
        </div>
        <!-- /Update in version 2.6 -->

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="movies-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $testListTable->display() ?>
        </form>
        
    </div>
    <?php
}


function tt_render_list_page_paypal(){
    
    //Create an instance of our package class...
    $testListTablepaypal = new Paypal_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $testListTablepaypal->prepare_items();
    
    ?>
    <div class="wrap">        
        <div id="icon-users" class="icon32"><br/></div>
        <h2><?php _e('Paypal Register List', TEXT_DOMAIN_PAPAL_LIST) ?></h2>

        <!-- Update in version 2.6 -->
        <div class="export_paypal">
            <form action= "<?php echo home_url()?>/wp-content/plugins/imevent-common/paypal/export_csv_paypal.php" method="post">
                <div class="metabox-prefs">
                    <h3>Choose fields that you want to export to CSV file</h3>
                    
                        <label for="id"><input  name="check_list[]"  value="id"  type="checkbox"><?php _e('ID', TEXT_DOMAIN_PAPAL_LIST); ?></label>
                        <label for="statusaa"><input  name="check_list[]"  value="status"  type="checkbox">Status</label>
                        <label for="orderaaa"><input  name="check_list[]"  value="order_id"  type="checkbox">Order Id</label>
                        <label for="transactionaa"><input  name="check_list[]"  value="transaction_id"  type="checkbox">Transactionn Id</label>
                        <label for="emailaaaaa"><input  name="check_list[]"  value="buyer_email"  type="checkbox">Buyer Email</label>
                        <label for="createaa"><input  name="check_list[]"  value="created"  type="checkbox">Created</label>
                        <label for="currencyaaaa"><input  name="check_list[]"  value="currency"  type="checkbox">Currency</label>
                        
                        <br>
                        <label for="createaa">Insert Key. For example: price,email</label><input  name="extra_field_export"  value=""  type="text" size="50"><br/>
                        You can find Key here: <a href="http://demo.ovatheme.com/Documentation/wordpress/imevent/key_export.png" target="_blank">http://demo.ovatheme.com/Documentation/wordpress/imevent/key_export.png</a>
                        <br>Note syntax: your-key,your-key,your-key
                        <br class="clear">

                        <br class="clear">
                </div>
            <input id="button" class="button action" name ="submit"value="Export to CSV" type="submit" style="background-color:#555; color: #fff; border-color: #555; box-shadow: none;">
            </form>
        </div>
        <!-- /Update in version 2.6 -->

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="movies-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $testListTablepaypal->display() ?>
        </form>
        
    </div>
    <?php
}





