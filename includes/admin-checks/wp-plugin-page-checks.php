<?php
add_action('admin_init', 'prevent_plugin_activation_deactivation');

function prevent_plugin_activation_deactivation() {
    $selected_plugins = get_option('selected_plugins', array());
    if (!empty($selected_plugins)) {
        add_filter('plugin_action_links', 'disable_plugin_action_links', 10, 4);
        add_filter('bulk_actions-plugins', 'disable_bulk_actions');
        add_filter('handle_bulk_actions-plugins', 'disable_bulk_action_handling', 10, 3);
    }
}

function disable_plugin_action_links($actions, $plugin_file, $plugin_data, $context) {
    if (isset($actions['deactivate'])) {
        unset($actions['deactivate']);
    }
    if (isset($actions['activate'])) {
        unset($actions['activate']);
    }
    if (isset($actions['delete'])) {
        unset($actions['delete']);
    }
    return $actions;
}

function disable_bulk_actions($actions) {
    if (isset($actions['deactivate-selected'])) {
        unset($actions['deactivate-selected']);
    }
    if (isset($actions['activate-selected'])) {
        unset($actions['activate-selected']);
    }
    if (isset($actions['delete-selected'])) {
        unset($actions['delete-selected']);
    }
    return $actions;
}

function disable_bulk_action_handling($redirect_to, $doaction, $plugin_ids) {
    if ($doaction === 'deactivate-selected' || $doaction === 'activate-selected') {
        $redirect_to = remove_query_arg(array('deactivate-selected', 'activate-selected'), $redirect_to);
    }
    return $redirect_to;
}

function remove_add_new_plugin_button() {
    remove_submenu_page('plugins.php', 'plugin-install.php');
    global $pagenow;
    if ($pagenow === 'plugins.php') {
        add_action('admin_footer', function() {
            ?>
            <script type="text/javascript">
                document.querySelector('.wrap .page-title-action').style.display = 'none';
            </script>
            <?php
        });
    }
}

$selected_plugins = get_option('selected_plugins', array());
if (!empty($selected_plugins)) {
    add_action('admin_enqueue_scripts', 'remove_add_new_plugin_button');
}

add_action('current_screen', 'plugin_page_reset_admin_notice');

function plugin_page_reset_admin_notice($screen) {
    if ($screen->id !== 'plugins') {
        return;
    }

    $selected_plugins = get_option('selected_plugins', array());
    if (!empty($selected_plugins)) {
        if (isset($_POST['plugin_page_reset']) && current_user_can('administrator')) {
            // Verify nonce
            if (isset($_POST['plugin_page_reset_nonce']) && wp_verify_nonce($_POST['plugin_page_reset_nonce'], 'plugin_page_reset_nonce')) {
                // Nonce is verified, proceed with form processing
                update_option('selected_plugins', array());
                set_transient('plugin_reset_notice', true, 30);
                // Redirect to avoid form resubmission and display the notice
                wp_safe_redirect(admin_url('plugins.php'));
                exit;
            } else {
                // Nonce verification failed, handle error or logging
                wp_die('Nonce verification failed.');
            }
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
            div#plugin_page_reset {
                background: #efe;
                padding: 15px;
            }
            div#plugin_page_reset p {
                font-size: 16px;
            }
            #plugin_page_reset.notice {
                border-left: 4px solid #d63638;
            }
            input#conflict_crash_reset {
                font-size: 15px;
            }
        </style>
        <div id="plugin_page_reset" class="notice notice-error">
            <div class="custom-notice-content">
                <p><?php esc_html_e('Plugin actions are disabled because you have modified the active plugin list using Conflict Finder. Click the RESET PLUGINS button to get these options back.', 'text-domain'); ?></p>
                <form style="float: right !important;" method="post" action="">
                    <?php wp_nonce_field('plugin_page_reset_nonce', 'plugin_page_reset_nonce'); ?>
                    <input id="conflict_crash_reset" type="submit" name="plugin_page_reset" class="button button-primary" value="<?php esc_attr_e('RESET PLUGINS', 'text-domain'); ?>">
                </form>
            </div>
        </div>
        <?php
    }
}

function show_plugin_reset_notice() {
    if (get_transient('plugin_reset_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e('All plugin functions have been restored.', 'text-domain'); ?></p>
        </div>
        <?php
        // Delete the transient to ensure the notice is shown only once
        delete_transient('plugin_reset_notice');
    }
}

// Hook the functions to appropriate actions
add_action('admin_notices', 'show_plugin_reset_notice', 1);
?>