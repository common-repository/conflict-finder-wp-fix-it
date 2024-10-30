<?php
// Add options page
function conflict_finder_menu() {
    add_submenu_page('tools.php', 'Plugin Conflict Finder Options', 'Conflict Finder', 'manage_options', 'conflict-finder', 'conflict_finder_options_page');
}
add_action('admin_menu', 'conflict_finder_menu');
function add_conflict_finder_admin_bar_menu($wp_admin_bar) {
    if (current_user_can('manage_options')) { // Check if the current user can manage options (typically administrators)
        // Add a parent menu item
        $wp_admin_bar->add_menu(array(
            'parent' => 'top-secondary', // Add to the right side of the admin bar
            'id' => 'conflict-finder',
            'title' => '<span class="ab-icon dashicons dashicons-superhero conflict-finder-icon"></span><span class="ab-item conflict-finder-text">Conflict Finder</span>',
            'href' => admin_url('tools.php?page=conflict-finder'), // Link to your conflict finder page
            'meta' => array(
                'title' => 'Conflict Finder', // Title without icon markup (for accessibility)
                'class' => 'conflict-finder-link'
            ),
        ));
    }
}
add_action('admin_bar_menu', 'add_conflict_finder_admin_bar_menu', 999);
