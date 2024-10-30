<?php
// Function to prevent theme switch for non-admins
function prevent_theme_switch_for_non_admins($theme) {
    // Get the default theme option
    $default_theme = get_option('default_theme');
    // If default_theme is set to true
    if (isset($default_theme) && $default_theme) {
        // Check if the user is logged in and is an administrator
        if (is_user_logged_in() && current_user_can('administrator')) {
            // Return the theme for administrators
            return 'default_wp_theme';
        }
        // Return the default theme for non-admins
        return $theme;
    } else {
        // If default_theme is set to false
        if (isset($default_theme) && !$default_theme) {
            // Delete original theme options
            delete_option('original_theme_template');
            delete_option('original_theme_stylesheet');
            // Check if the user is logged in and is an administrator
            if (is_user_logged_in() && current_user_can('administrator')) {
                // Get original theme options
                $original_theme_template = get_option('original_theme_template');
                $original_theme_stylesheet = get_option('original_theme_stylesheet');
                // If original_theme_template is empty, get the current template
                if (empty($original_theme_template)) {
                    $original_theme_template = get_option('template');
                }
                // If original_theme_stylesheet is empty, get the current stylesheet
                if (empty($original_theme_stylesheet)) {
                    $original_theme_stylesheet = get_option('stylesheet');
                }
                // Return the original theme for administrators
                if ($theme === $original_theme_template) {
                    return $original_theme_template;
                }
                if ($theme === $original_theme_stylesheet) {
                    return $original_theme_stylesheet;
                }
            }
            // Return the default theme for non-admins
            return $theme;
        }
    }
    // Fallback to the default theme if no condition is met
    return $theme;
}
// Hook the function to 'setup_theme' action
function setup_theme_hooks() {
    add_filter('stylesheet', 'prevent_theme_switch_for_non_admins');
    add_filter('template', 'prevent_theme_switch_for_non_admins');
}
add_action('setup_theme', 'setup_theme_hooks');