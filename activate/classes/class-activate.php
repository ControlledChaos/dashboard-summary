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
	 * Add & update options
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function options() {

		// Add options with default to look for when freshly installed.
		add_option( 'ds_enable_summary', 'new_install' );
		add_option( 'ds_enable_glance', 'new_install' );

		// Update options if the installation defaults are set.
		if ( 'new_install' == get_option( 'ds_enable_summary' ) ) {
			update_option( 'ds_enable_summary', 1 );
		}

		if ( 'new_install' == get_option( 'ds_enable_glance' ) ) {
			update_option( 'ds_enable_glance', 0 );
		}

		// Network options.
		if ( is_multisite() ) {
			add_network_option( get_current_network_id(), 'ds_enable_network_summary', 'new_install' );
			add_network_option( get_current_network_id(), 'ds_enable_network_right_now', 'new_install' );

			if ( 'new_install' == get_option( 'ds_enable_network_summary' ) ) {
				update_network_option( 'ds_enable_network_summary', 1 );
			}

			if ( 'new_install' == get_option( 'ds_enable_network_right_now' ) ) {
				update_network_option( 'ds_enable_network_right_now', 0 );
			}
		}
	}

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
