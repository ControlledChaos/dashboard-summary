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
				<fieldset>
					<legend class="screen-reader-text">
						<?php _e( 'Network Dashboard Widgets', DS_DOMAIN ); ?>
					</legend>
					<label for="ds_enable_network_summary">
						<input type="hidden" name="ds_enable_network_summary" value="0">
						<input type="checkbox" id="ds_enable_network_summary" name="ds_enable_network_summary" value="1" <?php echo checked( 1, $option, false ); ?> />
						<?php printf(
							'%s %s %s',
							__( 'Enable the', DS_DOMAIN ),
							DS_NETWORK_WIDGET_TITLE,
							__( 'widget.', DS_DOMAIN )
						); ?>
					</label>
				</fieldset>
			</td>
		</tr>
	</tbody>
</table>
