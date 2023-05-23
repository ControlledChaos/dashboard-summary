<?php
/**
 * Plugin assets
 *
 * Methods for enqueueing and printing assets
 * such as JavaScript and CSS files.
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Assets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Assets;

use function Dashboard_Summary\User_Colors\user_colors;
use function Dashboard_Summary\User_Colors\user_notify_colors;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Execute functions
 *
 * @since  1.0.0
 * @global array $pagenow Array of admin screens.
 * @return void
 */
function setup() {

	// Return namespaced function.
	$ns = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	global $pagenow;

	if ( 'index.php' != $pagenow ) {
		return;
	}

	// Enqueue assets.
	add_action( 'admin_enqueue_scripts', $ns( 'assets' ) );

	// Print admin scripts to head.
	add_action( 'admin_print_footer_scripts', $ns( 'print_scripts' ), 20 );

	// Print admin styles to head.
	add_action( 'admin_print_styles', $ns( 'print_styles' ), 20 );
}

/**
 * File suffix
 *
 * Adds the `.min` filename suffix if
 * the system is not in debug mode.
 *
 * @since  1.0.0
 * @param  string $suffix The string returned
 * @return string Returns the `.min` suffix or
 *                an empty string.
 */
function suffix( $suffix = '' ) {

	// If in one of the debug modes do not minify.
	if (
		( defined( 'WP_DEBUG' ) && WP_DEBUG ) ||
		( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
	) {
		$suffix = '';
	} else {
		$suffix = '.min';
	}

	// Return the suffix or not.
	return $suffix;
}

/**
 * Enqueue assets
 *
 * @since  1.0.0
 * @return void
 */
function assets() {

	// Tabbed/accordion content script.
	wp_enqueue_script( 'ds-tabs', DS_URL . 'assets/js/tabs' . suffix() . '.js', [ 'jquery' ], DS_VERSION, true );
	wp_add_inline_script(
		'ds-tabs',
		'jQuery( document ).ready( function($) { $( ".ds-tabbed-content" ).responsiveTabs(); });'
	);

	// Plugin widget styles.
	wp_enqueue_style( 'ds-widget', DS_URL . 'assets/css/widgets' . suffix() . '.css', [], DS_VERSION, 'all' );

	// Core widget styles.
	wp_enqueue_style( 'ds-at-a-glance', DS_URL . 'assets/css/at-a-glance' . suffix() . '.css', [], DS_VERSION, 'all' );

	// Script to fill base64 background images with current link colors.
	wp_enqueue_script( 'ds-svg-icon-colors', DS_URL . 'assets/js/svg-icon-colors' . suffix() . '.js', [ 'jquery' ], DS_VERSION, true );
}

/**
 * Print admin scripts
 *
 * @since  1.0.0
 * @param  string $scripts Default empty string.
 * @return string Returns script blocks.
 */
function print_scripts( $scripts = '' ) {

	// Script to fill base64 background images with current link colors.
	$scripts  = '<script>';
	$scripts .= 'var _dashboard_svg_icons = ' . wp_json_encode( user_colors() ) . ';';
	$scripts .= '</script>';

	// Modal window script.
	$scripts .= '<script>';
	$scripts .= file_get_contents( DS_URL . 'assets/js/modal' . suffix() . '.js' );
	$scripts .= '</script>';

	// Apply filter and print the script blocks.
	echo apply_filters( 'ds_dashboard_print_scripts', $scripts );
}

/**
 * Print admin styles
 *
 * @since  1.0.0
 * @param  string $style Default empty string.
 * @return string Returns the style blocks.
 */
function print_styles( $style = '' ) {

	// Get user notification colors.
	$notify_color      = user_notify_colors();
	$notify_background = $notify_color['background'];
	$notify_text       = $notify_color['text'];

	// Notification bubble.
	$style  = '<style>';
	$style .= '#dashboard-widgets #ds-widget .ds-widget-update-count { background-color: ' . $notify_background . '; color: ' . $notify_text . '; }';
	$style .= '</style>';

	// Modal windows.
	$modal  = file_get_contents( DS_URL . 'assets/css/modal' . suffix() . '.css' );
	$style .= '<style>' . $modal . '</style>';

	// Apply filter and print the style blocks.
	echo apply_filters( 'ds_dashboard_print_styles', $style );
}
