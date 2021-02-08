<?php
/**
 * Default widget: profile tab
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
$heading = apply_filters(
	'ds_default_widget_heading_profile',
	__( 'Your Profile', DS_DOMAIN )
);

// System section description.
$description = apply_filters(
	'ds_default_widget_description_profile',
	sprintf(
		'<p class="description">%s</p>',
		__( 'Following are details about your account.', DS_DOMAIN )
	)
);

?>
<h4><?php echo $heading; ?></h4>
<?php echo $description; ?>
