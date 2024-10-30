<?php
// Check if the Must-Use plugin file exists, and if not, provide a link to create it
function check_must_use_plugin_file() {
    $must_use_plugin_file = WP_CONTENT_DIR . '/mu-plugins/conflict-finder-must-use.php';
    if (!file_exists($must_use_plugin_file)) {
        echo '<div class="notice notice-warning conflict-finder-notice"><p><strong>';
        echo esc_html__('The Conflict Finder is missing a file needed to operate properly.', 'your-text-domain');
        echo '</strong> <a href="' . esc_url(admin_url('admin-post.php?action=conflict_finder_create_must_use')) . '">';
        echo esc_html__('Click here to create it now...', 'your-text-domain');
        echo '</a>.</p></div>';
    }
}
// Hook the function to be displayed in admin notices
add_action('admin_notices', 'check_must_use_plugin_file');
// Handler for creating the Must-Use plugin file
function conflict_finder_create_must_use_file() {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    // Initialize the WordPress filesystem
    if (!function_exists('WP_Filesystem')) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    WP_Filesystem();
    // Check if WP_Filesystem initialized properly
    global $wp_filesystem;
    if (!$wp_filesystem) {
        return;
    }
    $must_use_plugin_file = WP_CONTENT_DIR . '/mu-plugins/conflict-finder-must-use.php';
    if (!file_exists($must_use_plugin_file)) {
        // Check if the Must-Use plugin directory exists
        $mu_plugins_dir = WP_CONTENT_DIR . '/mu-plugins';
        if (!is_dir($mu_plugins_dir)) {
            // Attempt to create the directory
            if (wp_mkdir_p($mu_plugins_dir)) {
                // Directory created successfully
                error_log('Must-Use plugins directory created successfully.');
            } else {
                // Failed to create directory
                error_log('Failed to create Must-Use plugins directory.');
                return;
            }
        }
        // Define the content for the Must-Use plugin file
        $must_use_plugin_content = <<<'EOT'
<?php
/*
Plugin Name: Plugin Conflict Finder Must Use
Description: Prevent selected plugins from loading for admin users and logged-in users on the front end.
*/
function conflict_finder_must_use_init() {
    add_filter('option_active_plugins', 'conflict_finder_must_use_filter_active_plugins');
    if (is_multisite()) {
        add_filter('site_option_active_sitewide_plugins', 'conflict_finder_must_use_filter_active_plugins');
    }
    
    // Add a filter for logged-out users
    add_filter('option_active_plugins', 'conflict_finder_must_use_filter_active_plugins_logged_out');
}
function conflict_finder_must_use_filter_active_plugins($plugins) {
    if (!function_exists('wp_get_current_user')) {
        require_once(ABSPATH . 'wp-includes/pluggable.php');
    }
    $selected_plugins = get_option('selected_plugins', array());
    if (empty($selected_plugins)) {
        return $plugins;
    }
    if (current_user_can('manage_options') || (is_user_logged_in() && !is_admin())) {
        foreach ($plugins as $key => $plugin) {
            if (in_array(plugin_basename($plugin), $selected_plugins)) {
                unset($plugins[$key]);
            }
        }
    }
    return $plugins;
}
function conflict_finder_must_use_filter_active_plugins_logged_out($plugins) {
    $selected_plugins = get_option('selected_plugins', array());
    $default_disable_plugins_all_mode = get_option('disable_plugins_all_mode');
    $debug_mode = isset($_GET['debug']);
    if (empty($selected_plugins)) {
        return $plugins;
    }
    if (!is_user_logged_in() && !current_user_can('manage_options')) {
        if ($default_disable_plugins_all_mode && $debug_mode) {
            foreach ($plugins as $key => $plugin) {
                if (in_array(plugin_basename($plugin), $selected_plugins)) {
                    unset($plugins[$key]);
                }
            }
        }
    }
    return $plugins;
}
add_action('muplugins_loaded', 'conflict_finder_must_use_init');
?>
EOT;
        // Create the Must-Use plugin file
        if ($wp_filesystem->put_contents($must_use_plugin_file, $must_use_plugin_content, FS_CHMOD_FILE)) {
            // Redirect to settings page
            wp_safe_redirect(admin_url('tools.php?page=conflict-finder'));
            exit;
        } else {
            // Error message
            echo '<div class="notice notice-error"><p><strong>';
            echo esc_html__('Failed to create Conflict Finder Must-Use plugin file.', 'plugin-conflict-finder');
            echo '</strong></p></div>';
        }
    }
}
// Hook the handler to the admin-post action
add_action('admin_post_conflict_finder_create_must_use', 'conflict_finder_create_must_use_file');