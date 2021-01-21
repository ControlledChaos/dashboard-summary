<?php
/**
 * At a Glance widget
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Widgets
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class At_A_Glance {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Remove the widget.
		add_action( 'wp_dashboard_setup', [ $this, 'remove_widget' ] );

		// Print admin styles to head.
		add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );

		// Add custom post types & taxonomies.
		add_action( 'dashboard_glance_items', [ $this, 'at_glance' ] );

		// Add PHP notice and/or other info.
		add_action( 'rightnow_end', [ $this, 'at_glance_end' ] );
	}

	/**
	 * Remove At a Glance widget
	 *
	 * @since  1.0.0
	 * @access public
	 * @global array wp_meta_boxes The metaboxes array holds all the widgets for wp-admin.
	 * @return void
	 */
	public function remove_widget() {

		global $wp_meta_boxes;

		if ( false == settings()->sanitize_glance() ) {
			unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		}
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
		$post_types = summary()->custom_types_query();

		// Prepare styles each post type matching the query.
		$type_count = '';
		foreach ( $post_types as $post_type ) {

			$type = get_post_type_object( $post_type );
			$type_count .= sprintf(
				'#dashboard_right_now .post-count.%s a:before, #dashboard_right_now .post-count.%s span:before { display: none; }',
				$type->name . '-count',
				$type->name . '-count'
			);
		}

		// Get taxonomies.
		$taxonomies = summary()->taxonomies_query();

		// Prepare styles each taxonomy matching the query.
		$tax_count = '';
		if ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$type_count .= sprintf(
					'#dashboard_right_now .post-count.%s a:before, #dashboard_right_now .post-count.%s span:before { display: none; }',
					$type->name . '-count',
					$type->name . '-count'
				);
			}
		}

		// At a Glance icons style block.
		$glance  = '<!-- Begin At a Glance icon styles -->' . '<style>';
		$glance .= '#dashboard_right_now li a:before, #dashboard_right_now li span:before { color: currentColor; } ';
		$glance .= '.at-glance-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
		$glance .= '.at-glance-cpt-icons img { display: inline-block; max-width: 20px; } ';
		$glance .= $type_count;
		$glance .= '#dashboard_right_now li.at-glance-taxonomy a:before, #dashboard_right_now li.at-glance-taxonomy > span:before { content: "\f318"; }';
		$glance .= '#dashboard_right_now li.at-glance-taxonomy.post_tag a:before, #dashboard_right_now li.at-glance-taxonomy.post_tag > span:before { content: "\f323"; }';
		$glance .= '#dashboard_right_now .post-count.attachment-count a::before, #dashboard_right_now .post-count.attachment-count span::before { display: none; }';
		$glance .= '</style>' . '<!-- End At a Glance icon styles -->';

		echo $glance;
	}

	/**
	 * At a Glance
	 *
	 * Adds custom post types to At a Glance dashboard widget.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function at_glance() {

		// Add attachment post type.
		$builtin = [ 'attachment' ];

		// Custom post types query.
		$query = summary()->custom_types_query();

		// Merge the post types.
		$post_types = array_merge( $builtin, $query );

		// Prepare an entry for each post type matching the query.
		foreach ( $post_types as $post_type ) {

			$type = get_post_type_object( $post_type );

			// Count the number of posts.
			$count = wp_count_posts( $type->name );

			// Get the number of published posts.
			$number = number_format_i18n( $count->publish );

			// Get the plural or single name based on the count.
			$name = _n( $type->labels->singular_name, $type->labels->name, intval( $count->publish ) );

			// If the icon is data:image/svg+xml.
			if ( 0 === strpos( $type->menu_icon, 'data:image/svg+xml;base64,' ) ) {
				$menu_icon = sprintf(
					'<span class="at-glance-cpt-icons" style="%s"></span>',
					esc_attr( 'background-image: url( "' . esc_html( $type->menu_icon ) . '" );' )
				);

			// If the icon is a Dashicon class.
			} elseif ( 0 === strpos( $type->menu_icon, 'dashicons-' ) ) {
				$menu_icon = '<icon class="dashicons ' . $type->menu_icon . '"></icon>';

			// If the icon is a URL.
			} elseif( 0 === strpos( $type->menu_icon, 'http' ) ) {
				$menu_icon = '<span class="at-glance-cpt-icons"><img src="' . esc_url( $type->menu_icon ) . '" /></span>';

			} else {
				$menu_icon = '<icon class="dashicons dashicons-admin-post dashicons-admin-' . $type->menu_icon . '"></icon>';
			}

			// Supply an edit link if the user can edit posts.
			if ( current_user_can( $type->cap->edit_posts ) ) {
				printf(
					'<li class="post-count %s-count"><a href="edit.php?post_type=%s">%s %s %s</a></li>',
					$type->name,
					$type->name,
					$menu_icon,
					$number,
					$name
				);

			// Otherwise just the count and post type name.
			} else {
				printf(
					'<li class="post-count %s-count">%s %s %s</li>',
					$type->name,
					$menu_icon,
					$number,
					$name
				);

			}
		}

		// Get taxonomies.
		$taxonomies = summary()->taxonomies_query();

		// Prepare an entry for each taxonomy matching the query.
		if ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {

				// Get the first supported post type in the array.
				if ( ! empty( $taxonomy->object_type ) ) {
					$types = $taxonomy->object_type[0];
				} else {
					$types = null;
				}

				// Set `post_type` URL parameter for menu highlighting.
				if ( $types && 'post' === $types ) {
					$type = '&post_type=post';
				} elseif ( $types ) {
					$type = '&post_type=' . $types;
				} else {
					$type = '';
				}

				// Print a list item for the taxonomy.
				echo sprintf(
					'<li class="at-glance-taxonomy %s"><a href="%s">%s %s</a></li>',
					$taxonomy->name,
					admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . $type ),
					wp_count_terms( [ $taxonomy->name ] ),
					$taxonomy->labels->name
				);
			}
		}
	}

	/**
	 * At a Glance end
	 *
	 * Adds content to the end of the
	 * At a Glance dashboard widget.
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
