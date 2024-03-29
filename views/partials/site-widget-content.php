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
use Dashboard_Summary\Classes as Classes,
	Dashboard_Summary\Core    as Core;

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
		__( 'Website Content', 'dashboard-summary' )
	)
);

// Content section description.
$tab_description = apply_filters(
	'ds_site_widget_content_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'An overview of the content of this site.', 'dashboard-summary' )
	)
);

// Post types section heading.
$types_heading = apply_filters(
	'ds_site_widget_types_heading',
	__( 'Content Types', 'dashboard-summary' )
);

// Post types description.
$types_description = apply_filters(
	'ds_site_widget_types_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This website contains the following post and content types.', 'dashboard-summary' )
	)
);

// Taxonomies section heading.
$taxes_heading = apply_filters(
	'ds_site_widget_taxes_heading',
	__( 'Content Classification', 'dashboard-summary' )
);

// Taxonomies description.
$taxes_description = apply_filters(
	'ds_site_widget_taxes_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'This website&#8217;s content is organized by the following taxonomies.', 'dashboard-summary' )
	)
);

// Tools section heading.
$tools_heading = apply_filters(
	'ds_site_widget_content_tools_heading',
	__( 'Content Tools', 'dashboard-summary' )
);

// Tools description.
$tools_description = apply_filters(
	'ds_site_widget_content_tools_description',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Search, import, and export content of this website, if allowed.', 'dashboard-summary' )
	)
);

?>
<?php echo $tab_heading; ?>
<?php echo $tab_description; ?>

<div class="ds-widget-divided-section ds-widget-content-types">
	<h4><?php echo $types_heading; ?></h4>
	<?php echo $types_description; ?>

	<?php Core\post_types_list(); ?>
</div>

<div class="ds-widget-divided-section ds-widget-content-taxes">
	<h4><?php echo $taxes_heading; ?></h4>
	<?php echo $taxes_description; ?>

	<?php Core\taxonomies_list(); ?>
</div>

<div class="ds-widget-divided-section ds-widget-content-links">

	<h4><?php echo $tools_heading; ?></h4>
	<?php echo $tools_description; ?>

	<form role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" target="_blank" rel="nofollow noreferrer noopener">
		<?php $content_id = 'site-' . get_current_blog_id() . '-dashboard-search-content'; ?>
		<p class="ds-widget-search-fields">
			<label class="screen-reader-text" for="<?php echo $content_id; ?>" aria-label="<?php _e( 'Search Content', 'dashboard-summary' ); ?>"><?php _e( 'Search Content', 'dashboard-summary' ); ?></label>

			<input type="search" name="s" id="<?php echo $content_id; ?>" aria-labelledby="<?php _e( 'Search Content', 'dashboard-summary' ); ?>" value="<?php echo get_search_query(); ?>" autocomplete="off" placeholder="<?php _e( 'Enter title or content search terms', 'dashboard-summary' ); ?>" aria-placeholder="<?php _e( 'Enter content search terms', 'dashboard-summary' ); ?>" />
			<?php submit_button( __( 'Search Content', 'dashboard-summary' ), '', false, false, [ 'id' => 'submit-' . $content_id ] ); ?>
		</p>
	</form>

	<?php if ( current_user_can( 'upload_files' ) ) : ?>
	<form role="search" action="<?php echo self_admin_url( 'upload.php' ); ?>" method="get">
		<?php $media_id = 'site-' . get_current_blog_id() . '-dashboard-search-media'; ?>
		<p class="ds-widget-search-fields">
			<label class="screen-reader-text" for="<?php echo $media_id; ?>" aria-label="<?php _e( 'Search Media', 'dashboard-summary' ); ?>"><?php _e( 'Search Media', 'dashboard-summary' ); ?></label>

			<input type="search" name="search" id="<?php echo $media_id; ?>" aria-labelledby="<?php _e( 'Search Media', 'dashboard-summary' ); ?>" value="<?php echo get_search_query(); ?>" autocomplete="off" placeholder="<?php _e( 'Enter media title, meta, or filename', 'dashboard-summary' ); ?>" aria-placeholder="<?php _e( 'Enter media title or filename', 'dashboard-summary' ); ?>" />
			<?php submit_button( __( 'Search Media', 'dashboard-summary' ), '', false, false, [ 'id' => 'submit-' . $media_id ] ); ?>
		</p>
	</form>
	<?php endif; ?>

	<p class="ds-widget-link-button">
		<?php if ( current_user_can( 'import' ) ) : ?>
		<a class="button button-primary" href="<?php echo self_admin_url( 'import.php' ); ?>">
			<?php _e( 'Import', 'dashboard-summary' ); ?>
		</a>
		<?php endif; ?>
		<?php if ( current_user_can( 'export' ) ) : ?>
		<a class="button button-primary" href="<?php echo self_admin_url( 'export.php' ); ?>">
			<?php _e( 'Export', 'dashboard-summary' ); ?>
		</a>
		<?php endif; ?>
	</p>
</div>

<?php

// Development hook.
do_action( 'ds_site_widget_content_tab' );
