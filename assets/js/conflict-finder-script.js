document.addEventListener('DOMContentLoaded', function() {
        const toggleActiveButton = document.getElementById('toggle-active-plugins');
        const activePluginCheckboxes = document.querySelectorAll('.active-plugin');
        toggleActiveButton.addEventListener('click', function() {
            const allActiveChecked = Array.from(activePluginCheckboxes).every(function(checkbox) {
                return checkbox.checked;
            });
            Array.from(activePluginCheckboxes).forEach(function(checkbox) {
                checkbox.checked = !allActiveChecked;
            });
            toggleActiveButton.textContent = allActiveChecked ? 'Select All' : 'Deselect All';
        });
    });
    
document.addEventListener('DOMContentLoaded', function() {
        const toggleInactiveButton = document.getElementById('toggle-inactive-plugins');
        const inactivePluginCheckboxes = document.querySelectorAll('.inactive-plugin');
        toggleInactiveButton.addEventListener('click', function() {
            const allInactiveChecked = Array.from(inactivePluginCheckboxes).every(function(checkbox) {
                return checkbox.checked;
            });
            Array.from(inactivePluginCheckboxes).forEach(function(checkbox) {
                checkbox.checked = !allInactiveChecked;
            });
            toggleInactiveButton.textContent = allInactiveChecked ? 'Select All' : 'Deselect All';
        });
    });
    
document.getElementById('error-notification-form').addEventListener('submit', function(event) {
        var email = document.getElementById('notification_email').value;

        // Basic email validation using a regular expression
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!emailRegex.test(email)) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('email-error-msg').style.display = 'block';
        } else {
            document.getElementById('email-error-msg').style.display = 'none';
        }
    });