<?php
add_action('init','init_visual_composer_custom',1000);
function init_visual_composer_custom(){
    if(function_exists('vc_map')){

      vc_map( array(
       "name" => __("schedule", TEXT_DOMAIN_SHORTCODE),
       "base" => "schedule",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "icon" => "icon-qk",   
       "params" => array(
        
        
        array(
             "type" => "textarea",
             "holder" => "div",
             "class" => "",
             "heading" => __("Slug Array. Only insert level 1 of schedule category",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "array_slug",
             "value" => "",
             "description" => __('Insert slug of level 1 category. for instance: day-01, day-02, day-03, day-04<br/>You will find all category slug in Schedule >> Categories',TEXT_DOMAIN_SHORTCODE)
        ),

       array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_schedule_order_by',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "schedule_count",
               "value" => "100",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_thumbnail",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display border gray with speaker",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_thumbnail_border_gray",
             "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Time",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_time",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Button Cricle",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_button_cricle",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Author",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_author",
             "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Author Job",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_author_job",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Description",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_desc",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display link title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_link_title",
             "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Word Count dipplay in intro description",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_count_word",
             "value" => '30'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Icon Time",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "schedule_icon_time",
               "value" => "fa-clock-o",
               "description" => 'Insert class to use for your style'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Icon Microphone",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "schedule_icon_microphone",
               "value" => "fa-microphone",
               "description" => 'Insert class to use for your style'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            )
        

       )
      ) );
      
      vc_map( array(
       "name" => __("Schedule 2", TEXT_DOMAIN_SHORTCODE),
       "base" => "imevent_schedule2",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "icon" => "icon-qk",   
       "params" => array(
        
        
        array(
             "type" => "textarea",
             "holder" => "div",
             "class" => "",
             "heading" => __("Slug Array. Only insert level 1 of schedule category",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "array_slug",
             "value" => "",
             "description" => __('Insert slug of level 1 category. for instance: day-01, day-02, day-03, day-04<br/>You will find all category slug in Schedule >> Categories',TEXT_DOMAIN_SHORTCODE)
        ),

       array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_schedule_order_by',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "schedule_count",
               "value" => "100",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_thumbnail",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
         
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Time",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_time",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Author",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_author",
             "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
         
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Description",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_desc",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Address",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_display_address",
              "value" => array(   
                    __('true', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('false', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("speaker text",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speaker_text",
             "value" => "speaker"
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Count word",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "schedule_count_word",
             "value" => "30"
          ),
          
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            )
        

       )
      ) );

      vc_map( array(
         "name" => __("sponsors", TEXT_DOMAIN_SHORTCODE),
         "base" => "sponsors",
         "as_parent" => array('only' => 'item_sponsors'),
         "js_view" => 'VcColumnView',
         "content_element" => true,
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Auto slide",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "auto",
             "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('False', TEXT_DOMAIN_SHORTCODE) => 'false',
                    ),
             "default"  => 'true'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("show navigation",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "show_nav",
             "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('False', TEXT_DOMAIN_SHORTCODE) => 'false',
                    ),
             "default"  => 'true'
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display count item in each slide",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "itemslide", 
             "value"  => '5'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Loop",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "loop",
             "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('False', TEXT_DOMAIN_SHORTCODE) => 'false',
                    ),
             "default"  => 'true'
          ),
          array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Time switch each the slide",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "autoplaytimeout",
               "value" => "3000",
               "description" => __("Time switch each the slide. For example 3000ms=3s",TEXT_DOMAIN_SHORTCODE)
            ),
          array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Animation",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "animation",
               "value" => "fadeInUp",
               "description" => __('For example: fadeInUp. You can find animation here: http://daneden.github.io/animate.css/', TEXT_DOMAIN_SHORTCODE)
            ),
          array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Animation delay (ms)",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "animation_delay",
               "value" => "300",
               "description" => __('For example: 300', TEXT_DOMAIN_SHORTCODE)
            )
          
          

         )
      ) );

      vc_map( array(
         "name" => __("item sponsors", TEXT_DOMAIN_SHORTCODE),
         "base" => "item_sponsors",
         "content_element" => true,
         "as_child" => array('only' => 'sponsors'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
             "type" => "attach_image",
             "holder" => "div",
             "class" => "",
             "heading" => __("Thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "thumbnail",
             "value" => ""
          ),
          array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Link",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "link",
               "value" => ""
            ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Link Target",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "target",
             "value" => array(   
                    __('_blank', TEXT_DOMAIN_SHORTCODE) => 'New Window',
                    __('_self', TEXT_DOMAIN_SHORTCODE) => 'Self',
                    ),
             "default"  => '_blank'
          ),
          array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Alt",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "alt",
               "value" => ""
            )

         )
      ) );  

      
      if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
          class WPBakeryShortCode_sponsors extends WPBakeryShortCodesContainer {
          }
      }
      if ( class_exists( 'WPBakeryShortCode' ) ) {
          class WPBakeryShortCode_item_sponsors extends WPBakeryShortCode {
          }
      }


      vc_map( array(
       "name" => __("New Address", TEXT_DOMAIN_SHORTCODE),
       "base" => "address_parent",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "as_parent" => array('only' => 'address_item'),
       "js_view" => 'VcColumnView',
       "icon" => "icon-qk",   
       "params" => array(

          array(
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => __("Background color",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "background_color",
               "value" => "#0d1d31",
               "description" => 'Insert background color'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
          )
       
      )));

      vc_map( array(
       "name" => __("Address Item", TEXT_DOMAIN_SHORTCODE),
       "base" => "address_item",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "as_child" => array('only' => 'address_parent'),
       "icon" => "icon-qk",   
       "params" => array(

        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Font awesome",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "font_awesome",
             "value" => "",
             "description" => 'For example: fa-heart. You can find here: http://fontawesome.io/cheatsheet/'
        ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "title",
             "value" => "",
             "description" => 'For example: Date'
        ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Icon direct",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "icon_direct",
             "value" => array(   
                    __('Left', TEXT_DOMAIN_SHORTCODE) => 'pull-left',
                    __('Right', TEXT_DOMAIN_SHORTCODE) => 'pull-right'
                    ),
             "default"  => 'pull-left'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Date",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "date",
             "value" => "",
             "description" => 'For example: December 10-08-2015'
        ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Column Width",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "column_width",
             "value" => array(   
                    __('3 columns', TEXT_DOMAIN_SHORTCODE) => '3',
                    __('1 column', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('2 columns', TEXT_DOMAIN_SHORTCODE) => '2',
                    __('4 columns', TEXT_DOMAIN_SHORTCODE) => '4',
                    __('5 columns', TEXT_DOMAIN_SHORTCODE) => '5',
                    __('6 columns', TEXT_DOMAIN_SHORTCODE) => '6',
                    __('7 columns', TEXT_DOMAIN_SHORTCODE) => '7',
                    __('8 columns', TEXT_DOMAIN_SHORTCODE) => '8',
                    __('9 columns', TEXT_DOMAIN_SHORTCODE) => '9',
                    __('10 columns', TEXT_DOMAIN_SHORTCODE) => '10',
                    __('11 columns', TEXT_DOMAIN_SHORTCODE) => '11',
                    __('12 columns', TEXT_DOMAIN_SHORTCODE) => '12',
                    ),
             "default"  => '3'
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "Class",
             "value" => ""
             
        ),
        
       
      )));

      if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
          class WPBakeryShortCode_address_parent extends WPBakeryShortCodesContainer {
          }
      }
      if ( class_exists( 'WPBakeryShortCode' ) ) {
          class WPBakeryShortCode_address_item extends WPBakeryShortCode {
          }
      }
      
      vc_map( array(
         "name" => __("Testimonial", TEXT_DOMAIN_SHORTCODE),
         "base" => "testimonial",
         "as_parent" => array('only' => 'item_testimonial'),
         "js_view" => 'VcColumnView',
         "content_element" => true,
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(

            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Time swich each slide (ms)",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "timeout",
               "value" => "",
               "description" => 'For example: 3000. 3000ms=3s',
               "value"    => '3000'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Auto",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "auto",
               "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'True',
                    __('false', TEXT_DOMAIN_SHORTCODE) => 'false'
                    ),
              "default"  => 'true'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Loop",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "loop",
               "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'True',
                    __('false', TEXT_DOMAIN_SHORTCODE) => 'false'
                    ),
              "default"  => 'true'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert Class'
               
            ),

      )));
      
      vc_map( array(
         "name" => __("Item testimonial", TEXT_DOMAIN_SHORTCODE),
         "base" => "item_testimonial",
         "as_child" => array('only' => 'testimonial'),
         "content_element" => true,
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(

            array(
               "type" => "attach_image",
               "holder" => "div",
               "class" => "",
               "heading" => __("Thumbnail",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "thumbnail",
               "value" => ""
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Alt for thumbnail",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "alt",
               "value" => ""
               
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Author",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "author",
               "value" => ""
               
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Style",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "style",
               "value" => array(   
                    __('Hexagon', TEXT_DOMAIN_SHORTCODE) => 'rhex',
                    __('Circle', TEXT_DOMAIN_SHORTCODE) => 'crcle',
                    __('Square', TEXT_DOMAIN_SHORTCODE) => 'wohex'
                    ),
              "default"  => 'rhex',
              "description" => 'Choose style to display'
               
            ),
            array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Content",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "content",
               "value" => "",
               "description" => 'Insert content for testimonial'
            ),

      )));

      if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
          class WPBakeryShortCode_testimonial extends WPBakeryShortCodesContainer {
          }
      }
      if ( class_exists( 'WPBakeryShortCode' ) ) {
          class WPBakeryShortCode_item_testimonial extends WPBakeryShortCode {
          }
      }




       $args_speaker = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'slug',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'group',
        'pad_counts'               => false 

      );    
      $categories_speakergroup = get_categories($args_speaker);
      $cate_array_speakergroup = array();
      $empty_speakergroup = array("Select Speaker category" => "");
      if ($categories_speakergroup) {
      foreach ( $categories_speakergroup as $cate ) {
        $cate_array_speakergroup[$cate->cat_name] = $cate->slug;
      }
      } else {
      $cate_array_speakergroup["No content Category found"] = 0;
      }  


      vc_map( array(
         "name" => __("speaker", TEXT_DOMAIN_SHORTCODE),
         "base" => "speaker",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Slug",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "slug",
               "value" => array_merge($empty_speakergroup,$cate_array_speakergroup)
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Style",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "style",
             "value" => array(   
                    __('Hexagon', TEXT_DOMAIN_SHORTCODE) => 'rhex',
                    __('Circle', TEXT_DOMAIN_SHORTCODE) => 'crcle',
                    __('Square', TEXT_DOMAIN_SHORTCODE) => 'wohex',
                    ),
             "default"  => 'rhex'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Column",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "column",
             "value" => array(
                    __('4 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-3 col-sm-6',
                    __('1 item in row',TEXT_DOMAIN_SHORTCODE)  => 'col-md-12 col-sm-12',
                    __('2 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-6 col-sm-6',
                    __('3 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-4 col-sm-4',
                    __('5 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-2 col-sm-6 col-5',
                    __('6 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-2 col-sm-6',
                    ),
             "default"  => 'col-md-3 col-sm-6'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speaker_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_speaker_order_by',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speaker_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "speakers_item_count",
               "value" => "30",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display job",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_display_job",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Description",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_display_intro_description",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display Link",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_speaker_link",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Remove zoom thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_remove_zoom_thumbnail",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Remove zoom background thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_remove_background_thumbnail",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Word count display in description",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_desc_count",
             "value" => "12"
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            ),

         
      )));



      $args_faq = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'slug',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'faqgroup',
        'pad_counts'               => false 

      );    
      $categories_faqgroup = get_categories($args_faq);
      $cate_array_faqgroup = array();
      $empty_faqgroup = array("Select Faq category" => "");
      if ($categories_faqgroup) {
        foreach ( $categories_faqgroup as $cate ) {
          $cate_array_faqgroup[$cate->cat_name] = $cate->slug;
        }
      } else {
        $cate_array_faqgroup["No content Category found"] = 0;
      }  

      vc_map( array(
         "name" => __("faq", TEXT_DOMAIN_SHORTCODE),
         "base" => "faq",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Slug",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "slug",
             "value" => array_merge($empty_faqgroup,$cate_array_faqgroup)
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Style",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "style",
             "value" => array(
                    __('Style 1',TEXT_DOMAIN_SHORTCODE) => 'style1',
                    __('Style 2',TEXT_DOMAIN_SHORTCODE)  => 'style2'
                    ),
             "default"  => 'style1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "faq_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_faq_order_by',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "faq_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "faq_item_count",
               "value" => "100",               
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class to use for your style'
          )
         
      )));
  
      $args_slidegroup = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'slug',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'exclude'                  => '',
        'include'                  => '',
        'number'                   => '',
        'taxonomy'                 => 'slidegroup',
        'pad_counts'               => false 

      );    
      $categories_slidegroup = get_categories($args_slidegroup);
      $cate_array_slidegroup = array();
      $empty_slidegroup = array("Select slide category" => "");
      if ($categories_slidegroup) {
        foreach ( $categories_slidegroup as $cate ) {
          $cate_array_slidegroup[$cate->cat_name] = $cate->slug;
        }
      } else {
        $cate_array_slidegroup["No content Category found"] = 0;
      }

      
      vc_map( array(
         "name" => __("slideshow", TEXT_DOMAIN_SHORTCODE),
         "base" => "slideshow",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Slug Group",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "slug_group",
               "value" => array_merge($empty_slidegroup,$cate_array_slidegroup),
               "description" => 'Add slide: From Left Sidebar >> Slideshows >> Add New Slide'
          ),
          
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "slideshow_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_slideshow_order',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "slideshow_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "slideshow_item_count",
               "value" => "10",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Auto Slider",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "auto_slider",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('No', TEXT_DOMAIN_SHORTCODE) => 'false',                    
                    ),
             "default" => 'true'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Duration when auto play slider ms. 3000ms = 3s",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "duration",
               "value" => "3000",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Show navigation",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "navigation",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('No', TEXT_DOMAIN_SHORTCODE) => 'false',                    
                    ),
             "default" => 'true'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Loop",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "loop",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('No', TEXT_DOMAIN_SHORTCODE) => 'false',                    
                    ),
             "default" => 'true'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("height desk",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "height_desk",
               "value" => "768px",
               "description" => 'Insert 768px or fullheight'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("height ipad",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "height_ipad",
               "value" => "768px",
               "description" => 'Insert 768px or fullheight'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("height mobile",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "height_mobile",
               "value" => "800px",
               "description" => 'Insert 768px or fullheight'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            )

         )
      ) );



      vc_map( array(
         "name" => __("slideshow multi background", TEXT_DOMAIN_SHORTCODE),
         "base" => "slideshow_two",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Slug Group",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "slug_group",
               "value" => array_merge($empty_slidegroup,$cate_array_slidegroup),
               "description" => 'Add slide: From Left Sidebar >> Slideshows >> Add New Slide'
          ),
          
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "slideshow_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_slideshow_order',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "slideshow_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "slideshow_item_count",
               "value" => "10",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Auto Slider",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "auto_slider",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('No', TEXT_DOMAIN_SHORTCODE) => 'false',                    
                    ),
             "default" => 'true'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Duration when auto play slider ms. 3000ms = 3s",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "duration",
               "value" => "3000",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Show navigation",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "navigation",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('No', TEXT_DOMAIN_SHORTCODE) => 'false',                    
                    ),
             "default" => 'true'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Loop",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "loop",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => 'true',
                    __('No', TEXT_DOMAIN_SHORTCODE) => 'false',                    
                    ),
             "default" => 'true'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("height desk",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "height_desk",
               "value" => "768px",
               "description" => 'Insert 768px or fullheight'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("height ipad",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "height_ipad",
               "value" => "768px",
               "description" => 'Insert 768px or fullheight'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("height mobile",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "height_mobile",
               "value" => "800px",
               "description" => 'Insert 768px or fullheight'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            )

         )
      ) );

      vc_map( array(
         "name" => __("Old Address", TEXT_DOMAIN_SHORTCODE),
         "base" => "address",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Date",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "date",
               "value" => "",
               "description" => 'For instance: December 17-22, 2014'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Location",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "location",
               "value" => "",
               "description" => 'Insert localtion. For instance: 3200 Barbaros Bulvari Besiktas/Istanbul, TR '
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("REMAINING",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "remaining",
               "value" => "",
               "description" => 'Insert localtion. For instance: 245 Tickets '
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Speakers",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "speakers",
               "value" => "",
               "description" => 'Insert Speakers Text. For instance: 24 Professional Speakers '
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            )
         )
      ) );

      vc_map( array(
       "name" => __("heading", TEXT_DOMAIN_SHORTCODE),
       "base" => "heading",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "icon" => "icon-qk",   
       "params" => array(
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "title",
             "value" => ""
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Sub Title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "subtitle",
             "value" => ""
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("FontAwesome",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "fontclass",
             "value" => "",
             "description" => 'You can find fontclass here: http://fontawesome.io/icons/ For instance: fa-star'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Delay",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "delay",
             "value" => "",
             "description" => 'Insert time delay to display: For instance: 300'
          ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Icon style",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "icon_style",
             "value" => array(   
                    __('Hexagon', TEXT_DOMAIN_SHORTCODE) => 'rhex',
                    __('Circle', TEXT_DOMAIN_SHORTCODE) => 'crcle',
                    __('Square', TEXT_DOMAIN_SHORTCODE) => 'wohex',

                    ),
             "default"  => 'rhex'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "class",
             "value" => ""
          ),
        
       )
      ) );

      vc_map( array(
       "name" => __("Heading normal", TEXT_DOMAIN_SHORTCODE),
       "base" => "heading_normal",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "icon" => "icon-qk",   
       "params" => array(
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "title",
             "value" => "",
             "description" => 'Insert Title'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Sub Title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "subtitle",
             "value" => "",
             "description" => 'Insert Sub Title'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Fontclass 1",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "fontclass1",
             "value" => "",
             "description" => 'Insert class of fontawesome: For instance: fa-star'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Fontclass 2",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "fontclass2",
             "value" => "",
             "description" => 'Insert class of fontawesome: For instance: fa-star'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Delay",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "delay",
             "value" => "",
             "description" => 'Insert time delay to display: For instance: 300'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class'
          ),
        
       )
      ) );      

      vc_map( array(
       "name" => __("thumbnail", TEXT_DOMAIN_SHORTCODE),
       "base" => "thumbnail",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "icon" => "icon-qk",   
       "params" => array(
        array(
             "type" => "attach_image",
             "holder" => "div",
             "class" => "",
             "heading" => __("Path of thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "thumbnail",
             "value" => "",
             "description" => 'You should use square image. For example: 228x150 px'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Alt of thumbnail",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "alt",
             "value" => ""
          ),
        array(
             "type" => "attach_image",
             "holder" => "div",
             "class" => "",
             "heading" => __("Path Image for popup",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "pathimage",
             "value" => ""
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Path Video for popup",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "pathvideo",
             "value" => "",
             "description" => 'Use video popup: Vimeo like http://vimeo.com/23534361, <br/>Youtube like https://www.youtube.com/watch?v=hpeYWdkUtcE'
          ),
         array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class to use for your style'
          ),
        
        
       )
      ) );

      vc_map( array(
       "name" => __("button", TEXT_DOMAIN_SHORTCODE),
       "base" => "button",
       "class" => "",
       "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
       "icon" => "icon-qk",   
       "params" => array(
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "title",
             "value" => "",
             "description" => 'Title'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Link",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "link",
             "value" => "",
             "description" => 'Link'
          ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Target",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "target",
             "value" => array(   
                    __('New Window', TEXT_DOMAIN_SHORTCODE) => 'blank',
                    __('Inline Page', TEXT_DOMAIN_SHORTCODE) => 'inline',
                    __('Scroll To', TEXT_DOMAIN_SHORTCODE) => 'scrollto',
                    ),
             "description" => 'Select target',
             "default" => "blank"
          ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Show Icon",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "showicon",
             "value" => array(   
                    __('Left Position', TEXT_DOMAIN_SHORTCODE) => 'left',
                    __('Right Position', TEXT_DOMAIN_SHORTCODE) => 'right',
                    __('none', TEXT_DOMAIN_SHORTCODE) => 'none',
                    ),
             "description" => 'You can choose display left, right, or dont display',
             "default" => "left"
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Fontawesome",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "fontawesome",
             "value" => "",
             "description" => 'Insert fontawesome. You can find it here: http://fortawesome.github.io/Font-Awesome/icons/'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Margin",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "margin",
             "value" => "",
             "description" => 'Insert value for top right bottom left. For instance 0px 0px 0px 20px'
          ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class'
          ),
        
       )
      ) );
      
      vc_map( array(
         "name" => __("buttonpopup", TEXT_DOMAIN_SHORTCODE),
         "base" => "buttonpopup",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Title",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "title",
               "value" => "",
               "description" => 'Title'
            ),
          array(
               "type" => "attach_image",
               "holder" => "div",
               "class" => "",
               "heading" => __("Image Path",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "imagepath",
               "value" => "",
               "description" => 'Link Image'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Video Path",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "videopath",
               "value" => "",
               "description" => 'Insert link video: vimeo, youtube'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Margin",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "margin",
               "value" => "",
               "description" => 'Insert value for top right bottom left. For instance 0px 0px 0px 20px'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class'
            ),
          
         )
      ) );
      
      vc_map( array(
         "name" => __("makedonation", TEXT_DOMAIN_SHORTCODE),
         "base" => "makedonation",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Title",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "title",
               "value" => "",
               "description" => 'Title'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Paypal email",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "paypalemail",
               "value" => "",
               "description" => 'Identify your business so that you can collect the payments.'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Amount",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "amount",
               "value" => "",
               "description" => 'Insert amount. For instance 25'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Currency code",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "currency_code",
               "value" => "",
               "description" => 'Insert Currency. For instance USD'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert Class'
            ),
         
          
         )
      ) );
      
      
      $args_blog = array(
        'orderby' => 'name',
        'order' => 'ASC'
        );
      $categories_blog = get_categories($args_blog);
      $cate_array = array();$arrayCateAll = array('All categories ' => '' );
      if ($categories_blog) {
        foreach ( $categories_blog as $cate ) {
          $cate_array[$cate->cat_name] = $cate->cat_ID;
        }
      } else {
        $cate_array["No content Category found"] = 0;
      }
      
      vc_map( array(
         "name" => __("latestblog", TEXT_DOMAIN_SHORTCODE),
         "base" => "latestblog",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(

          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Category",'events'),
               "param_name" => "category",
               "value" => array_merge($arrayCateAll,$cate_array),
               "description" => __("Choose a Content Category from the drop down list.", 'events')
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "count",
               "value" => "3",
               "description" => 'Post Count'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Show date",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "showdate",
               "value" => array(   
                      __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('False', TEXT_DOMAIN_SHORTCODE) => 'false',                
                      ),
               "description" => 'Show date',
               "default" => "true"
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Show comment",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "showcomment",
               "value" => array(   
                      __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('False', TEXT_DOMAIN_SHORTCODE) => 'false',
                      ),
               "description" => 'Show Comment',
               "default" => "true"
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Show Description",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "showdescription",
               "value" => array(   
                      __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('False', TEXT_DOMAIN_SHORTCODE) => 'false',
                      ),
               "description" => 'Show Description',
               "default" => "true"
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Show Readmore",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "showreadmore",
               "value" => array(   
                      __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('False', TEXT_DOMAIN_SHORTCODE) => 'false',                
                      ),
               "description" => 'Show Read More',
               "default" => "true"
            ),
          

         )
      ) );
      
      vc_map( array(
         "name" => __("location", TEXT_DOMAIN_SHORTCODE),
         "base" => "location",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Defineid",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "defineid",
               "value" => "map-canvas",
               "description" => 'Insert id to display map. For instance: map-canvas'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Latitude",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "latitude",
               "value" => "40.9807648",
               "description" => 'Insert latitude parameter for google map. For instance: 40.9807648'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Longitude",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "longitude",
               "value" => "28.9866516",
               "description" => 'Insert longitude parameter for google map. For instance: 28.9866516'
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Zoom",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "zoom",
               "value" => "12",
               "description" => 'Insert zoom parameter for google map. Default 12'
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Marker title",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "marker_title",
               "value" => "",
               "description" => __('Insert marker title', TEXT_DOMAIN_SHORTCODE)
            ), 
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Heading",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "heading",
               "value" => "",
               "description" => 'Insert heading'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("fontclass",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "fontclass",
               "value" => "",
               "description" => 'Insert fontawesome class beside heading'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("fontclass2 if you choose Style Icon is valentine",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "fontclass2",
               "value" => "",
               "description" => 'Insert fontawesome class beside heading'
            ),
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Style Icon",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "style_icon",
               "value" => array(   
                    __('Hexagon', TEXT_DOMAIN_SHORTCODE) => 'rhex',
                    __('Circle', TEXT_DOMAIN_SHORTCODE) => 'crcle',
                    __('Square', TEXT_DOMAIN_SHORTCODE) => 'wohex',
                    __('Valentine', TEXT_DOMAIN_SHORTCODE) => 'valentine'
                    ),
              "default"  => 'rhex',
              "description" => 'Choose style to display'
               
            ),
          array(
               "type" => "textarea_html",
               "holder" => "div",
               "class" => "",
               "heading" => __("Main Content",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "content",
               "value" => "",
               "description" => 'Insert main content'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Button name",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "button_name",
               "value" => "",
               "description" => 'Insert button name'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("button_font_class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "button_font_class",
               "value" => "",
               "description" => 'Insert awesome class beside button'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Button link",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "button_link",
               "value" => "",
               "description" => 'Insert button link'
            ),
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Target Link",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "target_link",
               "value" => array(   
                    __('Same window', TEXT_DOMAIN_SHORTCODE) => '_self',
                    __('New Window', TEXT_DOMAIN_SHORTCODE) => '_blank'
                    ),
              "default"  => '_self'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class'
            ),
          
          
         )
      ) );


    vc_map( array(
     "name" => __("Iframe Eventbrite", 'imevent'),
     "base" => "imevent_iframe_eventbrite",
     "class" => "",
     "category" => __("My shortcode", 'imevent'),
     "icon" => "icon-qk",   
     "params" => array(
      
      
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert ID of event at eventbrite.com",'imevent'),
             "description" => "Find ID. This is your event url: https://www.eventbrite.com/e/sell-imevent-wordpress-theme-tickets-18691767580 => ID is 18691767580",
             "param_name" => "id",
             "value" => "",               
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Class",'imevent'),
           "param_name" => "class",
           "value" => ""
        ),

    )));


    vc_map( array(
     "name" => __("Banner", 'imevent'),
     "base" => "imevent_banner",
     "class" => "",
     "category" => __("My shortcode", 'imevent'),
     "icon" => "icon-qk",
     "params" => array(

      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title",'imevent'),
             "param_name" => "title",
             "value" => "",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("sub title",'imevent'),
             "param_name" => "subtitle",
             "value" => "",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert year of countdown",'imevent'),
             "param_name" => "end_date_y",
             "value" => "",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert month of countdown",'imevent'),
             "param_name" => "end_date_m",
             "value" => "",               
      ),
       array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert date of countdown",'imevent'),
             "param_name" => "end_date_d",
             "value" => "",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert hour of countdown like 0,1,2,3...23",'imevent'),
             "param_name" => "end_date_h",
             "value" => "",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert minutes of countdown like 0,1,2,3....59",'imevent'),
             "param_name" => "end_date_i",
             "value" => "",               
      ),
     
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert timezone of countdown<br/>The timezone (hours or minutes from GMT) for the target times. <br/>
For instance:<br/>
If Timezone is UTC-9:00 you have to insert -9 <br/>
If Timezone is UTC-9:30, you have to insert -9*60+30=-570. <br/>
Read about UTC Time: http://en.wikipedia.org/wiki/List_of_UTC_time_offsets",'imevent'),
             "param_name" => "timezone",
             "value" => "0",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Insert date format of countdown<br/>Display Format: dHMS. <br/>
d: Day <br/>
H: Hour <br/>
M: Month <br/>
S: Second. <br/>
You can insert HMS or dHM or dH. default dHMS",'imevent'),
             "param_name" => "display_format",
             "value" => "dHMS",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("years",'imevent'),
             "param_name" => "years",
             "value" => "years",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("months",'imevent'),
             "param_name" => "months",
             "value" => "months",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("weeks",'imevent'),
             "param_name" => "weeks",
             "value" => "weeks",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("days",'imevent'),
             "param_name" => "days",
             "value" => "days",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("hours",'imevent'),
             "param_name" => "hours",
             "value" => "hours",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("minutes",'imevent'),
             "param_name" => "minutes",
             "value" => "minutes",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("seconds",'imevent'),
             "param_name" => "seconds",
             "value" => "seconds",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("year",'imevent'),
             "param_name" => "year",
             "value" => "year",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("month",'imevent'),
             "param_name" => "month",
             "value" => "month",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("week",'imevent'),
             "param_name" => "week",
             "value" => "week",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("day",'imevent'),
             "param_name" => "day",
             "value" => "day",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("hour",'imevent'),
             "param_name" => "hour",
             "value" => "hour",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("minute",'imevent'),
             "param_name" => "minute",
             "value" => "minute",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("second",'imevent'),
             "param_name" => "second",
             "value" => "second",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("register button text",'imevent'),
             "param_name" => "register_text",
             "value" => "",               
      ),
      array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("register button link",'imevent'),
             "param_name" => "register_link",
             "value" => "",               
      ),

      array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => __("Class",'imevent'),
           "param_name" => "class",
           "value" => ""
      ),


    )));



      
    vc_map( array(
       "name" => __("Latest event", 'imevent'),
       "base" => "imevent_latest_event",
       "as_parent" => array('only' => 'imevent_latest_event_item'),
       "js_view" => 'VcColumnView',
       "content_element" => true,
       "class" => "",
       "category" => __("My shortcode", 'imevent'),
       "icon" => "icon-qk",   
       "params" => array(

          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("title",'imevent'),
             "param_name" => "title",
             "value" => "",
             "value"    => ''
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",'imevent'),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert Class'
             
          ),

    )));

    vc_map( array(
       "name" => __("Latest event item", 'imevent'),
       "base" => "imevent_latest_event_item",
       "as_child" => array('only' => 'imevent_latest_event'),
       "content_element" => true,
       "class" => "",
       "category" => __("My shortcode", 'imevent'),
       "icon" => "icon-qk",   
       "params" => array(

          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("icon",'imevent'),
             "param_name" => "icon",
             "value" => "",
             "description" => 'Insert fontawesome: fa-star. You can find here: http://fontawesome.io/cheatsheet/'
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("title",'imevent'),
             "param_name" => "title",
             "value" => "",
             "description" => ''
             
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Sub title",'imevent'),
             "param_name" => "subtitle",
             "value" => "",
             "description" => ''
             
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Column",'imevent'),
             "param_name" => "column",
             "value" => array(   
                  __('1 column', 'imevent') => 'col-sm-12',
                  __('2 columns', 'imevent') => 'col-sm-6',
                  __('3 columns', 'imevent') => 'col-sm-4',
                  __('4 columns', 'imevent') => 'col-sm-3'
                  ),
            "default"  => 'col-sm-6'
          ),
          array(
             "type" => "textarea",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",'imevent'),
             "param_name" => "class",
             "value" => ""
          ),

    )));

    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_imevent_latest_event extends WPBakeryShortCodesContainer {
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_imevent_latest_event_item extends WPBakeryShortCode {
        }
    }



    vc_map( array(
       "name" => __("Heading 2", 'imevent'),
       "base" => "imevent_heading",
       "class" => "",
       "category" => __("My shortcode", 'imevent'),
       "icon" => "icon-qk",   
       "params" => array(
        
        
        array(
             "type" => "textarea_html",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title",'imevent'),
             "param_name" => "content",
             "value" => "",
             "description" => 'Welcom To &lt;span class=&quot;theme-color&quot;&gt; Jevent &lt;/span&gt;'
        ),
        array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Show line",'imevent'),
             "param_name" => "line",
             "value" => array(
                "yes" => "yes",
                "no"  => "now"
              ),
             "default" => "yes"
        ),

        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",'imevent'),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class to use for your style'
        )
        

       
      )));

      vc_map( array(
       "name" => __("About", 'imevent'),
       "base" => "imevent_about",
       "class" => "",
       "category" => __("My shortcode", 'imevent'),
       "icon" => "icon-qk",   
       "params" => array(
        
        
        array(
             "type" => "attach_image",
             "holder" => "div",
             "class" => "",
             "heading" => __("Image",'imevent'),
             "param_name" => "img",
             "value" => ""
        ),
        array(
             "type" => "textarea_html",
             "holder" => "div",
             "class" => "",
             "heading" => __("Content",'imevent'),
             "param_name" => "content",
             "value" => "",
             "description" => 'Insert code like: &lt;a class=&quot;jevent-title-1 wow fadeInDown&quot; href=&quot;#&quot; data-wow-delay=&quot;0.8s&quot;&gt; About&lt;span class=&quot;theme-color&quot;&gt; Us&lt;/span&gt; &lt;/a&gt;

Praesent ac sem in neque venenatis tristique. Morbi et ligula velit. Nullam a augue vel mi porta vestibulum non ac elit. Vivamus convallis tortor et fermentum semper. In hac habitasse platea dictumst. Curabitur eget dui id metus pulvinar suscipit.'
        ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("text button", 'imevent'),
             "param_name" => "text_button",
             "value" => "",
        ),
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("link button", 'imevent'),
             "param_name" => "link_button",
             "value" => "",
        ),
        
        array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",'imevent'),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class to use for your style'
        )
        

       
      )));


      vc_map( array(
         "name" => __("Testimonial 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_testimonial2",
         "as_parent" => array('only' => 'imevent_item_testimonial2'),
         "js_view" => 'VcColumnView',
         "content_element" => true,
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(

            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Time swich each slide (ms)",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "timeout",
               "value" => "",
               "description" => 'For example: 3000. 3000ms=3s',
               "value"    => '3000'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Auto",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "auto",
               "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'True',
                    __('false', TEXT_DOMAIN_SHORTCODE) => 'false'
                    ),
              "default"  => 'true'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Loop",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "loop",
               "value" => array(   
                    __('True', TEXT_DOMAIN_SHORTCODE) => 'True',
                    __('false', TEXT_DOMAIN_SHORTCODE) => 'false'
                    ),
              "default"  => 'true'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert Class'
               
            ),

      )));
      
      vc_map( array(
         "name" => __("Item testimonial 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_item_testimonial2",
         "as_child" => array('only' => 'imevent_testimonial2'),
         "content_element" => true,
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(

            array(
               "type" => "textarea",
               "holder" => "div",
               "class" => "",
               "heading" => __("Description",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "desc",
               "value" => "",
            ),
            array(
               "type" => "attach_image",
               "holder" => "div",
               "class" => "",
               "heading" => __("Thumbnail",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "thumbnail",
               "value" => ""
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Alt",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "alt",
               "value" => "",
               "description" => 'Insert alt for thumbnail'
               
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Author",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "author",
               "value" => "",
               "description" => 'Insert author name'
               
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Author Job",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "author_job",
               "value" => ""
            ),

      )));

      if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
          class WPBakeryShortCode_imevent_testimonial2 extends WPBakeryShortCodesContainer {
          }
      }
      if ( class_exists( 'WPBakeryShortCode' ) ) {
          class WPBakeryShortCode_imevent_item_testimonial2 extends WPBakeryShortCode {
          }
      }


       $args_speaker = array(
          'type'                     => 'post',
          'child_of'                 => 0,
          'parent'                   => '',
          'orderby'                  => 'slug',
          'order'                    => 'ASC',
          'hide_empty'               => 1,
          'hierarchical'             => 1,
          'exclude'                  => '',
          'include'                  => '',
          'number'                   => '',
          'taxonomy'                 => 'group',
          'pad_counts'               => false 

        );    
        $categories_speakergroup = get_categories($args_speaker);
        $cate_array_speakergroup = array();
        $empty_speakergroup = array("Select Speaker category" => "");
        if ($categories_speakergroup) {
        foreach ( $categories_speakergroup as $cate ) {
          $cate_array_speakergroup[$cate->cat_name] = $cate->slug;
        }
        } else {
        $cate_array_speakergroup["No content Category found"] = 0;
        }  


      vc_map( array(
         "name" => __("Speaker 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_speaker2",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Slug",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "slug",
               "value" => array_merge($empty_speakergroup,$cate_array_speakergroup)
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Column",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "column",
             "value" => array(
                    __('1 item in row',TEXT_DOMAIN_SHORTCODE)  => 'col-md-12 col-sm-12',
                    __('2 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-6 col-sm-6',
                    __('3 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-4 col-sm-4',
                    __('4 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-3 col-sm-6',
                    __('5 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-2 col-sm-6 col-5',
                    __('6 items in row',TEXT_DOMAIN_SHORTCODE) => 'col-md-2 col-sm-6',
                    ),
             "default"  => 'col-md-3 col-sm-6'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speaker_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_speaker_order_by',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speaker_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "speakers_item_count",
               "value" => "30",               
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display job",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_display_job",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Display speaker link",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "speakers_speaker_link",
             "value" => array(   
                    __('Yes', TEXT_DOMAIN_SHORTCODE) => '1',
                    __('No', TEXT_DOMAIN_SHORTCODE) => '0',                    
                    ),
             "default" => '1'
          ),
          
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class to use for your style'
            ),

         
      )));

      vc_map( array(
         "name" => __("Pricing", TEXT_DOMAIN_SHORTCODE),
         "base" => "pricing",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Name",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "name",
               "value" => "",
               "description" => 'Name of package. For instance: Personal'
            ),

          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Pricing style",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "pricing_style",
               "value" => array(   
                      __('Currency - Value', TEXT_DOMAIN_SHORTCODE) => 'ca',                
                      __('Price - Value', TEXT_DOMAIN_SHORTCODE) => 'ac',
                      ),
               "default" => 'ca'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Value",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "value",
               "value" => "",
               "description" => 'Value of package. For instance: 111'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Currency",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "currency",
               "value" => "",
               "description" => 'Currency of package. For instance: $'
            ),
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Feature Package",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "feature",
               "value" => array(   
                      __('Normal', TEXT_DOMAIN_SHORTCODE) => 'nofeature',                
                      __('Feature', TEXT_DOMAIN_SHORTCODE) => 'featured',
                      ),
               "description" => 'Choose package is feature',
               "default" => "nofeature"
            ),
          
          array(
               "type" => "textarea_html",
               "holder" => "div",
               "class" => "",
               "heading" => __("Content",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "content",
               "value" => '',
               "description" => 'Click Text tab and insert like: &lt;div&nbsp;class=&quot;price-table-row&quot;&gt;&lt;i&nbsp;class=&quot;fa&nbsp;fa-check-circle-o&quot;&gt;&lt;/i&gt;&nbsp;Lorem&nbsp;ipsum&nbsp;dolor&nbsp;sit&nbsp;amet&lt;/div&gt;<br/>&lt;div&nbsp;class=&quot;price-table-row&nbsp;odd&quot;&gt;&lt;i&nbsp;class=&quot;fa&nbsp;fa-check-circle-o&quot;&gt;&lt;/i&gt;&nbsp;Consectetur&nbsp;adipiscing&nbsp;elit&lt;/div&gt;<br/>&lt;div&nbsp;class=&quot;price-table-row&quot;&gt;&lt;i&nbsp;class=&quot;fa&nbsp;fa-check-circle-o&quot;&gt;&lt;/i&gt;&nbsp;Sed&nbsp;vitae&nbsp;diam&nbsp;metus&lt;/div&gt;<br/>&lt;div&nbsp;class=&quot;price-table-row&nbsp;odd&quot;&gt;&lt;i&nbsp;class=&quot;fa&nbsp;fa-check-circle-o&quot;&gt;&lt;/i&gt;&nbsp;Donec&nbsp;cursus&nbsp;magna&lt;/div&gt;'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Name button",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "name_button",
               "value" => "",
               "description" => 'Name Button of package. For instance: Register'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Link button",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "link_button",
               "value" => "",
               "description" => 'Link Button of package. For instance: if extra link is Scroll Smooth: #register else if extra link is No scroll: http://sitename.com'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Extra link",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "extra_link",
               "value" => array(   
                      __('No scroll', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('Scroll Smooth', TEXT_DOMAIN_SHORTCODE) => 'false',                
                      ),
               "description" => 'Choose extra link is true or false',
               "default" => "true"
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Target",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "target",
               "value" => array(   
                      __('_self', TEXT_DOMAIN_SHORTCODE) => 'Self',                
                      __('_blank', TEXT_DOMAIN_SHORTCODE) => 'Blank',
                      ),
               "default" => '_self'
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class'
            ),
         
      )));


      vc_map( array(
         "name" => __("Pricing 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_pricing2",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Name",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "name",
               "value" => "",
               "description" => 'Name of package. For instance: Personal'
            ),

          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Pricing style",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "pricing_style",
               "value" => array(   
                      __('Currency - Value', TEXT_DOMAIN_SHORTCODE) => 'ca',                
                      __('Price - Value', TEXT_DOMAIN_SHORTCODE) => 'ac',
                      ),
               "default" => 'ca'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Value",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "value",
               "value" => "",
               "description" => 'Value of package. For instance: 111'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Currency",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "currency",
               "value" => "",
               "description" => 'Currency of package. For instance: $'
            ),
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Feature Package",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "feature",
               "value" => array(   
                      __('Normal', TEXT_DOMAIN_SHORTCODE) => 'nofeature',                
                      __('Feature', TEXT_DOMAIN_SHORTCODE) => 'featured',
                      ),
               "description" => 'Choose package is feature',
               "default" => "nofeature"
            ),
          array(
               "type" => "textarea_html",
               "holder" => "div",
               "class" => "",
               "heading" => __("Content",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "content",
               "value" => '',
               "description" => 'Open Text tab and insert like: &lt;ul&nbsp;class=&quot;plans-detail&quot;&gt;&nbsp;&lt;li&gt;5&nbsp;Projects&lt;/li&gt;&nbsp;&lt;li&gt;30&nbsp;GB&nbsp;Storage&lt;/li&gt;&nbsp;&lt;li&gt;Unlimited&nbsp;Data&nbsp;Transfer&lt;/li&gt;&nbsp;&lt;li&gt;50&nbsp;GB&nbsp;Bandwidth&lt;/li&gt;&nbsp;&lt;li&gt;Enhanced&nbsp;Security&lt;/li&gt;&nbsp;&lt;/ul&gt;'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Name button",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "name_button",
               "value" => "",
               "description" => 'Name Button of package. For instance: Register'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Link button",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "link_button",
               "value" => "",
               "description" => 'Link Button of package. For instance: if extra link is Scroll Smooth: #register else if extra link is No scroll: http://sitename.com'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Extra link",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "extra_link",
               "value" => array(   
                      __('No scroll', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('Scroll Smooth', TEXT_DOMAIN_SHORTCODE) => 'false',                
                      ),
               "description" => 'Choose extra link is true or false',
               "default" => "true"
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class'
            ),
         
      )));

      $products_array = array();

      if(class_exists('Woocommerce')){

        // Choose Product
        $args = array(
          'post_type' => 'product', 
          'orderby' => 'name',
          'order' => 'ASC',
          'posts_per_page' => '1000000'
        );

        $products = new WP_Query($args);

        $products_array['Choose Product'] = 'empty';

        if($products->have_posts()){
              while($products->have_posts()): $products->the_post();
                global $post;
            $products_array[$post->post_title] = $post->ID;
          endwhile;
        }
        
      }

      vc_map( array(
         "name" => __("Pricing Woocommerce", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_woo_pricing",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
          array(
                 "type" => "dropdown",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Product ID",'eventmana'),
                 "param_name" => "product_id",
                 "value" => $products_array,
                 "default" => 'all',
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Name",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "name",
               "value" => "",
               "description" => 'Name of package. For instance: Personal'
            ),

          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Pricing style",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "pricing_style",
               "value" => array(   
                      __('Currency - Value', TEXT_DOMAIN_SHORTCODE) => 'ca',                
                      __('Price - Value', TEXT_DOMAIN_SHORTCODE) => 'ac',
                      ),
               "default" => 'ca'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Value",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "value",
               "value" => "",
               "description" => 'Value of package. For instance: 111'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Currency",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "currency",
               "value" => "",
               "description" => 'Currency of package. For instance: $'
            ),
          array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Feature Package",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "feature",
               "value" => array(   
                      __('Normal', TEXT_DOMAIN_SHORTCODE) => 'nofeature',                
                      __('Feature', TEXT_DOMAIN_SHORTCODE) => 'featured',
                      ),
               "description" => 'Choose package is feature',
               "default" => "nofeature"
            ),
          array(
               "type" => "textarea_html",
               "holder" => "div",
               "class" => "",
               "heading" => __("Description",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "content",
               "value" => "",
               "description" => 'For example: Click Text tab and insert &lt;div class=&quot;price-table-row&quot;&gt;&lt;i class=&quot;fa fa-check-circle-o&quot;&gt;&lt;/i&gt;Lorem ipsum dolor sit amet&lt;/div&gt;
&lt;div class=&quot;price-table-row odd&quot;&gt;&lt;i class=&quot;fa fa-check-circle-o&quot;&gt;&lt;/i&gt;Consectetur adipiscing elit&lt;/div&gt;
&lt;div class=&quot;price-table-row&quot;&gt;&lt;i class=&quot;fa fa-check-circle-o&quot;&gt;&lt;/i&gt;Sed vitae diam metus&lt;/div&gt;
&lt;div class=&quot;price-table-row odd&quot;&gt;&lt;i class=&quot;fa fa-check-circle-o&quot;&gt;&lt;/i&gt;Donec cursus magna&lt;/div&gt; <br/> or this code <br/> &lt;ul class=&quot;plans-detail&quot;&gt;
  &lt;li&gt;5 Projects&lt;/li&gt;
  &lt;li&gt;30 GB Storage&lt;/li&gt;
  &lt;li&gt;Unlimited Data Transfer&lt;/li&gt;
  &lt;li&gt;50 GB Bandwidth&lt;/li&gt;
  &lt;li&gt;Enhanced Security&lt;/li&gt;
&lt;/ul&gt;'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Choose style",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "style",
               "value" => array(   
                      __('Style 1', TEXT_DOMAIN_SHORTCODE) => 'style1',                
                      __('Style 2', TEXT_DOMAIN_SHORTCODE) => 'style2',
                      ),
               "default" => "style1"
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class'
            ),
         
      )));

      

       $args_faq = array(
          'type'                     => 'post',
          'child_of'                 => 0,
          'parent'                   => '',
          'orderby'                  => 'slug',
          'order'                    => 'ASC',
          'hide_empty'               => 1,
          'hierarchical'             => 1,
          'exclude'                  => '',
          'include'                  => '',
          'number'                   => '',
          'taxonomy'                 => 'faqgroup',
          'pad_counts'               => false 

        );    
        $categories_faqgroup = get_categories($args_faq);
        $cate_array_faqgroup = array();
        $empty_faqgroup = array("Select Faq category" => "");
        if ($categories_faqgroup) {
          foreach ( $categories_faqgroup as $cate ) {
            $cate_array_faqgroup[$cate->cat_name] = $cate->slug;
          }
        } else {
          $cate_array_faqgroup["No content Category found"] = 0;
        }  


      vc_map( array(
         "name" => __("Faq 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_faq",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(

          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Slug",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "slug",
             "value" => array_merge($empty_faqgroup,$cate_array_faqgroup)
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order By",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "faq_order_by",
             "value" => array(
                    __('ID', TEXT_DOMAIN_SHORTCODE) => 'id',
                    __('Order in attribute of slide', TEXT_DOMAIN_SHORTCODE) => '_cmb_faq_order_by',
                    __('Author', TEXT_DOMAIN_SHORTCODE) => 'author',
                    __('title', TEXT_DOMAIN_SHORTCODE) => 'title',
                    __('Slug', TEXT_DOMAIN_SHORTCODE) => 'name',
                    __('Order by date', TEXT_DOMAIN_SHORTCODE) => 'date',
                    __('Order by last modified date', TEXT_DOMAIN_SHORTCODE) => 'modified',
                    __('Order by post/page parent id.', TEXT_DOMAIN_SHORTCODE) => 'parent',
                    __('Random order', TEXT_DOMAIN_SHORTCODE) => 'rand',
                    __('Order by number of comments', TEXT_DOMAIN_SHORTCODE) => 'comment_count',
                    ),
             "default" => 'id'
          ),
          array(
             "type" => "dropdown",
             "holder" => "div",
             "class" => "",
             "heading" => __("Order",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "faq_order",
             "value" => array(   
                    __('ASC', TEXT_DOMAIN_SHORTCODE) => 'ASC',
                    __('DESC', TEXT_DOMAIN_SHORTCODE) => 'DESC',                    
                    ),
             "default" => 'ASC'
          ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "faq_item_count",
               "value" => "100",               
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
             "param_name" => "class",
             "value" => "",
             "description" => 'Insert class to use for your style'
          ),
          
         
      )));

      $args = array(
        'orderby' => 'name',
        'order' => 'ASC'
        );

      $categories=get_categories($args);
      $cate_array = array();$arrayCateAll = array('All categories ' => 'all' );
      if ($categories) {
        foreach ( $categories as $cate ) {
          $cate_array[$cate->cat_name] = $cate->cat_ID;
        }
      } else {
        $cate_array["No content Category found"] = 0;
      }

      vc_map( array(
         "name" => __("latest blog 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_latestblog2",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",   
         "params" => array(
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Category",'events'),
               "param_name" => "category",
               "value" => array_merge($arrayCateAll,$cate_array),
               "description" => __("Choose a Content Category from the drop down list.", 'events')
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Count",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "count",
               "value" => "3",
               "description" => 'Post Count'
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Show date",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "showdate",
               "value" => array(   
                      __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('False', TEXT_DOMAIN_SHORTCODE) => 'false',                
                      ),
               "description" => 'Show date',
               "default" => "true"
            ),
            array(
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => __("Show Description",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "showdescription",
               "value" => array(   
                      __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                      __('False', TEXT_DOMAIN_SHORTCODE) => 'false',
                      ),
               "description" => 'Show Description',
               "default" => "true"
            ),
              array(
                 "type" => "dropdown",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Show Readmore",TEXT_DOMAIN_SHORTCODE),
                 "param_name" => "showreadmore",
                 "value" => array(   
                        __('True', TEXT_DOMAIN_SHORTCODE) => 'true',
                        __('False', TEXT_DOMAIN_SHORTCODE) => 'false',                
                        ),
                 "description" => 'Show Read More',
                 "default" => "true"
              ),
          

         )
      ) );

      vc_map( array(
         "name" => __("Map 2", TEXT_DOMAIN_SHORTCODE),
         "base" => "imevent_map",
         "class" => "",
         "category" => __("My shortcode", TEXT_DOMAIN_SHORTCODE),
         "icon" => "icon-qk",
         "params" => array(
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Defineid",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "defineid",
               "value" => "map-canvas",
               "description" => 'Insert id to display map. For instance: map-canvas'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Latitude",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "latitude",
               "value" => "40.9807648",
               "description" => 'Insert latitude parameter for google map. For instance: 40.9807648'
            ),
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Longitude",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "longitude",
               "value" => "28.9866516",
               "description" => 'Insert longitude parameter for google map. For instance: 28.9866516'
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Zoom",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "zoom",
               "value" => "12",
               "description" => 'Insert zoom parameter for google map. Default 12'
            ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Marker title",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "marker_title",
               "value" => "",
               "description" => __('Insert marker title', TEXT_DOMAIN_SHORTCODE)
            ), 
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Heading",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "heading",
               "value" => "",
               "description" => 'Insert heading'
            ),
          array(
               "type" => "textarea_html",
               "holder" => "div",
               "class" => "",
               "heading" => __("Main Content",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "content",
               "value" => "",
               "description" => 'Insert main content'
            ),
          
          array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Class",TEXT_DOMAIN_SHORTCODE),
               "param_name" => "class",
               "value" => "",
               "description" => 'Insert class'
            ),
          
          
         )
      ) );


  }
}





