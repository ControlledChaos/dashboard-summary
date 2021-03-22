<?php
/**
 * Replace Widget
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Network_Widget {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		add_action( 'wp_network_dashboard_setup', [ $this, 'add_widget' ] );
		add_action( 'ds_network_widget', [ $this, 'get_output' ] );

		// Enqueue assets.
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );

		// Print admin styles to head.
		add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );
	}

	/**
	 * Add the network summary widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_widget() {

		$heading = apply_filters( 'ds_network_widget_heading', DS_NETWORK_WIDGET_TITLE );

		if ( true == settings()->sanitize_network_summary() ) {
			wp_add_dashboard_widget( 'dashboard_summary', $heading, [ $this, 'output' ] );
		}
	}

	/**
	 * Dashboard widget output
	 *
	 * Add widget content as an action to facilitate
	 * the use of another template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output() {
		do_action( 'ds_network_widget' );
	}

	/**
	 * Get dashboard widget output
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_output() {
		include DS_PATH . 'views/default-network-widget.php';
	}

	/**
	 * Enqueue assets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function assets() {

		// Instantiate the Assets class.
		$assets = new Assets;

		// Tabbed/accordion content script.
		wp_enqueue_script( 'ds-tabs', DS_URL . 'assets/js/tabs' . $assets->suffix() . '.js', [ 'jquery' ], $assets->version(), true );
		wp_add_inline_script(
			'ds-tabs',
			'jQuery( document ).ready( function($) { $( ".ds-tabbed-content" ).responsiveTabs(); });'
		);

		// Widget styles.
		wp_enqueue_style( 'ds-default-widget', DS_URL . 'assets/css/default-widget' . $assets->suffix() . '.css', [], $assets->version(), 'all' );
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

		// Get user colors.
		$colors = $user_colors->user_colors();

		// Dashboard Summary icons style block.
		$style  = '<!-- Begin Dashboard Summary icon styles -->' . '<style>';
		$style .= '.ds-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
		$style .= '.ds-cpt-icons img { display: inline-block; max-width: 20px; } ';
		$style .= '.ds-tabs-nav li.ds-tabs-state-active { border-bottom-color: ' . $colors['colors']['background'] . '; }';
		$style .= '</style>' . '<!-- End Dashboard Summary icon styles -->';

		echo $style;
	}
}