<?php
// Options page content
?>
<link rel="stylesheet" type="text/css" href="<?php echo esc_url(plugin_dir_url(__FILE__) . '../assets/css/conflict-finder-styles.css'); ?>">
<div id="top_options" class="wrap">
    <h1><span class="dashicons dashicons-superhero"></span> Conflict Finder Options</h1>
    <div style="margin-top:10px;display: flex;">
        <div style="flex: 1; margin-right: 20px; background-color: #fff; padding: 20px; border: 1px solid #ddd;border-radius: 12px">
<div style="display: flex;margin-bottom:23px">
<div style="flex: 1;margin-top: 10px;">
            <!-- Input field for IFRAME --><div style="background: #efe;max-width: 444px;padding: 20px;border: solid 1px #ccc;border-radius: 12px;">
<h1 style="font-size: 21px;"><strong>Enter the URL where you see an issue:</strong><button id="conflict-url-info" class="info-icon" type="button">?</button></h1>
<form method="post" action="">
<?php wp_nonce_field('conflict_finder_options', 'conflict_finder_options_nonce'); ?>
<input type="text" id="iframe_url" name="iframe_url" value="<?php echo esc_attr($iframe_url); ?>" style="width: 433px;margin-bottom:15px;" pattern="https?://.+">
 <!-- Modal -->
        <div id="conflict-url-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1 style="font-size: 21px;">Conflict Finder URL Entry - <span style="color:#f99568">HOW TO VIDEO</span></h1>
                <hr>
                <p><strong>Watch the short video below to see how you can use this option to find a conflict.</strong></p>
                <br>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
<p style="margin-top: -5px;color:#eb4034;font-size:14px !important">Must a valid URL (ex. https://example.com)</p></div>
</div>
<div style="flex: 1;">
<h1 style="font-size: 21px;">Activate Default WordPress Theme:<button id="default-theme-info" class="info-icon" type="button">?</button></h1>
<p>Turn on the default WordPress theme to see if there is a theme conflict.<br><span style="color:#eb4034;font-size:14px">Only turned on for admin users. Other users will not be affected.</span></p>
 <!-- Modal -->
        <div id="default-theme-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1 style="font-size: 21px;">Activate Default WordPress Theme - <span style="color:#f99568">HOW TO VIDEO</span></h1>
                <hr>
                <p><strong>Watch the short video below to see how you can use this option to find a conflict.</strong></p>
                <br>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
<label class="switch" style="">
    <input type="checkbox" name="default_theme" <?php checked($default_theme); ?>>
    <span class="slider round"></span>
</label>
<span style="font-size:16px; padding: 13px;"><?php echo $default_theme ? '<strong>Default theme is active</strong>' : '<strong>Default theme is inactive</strong>'; ?></span>
</div>
</div>
<hr>
<div style="display: flex;margin-bottom:23px">
<div style="flex: 3;">
        <h1 style="font-size: 21px;">Debug Messages Mode:<button id="debug-mode-info" class="info-icon" type="button">?</button></h1>
        <p>Enable to view debugging messages. <br>
        <span style="color:#eb4034; font-size:14px">Only admin users will see these messages.</span></p>
        <!-- Modal -->
        <div id="debug-mode-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1 style="font-size: 21px;">Debug Messages Mode - <span style="color:#f99568">HOW TO VIDEO</span></h1>
                <hr>
                <p><strong>Watch the short video below to see how you can use this option to find a conflict.</strong></p>
                <br>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
        <label class="switch" style="">
    <input type="checkbox" name="debug_mode" <?php checked($debug_mode); ?>>
    <span class="slider round"></span>
</label>
<span style="font-size:16px; padding: 13px;"><?php echo $debug_mode ? '<strong>Debug mode is on</strong>' : '<strong>Debug mode is off</strong>'; ?></span>
    </div>      
<div style="flex: 3;">
 <h1 style="font-size: 21px;">Debug Messages Display:<button id="debug-display-info" class="info-icon" type="button">?</button></h1>
            <p>Setting to display debugging messages. <br>
            <span style="color:#eb4034; font-size:14px">Display errors for all users.</span></p>
            <!-- Modal -->
        <div id="debug-display-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1 style="font-size: 21px;">Debug Messages Display - <span style="color:#f99568">HOW TO VIDEO</span></h1>
                <hr>
                <p><strong>Watch the short video below to see how you can use this option to find a conflict.</strong></p>
                <br>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
            <label class="switch" style="">
    <input type="checkbox" name="debug_display_mode" <?php checked($debug_display_mode); ?>>
    <span class="slider round"></span>
</label>
<span style="font-size:16px; padding: 13px;"><?php echo $debug_display_mode ? '<strong>On for all users</strong>' : '<strong>On for admin users</strong>'; ?></span>
</div>
<div style="flex: 3;">
<h1 style="font-size: 21px;">Debug Logged Out Mode:<button id="debug-logged-out-info" class="info-icon" type="button">?</button></h1>
            <p>View site errors logged out. <br>
            <span style="color:#eb4034; font-size:14px">Logged out preview will show below.</span></p>
                        <!-- Modal -->
        <div id="debug-logged-out-info-modal" class="modal">
              <div class="modal-content">
                <span class="close">&times;</span>
                <h1 style="font-size: 21px;">Debug Logged Out Mode - <span style="color:#f99568">HOW TO VIDEO</span></h1>
                <hr>
                <p><strong>Watch the short video below to see how you can use this option to find a conflict.</strong></p>
                <br>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
            <label class="switch" style="">
    <input type="checkbox" name="disable_plugins_all_mode" <?php checked($disable_plugins_all_mode); ?>>
    <span class="slider round"></span>
</label>
<span style="font-size:16px; padding: 13px;"><?php echo $disable_plugins_all_mode ? '<strong>Logged out preview enabled</strong>' : '<strong>Logged out preview disabled</strong>'; ?></span>
</div>
            </div>
<hr>
            <h1 style="font-size: 21px;">Disable Active Plugins Below:<button id="disable-plugins-info" class="info-icon" type="button">?</button></h1>
            <!-- Modal -->
        <div id="disable-plugins-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h1 style="font-size: 21px;">Disable Active Plugins - <span style="color:#f99568">HOW TO VIDEO</span></h1>
                <hr>
                <p><strong>Watch the short video below to see how you can use this option to find a conflict.</strong></p>
                <br>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
            <p style="font-size:16px">Select the plugin(s) below you would like to turn off to track down a plugin conflict. Click "<strong>Start Over</strong>" to revert to original activated plugins and settings.<br><span style="color:#eb4034;font-size:14px">These will only be turned off for admin users. Other users will not be affected.</span></p>
                <div style="margin-bottom: -25px;display: flex;margin-top:0px;background: #efe;border-radius: 12px;padding: 0px 33px 33px 33px;border: solid 1px #ccc;">
<?php if (!empty($active_plugins_with_names)) : ?>
    <div style="flex: 1; margin-right: 20px;">
    <h2 style="color: #00D78B;margin-bottom: -10px;padding: 10px 0px;margin-left: -5px;font-size: 23px;text-transform: uppercase;">Active Plugin List</h2>    <p style="font-size:14px">Check to move to inactive list</p>
     <button style="margin-top: -15px;margin-left: -10px;" type="button" id="toggle-active-plugins">Select All</button><br>
        <?php foreach ($active_plugins_with_names as $plugin_path => $plugin_name) : ?>
            <?php
            // Skip the Conflict Finder plugin
            $plugin_dirname = dirname($plugin_path);
            if (strpos($plugin_dirname, 'conflict-finder-wp-fix-it') !== false) {
                continue;
            }
            ?>
            <?php $is_none_checked = count($selected_plugins) === 0; // None checked
		if ($is_none_checked) : ?>
    			<style> div#inactive-plugin-list {display: none !important;}</style>
	    <?php endif; ?>
            <label class="plugin-label">
                <input type="checkbox" class="plugin-checkbox active-plugin" name="selected_plugins[]" value="<?php echo esc_attr($plugin_path); ?>" <?php checked(in_array($plugin_path, $selected_plugins)); ?>>
                <?php echo esc_html($plugin_name); ?>
            </label><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if (!empty($inactive_plugins_with_names)) : ?>
    <div id="inactive-plugin-list" style="flex: 1;">
        <h2 style="color: #eb4034;margin-bottom: -10px;padding: 10px 0px;margin-left: -5px;font-size: 23px;text-transform: uppercase;">Inactive Plugin List</h2>
        <p style="font-size:14px">Un-check to move to active list</p>
        <button style="margin-top: -15px;margin-left: -10px;" type="button" id="toggle-inactive-plugins">Deselect All</button><br>
        <?php foreach ($inactive_plugins_with_names as $plugin_path => $plugin_name) : ?>
            <?php
            // Skip the Conflict Finder plugin
            $plugin_dirname = dirname($plugin_path);
            if (strpos($plugin_dirname, 'conflict-finder-wp-fix-it') !== false) {
                continue;
            }
            ?>
            <?php $is_plugin_selected = in_array($plugin_path, $selected_plugins); ?>
            <?php if ($is_plugin_selected) : ?>
                <label class="plugin-label">
                    <input type="checkbox" class="plugin-checkbox inactive-plugin" name="selected_plugins[]" value="<?php echo esc_attr($plugin_path); ?>" <?php checked($is_plugin_selected); ?>>
                    <?php echo esc_html($plugin_name); ?>
                </label><br>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
                </div>
                <br>           
                <p class="submit">
                    <input id="Conflict_Submit" type="submit" name="submit" class="button-primary" value="Save Changes">
                    <input id="Conflict_Reset"  type="submit" name="reset" class="button" value="Start Over">
                </p>
            </form>
            <hr>
            <div id="page_preview" style="flex: 1;">
    <h1 style="font-size: 21px;">Logged In Preview<span style="font-size:16px;color: #eb4034;"> - this is the logged in version of the issue page</span><button id="logged-in-preview-info" class="info-icon" type="button">?</button></h1>
    <!-- Modal -->
        <div id="logged-in-preview-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
    <?php echo esc_url($iframe_url); ?>
    <br><br>
    <div>
        <button id="desktop-view">Desktop View</button>
        <button id="tablet-view">Tablet View</button>
        <button id="mobile-view">Mobile View</button>
        <button id="refresh-preview" style="margin-left: 10px;">Refresh Preview</button>
    </div>
    <style>
    .iframe-container {
    background: url('<?php echo esc_url(plugins_url('conflict-finder-wp-fix-it/assets/img/loading.gif')); ?>');background-repeat: no-repeat !important;background-position: center center !important;
	}
    </style>
<div class="iframe-container">
    <iframe id="logged-in-preview" src="<?php echo esc_url($iframe_url); ?>" style="margin-top: 23px; width: 100%; height: 800px; border: 1px solid #ddd; box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);border-radius: 12px; overflow: hidden;" onload="resizeIframe(this)"></iframe>
    </div>
</div>
<!--Show logged out view in preview window -->
<br>
<?php
$default_disable_plugins_all_mode = get_option('disable_plugins_all_mode');?>
<?php if ($default_disable_plugins_all_mode): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var iframe = document.getElementById('logged-out-preview');
    if (iframe) {
        iframe.onload = function() {
            resizeIframe(iframe);
            hideElementsInIframe(iframe);
            observeIframeChanges(iframe);
        };
        
        function resizeIframe(iframe) {
            var maxHeight = 800; // Set your maximum height here
            var newHeight = Math.min(iframe.contentWindow.document.documentElement.scrollHeight, maxHeight);
            iframe.style.height = newHeight + 'px';
        }

        function hideElementsInIframe(iframe) {
            const inputElement = iframe.contentWindow.document.querySelector('#conflict_crash_reset');
            const anchorElement = iframe.contentWindow.document.querySelector('#troubleshoot_button');
            const textElement = iframe.contentWindow.document.querySelector('strong#button_stuck_text');
            
            if (inputElement) {
                inputElement.style.display = 'none';
            }
            if (anchorElement) {
                anchorElement.style.display = 'none';
            }
            if (textElement) {
                textElement.style.display = 'none';
            }
        }

        function observeIframeChanges(iframe) {
            const observer = new MutationObserver(function(mutations) {
                hideElementsInIframe(iframe);
                resizeIframe(iframe); // Adjust height on content change
            });
            observer.observe(iframe.contentWindow.document.body, { childList: true, subtree: true });
        }

        // Adjust height periodically for dynamically changing content
        setInterval(function() {
            resizeIframe(iframe);
        }, 1000);

    } else {
        console.warn('Iframe with ID "logged-out-preview" not found.');
    }
});
</script>
<div id="logged_out_page_preview" style="flex: 1;">
<br>
<?php
    
    $iframe_url = get_option('iframe_url'); // Fetch the option from the database
    // Check if the iframe_url contains 'wp-admin'
if (strpos($iframe_url, 'wp-admin') === false) {
    // If 'wp-admin' is not found in the iframe_url, render the iframe
    ?>
    <h1 style="font-size: 21px;">Logged Out Preview<span style="font-size:16px;color: #eb4034;"> - this is the logged out version of the issue page</span><button id="logged-out-preview-info" class="info-icon" type="button">?</button></h1>
    <!-- Modal  -->
        <div id="logged-out-preview-info-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Content coming in a future release...</p>
            </div>
        </div>
        <!-- End Modal -->
     <?php echo esc_url($iframe_url); ?>
     <br><br>
    <div>
        <button id="desktop-view-logged-out">Desktop View</button>
        <button id="tablet-view-logged-out">Tablet View</button>
        <button id="mobile-view-logged-out">Mobile View</button>
        <button id="refresh-preview-logged-out" style="margin-left: 10px;">Refresh Preview</button>
    </div>
    <style>
    .iframe-container {
    background: url('<?php echo esc_url(plugins_url('conflict-finder-wp-fix-it/assets/img/loading.gif')); ?>');background-repeat: no-repeat !important;background-position: center center !important;
	}
    </style>
    <?php $logged_out_url = esc_url(plugins_url('conflict-finder-wp-fix-it/includes/logged-out-view.php'));?>
    <div class="iframe-container-logged-out">
<iframe id="logged-out-preview" src="<?php echo esc_url($logged_out_url); ?>" style="margin-top: 23px; width: 100%; border: 1px solid #ddd; box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5); border-radius: 12px; pointer-events: none; overflow: hidden;" onload="resizeIframe(this)"></iframe>
 </div>
<?php } ?>
</div>
<?php endif; ?>
        </div>
         <div id="conflict-finder-sidebar" style="width: 20%;">
         <div class="notification-bar">
    <form id="error-notification-form" method="post" action="">
        <?php wp_nonce_field('error_notification_nonce_action', 'error_notification_nonce'); ?>
        <label id="get-notified-label" for="notification_email"><strong><span style="margin-top: -3px;" class="dashicons dashicons-email-alt"></span> Get Error Notifications</strong></label>
        <input style="width: 100% !important;" type="email" id="notification_email" name="notification_email" placeholder="Enter notification email address" value="<?php echo esc_attr($saved_email); ?>" required>
        <input type="submit" id="error-notify-button" name="save_notification_email" value="GET NOTIFIED">
        <?php
        $to = get_option('error_notification_email');
        // Check if the recipient email is not empty
	if ( ! empty( $to ) ) {
	?>
        <input type="submit" id="error-clear-button" name="clear_notification_email" value="DISABLE">
        <?php } ?>
        <p id="email-error-msg" style="display: none; color: red; margin-top: 5px;">Please enter a valid email address.</p>
        <p style="margin-top: 10px; font-size: 14px;">Receive an email if there is a detected error on your website showing you the exact location and error details</p>
    </form>
</div>
         <div style="background: #fff;padding: 15px;border: solid 1px #ccc;border-radius: 12px;margin-bottom:55px">
         <h2><span class="dashicons dashicons-wordpress"></span> WordPress Information</h2>
            <div id="wordpress-info">
                <p><span style="font-size:14px">WordPress Version:</span> <strong><?php echo esc_html($wp_version); ?></strong></p>
                <p><span style="font-size:14px">Active Theme:</span> <strong><?php echo esc_html($theme_name); ?></strong></p>
                <p><span style="font-size:14px">Installed Plugins Amount:</span> <strong><?php echo esc_html($plugin_count); ?></strong></p>
                <?php if ($total_updates > 0): ?>
<p><span style="font-size:14px;">Available Updates:</span> <strong><a href="<?php echo esc_url(admin_url('update-core.php')); ?>"><span class="conflict-finder-update-count"><?php echo esc_html($total_updates); ?></span></a></strong></p>
                <?php else: ?>
		<p><span style="font-size:14px">Available Updates:</span> <strong>0</strong></p>
    		<?php endif; ?>
            </div>
            <hr>
            <h2><span class="dashicons dashicons-admin-generic"></span> Server Information</h2>
            <div id="server-info">
                <p><span style="font-size:14px">PHP Version:</span> <strong><?php echo esc_html(phpversion()); ?></strong></p>
                <p><span style="font-size:14px">Software:</span> <strong><?php echo esc_html($_SERVER['SERVER_SOFTWARE']); ?></strong></p>
                <p><span style="font-size:14px">Operating System:</span> <strong><?php echo esc_html(php_uname('s')); ?></strong></p>
                <p><span style="font-size:14px">IP Address:</span> <strong><?php echo esc_html($_SERVER['SERVER_ADDR']); ?></strong></p>
            </div>
            </div>
            <div class="inside">
            <div id="plugin-info" style="display: none;">
		<button id="close-plugin-info" style="top: 10px; right: 10px;">HIDE THIS INFO BELOW</button>
            <h2 class="hndle" style="text-align: center;font-size:15px"><span>- <?php esc_html_e('this plugin provided to you by', 'text-domain'); ?> -</span></h2>
                <a href="https://www.wpfixit.com/" target="_blank">
                    <img src="<?php echo esc_url(plugins_url('conflict-finder-wp-fix-it/assets/img/logo.png')); ?>" alt="<?php esc_attr_e('WP Fix It', 'text-domain'); ?>" style="width:90%;display: block; margin: 0 auto 20px;">
                </a>
                <hr>
                <p style="font-size:16px"><strong><?php esc_html_e('Need Emergency WordPress Help?', 'text-domain'); ?></strong><br>
                    </p>
                <p style="font-size:16px">
                    <?php esc_html_e('We are the only true 24/7 emergency WordPress support company that can offer you immediate WordPress issue resolution when you need it.', 'text-domain'); ?>
                    <br><br>
                    <?php esc_html_e('Our average resolve time here to get an issue that is troubling your WordPress website fixed is 30 minutes or less.', 'text-domain'); ?>
                    <br><br>
                    <?php esc_html_e('We have a team of skilled agents available 24 hours a day 7 days a week to take on WordPress support issues and then resolve them. We are always open and ready to fix WordPress issues FAST! The average resolve time here is 30 minutes.', 'text-domain'); ?>
                    <br>
                    <hr>
                    <p><h3 style="text-align: center;line-height: 1.4;"><a href="https://www.wpfixit.com" target="_blank" rel="nofollow noopener noreferrer"><?php esc_html_e('The World’s Fastest 24/7 WordPress Support Service Company Since 2009', 'text-domain'); ?></a></h3></p>
                    <hr>
                    <br>
                    <a href="https://www.wpfixit.com/24-7-wordpress-support/#jarrett" target="_blank">
                        <img src="<?php echo esc_url(plugins_url('conflict-finder-wp-fix-it/assets/img/jarrett.webp')); ?>" alt="<?php esc_attr_e('WP Fix It', 'text-domain'); ?>" style="width: 77px;margin: 0 auto 20px;max-width: 80px;float: left;">
                    </a>
                </p>
                <p style="text-align:center;margin-top:-10px">
                <b><?php esc_html_e('Jarrett Gucci', 'text-domain'); ?></b>
                    <br>
                <b><?php esc_html_e('Owner & Founder', 'text-domain'); ?></b>
                <h4 style="text-align:center;margin-top:-10px"><a href="https://www.wpfixit.com/24-7-wordpress-support/#jarrett" target="_blank" rel="nofollow noopener noreferrer"><?php esc_html_e('Learn more about me...', 'text-domain'); ?></a></h4>
                    </p>
            </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var iframe = document.getElementById('logged-in-preview');
    if (iframe) {
        iframe.onload = function() {
            resizeIframe(iframe);
            hideElementsInIframe(iframe);
            observeIframeChanges(iframe);
        };
        
        function resizeIframe(iframe) {
            var maxHeight = 800; // Set your maximum height here
            var newHeight = Math.min(iframe.contentWindow.document.documentElement.scrollHeight, maxHeight);
            iframe.style.height = newHeight + 'px';
        }

        function hideElementsInIframe(iframe) {
            const inputElement = iframe.contentWindow.document.querySelector('#conflict_crash_reset');
            const anchorElement = iframe.contentWindow.document.querySelector('#troubleshoot_button');
            const textElement = iframe.contentWindow.document.querySelector('strong#button_stuck_text');
            
            if (inputElement) {
                inputElement.style.display = 'none';
            }
            if (anchorElement) {
                anchorElement.style.display = 'none';
            }
            if (textElement) {
                textElement.style.display = 'none';
            }
        }

        function observeIframeChanges(iframe) {
            const observer = new MutationObserver(function(mutations) {
                hideElementsInIframe(iframe);
                resizeIframe(iframe); // Adjust height on content change
            });
            observer.observe(iframe.contentWindow.document.body, { childList: true, subtree: true });
        }

        // Adjust height periodically for dynamically changing content
        setInterval(function() {
            resizeIframe(iframe);
        }, 1000);

    } else {
        console.warn('Iframe with ID "logged-in-preview" not found.');
    }
});
    document.addEventListener('DOMContentLoaded', function() {
    var refreshButton = document.getElementById('refresh-preview');
    var desktopViewButton = document.getElementById('desktop-view');
    var tabletViewButton = document.getElementById('tablet-view');
    var mobileViewButton = document.getElementById('mobile-view');
    var iframe = document.getElementById('logged-in-preview');
    var iframeContainer = document.querySelector('.iframe-container'); 
    // Refresh the iframe content when the refresh button is clicked
    if (refreshButton && iframe) {
        refreshButton.addEventListener('click', function() {
            iframe.src = iframe.src;
        });
    }
    // Set iframe to desktop view
    if (desktopViewButton && iframe) {
        desktopViewButton.addEventListener('click', function() {
            iframe.style.width = '100%';
            iframeContainer.style.background = 'transparent'; // Set background to transparent
        });
    }
    // Set iframe to tablet view
    if (tabletViewButton && iframe) {
        tabletViewButton.addEventListener('click', function() {
            iframe.style.width = '768px';
            iframeContainer.style.background = 'transparent'; // Set background to transparent
        });
    }
    // Set iframe to mobile view
    if (mobileViewButton && iframe && iframeContainer) {
        mobileViewButton.addEventListener('click', function() {
            iframe.style.width = '375px';
            iframeContainer.style.background = 'transparent'; // Set background to transparent
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var refreshButton = document.getElementById('refresh-preview-logged-out');
    var desktopViewButton = document.getElementById('desktop-view-logged-out');
    var tabletViewButton = document.getElementById('tablet-view-logged-out');
    var mobileViewButton = document.getElementById('mobile-view-logged-out');
    var iframe = document.getElementById('logged-out-preview');
    var iframeContainer = document.querySelector('.iframe-container-logged-out'); 
    // Refresh the iframe content when the refresh button is clicked
    if (refreshButton && iframe) {
        refreshButton.addEventListener('click', function() {
            iframe.src = iframe.src;
        });
    }
    // Set iframe to desktop view
    if (desktopViewButton && iframe) {
        desktopViewButton.addEventListener('click', function() {
            iframe.style.width = '100%';
            iframeContainer.style.background = 'transparent'; // Set background to transparent
        });
    }
    // Set iframe to tablet view
    if (tabletViewButton && iframe) {
        tabletViewButton.addEventListener('click', function() {
            iframe.style.width = '768px';
            iframeContainer.style.background = 'transparent'; // Set background to transparent
        });
    }
    // Set iframe to mobile view
    if (mobileViewButton && iframe && iframeContainer) {
        mobileViewButton.addEventListener('click', function() {
            iframe.style.width = '375px';
            iframeContainer.style.background = 'transparent'; // Set background to transparent
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var pluginInfo = document.getElementById('plugin-info');
    var closeButton = document.getElementById('close-plugin-info');
    // Function to set the cookie
    function setCookie(name, value, days) {
        var expires = '';
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }
    // Function to get the cookie value
    function getCookie(name) {
        var nameEQ = name + '=';
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }
    // Check if the cookie is set
    var pluginInfoClosed = getCookie('pluginInfoClosed');
    if (!pluginInfoClosed) {
        pluginInfo.style.display = 'block';
    }
    // Close button click event
    closeButton.addEventListener('click', function() {
        pluginInfo.style.display = 'none'; // Hide the plugin info
        setCookie('pluginInfoClosed', 'true', 7); // Set the cookie to remember the user's choice for 7 days
    });
});
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash === "#page_preview") {
        setTimeout(function() {
            var element = document.getElementById("page_preview");
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }, 500); // Adjust the timeout as needed
    }
});
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash === "#top_options") {
        setTimeout(function() {
            var element = document.getElementById("top_options");
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }, 500); // Adjust the timeout as needed
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.plugin-checkbox');
    let lastChecked = null;
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('click', function(event) {
            if (lastChecked && event.shiftKey) {
                let start = Array.prototype.indexOf.call(checkboxes, lastChecked);
                let end = Array.prototype.indexOf.call(checkboxes, checkbox);
                checkboxes.forEach(function(cb, index) {
                    if ((start < end && index > start && index < end) || (start > end && index < start && index > end)) {
                        cb.checked = lastChecked.checked;
                    }
                });
            }
            lastChecked = checkbox;
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    // Function to open a modal
    const openModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            modal.setAttribute('aria-hidden', 'false');
            const closeButton = modal.querySelector('.close');
            if (closeButton) {
                closeButton.focus();
            } else {
                console.error(`Close button not found in modal with ID ${modalId}`);
            }
        } else {
            console.error(`Modal with ID ${modalId} not found`);
        }
    };
    // Function to close a modal and pause any playing videos
    const closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Pause all Vimeo iframes within the modal
            //const iframes = modal.querySelectorAll('iframe');
           // iframes.forEach((iframe) => {
               // if (iframe.src.includes('player.vimeo.com')) {
               //     const player = new Vimeo.Player(iframe);
                   // player.pause().then(() => {
                   //     console.log(`Paused Vimeo video in modal with ID ${modalId}`);
                   // }).catch((error) => {
                   //     console.error(`Error pausing Vimeo video: ${error}`);
                   // });
               // }
           // });
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        } else {
            console.error(`Modal with ID ${modalId} not found`);
        }
    };
    // Select all modals
    const modals = document.querySelectorAll('.modal');
    // Information buttons and corresponding modals
    const infoButtons = [
        { buttonId: 'conflict-url-info', modalId: 'conflict-url-info-modal' },
        { buttonId: 'debug-mode-info', modalId: 'debug-mode-info-modal' },
        { buttonId: 'debug-display-info', modalId: 'debug-display-info-modal' },
        { buttonId: 'debug-logged-out-info', modalId: 'debug-logged-out-info-modal' },
        { buttonId: 'default-theme-info', modalId: 'default-theme-info-modal' },
        { buttonId: 'disable-plugins-info', modalId: 'disable-plugins-info-modal' },
        { buttonId: 'logged-in-preview-info', modalId: 'logged-in-preview-info-modal' }
        <?php
        $default_disable_plugins_all_mode = get_option('disable_plugins_all_mode');
        if ($default_disable_plugins_all_mode): ?>
            ,{ buttonId: 'logged-out-preview-info', modalId: 'logged-out-preview-info-modal' }
        <?php endif; ?>
    ];
    // Add event listeners to the buttons and close buttons
    infoButtons.forEach(({ buttonId, modalId }) => {
        const button = document.getElementById(buttonId);
        const modal = document.getElementById(modalId);
        if (button && modal) {
            const closeButton = modal.querySelector('.close');
            if (closeButton) {
                button.addEventListener('click', () => openModal(modalId));
                closeButton.addEventListener('click', () => closeModal(modalId));
            } else {
                console.error(`Close button not found in modal with ID ${modalId}`);
            }
        } else {
            if (!button) {
                console.error(`Button with ID ${buttonId} not found`);
            }
            if (!modal) {
                console.error(`Modal with ID ${modalId} not found`);
            }
        }
    });
    // Close the modal when clicking outside of it
    window.addEventListener('click', (event) => {
        modals.forEach((modal) => {
            if (event.target === modal) {
                closeModal(modal.id);
            }
        });
    });
    // Close the modal when pressing the Escape key
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            modals.forEach((modal) => {
                if (modal.style.display === 'block') {
                    closeModal(modal.id);
                }
            });
        }
    });
});
</script>
<?php
?>
