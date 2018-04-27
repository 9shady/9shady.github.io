<?php
/**
 * @package Analytics Code
 * @version 1.6
 */
/*
Plugin Name: Analytics Code by Spin
Plugin URI: http://shubhampandey.in/
Description: Analytics code for kaivalya online website
Author: Shubham Pandey
Version: 1.6
Author URI: http://shubhampandey.in/
*/

function kaivalya_add_analytics_code(){
	echo '<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-90186372-11"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "UA-90186372-11");
</script>
';
	//echo '<meta name="google-site-verification" content="fDz31XsgAYnu0I6GlSFs64c2WW3QEh6UaOdHSrS9AFk" />';
}

add_action( 'wp_head', 'kaivalya_add_analytics_code' );