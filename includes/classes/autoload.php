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
	__NAMESPACE__ . '\Classes\Summary' => DS_CLASS . 'summary.php'
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
