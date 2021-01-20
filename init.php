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
 * Removes unwanted features.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function dashboard_summary() {

	// Load text domain. Hook to `init` rather than `plugins_loaded`.
	add_action( 'init', __NAMESPACE__ . '\text_domain' );

	/**
	 * Class autoloader
	 *
	 * The autoloader registers plugin classes for later use,
	 * such as running new instances below.
	 */
	require_once DS_PATH . 'includes/autoloader.php';

	new Classes\Dashboard;
	new Classes\Replace_Widget;
}

// Run the plugin.
dashboard_summary();
