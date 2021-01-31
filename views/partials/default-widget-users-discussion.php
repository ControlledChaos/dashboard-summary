<?php
/**
 * Default widget: users tab
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

// Users section heading.
$heading_users = apply_filters(
	'ds_default_widget_heading_users',
	__( 'Users & Discussion', DS_DOMAIN )
);

// Users section description.
$description_users = apply_filters(
	'ds_default_widget_description_users',
	''
);

?>
<h3 class="screen-reader-text"><?php _e( '', DS_DOMAIN ); ?></h3>

<?php echo $description_users; ?>

<h4><?php echo $heading_users; ?></h4>
