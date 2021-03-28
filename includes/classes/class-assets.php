<?php
/**
 * Assets class
 *
 * Methods for enqueueing and printing assets
 * such as JavaScript and CSS files.
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Core
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

final class Assets {

	/**
	 * Plugin version
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string The version number.
	 */
	private $version = DS_VERSION;

	/**
	 * Plugin version
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function version() {
		return $this->version;
	}

	/**
	 * File suffix
	 *
	 * Adds the `.min` filename suffix if
	 * the system is not in debug mode.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function suffix() {

		// If in one of the debug modes do not minify.
		if (
			( defined( 'WP_DEBUG' ) && WP_DEBUG ) ||
			( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
		) {
			$suffix = '';
		} else {
			$suffix = '.min';
		}

		// Return the suffix or not.
		return $suffix;
	}
}
