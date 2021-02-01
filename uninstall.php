<?php
/**
 * Unistall methods
 *
 * Runs automatically when the plugin is uninstalled.
 *
 * @package    Dashboard_Summary
 * @subpackage Unistall
 * @since      1.0.0
 */

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Delete plugin options
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function delete_options() {
	delete_option( 'ds_enable_summary' );
	delete_option( 'ds_enable_glance' );
}
delete_options();