<?php
/*
 * This script fetches the logged-out version of the homepage using WordPress HTTP API.
 */
// Load WordPress environment
require_once('../../../../wp-load.php'); // Adjust the path if necessary
// Set the URL of the page you want to fetch
$url = get_option('iframe_url', esc_url(home_url('/')));
$url_with_debug = esc_url(add_query_arg('debug', '', $url));
// Validate and sanitize URL
$url = filter_var($url_with_debug, FILTER_SANITIZE_URL);
// Fetch the remote content using WordPress HTTP API
$response = wp_remote_get($url_with_debug);
// Get the body of the response
$body = wp_remote_retrieve_body($response);
// Output the content
echo $body;
?>
