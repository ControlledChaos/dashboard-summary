<?php
/**
 * Dashboard Summary
 *
 * Improves the At a Glance dashboard widget and offers a replacement
 * widget with more detailed website and network information.
 *
 * Compatible with multisite installations and with ClassicPress.
 *
 * @package Dashboard_Summary
 * @version 1.0.0
 * @link    https://github.com/ControlledChaos/dashboard-summary
 *
 * Plugin Name:  Dashboard Summary
 * Plugin URI:   https://github.com/ControlledChaos/dashboard-summary
 * Description:  Improves the At a Glance dashboard widget and offers a replacement widget with more detailed website and network information. Compatible with multisite installations and with ClassicPress.
 * Version:      1.0.0
 * Author:       Controlled Chaos Design
 * Author URI:   http://ccdzine.com/
 * Text Domain:  dashboard-summary
 * Domain Path:  /languages
 * Requires PHP: 5.4
 * Requires at least: 3.8
 * Tested up to: 6.2.2
 */

namespace Dashboard_Summary;

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
 * Constant: Plugin basename
 *
 * @since 1.0.0
 * @var   string The basename of this plugin file.
 */
define( 'DS_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Load text domain
 *
 * @since  1.0.0
 * @return void
 */
function load_plugin_textdomain() {

	// Load plugin text domain.
	\load_plugin_textdomain(
		'dashboard-summary',
		false,
		dirname( DS_BASENAME ) . '/languages'
	);

	// If this is in the must-use plugins directory.
	\load_muplugin_textdomain(
		'dashboard-summary',
		dirname( DS_BASENAME ) . '/languages'
	);
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_plugin_textdomain' );

/**
 * Settings link
 *
 * Add settings link to plugin row on the Plugins pages
 * in site and network admin.
 *
 * @param  array $links Default plugin links on the Plugins admin page.
 * @since  1.0.0
 * @return string Returns the new set of plugin links.
 */
function settings_link( $links, $settings = [] ) {

	// Stop if not in the admin.
	if ( ! is_admin() ) {
		return;
	}

	// Markup of the network admin link.
	if ( is_multisite() && is_network_admin() ) {
		$settings = [
			sprintf(
				'<a href="%s">%s</a>',
				esc_url( network_admin_url( 'settings.php#network-summary-description' ) ),
				esc_html__( 'Settings', 'dashboard-summary' )
			)
		];

	// Markup of the site admin link.
	} else {
		$settings = [
			sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'options-general.php#website-summary-description' ) ),
				esc_html__( 'Settings', 'dashboard-summary' )
			)
		];
	}

	// Merge the new link with existing links.
	return array_merge( $settings, $links );
}
add_action( 'plugins_loaded', function() {
	add_filter( 'plugin_action_links_' . DS_BASENAME, __NAMESPACE__ . '\settings_link' );
	add_filter( 'network_admin_plugin_action_links_' . DS_BASENAME, __NAMESPACE__ . '\settings_link' );
} );

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
include_once DS_PATH . 'includes/activate/activate.php';

// Get the plugin deactivation class.
include_once DS_PATH . 'includes/activate/deactivate.php';

/**
 * Register the activation & deactivation hooks
 *
 * The namespace of this file must remain escaped by use of the
 * backslash (`\`) prepending the activation hooks and corresponding
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
	Activate\get_row_notice();
	Activate\update_user_dashboard();
}

/**
 * Deactivation callback
 *
 * The function that runs during plugin deactivation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function deactivate_plugin() {
	Deactivate\update_user_dashboard();
}

/**
 * Disable plugin for PHP version
 *
 * Stop here if the minimum PHP version in the config
 * file is not met. Prevents breaking sites running
 * older PHP versions.
 *
 * A notice is added to the plugin row on the Plugins
 * screen as a more elegant and more informative way
 * of disabling the plugin than putting the PHP minimum
 * in the plugin header, which activates a die() message.
 * However, the Requires PHP tag is included in the
 * plugin header with a minimum of version 5.4
 * because of the namespaces.
 *
 * @since  1.0.0
 * @return void
 */
if ( ! min_php_version() ) {
	return;
}

/**
 * Plugin initialization
 *
 * Get the plugin initialization file if
 * the PHP minimum is met.
 *
 * @since  1.0.0
 */
require_once DS_PATH . 'init.php';
