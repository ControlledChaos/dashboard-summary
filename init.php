<?php
/**
 * Initialize plugin functionality
 *
 * Loads the text domain for translation and
 * instantiates various classes.
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
 * Class autoloader
 *
 * The autoloader registers plugin classes for later use,
 * such as running new instances below.
 */
require_once DS_PATH . 'includes/classes/autoload.php';

// Hook initialization functions.
add_action( 'init', __NAMESPACE__ . '\init' );
add_action( 'admin_init', __NAMESPACE__ . '\admin_init' );

/**
 * Initialization function
 *
 * Loads PHP classes and text domain.
 * Instantiates various classes.
 * Adds settings link in the plugin row.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function init() {

	// Settings and core methods.
	new Classes\Settings;
	new Classes\Summary;
	new Classes\User_Options;
}

/**
 * Admin initialization function
 *
 * Instantiates various classes.
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
	if ( is_admin() && ! is_network_admin() && 'index.php' === $pagenow ) {
		new Classes\Site_Widget;
		new Classes\Site_Default_Widget;
	}

	// Network dashboard.
	if ( is_network_admin() && 'index.php' === $pagenow ) {
		new Classes\Network_Widget;
		new Classes\Network_Default_Widget;
	}

	add_filter( 'gettext', [ 'Dashboard_Summary\Classes\Summary', 'plugin_modal_button_text' ], 20, 3 );
}
