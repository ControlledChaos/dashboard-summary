<?php
/**
 * User options class
 *
 * Puts options values into user-friendly text.
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Admin
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class User_Options {

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
	 * User login (username)
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the username.
	 */
	public function user_login() {

		// Get current user data.
		$user_data = get_userdata( get_current_user_id() );

		// Return the username.
		return esc_html( $user_data->user_login );
	}

	/**
	 * Get user roles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of user roles.
	 */
	function get_user_roles() {

		// Get current user roles as a variable.
		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		// Add Super Admin if applicable to current user.
		if ( is_multisite() && is_super_admin( get_current_user_id() ) ) {
			$super = [ 'Super Admin' ];
			$roles = array_merge( $super, $roles );
		}

		// Return an array of user roles.
		return $roles;
	}

	/**
	 * User roles
	 *
	 * Comma-separated list of user roles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the list.
	 */
	function user_roles() {

		// Get the array of user roles.
		$roles = $this->get_user_roles();

		// Translate and capitalize each role.
		foreach( $roles as $role ) {
			$role_i18n[] = ucwords( __( $role, 'dashboard-summary' ) );
		}

		// Return a comma-separated list of user roles.
		return implode( ', ', $role_i18n );
	}

	/**
	 * Nickname
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the nickname.
	 */
	public function nickname() {

		// Get current user data.
		$user_data = get_userdata( get_current_user_id() );

		// Return the nickname.
		return esc_html( $user_data->nickname );
	}

	/**
	 * Display name
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the display name.
	 */
	public function display_name() {

		// Get current user data.
		$user_data = get_userdata( get_current_user_id() );

		// Return the display name.
		return esc_html( $user_data->display_name );
	}

	/**
	 * User email
	 *
	 * Current user email with mailto link.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the email address.
	 */
	public function email() {

		// Get current user data.
		$user_data = get_userdata( get_current_user_id() );

		// Return the linked email address.
		return sprintf(
			'<a href="mailto:%s">%s</a>',
			sanitize_email( $user_data->user_email ),
			sanitize_email( $user_data->user_email )
		);
	}

	/**
	 * User website
	 *
	 * Current user website URL with link, if available.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the website URL or no website notice.
	 */
	public function website() {

		if ( ! empty( get_user_option( 'user_url' ) ) ) {
			return sprintf(
				'<a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
				esc_url( get_user_option( 'user_url' ) ),
				esc_url( get_user_option( 'user_url' ) )
			);
		} else {
			return __( 'No website provided.', 'dashboard-summary' );
		}
	}

	/**
	 * Frontend toolbar
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns Yes/No text based on user option.
	 */
	public function toolbar() {

		// Check the toolbar user option.
		if ( true == get_user_option( 'show_admin_bar_front' ) ) {
			return __( 'Yes', 'dashboard-summary' );
		} else {
			return __( 'No', 'dashboard-summary' );
		}
	}
}

/**
 * Instance of the class
 *
 * @since  1.0.0
 * @access public
 * @return object User_Options Returns an instance of the class.
 */
function user_options() {
	return User_Options :: instance();
}
