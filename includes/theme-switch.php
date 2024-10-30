<?php
// Function to get the current theme directory name
function get_current_theme_directory() {
    return get_option('template'); // Using 'stylesheet' option for current theme directory
    return get_option('stylesheet'); // Using 'stylesheet' option for current theme directory
}
// Function to store the current theme
function store_original_theme_template() {
    //Set original template name
    $original_theme_template = get_option('original_theme_template');
    delete_option('original_theme_template');
    $current_theme_template = get_option('template');
    update_option('original_theme_template', $current_theme_template);
}
function store_original_theme_stylesheet() {
    //Set original stylesheet name
    $original_theme_stylesheet = get_option('original_theme_stylesheet');
    delete_option('original_theme_stylesheet');
    $current_theme_stylesheet = get_current_theme_directory();
    update_option('original_theme_stylesheet', $current_theme_stylesheet);
}
// Function to switch to a theme
function switch_to_theme($theme) {
    switch_theme($theme);
}
// Include the necessary WordPress files for theme installation and deletion
if (!class_exists('WP_Upgrader')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
}
if (!class_exists('WP_Upgrader_Skin')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skins.php';
}
if (!function_exists('delete_theme')) {
    require_once ABSPATH . 'wp-admin/includes/theme.php';
}
// Custom WP_Upgrader_Skin to suppress output
class Silent_Upgrader_Skin extends \WP_Upgrader_Skin {
    public function feedback($string, ...$args) {
        // No output
    }
}
// Check if default_theme is set to true
if (isset($default_theme) && $default_theme) {
    $wp_2024_theme = 'default_wp_theme'; // Theme directory name of WordPress 2024 theme
    // Store the current theme template if not already stored
    if (!get_option('original_theme_template')) {
        store_original_theme_template();
    }
    // Store the current theme stylesheet if not already stored
    if (!get_option('original_theme_stylesheet')) {
        store_original_theme_stylesheet();
    }
    // Check if the WordPress 2024 theme is installed
    $installed_themes = wp_get_themes();
    if (!array_key_exists($wp_2024_theme, $installed_themes)) {
        // WordPress 2024 theme is not installed, so install it
	// Get the plugin directory path
	$plugin_dir = plugin_dir_url( __FILE__ );
	// Append the file name to the plugin directory URL
	$theme_zip_url = $plugin_dir . 'theme/default_wp_theme.zip';
        // Suppress output using custom skin
        $skin = new Silent_Upgrader_Skin();
        $theme_installer = new Theme_Upgrader($skin);
        $theme_install_result = $theme_installer->install($theme_zip_url);
        if (!is_wp_error($theme_install_result)) {
            // Installation succeeded, now activate the theme
            //switch_to_theme($wp_2024_theme);
        }
    } else {
        // WordPress 2024 theme is already installed, so just activate it
        //switch_to_theme($wp_2024_theme);
    }
} else {
    // If default_theme is set to false, revert back to the original active theme
    $original_theme_template = get_option('original_theme_template');
    if ($original_theme_template) {
        switch_to_theme($original_theme_template);
        // Remove the stored original theme option
        //delete_option('original_theme_template');
    }
    $original_theme_stylesheet = get_option('original_theme_stylesheet');
    if ($original_theme_stylesheet) {
        switch_to_theme($original_theme_stylesheet);
        // Remove the stored original theme option
        //delete_option('original_theme_stylesheet');
    }
    // Delete the WordPress 2024 theme
   $wp_2024_theme = 'default_wp_theme';
   $installed_themes = wp_get_themes();
    if (array_key_exists($wp_2024_theme, $installed_themes)) {
       delete_theme($wp_2024_theme);
    	}
}
?>