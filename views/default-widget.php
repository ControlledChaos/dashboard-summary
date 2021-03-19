<?php
/**
 * Default widget content
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

// Get class instances.
$summary      = Classes\summary();
$user_options = Classes\user_options();
$user_colors  = Classes\user_colors();

// Active tab.
if ( is_multisite() && is_network_admin() ) {
	$sites_li       = '<li class="ds-tabs-state-active">';
	$profile_li     = '<li>';
	$sites_active   = ' ds-tabs-state-active';
	$profile_active = '';
} else {
	$sites_li       = '<li>';
	$profile_li     = '<li class="ds-tabs-state-active">';
	$sites_active   = '';
	$profile_active = ' ds-tabs-state-active';
}

// Updates count.
$update_data = wp_get_update_data();
$updates     = number_format_i18n( $update_data['counts']['total'] );
if ( 0 != $updates ) {
	$update_count = sprintf(
		' <span class="ds-widget-update-count">%s</span>',
		$updates
	);
} else {
	$update_count = null;
}

do_action( 'ds_default_widget_before' );

?>
<div id="ds-default-widget" class="ds-widget ds-default-widget ds-tabbed-content">

	<ul class="ds-tabs-nav">

		<?php if ( is_multisite() && is_network_admin() ) : ?>
			<?php echo $sites_li; ?><a href="#ds-default-widget-sites"><?php _e( 'Sites', DS_DOMAIN ); ?></a></li>
		<?php endif; ?>

		<?php echo $profile_li; ?><a href="#ds-default-widget-profile"><?php _e( 'Profile', DS_DOMAIN ); ?></a></li>

		<?php if ( ! is_multisite() || ( is_multisite() && ! is_network_admin() ) ) : ?>
		<li><a href="#ds-default-widget-content"><?php _e( 'Content', DS_DOMAIN ); ?></a></li>
		<?php endif; ?>

		<li><a href="#ds-default-widget-users-discussion"><?php _e( 'Users', DS_DOMAIN ); ?></a></li>

		<?php if ( $summary->updates_tab() ) : ?>
		<li><a href="#ds-default-widget-updates"><?php _e( 'Updates', DS_DOMAIN ); echo $update_count; ?></a></li>
		<?php endif; ?>

		<li><a href="#ds-default-widget-system-info"><?php _e( 'System', DS_DOMAIN ); ?></a></li>
	</ul>

	<?php if ( ! is_multisite() || ( is_multisite() && ! is_network_admin() ) ) : ?>
	<section id="ds-default-widget-content" class="ds-widget-section ds-tabs-panel<?php echo $sites_active; ?>">
		<?php

		include( DS_PATH . '/views/partials/default-widget-content.php' );

		?>
	</section>
	<?php endif; ?>

	<section id="ds-default-widget-profile" class="ds-widget-section ds-tabs-panel<?php echo $profile_active; ?>">
		<?php

		include( DS_PATH . '/views/partials/default-widget-profile.php' );

		?>
	</section>

	<?php if ( is_multisite() && is_network_admin() ) : ?>
		<section id="ds-default-widget-sites" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/default-widget-sites.php' );

		?>
	</section>
	<?php endif; ?>

	<section id="ds-default-widget-users-discussion" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/default-widget-users-discussion.php' );

		?>
	</section>

	<?php if ( $summary->updates_tab() ) : ?>
	<section id="ds-default-widget-updates" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/default-widget-updates.php' );

		?>
	</section>
	<?php endif; ?>

	<section id="ds-default-widget-system-info" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/default-widget-system-info.php' );

		?>
	</section>
</div>
<?php

do_action( 'ds_default_widget_after' );
