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
	 * Post types query
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of queried post types.
	 */
	public function post_types() {

		// Post type query arguments.
		$query = [
			'public'   => true,
			'_builtin' => false
		];

		// Return post types according to above.
		$query = get_post_types( $query, 'object', 'and' );
		return apply_filters( 'ds_post_types_query', $query );
	}

	/**
	 * Taxonomies query
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of queried taxonomies.
	 */
	public function taxonomies() {

		// Taxonomy query arguments.
		$query = [
			'public'  => true,
			'show_ui' => true
		];

		// Return taxonomies according to above.
		$query = get_taxonomies( $query, 'object', 'and' );
		return apply_filters( 'ds_taxonomies_query', $query );
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
