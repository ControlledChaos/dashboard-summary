<?php
/**
 * Dashboard class
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Admin
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Dashboard {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		new Summary_Widget;
		new At_A_Glance;

		// Enqueue admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		// Print admin scripts to head.
		add_action( 'admin_print_scripts', [ $this, 'admin_print_scripts' ], 20 );
	}

	/**
	 * User colors
	 *
	 * Returns CSS hex codes for admin user schemes.
	 * These colors are used to fill base64/SVG background
	 * images with colors corresponding to current user's
	 * color scheme preference. Also used rendering the
	 * tab effect by applying the color scheme background
	 * color to the bottom border of the active tab.
	 *
	 * @see assets/js/svg-icon-colors.js
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $colors Array of CSS hex codes.
	 * @global integer $wp_version
	 * @return array Returns an array of color scheme CSS hex codes.
	 */
	function user_colors( $colors = [] ) {

		// Get WordPress version.
		global $wp_version;

		// Get the user color scheme option.
		$color_scheme = get_user_option( 'admin_color' );

		/**
		 * Older color schemes for ClassicPress and
		 * older WordPress versions.
		 */
		if (
			function_exists( 'classicpress_version' ) ||
			( ! function_exists( 'classicpress_version' ) && version_compare( $wp_version,'4.9.9' ) <= 0 )
		) {

			/**
			 * The Fresh (default) scheme in older WordPress & in ClassicPress
			 * has a link hover/focus color different than the others.
			 */
			if ( ! $color_scheme || 'fresh'== $color_scheme ) {
				$colors = [ 'colors' =>
					[ 'background' => '#f1f1f1', 'link' => '#0073aa', 'hover' => '#00a0d2', 'focus' => '#00a0d2' ]
				];
			} else {
				$colors = [ 'colors' =>
					[ 'background' => '#f1f1f1', 'link' => '#0073aa', 'hover' => '#0096dd', 'focus' => '#0096dd' ]
				];
			}

		/**
		 * The Modern scheme in WordPress is the
		 * only one other than the default (Fresh)
		 * with unique link colors.
		 */
		} elseif ( 'modern' == $color_scheme ) {
			$colors = [ 'colors' =>
				[ 'background' => '#f1f1f1', 'link' => '#3858e9', 'hover' => '#183ad6', 'focus' => '#183ad6' ]
			];

		// All other default color schemes.
		} else {
			$colors = [ 'colors' =>
				[ 'background' => '#f1f1f1', 'link' => '#0073aa', 'hover' => '#006799', 'focus' => '#006799' ]
			];
		}

		// Apply a filter for custom color schemes.
		return apply_filters( 'ds_user_colors', $colors );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_enqueue_scripts() {

		// Instantiate the Assets class.
		$assets = new Assets;

		// Script to fill base64 background images with current link colors.
		wp_enqueue_script( 'svg-icon-colors', DS_URL . 'assets/js/svg-icon-colors' . $assets->suffix() . '.js', [ 'jquery' ], $assets->version(), true );
	}

	/**
	 * Print admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_print_scripts() {

		// Script to fill base64 background images with current link colors.
		echo '<script type="text/javascript">var _atGlanceSVG = ' . wp_json_encode( $this->user_colors() ) . ";</script>\n";
	}
}
