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

class Replace_Widget {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Remove the At a Glance widget.
		add_action( 'wp_dashboard_setup', [ $this, 'remove_widget' ] );

		// Add the summary widget.
		add_action( 'wp_dashboard_setup', [ $this, 'add_widget' ] );
	}

	/**
	 * Remove At a Glance widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @global array wp_meta_boxes The metaboxes array holds all the widgets for wp-admin.
	 * @return void
	 */
	public function remove_widget() {

		global $wp_meta_boxes;

		if ( false == settings()->sanitize_glance() ) {
			unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		}
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
	 * @return mixed
	 */
	public function output() {
		include DS_PATH . 'views/default-widget.php';
	}
}
