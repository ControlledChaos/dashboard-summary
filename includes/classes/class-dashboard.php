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

		// Enqueue admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		// Print admin scripts to head.
		add_action( 'admin_print_scripts', [ $this, 'admin_print_scripts' ], 20 );

		// Print admin styles to head.
		add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );

		// "At a Glance" dashboard widget.
		add_action( 'dashboard_glance_items', [ $this, 'at_glance' ] );
		add_action( 'rightnow_end', [ $this, 'at_glance_end' ] );
	}

	/**
	 * At a Glance post types
	 *
	 * Queries post types to be displayed in the
	 * "At a Glance" dashboard widget.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of queried post types.
	 */
	public function at_glance_post_types() {

		// Post type query arguments.
		$query = [
			'public'   => true,
			'_builtin' => false
		];

		// Return post types according to above.
		return get_post_types( $query, 'object', 'and' );
	}

	/**
	 * At a Glance SVG colors
	 *
	 * Returns CSS hex codes for admin user schemes.
	 * These colors are used to fill base64/SVG background
	 * images with colors corresponding to current user's
	 * color scheme preference.
	 *
	 * @see assets/js/at-glance-svg.js
	 *
	 * @todo Conditional color schemes for the antibrand system.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $colors Array of CSS hex codes.
	 * @global integer $wp_version
	 * @return array Returns an array of color scheme CSS hex codes.
	 */
	function at_glance_svg( $colors = [] ) {

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
			if ( ! $color_scheme || 'fresh'== $color_scheme ){
				$colors = [ 'colors' =>
					[ 'link' => '#0073aa', 'hover' => '#00a0d2', 'focus' => '#00a0d2' ]
				];
			} else {
				$colors = [ 'colors' =>
					[ 'link' => '#0073aa', 'hover' => '#0096dd', 'focus' => '#0096dd' ]
				];
			}

		/**
		 * The Modern scheme in WordPress is the
		 * only one with unique link colors.
		 */
		} elseif ( 'modern' == $color_scheme ) {
			$colors = [ 'colors' =>
				[ 'link' => '#3858e9', 'hover' => '#183ad6', 'focus' => '#183ad6' ]
			];

		// All other default color schemes.
		} else {
			$colors = [ 'colors' =>
				[ 'link' => '#0073aa', 'hover' => '#006799', 'focus' => '#006799' ]
			];
		}

		// Apply a filter for custom color schemes.
		return apply_filters( 'scp_glance_svg', $colors );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_enqueue_scripts() {

		// Script to fill base64 background images with current link colors.
		wp_enqueue_script( 'scp-svg-painter', DS_URL . 'assets/js/at-glance-svg.min.js', [ 'jquery' ], '', true );
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
		echo '<script type="text/javascript">var _atGlanceSVG = ' . wp_json_encode( $this->at_glance_svg() ) . ";</script>\n";
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_print_styles() {

		/**
		 * At a Glance styles
		 *
		 * Needed to override the default CSS pseudoelement icon on
		 * custom post types and for post type icons that are
		 * base64/SVG or <img> element.
		 * Also, icons colored with current link color.
		 */

		// Get post types.
		$post_types = $this->at_glance_post_types();

		// Prepare styles each post type matching the query.
		$type_count = '';
		foreach ( $post_types as $post_type ) {
			$type_count .= sprintf(
				'#dashboard_right_now .post-count.%s a:before, #dashboard_right_now .post-count.%s span:before { display: none; }',
				$post_type->name . '-count',
				$post_type->name . '-count'
			);
		}

		// At a Glance icons style block.
		$glance  = '<!-- Begin At a Glance icon styles -->' . '<style>';
		$glance .= '#dashboard_right_now li a:before, #dashboard_right_now li span:before { color: currentColor; } ';
		$glance .= '.at-glance-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
		$glance .= '.at-glance-cpt-icons img { display: inline-block; max-width: 20px; } ';
		$glance .= $type_count;
		$glance .= '</style>' . '<!-- End At a Glance icon styles -->';

		echo $glance;
	}

	/**
	 * At a Glance
	 *
	 * Adds custom post types to "At a Glance" dashboard widget.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function at_glance() {

		// Get post types.
		$post_types = $this->at_glance_post_types();

		// Prepare an entry for each post type matching the query.
		foreach ( $post_types as $post_type ) {

			// Count the number of posts.
			$count = wp_count_posts( $post_type->name );

			// Get the number of published posts.
			$number = number_format_i18n( $count->publish );

			// Get the plural or single name based on the count.
			$name = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $count->publish ) );

			// If the icon is data:image/svg+xml.
			if ( 0 === strpos( $post_type->menu_icon, 'data:image/svg+xml;base64,' ) ) {
				$menu_icon = sprintf(
					'<span class="at-glance-cpt-icons" style="%s"></span>',
					esc_attr( 'background-image: url( "' . esc_html( $post_type->menu_icon ) . '" );' )
				);

			// If the icon is a Dashicon class.
			} elseif ( 0 === strpos( $post_type->menu_icon, 'dashicons-' ) ) {
				$menu_icon = '<icon class="dashicons ' . $post_type->menu_icon . '"></icon>';

			// If the icon is a URL.
			} elseif( 0 === strpos( $post_type->menu_icon, 'http' ) ) {
				$menu_icon = '<span class="at-glance-cpt-icons"><img src="' . esc_url( $post_type->menu_icon ) . '" /></span>';

			} else {
				$menu_icon = '<icon class="dashicons dashicons-admin-post dashicons-admin-' . $post_type->menu_icon . '"></icon>';
			}

			// Supply an edit link if the user can edit posts.
			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				printf(
					'<li class="post-count %s-count"><a href="edit.php?post_type=%s">%s %s %s</a></li>',
					$post_type->name,
					$post_type->name,
					$menu_icon,
					$number,
					$name
				);

			// Otherwise just the count and post type name.
			} else {
				printf(
					'<li class="post-count %s-count">%s %s %s</li>',
					$post_type->name,
					$menu_icon,
					$number,
					$name
				);

			}
		}
	}

	/**
	 * At a Glance end
	 *
	 * Adds content to the end of the
	 * "At a Glance" dashboard widget.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function at_glance_end() {

		// PHP version notice.
		echo sprintf(
			'<p>%s %s</p>',
			__( 'Your website is running PHP version', DS_DOMAIN ),
			phpversion()
		);
	}
}
