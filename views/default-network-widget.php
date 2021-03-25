<?php
/**
 * Default network widget content
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

do_action( 'ds_default_network_widget_before' );

?>
<div id="ds-default-widget" class="ds-widget ds-default-widget ds-tabbed-content">

	<ul class="ds-tabs-nav">

		<li class="ds-tabs-state-active"><a href="#ds-default-network-widget-sites"><?php _e( 'Sites', 'dashboard-summary' ); ?></a></li>

		<li><a href="#ds-default-network-widget-users"><?php _e( 'Users', 'dashboard-summary' ); ?></a></li>

		<li><a href="#ds-default-widget-profile"><?php _e( 'Profile', 'dashboard-summary' ); ?></a></li>

		<?php if ( $summary->updates_tab() ) : ?>
		<li><a href="#ds-default-widget-updates"><?php _e( 'Updates', 'dashboard-summary' ); echo $update_count; ?></a></li>
		<?php endif; ?>

		<li><a href="#ds-default-network-widget-system-info"><?php _e( 'System', 'dashboard-summary' ); ?></a></li>
	</ul>

	<section id="ds-default-network-widget-sites" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">
		<?php

		include( DS_PATH . '/views/partials/network-widget-sites.php' );

		?>
	</section>

	<section id="ds-default-network-widget-users" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/network-widget-users.php' );

		?>
	</section>

	<section id="ds-default-widget-profile" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/widget-profile.php' );

		?>
	</section>

	<?php if ( $summary->updates_tab() ) : ?>
	<section id="ds-default-widget-updates" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/widget-updates.php' );

		?>
	</section>
	<?php endif; ?>

	<section id="ds-default-network-widget-system-info" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/widget-system-info.php' );

		?>
	</section>
</div>
<?php

do_action( 'ds_default_network_widget_after' );