<?php
/**
 * Settings
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Settings
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

		// Network settings sections and fields.
		if ( is_multisite() ) {
			add_filter( 'wpmu_options', [ $this, 'network_settings' ] );
			add_action( 'update_wpmu_options', [ $this, 'update_network_settings' ] );
		}
	}

	/**
	 * Site settings
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

		// Disable the At a Glance widget.
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
	 * Update network settings
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function update_network_settings() {

		if ( isset( $_POST['ds_enable_network_summary'] ) ) {
			update_network_option( get_current_network_id(), 'ds_enable_network_summary', filter_var( $_POST['ds_enable_network_summary'], FILTER_VALIDATE_INT ) );
		}

		if ( isset( $_POST['ds_enable_network_right_now'] ) ) {
			update_network_option( get_current_network_id(), 'ds_enable_network_right_now', filter_var( $_POST['ds_enable_network_right_now'], FILTER_VALIDATE_INT ) );
		}
	}

	/**
	 * Enable the network Dashboard Summary widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function network_settings() {

		// Get option sanitization methods.
		$summary   = $this->sanitize_network_summary();
		$right_now = $this->sanitize_network_right_now();

		// Get the form markup.
		include DS_PATH . '/views/partials/form-network-settings.php';
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
			'<p id="dashboard-summary-description">%s</p>',
			__( 'Choose which website summary widgets to display on the dashboard.', DS_DOMAIN )
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
	 * @return boolean Returns true or false.
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
	 * @return boolean Returns true or false.
	 */
	public function sanitize_glance() {

		$option = get_option( 'ds_enable_glance' );

		if ( true == $option ) {
			return true;
		}
		return false;
	}

	/**
	 * Sanitize network summary option
	 *
	 * Defaults to true.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return boolean Returns true or false.
	 */
	public function sanitize_network_summary() {

		$option = get_network_option( get_current_network_id(), 'ds_enable_network_summary' );

		if ( null == $option || true == $option ) {
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
	 * @access public
	 * @return boolean Returns true or false.
	 */
	public function sanitize_network_right_now() {

		$option = get_network_option( get_current_network_id(), 'ds_enable_network_right_now' );

		if ( true == $option ) {
			return true;
		}
		return false;
	}

	/**
	 * Settings link
	 *
	 * @param  array $links Default plugin links on the 'Plugins' admin page.
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the new set of plugin links.
	 */
	public static function settings_link( $links ) {

		// Stop if not in the admin.
		if ( ! is_admin() ) {
			return;
		}

		// Markup & text of the new link.
		$settings = [
			sprintf(
				'<a href="%s">%s</a>',
				esc_url( admin_url( 'options-general.php#dashboard-summary-description' ) ),
				esc_html__( 'Settings', DS_DOMAIN )
			)
		];

		// Merge the new link with existing links.
		return array_merge( $settings, $links );
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
