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

// Post types section heading.
$heading_types = apply_filters(
	'ds_default_widget_heading_types',
	__( 'Content Types', DS_DOMAIN )
);

// Taxonomies section heading.
$heading_taxes = apply_filters(
	'ds_default_widget_heading_taxes',
	__( 'Content Classification', DS_DOMAIN )
);

// System section heading.
$heading_system = apply_filters(
	'ds_default_widget_heading_system',
	__( 'System Information', DS_DOMAIN )
);

// Post types section description.
$description_types = apply_filters(
	'ds_default_widget_description_types',
	sprintf(
		'<p>%s</p>',
		__( 'This website contains the following post and content types. Follow the links to manage these.', DS_DOMAIN )
	)
);

// Taxonomies section description.
$description_taxes = apply_filters(
	'ds_default_widget_description_taxes',
	sprintf(
		'<p>%s</p>',
		__( 'This website\'s content is organized in part or in whole by the following taxonomies. Follow the links to manage these.', DS_DOMAIN )
	)
);

// System section description.
$description_system = apply_filters(
	'ds_default_widget_description_system',
	sprintf(
		'<p>%s <a href="%s">%s</a> %s</p>',
		__( 'Some technical details about the', DS_DOMAIN ),
		esc_url( home_url() ),
		get_bloginfo( 'name' ),
		__( 'website.', DS_DOMAIN )
	)
);

do_action( 'ds_default_widget_before' );

?>
<div id="ds-default-widget" class="ds-widget ds-default-widget ds-tabbed-content">

	<ul class="ds-tabs-nav">
		<li class="ds-tabs-state-active"><a href="#ds-default-widget-content-types"><?php _e( 'Content', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-content-taxes"><?php _e( 'Classification', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-system-info"><?php _e( 'System', DS_DOMAIN ); ?></a></li>
	</ul>

	<section id="ds-default-widget-content-types" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">
		<h3><?php echo $heading_types; ?></h3>
		<?php echo $description_types; ?>
		<?php Classes\summary()->post_types_list(); ?>
	</section>

	<section id="ds-default-widget-content-taxes" class="ds-widget-section ds-tabs-panel">
		<h3><?php echo $heading_taxes; ?></h3>
		<?php echo $description_taxes; ?>
		<?php Classes\summary()->taxonomies_icons_list(); ?>
	</section>

	<section id="ds-default-widget-system-info" class="ds-widget-section ds-tabs-panel">
		<h3><?php echo $heading_system; ?></h3>
		<?php echo $description_system; ?>

		<ul class="ds-widget-system-list">
			<li><icon class="dashicons dashicons-editor-code"></icon> <?php echo Classes\summary()->php_version(); ?></li>
			<li><icon class="dashicons dashicons-dashboard"></icon> <?php echo Classes\summary()->management_system(); ?></li>
			<li><icon class="dashicons dashicons-admin-appearance"></icon> <?php echo Classes\summary()->active_theme(); ?></li>
			<?php
			if ( ! empty( Classes\summary()->search_engines() ) ) {
				echo sprintf(
					'<li><icon class="dashicons dashicons-search"></icon> %s</li>',
					Classes\summary()->search_engines()
				);
			} ?>
		</ul>
	</section>

</div>
<?php

do_action( 'ds_default_widget_after' );
