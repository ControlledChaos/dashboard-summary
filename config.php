<?php
/**
 * Plugin configuration
 *
 * Defines constants used throughout the plugin files.
 *
 * @package    Dashboard_Summary
 * @subpackage Configuration
 * @category   Core
 * @since      1.0.0
 */

namespace Dashboard_Summary;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Constant: Plugin version
 *
 * @since 1.0.0
 * @var   string The latest plugin version.
 */
define( 'DS_VERSION', '1.0.0' );

/**
 * Constant: Plugin folder path
 *
 * @since 1.0.0
 * @var   string The filesystem directory path (with trailing slash)
 *               for the plugin __FILE__ passed in.
 */
define( 'DS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Constant: Plugin folder URL
 *
 * @since 1.0.0
 * @var   string The URL directory path (with trailing slash)
 *               for the plugin __FILE__ passed in.
 */
define( 'DS_URL', plugin_dir_url(__FILE__ ) );

/**
 * Constant: Minimum PHP version
 *
 * @since 1.0.0
 * @var   string The minimum required PHP version.
 */
define( 'DS_MIN_PHP_VERSION', '7.4' );

/**
 * Function: Minimum PHP version
 *
 * Checks the PHP version sunning on the current host
 * against the minimum version required by this plugin.
 *
 * @since  1.0.0
 * @return boolean Returns false if the minimum is not met.
 */
function min_php_version() {

	if ( version_compare( phpversion(), DS_MIN_PHP_VERSION, '<' ) ) {
		return false;
	}
	return true;
}

/**
 * Constant: Site widget title
 *
 * @since 1.0.0
 * @var   string The text of the title.
 */
if ( ! defined( 'DS_SITE_WIDGET_TITLE' ) ) {

	$widget_title = apply_filters( 'ds_site_widget_title', __( 'Website Summary', 'dashboard-summary' ) );

	define( 'DS_SITE_WIDGET_TITLE', $widget_title );
}

/**
 * Constant: Network widget title
 *
 * @since 1.0.0
 * @var   string The text of the title.
 */
if ( ! defined( 'DS_NETWORK_WIDGET_TITLE' ) ) {

	$widget_title = apply_filters( 'ds_network_widget_title', __( 'Network Summary', 'dashboard-summary' ) );

	define( 'DS_NETWORK_WIDGET_TITLE', $widget_title );
}
