<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
function plan_up_create_registration($args){
    $event_register_managent = fw()->extensions->get( 'event-register-management' );
    //Create post type event-customer
    $post = array(
        'post_title'   => $args['post_title'],
        'post_content' => $args['post_content'],
        'post_status'  => 'publish',
        'post_type'    => $event_register_managent->get_post_type_name()
    );
    $post_id = wp_insert_post($post);
    fw_set_db_post_option( $post_id, 'first_name', $args['first_name'] );
    fw_set_db_post_option( $post_id, 'last_name', $args['last_name'] );
    fw_set_db_post_option( $post_id, 'register_email', $args['register_email'] );
    fw_set_db_post_option( $post_id, 'phone', $args['phone'] );
    fw_set_db_post_option( $post_id, 'ticket', $args['ticket'] );
    fw_set_db_post_option( $post_id, 'quantity', $args['quantity'] );
    fw_set_db_post_option( $post_id, 'total', $args['total'] );
    fw_set_db_post_option( $post_id, 'currency', $args['currency'] );
    fw_set_db_post_option( $post_id, 'news_register', $args['news_register'] );
    fw_set_db_post_option( $post_id, 'payment_status', esc_html__('Not paid yet', 'plan-up') );

    //Mail notification
    try{
        $erm_settings = fw_get_db_ext_settings_option('event-register-management');
        $noti_mail = $erm_settings['mail_noti'];
        if( $noti_mail != '' ):
            $mail_to = $noti_mail;
            $headers = $erm_settings['mail_headers'];
            $email_subject = esc_html__(get_bloginfo('name').': Registration', 'plan-up');
            $email_body = '<html><body>'.wpautop(($erm_settings['mail_template']),true).'</body></html>';
            $email_body = str_replace('{first_name}', $args['first_name'], $email_body);
            $email_body = str_replace('{last_name}', $args['last_name'], $email_body);
            $email_body = str_replace('{email}', $args['register_email'], $email_body);
            $email_body = str_replace('{phone}', $args['phone'], $email_body);
            $email_body = str_replace('{ticket}', $args['ticket'], $email_body);
            $email_body = str_replace('{quantity}', $args['quantity'], $email_body);
            $email_body = str_replace('{total}', $args['total'], $email_body);
            wp_mail($mail_to, $email_subject, $email_body, $headers);

            $mail_to = $args['register_email'];
            $email_subject = esc_html__(get_bloginfo('name').': Thanks for your registry. Here is your detail information', 'plan-up');
            wp_mail($mail_to, $email_subject, $email_body,$headers);
        endif;
    }catch( Exception $e ){
        //Do nothing
    }

    //Return post id of the created post
    return $post_id;
}