<?php
/**
 * At a Glance widget
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

class At_A_Glance {

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
}
