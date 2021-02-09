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

// Instance of the Site_Summary class.
$summary = Classes\summary();

// Instance of the User_Colors class.
$user_colors = Classes\user_colors();

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
		<li class="ds-tabs-state-active"><a href="#ds-default-widget-profile"><?php _e( 'Profile', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-content"><?php _e( 'Content', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-users-discussion"><?php _e( 'Users', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-updates"><?php _e( 'Updates', DS_DOMAIN ); echo $update_count; ?></a></li>
		<li><a href="#ds-default-widget-system-info"><?php _e( 'System', DS_DOMAIN ); ?></a></li>
	</ul>

	<section id="ds-default-widget-profile" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">
		<?php

		include_once( DS_PATH . '/views/partials/default-widget-profile.php' );

		?>
	</section>

	<section id="ds-default-widget-content" class="ds-widget-section ds-tabs-panel">
		<?php

		include_once( DS_PATH . '/views/partials/default-widget-content.php' );

		?>
	</section>

	<section id="ds-default-widget-users-discussion" class="ds-widget-section ds-tabs-panel">
		<?php

		include_once( DS_PATH . '/views/partials/default-widget-users-discussion.php' );

		?>
	</section>

	<section id="ds-default-widget-updates" class="ds-widget-section ds-tabs-panel">
		<?php

		include_once( DS_PATH . '/views/partials/default-widget-updates.php' );

		?>
	</section>

	<section id="ds-default-widget-system-info" class="ds-widget-section ds-tabs-panel">
		<?php

		include_once( DS_PATH . '/views/partials/default-widget-system-info.php' );

		?>
	</section>
</div>
<?php

do_action( 'ds_default_widget_after' );
