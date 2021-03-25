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
		add_action( 'install_plugins_pre_plugin-information', [ $this, 'hide_update_button' ] );
	}

	/**
	 * Print plugin install styles
	 *
	 * Hide the "Install Update Now" button in the
	 * plugin details modal window. This currently
	 * removes it on the Plugins page as well so a
	 * better solution is needed.
	 *
	 * @todo Find a way to override the script on the
	 * update button in the iframe the remove this.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a style block.
	 */
	public function hide_update_button() {

		// Plugin modal styles.
		$style  = '<style>';
		$style .= '#plugin-information-footer { display: none; }';
		$style .= '</style>';

		// Print the style block.
		echo $style;
	}
}
