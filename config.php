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
 * Constant: Site widget title
 *
 * @since 1.0.0
 * @var   string The text of the title.
 */
if ( ! defined( 'DS_WIDGET_TITLE' ) ) {
	$title = __( 'Website Summary', 'dashboard-summary' );
	define( 'DS_WIDGET_TITLE', $title );
}

/**
 * Constant: Network widget title
 *
 * @since 1.0.0
 * @var   string The text of the title.
 */
if ( ! defined( 'DS_NETWORK_WIDGET_TITLE' ) ) {
	$title = __( 'Network Summary', 'dashboard-summary' );
	define( 'DS_NETWORK_WIDGET_TITLE', $title );
}
