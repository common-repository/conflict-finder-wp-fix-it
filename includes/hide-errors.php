<?php
// Start output buffering early to capture all output
if (!current_user_can('administrator')) {
    ob_start(function ($buffer) {
        $error = error_get_last();
        if ($error && ($error['type'] === E_ERROR || $error['type'] === E_PARSE)) {
            // Wrap the entire output buffer in a div with class 'wp-debug-message'
            return '<div class="wp-debug-message">' . $buffer . '</div>';
        }
        return $buffer; // Ensure the buffer content is returned if no error
    });
    // Ensure the output buffer is flushed at the end of the script execution
    add_action('shutdown', function() {
        if (ob_get_length()) {
            ob_end_flush();
        }
    });
}
if (isset($_POST['stuck_reset']) && current_user_can('administrator')) {
    // Verify nonce
    if (isset($_POST['stuck_reset_nonce']) && wp_verify_nonce($_POST['stuck_reset_nonce'], 'stuck_reset_nonce')) {
        // Nonce is verified, proceed with form processing
        update_option('selected_plugins', array());
        update_option('debug_mode', false);
        update_option('debug_display_mode', false);
        
        update_option('disable_plugins_all_mode', false);
        update_option('default_theme', false);
        update_wp_debug(false);
        // Redirect to avoid form resubmission on page refresh
        wp_safe_redirect(admin_url('tools.php?page=conflict-finder'));
        exit;
    } else {
        // Nonce verification failed, handle error or logging
        // Optionally, you can redirect or display an error message
        wp_die('Nonce verification failed.');
    }
}
// Custom display message for fatal errors
function custom_shutdown_handler() {
    $last_error = error_get_last();
    if ($last_error && ($last_error['type'] === E_ERROR || $last_error['type'] === E_PARSE)) {
        $error_message = "<div class='wp-debug-message'><b>Fatal error:</b> {$last_error['message']} - {$last_error['file']}:{$last_error['line']}<br></div>";
        // Example: Get dynamic content based on user input (replace with actual retrieval method)
        $dynamic_content = get_option('conflict_finder_error_message');
        if (current_user_can('administrator')) {
        $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
    	echo '<br><hr><h2 style="font-size: 33px;margin-top:20px;text-align:center;color:#eb4034;text-transform: uppercase;"><span>There is a conflict on your website</span></h2>';
    	echo '<div style="text-align: center; font-size:18px !important">The good news is only admin users see this and you can find it easily.<br><br>You can use the installed plugin Conflict Finder to troubleshoot this<br><br><strong id="button_stuck_text" >Troubleshoot below or if your site is locked up click "RESET ALL"</strong></div>';
    	echo '<br><br>';
    	echo '<link rel="stylesheet" type="text/css" href="'.esc_url(plugin_dir_url(__FILE__) . '../assets/css/admin-error-page.css') .'">';
      echo '<a href="' . esc_url(admin_url('tools.php?page=conflict-finder')) . '" id="troubleshoot_button" class="troubleshoot_button_class">Troubleshoot Error</a>';
        echo '<form style="float: right !important;" method="post" action="">';
        wp_nonce_field('stuck_reset_nonce', 'stuck_reset_nonce');
	echo '<input id="conflict_crash_reset" type="submit" name="stuck_reset" class="button" value="RESET ALL">';
	echo '</form>';
}
        // Admin CSS styling for error handling
        echo '<style>.wp-die-message {display: none !important;}html {background: #efefef !important;} body#error-page {padding-bottom: 73px!important; border-radius: 12px !important;}</style>';
        }
        if (!current_user_can('administrator')) {
        echo '<style>.wp-die-message {display: none !important;}</style>';
        if (isset($_GET['debug'])) {
        // Run this if debug mode is on
        $default_debug_mode = get_option('debug_mode');
	if (isset($default_debug_mode) && $default_debug_mode) {
        echo '<style>.wp-die-message {display: none !important;}</style>';
        }
        else{
        echo '<style> .wp-die-message {display: none !important;} .wp-die-message p {font-size:18px !important}html {background: #efefef !important;} body#error-page {max-height:290px !important;padding-bottom: 73px!important; border-radius: 12px !important;}</style>';
        echo '<br><hr><h2 style="font-size: 33px;margin-top:20px;text-align:center;color:#eb4034;text-transform: uppercase;"><span>There is a conflict on your website</span></h2>';
    	echo '<div style="text-align: center; font-size:18px !important">The good news is only admin users see this and you can find it easily.<br><br>You can use the installed plugin Conflict Finder to troubleshoot this<br><br><strong id="button_stuck_text" >Troubleshoot below or if your site is locked up click "RESET ALL"</strong></div>';
    	echo '<br><br>';
    	echo '<link rel="stylesheet" type="text/css" href="'.esc_url(plugin_dir_url(__FILE__) . '../assets/css/admin-error-page.css') .'">';
      echo '<a href="' . esc_url(admin_url('tools.php?page=conflict-finder')) . '" id="troubleshoot_button" class="troubleshoot_button_class">Troubleshoot Error</a>';
        echo '<form style="float: right !important;" method="post" action="">';
        wp_nonce_field('stuck_reset_nonce', 'stuck_reset_nonce');
	echo '<input id="conflict_crash_reset" type="submit" name="stuck_reset" class="button" value="RESET ALL">';
	echo '</form>';
        }
        }
    // Check if display to all users is active
    $default_debug_display_mode = get_option('debug_display_mode');
    if (isset($default_debug_display_mode) && !$default_debug_display_mode) {
        // Check if the "debug" query string is present in the URL
        if (!isset($_GET['debug'])) {
        // Non admin CSS styling for error handling
	echo '<link rel="stylesheet" type="text/css" href="'.esc_url(plugin_dir_url(__FILE__) . '../assets/css/non-admin-error-page.css') .'">';
	echo '<style>.wp-die-message {display: none !important;}</style>';
            // Display custom message for non-administrators
            echo '<div style="display: flex; justify-content: center;margin-top: -100px;margin-bottom: -25px;"><img src="' . esc_url(plugins_url('conflict-finder-wp-fix-it/assets/img/monster.png')) . '" width="100%" height="auto"></div><h2 style="font-size: 30px;margin-top:40px;text-align:center;color:#5AD0E4"><span>AHHHHHHH! YOU FOUND ME!</span></h2><div style="text-align: center;"><span>I am a web bug and currently being removed from this website.<br><br>Apologies, but this means that you did not find what you are looking for.<br><br><strong>- We will be back up and running shortly -</strong></span></div>';}
            }
// Run this if admin only display is active
else {
	// Run this if debug mode is off
        $default_debug_mode = get_option('debug_mode');
	//if (isset($default_debug_mode) && !$default_debug_mode) {
	//echo '<style>body#error-page {max-height:333px !important;text-align:center !important} </style>';
	//echo '<h2 style="font-size: 33px;margin-top:20px;text-align:center;color:#f99568"><span>AHHHHHHH! THERE IS AN ERROR!</span></h2>';	//echo '<strong>To view the output of any error messages you must enable WP_DEBUG first.</strong>';
	//echo'<div style="display: flex; justify-content: center;"><img src="' . esc_url(plugins_url('conflict-finder-wp-fix-it/assets/img/monster.png')) . '" width="1070" height="562"></div>';
	//}
//echo '<style>.wp-die-message {display: none !important;}html {background: #efefef !important;} body#error-page {border-radius: 12px !important;font-size: 18px !important;} </style>';
}
        }
         else {
            // Output dynamic content for administrators or customize further
            if ( ! empty( $dynamic_content ) ) {
                echo esc_html($dynamic_content);
            } else {
                // Handle default case for administrators if needed
                echo '';
            }
        }
    }
}
// Register the custom shutdown function
add_action('shutdown', 'custom_shutdown_handler');
?>