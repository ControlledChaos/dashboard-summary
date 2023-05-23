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

// Load required files.
foreach ( glob( DS_PATH . 'includes/*.php' ) as $filename ) {
	require $filename;
}

Settings\setup();
Assets\setup();

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

	// Site dashboard.
	if ( is_admin() && ! is_network_admin() && 'index.php' === $pagenow ) {
		Site_Widget\setup();
		Core_Widget\setup();
	}

	// Network dashboard.
	if ( is_network_admin() && 'index.php' === $pagenow ) {
		Network_Widget\setup();
		Core_Network_Widget\setup();
	}

	add_filter( 'gettext', '\Dashboard_Summary\Core\plugin_modal_button_text', 20, 3 );
}
add_action( 'admin_init', __NAMESPACE__ . '\admin_init' );
