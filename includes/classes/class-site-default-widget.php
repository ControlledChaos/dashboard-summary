<?php
/**
 * Site default widget
 *
 * The "At a Glance" widget, formerly "Right Now",
 * is the default WordPress & ClassicPress summary
 * widget on site dashboards, not network dashboards.
 *
 * Methods in this class add custom post types with
 * icons, taxonomies with icons, and a system summary
 * to the default widget content.
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

class Site_Default_Widget {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// If the At a Glance widget setting is false/unchecked.
		if ( false == settings()->sanitize_glance() ) {

			// Remove At a Glance widget.
			add_action( 'wp_dashboard_setup', [ $this, 'remove_widget' ] );
		}

		// If the At a Glance widget setting is true/checked.
		if ( true == settings()->sanitize_glance() ) {

			// Print admin scripts to head.
			add_action( 'admin_print_scripts', [ $this, 'print_scripts' ], 20 );

			// Enqueue assets.
			add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );

			// Print admin styles to head.
			add_action( 'admin_print_styles', [ $this, 'admin_print_styles' ], 20 );

			// Add custom post types & taxonomies.
			add_action( 'dashboard_glance_items', [ $this, 'at_glance' ] );

			// System information section.
			add_filter( 'update_right_now_text', [ $this, 'system_info' ], 10, 1 );
		}
	}

	/**
	 * Remove At a Glance widget
	 *
	 * Removes the widget by default and if the setting
	 * is not set to tru (checkbox checked).
	 *
	 * @since  1.0.0
	 * @access public
	 * @global array wp_meta_boxes The metaboxes array holds all the widgets for wp-admin.
	 * @return void
	 */
	public function remove_widget() {

		// Access metaboxes.
		global $wp_meta_boxes;

		// Unset the At a Glance widget.
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	}

	/**
	 * Print admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function print_scripts() {

		// Remove the unused <p id="wp-version-message">.
		echo '<script>jQuery( document ).ready( function($) { $( "#dashboard_right_now #wp-version-message" ).remove(); });</script>';
	}

	/**
	 * Enqueue assets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function assets() {

		// Instantiate the Assets class.
		$assets = new Assets;

		// Widget styles.
		wp_enqueue_style( 'ds-at-a-glance', DS_URL . 'assets/css/at-a-glance' . $assets->suffix() . '.css', [], $assets->version(), 'all' );
	}

	/**
	 * Print admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $style Default empty string.
	 * @return string Returns the style blocks.
	 */
	public function admin_print_styles( $style = '' ) {

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

		// Prepare styles for each post type matching the query.
		$type_count = '';
		foreach ( $post_types as $post_type ) {

			$type = get_post_type_object( $post_type );
			$type_count .= sprintf(
				'#dashboard_right_now .post-count.%s a:before, #dashboard_right_now .post-count.%s span:before { display: none; }',
				$type->name . '-count',
				$type->name . '-count'
			);
		}

		// At a Glance widget style block.
		$style  = '<!-- Begin At a Glance widget styles -->' . '<style>';
		$style .= '#dashboard_right_now li a:before, #dashboard_right_now li span:before { color: currentColor; } ';
		$style .= '.at-glance-cpt-icons { display: inline-block; width: 20px; height: 20px; vertical-align: middle; background-repeat: no-repeat; background-position: center; background-size: 20px auto; } ';
		$style .= '.at-glance-cpt-icons img { display: inline-block; max-width: 20px; } ';
		$style .= $type_count;
		$style .= '#dashboard_right_now li.at-glance-taxonomy a:before, #dashboard_right_now li.at-glance-taxonomy > span:before { display: none; }';
		$style .= '#dashboard_right_now .post-count.attachment-count a::before, #dashboard_right_now .post-count.attachment-count span::before { display: none; }';
		$style .= '#dashboard_right_now li.at-glance-user-count a:before, #dashboard_right_now li.at-glance-user-count span:before { content: "\f110"; }';
		$style .= '#dashboard_right_now li.at-glance-users-count a:before, #dashboard_right_now li.at-glance-users-count span:before { content: "\f307"; }';
		$style .= '#dashboard_right_now .ds-widget-divided-section { margin-top: 1em; padding-top: 0.5em; border-top: solid 1px #ccd0d4; }';
		$style .= '#dashboard_right_now #wp-version-message { display: none; }';
		$style .= '#dashboard-widgets #dashboard_right_now .ds-widget-divided-section h4 { margin: 0.75em 0 0; font-size: 1em; font-weight: bold; font-weight: 600; }';
		$style .= '#dashboard-widgets #dashboard_right_now .ds-widget-divided-section p.description { margin: 0.75em 0 0; font-style: italic; line-height: 1.3; }';
		$style .= '#dashboard-widgets #dashboard_right_now .ds-widget-divided-section a { text-decoration: none; }';
		$style .= '#dashboard_right_now ul.ds-widget-system-list { display: block; margin: 0.75em 0 0; }';
		$style .= '#dashboard_right_now .ds-widget-system-list li { margin: 0.325em 0 0; }';
		$style .= '#dashboard_right_now .ds-widget-system-list li a:before { display: none; }';
		$style .= '#dashboard_right_now .main p.ds-widget-link-button { margin-top: 1.5em; }';
		$style .= '</style>' . '<!-- End At a Glance widget styles -->';

		// Apply filter and print the style block.
		echo apply_filters( 'ds_website_default_print_styles', $style );
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

		// Development hook.
		do_action( 'ds_glance_items_one' );

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
			$get_count = wp_count_posts( $type->name );
			if ( 'attachment' == $post_type ) {
				$count = $get_count->inherit;
			} else {
				$count = $get_count->publish;
			}

			// Get the number of published posts.
			$number = number_format_i18n( $count );

			// Get the plural or single name based on the count.
			$name = _n( $type->labels->singular_name, $type->labels->name, intval( $count ) );

			// If the icon is data:image/svg+xml.
			if ( 0 === strpos( $type->menu_icon, 'data:image/svg+xml;base64,' ) ) {
				$menu_icon = sprintf(
					'<icon class="at-glance-cpt-icons" style="%s"></icon>',
					esc_attr( 'background-image: url( "' . esc_html( $type->menu_icon ) . '" );' )
				);

			// If the icon is a Dashicon class.
			} elseif ( 0 === strpos( $type->menu_icon, 'dashicons-' ) ) {
				$menu_icon = '<icon class="dashicons ' . $type->menu_icon . '"></icon>';

			// If the icon is a URL.
			} elseif( 0 === strpos( $type->menu_icon, 'http' ) ) {
				$menu_icon = '<icon class="at-glance-cpt-icons"><img src="' . esc_url( $type->menu_icon ) . '" /></icon>';

			// Fall back to the default post icon.
			} else {
				$menu_icon = '<icon class="dashicons dashicons-admin-post dashicons-admin-' . $type->menu_icon . '"></icon>';
			}

			// Supply an edit link if media & the user can access the media library.
			if ( 'attachment' === $post_type && current_user_can( 'upload_files' ) ) {
				printf(
					'<li class="post-count %s-count"><a href="edit.php?post_type=%s">%s %s %s</a></li>',
					$type->name,
					$type->name,
					$menu_icon,
					$number,
					$name
				);

			// Supply an edit link if not media & the user can edit posts.
			} elseif ( 'attachment' != $post_type && current_user_can( $type->cap->edit_posts ) ) {
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

		// Development hook.
		do_action( 'ds_glance_items_two' );

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

				// Count the terms in the taxonomy.
				$count = wp_count_terms( $taxonomy->name );

				// Get the plural or singular name based on the count.
				$name = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, intval( $count ) );

				// Conditional icon markup.
				if ( 'post_tag' == $taxonomy->name ) {
					$icon = sprintf(
						'<icon class="dashicons dashicons-tag ds-icon-%s"></icon>',
						$taxonomy->name
					);
				} else {
					$icon = sprintf(
						'<icon class="dashicons dashicons-category ds-icon-%s"></icon>',
						$taxonomy->name
					);
				}

				// Supply an edit link if the user can edit the taxonomy.
				$edit = get_taxonomy( $taxonomy->name );
				if ( current_user_can( $edit->cap->edit_terms ) ) {

					// Print a list item for the taxonomy.
					printf(
						'<li class="at-glance-taxonomy %s"><a href="%s">%s %s %s</a></li>',
						$taxonomy->name,
						esc_url( admin_url( 'edit-tags.php?taxonomy=' . $taxonomy->name . $type ) ),
						$icon,
						$count,
						$name
					);

				// List item without link.
				} else {

					// Print a list item for the taxonomy.
					printf(
						'<li class="at-glance-taxonomy %s">%s %s %s</li>',
						$taxonomy->name,
						$icon,
						$count,
						$name
					);
				}
			}
		}

		// Development hook.
		do_action( 'ds_glance_items_three' );

		// Show total users if the current user can manage users.
		if ( current_user_can( 'manage_users' ) ) {

			// Count the registered users.
			$users_count = number_format_i18n( summary()->total_users() );

			/**
			 * List item class based on the count.
			 * Used to display single person icon for one user or
			 * group icon for multiple users.
			 */
			if ( 1 == summary()->total_users() ) {
				$users_class = 'at-glance-user-count';
			} else {
				$users_class = 'at-glance-users-count';
			}

			// Plural or single text based on the count.
			$users = _n( 'User', 'Users', intval( $users_count ), 'dashboard-summary' );

			// User list item.
			printf(
				'<li class="%s"><a href="%s">%s %s</a></li>',
				$users_class,
				self_admin_url( 'users.php' ),
				summary()->total_users(),
				$users
			);
		}

		// Development hook.
		do_action( 'ds_glance_items_four' );
	}

	/**
	 * System information
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the markup of the system information.
	 */
	public function system_info( $content ) {

		// Instance of the Summary class.
		$summary = summary();

		// This content is for a native widget.
		$native_widget = true;

		// Get the system information content.
		include( DS_PATH . '/views/partials/widget-system-info.php' );
	}
}
