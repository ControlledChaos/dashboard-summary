<?php
/**
 * Settings
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

final class Settings {

	/**
	 * Instance of the class
	 *
	 * This method can be used to call an instance
	 * of the class from outside the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns an instance of the class.
	 */
	public static function instance() {
		return new self;
	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Register settings sections and fields.
		add_action( 'admin_init', [ $this, 'settings' ] );
	}

	/**
	 * Plugin settings
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function settings() {

		// Admin pages settings section.
		add_settings_section(
			'ds_dashboard_options',
			__( 'Dashboard Options', DS_DOMAIN ),
			[ $this, 'section_description' ],
			'general'
		);

		// Enable the Dashboard Summary widget.
		add_settings_field(
			'ds_enable_summary',
			__( 'Dashboard Summary', DS_DOMAIN ),
			[ $this, 'enable_summary' ],
			'general',
			'ds_dashboard_options',
			[ esc_html__( 'Enable the Dashboard Summary widget.', DS_DOMAIN ) ]
		);

		register_setting(
			'general',
			'ds_enable_summary',
			[
				'boolean',
				'',
				[ $this, 'sanitize_summary' ],
				true,
				true
			]
		);

		// Disable the "At a Glance" widget.
		add_settings_field(
			'ds_enable_glance',
			__( 'At a Glance', DS_DOMAIN ),
			[ $this, 'enable_glance' ],
			'general',
			'ds_dashboard_options',
			[ esc_html__( 'Enable the At a Glance widget.', DS_DOMAIN ) ]
		);

		register_setting(
			'general',
			'ds_enable_glance',
			[
				'boolean',
				'',
				[ $this, 'sanitize_glance' ],
				false,
				false
			]
		);
	}

	/**
	 * Settings section description
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function section_description() {

		echo sprintf(
			'<p>%s</p>',
			__( 'Choose which content summary widgets to display on the dashboard.', DS_DOMAIN )
		);
	}

	/**
	 * Enable the Dashboard Summary widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enable_summary( $args ) {

		$option = $this->sanitize_summary();

		$html   = '<p><input type="hidden" name="ds_enable_summary" value="0"><input type="checkbox" id="ds_enable_summary" name="ds_enable_summary" value="1" ' . checked( 1, $option, false ) . '/>';
		$html  .= sprintf(
			'<label for="ds_enable_summary">%1s</label></p>',
			$args[0]
		 );

		echo $html;
	}

	/**
	 * Enable the At a Glance widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enable_glance( $args ) {

		$option = $this->sanitize_glance();

		$html   = '<p><input type="hidden" name="ds_enable_glance" value="0"><input type="checkbox" id="ds_enable_glance" name="ds_enable_glance" value="1" ' . checked( 1, $option, false ) . '/>';
		$html  .= sprintf(
			'<label for="ds_enable_glance">%1s</label></p>',
			$args[0]
		 );

		echo $html;
	}

	/**
	 * Sanitize Dashboard Summary option
	 *
	 * Defaults to true.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function sanitize_summary() {

		$option = get_option( 'ds_enable_summary' );

		if ( null == $option || true == $option ) {
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
	 * @access public
	 * @return string
	 */
	public function sanitize_glance() {

		$option = get_option( 'ds_enable_glance' );

		if ( true == $option ) {
			return true;
		}
		return false;
	}
}

/**
 * Instance of the class
 *
 * @since  1.0.0
 * @access public
 * @return object Settings Returns an instance of the class.
 */
function settings() {
	return Settings :: instance();
}
