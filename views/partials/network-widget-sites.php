<?php
/**
 * Default widget: sites tab
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

// Sites section heading.
$tab_heading = apply_filters(
	'ds_network_widget_sites_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Network Management', 'dashboard-summary' )
	)
);

// Sites section description.
$tab_description = apply_filters(
	'ds_network_widget_sites_description',
	sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'Manage the websites of this network.', 'dashboard-summary' )
	)
);

// Manage section heading.
$manage_heading = apply_filters(
	'ds_site_widget_manage_sites_heading',
	__( 'Network Sites', 'dashboard-summary' )
);

// Manage description.
$manage_description = apply_filters(
	'ds_site_widget_manage_sites_description',
	''
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_network_widget_sites_tools_heading',
	__( 'Website Tools', 'dashboard-summary' )
);

// Tools description.
$tools_description = apply_filters(
	'ds_network_widget_sites_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Add a site or manage sites from the sites list screen.', 'dashboard-summary' )
	)
);

// Sites count text.
$sites_count = get_blog_count();
$sites_text  = sprintf(
	_n(
		'<strong>%s</strong> website',
		'<strong>%s</strong> websites',
		$sites_count
	),
	number_format_i18n( $sites_count )
);

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-sites-manage">

	<h4><?php echo $manage_heading; ?></h4>
	<?php echo $manage_description; ?>

	<p><?php printf( __( 'This network consists of %1$s.', 'dashboard-summary' ), $sites_text ); ?></p>

	<form role="search" action="<?php echo network_admin_url( 'sites.php' ); ?>" method="get">
		<?php $field_id = 'network-' . get_current_network_id() . '-dashboard-search-sites'; ?>
		<p class="ds-widget-search-fields">
			<label class="screen-reader-text" for="<?php echo $field_id; ?>" aria-label="<?php _e( 'Search Sites', 'dashboard-summary' ); ?>"><?php _e( 'Search Sites', 'dashboard-summary' ); ?></label>

			<input type="search" name="s" id="<?php echo $field_id; ?>" aria-labelledby="<?php _e( 'Search Sites', 'dashboard-summary' ); ?>" value="<?php echo get_search_query(); ?>" autocomplete="off" placeholder="<?php _e( 'Enter whole or partial site name', 'dashboard-summary' ); ?>" aria-placeholder="<?php _e( 'Enter whole or partial site name', 'dashboard-summary' ); ?>" />
			<?php submit_button( __( 'Search Sites', 'dashboard-summary' ), '', false, false, [ 'id' => 'submit-' . $field_id ] ); ?>
		</p>
	</form>
</div>

<div class="ds-widget-divided-section ds-widget-sites-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo network_admin_url( 'sites.php' ); ?>">
			<?php _e( 'Manage Sites', 'dashboard-summary' ); ?>
		</a>
		<a class="button button-primary" href="<?php echo network_admin_url( 'site-new.php' ); ?>">
			<?php _e( 'New Site', 'dashboard-summary' ); ?>
		</a>
	</p>
</div>

<?php

// Development hook.
do_action( 'ds_network_widget_sites_tab' );
