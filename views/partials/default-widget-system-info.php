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
$heading_system = apply_filters(
	'ds_default_widget_heading_system',
	__( 'System Information', DS_DOMAIN )
);

// System section description.
$description_system = apply_filters(
	'ds_default_widget_description_system',
	sprintf(
		'<p class="description">%s <a href="%s">%s</a> %s</p>',
		__( 'Some technical details about the', DS_DOMAIN ),
		esc_url( get_site_url( get_current_blog_id() ) ),
		get_bloginfo( 'name' ),
		__( 'website.', DS_DOMAIN )
	)
);

?>
<h4><?php echo $heading_system; ?></h4>
<?php echo $description_system; ?>

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
