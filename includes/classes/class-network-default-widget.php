<?php
/**
 * Network default widget
 *
 * The "Right Now" widget is the default WordPress &
 * ClassicPress network summary widget on network
 * administration dashboards.
 *
 * Methods in this class add a system summary
 * to the default widget content.
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

class Network_Default_Widget {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// If the Right Now widget setting is false/unchecked.
		if ( false == settings()->sanitize_network_right_now() ) {

			// Remove Right Now widget.
			add_action( 'wp_network_dashboard_setup', [ $this, 'remove_widget' ] );
		}

		// If the Right Now widget setting is true/checked.
		if ( true == settings()->sanitize_network_right_now() ) {

			// Print admin styles to head.
			add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );

			// System information section.
			add_filter( 'mu_rightnow_end', [ $this, 'system_info' ], 10, 1 );
		}
	}

	/**
	 * Remove Right Now widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @global array wp_meta_boxes The metaboxes array holds all the widgets for wp-admin.
	 * @return void
	 */
	public function remove_widget() {

		// Access metaboxes.
		global $wp_meta_boxes;

		// Unset the Right Now widget.
		unset( $wp_meta_boxes['dashboard-network']['normal']['core']['network_dashboard_right_now'] );
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_print_styles() {

		// Right Now widget style block.
		$style  = '<!-- Begin Right Now widget styles -->' . '<style>';
		$style .= '.wp-core-ui #network_dashboard_right_now p .button { vertical-align: middle; }';
		$style .= '#network_dashboard_right_now .ds-widget-divided-section { margin-top: 2em; padding-top: 0.5em; border-top: solid 1px #ccd0d4; }';
		$style .= '#dashboard-widgets #network_dashboard_right_now .ds-widget-divided-section h4 { margin: 0.75em 0 0; font-size: 1em; font-weight: bold; font-weight: 600; }';
		$style .= '#dashboard-widgets #network_dashboard_right_now .ds-widget-divided-section p.description { margin: 0.75em 0 0; font-style: italic; line-height: 1.3; }';
		$style .= '#dashboard-widgets #network_dashboard_right_now .ds-widget-divided-section a { text-decoration: none; }';
		$style .= '#network_dashboard_right_now ul.right-now-system-list { display: block; margin: 0.75em 0 0; }';
		$style .= '#network_dashboard_right_now .right-now-system-list li { margin: 0.325em 0 0; }';
		$style .= '#network_dashboard_right_now .right-now-system-list li a:before { display: none; }';
		$style .= '</style>' . '<!-- End Right Now widget styles -->';

		// Print the style block.
		echo $style;
	}

	/**
	 * System information
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup of the system information.
	 */
	public function system_info( $content ) {

		// Instance of the Summary class.
		$summary = summary();

		// This content is for a native widget.
		$native_widget = true;

		// Get the system information content.
		include( DS_PATH . '/views/partials/widget-system-info.php' );
	}
}
