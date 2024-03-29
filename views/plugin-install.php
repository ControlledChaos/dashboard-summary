<?php
/**
 * Plugin innformation modal content
 *
 * @todo Current screen notice in debug mode:
 * Undefined offset 1 in wp-includes\vars.php
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Updates
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes,
	Dashboard_Summary\Core    as Core;

define( 'IFRAME_REQUEST', true );

/**
 * Absolute path to the system directory
 *
 * Yeah, it's funky but it works if the system
 * directories have not been modified.
 */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/' );
}

// Get the admin bootstrap file if available.
if ( file_exists( ABSPATH . 'wp-admin/admin.php' ) ) {
	require ABSPATH . 'wp-admin/admin.php';

// Otherwise stop here & display a message.
} else {

	// Die message.
	$die = sprintf(
		'<h1>%s</h1><p>%s</p>',
		'File Error',
		'Plugin information could not be loaded. Files required to display the information could not be accessed.'
	);
	die( $die );
}

/**
 * Get the plugin list table
 *
 * Escape this plugin's namespace for `_get_list_table()`.
 */
$wp_list_table = \_get_list_table( 'WP_Plugin_Install_List_Table' );
$wp_list_table->prepare_items();

// Enqueue script for tab switching.
wp_enqueue_script( 'plugin-install' );

// Body ID needed to display the plugin information.
$body_id = 'plugin-information';

// Display plugin information.
Core\plugin_info_modal();

// Get the admin screen header.
require_once ABSPATH . 'wp-admin/admin-header.php';

// Get the admin screen footer.
require_once ABSPATH . 'wp-admin/admin-footer.php';
