<?php
/**
 * Dashboard Summary
 *
 * Improves the At a Glance dashboard widget and offers
 * a replacement widget with more detailed website information.
 *
 * @package     Dashboard_Summary
 * @version     1.0.0
 * @link        https://github.com/ControlledChaos/dashboard-summary
 *
 * Plugin Name:  Dashboard Summary
 * Plugin URI:   https://github.com/ControlledChaos/dashboard-summary
 * Description:  Improves the At a Glance dashboard widget and offers a replacement widget with more detailed website information.
 * Version:      1.0.0
 * Author:       Controlled Chaos Design
 * Author URI:   http://ccdzine.com/
 * Text Domain:  dashboard-summary
 * Domain Path:  /languages
 * Tested up to: 5.6.1
 */

namespace Dashboard_Summary;

// Alias namespaces.
use Dashboard_Summary\Classes\Activate as Activate;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * License & Warranty
 *
 * Dashboard Summary is free software.
 * It can be redistributed and/or modified ad libidum.
 *
 * Dashboard Summary is distributed WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Constant: Plugin base name
 *
 * @since 1.0.0
 * @var   string The base name of this plugin file.
 */
define( 'DS_BASENAME', plugin_basename( __FILE__ ) );

// Get the PHP version class.
require_once plugin_dir_path( __FILE__ ) . 'includes/classes/class-php-version.php';

// Get plugin configuration file.
require plugin_dir_path( __FILE__ ) . 'config.php';

/**
 * Activation & deactivation
 *
 * The activation & deactivation methods run here before the check
 * for PHP version which otherwise disables the functionality of
 * the plugin.
 */

// Get the plugin activation class.
include_once DS_PATH . 'activate/classes/class-activate.php';

// Get the plugin deactivation class.
include_once DS_PATH . 'activate/classes/class-deactivate.php';

/**
 * Register the activaction & deactivation hooks
 *
 * The namspace of this file must remain escaped by use of the
 * backslash (`\`) prepending the acivation hooks and corresponding
 * functions.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
\register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_plugin' );
\register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_plugin' );

/**
 * Activation callback
 *
 * The function that runs during plugin activation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function activate_plugin() {

	// Instantiate the Activate class.
	$activate = new Activate\Activate;

	// Update options.
	$activate->options();
}

/**
 * Run daactivation class
 *
 * The function that runs during plugin deactivation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function deactivate_plugin() {}

/**
 * Disable plugin for PHP version
 *
 * Stop here if the minimum PHP version is not met.
 * Prevents breaking sites running older PHP versions.
 *
 * @since  1.0.0
 * @return void
 */
if ( ! Classes\php()->version() ) {

	// First add a notice to the plugin row.
	$activate = new Activate\Activate;
	$activate->get_row_notice();

	return;
}

// Get the plugin initialization file.
require_once DS_PATH . 'init.php';
