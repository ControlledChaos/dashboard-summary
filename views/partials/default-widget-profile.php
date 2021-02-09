<?php
/**
 * Default widget: profile tab
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

// Profile section heading.
$heading_profile = apply_filters(
	'ds_default_widget_heading_profile',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Your Profile', DS_DOMAIN )
	)
);

// Personal information section heading.
$heading_user_bio = apply_filters(
	'ds_default_widget_heading_user_bio',
	sprintf(
		'<h4 class="screen-reader-text">%s</h4>',
		__( 'Personal Information', DS_DOMAIN )
	)
);

// Personal information description.
$description_user_bio = apply_filters(
	'ds_default_widget_description_user_bio',
	sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'Your personal information is as follows. Some of this information may be displayed publicly.', DS_DOMAIN )
	)
);

// Personal options section heading.
$heading_user_options = apply_filters(
	'ds_default_widget_heading_user_options',
	__( 'Personal Options', DS_DOMAIN )
);

// Personal options description.
$description_user_options = apply_filters(
	'ds_default_widget_description_user_options',
	sprintf(
		'<p class="description">%s</p>',
		__( 'A quick review of your options for using this website.', DS_DOMAIN )
	)
);

?>
<?php echo $heading_profile; ?>
<?php $summary->user_greeting(); ?>

<div class="ds-tabbed-content">

	<ul class="ds-tabs-nav">
		<li class="ds-tabs-state-active"><a href="#ds-user-bio"><?php _e( 'Information', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-user-options"><?php _e( 'Options', DS_DOMAIN ); ?></a></li>
	</ul>

	<section id="ds-user-bio" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">

		<h4><?php echo $heading_user_bio; ?></h4>
		<?php echo $description_user_bio; ?>

		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php _e( 'Your Identity', DS_DOMAIN ); ?></h4>
		</div>
		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php _e( 'Your Biography', DS_DOMAIN ); ?></h4>

			<p><?php echo get_user_option( 'description' ); ?></p>
			<p><a class="button button-primary" href="<?php echo self_admin_url( 'profile.php' ); ?>"><?php _e( 'Edit Profile', DS_DOMAIN ); ?></a></p>
		</div>
	</section>

	<section id="ds-user-options" class="ds-widget-section ds-tabs-panel">

		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php echo $heading_user_options; ?></h4>
			<?php echo $description_user_options; ?>
		</div>

		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php _e( 'Reference', DS_DOMAIN ); ?></h4>

			<?php
			$meta = get_user_meta( get_current_user_id() );
			echo '<pre style="white-space: pre-wrap; word-break: break-all; line-height: 1;">';
			print_r( $meta );
			echo '</pre>';
			?>
		</div>
	</section>
</div>
