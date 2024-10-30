<?php
// Options page callback
function conflict_finder_options_page() {
    // Get the saved iframe URL or use the homepage URL if empty
    $iframe_url = get_option('iframe_url', esc_url(home_url('/')));
    if (empty($iframe_url)) {
        $iframe_url = esc_url(home_url('/'));
    }
    // Path to the Must-Use plugin file
    $must_use_plugin_file = WP_CONTENT_DIR . '/mu-plugins/conflict-finder-must-use.php';
    // Check if the Must-Use plugin file exists
    if (!file_exists($must_use_plugin_file)) {
        echo '<div class="error"><p>The Must-Use plugin file is missing.</p></div>';
        return;
    }
    // Initialize the selected plugins array and other options
    $selected_plugins = get_option('selected_plugins', array());
    $debug_mode = get_option('debug_mode', false);
    $debug_display_mode = get_option('debug_display_mode', false);
    $disable_plugins_all_mode = get_option('disable_plugins_all_mode', false);
    $default_theme = get_option('default_theme', false);
    
    // Redirect function after form submits
    function conflict_finder_refresh_script() {
    echo '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var newUrl = window.location.pathname + window.location.search + "#page_preview";
                window.location.href = newUrl;
                window.location.reload();
        });
    </script>';
}    
// Redirect function after form resets
function conflict_finder_reset_script() {
     $redirect_url = esc_url(admin_url('tools.php?page=conflict-finder'));
// Output JavaScript for redirection
echo "<script type='text/javascript'>
    if (window.location.href !== '" . esc_js($redirect_url) . "') {
        window.location.href = '" . esc_js($redirect_url) . "';
    }
</script>";
}
    // Handle form submission
if (isset($_POST['submit']) && isset($_POST['conflict_finder_options_nonce']) && wp_verify_nonce($_POST['conflict_finder_options_nonce'], 'conflict_finder_options')) {
    // Sanitize and update the selected plugins
    $newly_selected_plugins = isset($_POST['selected_plugins']) ? array_map('sanitize_text_field', $_POST['selected_plugins']) : array();
    update_option('selected_plugins', $newly_selected_plugins);
    // Sanitize and update the iframe URL
    $new_iframe_url = !empty($_POST['iframe_url']) ? esc_url_raw($_POST['iframe_url']) : esc_url(home_url('/'));
    update_option('iframe_url', $new_iframe_url);
    // Update debug mode settings
    $new_debug_mode = isset($_POST['debug_mode']);
    $new_debug_display_mode = isset($_POST['debug_display_mode']);
    update_option('debug_mode', $new_debug_mode);
    update_option('debug_display_mode', $new_debug_display_mode);
    update_wp_debug($new_debug_mode);
    // Update other settings
    $new_disable_plugins_all_mode = isset($_POST['disable_plugins_all_mode']);
    $new_default_theme = isset($_POST['default_theme']);
    update_option('disable_plugins_all_mode', $new_disable_plugins_all_mode);
    update_option('default_theme', $new_default_theme);
    
    // Ensure debug mode is enabled if debug display mode is enabled
    if ($new_debug_display_mode && !$new_debug_mode) {
        update_option('debug_mode', true);
        update_wp_debug(true);
    }
    
    // Indicate a successful form submission
    add_action('admin_footer', 'conflict_finder_refresh_script');
}
// Handle reset action
if (isset($_POST['reset']) && isset($_POST['conflict_finder_options_nonce']) && wp_verify_nonce($_POST['conflict_finder_options_nonce'], 'conflict_finder_options')) {
    // Reset options to default values
    update_option('selected_plugins', array());
    update_option('debug_mode', false);
    update_option('debug_display_mode', false);
    update_option('disable_plugins_all_mode', false);
    update_option('default_theme', false);
    update_wp_debug(false);
    $selected_plugins = array();
    $debug_mode = false;
    $debug_display_mode = false;
    $disable_plugins_all_mode = false;
    $default_theme = false;
    // Indicate a successful form reset
    add_action('admin_footer', 'conflict_finder_reset_script');
}
    // Get all plugins with their names
    $all_plugins = get_plugins();
    $active_plugins = get_option('active_plugins', array());
    // Split plugins into active and inactive lists
    $active_plugins_with_names = array();
    $inactive_plugins_with_names = array();
    foreach ($all_plugins as $plugin_path => $plugin_info) {
        if (in_array($plugin_path, $active_plugins)) {
            // Skip the Conflict Finder plugin
            if (strpos($plugin_path, 'conflict-finder-wp-fix-it') !== false) {
                continue;
            }
            $active_plugins_with_names[$plugin_path] = $plugin_info['Name'];
        } else {
            $inactive_plugins_with_names[$plugin_path] = $plugin_info['Name'];
        }
    }
    // Exclude this plugin from the lists
    $this_plugin = plugin_basename(__FILE__);
    unset($active_plugins_with_names[$this_plugin]);
    unset($inactive_plugins_with_names[$this_plugin]);
    // Get WordPress version
    $wp_version = get_bloginfo('version');
    // Get active theme's name
    $theme = wp_get_theme();
    $theme_name = $theme->get('Name');
    // Get the number of installed plugins
    $plugin_count = count($all_plugins);
    // Ensure that the necessary update functions are loaded
    include_once(ABSPATH . 'wp-admin/includes/update.php');
    // Get the number of pending updates
    $plugin_update_count = count(get_plugin_updates());
    $theme_update_count = count(get_theme_updates());
    $core_update_count = count(array_filter(get_core_updates(), function($update) use ($wp_version) {
        return version_compare($update->current, $wp_version, '>');
    }));
    // Calculate the total number of pending updates
    $total_updates = $plugin_update_count + $theme_update_count + $core_update_count;
    // Include additional PHP files
    include 'theme-switch.php';
    include 'error-notify.php';
    include 'options-page-content.php';
}
?>