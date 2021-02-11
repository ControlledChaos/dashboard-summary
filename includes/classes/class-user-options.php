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
	 * @return srting Returns the username.
	 */
	public function user_login() {

		$user_data = get_userdata( get_current_user_id() );

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

		$user  = wp_get_current_user();
		$roles = (array) $user->roles;

		return $roles;
	}

	/**
	 * User roles
	 *
	 * Comma-separated list of user roles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return srting Returns the list.
	 */
	function user_roles() {

		$roles = $this->get_user_roles();

		foreach( $roles as $role ) {
			$role_i18n[] = ucwords( __( $role, DS_DOMAIN ) );
		}

		return implode( ', ', $role_i18n );
	}

	/**
	 * Nickname
	 *
	 * @since  1.0.0
	 * @access public
	 * @return srting Returns the nickname.
	 */
	public function nickname() {

		$user_data = get_userdata( get_current_user_id() );

		return esc_html( $user_data->nickname );
	}

	/**
	 * Display name
	 *
	 * @since  1.0.0
	 * @access public
	 * @return srting Returns the display name.
	 */
	public function display_name() {

		$user_data = get_userdata( get_current_user_id() );

		return esc_html( $user_data->display_name );
	}

	/**
	 * User email
	 *
	 * @since  1.0.0
	 * @access public
	 * @return srting Returns the email address.
	 */
	public function email() {

		$user_data = get_userdata( get_current_user_id() );

		return sprintf(
			'<a href="mailto:%s">%s</a>',
			sanitize_email( $user_data->user_email ),
			sanitize_email( $user_data->user_email )
		);
	}

	/**
	 * User website
	 *
	 * @since  1.0.0
	 * @access public
	 * @return srting Returns the website URL.
	 */
	public function website() {

		if ( ! empty( get_user_option( 'user_url' ) ) ) {
			return sprintf(
				'<a href="%s" target="_blank" rel="nofollow noreferrer noopener">%s</a>',
				esc_url( get_user_option( 'user_url' ) ),
				esc_url( get_user_option( 'user_url' ) )
			);
		} else {
			return __( 'No website provided.', DS_DOMAIN );
		}
	}

	/**
	 * Frontend toolbar
	 *
	 * @since  1.0.0
	 * @access public
	 * @return srting Returns Yes/No text based on boolean.
	 */
	public function toolbar() {

		if ( true == get_user_option( 'show_admin_bar_front' ) ) {
			return __( 'Yes', DS_DOMAIN );
		} else {
			return __( 'No', DS_DOMAIN );
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
