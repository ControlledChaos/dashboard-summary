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
use Dashboard_Summary\Classes as Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// System section heading.
$tab_heading = apply_filters(
	'ds_widget_system_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'System Overview', DS_DOMAIN )
	)
);

// System section description.
$tab_description = apply_filters(
	'ds_widget_system_description',
	sprintf(
		'<p class="description">%s <a href="%s">%s</a> %s</p>',
		__( 'Some technical details about the', DS_DOMAIN ),
		esc_url( get_site_url( get_current_blog_id() ) ),
		get_bloginfo( 'name' ),
		__( 'website.', DS_DOMAIN )
	)
);

// Information section heading.
$info_heading = apply_filters(
	'ds_widget_system_info_heading',
	__( 'System Information', DS_DOMAIN )
);

// Information description.
$info_description = apply_filters(
	'ds_widget_system_info_description',
	sprintf(
		'<p class="description">%s <a href="%s">%s</a> %s</p>',
		__( 'Some technical details about the', DS_DOMAIN ),
		esc_url( get_site_url( get_current_blog_id() ) ),
		get_bloginfo( 'name' ),
		__( 'website.', DS_DOMAIN )
	)
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_widget_system_tools_heading',
	__( 'System Tools', DS_DOMAIN )
);

// Tools description.
if ( is_multisite() && is_network_admin() ) {
	$tools_description = sprintf(
		'<p class="description">%s</p>',
		__( 'Manage the network settings and the options for the primary website.', DS_DOMAIN )
	);
} else {
	$tools_description = sprintf(
		'<p class="description">%s</p>',
		__( 'Manage the options for this website.', DS_DOMAIN )
	);
}
$tools_description = apply_filters( 'ds_widget_system_tools_description', $tools_description );

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-system-overview">

	<h4><?php echo $info_heading; ?></h4>
	<?php echo $info_description; ?>

	<ul class="ds-widget-details-list ds-widget-system-list">
		<li><icon class="ds-cpt-icons dashicons dashicons-editor-code"></icon> <?php echo $summary->php_version(); ?></li>
		<li><icon class="ds-cpt-icons dashicons dashicons-dashboard"></icon> <?php echo $summary->system_notice(); ?></li>
		<li><icon class="ds-cpt-icons dashicons dashicons-admin-appearance"></icon> <?php echo $summary->active_theme(); ?></li>
		<?php
		if ( ! empty( $summary->search_engines() ) ) {
			echo sprintf(
				'<li><icon class="ds-cpt-icons dashicons dashicons-search"></icon> %s</li>',
				$summary->search_engines()
			);
		} ?>
	</ul>
</div>

<?php

if ( current_user_can( 'manage_options' ) ) :

?>
<div class="ds-widget-divided-section ds-widget-system-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<?php if ( is_multisite() && is_network_admin() ) : ?>
		<a class="button button-primary" href="<?php echo network_admin_url( 'settings.php' ); ?>">
			<?php _e( 'Network Settings', DS_DOMAIN ); ?>
		</a>
		<?php endif; ?>
		<a class="button button-primary" href="<?php echo admin_url( 'options.php' ); ?>">
			<?php _e( 'Options Page', DS_DOMAIN ); ?>
		</a>
	</p>
</div>
<?php
endif;

// Development hook.
do_action( 'ds_system_info_tab' );
