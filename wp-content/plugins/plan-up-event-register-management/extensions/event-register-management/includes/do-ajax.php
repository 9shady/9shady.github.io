<?php
/*
Do AJAX process
*/
add_action("wp_ajax_nopriv_do_maker", "do_maker");
add_action("wp_ajax_do_maker", "do_maker");
function do_maker(){
    if( isset($_POST['step']) ){
        $step = $_POST['step'];
        if( $step == 'register' ):
            $data = array();
            $news_register = $_POST['news_register'] == 'checked' ? esc_html__('Yes', 'plan-up') : esc_html__('No', 'plan-up');
            $quantity = $_POST['quantity'] != '' ? $_POST['quantity'] : '1';
            $customer_id = plan_up_create_registration($args = array(
                'post_title' => $_POST['first_name'].' - '.$_POST['register_email'],
                'post_content' => '',
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'phone' => $_POST['phone'],
                'ticket' => $_POST['ticket'],
                'register_email' => $_POST['register_email'],
                'quantity' => $quantity,
                'total' => $quantity*$_POST['amount'],
                'currency' => $_POST['currency'],
                'news_register' => $news_register,
            ));
            $data['message'] = "Registered ".$customer_id;
            $data['customer_id'] = $customer_id;
            echo json_encode($data);
        endif;
        //Check and uncheck the booking in the custom post type table
        //View ajax in post-table.php
        if( $step == 'admin-mark-check' ):
            $check = $_POST['check'];
            $id = $_POST['id'];
            if( $check == 'checked' ){
                fw_set_db_post_option($id,'checked','true');
            }else{
                fw_set_db_post_option($id,'checked','');
            }
        endif;
    }
    die();
}
?>