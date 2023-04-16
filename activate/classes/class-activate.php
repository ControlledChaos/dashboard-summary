<?php
/**
 * Plugin activation class
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Activate
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes\Activate;

// Alias namespaces.
use Dashboard_Summary\Classes as Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Activate {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {}

	/**
	 * Get plugin row notice
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function get_row_notice() {

		// Add notice if the PHP version is insufficient.
		if ( ! Classes\php()->version() ) {
			add_action( 'after_plugin_row_' . DS_BASENAME, [ $this, 'row_notice' ], 5, 3 );
		}
	}

	/**
	 * Plugin row notice
	 *
	 * Provides a PHP deactivation notice below the content
	 * of the plugin row.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup of the plugin row notice.
	 */
	public function row_notice( $plugin_file, $plugin_data, $status ) {

		// Column span of the table data cell.
		$colspan = 4;

		// Column span if WordPress version is less than 5.5 or ClassicPress.
		if ( version_compare( $GLOBALS['wp_version'], '5.5', '<' ) ) {
			$colspan = 3;
		}

		?>
		<style>
			.plugins tr[data-plugin='<?php echo DS_BASENAME; ?>'] th,
			.plugins tr[data-plugin='<?php echo DS_BASENAME; ?>'] td {
				box-shadow: none;
			}

			<?php if ( isset( $plugin_data['update'] ) && ! empty( $plugin_data['update'] ) ) : ?>

				.plugins tr.<?php echo 'dashboard-summary'; ?>-plugin-tr td {
					box-shadow: none ! important;
				}

				.plugins tr.<?php echo 'dashboard-summary'; ?>-plugin-tr .update-message {
					margin-bottom: 0;
				}

			<?php endif; ?>
		</style>

		<tr id="plugin-php-notice" class="plugin-update-tr active <?php echo 'dashboard-summary'; ?>-plugin-tr">
			<td colspan="<?php echo $colspan; ?>" class="plugin-update colspanchange">
				<div class="update-message notice inline notice-error notice-alt">
					<?php echo sprintf(
						'<p>%s %s %s %s</p>',
						__( 'Functionality of this plugin has been disabled because it requires PHP version', 'dashboard-summary' ),
						Classes\php()->minimum(),
						__( 'or greater. Your system is running PHP version', 'dashboard-summary' ),
						phpversion()
					); ?>
				</div>
			</td>
		</tr>
		<?php
	}
}
