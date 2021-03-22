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
$heading_users = apply_filters(
	'ds_default_widget_heading_users',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Users Overview', DS_DOMAIN )
	)
);

// Sites section description.
$description_users = apply_filters(
	'ds_default_widget_description_users',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Manage network users.', DS_DOMAIN )
	)
);

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
<?php echo $heading_users; ?>
<?php echo $description_users; ?>

<div class="ds-widget-divided-section ds-widget-users-section">

	<h4><?php _e( 'Network Users', DS_DOMAIN ); ?></h4>

	<p><?php printf( __( 'There %1$s registered in the network.', DS_DOMAIN ), $users_text ); ?></p>

	<form action="<?php echo network_admin_url( 'users.php' ); ?>" method="get">
		<p>
			<label class="screen-reader-text" for="search-users"><?php _e( 'Search Users', DS_DOMAIN ); ?></label>
			<input type="search" name="s" value="" size="30" autocomplete="off" id="search-users"/>
			<?php submit_button( __( 'Search Users', DS_DOMAIN ), '', false, false, [ 'id' => 'submit_users' ] ); ?>
		</p>
	</form>
</div>

<p class="ds-wdget-link-button">
	<a class="button button-primary" href="<?php echo network_admin_url( 'users.php' ); ?>">
		<?php _e( 'Manage Users', DS_DOMAIN ); ?>
	</a>
	<a class="button button-primary" href="<?php echo network_admin_url( 'user-new.php' ); ?>">
		<?php _e( 'New User', DS_DOMAIN ); ?>
	</a>
</p>

<?php

// Development hook.
do_action( 'ds_users_tab' );
