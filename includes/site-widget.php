<?php
/**
 * Site summary widget
 *
 * Adds a widget to the dashboard of a standard installation
 * or to network sites of a multisite installation.
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Site_Widget;

use Dashboard_Summary\Settings as Settings;

use function Dashboard_Summary\User_Colors\user_colors;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Execute functions
 *
 * @since  1.0.0
 * @return void
 */
function setup() {

	// Return namespaced function.
	$ns = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	// Add the summary widget.
	add_action( 'wp_dashboard_setup', $ns( 'add_widget' ) );
	add_action( 'ds_summary_widget', $ns( 'get_output' ) );

	// Print admin styles to head.
	add_action( 'admin_print_styles', $ns( 'admin_print_styles' ), 20 );
}

/**
 * Add the Website Summary widget
 *
 * @since  1.0.0
 * @return void
 */
function add_widget() {

	/**
	 * Widget title
	 *
	 * The title is set as a constant in the plugin config file.
	 * The title can be modified by defining the `DS_SITE_WIDGET_TITLE`
	 * constant in the system config file or by accessing the
	 * `ds_site_widget_title` filter applied here.
	 */
	$title = apply_filters( 'ds_site_widget_title', DS_SITE_WIDGET_TITLE );

	// Add the widget if the setting is true.
	if ( true == Settings\sanitize_summary() ) {
		wp_add_dashboard_widget( 'dashboard_summary', $title, __NAMESPACE__ . '\output' );
	}
}

/**
 * Site dashboard widget output
 *
 * Add widget content as an action to facilitate the use
 * of another template via the `remove_action` and the
 * `add_action` hooks.
 *
 * @since  1.0.0
 * @return void
 */
function output() {
	do_action( 'ds_summary_widget' );
}

/**
 * Get site dashboard widget output
 *
 * Includes the widget markup from files in the views directory.
 *
 * @since  1.0.0
 * @return void
 */
function get_output() {
	include DS_PATH . 'views/site-widget-template.php';
}

/**
 * Print admin styles
 *
 * @since  1.0.0
 * @param  string $style Default empty string.
 * @return string Returns the style blocks.
 */
function admin_print_styles( $style = '' ) {

	// Get user colors.
	$colors = user_colors();

	// Tabs sections: hide while stylesheet loading.
	$style  = '<style>';
	$style .= '.ds-widget-section:not( .ds-tabs-state-active ) { display: none; }';
	$style .= '</style>';

	// Dashboard Summary icons style block.
	$style .= '<!-- Begin Dashboard Summary icon styles -->' . '<style>';
	$style .= '.ds-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
	$style .= '.ds-cpt-icons img { display: inline-block; max-width: 20px; } ';
	$style .= '.ds-tabs-nav li.ds-tabs-state-active { border-bottom-color: ' . $colors['colors']['background'] . '; }';
	$style .= '</style>' . '<!-- End Dashboard Summary icon styles -->';

	// Apply filter and print the style block.
	echo apply_filters( 'ds_website_print_styles', $style );
}
