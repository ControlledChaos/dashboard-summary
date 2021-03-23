<?php
/**
 * Default widget: content tab
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

/**
 * Content section heading
 *
 * The HTML is included here because of the
 * screen-reader-text class, which may need
 * to be filtered out.
 */
$tab_heading = apply_filters(
	'ds_site_widget_content_heading',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Website Content', DS_DOMAIN )
	)
);

// Content section description.
$tab_description = apply_filters(
	'ds_site_widget_content_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Follow the links to manage website content.', DS_DOMAIN )
	)
);

// Post types section heading.
$types_heading = apply_filters(
	'ds_site_widget_types_heading',
	__( 'Content Types', DS_DOMAIN )
);

// Post types description.
$types_description = apply_filters(
	'ds_site_widget_types_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This website contains the following post and content types.', DS_DOMAIN )
	)
);

// Taxonomies section heading.
$taxes_heading = apply_filters(
	'ds_site_widget_taxes_heading',
	__( 'Content Classification', DS_DOMAIN )
);

// Taxonomies description.
$taxes_description = apply_filters(
	'ds_site_widget_taxes_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This website&#8217;s content is organized by the following taxonomies.', DS_DOMAIN )
	)
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_site_widget_content_tools_heading',
	__( 'Content Tools', DS_DOMAIN )
);

// Tools description.
$tools_description = apply_filters(
	'ds_site_widget_content_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Import and export content for this website.', DS_DOMAIN )
	)
);

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-content-types">
	<h4><?php echo $types_heading; ?></h4>
	<?php echo $types_description; ?>

	<?php $summary->post_types_list(); ?>
</div>

<div class="ds-widget-divided-section ds-widget-content-taxes">
	<h4><?php echo $taxes_heading; ?></h4>
	<?php echo $taxes_description; ?>

	<?php $summary->taxonomies_icons_list(); ?>
</div>

<div class="ds-widget-divided-section ds-widget-content-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<p class="ds-widget-link-button">
		<?php if ( current_user_can( 'import' ) ) : ?>
		<a class="button button-primary" href="<?php echo self_admin_url( 'import.php' ); ?>">
			<?php _e( 'Import', DS_DOMAIN ); ?>
		</a>
		<?php endif; ?>
		<?php if ( current_user_can( 'export' ) ) : ?>
		<a class="button button-primary" href="<?php echo self_admin_url( 'export.php' ); ?>">
			<?php _e( 'Export', DS_DOMAIN ); ?>
		</a>
		<?php endif; ?>
	</p>
</div>

<?php

// Development hook.
do_action( 'ds_site_widget_content_tab' );
