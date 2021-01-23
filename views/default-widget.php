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

// System details heading.
$heading_system = apply_filters(
	'ds_default_widget_heading_types',
	__( 'System Details', DS_DOMAIN )
);

// Post types heading.
$heading_types = apply_filters(
	'ds_default_widget_heading_types',
	__( 'Content Types', DS_DOMAIN )
);

// Taxonomies heading.
$heading_taxes = apply_filters(
	'ds_default_widget_heading_taxes',
	__( 'Classification', DS_DOMAIN )
);

do_action( 'ds_default_widget_before' );

?>
<div id="ds-default-widget" class="ds-widget ds-default-widget">

	<section id="ds-default-widget-system-details" class="ds-widget-section">
		<h3><?php echo $heading_system; ?></h3>

		<ul>
			<li><?php echo Classes\summary()->php_version(); ?></li>
			<li><?php echo Classes\summary()->management_system(); ?></li>
		</ul>
	</section>

	<section id="ds-default-widget-content-types" class="ds-widget-section">
		<h3><?php echo $heading_types; ?></h3>
		<?php Classes\summary()->post_types_list(); ?>
	</section>

	<section id="ds-default-widget-content-taxes" class="ds-widget-section">
		<h3><?php echo $heading_taxes; ?></h3>
		<?php Classes\summary()->taxonomies_icons_list(); ?>
	</section>

</div>
<?php

do_action( 'ds_default_widget_after' );
