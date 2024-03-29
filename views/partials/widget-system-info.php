<?php
/**
 * Default widget: system tab
 *
 * @package    Dashboard_Summary
 * @subpackage Views
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Views;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes,
	Dashboard_Summary\Core    as Core,
	Dashboard_Summary\ACF     as ACF;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// System section heading.
$tab_heading = apply_filters(
	'ds_widget_system_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'System Overview', 'dashboard-summary' )
	)
);

// System section description.
if ( is_multisite() && is_network_admin() ) {
	$tab_description = sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'An overview of network operations.', 'dashboard-summary' )
	);
} else {
	$tab_description = sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'An overview of website operations.', 'dashboard-summary' )
	);
}
$tab_description = apply_filters( 'ds_widget_system_description', $tab_description );

// Information section heading.
$info_heading = apply_filters(
	'ds_widget_system_info_heading',
	__( 'System Information', 'dashboard-summary' )
);

// Information description.
$info_description = apply_filters(
	'ds_widget_system_info_description',
	sprintf(
		'<p class="description">%s <a href="%s">%s</a> %s</p>',
		__( 'Some technical details about the', 'dashboard-summary' ),
		esc_url( get_site_url( get_current_blog_id() ) ),
		get_bloginfo( 'name' ),
		__( 'website.', 'dashboard-summary' )
	)
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_widget_system_tools_heading',
	__( 'System Tools', 'dashboard-summary' )
);

// Tools description.
if ( is_multisite() && is_network_admin() ) {
	$tools_description = sprintf(
		'<p class="description">%s</p>',
		__( 'Tools to help manage this network.', 'dashboard-summary' )
	);
} else {
	$tools_description = sprintf(
		'<p class="description">%s</p>',
		__( 'Tools to help manage this website.', 'dashboard-summary' )
	);
}
$tools_description = apply_filters( 'ds_widget_system_tools_description', $tools_description );

/**
 * Database icon
 *
 * As of April, 10, 2021 ClassicPress has not
 * updated the Dshicons icon font from the
 * WordPress 4.9.8 version. An issue has been
 * opened on GitHub.
 *
 * Until the font is updated the generic icon
 * will be used for ClassicPress.
 *
 * @link https://github.com/ClassicPress/ClassicPress/issues/695
 */
if ( 'classicpress' === Core\management_system() ) {
	$database_icon = 'dashicons-admin-generic';
} else {
	$database_icon = 'dashicons-database';
}

/**
 * Permission to access the security page.
 *
 * Checks for ClassicPress and its permissions.
 * Also a filter is applied to the variable for
 * custom roles and for alternative management
 * systems.
 */
if ( 'classicpress' === Core\management_system() ) {
	$security_access = true;
} else {
	$security_access = true;
}
$security_access = apply_filters( 'ds_security_access', $security_access );
?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-system-overview">

	<h4><?php echo $info_heading; ?></h4>
	<?php echo $info_description; ?>

	<ul class="ds-widget-details-list ds-widget-system-list">
		<li><icon class="ds-cpt-icons dashicons dashicons-editor-code"></icon> <?php echo Core\php_version(); ?></li>
		<li><icon class="ds-cpt-icons dashicons <?php echo $database_icon; ?>"></icon> <?php echo Core\database_version(); ?></li>
		<li><icon class="ds-cpt-icons dashicons dashicons-dashboard"></icon> <?php echo Core\system_notice(); ?></li>
		<?php if ( current_user_can( 'install_themes' ) || current_user_can( 'customize' ) ) : ?>
		<li><icon class="ds-cpt-icons dashicons dashicons-art"></icon> <?php echo Core\available_themes(); ?></li>
		<?php endif; ?>
		<li><icon class="ds-cpt-icons dashicons dashicons-admin-appearance"></icon> <?php echo Core\active_theme(); ?></li>
		<?php
		if ( ! empty( Core\search_engines() ) ) {
			echo sprintf(
				'<li><icon class="ds-cpt-icons dashicons dashicons-search"></icon> %s</li>',
				Core\search_engines()
			);
		} ?>
	</ul>
</div>

<?php

if ( current_user_can( 'manage_options' ) && $native_widget == false ) :

?>
<div class="ds-widget-divided-section ds-widget-system-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">

		<?php

		// Link to network pages.
		if ( is_multisite() && is_network_admin() ) : ?>
		<a class="button button-primary" href="<?php echo network_admin_url( 'settings.php' ); ?>">
			<?php _e( 'Network Settings', 'dashboard-summary' ); ?>
		</a>
		<a class="button button-primary" href="<?php echo network_admin_url( 'setup.php' ); ?>">
			<?php _e( 'Network Setup', 'dashboard-summary' ); ?>
		</a>
		<?php endif; ?>

		<?php

		// Link to the Site Health page if available.
		if (  Core\show_health_link() && class_exists( 'WP_Site_Health' ) && current_user_can( 'view_site_health_checks' ) ) : ?>

		<?php

		// Link text.
		if ( is_multisite() && is_network_admin() ) {
			$health = __( 'Network Health', 'dashboard-summary' );
		} else {
			$health = __( 'Website Health', 'dashboard-summary' );
		}

		// Add the link with filter applied for removal of the link.
		echo apply_filters(
			'ds_site_health_link',
			sprintf(
				'<a class="button button-primary" href="%s">%s</a>',
				admin_url( 'site-health.php' ),
				$health
			)
		); ?>
		<?php endif; ?>

		<?php

		// Link to the security page if available.
		if ( $security_access && file_exists( ABSPATH . 'wp-admin/security.php' ) ) : ?>

		<?php

		// Add the link with filter applied for removal of the link.
		echo apply_filters(
			'ds_security_link',
			sprintf(
				'<a class="button button-primary" href="%s">%s</a>',
				admin_url( 'security.php' ),
				__( 'Security Page', 'dashboard-summary' )
			)
		); ?>
		<?php endif; ?>

		<?php

		// Link to the options page if not network dashboard.
		if ( ! is_network_admin() ) :

			/**
			 * Link to the enhanced options page if the Advanced
			 * Custom Fields: Extended plugin is active.
			 */
			if ( ACF\acfe_active() ) {
				$options_link = 'options-general.php?page=acfe-options';

			// The core options screen.
			} else {
				$options_link = 'options.php';
			}
			$options_link = apply_filters( 'ds_options_screen_link', $options_link );

		?>
		<a class="button button-primary" href="<?php echo admin_url( $options_link ); ?>">
			<?php _e( 'Options Page', 'dashboard-summary' ); ?>
		</a>
		<?php endif; ?>
	</p>
</div>

<?php
endif; // End current_user_can.
if ( current_user_can( 'install_plugins' ) && $native_widget == false ) :

	// Do not display on network site dashboards, except the main site.
	if (
		! is_multisite() ||
		( is_multisite() && is_network_admin() ) ||
		( is_main_site() )
	) :
	?>
	<div class="ds-widget-divided-section ds-widget-plugin-development hide-if-no-js">

		<h4><?php _e( 'Widget Development', 'dashboard-summary' ); ?></h4>
		<p class="description"><?php _e( 'Development hooks & filters of the dashboard summary widgets for adding content or modifying text.', 'dashboard-summary' ); ?></p>

		<p><a href="#dev-reference" data-ds-modal><span class="dashicons dashicons-book"></span> <?php _e( 'View reference in modal window.', 'dashboard-summary' ); ?></a></p>
		<div id="dev-reference" class="ds-modal" role="dialog">
			<div class="ds-modal-content">
				<?php include( DS_PATH . '/views/partials/dev-reference.php' ); ?>
			</div>
		</div>

	</div>
	<?php
	endif; // End if not network site dashboard.
endif; // End current_user_can.

// Development hook.
do_action( 'ds_system_tab' );
