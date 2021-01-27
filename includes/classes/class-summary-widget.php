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

class Summary_Widget {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Add the summary widget.
		add_action( 'wp_dashboard_setup', [ $this, 'add_widget' ] );
		add_action( 'ds_summary_widget', [ $this, 'get_output' ] );

		// Enqueue assets.
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );

		// Print admin styles to head.
		add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );
	}

	/**
	 * Add the summary widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_widget() {

		$heading = apply_filters( 'ds_widget_heading', __( 'Website Summary', DS_DOMAIN ) );

		if ( true == settings()->sanitize_summary() ) {
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
		do_action( 'ds_summary_widget' );
	}

	/**
	 * Get dashboard widget output
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_output() {
		include DS_PATH . 'views/default-widget.php';
	}

	/**
	 * Enqueue assets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function assets() {

		// Tabbed/accordion content script.
		wp_enqueue_script( 'ds-tabs', DS_URL . 'assets/js/tabs.min.js', [ 'jquery' ], DS_VERSION, true );
		wp_add_inline_script(
			'ds-tabs',
			'jQuery( document ).ready( function($) { $( ".ds-tabbed-content" ).responsiveTabs(); });'
		);

		// Widget styles.
		wp_enqueue_style( 'ds-default-widget', DS_URL . 'assets/css/default-widget.min.css', [], DS_VERSION, 'all' );
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_print_styles() {

		// Dashboard Summary icons style block.
		$style  = '<!-- Begin Dashboard Summary icon styles -->' . '<style>';
		$style .= '.ds-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
		$style .= '.ds-cpt-icons img { display: inline-block; max-width: 20px; } ';
		$style .= '</style>' . '<!-- End Dashboard Summary icon styles -->';

		echo $style;
	}
}
