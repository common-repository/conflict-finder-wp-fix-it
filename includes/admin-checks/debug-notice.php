<?php
// Function to show an admin notice with a disable button
function show_debug_notice() {
    ?>
    <div class="notice notice-error" style="padding: 15px !important; background:#efe !important; position: relative; display: flex; align-items: center; justify-content: space-between;">
        <p style="font-size:16px !important;margin: 0; padding-right: 20px;">Debug messages are turned on for all visitors. This should remain off at all times if you are not debugging an issue. Click the <strong>DISABLE THIS</strong> button to deactivate.</p>
        <form style="float: right !important;" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('reset_debug_mode_nonce', 'reset_debug_mode_nonce'); ?>
            <input id="conflict_crash_reset" type="submit" name="reset_debug_mode" class="button button-primary" value="DISABLE THIS">
            <input type="hidden" name="action" value="handle_debug_reset">
        </form>
    </div>
    <?php
}
// Function to show a notice that debug mode has been disabled
function show_debug_disabled_notice() {
    if (get_transient('debug_disabled_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Debug mode has been disabled for all non-admin users.</p>
        </div>
        <?php
        // Delete the transient to ensure the notice is shown only once
        delete_transient('debug_disabled_notice');
    }
}
// Function to handle form submission and reset debug mode
function handle_debug_reset() {
    if (isset($_POST['reset_debug_mode']) && check_admin_referer('reset_debug_mode_nonce', 'reset_debug_mode_nonce')) {
        update_option('debug_display_mode', false);
        set_transient('debug_disabled_notice', true, 30);
        // Redirect to avoid form resubmission and display the notice
        wp_redirect(admin_url());
        exit;
    }
}
// Function to check the option and add the notice if needed
function check_and_show_debug_notice() {
    if (get_option('debug_display_mode')) {
        add_action('admin_notices', 'show_debug_notice', 1);
    }
}
// Hook the functions to appropriate actions
add_action('admin_init', 'check_and_show_debug_notice');
add_action('admin_post_handle_debug_reset', 'handle_debug_reset');
add_action('admin_notices', 'show_debug_disabled_notice', 1);
?>