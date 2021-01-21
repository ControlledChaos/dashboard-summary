<?php
/**
 * Dashboard Summary
 *
 * Dashboard wisget for ClassicPress & WordPress that replaces the "At a Glance" widget with an improved version.
 *
 * @package     Dashboard_Summary
 * @version     1.0.0
 * @link        https://github.com/ControlledChaos/dashboard-summary
 *
 * Plugin Name:  Dashboard Summary
 * Plugin URI:   https://github.com/ControlledChaos/dashboard-summary
 * Description:  Dashboard wisget for ClassicPress & WordPress that replaces the "At a Glance" widget with an improved version.
 * Version:      1.0.0
 * Author:       Controlled Chaos Design
 * Author URI:   http://ccdzine.com/
 * Text Domain:  dashboard-summary
 * Domain Path:  /languages
 * Tested up to: 5.6.0
 */

namespace Dashboard_Summary;

// Alias namespaces.
use Dashboard_Summary\Classes\Activate as Activate;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

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
 * Run activation class
 *
 * The code that runs during plugin activation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function activate_plugin() {
	Activate\activation_class();
}
activate_plugin();

/**
 * Run daactivation class
 *
 * The code that runs during plugin deactivation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function deactivate_plugin() {
	Activate\deactivation_class();
}
deactivate_plugin();

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
	return;
}

// Get the plugin initialization file.
require_once DS_PATH . 'init.php';
