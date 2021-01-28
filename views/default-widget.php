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

// Users section heading.
$heading_users = apply_filters(
	'ds_default_widget_heading_users',
	__( 'Users & Discussion', DS_DOMAIN )
);

// Updates section heading.
$heading_updates = apply_filters(
	'ds_default_widget_heading_updates',
	__( 'System Updates', DS_DOMAIN )
);

// System section heading.
$heading_system = apply_filters(
	'ds_default_widget_heading_system',
	__( 'System Information', DS_DOMAIN )
);

// Content section description.
$description_content = apply_filters(
	'ds_default_widget_description_content',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Follow the links to manage website content.', DS_DOMAIN )
	)
);

// Post types description.
$description_types = apply_filters(
	'ds_default_widget_description_types',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This website contains the following post and content types.', DS_DOMAIN )
	)
);

// Taxonomies description.
$description_taxes = apply_filters(
	'ds_default_widget_description_taxes',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This website\'s content is organized by the following taxonomies.', DS_DOMAIN )
	)
);

// Users section description.
$description_users = apply_filters(
	'ds_default_widget_description_users',
	''
);

// Updates section description.
$description_updates = apply_filters(
	'ds_default_widget_description_updates',
	''
);

// System section description.
$description_system = apply_filters(
	'ds_default_widget_description_system',
	sprintf(
		'<p class="description">%s <a href="%s">%s</a> %s</p>',
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
		<li class="ds-tabs-state-active"><a href="#ds-default-widget-content"><?php _e( 'Content', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-users-discussion"><?php _e( 'Users', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-updates"><?php _e( 'Updates', DS_DOMAIN ); ?></a></li>
		<li><a href="#ds-default-widget-system-info"><?php _e( 'System', DS_DOMAIN ); ?></a></li>
	</ul>

	<section id="ds-default-widget-content" class="ds-widget-section ds-tabs-panel ds-tabs-state-active">

		<h3 class="screen-reader-text"><?php _e( 'Website Content', DS_DOMAIN ); ?></h3>

		<?php echo $description_content; ?>

		<h4><?php echo $heading_types; ?></h4>
		<?php echo $description_types; ?>

		<?php $summary->post_types_list(); ?>

		<h4><?php echo $heading_taxes; ?></h4>
		<?php echo $description_taxes; ?>

		<?php $summary->taxonomies_icons_list(); ?>
	</section>

	<section id="ds-default-widget-users-discussion" class="ds-widget-section ds-tabs-panel">

		<h3 class="screen-reader-text"><?php _e( '', DS_DOMAIN ); ?></h3>

		<?php echo $description_users; ?>

		<h4><?php echo $heading_users; ?></h4>

	</section>

	<section id="ds-default-widget-updates" class="ds-widget-section ds-tabs-panel">

		<h3 class="screen-reader-text"><?php echo $heading_updates; ?></h3>

		<?php echo $description_updates; ?>

		<h4><?php _e( 'Plugins', DS_DOMAIN ); ?></h4>
		<p><?php echo $summary->update_plugins(); ?></p>

		<h4><?php _e( 'Themes', DS_DOMAIN ); ?></h4>
		<p><?php echo $summary->update_themes(); ?></p>

	</section>

	<section id="ds-default-widget-system-info" class="ds-widget-section ds-tabs-panel">

		<h4><?php echo $heading_system; ?></h4>
		<?php echo $description_system; ?>

		<ul class="ds-widget-system-list">
			<li><icon class="ds-cpt-icons dashicons dashicons-editor-code"></icon> <?php echo $summary->php_version(); ?></li>
			<li><icon class="ds-cpt-icons dashicons dashicons-dashboard"></icon> <?php echo $summary->management_system(); ?></li>
			<li><icon class="ds-cpt-icons dashicons dashicons-admin-appearance"></icon> <?php echo $summary->active_theme(); ?></li>
			<?php
			if ( ! empty( $summary->search_engines() ) ) {
				echo sprintf(
					'<li><icon class="ds-cpt-icons dashicons dashicons-search"></icon> %s</li>',
					$summary->search_engines()
				);
			} ?>
		</ul>
	</section>

</div>
<?php

do_action( 'ds_default_widget_after' );
