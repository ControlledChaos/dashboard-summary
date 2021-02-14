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
$heading_updates = apply_filters(
	'ds_default_widget_heading_updates',
	__( 'System Updates', DS_DOMAIN )
);

// Updates section description.
$description_updates = apply_filters(
	'ds_default_widget_description_updates',
	''
);

?>
<h3 class="screen-reader-text"><?php echo $heading_updates; ?></h3>

<?php echo $description_updates; ?>

<?php if ( current_user_can( 'update_core' ) ) : ?>
<div class="ds-widget-divided-section ds-widget-updates-section">
	<h4><?php _e( 'System', DS_DOMAIN ); ?></h4>
	<?php echo $summary->core_updates(); ?>
</div>
<?php endif; ?>

<?php if ( current_user_can( 'update_plugins' ) ) : ?>
<div class="ds-widget-divided-section ds-widget-updates-section">
	<h4><?php _e( 'Plugins', DS_DOMAIN ); ?></h4>
	<?php echo $summary->update_plugins_list(); ?>
</div>
<?php endif; ?>

<?php if ( current_user_can( 'update_themes' ) ) : ?>
<div class="ds-widget-divided-section ds-widget-updates-section">
	<h4><?php _e( 'Themes', DS_DOMAIN ); ?></h4>
	<?php echo $summary->update_themes_list(); ?>
</div>
<?php endif; ?>

<p class="ds-wdget-link-button">
	<a class="button button-primary" href="<?php echo self_admin_url( 'update-core.php' ); ?>">
		<?php _e( 'Updates Page', DS_DOMAIN ); ?>
	</a>
</p>
<?php

// Development hook.
do_action( 'ds_updates_tab' );
