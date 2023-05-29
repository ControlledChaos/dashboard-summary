<?php
/**
 * Plugin deactivation
 *
 * Nothing to see here.
 *
 * @package    Dashboard_Summary
 * @subpackage Includes
 * @category   Activate
 * @since      1.0.0
 */

namespace Dashboard_Summary\Deactivate;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Update dashboard layout user option
 *
 * @since  1.0.0
 * @return void
 */
function update_user_dashboard() {

	$users = get_users( [ 'fields' => [ 'id' ] ] );
	$value = [];

	foreach ( $users as $user ) {
		update_user_option( $user->id, 'meta-box-order_dashboard', $value, true );
	}
}
