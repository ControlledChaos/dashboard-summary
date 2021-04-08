<?php
/**
 * Settings
 *
 * Register settings and render the fields,
 * plus associated markup.
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
		add_action( 'admin_init', [ $this, 'site_settings' ] );

		// Network settings sections and fields.
		if ( is_multisite() ) {
			add_filter( 'wpmu_options', [ $this, 'network_settings' ] );
			add_action( 'update_wpmu_options', [ $this, 'update_network_settings' ] );
		}
	}

	/**
	 * Site settings
	 *
	 * Settings for the dashboard of a standard installation
	 * or of network sites of a multisite installation.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function site_settings() {

		// Add a section on the General Settings screen.
		add_settings_section(
			'ds_dashboard_options',
			__( 'Dashboard Options', 'dashboard-summary' ),
			[ $this, 'section_description' ],
			'general'
		);

		// Register the Website Summary setting.
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

		// Add the Website Summary setting field.
		add_settings_field(
			'ds_enable_summary',
			DS_SITE_WIDGET_TITLE,
			[ $this, 'enable_summary' ],
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
				[ $this, 'sanitize_glance' ],
				false,
				false
			]
		);

		// Add the At a Glance setting field.
		add_settings_field(
			'ds_enable_glance',
			__( 'At a Glance', 'dashboard-summary' ),
			[ $this, 'enable_glance' ],
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
	 * @access public
	 * @return string
	 */
	public function section_description() {

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
	 * @access public
	 * @return string
	 */
	public function enable_summary( $args, $html = '' ) {

		// Get site option sanitization method.
		$option = $this->sanitize_summary();

		// Field markup.
		$html  = '<p><input type="hidden" name="ds_enable_summary" value="0"><input type="checkbox" id="ds_enable_summary" name="ds_enable_summary" value="1" ' . checked( 1, $option, false ) . '/>';
		$html .= sprintf(
			'<label for="ds_enable_summary">%1s</label></p>',
			$args[0]
		);

		// Print the field markup.
		echo $html;
	}

	/**
	 * Enable At a Glance field
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enable_glance( $args, $html = '' ) {

		// Get site option sanitization method.
		$option = $this->sanitize_glance();

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
	 * @access public
	 * @return boolean Returns true or false.
	 */
	public function sanitize_summary() {

		// Get the relevant option.
		$option = get_option( 'ds_enable_summary' );

		/**
		 * True by default
		 *
		 * This returns true if the option is null/empty
		 * as well as if the option is true (1) so the
		 * Website Summary widget will be displayed
		 * unless expressly excluded.
		 */
		if ( null == $option || true == $option ) {
			return true;
		}

		// Otherwise return false.
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

		// Get the relevant option.
		$option = get_option( 'ds_enable_glance' );

		// Return true if set to true.
		if ( true == $option ) {
			return true;
		}

		// Return false by default.
		return false;
	}

	/**
	 * Network settings
	 *
	 * Settings for the network dashboard of
	 * a multisite installation.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function network_settings() {

		// Get network option sanitization methods.
		$summary   = $this->sanitize_network_summary();
		$right_now = $this->sanitize_network_right_now();

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
	 * @access public
	 * @return void
	 */
	public function update_network_settings() {

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
	 * @access public
	 * @return boolean Returns true or false.
	 */
	public function sanitize_network_summary() {

		// Get the relevant network option.
		$option = get_network_option( get_current_network_id(), 'ds_enable_network_summary' );

		/**
		 * True by default
		 *
		 * This returns true if the option is null/empty
		 * as well as if the option is true (1) so the
		 * Network Summary widget will be displayed
		 * unless expressly excluded.
		 */
		if ( null == $option || true == $option ) {
			return true;
		}

		// Otherwise return false.
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

		// Get the relevant network option.
		$option = get_network_option( get_current_network_id(), 'ds_enable_network_right_now' );

		// Return true if set to true.
		if ( true == $option ) {
			return true;
		}

		// Return false by default.
		return false;
	}

	/**
	 * Settings link
	 *
	 * Add settings link to plugin row on the Plugins pages
	 * in site and network admin.
	 *
	 * @param  array $links Default plugin links on the Plugins admin page.
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the new set of plugin links.
	 */
	public static function settings_link( $links, $settings = [] ) {

		// Stop if not in the admin.
		if ( ! is_admin() ) {
			return;
		}

		// Markup of the network admin link.
		if ( is_multisite() && is_network_admin() ) {
			$settings = [
				sprintf(
					'<a href="%s">%s</a>',
					esc_url( network_admin_url( 'settings.php#network-summary-description' ) ),
					esc_html__( 'Settings', 'dashboard-summary' )
				)
			];

		// Markup of the site admin link.
		} else {
			$settings = [
				sprintf(
					'<a href="%s">%s</a>',
					esc_url( admin_url( 'options-general.php#website-summary-description' ) ),
					esc_html__( 'Settings', 'dashboard-summary' )
				)
			];
		}

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
