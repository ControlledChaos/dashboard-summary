<?php
/**
 * Dashboard class
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Admin
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Dashboard {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Enqueue admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		// Print admin scripts to head.
		add_action( 'admin_print_scripts', [ $this, 'admin_print_scripts' ], 20 );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_enqueue_scripts() {

		// Instantiate the Assets class.
		$assets = new Assets;

		// Script to fill base64 background images with current link colors.
		wp_enqueue_script( 'svg-icon-colors', DS_URL . 'assets/js/svg-icon-colors' . $assets->suffix() . '.js', [ 'jquery' ], $assets->version(), true );
	}

	/**
	 * Print admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_print_scripts() {

		// Instantiate the User_Colors class.
		$colors = new User_Colors;

		// Script to fill base64 background images with current link colors.
		echo '<script type="text/javascript">var _dashboard_svg_icons = ' . wp_json_encode( $colors->user_colors() ) . ";</script>\n";
	}
}
