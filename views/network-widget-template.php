<?php
/**
 * Network widget template
 *
 * Each list item in the `.ds-tabs-nav` list corresponds to
 * a `<section>` element. Sections are displayed and hidden
 * by JavaScript enqueued in the Dashboard class.
 *
 * If JavaScript is disabled by the browser then the tabs
 * navigation list is hidden and all sections are displayed.
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes,
	Dashboard_Summary\Core    as Core;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
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

do_action( 'ds_default_network_widget_before' );

?>
<div id="ds-widget" class="ds-widget ds-widget ds-tabbed-content">

	<ul class="ds-tabs-nav">

		<li class="ds-tabs-state-active"><a href="#ds-default-network-widget-sites"><?php _e( 'Sites', 'dashboard-summary' ); ?></a></li>

		<li><a href="#ds-default-network-widget-users"><?php _e( 'Users', 'dashboard-summary' ); ?></a></li>

		<li><a href="#ds-widget-profile"><?php _e( 'Profile', 'dashboard-summary' ); ?></a></li>

		<?php if ( Core\updates_tab() ) : ?>
		<li><a href="#ds-widget-updates"><?php _e( 'Updates', 'dashboard-summary' ); echo $update_count; ?></a></li>
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

	<section id="ds-widget-profile" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/widget-profile.php' );

		?>
	</section>

	<?php if ( Core\updates_tab() ) : ?>
	<section id="ds-widget-updates" class="ds-widget-section ds-tabs-panel">
		<?php

		include( DS_PATH . '/views/partials/widget-updates.php' );

		?>
	</section>
	<?php endif; ?>

	<section id="ds-default-network-widget-system-info" class="ds-widget-section ds-tabs-panel">
		<?php

		// This content is not for a native widget.
		$native_widget = false;

		// Get the system information content.
		include( DS_PATH . '/views/partials/widget-system-info.php' );

		?>
	</section>
</div>
<?php

do_action( 'ds_default_network_widget_after' );
