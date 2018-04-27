<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {
	define('TEXT_DOMAIN_METABOX', 'imevent');

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	$meta_boxes[] = array(
        'id'         => 'Post_Options',
        'title'      => 'Post Options',
        'pages'      => array('post'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => __('oEmbed Post format media', TEXT_DOMAIN_METABOX),
                'desc' => __('Enter a audio, youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'embed_media',
                'type' => 'oembed',
            ),
        ),
    );

	$meta_boxes[] = array(
		'id'         => 'schedule_fields',
		'title'      => __('Schedule Field', TEXT_DOMAIN_METABOX),
		'pages'      => array( 'schedule'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		'fields' => array(
             array(
                'name' => __('Order', TEXT_DOMAIN_METABOX),
                'desc' => __('To display at frontend. Insert number 1,2,3,4,5...', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'schedule_order_by',
                'type' => 'text',
                'default' => '1'
            ),
			array(
                'name' => __('Time Text', TEXT_DOMAIN_METABOX),
				'desc' => __('You can insert time here: 08:00 - 08:45', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_timetext',
				'type' => 'text',
            ),
            array(
                'name' => __('Author', TEXT_DOMAIN_METABOX),
				'desc' => __('Author will speak: John Doe', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_author',
				'type' => 'text',
            ),
            array(
                'name' => __('Author Job', TEXT_DOMAIN_METABOX),
				'desc' => __('Job of author: CEO at Crown.io', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_author_job',
				'type' => 'text',
            ),
            array(
                'name' => __('Link thumbnail of speaker', TEXT_DOMAIN_METABOX),
                'desc' => __('Insert link for speaker', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'schedule_link_speaker',
                'type' => 'text',
            ),
            array(
                'name' => __('Mail Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Mail Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_mail_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Facebook Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Facebook Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_facebook_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Twitter Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Twitter Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_twitter_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Linkedin Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Linkedin Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_linkedin_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Pinterest Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Pinterest Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_pinterest_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Google Plus Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Google Plus Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_googleplus_address',
				'type' => 'text'				
            ),            
            array(
                'name' => __('Tumblr Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Tumblr Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_tumblr_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Instagram Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Instagram Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_instagram_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('VK Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('VK Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_vk_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Flickr Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Flickr Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_flickr_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('MySpace Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('MySpace Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_mySpace_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Youtube Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Youtube Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'schedule_youtube_address',
				'type' => 'text'				
            ),
          
		)
	);

    $meta_boxes[] = array(
        'id'         => 'faq_fields',
        'title'      => __('Faq Field', TEXT_DOMAIN_METABOX),
        'pages'      => array( 'faq'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
             array(
                'name' => __('Order', TEXT_DOMAIN_METABOX),
                'desc' => __('To display at frontend. Insert number 1,2,3,4,5...', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'faq_order_by',
                'type' => 'text',
                'default' => '1'
            )
        )
    );

	$meta_boxes[] = array(
		'id'         => 'speaker_fields',
		'title'      => __('Speaker Field', TEXT_DOMAIN_METABOX),
		'pages'      => array( 'speaker'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left		
		'fields' => array(
            array(
                'name' => __('Order', TEXT_DOMAIN_METABOX),
                'desc' => __('To display at frontend. Insert number 1,2,3,4,5...', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'speaker_order_by',
                'type' => 'text',
                'default' => '1'
            ),
			array(
                'name' => __('Job', TEXT_DOMAIN_METABOX),
				'desc' => __('Job', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_job',
				'type' => 'text',				
            ),
            array(
                'name' => __('Mail Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Mail Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_mail_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Facebook Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Facebook Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_facebook_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Twitter Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Twitter Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_twitter_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Linkedin Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Linkedin Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_linkedin_address',
				'type' => 'text',				
            ),
            array(
                'name' => __('Pinterest Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Pinterest Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_pinterest_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Google Plus Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Google Plus Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_googleplus_address',
				'type' => 'text'				
            ),            
            array(
                'name' => __('Tumblr Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Tumblr Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_tumblr_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Instagram Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Instagram Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_instagram_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('VK Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('VK Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_vk_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Flickr Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Flickr Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_flickr_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('MySpace Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('MySpace Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_mySpace_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Youtube Adress', TEXT_DOMAIN_METABOX),
				'desc' => __('Youtube Adress', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'speaker_youtube_address',
				'type' => 'text'				
            ),
                       
           
            
          
		)
	);

    $meta_boxes[] = array(
            'id'         => 'menu_display_page',
            'title'      => __('General Settings', TEXT_DOMAIN_METABOX),
            'pages'      => array( 'page', 'post','schedule', 'speaker'), // Post type
            'context'    => 'normal',
            'priority'   => 'high',
            'show_names' => true,
            'fields' => array(
                array(
                    'name' => __('Choose Menu', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'menu_display',
                    'type' => 'select',
                    'options' => array(
                        "primary" => "Primary",
                        "one_page" => "One page"
                    ),
                    'default'   => 'primary',
                    'description' => __('One Page menu always use for home page (lading page)', TEXT_DOMAIN_METABOX)
                ),
                array(
                    'name' => __('Footer Code', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'footer_global',
                    'type' => 'select',
                    'options' => array(
                        "yes" => "Yes",
                        "no" => "no"
                    ),
                    'default'   => 'yes',
                    'description' => __('Use code in Theme options >> Footer settings', TEXT_DOMAIN_METABOX)
                ),
                array(
                    'name' => __('Show sidebar', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'show_sidebar',
                    'type' => 'select',
                    'options' => array(
                        "yes" => __("Yes",TEXT_DOMAIN_METABOX),
                        "no" => __("No",TEXT_DOMAIN_METABOX)
                    ),
                    'default'   => 'yes'
                ),
                array(
                    'name' => __('Show title', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'show_title',
                    'type' => 'select',
                    'options' => array(
                        "yes" => __("Yes",TEXT_DOMAIN_METABOX),
                        "no" => __("No",TEXT_DOMAIN_METABOX)
                    ),
                    'default'   => 'yes'
                ),
                array(
                    'name' => __('Select Light/Dark version', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'bg_version',
                    'type' => 'select',
                    'options' => array(
                        "global" => __("Global",TEXT_DOMAIN_METABOX),
                        "body-light" => __("Light",TEXT_DOMAIN_METABOX),
                        "body-dark" => __("Dark",TEXT_DOMAIN_METABOX)
                    ),
                    'default'   => 'global',
                    'description' => __('Global: Use in Theme Options >> Style Settings<br/> Dark/Light: will override value in Global',TEXT_DOMAIN_METABOX)
                ),
                array(
                    'name' => __('Audio Background', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'audio_background',
                    'type' => 'select',
                    'options' => array(
                        "none" =>__ ("None",TEXT_DOMAIN_METABOX),
                        "auto_play" => __("Auto Play",TEXT_DOMAIN_METABOX),
                        "manual_play" => __("Manual Play",TEXT_DOMAIN_METABOX)
                    ),
                    'default'   => 'none'
                ),
                array(
                    'name' => __('Path audio background: *.mp3', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'audio_path',
                    'description'   => __('Insert path of audio', TEXT_DOMAIN_METABOX),
                    'type' => 'text',
                    'default'   => 'http://demo.ovatheme.com/imevent/intro/dance-background.mp3'
                ),
                array(
                    'name' => __('Animate for elements', TEXT_DOMAIN_METABOX),
                    'id'   => $prefix . 'ova_animate',
                    'type' => 'select',
                    'options' => array(
                        'global' => "Global",
                        'ova_animate'=>'Yes',
                        'no_ova_animate'=>'No'
                    ),
                    'default'   => 'global',
                    'description' => __('Choose Global will use value in Theme options >> Style settings >> Display Animate for element', TEXT_DOMAIN_METABOX)
                ),

            ),
            
    );

    


	$meta_boxes[] = array(
		'id'         => 'seo_fields',
		'title'      => __('SEO Fields', TEXT_DOMAIN_METABOX),
		'pages'      => array( 'page', 'post','schedule', 'speaker'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		//'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(
			array(
				'name' => __('SEO Title', TEXT_DOMAIN_METABOX),
				'desc' => __('Title for SEO (optional)', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'seo_title',
				'type' => 'text',
			),
            array(
                'name' => __('SEO Keywords', TEXT_DOMAIN_METABOX),
                'desc' => __('SEO keywords (optional)', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'seo_keywords',
                'type' => 'text',
            ),
            array(
                'name' => __('SEO Description', TEXT_DOMAIN_METABOX),
                'desc' => __('SEO description (optional)', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'seo_description',
                'type' => 'textarea',
            ),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'slideshow_fields',
		'title'      => __('Slideshow Field', TEXT_DOMAIN_METABOX),
		'pages'      => array( 'slideshow'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left

		'fields' => array(
            array(
                'name' => __('Order', TEXT_DOMAIN_METABOX),
                'desc' => __('To display at frontend. Insert number 1,2,3,4,5...', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'slideshow_order',
                'type' => 'text',
                'default' => '1'
            ),
            array(
                'name' => __('Template', TEXT_DOMAIN_METABOX),
                'desc' => __('Select a template to display for this slide', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'template',
                'type' => 'select',
                'options' => array(
                'slide1' => __( 'Template 1: CountDown style', TEXT_DOMAIN_METABOX ),
                'slide2'   => __( 'Template 2: Display button: register and watch video', TEXT_DOMAIN_METABOX ),
                'slide3'   => __( 'Template 3: Register Form style', TEXT_DOMAIN_METABOX ),
                'slide4'   => __( 'Template 4: Display button youtube', TEXT_DOMAIN_METABOX ),
                  ),
            'default' => 'slide1',
            ),
			array(
                'name' => __('Title 1 <br/>For 4 templates', TEXT_DOMAIN_METABOX),
                'desc' => __('For example: January 17-19,2014. <br/>', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'title1',
                'type' => 'text',
            ),
            array(
                'name' => __('Title 2<br/>For 4 templates', TEXT_DOMAIN_METABOX),
                'desc' => __('For example: PHP Conference in Istanbul.', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'title2',
                'type' => 'text',
            ),

            array(
                'name' => __('End Date Countdown.<br/>Only template 1', TEXT_DOMAIN_METABOX),
				'desc' => __('Choose end date for countdown.', TEXT_DOMAIN_METABOX),
				'id'   => $prefix . 'end_date',
				'type' => 'text_datetime_timestamp',
            ),
            array(
                'name' => __('Button Register Link<br/>Only template 1, 2', TEXT_DOMAIN_METABOX),
                'desc' => __('You can insert a link like #register or insert an extralink like http://themeforest.net/user/ovatheme/portfolio.', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'register_link',
                'type' => 'text',
            ),
            array(
                'name' => __('Link youtube<br/>Only template 2, 4', TEXT_DOMAIN_METABOX),
                'desc' => __('For example: https://www.youtube.com/watch?v=hpeYWdkUtcE. <br/>', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'youtube_link',
                'type' => 'text',
            ),
            
            array(
                'name' => __('Register button text<br/>Only template 1', TEXT_DOMAIN_METABOX),
                'desc' => __('For example: Register', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'slideshow_tem1_register_button',
                'type' => 'text',
                'default'=> ''
            ),
            array(
                'name' => __('Video button text:<br/>Only template 2', TEXT_DOMAIN_METABOX),
                'desc' => __('For example: Watch Video', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'slideshow_tem2_watchvideo_button',
                'type' => 'text',
                'default'=> ''
            ),
            array(
                'name' => __('REGISTER button text<br/> Only template 2', TEXT_DOMAIN_METABOX),
                'desc' => __('For example: Register', TEXT_DOMAIN_METABOX),
                'id'   => $prefix . 'slideshow_tem2_register_button',
                'type' => 'text',
                'default'=> ''
            ),


		)
	);

	

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
