<?php
// Custom function to modify the sender's name
function conflict_finder_custom_email_sender_name( $original_email_from ) {
    return 'WP Fix It - WordPress Experts';
}
// Add filter to modify sender's name
add_filter( 'wp_mail_from_name', 'conflict_finder_custom_email_sender_name' );
// Send out email if error is present
    	if ( false === get_transient( 'conflict_finder_email_sent' ) ) {
    	// Use the notification email as the recipient
    	$to = get_option('error_notification_email');
        // Check if the recipient email is not empty
	if ( ! empty( $to ) ) {
        // Email subject
        $subject = 'IMPORTANT - Critical Error On Your Website';
        // Get the site URL
	$site_url = home_url('/');
        // Email content
        $message = 'Hello<br><br>';
        $message .= 'There has been a critical error(s) on the website at ' . $site_url . '.<br><br>';
        //$message .= 'The good news is that all your website visitors are seeing your custom error page and not the actual error(s).<br><br>';
        $message .= 'Below are the details of what was discovered so you can investigate.<br><br>';
	$message .= '<strong>Error Found:</strong><br>' . $error['message'] . '<br>';
	$message .= '<br><strong>File Error Found In:</strong><br>' . $error['file'] . '<br>';
	$message .= '<br><strong>Line in File:</strong><br>' . $error['line'] . '<br>';
	$message .= '<hr>';
	
	// Included support option to fix the error
	$message .= '<br><strong>Need some emergency WordPress help to fix this for you?</strong><br><br>';
	$message .= 'If so, we fully understand that you are probably in a complete panic because there is something on your WordPress website that is not functioning as it should be and you need support quickly to fix it.<br><br>';
	$message .= 'If anything on your WordPress site is broken and not working the way it should, WP Fix It will fix it for you right away. We are ready 24/7 to help FAST!<br><br>';
	$message .= '<strong><a href="https://help.wpfixit.com" target="_blank">LEARN MORE HERE</a></strong><br><br>';
    	
        // Email headers
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        // Send email
        $email_sent = wp_mail( $to, $subject, $message, $headers );
	if ( $email_sent ) {
        // Set transient to indicate that the email has been sent
        set_transient( 'conflict_finder_email_sent', true, DAY_IN_SECONDS );
        }
        }
    }
?>