<?php
add_action( 'wp_footer', 'plan_up_trigger_payment', 99 );
function plan_up_trigger_payment(){
    $current_rel_uri = home_url();
    $action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : '';
    if( $action == 'success' ):
        if( isset($_GET['customer_id']) ):
            if( isset($_POST['verify_sign']) && isset($_POST['payment_status']) && $_POST['payment_status'] == 'Completed' ){
                $payment_method = isset($_REQUEST["payment_method"]) ? $_REQUEST["payment_method"] : '';
                $customer_id = $_GET['customer_id'];
                fw_set_db_post_option($customer_id,'payment_status', esc_html__('Paid - PayPal', 'plan-up'));
                fw_set_db_post_option($customer_id,'payment_method',$payment_method);
                if( isset($_POST['payer_email']) ){
                    fw_set_db_post_option($customer_id,'paypal_account',$_POST['payer_email']);
                }
                echo
                '<script type="text/javascript" charset="utf-8">
                    window.location.replace("'.$current_rel_uri.'?action=done");
                </script>';
            }else{
                echo
                    '<script>
                        ;(function($){
                            notie.alert(3, "'.esc_html__('Payment fail', 'plan-up').'", 2);
                            window.location.replace("'.$current_rel_uri.'");
                        })(jQuery)
                    </script>';
            }
        endif;
    endif;
    if( $action == 'done' ):
        echo
            '<script>
                ;(function($){
                    notie.alert(1, "'.esc_html__('Registration done!', 'plan-up').'", 2);
                    window.location.replace("'.$current_rel_uri.'");
                })(jQuery)
            </script>';
    endif;
}
?>