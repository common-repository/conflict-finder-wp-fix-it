<?php
// Hook to admin_init to initialize our functionality
add_action('admin_init', 'prevent_theme_switching_access');

function prevent_theme_switching_access() {
    // Check if the default theme is set and active
    $default_theme = get_option('default_theme');
    if (isset($default_theme) && $default_theme) {
        // Verify nonce before allowing theme switching prevention
        if (isset($_GET['action']) && $_GET['action'] === 'activate' && isset($_GET['theme'])) {
            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'prevent_theme_switching')) {
                wp_die(esc_html__('Nonce verification failed. You are not allowed to switch themes.', 'text-domain'));
            }
            wp_die(esc_html__('You are not allowed to switch themes.', 'text-domain'));
        }

        // Remove the activation and deletion links from the themes page
        add_action('admin_head', 'hide_theme_action_buttons');
        add_filter('theme_action_links', 'filter_theme_action_links', 10, 2);
    }
}

function hide_theme_action_buttons() {
    $screen = get_current_screen();
    if ($screen->id === 'themes') {
        ?>
        <style>
            .theme-actions .activate, .theme-actions .delete-theme {
                display: none !important;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                $(".theme-actions .activate, .theme-actions .delete-theme").remove();
            });
        </script>
        <?php
    }
}

function filter_theme_action_links($actions, $theme) {
    if (isset($actions['activate'])) {
        unset($actions['activate']);
    }
    if (isset($actions['delete'])) {
        unset($actions['delete']);
    }
    return $actions;
}

add_action('admin_notices', 'themes_page_reset_admin_notice', 1);

function themes_page_reset_admin_notice() {
    // Check if the default theme is active
    $default_theme = get_option('default_theme');
    if (isset($default_theme) && $default_theme) {
        if (isset($_POST['themes_page_reset']) && current_user_can('administrator')) {
            // Verify nonce
            if (isset($_POST['themes_page_reset_nonce']) && wp_verify_nonce($_POST['themes_page_reset_nonce'], 'themes_page_reset_nonce')) {
                // Nonce is verified, proceed with form processing
                update_option('default_theme', false);
                set_transient('theme_reset_notice', true, 30);

                // Delete the WordPress 2024 theme
                $wp_2024_theme = 'default_wp_theme';
                $installed_themes = wp_get_themes();
                if (array_key_exists($wp_2024_theme, $installed_themes)) {
                    delete_theme($wp_2024_theme);
                }

                // Redirect to avoid form resubmission and display the notice
                wp_redirect(admin_url('themes.php'));
                exit;
            } else {
                // Nonce verification failed, handle error or logging
                wp_die(esc_html__('Nonce verification failed.', 'text-domain'));
            }
        }

        // Ensure this notice is only displayed on the themes page
        $screen = get_current_screen();
        if ($screen->id !== 'themes') {
            return;
        }

        ?>
        <style>
            .custom-notice-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .custom-notice-content p {
                margin: 0;
            }
            .custom-notice-content form {
                margin: 0;
            }
            div#themes_page_reset {
                background: #efe;
                padding: 15px;
                border-left: 4px solid #d63638;
            }
            input#conflict_crash_reset {
                font-size: 15px;
            }
            a.hide-if-no-js.page-title-action {display: none;}
            .inactive-theme {display: none !important;}
            .theme-actions {display: none !important;}
        </style>
        <div id="themes_page_reset" class="notice notice-warning">
            <div class="custom-notice-content">
                <p><?php echo esc_html__('Theme actions are disabled because you have modified the active theme using Conflict Finder. Click the RESET THEME button to get these options back.', 'text-domain'); ?></p>
                <form method="post" action="">
                    <?php wp_nonce_field('themes_page_reset_nonce', 'themes_page_reset_nonce'); ?>
                    <input id="conflict_crash_reset" type="submit" name="themes_page_reset" class="button button-primary" value="<?php echo esc_attr__('RESET THEME', 'text-domain'); ?>">
                </form>
            </div>
        </div>
        <?php
    }
}

function show_theme_reset_notice() {
    if (get_transient('theme_reset_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php echo esc_html__('All theme functions have been restored.', 'text-domain'); ?></p>
        </div>
        <?php
        // Delete the transient to ensure the notice is shown only once
        delete_transient('theme_reset_notice');
    }
}

// Hook the functions to appropriate actions
add_action('admin_notices', 'show_theme_reset_notice', 1);
?>