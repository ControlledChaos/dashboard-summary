<?php
/**
 * Register plugin classes
 *
 * The autoloader registers plugin classes for later use.
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Classes
 * @since      1.0.0
 */

namespace Dashboard_Summary;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class files
 *
 * Defines the class directory and file prefix.
 *
 * @since 1.0.0
 * @var   string Defines the class file path.
 */
define( 'DS_CLASS', DS_PATH . 'includes/classes/class-' );

/**
 * Array of classes to register
 *
 * @since 1.0.0
 * @var   array Defines an array of class files to register.
 */
define( 'DS_CLASSES', [
	__NAMESPACE__ . '\Classes\Assets'         => DS_CLASS . 'assets.php',
	__NAMESPACE__ . '\Classes\At_A_Glance'    => DS_CLASS . 'at-a-glance.php',
	__NAMESPACE__ . '\Classes\Dashboard'      => DS_CLASS . 'dashboard.php',
	__NAMESPACE__ . '\Classes\Settings'       => DS_CLASS . 'settings.php',
	__NAMESPACE__ . '\Classes\Site_Summary'   => DS_CLASS . 'site-summary.php',
	__NAMESPACE__ . '\Classes\Summary_Widget' => DS_CLASS . 'summary-widget.php',
	__NAMESPACE__ . '\Classes\Network_Widget' => DS_CLASS . 'network-widget.php',
	__NAMESPACE__ . '\Classes\Plugin_Install' => DS_CLASS . 'plugin-install.php',
	__NAMESPACE__ . '\Classes\User_Colors'    => DS_CLASS . 'user-colors.php',
	__NAMESPACE__ . '\Classes\User_Options'   => DS_CLASS . 'user-options.php'
] );

/**
 * Autoload class files
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
spl_autoload_register(
	function ( string $class ) {
		if ( isset( DS_CLASSES[ $class ] ) ) {
			require DS_CLASSES[ $class ];
		}
	}
);
