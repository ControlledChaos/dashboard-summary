<?php
/**
 * Dashboard class
 *
 * Instantiated for both site and network dashboards.
 * Primarily used to load scripts & styles.
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Admin
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

use function Dashboard_Summary\User_Colors\user_colors;
use function Dashboard_Summary\User_Colors\user_notify_colors;

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

		// Enqueue admin assets.
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );

		// Print admin scripts to head.
		add_action( 'admin_print_scripts', [ $this, 'print_scripts' ], 20 );

		// Print admin styles to head.
		add_action( 'admin_print_styles', [ $this, 'print_styles' ], 20 );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function assets() {

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
	 * @param  string $scripts Default empty string.
	 * @return string Returns script blocks.
	 */
	public function print_scripts( $scripts = '' ) {

		// Instantiate classes.
		$assets = new Assets;

		// Script to fill base64 background images with current link colors.
		$scripts  = '<script>';
		$scripts .= 'var _dashboard_svg_icons = ' . wp_json_encode( user_colors() ) . ';';
		$scripts .= '</script>';

		// Modal window script.
		$scripts .= '<script>';
		$scripts .= file_get_contents( DS_URL . 'assets/js/modal' . $assets->suffix() . '.js' );
		$scripts .= '</script>';

		// Apply filter and print the script blocks.
		echo apply_filters( 'ds_dashboard_print_scripts', $scripts );
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $style Default empty string.
	 * @return string Returns the style blocks.
	 */
	public function print_styles( $style = '' ) {

		// Instantiate classes.
		$assets = new Assets;

		// Get user notification colors.
		$notify_color      = user_notify_colors();
		$notify_background = $notify_color['background'];
		$notify_text       = $notify_color['text'];

		// Notification bubble.
		$style  = '<style>';
		$style .= '#dashboard-widgets #ds-widget .ds-widget-update-count { background-color: ' . $notify_background . '; color: ' . $notify_text . '; }';
		$style .= '</style>';

		// Modal windows.
		$modal  = file_get_contents( DS_URL . 'assets/css/modal' . $assets->suffix() . '.css' );
		$style .= '<style>' . $modal . '</style>';

		// Apply filter and print the style blocks.
		echo apply_filters( 'ds_dashboard_print_styles', $style );
	}
}
