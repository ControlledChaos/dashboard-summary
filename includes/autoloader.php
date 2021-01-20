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
 * @var   array Defines an array of class file paths.
 */
define( 'DS_CLASS', [
	'core'     => DS_PATH . 'includes/classes/core/class-',
	'settings' => DS_PATH . 'includes/classes/settings/class-',
	'admin'    => DS_PATH . 'includes/classes/backend/class-',
	'general'  => DS_PATH . 'includes/classes/class-',
] );

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
	'Dashboard_Summary\Classes\Dashboard'      => DS_CLASS['general'] . 'dashboard.php',
	'Dashboard_Summary\Classes\Replace_Widget' => DS_CLASS['general'] . 'replace-widget.php',
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
