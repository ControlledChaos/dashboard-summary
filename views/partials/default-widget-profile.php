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

// System section heading.
$heading_profile = apply_filters(
	'ds_default_widget_heading_profile',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Your Profile', DS_DOMAIN )
	)
);

// System section description.
$description_profile = apply_filters(
	'ds_default_widget_description_profile',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Details about your account.', DS_DOMAIN )
	)
);

// Personal information section heading.
$heading_user_bio = apply_filters(
	'ds_default_widget_heading_user_bio',
	__( 'Personal Information', DS_DOMAIN )
);

// Personal information description.
$description_user_bio = apply_filters(
	'ds_default_widget_description_user_bio',
	sprintf(
		'<p class="description">%s</p>',
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
<?php // echo $description_profile; ?>

<div class="ds-widget-divided-section ds-widget-profile-section">
	<h4><?php echo $heading_user_bio; ?></h4>
	<?php echo $description_user_bio; ?>
</div>

<div class="ds-widget-divided-section ds-widget-profile-section">
	<h4><?php echo $heading_user_options; ?></h4>
	<?php echo $description_user_options; ?>
</div>
