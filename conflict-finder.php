<?php
/*
Plugin Name: Conflict Finder - WP Fix It
Description: Easily identify plugin conflicts on your site. Disable all active plugins with a single click and enable them back seamlessly. Admin-only access.
Version: 6.3
Author: WP Fix It
Author URI: https://www.wpfixit.com
Text Domain: conflict-finder-wp-fix-it
Requires PHP: 5.6
Requires at least: 4.9
*/
// Include necessary files
foreach (['admin-menu.php', 'options-page.php', 'update-debug.php', 'mu-check.php', 'admin-theme-override.php'] as $file) {
    require_once plugin_dir_path(__FILE__) . 'includes/' . $file;
}
require_once plugin_dir_path(__FILE__) . 'includes/admin-checks/wp-plugin-page-checks.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-checks/wp-theme-page-checks.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-checks/debug-notice.php';
// Include the custom shutdown handler file
include_once plugin_dir_path(__FILE__) . 'includes/hide-errors.php';
// Enqueue scripts and styles for the Conflict Finder options page
function conflict_finder_enqueue_scripts_styles($hook) {
    if ($hook === 'tools_page_conflict-finder') {
        wp_enqueue_script('conflict-finder-script', plugin_dir_url(__FILE__) . 'assets/js/conflict-finder-script.js', array('jquery'), '1.0.0', true);
        wp_enqueue_style('conflict-finder-styles', plugin_dir_url(__FILE__) . 'assets/css/conflict-finder-styles.css', array(), '1.0.0');
        wp_localize_script('conflict-finder-script', 'conflictFinder', array(
            'nonce' => wp_create_nonce('conflict_finder_nonce')
        ));
    }
}
add_action('admin_enqueue_scripts', 'conflict_finder_enqueue_scripts_styles');
// Enqueue script to collaspe admin menu on options page
function enqueue_admin_collapse_script($hook_suffix) {
    // Check if we are on the specific page
    if ($hook_suffix == 'tools_page_conflict-finder') {
        wp_enqueue_script('admin-collapse-menu', plugin_dir_url(__FILE__) . 'assets/js/admin-collapse-menu.js', array('jquery'), '1.0.0', true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_collapse_script');
// Set transient to update mu plugin contents
function set_update_mu_plugin_contents_transient($value) {
    // Set the expiration time to 365 days (365 * 24 * 60 * 60 seconds)
    $expiration = 24 * 60 * 60;
    // Set the transient with the given value and expiration time
    set_transient('update_mu_plugin_contents', $value, $expiration);
}
// Run function to update mu plugin contents
function run_set_transient_in_admin() {
    // Check if the transient is not already present
    if (false === get_transient('update_mu_plugin_contents')) {
        $value_to_store = 'mu_plugin_contents';
        
        // Run the conflict_finder_activate function
        conflict_finder_activate();
        // Call the function to set the transient
        set_update_mu_plugin_contents_transient($value_to_store);
    }
}
// Hook the function to admin_init action to run it in the admin area
add_action('admin_init', 'run_set_transient_in_admin');
// Initialize plugin options upon activation
function conflict_finder_activate() {
    global $wp_filesystem;
    require_once ABSPATH . 'wp-admin/includes/file.php';
    WP_Filesystem();
    $mu_plugins_dir = WP_CONTENT_DIR . '/mu-plugins';
    if (!file_exists($mu_plugins_dir) && !wp_mkdir_p($mu_plugins_dir)) {
        return;
    }
    $must_use_plugin_file = $mu_plugins_dir . '/conflict-finder-must-use.php';
    if (file_exists($must_use_plugin_file)) {
        $wp_filesystem->delete($must_use_plugin_file);
    }
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
    if (!$wp_filesystem->put_contents($must_use_plugin_file, $must_use_plugin_content, FS_CHMOD_FILE)) {
        return;
    }
    set_transient('conflict_finder_activation_redirect', true, 1);
}
register_activation_hook(__FILE__, 'conflict_finder_activate');
// Add settings link and "Get Help" link on plugin page
function conflict_finder_settings_links($links) {
    array_unshift($links, '<a href="' . esc_url(admin_url('tools.php?page=conflict-finder')) . '">' . esc_html__('Find Conflict', 'conflict-finder-wp-fix-it') . '</a> ');
    array_unshift($links, '<a href="' . esc_url('https://help.wpfixit.com') . '" target="_blank"><b><span style="color:#f99568 !important">' . esc_html__(' GET HELP', 'conflict-finder-wp-fix-it') . '</b></span></a> ');
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'conflict_finder_settings_links');
// Redirect upon activation
function conflict_finder_activation_redirect() {
    if (get_transient('conflict_finder_activation_redirect')) {
        delete_transient('conflict_finder_activation_redirect');
        $redirect_url = esc_url(admin_url('tools.php?page=conflict-finder'));
// Output JavaScript for redirection
echo "<script type='text/javascript'>
    if (window.location.href !== '" . esc_js($redirect_url) . "') {
        window.location.href = '" . esc_js($redirect_url) . "';
    }
</script>";
    }
}
add_action('admin_init', 'conflict_finder_activation_redirect');
// Reset plugin options upon deactivation
function conflict_finder_deactivate() {
    delete_transient('update_mu_plugin_contents');
    delete_option('selected_plugins');
    delete_option('conflict_finder_initial_options');
    delete_option('debug_mode');
    require_once ABSPATH . 'wp-admin/includes/file.php';
    global $wp_filesystem;
    WP_Filesystem();
    $must_use_plugin_file = WP_CONTENT_DIR . '/mu-plugins/conflict-finder-must-use.php';
    if ($wp_filesystem->exists($must_use_plugin_file)) {
        $wp_filesystem->delete($must_use_plugin_file);
    }
}
register_deactivation_hook(__FILE__, 'conflict_finder_deactivate');
// Check for errors and email if found
function check_for_fatal_error() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        require_once plugin_dir_path(__FILE__) . '/includes/email-error.php';
    }
}
add_action('shutdown', 'check_for_fatal_error');
// Actions when plugin selection is made
function custom_deactivate_selected_plugins() {
    // Check if user is not logged in and not an administrator
    if (!is_user_logged_in() && !current_user_can('manage_options')) {
        // Retrieve selected plugins from options
        $selected_plugins = get_option('custom_selected_plugins', array());
        if (!empty($selected_plugins)) {
            // Get list of active plugins
            $active_plugins = get_option('active_plugins', array());
            foreach ($selected_plugins as $selected_plugin) {
                // Check if selected plugin is active
                if (in_array($selected_plugin, $active_plugins)) {
                    // Deactivate the plugin
                    deactivate_plugins(plugin_basename($selected_plugin));
                }
            }
        }
    }
}
add_action('plugins_loaded', 'custom_deactivate_selected_plugins');
?>