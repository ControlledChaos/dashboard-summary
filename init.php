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
}

// Run the plugin.
dashboard_summary();

/**
 * Settings link
 *
 * @param  array $links Default plugin links on the 'Plugins' admin page.
 * @since  1.0.0
 * @access public
 * @return string Returns the new set of plugin links.
 */
function settings_link( $links ) {

	// Stop if not in the admin.
	if ( ! is_admin() ) {
		return;
	}

	// Markup & text of the new link.
	$settings = [
		sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url( 'options-general.php#dashboard-summary-description' ) ),
			esc_attr( 'Settings', DS_DOMAIN )
		)
	];

	// Merge the new link with existing links.
	return array_merge( $settings, $links );
}
add_filter( 'plugin_action_links_' . DS_BASENAME, __NAMESPACE__ . '\settings_link' );
