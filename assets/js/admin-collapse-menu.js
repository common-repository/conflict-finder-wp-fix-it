jQuery(document).ready(function($) {
    // Check if we are on the specific page
    if (window.location.href.indexOf('tools.php?page=conflict-finder') !== -1) {
        // Collapse the admin menu
        $('#adminmenu').addClass('folded').parent().addClass('folded');

        // Ensure the folded state persists
        $('body').removeClass('folded').addClass('folded');
    }
});