<?php
/**
 * Network setting: enable network summary
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

<h2><?php _e( 'Dashboard Options', DS_DOMAIN ); ?></h2>

<table id="network-dashboard-options" class="form-table" role="presentation">
	<tbody>
		<tr>
			<th scope="row"><?php _e( DS_NETWORK_WIDGET_TITLE, DS_DOMAIN ); ?></th>
			<td>
				<label for="ds_enable_network_summary">
					<input type="hidden" name="ds_enable_network_summary" value="0">
					<input type="checkbox" id="ds_enable_network_summary" name="ds_enable_network_summary" value="1" <?php echo checked( 1, $summary, false ); ?> />
					<?php printf(
						'%s %s %s',
						__( 'Enable the', DS_DOMAIN ),
						DS_NETWORK_WIDGET_TITLE,
						__( 'widget.', DS_DOMAIN )
					); ?>
				</label>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php _e( 'Right Now', DS_DOMAIN ); ?></th>
			<td>
				<label for="ds_enable_network_right_now">
					<input type="hidden" name="ds_enable_network_right_now" value="0">
					<input type="checkbox" id="ds_enable_network_right_now" name="ds_enable_network_right_now" value="1" <?php echo checked( 1, $right_now, false ); ?> />
					<?php _e( 'Enable the Right Now widget.', DS_DOMAIN ); ?>
				</label>
			</td>
		</tr>
	</tbody>
</table>
