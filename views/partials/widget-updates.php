<?php
/**
 * Default widget: updates tab
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

wp_update_themes();
wp_update_plugins();

// Updates section heading.
$tab_heading = apply_filters(
	'ds_widget_updates_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'System Updates', 'dashboard-summary' )
	)
);

// Updates section description.
$tab_description = apply_filters(
	'ds_widget_updates_description',
	''
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_widget_updates_tools_heading',
	__( 'Update Tools', 'dashboard-summary' )
);

// Tools description.
if ( is_multisite() && is_network_admin() ) {
	$tools_description = sprintf(
		'<p class="description">%s</p>',
		__( 'Go to the updates page or upgrade the network.', 'dashboard-summary' )
	);
} else {
	$tools_description = sprintf(
		'<p class="description">%s</p>',
		__( 'Go to the updates page.', 'dashboard-summary' )
	);
}
$tools_description = apply_filters( 'ds_widget_updates_tools_description', $tools_description );

?>
<?php echo $tab_heading ?>
<?php echo $tab_description; ?>

<?php if ( current_user_can( 'update_core' ) ) : ?>
<div class="ds-widget-divided-section ds-widget-updates-section">

	<h4><?php _e( 'System', 'dashboard-summary' ); ?></h4>

	<?php echo $summary->core_updates(); ?>
</div>
<?php endif; ?>

<?php if ( current_user_can( 'update_plugins' ) ) : ?>
<div class="ds-widget-divided-section ds-widget-updates-section">

	<h4><?php _e( 'Plugins', 'dashboard-summary' ); ?></h4>

	<?php echo $summary->update_plugins_list(); ?>
</div>
<?php endif; ?>

<?php if ( current_user_can( 'update_themes' ) ) : ?>
<div class="ds-widget-divided-section ds-widget-updates-section">

	<h4><?php _e( 'Themes', 'dashboard-summary' ); ?></h4>

	<?php echo $summary->update_themes_list(); ?>
</div>
<?php endif; ?>

<div class="ds-widget-divided-section ds-widget-updates-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo self_admin_url( 'update-core.php' ); ?>">
			<?php _e( 'Updates Page', 'dashboard-summary' ); ?>
		</a>
		<?php if ( is_multisite() && is_network_admin() ) : ?>
		<a class="button button-primary" href="<?php echo network_admin_url( 'upgrade.php' ); ?>">
			<?php _e( 'Upgrade Network', 'dashboard-summary' ); ?>
		</a>
		<?php endif; ?>
	</p>
</div>
<?php

// Development hook.
do_action( 'ds_updates_tab' );
