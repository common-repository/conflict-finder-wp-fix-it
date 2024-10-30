<?php
// Restore original active plugins list
function restore_original_active_plugins() {
    // Get the original active plugins list
    $original_active_plugins = get_option('original_active_plugins');
    
    // Update the active plugins option with the original list
    update_option('active_plugins', $original_active_plugins);
}
?>