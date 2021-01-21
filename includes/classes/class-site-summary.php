<?php
/**
 * Site summary
 *
 * @package    Dashboard_Summary
 * @subpackage Classes
 * @category   Content
 * @since      1.0.0
 */

namespace Dashboard_Summary\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Site_Summary {

	/**
	 * Instance of the class
	 *
	 * This method can be used to call an instance
	 * of the class from outside the class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns an instance of the class.
	 */
	public static function instance() {
		return new self;
	}

	/**
	 * Custom post types query
	 *
	 * The custom post types are here as a separate query
	 * for use in the At a Glance widget in which the default,
	 * built-in post types already exists and custom post types
	 * are added by filter.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of queried post types.
	 */
	public function custom_types_query() {

		// Post type query arguments.
		$query = [
			'public'   => true,
			'_builtin' => false
		];

		// Return post types according to above.
		$query = get_post_types( $query, 'names', 'and' );
		return apply_filters( 'ds_custom_types_query', $query );
	}

	/**
	 * Public post types
	 *
	 * Merges built-in post types and custom post types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of all public post types.
	 */
	public function public_post_types() {

		// Built-in post types.
		$builtin = [ 'post', 'page' ];

		// Custom post types query.
		$query = $this->custom_types_query();

		// Merge the post types.
		$types = array_merge( $builtin, $query );

		// Return the public post types.
		return apply_filters( 'ds_public_post_types', $types );
	}

	/**
	 * Taxonomies query
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of queried taxonomies.
	 */
	public function taxonomies_query() {

		// Taxonomy query arguments.
		$query = [
			'public'  => true,
			'show_ui' => true
		];

		// Return taxonomies according to above.
		$query = get_taxonomies( $query, 'object', 'and' );
		return apply_filters( 'ds_taxonomies_query', $query );
	}

	/**
	 * Post types list
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed Returns unordered list markup.
	 */
	public function post_types_list() {

		// Get all public post types.
		$post_types = $this->public_post_types();

		echo '<ul>';
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
					'<icon class="at-glance-cpt-icons" style="%s"></icon>',
					esc_attr( 'background-image: url( "' . esc_html( $type->menu_icon ) . '" );' )
				);

			// If the icon is a Dashicon class.
			} elseif ( 0 === strpos( $type->menu_icon, 'dashicons-' ) ) {
				$menu_icon = '<icon class="dashicons ' . $type->menu_icon . '"></icon>';

			// If the icon is a URL.
			} elseif( 0 === strpos( $type->menu_icon, 'http' ) ) {
				$menu_icon = '<icon class="at-glance-cpt-icons"><img src="' . esc_url( $type->menu_icon ) . '" /></icon>';

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
		echo '</ul>';
	}
}

/**
 * Instance of the class
 *
 * @since  1.0.0
 * @access public
 * @return object Site_Summary Returns an instance of the class.
 */
function summary() {
	return Site_Summary :: instance();
}