<?php
/**
 * Network summary Widget
 *
 * Adds a widget to the network dashboard of a multisite installation.
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

use Dashboard_Summary\Settings as Settings;

use function Dashboard_Summary\User_Colors\user_colors;

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

		// Add the widget to the network dashboard.
		add_action( 'wp_network_dashboard_setup', [ $this, 'add_widget' ] );
		add_action( 'ds_network_widget', [ $this, 'get_output' ] );

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

		/**
		 * Widget title
		 *
		 * The title is set as a constant in the plugin config file.
		 * The title can be modified by defining the `DS_NETWORK_WIDGET_TITLE`
		 * constant in the system config file or by accessing the
		 * `ds_network_widget_title` filter applied here.
		 */
		$title = apply_filters( 'ds_network_widget_title', DS_NETWORK_WIDGET_TITLE );

		// Add the widget if the setting is true.
		if ( true == Settings\sanitize_network_summary() ) {
			wp_add_dashboard_widget( 'dashboard_summary', $title, [ $this, 'output' ] );
		}
	}

	/**
	 * Dashboard widget output
	 *
	 * Add widget content as an action to facilitate the use
	 * of another template via the `remove_action` and the
	 * `add_action` hooks.
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
	 * Includes the widget markup from files in the views directory.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_output() {
		include DS_PATH . 'views/network-widget-template.php';
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $style Default empty string.
	 * @return string Returns the style blocks.
	 */
	public function admin_print_styles( $style = '' ) {

		// Get user colors.
		$colors =user_colors();

		// Tabs sections: hide while stylesheet loading.
		$style  = '<style>';
		$style .= '.ds-widget-section:not( .ds-tabs-state-active ) { display: none; }';
		$style .= '</style>';

		// Dashboard Summary icons style block.
		$style  = '<!-- Begin Dashboard Summary icon styles -->' . '<style>';
		$style .= '.ds-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
		$style .= '.ds-cpt-icons img { display: inline-block; max-width: 20px; } ';
		$style .= '.ds-tabs-nav li.ds-tabs-state-active { border-bottom-color: ' . $colors['colors']['background'] . '; }';
		$style .= '</style>' . '<!-- End Dashboard Summary icon styles -->';

		// Apply filter and print the style block.
		echo apply_filters( 'ds_network_print_styles', $style );
	}
}
