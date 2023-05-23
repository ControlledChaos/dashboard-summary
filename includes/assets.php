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

	// Enqueue assets.
	add_action( 'admin_enqueue_scripts', $ns( 'assets' ) );
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
 * @global array $pagenow Array of admin screens.
 * @return void
 */
function assets() {

	global $pagenow;

	if ( 'index.php' != $pagenow ) {
		return;
	}

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
