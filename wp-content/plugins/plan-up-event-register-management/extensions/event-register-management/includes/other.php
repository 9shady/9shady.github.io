<?php
function plan_up_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','plan_up_set_content_type' );
?>