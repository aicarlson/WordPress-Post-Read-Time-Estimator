<?php
/*
 * Plugin Name: Estimated Post Read Time
 * Description: A WordPress plugin that estimates the read time for each post.
 * Version: 0.1
 * Author: Andrew Carlson
 * Author URI: http://ivanthevariable.com
 * License: GPL2
 */

// Include our options page and its required functions, but only in the admin panel.

if (is_admin()) {
	require( plugin_dir_path( __FILE__ ) . "/post.php");
} else {
	require( plugin_dir_path( __FILE__ ) . "/front.php");
};
?>