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

// Get a count of all comments.
$comment_count = get_comment_count();

?>
<h3 class="screen-reader-text"><?php _e( 'Users & Discussion', DS_DOMAIN ); ?></h3>

<h4><?php echo $heading_comments; ?></h4>

<?php echo $description_comments; ?>

<ul class="ds-content-list ds-widget-details-list ds-widget-comments-list">
	<?php
	/**
	echo sprintf(
		'<li><a href="%s"><icon class="dashicons dashicons-format-quote"></icon> %s %s</a></li>',
		esc_url( admin_url( 'edit-comments.php' ) ),
		$comment_count['total_comments'],
		_n( __( 'Comment in total', DS_DOMAIN ), __( 'Comments in Total', DS_DOMAIN ), $comment_count['total_comments'] )
	);
	*/
	?>
	<?php echo sprintf(
		'<li><a href="%s"><icon class="dashicons dashicons-admin-comments"></icon> %s %s</a></li>',
		esc_url( admin_url( 'edit-comments.php?comment_status=approved' ) ),
		$comment_count['approved'],
		_n(
			__( 'Approved Comment', DS_DOMAIN ),
			__( 'Approved Comments', DS_DOMAIN ),
			$comment_count['approved']
		)
	); ?>
	<?php echo sprintf(
		'<li><a href="%s"><icon class="dashicons dashicons-format-chat"></icon> %s %s</a></li>',
		esc_url( admin_url( 'edit-comments.php?comment_status=moderated' ) ),
		$comment_count['awaiting_moderation'],
		_n(
			__( 'Comment in Moderation', DS_DOMAIN ),
			__( 'Comments in Moderation', DS_DOMAIN ),
			$comment_count['awaiting_moderation']
		)
	); ?>
	<?php echo sprintf(
		'<li><a href="%s"><icon class="dashicons dashicons-warning"></icon> %s %s</a></li>',
		esc_url( admin_url( 'edit-comments.php?comment_status=spam' ) ),
		$comment_count['spam'],
		_n(
			__( 'Comment Marked Spam', DS_DOMAIN ),
			__( 'Comments Marked Spam', DS_DOMAIN ),
			$comment_count['spam']
		)
	); ?>
	<?php echo sprintf(
		'<li><a href="%s"><icon class="dashicons dashicons-trash"></icon> %s %s</a></li>',
		esc_url( admin_url( 'edit-comments.php?comment_status=trash' ) ),
		$comment_count['trash'],
		_n(
			__( 'Comment in Trash', DS_DOMAIN ),
			__( 'Comments in Trash', DS_DOMAIN ),
			$comment_count['trash']
		)
	); ?>
</ul>

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
