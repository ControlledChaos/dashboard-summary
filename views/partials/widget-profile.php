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
$tab_heading = apply_filters(
	'ds_widget_profile_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Your Profile', 'dashboard-summary' )
	)
);

// Profile section description.
$tab_description = apply_filters(
	'ds_widget_profile_description',
	''
);

// Personal information section heading.
$user_account_heading = apply_filters(
	'ds_widget_user_account_heading',
	sprintf(
		'<h4 class="screen-reader-text">%s</h4>',
		__( 'Personal Information', 'dashboard-summary' )
	)
);

// Personal information description.
$user_account_description = apply_filters(
	'ds_widget_user_account_description',
	sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'Your personal information is as follows. Some of this information may be displayed publicly.', 'dashboard-summary' )
	)
);

// Personal options section heading.
$user_options_heading = apply_filters(
	'ds_widget_user_options_heading',
	__( 'Personal Options', 'dashboard-summary' )
);

// Personal options description.
$user_options_description = apply_filters(
	'ds_widget_user_options_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'A quick review of your options for using this website.', 'dashboard-summary' )
	)
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_widget_profile_tools_heading',
	__( 'Account Tools', 'dashboard-summary' )
);

// Tools description.
$tools_description = apply_filters(
	'ds_widget_profile_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Manage your profile and the details of your account.', 'dashboard-summary' )
	)
);

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<?php $summary->user_intro(); ?>

<div class="ds-widget-profile">
	<div class="ds-tabbed-content">

		<ul class="ds-tabs-nav">
			<li class="ds-tabs-state-active"><a href="#ds-user-info"><?php _e( 'Information', 'dashboard-summary' ); ?></a></li>
			<li><a href="#ds-user-options"><?php _e( 'Options', 'dashboard-summary' ); ?></a></li>
		</ul>

		<section id="ds-user-info" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">

			<?php echo $user_account_heading; ?>
			<?php echo $user_account_description; ?>

			<div class="ds-widget-divided-section ds-widget-profile-section">

				<h4><?php _e( 'Your Identity', 'dashboard-summary' ); ?></h4>

				<ul class="ds-widget-details-list ds-widget-options-list">
					<li><?php _e( 'User name:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->user_login(); ?></strong></li>
					<li><?php _e( 'Nickname:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->nickname(); ?></strong></li>
					<li><?php _e( 'Display name:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->display_name(); ?></strong></li>
					<li><?php _e( 'User roles:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->user_roles(); ?></strong></li>
				</ul>
			</div>
			<?php

			// Print biography section only if content is available.
			if ( ! empty( get_user_option( 'description' ) ) ) : ?>
			<div class="ds-widget-divided-section ds-widget-profile-section">

				<h4><?php _e( 'Your Description/Biography', 'dashboard-summary' ); ?></h4>

				<p class="description"><?php _e( 'This may be displayed to website users or visitors, depending on the active theme or members plugins.', 'dashboard-summary' ); ?></p>

				<p class="hide-if-no-js"><a href="#ds-user-bio" data-ds-modal><?php _e( 'View in popup window', 'dashboard-summary' ); ?></a></p>

				<div id="ds-user-bio" class="ds-modal" role="dialog" aria-labelledby="ds-modal-bio-heading-text" aria-describedby="ds-user-bio-content">
					<div class="ds-modal-bio-heading hide-if-no-js">
						<?php $summary->user_avatar(); ?>
						<p id="ds-modal-bio-heading-text"><strong><?php echo __( 'About', 'dashboard-summary' ) . ' ' . $user_options->display_name(); ?></strong></p>
					</div>
					<div id="ds-user-bio-content">
						<?php echo wpautop( get_user_option( 'description' ) ); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</section>

		<section id="ds-user-options" class="ds-widget-section ds-tabs-panel">

			<div class="ds-widget-divided-section ds-widget-profile-section">

				<h4><?php echo $user_options_heading; ?></h4>
				<?php echo $user_options_description; ?>

				<ul class="ds-widget-details-list ds-widget-options-list">
					<li><?php _e( 'Account email:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->email(); ?></strong></li>
					<li><?php _e( 'Your website:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->website(); ?></strong></li>
					<li><?php _e( 'Admin color scheme:', 'dashboard-summary' ); ?> <strong><?php echo $user_colors->get_user_color_scheme(); ?></strong></li>
					<li><?php _e( 'Frontend toolbar:', 'dashboard-summary' ); ?> <strong><?php echo $user_options->toolbar(); ?></strong></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<div class="ds-widget-divided-section ds-widget-profile-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo self_admin_url( 'profile.php' ); ?>">
			<?php _e( 'Edit Account', 'dashboard-summary' ); ?>
		</a>
	</p>
</div>

<?php

// Development hook.
do_action( 'ds_profile_tab' );
