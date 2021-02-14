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
$heading_content = apply_filters(
	'ds_default_widget_heading_content',
	sprintf(
		'<h3 class="screen-reader-text">%s</h3>',
		__( 'Website Content', DS_DOMAIN )
	)
);

// Content section description.
$description_content = apply_filters(
	'ds_default_widget_description_content',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Follow the links to manage website content.', DS_DOMAIN )
	)
);

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

?>
<?php echo $heading_content; ?>
<?php echo $description_content; ?>

<div class="ds-widget-divided-section ds-widget-content-section">
	<h4><?php echo $heading_types; ?></h4>
	<?php echo $description_types; ?>

	<?php $summary->post_types_list(); ?>
</div>

<div class="ds-widget-divided-section ds-widget-content-section">
	<h4><?php echo $heading_taxes; ?></h4>
	<?php echo $description_taxes; ?>

	<?php $summary->taxonomies_icons_list(); ?>
</div>


<p class="ds-wdget-link-button">
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

<?php

// Development hook.
do_action( 'ds_content_tab' );

