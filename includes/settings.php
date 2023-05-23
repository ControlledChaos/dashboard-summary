<?php
/**
 * Settings
 *
 * Register settings and render the fields,
 * plus associated markup.
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Settings
 * @since      1.0.0
 */

namespace Dashboard_Summary\Settings;

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

	// Register settings sections and fields.
	add_action( 'admin_init', $ns( 'site_settings' ) );

	// Network settings sections and fields.
	if ( is_multisite() ) {
		add_filter( 'wpmu_options', $ns( 'network_settings' ) );
		add_action( 'update_wpmu_options', $ns( 'update_network_settings' ) );
	}
}

/**
 * Site settings
 *
 * Settings for the dashboard of a standard installation
 * or of network sites of a multisite installation.
 *
 * @since  1.0.0
 * @return void
 */
function site_settings() {

	// Add a section on the General Settings screen.
	add_settings_section(
		'ds_dashboard_options',
		__( 'Dashboard Options', 'dashboard-summary' ),
		__NAMESPACE__ . '\section_description',
		'general'
	);

	// Register the Website Summary setting.
	register_setting(
		'general',
		'ds_enable_summary',
		[
			'boolean',
			'',
			__NAMESPACE__ . '\sanitize_summary',
			true,
			true
		]
	);

	// Add the Website Summary setting field.
	add_settings_field(
		'ds_enable_summary',
		DS_SITE_WIDGET_TITLE,
		__NAMESPACE__ . '\enable_summary',
		'general',
		'ds_dashboard_options',
		[ sprintf(
			'%s %s %s',
			__( 'Enable the', 'dashboard-summary' ),
			DS_SITE_WIDGET_TITLE,
			__( 'widget.', 'dashboard-summary' )
		) ]
	);

	// Register the At a Glance setting.
	register_setting(
		'general',
		'ds_enable_glance',
		[
			'boolean',
			'',
			__NAMESPACE__ . '\sanitize_glance',
			false,
			false
		]
	);

	// Add the At a Glance setting field.
	add_settings_field(
		'ds_enable_glance',
		__( 'At a Glance', 'dashboard-summary' ),
		__NAMESPACE__ . '\enable_glance',
		'general',
		'ds_dashboard_options',
		[ esc_html__( 'Enable the At a Glance widget.', 'dashboard-summary' ) ]
	);
}

/**
 * Site settings section description
 *
 * Displays on the General Settings screen of a standard installation
 * or of network sites of a multisite installation.
 *
 * @since  1.0.0
 * @return string
 */
function section_description() {

	// Print the description markup.
	echo sprintf(
		'<p id="website-summary-description" class="description">%s</p>',
		__( 'Choose which website summary widgets to display on the dashboard.', 'dashboard-summary' )
	);
}

/**
 * Enable Website Summary field
 *
 * @since  1.0.0
 * @return string
 */
function enable_summary( $args, $html = '' ) {

	// Get site option sanitization method.
	$option = sanitize_summary();

	// Field markup.
	$html = '<input type="hidden" name="ds_enable_summary" value="0">';
	$html .= '<label for="ds_enable_summary"><input type="checkbox" id="ds_enable_summary" name="ds_enable_summary" value="1" ' . checked( 1, $option, false ) . '/> ' . $args[0] . '</label>';

	// Print the field markup.
	echo $html;
}

/**
 * Enable At a Glance field
 *
 * @since  1.0.0
 * @return string
 */
function enable_glance( $args, $html = '' ) {

	// Get site option sanitization method.
	$option = sanitize_glance();

	// Field markup.
	$html  = '<p><input type="hidden" name="ds_enable_glance" value="0"><input type="checkbox" id="ds_enable_glance" name="ds_enable_glance" value="1" ' . checked( 1, $option, false ) . '/>';
	$html .= sprintf(
		'<label for="ds_enable_glance">%1s</label></p>',
		$args[0]
	);

	// Print the field markup.
	echo $html;
}

/**
 * Sanitize Website Summary option
 *
 * Defaults to true.
 *
 * @since  1.0.0
 * @return boolean Returns true or false.
 */
function sanitize_summary() {

	$option = get_option( 'ds_enable_summary', true );

	if ( true == $option ) {
		return true;
	}
	return false;
}

/**
 * Sanitize At a Glance option
 *
 * Defaults to false.
 *
 * @since  1.0.0
 * @return boolean Returns true or false.
 */
function sanitize_glance() {

	$option = get_option( 'ds_enable_glance', false );

	if ( true == $option ) {
		return true;
	}
	return false;
}

/**
 * Network settings
 *
 * Settings for the network dashboard of
 * a multisite installation.
 *
 * @since  1.0.0
 * @return void
 */
function network_settings() {

	// Get network option sanitization methods.
	$summary   = sanitize_network_summary();
	$right_now = sanitize_network_right_now();

	// Get the network form markup.
	include DS_PATH . '/views/partials/form-network-settings.php';
}

/**
 * Update network settings
 *
 * Reference for the `filter_var()` function:
 * @link https://www.php.net/manual/en/function.filter-var.php
 *
 * @since  1.0.0
 * @return void
 */
function update_network_settings() {

	/**
	 * Update the network summary setting if the Network Settings
	 * page is updated with the setting.
	 */
	if ( isset( $_POST['ds_enable_network_summary'] ) ) {

		// Update the option.
		update_network_option(

			// Update for the current network.
			get_current_network_id(),

			// Option name to update.
			'ds_enable_network_summary',

			// Validate the integer setting.
			filter_var( $_POST['ds_enable_network_summary'], FILTER_VALIDATE_INT )
		);
	}

	/**
	 * Update the network right now setting if the Network Settings
	 * page is updated with the setting.
	 */
	if ( isset( $_POST['ds_enable_network_right_now'] ) ) {

		// Update the option.
		update_network_option(

			// Update for the current network.
			get_current_network_id(),

			// Option name to update.
			'ds_enable_network_right_now',

			// Validate the integer setting.
			filter_var( $_POST['ds_enable_network_right_now'], FILTER_VALIDATE_INT )
		);
	}
}

/**
 * Sanitize Network Summary option
 *
 * Defaults to true.
 *
 * @since  1.0.0
 * @return boolean Returns true or false.
 */
function sanitize_network_summary() {

	$option = get_network_option( get_current_network_id(), 'ds_enable_network_summary', true );

	if ( true == $option ) {
		return true;
	}
	return false;
}

/**
 * Sanitize network Right Now option
 *
 * Defaults to false.
 *
 * @since  1.0.0
 * @return boolean Returns true or false.
 */
function sanitize_network_right_now() {

	$option = get_network_option( get_current_network_id(), 'ds_enable_network_right_now', false );

	if ( true == $option ) {
		return true;
	}
	return false;
}
