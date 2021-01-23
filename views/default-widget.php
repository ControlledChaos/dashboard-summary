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

	<section class="ds-widget-section">
		<h3><?php echo $heading_types; ?></h3>
		<?php Classes\summary()->post_types_list(); ?>
	</section>

	<section class="ds-widget-section">
		<h3><?php echo $heading_taxes; ?></h3>
		<?php Classes\summary()->taxonomies_icons_list(); ?>
	</section>

</div>
<?php

do_action( 'ds_default_widget_after' );
