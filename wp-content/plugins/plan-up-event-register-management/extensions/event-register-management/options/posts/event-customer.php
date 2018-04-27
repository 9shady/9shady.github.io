<?php
$options = array(
    'event_customer_metadata' => array(
        'type' => 'box',
        'title' => esc_html__( 'Customer Data', 'plan-up' ),
        'options' => array(
            'checked' => array(
                'type' => 'checkbox',
                'value' => false,
                'text' => false,
                'desc' => esc_html__('Check the box to mark the registration has been checked.', 'plan-up')
            ),
            'first_name' => array(
                'type' => 'text',
                'label' => esc_html__( 'First Name', 'plan-up' ),
            ),
            'last_name' => array(
                'type' => 'text',
                'label' => esc_html__( 'Last name', 'plan-up' ),
            ),
            'register_email' => array(
                'type' => 'text',
                'label' => esc_html__( 'Registerd Email', 'plan-up' )
            ),
            'phone' => array(
                'type' => 'text',
                'label' => esc_html__( 'Phone', 'plan-up' ),
            ),
            'ticket' => array(
                'type' => 'text',
                'label' => esc_html__( 'Ticket', 'plan-up' ),
            ),
            'quantity' => array(
                'type' => 'text',
                'label' => esc_html__( 'Number of tickets', 'plan-up' ),
            ),
            'total' => array(
                'type' => 'text',
                'label' => esc_html__( 'Total value', 'plan-up' ),
            ),
            'currency' => array(
                'type' => 'text',
                'label' => esc_html__( 'Currency code', 'plan-up' ),
            ),
            'payment_method' => array(
                'type' => 'text',
                'label' => esc_html__( 'Payment method', 'plan-up' ),
            ),
            'payment_status' => array(
                'type' => 'select',
                'label' => esc_html__( 'Payment Status', 'plan-up' ),
                'value' => esc_html__('Not paid yet', 'plan-up'),
                'choices' => array(
                    esc_html__('Paid - Paypal', 'plan-up') => esc_html__('Paid - Paypal', 'plan-up'),
                    esc_html__('Paid - Stripe', 'plan-up') => esc_html__('Paid - Stripe', 'plan-up'),
                    esc_html__('Not paid yet', 'plan-up')   => esc_html__('Not paid yet', 'plan-up')
                )
            ),
            'paypal_account' => array(
                'type' => 'text',
                'label' => esc_html__('Customer paypal account', 'plan-up'),
                'desc' => esc_html__('Applying only for method is Paypal and paid with Paypal account', 'plan-up')
            ),
            'news_register' => array(
                'type' => 'text',
                'label' => esc_html__( 'News register', 'plan-up' ),
            )
        )
    )
);
?>