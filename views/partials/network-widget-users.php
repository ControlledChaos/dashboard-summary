<?php
/**
 * Default widget: users tab
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Sites section heading
 */
$tab_heading = apply_filters(
	'ds_network_widget_users_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Users Overview', 'dashboard-summary' )
	)
);

// Sites section description.
$tab_description = apply_filters(
	'ds_network_widget_users_description',
	sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'Manage network users.', 'dashboard-summary' )
	)
);

// Manage section heading.
$manage_heading = apply_filters(
	'ds_site_widget_manage_users_heading',
	__( 'Network Users', 'dashboard-summary' )
);

// Manage description.
$manage_description = apply_filters(
	'ds_site_widget_manage_users_description',
	''
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_network_widget_users_tools_heading',
	__( 'User Tools', 'dashboard-summary' )
);

// Tools description.
$tools_description = apply_filters(
	'ds_network_widget_users_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Add a user or manage users from the users list screen.', 'dashboard-summary' )
	)
);

// Users count text.
$users_count = get_user_count();
$users_text  = sprintf(
	_n(
		'is <strong>%s</strong> user',
		'are <strong>%s</strong> users',
		$users_count
	),
	number_format_i18n( $users_count )
);

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-users-manage">

	<h4><?php echo $manage_heading; ?></h4>
	<?php echo $manage_description; ?>

	<p><?php printf( __( 'There %1$s registered in the network.', 'dashboard-summary' ), $users_text ); ?></p>

	<form role="search" action="<?php echo network_admin_url( 'users.php' ); ?>" method="get">
		<?php $field_id = 'network-' . get_current_network_id() . '-dashboard-search-users'; ?>
		<p class="ds-widget-search-fields">
			<label class="screen-reader-text" for="<?php echo $field_id; ?>" aria-label="<?php _e( 'Search Users', 'dashboard-summary' ); ?>"><?php _e( 'Search Users', 'dashboard-summary' ); ?></label>

			<input type="search" name="s" id="<?php echo $field_id; ?>" aria-labelledby="<?php _e( 'Search Users', 'dashboard-summary' ); ?>" value="<?php echo get_search_query(); ?>" autocomplete="off" placeholder="<?php _e( 'Enter whole or partial user name', 'dashboard-summary' ); ?>" aria-placeholder="<?php _e( 'Enter whole or partial user name', 'dashboard-summary' ); ?>" />
			<?php submit_button( __( 'Search Users', 'dashboard-summary' ), '', false, false, [ 'id' => 'submit-' . $field_id ] ); ?>
		</p>
	</form>
</div>

<div class="ds-widget-divided-section ds-widget-users-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo network_admin_url( 'users.php' ); ?>">
			<?php _e( 'Manage Users', 'dashboard-summary' ); ?>
		</a>
		<a class="button button-primary" href="<?php echo network_admin_url( 'user-new.php' ); ?>">
			<?php _e( 'New User', 'dashboard-summary' ); ?>
		</a>
	</p>
</div>

<?php

// Development hook.
do_action( 'ds_network_widget_users_tab' );
