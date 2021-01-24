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

		// Enqueue assets.
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
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
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output() {
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

		// Widget styles.
		wp_enqueue_style( 'ds-default-widget', DS_URL . 'assets/css/default-widget.min.css', [], DS_VERSION, 'all' );
	}
}
