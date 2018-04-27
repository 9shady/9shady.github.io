<?php
/**
* AJAX PROCESS
*/
add_action( 'wp_footer', 'do_maker_script' );
function do_maker_script(){
    $theme_primary_color = get_theme_mod('primary_color', '#f30c74');
?>
  <script>
  ;(function($){
        /*Reservation form validation submit on safari*/
        if (true || navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){
            $('form.event-register-form input[type=submit]').on('click', function(event) {
                event.preventDefault();
                if( !$('form.event-register-form')[0].checkValidity() ){
                    /*https://github.com/jaredreich/notie.js*/
                    notie.alert(3, "<?php _e('Please enter a valid email and do not leave the required fields empty!', 'plan-up') ?>", 6);
                    $('.event-register-form input.required').css('border-color', '<?php echo esc_js($theme_primary_color); ?>');
                }else{
                    var check;
                    if($('form.event-register-form input[name=MAILCHIMP]').is(':checked')){
                        check = 'checked';
                    }else{
                        check = 'unchecked';
                    }
                    jQuery.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
                        dataType: 'json',
                        data: ({
                            action: 'do_maker',
                            step: 'register',
                            first_name: $('form.event-register-form input[name=first_name]').val(),
                            last_name: $('form.event-register-form input[name=last_name]').val(),
                            phone: $('form.event-register-form input[name=PHONE]').val(),
                            register_email: $('form.event-register-form input[name=email]').val(),
                            ticket: $('form.event-register-form select[name=amount] option:selected').text(),
                            amount: $('form.event-register-form select[name=amount] option:selected').val(),
                            currency: 'USD',
                            quantity: $('form.event-register-form input[name=quantity]').val(),
                            payment_method: 'PayPal',
                            news_register: check,
                        }),
                        success: function(res) {
                            var amount = $('form.event-register-form select[name=amount] option:selected').val();
                            if( amount > 0 ){
                                notie.alert(1, "<?php _e('Successfully, please wait for the website to redirect you to payment system!', 'plan-up'); ?>", 5);
                                return_url = $('form.event-register-form input[name=return]').val()+"&customer_id="+res['customer_id'];
                                $('form.event-register-form input[name=return]').val(return_url);
                                setTimeout(function() {
                                    $('form.event-register-form').trigger('submit');
                                }, 5000);
                            }else{//Free ticket selected
                                notie.alert(1, "<?php _e('Successfully!', 'plan-up'); ?>", 5);
                                var mailchimp = $('form.event-register-form input[name=mail_chimp]').val();
                                var mailchimp = $('form.event-register-form input[name=mail_chimp]').val();
                                if( mailchimp != ''  && $('form.event-register-form input[name=MAILCHIMP]').is(':checked') ){//Has mailchimp
                                    $('form.event-register-form').attr('action', mailchimp);
                                    $('form.event-register-form input[name=FNAME]').val($('form.event-register-form input[name=first_name]').val());
                                    $('form.event-register-form input[name=LNAME]').val($('form.event-register-form input[name=last_name]').val());
                                    $('form.event-register-form input[name=EMAIL]').val($('form.event-register-form input[name=email]').val());
                                    setTimeout(function() {
                                        $('form.event-register-form').trigger('submit');
                                    }, 5000);
                                }else{//No mailchimp
                                    setTimeout(function() {
                                        location.reload();
                                    }, 5000);
                                }
                            }
                        },
                        error: function(res) {
                            notie.alert(3, '<?php echo __("Register fail, something wrong!", "plan-up"); ?>', 3);
                        }
                    });
                    return false;
                }
            });
        }
        //Show/hide ajax loading gif
        var loading = $('form.event-register-form input[type=submit]').val();
        $('form.event-register-form input[type=submit]').bind('ajaxStart', function(){
            $(this).val("<?php echo esc_html__('Processing...', 'plan-up'); ?>");
        }).bind('ajaxStop', function(){
            $(this).val(loading);
        });
    })(jQuery);
  </script>
<?php

}