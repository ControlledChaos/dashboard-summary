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
 * Defines the class directories and file prefixes.
 *
 * @since 1.0.0
 * @var   string Defines the class file path.
 */
define( 'DS_CLASS', DS_PATH . 'includes/classes/class-' );

/**
 * Array of classes to register
 *
 * When you add new classes to your version of this plugin you may
 * add them to the following array rather than requiring the file
 * elsewhere. Be sure to include the precise namespace.
 *
 * @since 1.0.0
 * @var   array Defines an array of class files to register.
 */
define( 'DS_CLASSES', [
	'Dashboard_Summary\Classes\Assets'         => DS_CLASS . 'assets.php',
	'Dashboard_Summary\Classes\At_A_Glance'    => DS_CLASS . 'at-a-glance.php',
	'Dashboard_Summary\Classes\Dashboard'      => DS_CLASS . 'dashboard.php',
	'Dashboard_Summary\Classes\Settings'       => DS_CLASS . 'settings.php',
	'Dashboard_Summary\Classes\Site_Summary'   => DS_CLASS . 'site-summary.php',
	'Dashboard_Summary\Classes\Summary_Widget' => DS_CLASS . 'summary-widget.php',
	'Dashboard_Summary\Classes\User_Colors'    => DS_CLASS . 'user-colors.php',
	'Dashboard_Summary\Classes\User_Options'   => DS_CLASS . 'user-options.php'
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
