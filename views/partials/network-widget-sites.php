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
		__( 'Network Management', DS_DOMAIN )
	)
);

// Sites section description.
$tab_description = apply_filters(
	'ds_network_widget_sites_description',
	sprintf(
		'<p class="description screen-reader-text">%s</p>',
		__( 'Manage the websites of this network.', DS_DOMAIN )
	)
);

// Manage section heading.
$manage_heading = apply_filters(
	'ds_site_widget_manage_sites_heading',
	__( 'Network Sites', DS_DOMAIN )
);

// Manage description.
$manage_description = apply_filters(
	'ds_site_widget_manage_sites_description',
	''
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_network_widget_sites_tools_heading',
	__( 'Website Tools', DS_DOMAIN )
);

// Tools description.
$tools_description = apply_filters(
	'ds_network_widget_sites_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Add a site or manage sites from the sites list screen.', DS_DOMAIN )
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

	<p><?php printf( __( 'This network consists of %1$s.', DS_DOMAIN ), $sites_text ); ?></p>

	<form action="<?php echo network_admin_url( 'sites.php' ); ?>" method="get">
		<p>
			<label class="screen-reader-text" for="search-sites"><?php _e( 'Search Sites', DS_DOMAIN ); ?></label>
			<input type="search" name="s" value="" size="30" autocomplete="off" id="search-sites" placeholder="<?php _e( 'Enter whole or partial site name', DS_DOMAIN ); ?>" />
			<?php submit_button( __( 'Search Sites', DS_DOMAIN ), '', false, false, [ 'id' => 'submit_sites' ] ); ?>
		</p>
	</form>
</div>

<div class="ds-widget-divided-section ds-widget-sites-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<a class="button button-primary" href="<?php echo network_admin_url( 'sites.php' ); ?>">
			<?php _e( 'Manage Sites', DS_DOMAIN ); ?>
		</a>
		<a class="button button-primary" href="<?php echo network_admin_url( 'site-new.php' ); ?>">
			<?php _e( 'New Site', DS_DOMAIN ); ?>
		</a>
	</p>
</div>

<?php

// Development hook.
do_action( 'ds_network_widget_sites' );
