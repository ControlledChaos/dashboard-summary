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
 * Users & discussion section heading
 *
 * The HTML is included here because of the
 * screen-reader-text class, which may need
 * to be filtered out.
 */
$tab_heading = apply_filters(
	'ds_site_widget_users_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Users & Discussion', DS_DOMAIN )
	)
);

// Users section description.
$tab_description = apply_filters(
	'ds_site_widget_users_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Follow the links to manage users and comments.', DS_DOMAIN )
	)
);

// Comments section heading.
$comments_heading = apply_filters(
	'ds_site_widget_users_comments_heading',
	__( 'User Discussion', DS_DOMAIN )
);

// Comments section description.
$comments_description = apply_filters(
	'ds_site_widget_users_comments_description',
	''
);

// Registered users section heading.
$registered_heading = apply_filters(
	'ds_site_widget_users_registered_heading',
	__( 'Registered Users', DS_DOMAIN )
);

// Registered users section description.
$registered_description = apply_filters(
	'ds_site_widget_users_registered_description',
	''
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_site_widget_users_tools_heading',
	__( 'User Tools', DS_DOMAIN )
);

// Tools description.
$tools_description = apply_filters(
	'ds_site_widget_users_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Add a user or manage users from the users list screen.', DS_DOMAIN )
	)
);

// Get comment counts for various statuses.
$comment_count = get_comment_count();

// Get a count of all comments, including trash.
$comment_total = $comment_count['total_comments'] + $comment_count['trash'];

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-users-discussion">

	<h4><?php echo $comments_heading; ?></h4>
	<?php echo $comments_description; ?>

	<ul class="ds-content-list ds-widget-details-list ds-widget-comments-list">

		<?php

		// Complete list if the current user can moderate comments.
		if ( current_user_can( 'moderate_comments' ) ) :

		// Total comments.
		echo sprintf(
			'<li><a href="%s"><icon class="dashicons dashicons-format-quote"></icon> %s %s</a></li>',
			esc_url( admin_url( 'edit-comments.php' ) ),
			intval( $comment_total ),
			_n(
				'Comment in total',
				'Comments in Total',
				intval( $comment_total ),
				DS_DOMAIN
			)
		);
		?>
		<?php
		// Approved comments.
		echo sprintf(
			'<li><a href="%s"><icon class="dashicons dashicons-admin-comments"></icon> %s %s</a></li>',
			esc_url( admin_url( 'edit-comments.php?comment_status=approved' ) ),
			intval( $comment_count['approved'] ),
			__( 'Approved', DS_DOMAIN )
		); ?>
		<?php
		// Comments awaiting moderation.
		echo sprintf(
			'<li><a href="%s"><icon class="dashicons dashicons-format-chat"></icon> %s %s</a></li>',
			esc_url( admin_url( 'edit-comments.php?comment_status=moderated' ) ),
			intval( $comment_count['awaiting_moderation'] ),
			__( 'In Moderation', DS_DOMAIN )
		); ?>
		<?php
		// Comments marked as spam.
		echo sprintf(
			'<li><a href="%s"><icon class="dashicons dashicons-warning"></icon> %s %s</a></li>',
			esc_url( admin_url( 'edit-comments.php?comment_status=spam' ) ),
			intval( $comment_count['spam'] ),
			__( 'Marked Spam', DS_DOMAIN )
		); ?>
		<?php
		// Comments in trash.
		echo sprintf(
			'<li><a href="%s"><icon class="dashicons dashicons-trash"></icon> %s %s</a></li>',
			esc_url( admin_url( 'edit-comments.php?comment_status=trash' ) ),
			intval( $comment_count['trash'] ),
			__( 'In Trash', DS_DOMAIN )
		); ?>
		<?php
		// Comments by current user.
		echo sprintf(
			'<li><a href="%s"><icon class="dashicons dashicons-nametag"></icon> %s %s</a></li>',
			esc_url( admin_url( 'edit-comments.php?comment_status=mine&user_id=' . get_current_user_id() ) ),
			$summary->get_user_comments_count(),
			_n(
				'Comment By You',
				'Comments By You',
				$summary->get_user_comments_count(),
				DS_DOMAIN
			)
		);

		// If the current user cannot moderate comments.
		else :

			// Comments by current user.
		echo sprintf(
			'<li><icon class="dashicons dashicons-nametag"></icon> %s %s</li>',
			$summary->get_user_comments_count(),
			_n(
				'Comment By You',
				'Comments By You',
				$summary->get_user_comments_count(),
				DS_DOMAIN
			)
		);
		endif;
		?>
	</ul>
</div>

<?php

if ( current_user_can( 'list_users' ) ) :
?>
<div class="ds-widget-divided-section ds-widget-users-site">

	<h4><?php echo $registered_heading; ?></h4>
	<?php echo $registered_description; ?>

	<ul class="ds-widget-details-list">
		<li>
			<?php echo sprintf(
				'%s <a href="%s"><strong>%s</strong></a>',
				__( 'Number of registered users for this site:', DS_DOMAIN ),
				esc_url( admin_url( 'users.php' ) ),
				$summary->total_users()
			); ?>
		</li>
	</ul>

	<form role="search" action="<?php echo self_admin_url( 'users.php' ); ?>" method="get">
		<?php $field_id = 'site-' . get_current_blog_id() . '-dashboard-search-users'; ?>
		<p class="ds-widget-search-fields">
			<label class="screen-reader-text" for="<?php echo $field_id; ?>" aria-label="<?php _e( 'Search Users', DS_DOMAIN ); ?>"><?php _e( 'Search Users', DS_DOMAIN ); ?></label>

			<input type="search" name="s" id="<?php echo $field_id; ?>" aria-labelledby="<?php _e( 'Search Users', DS_DOMAIN ); ?>" value="<?php echo get_search_query(); ?>" autocomplete="off" placeholder="<?php _e( 'Enter whole or partial user name', DS_DOMAIN ); ?>" aria-placeholder="<?php _e( 'Enter whole or partial user name', DS_DOMAIN ); ?>" />
			<?php submit_button( __( 'Search Users', DS_DOMAIN ), '', false, false, [ 'id' => 'submit-' . $field_id ] ); ?>
		</p>
	</form>
</div>

<div class="ds-widget-divided-section ds-widget-users-discussion-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo self_admin_url( 'users.php' ); ?>">
			<?php _e( 'Manage Users', DS_DOMAIN ); ?>
		</a>
		<a class="button button-primary" href="<?php echo self_admin_url( 'user-new.php' ); ?>">
			<?php _e( 'New User', DS_DOMAIN ); ?>
		</a>
	</p>
</div>

<?php
endif;

// Development hook.
do_action( 'ds_site_widget_users_tab' );
