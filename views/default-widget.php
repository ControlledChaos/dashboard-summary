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

do_action( 'ds_default_widget_before' );

?>
<div id="ds-default-widget" class="ds-widget ds-default-widget">

	<section class="ds-widget-section">
		<h3><?php _e( 'Content Types', DS_DOMAIN ); ?></h3>
		<?php Classes\summary()->post_types_list(); ?>
	</section>

	<section class="ds-widget-section">
		<h3><?php _e( 'Content Organization', DS_DOMAIN ); ?></h3>
		<?php Classes\summary()->taxonomies_list(); ?>
	</section>

</div>
<?php

do_action( 'ds_default_widget_after' );
