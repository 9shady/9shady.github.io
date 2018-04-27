<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
$options = array(
    'mail_notification' => array(
        'type' => 'tab',
        'title' => esc_html__('Mail Noti', 'plan-up'),
        'options' => array(
            'mail_noti' => array(
                'type' => 'text',
                'label' => esc_html__('Notification Email', 'plan-up'),
                'desc' => esc_html__('This email will receive notification when a registration made', 'plan-up')
            ),
            'mail_headers' => array(
                'type' => 'text',
                'label' => esc_html__('Mail headers', 'plan-up'),
                'value' => 'From: '.get_bloginfo('name').' team <team@info.com>',
                'desc' => esc_html__('Eg: From: Team Name <team@info.com>', 'plan-up')
            ),
            'mail_template' => array(
                'type' => 'textarea',
                'label' => esc_html__('Mail template', 'plan-up'),
                'value' => "{first_name}\n{last_name}\n{email}\n{phone}\nTicket: {ticket}",
                'desc' => esc_html__('Use {first_name} {last_name} {email} {phone} {total} {ticket} in your notification template', 'plan-up')
            )
        )
    )
);