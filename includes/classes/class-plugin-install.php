<?php
/**
 * Plugin install iframe modal
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Update
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Plugin_Install {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Print plugin install styles.
		add_action( 'install_plugins_pre_plugin-information', [ $this, 'styles' ] );
	}

	/**
	 * Print plugin install styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a style block.
	 */
	public function styles() {

		$style  = '<style>';
		$style .= '#plugin-information-footer { display: none; }';
		$style .= '</style>';

		echo $style;
	}
}
