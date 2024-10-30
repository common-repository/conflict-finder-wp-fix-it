<?php
// Update WP_DEBUG in wp-config.php
function update_wp_debug($enable_debug) {
    $wp_filesystem = initialize_wp_filesystem();
    if (!$wp_filesystem) {
        echo "Failed to initialize the WP Filesystem.";
        return;
    }
    $wp_config_path = ABSPATH . 'wp-config.php';
    if ($wp_filesystem->exists($wp_config_path) && $wp_filesystem->is_writable($wp_config_path)) {
        // Read the content of wp-config.php
        $wp_config_content = $wp_filesystem->get_contents($wp_config_path);
        // Remove existing WP_DEBUG definition and any associated comment
        $wp_config_content = preg_replace("/define\\(\\s*'WP_DEBUG'\\s*,\\s*(true|false)\\s*\\);\\s*/", '', $wp_config_content);
        $wp_config_content = preg_replace("/\\/\\*\\*\\s*Enable WP_DEBUG\\s*\\*\\/\\s*/", '', $wp_config_content);
        // Prepare the new WP_DEBUG definition and comment
        $wp_debug_definition = "/** Enable WP_DEBUG */\ndefine('WP_DEBUG', " . ($enable_debug ? 'true' : 'false') . ");\n";
        // Insert the WP_DEBUG definition before the wp-settings.php require statement
        if (preg_match("/(require_once\\s+ABSPATH\\s*\\.\\s*'wp-settings\\.php'\\s*;)/", $wp_config_content, $matches)) {
            $wp_config_content = str_replace($matches[0], $wp_debug_definition . $matches[0], $wp_config_content);
        }
        // Write the updated content back to wp-config.php
        if (!$wp_filesystem->put_contents($wp_config_path, $wp_config_content, FS_CHMOD_FILE)) {
            echo "Failed to update wp-config.php.";
        } else {
            // Optional: Uncomment to confirm successful update
            // echo "WP_DEBUG setting has been successfully updated.";
        }
    } else {
        echo "wp-config.php does not exist or is not writable.";
    }
}
// Initialize WP Filesystem
function initialize_wp_filesystem() {
    if (!function_exists('request_filesystem_credentials')) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    $creds = request_filesystem_credentials('', '', false, false, array());
    if (!WP_Filesystem($creds)) {
        return false;
    }
    global $wp_filesystem;
    return $wp_filesystem;
}
// Function to update debug mode setting via AJAX
function update_debug_mode_callback() {
    // Check if the request is coming from a valid AJAX call
    check_ajax_referer('update_debug_mode_nonce', 'security');
    // Get the new debug mode value from the AJAX request
    $debug_mode = isset($_POST['debug_mode']) ? intval($_POST['debug_mode']) : 0;
    // Update the debug mode option in the database
    update_option('debug_mode', $debug_mode);
    // Update wp-config.php based on the new debug mode value
    update_wp_debug($debug_mode);
    // Return a success response
    wp_send_json_success('Debug mode updated successfully');
}
add_action('wp_ajax_update_debug_mode', 'update_debug_mode_callback');