<?php

$pagePath = explode('/wp-content/', dirname(__FILE__));
include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));


global $theme_option;
defined('TEXT_DOMAIN_PAPAL_NOTIFY') or define('TEXT_DOMAIN_PAPAL_NOTIFY', 'imevent');
	// Response from Paypal

	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_REQUEST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
		$req .= "&$key=$value";
	}

	
	if($theme_option['register_environment'] == 1){
		$paypal_url= "https://www.paypal.com/cgi-bin/webscr";
	}else{
		$paypal_url= "https://www.sandbox.paypal.com/cgi-bin/webscr";
	}

	$ch = curl_init($paypal_url);
	if ($ch == FALSE) {
		return FALSE;
	}
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	if(DEBUG == true) {
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
	}
	// CONFIG: Optional proxy configuration
	//curl_setopt($ch, CURLOPT_PROXY, $proxy);
	//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
	// Set TCP timeout to 30 seconds
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
	// of the certificate as shown below. Ensure the file is readable by the webserver.
	// This is mandatory for some environments.
	//$cert = __DIR__ . "./cacert.pem";
	//curl_setopt($ch, CURLOPT_CAINFO, $cert);
	$res = curl_exec($ch);
	if (curl_errno($ch) != 0) // cURL error
		{
		if(DEBUG == true) {	
			error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
		}
		curl_close($ch);
		exit;
	} else {
			// Log the entire HTTP response if debug is switched on.
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
				error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
				// Split response headers and payload
				list($headers, $res) = explode("\r\n\r\n", $res, 2);
			}
			curl_close($ch);
	}
	
	if (strcmp ($res, "VERIFIED") == 0) {
		global $wpdb;
		$wpdb->update(
			'imevent_payments', 
			array(
				'price' 		=> $_REQUEST['mc_gross'],
				'currency' 		=> $_REQUEST['mc_currency'],
				'status'		=> $_REQUEST['payment_status'],
				'payment_type'	=> '',
				'transaction_id' => $_REQUEST['txn_id'],
				'sumary'	=> ''
			), 
			array( 'order_id' => $_REQUEST['custom']), 
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s'
			)			
		);

		$results = $wpdb->get_results( "SELECT * FROM `imevent_payments` where status = 'Completed' and order_id = '".$_REQUEST['custom']."' ORDER BY `ID` DESC");	

	   	$body_email = str_replace('[orderid]',$results['0']->order_id, $theme_option['register_patter_template_paypal']);
    	$body_email = str_replace('[transaction_id]', $results['0']->transaction_id, $body_email);
    	$body_email = str_replace('[price]', $results['0']->price, $body_email);
    	$body_email = str_replace('[currency]', $results['0']->currency, $body_email);
    	$body_email = str_replace('[status]', $results['0']->status, $body_email);
    	$body_email = str_replace('[date]', date(get_option('date_format'), $results['0']->created), $body_email);
    	$body_email = str_replace('[userinfo]', html_entity_decode(str_replace('|||','',$results['0']->buyer_info)), $body_email);

		
		$multiple_to_recipients = array($theme_option['register_email_paypal'], $results['0']->buyer_email);	  	

		$subject = $theme_option['register_patter_template_free_subject'];
        $body 	 = $body_email;
        $headers = __('From website', TEXT_DOMAIN_PAPAL_NOTIFY) . $theme_option['register_email_paypal']. "\r\n";
        $headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";
                              
        add_filter( 'wp_mail_from', 'register_wp_mail_from' );
        add_filter( 'wp_mail_from_name', 'register_wp_mail_from_name' );
                          
        wp_mail($multiple_to_recipients, $subject, $body, $headers);

        remove_filter( 'wp_mail_from', 'register_wp_mail_from' );
        remove_filter( 'wp_mail_from_name', 'register_wp_mail_from_name' );
		
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
		}		
	} else if (strcmp ($res, "INVALID") == 0) {
		// log for manual investigation
		// Add business logic here which deals with invalid IPN messages
		$emailTo = $_REQUEST['payer_email'];
        $subject = _e('Error Pay', TEXT_DOMAIN_PAPAL_NOTIFY); 
        $body 	 = _e('Error Order', TEXT_DOMAIN_PAPAL_NOTIFY);

		wp_mail($emailTo, $subject, $body);

		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
		}
		return false;
	}

?>