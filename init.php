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

// Hook initialization functions.
add_action( 'init', __NAMESPACE__ . '\init' );
add_action( 'admin_init', __NAMESPACE__ . '\admin_init' );

/**
 * Initialization function
 *
 * Loads PHP classes and text domain.
 * Adds settings link in the plugin row.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function init() {

	// Load plugin text domain.
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

	/**
	 * Class autoloader
	 *
	 * The autoloader registers plugin classes for later use,
	 * such as running new instances below.
	 */
	require_once DS_PATH . 'includes/autoloader.php';

	// New instances of plugin classes.
	new Classes\Settings;
	new Classes\Site_Summary;
	new Classes\User_Options;

	// Add settings link to plugin row.
	add_filter( 'plugin_action_links_' . DS_BASENAME, [ __NAMESPACE__ . '\Classes\Settings', 'settings_link' ] );
}

/**
 * Admin initialization function
 *
 * Adds widgets, loads scripts & styles.
 *
 * @since  1.0.0
 * @access public
 * @global $pagenow Get the current admin screen.
 * @return void
 */
function admin_init() {

	// Access current admin page.
	global $pagenow;

	// Site & network dashboards.
	if ( ( is_admin() || is_network_admin() ) && 'index.php' === $pagenow ) {
		new Classes\Dashboard;
	}

	// Site dashboard.
	if ( is_admin() && 'index.php' === $pagenow ) {
		new Classes\Summary_Widget;
		new Classes\At_A_Glance;
	}

	// Network dashboard.
	if ( is_network_admin() && 'index.php' === $pagenow ) {
		new Classes\Network_Widget;
	}

	// Plugin install iframe modal.
	if ( ( is_admin() || is_network_admin() ) && 'plugin-install.php' === $pagenow ) {
		new Classes\Plugin_Install;
	}
}
