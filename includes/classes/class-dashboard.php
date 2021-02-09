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

		// Print admin styles to head.
		add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );
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

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_print_styles() {

		// Instantiate the User_Colors class.
		$user_colors = new User_Colors;

		// Get user notification colors.
		$notify_color      = $user_colors->user_notify_colors();
		$notify_background = $notify_color['background'];
		$notify_text       = $notify_color['text'];

		$style  = '<style>';
		$style .= '#dashboard-widgets #ds-default-widget .ds-widget-update-count { background-color: ' . $notify_background . '; color: ' . $notify_text . '; }';
		$style .= '</style>';

		echo $style;
	}
}
