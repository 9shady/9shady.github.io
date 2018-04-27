<?php
$options = array(
    'speakers' => array(
        'type' => 'box',
        'title' => esc_html__('Speaker information', 'plan-up'),
        'options' => array(
            'name' => array(
                'type' => 'text',
                'label' => esc_html__('Name', 'plan-up')
            ),
            'position' => array(
                'type' => 'text',
                'label' => esc_html__( 'Position', 'plan-up' ),
            ),
            'social' => array(
                'label' => esc_html__( 'Social Network', 'plan-up' ),
                'desc'  => esc_html__( 'Example: '.htmlspecialchars('<a href="#" class="fa fa-linkedin-square"></a> <a href="#" class="fa fa-facebook-official"></a>'), 'plan-up' ),
                'type'  => 'textarea',
                'value' => ''
            ),
        )
    )
);
?>