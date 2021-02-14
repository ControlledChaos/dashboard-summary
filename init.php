<?php
/**
 * Initialize plugin functionality
 *
 * @package    Dashboard_Summary
 * @subpackage Init
 * @category   Core
 * @since      1.0.0
 */

namespace Dashboard_Summary;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Load plugin text domain
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function text_domain() {

	// Standard plugin installation.
	load_plugin_textdomain(
		DS_DOMAIN,
		false,
		dirname( DS_BASENAME ) . '/languages'
	);

	// If this is in the must-use plugins directory.
	load_muplugin_textdomain(
		DS_DOMAIN,
		dirname( DS_BASENAME ) . '/languages'
	);
}

/**
 * Core plugin function
 *
 * Loads and runs PHP classes.
 * Adds settings link in the plugin row.
 *
 * @since  1.0.0
 * @access public
 * @global $pagenow Get the current admin screen.
 * @return void
 */
function dashboard_summary() {

	// Access current admin page.
	global $pagenow;

	// Load text domain. Hook to `init` rather than `plugins_loaded`.
	add_action( 'init', __NAMESPACE__ . '\text_domain' );

	/**
	 * Class autoloader
	 *
	 * The autoloader registers plugin classes for later use,
	 * such as running new instances below.
	 */
	require_once DS_PATH . 'includes/autoloader.php';

	/**
	 * New instances of plugin classes
	 *
	 * The Dashboard class is only run on the system
	 * administration dashboard (index.php).
	 */
	new Classes\Settings;
	new Classes\Site_Summary;
	new Classes\User_Options;

	if ( is_admin() && 'index.php' == $pagenow ) {
		new Classes\Dashboard;
		new Classes\Summary_Widget;
		new Classes\At_A_Glance;
	}

	// Add settings link to plugin row.
	add_filter( 'plugin_action_links_' . DS_BASENAME, [ 'Dashboard_Summary\Classes\Settings', 'settings_link' ] );
}

// Run the plugin.
dashboard_summary();
