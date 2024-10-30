<?php
// Function to save the email into the database
function save_error_notification_email() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['notification_email'])) {
        // Verify nonce
        if (isset($_POST['error_notification_nonce']) && wp_verify_nonce($_POST['error_notification_nonce'], 'error_notification_nonce_action')) {
            // Validate email
            if (filter_var($_POST['notification_email'], FILTER_VALIDATE_EMAIL)) {
                // Sanitize email using WordPress core function
                $notification_email = sanitize_email($_POST['notification_email']);
                // Save email to the database
                update_option('error_notification_email', $notification_email);
                // Display success message
                echo '<p id="saved_email" style="color: green;">Email notifications have been enabled!</p>';
            } 
        } 
    }
}
// Call the function to handle the form submission
save_error_notification_email();
// Function to clear the saved email from the database
function clear_error_notification_email() {
    if (isset($_POST['clear_notification_email'])) {
        // Verify nonce
        if (isset($_POST['error_notification_nonce']) && wp_verify_nonce($_POST['error_notification_nonce'], 'error_notification_nonce_action')) {
            // Clear the email option from the database
            delete_option('error_notification_email');
            delete_transient( 'conflict_finder_email_sent' );
            // Display success message
            echo '<style>#saved_email{display:none !important}</style>';
            echo '<p style="color: green;">Email notifications have been disabled!</p>';
        } else {
            // Display error message for nonce verification failure
            echo '<p style="color: red;">Nonce verification failed. Please try again.</p>';
        }
    }
}
// Call the function to handle clearing the email
clear_error_notification_email();
// Retrieve the saved email from the database
$saved_email = get_option('error_notification_email', '');
?>