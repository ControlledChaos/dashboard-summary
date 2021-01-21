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

?>
<div id="ds-default-widget" class="ds-default-widget">
	<?php Classes\summary()->post_types_list(); ?>
</div>
