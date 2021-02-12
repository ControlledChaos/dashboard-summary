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
		<li class="ds-tabs-state-active"><a href="#ds-user-info"><?php _e( 'Information', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-user-options"><?php _e( 'Options', DS_DOMAIN ); ?></a></li>
	</ul>

	<section id="ds-user-info" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">

		<h4><?php echo $heading_user_bio; ?></h4>
		<?php echo $description_user_bio; ?>

		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php _e( 'Your Identity', DS_DOMAIN ); ?></h4>

			<ul class="ds-widget-details-list ds-widget-options-list">
				<li><?php _e( 'User name:', DS_DOMAIN ); ?> <strong><?php echo $user_options->user_login(); ?></strong></li>
				<li><?php _e( 'Nickname:', DS_DOMAIN ); ?> <strong><?php echo $user_options->nickname(); ?></strong></li>
				<li><?php _e( 'Display name:', DS_DOMAIN ); ?> <strong><?php echo $user_options->display_name(); ?></strong></li>
				<li><?php _e( 'User roles:', DS_DOMAIN ); ?> <strong><?php echo $user_options->user_roles(); ?></strong></li>
			</ul>
		</div>
		<?php

		// Print biography section only if content is available.
		if ( ! empty( get_user_option( 'description' ) ) ) : ?>
		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php _e( 'Your Biography', DS_DOMAIN ); ?></h4>

			<p class="hide-if-no-js"><a href="#ds-user-bio" data-ds-modal><?php _e( 'View in popup window', DS_DOMAIN ); ?></a></p>

			<div id="ds-user-bio" class="ds-modal">
				<p class="hide-if-no-js"><strong><?php _e( 'Your Biography', DS_DOMAIN ); ?></strong></p>
				<?php echo wpautop( get_user_option( 'description' ) ); ?>
			</div>
		</div>
		<?php endif; ?>
	</section>

	<section id="ds-user-options" class="ds-widget-section ds-tabs-panel">

		<div class="ds-widget-divided-section ds-widget-profile-section">

			<h4><?php echo $heading_user_options; ?></h4>
			<?php echo $description_user_options; ?>

			<ul class="ds-widget-details-list ds-widget-options-list">
				<li><?php _e( 'Account email:', DS_DOMAIN ); ?> <strong><?php echo $user_options->email(); ?></strong></li>
				<li><?php _e( 'Your website:', DS_DOMAIN ); ?> <strong><?php echo $user_options->website(); ?></strong></li>
				<li><?php _e( 'Color scheme:', DS_DOMAIN ); ?> <strong><?php echo $user_colors->get_user_color_scheme(); ?></strong></li>
				<li><?php _e( 'Frontend toolbar:', DS_DOMAIN ); ?> <strong><?php echo $user_options->toolbar(); ?></strong></li>
			</ul>
		</div>
	</section>
</div>

<p class="ds-wdget-link-button">
	<a class="button button-primary" href="<?php echo self_admin_url( 'profile.php' ); ?>">
		<?php _e( 'Edit Account', DS_DOMAIN ); ?>
	</a>
</p>
