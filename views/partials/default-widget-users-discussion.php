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
$heading_users_discussion = apply_filters(
	'ds_default_widget_heading_users_discussion',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Users & Discussion', DS_DOMAIN )
	)
);

// Users section description.
$description_users_discussion = apply_filters(
	'ds_default_widget_description_users_discussion',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Follow the links to manage users and comments.', DS_DOMAIN )
	)
);

// Comments section heading.
$heading_comments = apply_filters(
	'ds_default_widget_heading_comments',
	__( 'User Discussion', DS_DOMAIN )
);

// Comments section description.
$description_comments = apply_filters(
	'ds_default_widget_description_comments',
	''
);

// Users section heading.
$heading_users = apply_filters(
	'ds_default_widget_heading_users',
	__( 'Registered Users', DS_DOMAIN )
);

// Users section description.
$description_users = apply_filters(
	'ds_default_widget_description_users',
	''
);

// Get comment counts for various statuses.
$comment_count = get_comment_count();

// Get a count of all comments, including trash.
$comment_total = $comment_count['total_comments'] + $comment_count['trash'];

?>
<?php echo $heading_users_discussion; ?>
<?php echo $description_users_discussion; ?>

<div class="ds-widget-divided-section ds-widget-users-section">
	<h4><?php echo $heading_comments; ?></h4>
	<?php echo $description_comments; ?>

	<ul class="ds-content-list ds-widget-details-list ds-widget-comments-list">
		<?php
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
		); ?>
	</ul>
</div>

<div class="ds-widget-divided-section ds-widget-users-section">
	<h4><?php echo $heading_users; ?></h4>
	<?php echo $description_users; ?>

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
</div>

<?php

if ( current_user_can( 'list_users' ) ) :
?>
<p class="ds-wdget-link-button">
	<a class="button button-primary" href="<?php echo self_admin_url( 'users.php' ); ?>">
		<?php _e( 'Manage Users', DS_DOMAIN ); ?>
	</a>
</p>
<?php
endif;
