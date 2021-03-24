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

		// Print admin styles to plugin install iframe.
		add_action( 'install_plugins_pre_plugin-information', [ $this, 'install_plugins' ] );
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
	 * @return string
	 */
	public function print_scripts() {

		// Instantiate classes.
		$colors = new User_Colors;
		$assets = new Assets;

		// Script to fill base64 background images with current link colors.
		echo '<script type="text/javascript">var _dashboard_svg_icons = ' . wp_json_encode( $colors->user_colors() ) . ";</script>\n";

		// Modal window script.
		$modal = file_get_contents( DS_URL . 'assets/js/modal' . $assets->suffix() . '.js' );
		echo '<script>' . $modal . '</script>';
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function print_styles() {

		// Instantiate classes.
		$colors = new User_Colors;
		$assets = new Assets;

		// Get user notification colors.
		$notify_color      = $colors->user_notify_colors();
		$notify_background = $notify_color['background'];
		$notify_text       = $notify_color['text'];

		// Notification bubble.
		$style  = '<style>';
		$style .= '#dashboard-widgets #ds-default-widget .ds-widget-update-count { background-color: ' . $notify_background . '; color: ' . $notify_text . '; }';
		$style .= '</style>';

		// Modal windows.
		$modal  = file_get_contents( DS_URL . 'assets/css/modal' . $assets->suffix() . '.css' );
		$style .= '<style>' . $modal . '</style>';

		echo $style;
	}

	/**
	 * Print plugin install styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function install_plugins() {

		$style  = '<style>';
		$style .= '#plugin-information-footer { display: none; }';
		$style .= '</style>';

		echo $style;
	}
}
